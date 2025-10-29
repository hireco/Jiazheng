<?php
session_start();
error_reporting(7);
require_once("config.php");

$tmpH = template("header");
$tmpB = template("bottom");

require_once("header.php");
require_once("bottom.php");

$action = (isset($_POST['action']) ? $_POST['action'] : "read");
if ($action == "read")
{
	$tmp = template("guestbook");
	$id = intval($_GET['id']);

	//分页
	$num_in_page = 10;
	$sql_num = "select count(*) from ".$db_guestbook." where `status`=1";
	$listNum = $db->fetch_one($sql_num);

	$cpage = isset($_GET['page']) ? intval($_GET['page']) : 1;
	$page_char = page($listNum,$num_in_page,$cpage,"guestbook.php?");
	$limitS = $cpage*$num_in_page-$num_in_page;

	//留言列表
	$sql_note = "select * from ".$db_guestbook." where `status`=1 order by `time` desc limit ".$limitS.",".$num_in_page;
	$query_note = $db->query($sql_note);
	while ($note = $db->fetch_array($query_note))
	{
		if ($note['qq'] != "")
		{
			$hasqq = 1;
		}
		else
		{
			$hasqq = 0;
		}
		if ($note['email'] != "")
		{
			$hasemail = 1;
		}
		else
		{
			$hasemail = 0;
		}

		$tmp->append("NOTE_LIST", array(
			'id' => $note['id'],
			'name' => $note['name'],
			'image' => $note['image'],
			'email' => $note['email'],
			'qq' => $note['qq'],
			'content' => str2html($note['content']),
			'reply' => str2html($note['reply']),
			'ip' => showip($note['ip']),
			'time' => date('y-m-d H:i', $note['time']),
			'web_title' => $web_title,
			'HASQQ' => $hasqq,
			'HASEMAIL' => $hasemail,
			));
	}
	$tmp->assign("pagechar", $page_char);

	$noteverify = $db->fetch_one("select `noteverify` from ".$db_config." where `id`=1");
	if ($noteverify == 0)
	{
		session_unregister("authnum");
		$check_fun = "checknote1";
	}
	else
	{
		$check_fun = "checknote2";
	}
	$tmp->assign("VERIFY", $noteverify);
	$tmp->assign("check", $check_fun);

	$tmpH->output();
	$tmp->output();
	$tmpB->output();
}
elseif ($action = "post")
{
	$db->insert($db_guestbook, array(
		'name' => checkStr($_POST['name']),
		'image' => $_POST['image'],
		'email' => checkStr($_POST['email']),
		'telephone' => $_POST['telephone'],
		'qq' => $_POST['qq'],
		'content' => checkStr($_POST['content']),
		'time' => time(),
		'ip' => getip(),
		'status' => 0,
		'read' => 0,
		));
	oa_exit("你已经成功留言，请等待管理员审批", "guestbook.php");
}
?>
