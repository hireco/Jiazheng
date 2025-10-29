<?php
error_reporting(7);
require_once("config.php");
$username = $_GET['username'];
$count1 = $db->fetch_one("select count(*) from ".$db_employee." where `username`='".$username."'");
$count2 = $db->fetch_one("select count(*) from ".$db_employer." where `username`='".$username."'");
if ($count1 + $count2 > 0)
{
	echo "<script>alert('对不起，用户名已经存在。');</script>";
}
else
{
	echo "<script>alert('恭喜你，你可以使用这个用户名注册。');</script>";
}
?>
