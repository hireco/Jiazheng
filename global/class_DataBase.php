<?php
/*
数据库功能
========
需要的其它类：无，可单独使用
========
特色:主要对update和insert这两个不方便使用的sql语句进行扩展
========
主要功能说明:

引用:$db = new DataBase;
connect:对数据库进行连接
	eg: $mysql = $db->connect("localhost","root","password","table");
query:发送一个query
	eg: $query = $db->query("select * from `table` where `id`=1");
insert:添加记录
	eg: $db->insert("table",array(
			'id' => $id,
			'user' => $user
			));
update:更新记录
	eg: $db->update("table",array(
			'id' => $id,
			'user' => $user
			),
			"id=1");
==============
Author:Coldney
Web:http://www.coldpage.com
E-Mail:coldney@gmail.com
请保留以上信息
*/
error_reporting(7);
define ('SUPPORT','coldney@gmail.com');//技术支持邮箱

class DataBase
{
	var $querycount;
	function connect($servername, $dbusername, $dbpassword, $dbname, $usepconnect=0)
	{
		if($usepconnect)
		{
			if(!@mysql_pconnect($servername, $dbusername, $dbpassword))
				$this->halt("数据库链接失败");
		}
		else
		{
			if(!@mysql_connect($servername, $dbusername, $dbpassword)) 
				$this->halt("数据库链接失败");
		}
		if(!@mysql_select_db($dbname)) 
			$this->halt("数据库选择失败");
	}
	function insert($table,$array)
	{
		$colums = ""; $values = ""; $comma="";
		if (is_array($array))
		{
			while (list($c,$v) = each ($array))
			{
				$columns .= $comma."`".$c."`";
				$values .= $comma."'".$this->checkPost($v)."'";
				$comma = ",";
			}
			$sql = "insert into ".$table." (".$columns.") values (".$values.")";
		}
		else
		{
			die("insert($table,$array)中，$array必须为数组！！");
		}
		$this->query($sql);
	}
	function update($table,$array,$condition)
	{
		$setting = ""; $comma="";
		if (is_array($array))
		{
			while (list($c,$v) = each ($array))
			{
				$setting .= $comma."`".$c."`='".$this->checkPost($v)."'";
				$comma = ",";
			}
			$sql = "update ".$table." set ".$setting." where ".$condition;
		}
		else
		{
			die("update($table,$array,$condition)中，$array必须为数组！！");
		}
		$this->query($sql);
	}

	function query($sql) 
	{
		$query = mysql_query($sql);
		if(!$query) 
		{
			$this->halt('MySQL请求错误', $sql);
		}
		$querycount++;
		return $query;
	}
	function fetch_array($query) 
	{
		return mysql_fetch_array($query);
	}
	function fetch_one_array($sql) 
	{
		$query = $this->query($sql);
		return mysql_fetch_array($query);
	}
	function fetch_one($sql) 
	{
		$record = $this->fetch_one_array($sql);
		Return $record[0];
	}
	function num_rows($query)
	{
		return mysql_num_rows($query);
	}
	function insert_id() 
	{
		return mysql_insert_id();
	}
	function close() 
	{
		return mysql_close();
	}
	function version() 
	{
		$version = @mysql_get_server_info();
		if (!$version) $version = "未知";
		return $version;
	}
	function halt($msg,$sql="")
	{
		$message = "<html>\n<head>\n<meta content=\"text/html; charset=gb2312\" http-equiv=\"Content-Type\">\n";
		$message .=  "<title>数据库错误</title>\n</head>\n";
		$message .= "<body>\n";

		$message .= "<b>数据库出错</b>: ".htmlspecialchars($msg)."\n<p>";
		$message .= "<b>错误描述</b>: ".mysql_error()."\n<br/>";
		$message .= "<b>错误编号</b>: ".mysql_errno()."\n<br/>";
		$message .= "<b>出错时间</b>: ".date("Y-m-d H:i",time())."\n<br/>";
		$message .= "<b>错误请求</b>: ".$sql."\n<br/>";
		$message .= "<b>出错脚本</b>: http://".$_SERVER['HTTP_HOST'].getenv("REQUEST_URI")."\n<br/>";
		$message .= "<b>技术支持</b>: ".SUPPORT."\n";
		$message .= "</p></body>\n</html>";

		die($message);
	}
	function checkPost($data)
	{
		$data = str_replace("'","''",$data);
		return $data;
	}

}
?>