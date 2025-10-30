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
	$tmp = template("comment");
	$id = intval($_GET['id']);

	$title = $db->fetch_one("select `title` from ".$db_article." where `id`=".$id);

	$commentverify = $db->fetch_one("select `commentverify` from ".$db_config." where `id`=1");
	if ($commentverify == 0)
	{
		session_unregister("authnum");
		$check_fun = "checkcomment1";
	}
	else
	{
		$check_fun = "checkcomment2";
	}
	$tmp->assign("VERIFY", $commentverify);
	$tmp->assign("check", $check_fun);
	$tmp->assign("title", $title);
	$tmp->assign("id", $id);

	//分页
	$num_in_page = 20;
	$sql_num = "select count(*) from ".$db_comment." where `aid`=".$id;
	$listNum = $db->fetch_one($sql_num);

	$cpage = isset($_GET['page']) ? intval($_GET['page']) : 1;
	$page_char = page($listNum,$num_in_page,$cpage,"comment.php?id=".$id);
	$limitS = $cpage*$num_in_page-$num_in_page;

	//文章列表
	$sql_comment = "select * from ".$db_comment." where `aid`=".$id." order by `time` desc limit ".$limitS.",".$num_in_page;
	$query_comment = $db->query($sql_comment);
	while ($comment = $db->fetch_array($query_comment))
	{
		$tmp->append("COMMENT_LIST", array(
			'id' => $comment['id'],
			'content' => str2html($comment['content']),
			'ip' => showip($comment['ip']),
			'time' => date('y-m-d H:i', $comment['time']),
			));
	}
	$tmp->assign("pagechar", $page_char);
	$tmp->assign("id", $id);
	$tmpH->output();
	$tmp->output();
	$tmpB->output();
}
elseif ($action = "post")
{
	$db->insert($db_comment, array(
		'aid' => $_POST['aid'],
		'content' => checkStr($_POST['content']),
		'time' => time(),
		'ip' => getip(),
		));
	oa_exit("你已经成功评论", "comment.php?id=".$_POST['aid']);
}
?>
