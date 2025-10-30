<?php
/*
新闻功能模块
========
需要的类：config.php forms.php class_DataBase.php SmartTemplate class_User.php
========
主要功能：（$a == ）
--------------------
add 添加合约	makesure 确认合约	doadd 执行添加合约
list 合约列表	show 查看合约

附加功能 (function)
-------------------

关于权限的说明
==============
0 表示无权执行该操作
1 部份操作才有，表示限制执行该操作(list,edit,attdelete为1时只能操作自己的)
2 表示允许执行该操作
==============
Author:Victor_Dinho
E-Mail:dinho.victor@gmail.com
*/
if (DINHO != 1)
{
	header('HTTP/1.1  404  Not  Found');  
	header("status:  404  Not  Found");  
	exit();
}
$db_contract = "`".$mysql_prefix."contract`"; //合约数据表
$db_employee = "`".$mysql_prefix."employee`"; //雇员数据表
$db_employer = "`".$mysql_prefix."employer`"; //雇主数据表
$num_in_page = 20;  //每页显示数目

$allow = array();

switch($usr->rights['Contract'])
{
case 'S':  //超级管理员
	$allow = array(
		'add' => 2, 'doadd' => 2, 'makesure' => 2, 'list' => 2, 'del' => 2,
		);
	break;
case 'A':  //一级管理员
	$allow = array(
		'add' => 2, 'doadd' => 2, 'makesure' => 2, 'list' => 2, 'del' => 0,
		);
	break;
case 'M':  //二级管理员
	$allow = array(
		'add' => 0, 'doadd' => 0, 'makesure' => 0, 'list' => 0, 'del' => 0,
		);
	break;
default:  //无权限
	$allow = array(
		'add' => 0, 'doadd' => 0, 'makesure' => 0, 'list' => 0, 'del' => 0,
		);
	break;
}

if (!($allow[$a] > 0)) $Form->oa_exit("你没有权限执行该操作~~");

