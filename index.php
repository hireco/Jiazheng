<?php

file_exists("install.php")?die("请先运行<a href=\"install.php\">install.php</a>安装，然后将install.php删除再访问。"):null;

session_start();
error_reporting(7);
require_once("config.php");

$tmpH = template("header_m");
$tmpB = template("bottom_m");

require_once("header.php");
require_once("bottom.php");
require_once("checklogin.php");
if ($logined == 1) //已登陆的页面
{
	$tmp = template("maind");
	$checked = array('<font color="red">未审批</font>', '已审批');
	$info = $db->fetch_one_array("select * from ".$db_user." where `id`=".$userid);
	$tmp->assign(array(
		'id' => $info['id'],
		'checked' => $checked[$info['checked']],
		'visit_times' => $info['visit_times'],
		'visited_times' => $info['visited_times'],
		'reg_time' => date('y-m-d', $info['reg_time']),
		));
}
else
{
	$tmp = template("main");
}

$c_telephone = $db->fetch_one("select `telephone` from ".$db_config." where `id`=1");
$c_fax = $db->fetch_one("select `telephone` from ".$db_config." where `id`=1");
$c_address = $db->fetch_one("select `address` from ".$db_config." where `id`=1");
$tmp->assign("telephone", $c_telephone);
$tmp->assign("fax", $c_fax);
$tmp->assign("address", $c_address);

//显示公告
$notice_num = 5;
$notice_len = 35;
$sql_notice = "select * from ".$db_article." where `sort`=1 and `show`=1 order by `top` desc, `post_time` desc limit 0,".$notice_num;
$query_notice = $db->query($sql_notice);
while ($notice = $db->fetch_array($query_notice))
{
	$tmp->append('NOTICE', array(
		'id' => $notice['id'],
		'title' => $notice['title'],
		'short' => gbsubstr($notice['title'], 0, $notice_len),
		));
}

//推荐雇员
$rec_num = 4;
$ori_width = 120;
$ori_height = 120;
$imgPath = "attachment/user/";
$sql_rec = "select * from ".$db_employee." where `checked`=1 and `recommended`=1 order by `rec_time` desc";
$query_rec = $db->query($sql_rec);
$current_num = 0;
while ($rec_info = $db->fetch_array($query_rec))
{
	if ($current >= $rec_num)
		break;
	if ($rec_info['picture'] != "")
	{
		$current_num++;
		$path = $imgPath.$rec_info['picture'];
		$photo = getimagesize($path);
		$picW = $photo[0];
		$picH = $photo[1];
		if ($picW / $picH < $ori_width / $ori_height)
		{
			$height = $ori_height;
			$width = $picW / $picH * $height;
		}
		else
		{
			$width = $ori_width;
			$height = $picH / $picW * $width;
		}
		$tmp->append('REC_LIST', array(
			'pic' => $path,
			'id' => $rec_info['id'],
			'height' => $height,
			'width' => $width,
			));
	}
}

$occupied = array('<font color="red">未安排</font>', '已安排');
//最新雇员列表
$employee_num = 5;
$employee_service_len = 25;
$sql_employee = "select * from ".$db_employee." where `checked`=1 order by `reg_time` desc limit 0,".$employee_num;
$query_employee = $db->query($sql_employee);
while ($employee = $db->fetch_array($query_employee))
{
	$area = $db->fetch_one("select `name` from ".$db_area." where `id`=".$employee['area']);
	$tmp->append('EMPLOYEE_LIST', array(
		'id' => $employee['id'],
		'area' => $area,
		'sex' => $employee['sex'],
		'salary' => $employee['salary'],
		'service' => gbsubstr(trim(str_replace(',', ' ', $employee['service'])), 0, $employee_service_len),
		'occupied' => $occupied[$employee['occupied']],
		));
}

//最新雇主列表
$employer_num = 5;
$employer_service_len = 25;
$sql_employer = "select * from ".$db_employer." where `checked`=1 order by `reg_time` desc limit 0,".$employer_num;
$query_employer = $db->query($sql_employer);
while ($employer = $db->fetch_array($query_employer))
{
	$area = $db->fetch_one("select * from ".$db_area." where `id`=".$employer['area']);
	$tmp->append('EMPLOYER_LIST', array(
		'id' => $employer['id'],
		'area' => $area,
		'ideal_sex' => $employer['ideal_sex'],
		'salary' => $employer['salary'],
		'service' => gbsubstr(trim(str_replace(',', ' ', $employer['service'])), 0, $employee_service_len),
		'occupied' => $occupied[$employer['occupied']],
		));
}

//两个文章列表
$article_num = 5;
$article_len = 50;
$sortname2 = $db->fetch_one("select `name` from ".$db_sort." where `id`=2");
$tmp->assign("sort2", $sortname2);
$sql_article_2 = "select * from ".$db_article." where `show`=1 and `sort`=2 order by `top` desc, `post_time` desc limit 0,".$article_num;
$query_article_2 = $db->query($sql_article_2);
while ($article_2 = $db->fetch_array($query_article_2))
{
	$tmp->append("ARTICLE_LIST2", array(
		'id' => $article_2['id'],
		'title' => $article_2['title'],
		'short' => gbsubstr($article_2['title'], 0, $article_len),
		));
}

$sortname3 = $db->fetch_one("select `name` from ".$db_sort." where `id`=3");
$tmp->assign("sort3", $sortname3);
$sql_article_3 = "select * from ".$db_article." where `show`=1 and `sort`=3 order by `top` desc, `post_time` desc limit 0,".$article_num;
$query_article_3 = $db->query($sql_article_3);
while ($article_3 = $db->fetch_array($query_article_3))
{
	$tmp->append("ARTICLE_LIST3", array(
		'id' => $article_3['id'],
		'title' => $article_3['title'],
		'short' => gbsubstr($article_3['title'], 0, $article_len),
		));
}

//友情链接列表
//文字
$friend_word_num = 20;
$sql_friend_word = "select * from ".$db_friend." where `type`=0 and `status`=1 order by `top` desc, `time` desc limit 0,".$friend_word_num;
$query_friend_word = $db->query($sql_friend_word);
while ($friend_word = $db->fetch_array($query_friend_word))
{
	$tmp->append("FRIEND_WORD_LIST", array(
		'title' => $friend_word['title'],
		'link' => $friend_word['link'],
		));
}
//图片
$friend_pic_num = 20;
$sql_friend_pic = "select * from ".$db_friend." where `type`=1 and `status`=1 order by `top` desc, `time` desc limit 0,".$friend_pic_num;
$query_friend_pic = $db->query($sql_friend_pic);
while ($friend_pic = $db->fetch_array($query_friend_pic))
{
	$tmp->append("FRIEND_PIC_LIST", array(
		'pic' => $friend_pic['pic'],
		'title' => $friend_pic['title'],
		'link' => $friend_pic['link'],
		));
}

//广告
$sql_ad_left = "select `content` from ".$db_ad." where `position`='左侧'";
$ad_left = $db->fetch_one($sql_ad_left);
$tmpH->assign('AD_LEFT', $ad_left);

$sql_ad_right = "select `content` from ".$db_ad." where `position`='右侧'";
$ad_right = $db->fetch_one($sql_ad_right);
$tmpB->assign('AD_RIGHT', $ad_right);

$sql_ad_center = "select `content` from ".$db_ad." where `position`='中间'";
$ad_center = $db->fetch_one($sql_ad_center);
$tmp->assign('AD_CENTER', $ad_center);

$tmpH->output();
$tmp->output();
$tmpB->output();
?>
