<?php
error_reporting(7);
include_once('config.php');

$tmpH = template("header");
$tmpB = template("bottom");

include_once('header.php');
include_once('checklogin.php');

$j = isset($_GET["j"]) ? $_GET["j"] : 'System';
$a = isset($_GET["a"]) ? $_GET["a"] : 'main';

if (!$logined) oa_exit("��û�е�¼ :(");
$username = $db->fetch_one("select `username` from ".$db_user." where `id`=".$userid);
$link = "class/Module_{$j}.php";
if (file_exists($link))
{
	require_once($link);
	require_once("left.php");
}
else
	oa_exit("����ģ�鲻����");

$tmpH->output();
$tmp->output();
$tmpB->output();
?>