if ($a == 'add') //添加合约
{
	$starttime_stamp = time();
	$interval = 15552000; //180天
	$endtime_stamp = $starttime_stamp + $interval;
	$endtime = array();
	$endtime['year'] = oadate("Y",$endtime_stamp);;
	$endtime['month'] =oadate("n",$endtime_stamp);
	$endtime['day'] = oadate("j",$endtime_stamp);
	$endtime['hour'] = 0;
	$endtime['minute'] = 0;
	$endtime['second'] = 0;
	$endtime['text'] = "合约结束时间";
	$endtime['note'] = "(默认为合约开始时间之后180天)";
	

	$Form->cpheader("添加合约");
	$Form->formheader(array(
		'title' => "添加合约",
		'action' => "admin.php?j=Contract&a=makesure"
		));
	$Form->makeinput(array(
		'text' => "雇员编号",
		'name' => "employeeid",
		));
	$Form->makeinput(array(
		'text' => "雇主编号",
		'name' => "employerid",
		));
	$Form->makeinput(array(
		'text' => "中介费",
		'name' => "agent",
		));
	$Form->makeinput(array(
		'text' => "工资",
		'name' => "salary",
		));
	$Form->maketimeinput($endtime);
	$Form->maketextarea(array(
		'text' => "备注",
		'name' => "note",
		), 0);
	$Form->formfooter(array(
		"button" => array(
			array('value'=>"下一步"),
			array('value'=>"重置",'type'=>"reset"),
		)));
	$Form->cpfooter();
}
elseif ($a == 'makesure') //确认合约
{
	$endtime = mktime($_POST['hour'], $_POST['minute'], $_POST['second'], $_POST['month'], $_POST['day'], $_POST['year']);
	$Form->cpheader("确认合约");
	$Form->formheader(array(
		'title' => "确认合约",
		'action' => "admin.php?j=Contract&a=doadd",
		));
	$Form->makehidden(array(
		'name' => "employeeid",
		'value' => $_POST['employeeid'],
		));
	$Form->makehidden(array(
		'name' => "employerid",
		'value' => $_POST['employerid'],
		));
	$Form->makehidden(array(
		'name' => "agent",
		'value' => $_POST['agent'],
		));
	$Form->makehidden(array(
		'name' => "salary",
		'value' => $_POST['salary'],
		));
	$Form->makehidden(array(
		'name' => "endtime",
		'value' => $endtime,
		));
	$Form->maketd(array(
		"<b>雇员编号</b>",
		$_POST['employeeid'],
		));
	$Form->maketd(array(
		"<b>雇主编号</b>",
		$_POST['employerid'],
		));
	$Form->maketd(array(
		"<b>中介费</b>",
		$_POST['agent'],
		));
	$Form->maketd(array(
		"<b>工资</b>",
		$_POST['salary'],
		));
	$Form->maketd(array(
		"<b>合约结束时间</b>",
		date('Y年n月j日', $endtime),
		));
	$Form->maketd(array(
		"<b>备注</b>",
		$_POST['note'],
		));
	$Form->formfooter(array(
		"button" => array(
			array('value'=>"确定"),
			array('value'=>"返回", 'type'=>"button", 'extra' => "onclick='history.back(-1)'"),
		)));
	echo "<script>function goto(url){this.location.replace(url);}</script>";
	$Form->cpfooter();
}
elseif ($a == 'doadd') //执行添加合约
{
	$db->insert($db_contract,array(
		'employeeid' => intval($_POST['employeeid']),
		'employerid' => intval($_POST['employerid']),
		'agent' => intval($_POST['agent']),
		'salary' => $_POST['salary'],
		'note' => checkStr($_POST['note']),
		'endtime' => $_POST['endtime'],
		'starttime' => time(),
		'adder' => $username,
		'addip' => getip(),
		));
	$db->update($db_employer, array(
		'occupied' => 1,
		), "`id`=".$_POST['employerid']);
	$db->update($db_employee, array(
		'occupied' => 1,
		), "`id`=".$_POST['employeeid']);
	$Form->oa_exit("合约添加成功","admin.php?j=Contract&a=list");
}
elseif ($a == 'list') //合约列表
{
	//处理会员的occupied问题
	$sql_employer = "select * from ".$db_employer." where `occupied`=1";
	$query_employer = $db->query($sql_employer);
	while ($employer = $db->fetch_array($query_employer))
	{
		$sql_contract = "select max(`endtime`) from ".$db_contract." where `employerid`=".$employer['id'];
		if ($db->fetch_one($sql_contract) <= time())
		{
			$db->update($db_employer, array(
				'occupied' => 0,
				), "`id`=".$employer['id']);
		}
	}
	$sql_employee = "select * from ".$db_employee." where `occupied`=1";
	$query_employee = $db->query($sql_employee);
	while ($employee = $db->fetch_array($query_employee))
	{
		$sql_contract = "select max(`endtime`) from ".$db_contract." where `employerid`=".$employee['id'];
		if ($db->fetch_one($sql_contract) <= time())
		{
			$db->update($db_employee, array(
				'occupied' => 0,
				), "`id`=".$employee['id']);
		}
	}

	$sql_num = "select count(*) from ".$db_contract." where 1";
	$listNum = $db->fetch_one($sql_num);
	$formtitle = "合约 [共".$listNum."条] [{$num_in_page}条/页]";

	$cpage = isset($_GET['page']) ? intval($_GET['page']) : 1;
	$page_char = page($listNum,$num_in_page,$cpage,"admin.php?j=Contract&a=list");
	$limitS = $cpage*$num_in_page-$num_in_page;

	$Form->cpheader();
	if($listNum > 0)
	{
		$Form->if_del();
		$Form->tableheaderbig(array(
			"title" => $formtitle,
			"colspan" => "8",
		));
		echo "<tr align=\"center\">\n";
		echo "<td width=\"15%\"><b>雇员</b></td>\n";
		echo "<td width=\"15%\"><b>雇主</b></td>\n";
		echo "<td width=\"12%\"><b>中介费</b></td>\n";
		echo "<td width=\"14%\"><b>工资</b></td>\n";
		echo "<td width=\"12%\"><b>开始日期</b></td>\n";
		echo "<td width=\"12%\"><b>结束日期</b></td>\n";
		echo "<td width=\"12%\"><b>添加者</b></td>\n";
		echo "<td width=\"6%\"><b>操作</b></td>\n";
		echo "</tr>\n";
		$lstRequest = "select * from ".$db_contract." where 1 order by `starttime` desc limit ".$limitS.",".$num_in_page;
		$vRe = $db->query($lstRequest);
		while($nL = $db->fetch_array($vRe)) 
		{
			$sql_employee = "select `name` from ".$db_employee." where `id`=".$nL['employeeid'];
			$tname = $db->fetch_one($sql_employee);
			$sql_employer = "select `name` from ".$db_employer." where `id`=".$nL['employerid'];
			$sname = $db->fetch_one($sql_employer);
			echo "<tr align=\"center\">\n";
			echo "<td><a href=\"admin.php?j=User&a=showemployee&id={$nL['employeeid']}\">".$tname."</a></td>\n";
			echo "<td><a href=\"admin.php?j=User&a=showemployer&id={$nL['employerid']}\">".$sname."</a></td>\n";
			echo "<td>".$nL['agent']."</td>\n";
			echo "<td>".$nL['salary']."</td>\n";
			echo "<td>".date('Y年n月j日',$nL['starttime'])."</td>\n";
			echo "<td>".date('Y年n月j日',$nL['endtime'])."</td>\n";
			echo "<td>".$nL['adder']."</td>\n";
			echo "<td><a href=\"#\" onclick=\"ifDel('admin.php?j=Contract&a=del&id={$nL['id']}')\">删除</a></td>\n";
			echo "</tr>\n";
		}
		echo "<tr><td colspan=\"8\" align=\"right\">".$page_char."</td></tr>";
		$Form->tablefooter(array("colspan" => "8"));
	}
	else
	{
		$Form->tableheaderbig(array("title" => $formtitle,));
		$Form->maketd(array("暂时没有合约~~"));
		$Form->tablefooter();
	}
	$Form->cpfooter();
}
elseif ($a == 'del') //删除合约
{
	$id = intval($_GET['id']);
	$sql = "select count(*) from ".$db_contract." where `id`='".$id."'";
	$num = $db->fetch_one($sql);
	
	if (!($num)) $Form->oa_exit("该合约不存在");

	$db->query("delete from ".$db_contract." where `id`='".$id."'");
	$Form->oa_exit("删除合约成功!","admin.php?j=Contract&a=list");
}
else
{
	$Form->oa_exit("功能不存在","index.php?a=main");
}

?>