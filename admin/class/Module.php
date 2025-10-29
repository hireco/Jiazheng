<?php
/*
新闻功能模块
========
需要的类：config.php forms.php class_DataBase.php SmartTemplate class_User.php
========
主要功能：（$a == ）
--------------------

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
$db_news = "`".$mysql_prefix."article`"; //新闻数据表
$num_in_page = 20;  //每页显示数目

$allow = array();

switch($usr->rights['News'])
{
case 'S':  //超级管理员
	$allow = array(
		);
	break;
case 'A':  //一级管理员
	$allow = array(
		);
	break;
case 'M':  //二级管理员
	$allow = array(
		);
	break;
default:  //无权限
	$allow = array(
		);
	break;
}

if (!($allow[$a] > 0)) $Form->oa_exit("你没有权限执行该操作~~");

if ($a == 'add')
{
}
else
{
	$Form->oa_exit("功能不存在","index.php?a=main");
}

?>