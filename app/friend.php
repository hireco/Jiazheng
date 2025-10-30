<?php
error_reporting(7);
require_once("config.php");

$tmpH = template("header");
$tmpB = template("bottom");

require_once("header.php");
require_once("bottom.php");

$action = (isset($_POST['action']) ? $_POST['action'] : "show");
if ($action == "show")
{
	$tmp = template("friend");

	//本站信息
	$imgPath = "attachment/config/";
	$admin = $db->fetch_one("select `admin` from ".$db_config." where `id`=1");
	$email = $db->fetch_one("select `email` from ".$db_config." where `id`=1");
	$link_logo = $db->fetch_one("select `link_logo` from ".$db_config." where `id`=1");
	$intro = $db->fetch_one("select `intro` from ".$db_config." where `id`=1");
	$tmp->assign("title", $web_title);
	$tmp->assign("url", $url);
	$tmp->assign("name", $admin);
	$tmp->assign("email", $email);
	$tmp->assign("logo", $imgPath.$link_logo);
	$tmp->assign("intro", str2html($intro));
	//友情链接列表
	//文字
	$sql_friend_word = "select * from ".$db_friend." where `type`=0 and `status`=1 order by `top` desc, `time` desc";
	$query_friend_word = $db->query($sql_friend_word);
	while ($friend_word = $db->fetch_array($query_friend_word))
	{
		$tmp->append("FRIEND_WORD_LIST", array(
			'title' => $friend_word['title'],
			'link' => $friend_word['link'],
			));
	}
	//图片
	$sql_friend_pic = "select * from ".$db_friend." where `type`=1 and `status`=1 order by `top` desc, `time` desc";
	$query_friend_pic = $db->query($sql_friend_pic);
	while ($friend_pic = $db->fetch_array($query_friend_pic))
	{
		$tmp->append("FRIEND_PIC_LIST", array(
			'pic' => $friend_pic['pic'],
			'title' => $friend_pic['title'],
			'link' => $friend_pic['link'],
			));
	}
	$tmpH->output();
	$tmp->output();
	$tmpB->output();
}
elseif ($action = "post")
{
	$db->insert($db_friend, array(
		'type' => $_POST['type'],
		'title' => checkStr($_POST['title']),
		'pic' => checkStr($_POST['pic']),
		'link' => checkStr($_POST['link']),
		'intro' => checkStr($_POST['intro']),
		'name' => checkStr($_POST['name']),
		'email' => checkStr($_POST['email']),
		'status' => 0,
		'top' => 0,
		'time' => time(),
		'ip' => getip(),
		));
	oa_exit("你已经成功提交友情链接，请等待管理员审批", "index.php");
}
?>
