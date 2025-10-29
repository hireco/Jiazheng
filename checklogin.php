<?php
session_start();
if (isset($_COOKIE['userid']) && isset($_COOKIE['password']) && isset($_COOKIE['type']))
{
	$using = "cookie";
	$userid = $_COOKIE['userid'];
	$password = $_COOKIE['password'];
	$type = $_COOKIE['type'];
	if ($type == 'employee') //雇员
	{
		$db_user = $db_employee;
	}
	else //雇主
	{
		$db_user = $db_employer;
	}
	$sql_user = "select `password` from ".$db_user." where `id`='".$userid."'";
	$correct_password = $db->fetch_one($sql_user);
	if ($correct_password == $password)
	{
		$logined = 1;
	}
	else
	{
		$logined = 0;
	}
}
elseif (session_is_registered('userid') && session_is_registered('password') && session_is_registered('type'))
{
	$using = "session";
	$username = $_SESSION['userid'];
	$password = $_SESSION['password'];
	$type = $_SESSION['type'];
	if ($type == 'employee') //雇员
	{
		$db_user = $db_employee;
	}
	else //雇主
	{
		$db_user = $db_employer;
	}
	$sql_user = "select `password` from ".$db_user." where `id`='".$userid."'";
	$correct_password = $db->fetch_one($sql_user);
	if ($correct_password == $password)
	{
		$logined = 1;
	}
	else
	{
		$logined = 0;
	}
}
else
{
	$logined = 0;
}
?>
