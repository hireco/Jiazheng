<?php
/*
���ݿ⹦��
========
��Ҫ�������ࣺ�ޣ��ɵ���ʹ��
========
��ɫ:��Ҫ��update��insert������������ʹ�õ�sql��������չ
========
��Ҫ����˵��:

����:$db = new DataBase;
connect:�����ݿ��������
	eg: $mysql = $db->connect("localhost","root","password","table");
query:����һ��query
	eg: $query = $db->query("select * from `table` where `id`=1");
insert:��Ӽ�¼
	eg: $db->insert("table",array(
			'id' => $id,
			'user' => $user
			));
update:���¼�¼
	eg: $db->update("table",array(
			'id' => $id,
			'user' => $user
			),
			"id=1");
==============
Author:Coldney
Web:http://www.coldpage.com
E-Mail:coldney@gmail.com
�뱣��������Ϣ
*/
error_reporting(7);
define ('SUPPORT','coldney@gmail.com');//����֧������

class DataBase
{
	var $querycount;
	function connect($servername, $dbusername, $dbpassword, $dbname, $usepconnect=0)
	{
		if($usepconnect)
		{
			if(!@mysql_pconnect($servername, $dbusername, $dbpassword))
				$this->halt("���ݿ�����ʧ��");
		}
		else
		{
			if(!@mysql_connect($servername, $dbusername, $dbpassword)) 
				$this->halt("���ݿ�����ʧ��");
		}
		if(!@mysql_select_db($dbname)) 
			$this->halt("���ݿ�ѡ��ʧ��");
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
			die("insert($table,$array)�У�$array����Ϊ���飡��");
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
			die("update($table,$array,$condition)�У�$array����Ϊ���飡��");
		}
		$this->query($sql);
	}

	function query($sql) 
	{
		$query = mysql_query($sql);
		if(!$query) 
		{
			$this->halt('MySQL�������', $sql);
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
		if (!$version) $version = "δ֪";
		return $version;
	}
	function halt($msg,$sql="")
	{
		$message = "<html>\n<head>\n<meta content=\"text/html; charset=gb2312\" http-equiv=\"Content-Type\">\n";
		$message .=  "<title>���ݿ����</title>\n</head>\n";
		$message .= "<body>\n";

		$message .= "<b>���ݿ����</b>: ".htmlspecialchars($msg)."\n<p>";
		$message .= "<b>��������</b>: ".mysql_error()."\n<br/>";
		$message .= "<b>������</b>: ".mysql_errno()."\n<br/>";
		$message .= "<b>����ʱ��</b>: ".date("Y-m-d H:i",time())."\n<br/>";
		$message .= "<b>��������</b>: ".$sql."\n<br/>";
		$message .= "<b>����ű�</b>: http://".$_SERVER['HTTP_HOST'].getenv("REQUEST_URI")."\n<br/>";
		$message .= "<b>����֧��</b>: ".SUPPORT."\n";
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