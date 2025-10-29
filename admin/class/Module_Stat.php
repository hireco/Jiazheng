<?php
/*
新闻功能模块
========
需要的类：config.php forms.php class_DataBase.php SmartTemplate class_User.php
========
主要功能：（$a == ）
--------------------
loginlist 登陆记录列表	loginclear 清空登陆记录
adminlist 操作记录列表	adminclear 清空操作记录

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
$db_loginlog = "`".$mysql_prefix."loginlog`"; //登陆记录数据表
$db_adminlog = "`".$mysql_prefix."adminlog`"; //操作记录数据表
$num_in_page = 20;  //每页显示数目

$allow = array();

switch($usr->rights['News'])
{
case 'S':  //超级管理员
	$allow = array(
		'loginlist' => 2, 'loginclear' => 2,
		'adminlist' => 2, 'adminclear' => 2,
		);
	break;
case 'A':  //一级管理员
	$allow = array(
		'loginlist' => 0, 'loginclear' => 0,
		'adminlist' => 0, 'adminclear' => 0,
		);
	break;
case 'M':  //二级管理员
	$allow = array(
		'loginlist' => 0, 'loginclear' => 0,
		'adminlist' => 0, 'adminclear' => 0,
		);
	break;
default:  //无权限
	$allow = array(
		'loginlist' => 0, 'loginclear' => 0,
		'adminlist' => 0, 'adminclear' => 0,
		);
	break;
}

if (!($allow[$a] > 0)) $Form->oa_exit("你没有权限执行该操作~~");

if ($a == 'loginlist') //登陆记录列表
{
	$result = array('<font color=red>失败</font>', '成功');
	$sql_num = "select count(*) from ".$db_loginlog." where 1";
	$listNum = $db->fetch_one($sql_num);
	$formtitle = "登陆记录 [共".$listNum."条] [{$num_in_page}条/页]";

	$cpage = isset($_GET['page']) ? intval($_GET['page']) : 1;
	$page_char = page($listNum,$num_in_page,$cpage,"admin.php?j=Stat&a=loginlist");
	$limitS = $cpage*$num_in_page-$num_in_page;

	$Form->cpheader();
	$Form->tableheaderbig(array(
		"title" => $formtitle,
		"colspan" => "5",
	));
	echo "<tr align=\"center\">\n";
	echo "<td width=\"20%\"><b>ID</b></td>\n";
	echo "<td width=\"20%\"><b>IP</b></td>\n";
	echo "<td width=\"20%\"><b>用户名</b></td>\n";
	echo "<td width=\"20%\"><b>时间</b></td>\n";
	echo "<td width=\"20%\"><b>结果</b></td>\n";
	echo "</tr>\n";
	$lstRequest = "select * from ".$db_loginlog." where 1 order by `time` desc limit ".$limitS.",".$num_in_page;
	$vRe = $db->query($lstRequest);
	while($nL = $db->fetch_array($vRe)) 
	{
		echo "<tr align=\"center\">\n";
		echo "<td>".$nL['id']."</td>\n";
		echo "<td>".$nL['ip']."</td>\n";
		echo "<td>".$nL['username']."</td>\n";
		echo "<td>".date('y-m-d H:i',$nL['time'])."</td>\n";
		echo "<td>".$result[$nL['result']]."</td>\n";
		echo "</tr>\n";
	}
	echo "<tr><td colspan=\"5\" align=\"right\">".$page_char."</td></tr>";
	$Form->formfooter(array(
		"colspan"=>'5',
		"button" => array(
			array('value'=>"清空记录", 'type'=>"button", 'extra' => "onclick=\"goto('admin.php?j=Stat&a=loginclear')\""),
		)));
	$Form->tablefooter(array("colspan" => "5"));
	echo "<script>function goto(url){this.location.replace(url);}</script>";
	$Form->cpfooter();
}
elseif ($a == 'loginclear') //清空登陆记录
{
	$sql = "truncate table ".$db_loginlog;
	$db->query($sql);
	$Form->oa_exit("登陆记录已经清空", "admin.php?j=Stat&a=loginlist");
}
elseif ($a == 'adminlist') //操作记录列表
{
	$sql_num = "select count(*) from ".$db_adminlog." where 1";
	$listNum = $db->fetch_one($sql_num);
	$formtitle = "操作记录 [共".$listNum."条] [{$num_in_page}条/页]";

	$cpage = isset($_GET['page']) ? intval($_GET['page']) : 1;
	$page_char = page($listNum,$num_in_page,$cpage,"admin.php?j=Stat&a=adminlist");
	$limitS = $cpage*$num_in_page-$num_in_page;

	$Form->cpheader();
	$Form->tableheaderbig(array(
		"title" => $formtitle,
		"colspan" => "4",
	));
	echo "<tr align=\"center\">\n";
	echo "<td width=\"10%\"><b>ID</b></td>\n";
	echo "<td width=\"50%\"><b>页面</b></td>\n";
	echo "<td width=\"20%\"><b>IP</b></td>\n";
	echo "<td width=\"29%\"><b>时间</b></td>\n";
	echo "</tr>\n";
	$lstRequest = "select * from ".$db_adminlog." where 1 order by `time` desc limit ".$limitS.",".$num_in_page;
	$vRe = $db->query($lstRequest);
	while($nL = $db->fetch_array($vRe)) 
	{
		echo "<tr align=\"center\">\n";
		echo "<td>".$nL['id']."</td>\n";
		echo "<td>".$nL['script']."</td>\n";
		echo "<td>".$nL['ip']."</td>\n";
		echo "<td>".date('y-m-d H:i',$nL['time'])."</td>\n";
		echo "</tr>\n";
	}
	echo "<tr><td colspan=\"5\" align=\"right\">".$page_char."</td></tr>";
	$Form->formfooter(array(
		"colspan"=>'4',
		"button" => array(
			array('value'=>"清空记录", 'type'=>"button", 'extra' => "onclick=\"goto('admin.php?j=Stat&a=adminclear')\""),
		)));
	$Form->tablefooter(array("colspan" => "4"));
	echo "<script>function goto(url){this.location.replace(url);}</script>";
	$Form->cpfooter();
}
elseif ($a == 'adminclear') //清空操作记录
{
	$sql = "truncate table ".$db_adminlog;
	$db->query($sql);
	$Form->oa_exit("登陆记录已经清空", "admin.php?j=Stat&a=adminlist");
}
else
{
	$Form->oa_exit("功能不存在","index.php?a=main");
}

?>