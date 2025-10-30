<?php
session_start();

require_once("config.php");

$username = checkStr($_POST['username']);
$password = checkStr($_POST['password']);
$type = $_POST['type'];
if ($type == "")
{
	oa_exit("请选择雇员还是雇主");
}
$cookie = intval($_POST['cookie']); //以天为单位

$db_user = ($type == "employee" ? $db_employee : $db_employer);
$sql_login = "select `id`, `password` from ".$db_user." where `username`='".$username."'";
$info = $db->fetch_one_array($sql_login);
if ($info['password'] != md5($password))
{
	oa_exit("用户名或密码不正确");
}
else //成功登陆
{
	if (isset($_COOKIE)) //能使用cookies
	{
		if ($cookie == 0)
		{
			setcookie("userid", $info['id']);
			setcookie("password", $info['password']);
			setcookie("type", $type);
		}
		else
		{
			$time = time() + $cookie * 24 * 3600;
			setcookie("userid", $info['id'], $time);
			setcookie("password", $info['password'], $time);
			setcookie("type", $type, $time);
		}
	}
	else //只能使用session
	{
		$_SESSION['userid'] = $info['id'];
		$_SESSION['password'] = $info['password'];
		$_SESSION['type'] = $type;
	}
	$visit_times = $db->fetch_one("select `visit_times` from ".$db_user." where `username`='".$username."'");
	$db->update($db_user, array(
		'visit_times' => $visit_times + 1,
		'last_ip' => getip(),
		'last_time' => time(),
		), "`username`='".$username."'");
	oa_exit("登陆成功，正在进入会员中心", "membercenter.php");
}
?>