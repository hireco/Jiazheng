<?php
session_start();

require_once("config.php");

$username = checkStr($_POST['username']);
$password = checkStr($_POST['password']);
$type = $_POST['type'];
if ($type == "")
{
	oa_exit("��ѡ���Ա���ǹ���");
}
$cookie = intval($_POST['cookie']); //����Ϊ��λ

$db_user = ($type == "employee" ? $db_employee : $db_employer);
$sql_login = "select `id`, `password` from ".$db_user." where `username`='".$username."'";
$info = $db->fetch_one_array($sql_login);
if ($info['password'] != md5($password))
{
	oa_exit("�û��������벻��ȷ");
}
else //�ɹ���½
{
	if (isset($_COOKIE)) //��ʹ��cookies
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
	else //ֻ��ʹ��session
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
	oa_exit("��½�ɹ������ڽ����Ա����", "membercenter.php");
}
?>