<?php
error_reporting(7);
require_once("config.php");
$username = $_GET['username'];
$count1 = $db->fetch_one("select count(*) from ".$db_employee." where `username`='".$username."'");
$count2 = $db->fetch_one("select count(*) from ".$db_employer." where `username`='".$username."'");
if ($count1 + $count2 > 0)
{
	echo "<script>alert('�Բ����û����Ѿ����ڡ�');</script>";
}
else
{
	echo "<script>alert('��ϲ�㣬�����ʹ������û���ע�ᡣ');</script>";
}
?>
