<?php
error_reporting(7);
include_once('config.php');

$tmpH = template("header");
$tmpB = template("bottom");

include_once('header.php');
include_once('checklogin.php');

$j = isset($_GET["j"]) ? $_GET["j"] : 'System';
$a = isset($_GET["a"]) ? $_GET["a"] : 'main';

if (!$logined) oa_exit("还没有登录 :(");
$username = $db->fetch_one("select `username` from ".$db_user." where `id`=".$userid);
$link = "class/Module_{$j}.php";
if (file_exists($link))
{
	require_once($link);
	require_once("left.php");
}
else
	oa_exit("功能模块不存在");

$tmpH->output();
$tmp->output();
$tmpB->output();
?>