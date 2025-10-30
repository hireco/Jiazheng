<?php
error_reporting(7);
require_once("config.php");

$tmpH = template("header");
$tmpB = template("bottom");

require_once("header.php");
require_once("bottom.php");

$step = (isset($_POST['step']) ? intval($_POST['step']) : 1);
if ($step == 1) //�����û���
{
	$tmp = template("findpass1");
}
elseif ($step == 2) //�����
{
	$tmp = template("findpass2");
	$username = checkStr($_POST['username']);
	if ($db->fetch_one("select `username` from ".$db_employer." where `username`='".$username."'") != "")
		$type = "employer";
	elseif ($db->fetch_one("select `username` from ".$db_employee." where `username`='".$username."'") != "")
		$type = "employee";
	else
		oa_exit("����������û�");
	if ($type == 'employer')
	{
		$db_user = $db_employer;
	}
	else
	{
		$db_user = $db_employee;
	}
	$question = $db->fetch_one("select `question` from ".$db_user." where `username`='".$username."'");
	$tmp->assign("question", $question);
	$tmp->assign("username", $username);
	$tmp->assign("type", $type);
}
elseif ($step == 3) //�޸�����
{
	$tmp = template("findpass3");
	$answer = checkStr($_POST['answer']);
	$username = checkStr($_POST['username']);
	$type = $_POST['type'];
	if ($type == 'employer')
	{
		$db_user = $db_employer;
	}
	else
	{
		$db_user = $db_employee;
	}
	$correct_answer = $db->fetch_one("select `answer` from ".$db_user." where `username`='".$username."'");
	if ($answer != $correct_answer)
	{
		oa_exit("�Բ���������Ĵ𰸴���");
	}
	$tmp->assign("username", $username);
	$tmp->assign("type", $type);
}
elseif ($step == 4) //ִ���޸�����
{
	$pass1 = $_POST['password1'];
	$pass2 = $_POST['password2'];
	$username = checkStr($_POST['username']);
	$type = $_POST['type'];
	if ($type == 'employer')
	{
		$db_user = $db_employer;
	}
	else
	{
		$db_user = $db_employee;
	}
	if ($pass1 != $pass2)
	{
		oa_exit("��������������벻��ͬ");
	}
	$db->update($db_user, array(
		'password' => md5($pass1),
		), "`username`='".$username."'");
	oa_exit("��ϲ���һ�����", "index.php");
}
$tmpH->output();
$tmp->output();
$tmpB->output();
?>
