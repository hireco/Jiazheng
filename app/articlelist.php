<?php
error_reporting(7);
require_once("config.php");

$tmpH = template("header");
$tmpB = template("bottom");
$tmp = template("articlelist");

require_once("header.php");
require_once("bottom.php");


$condition = (isset($_GET['id']) ? "and `sort`=".$_GET['id'] : "");

//分页
$num_in_page = 20;
$sql_num = "select count(*) from ".$db_article." where `show`=1 {$condition}";
$listNum = $db->fetch_one($sql_num);

$cpage = isset($_GET['page']) ? intval($_GET['page']) : 1;
$page_char = page($listNum,$num_in_page,$cpage,"articlelist.php?");
$limitS = $cpage*$num_in_page-$num_in_page;

//文章列表
$article_len = 80;
$sql_article = "select * from ".$db_article." where `show`=1 {$condition} order by `top` desc, `post_time` desc limit ".$limitS.",".$num_in_page;
$query_article = $db->query($sql_article);
while ($article = $db->fetch_array($query_article))
{
	$tmp->append("ARTICLE_LIST", array(
		'id' => $article['id'],
		'title' => $article['title'],
		'short' => gbsubstr($article['title'], 0, $article_len),
		'date' => date('m-d', $article['post_time']),
		));
}
$tmp->assign("pagechar", $page_char);

//热门文章列表
$hot_num = 5;
$hot_len = 22;
$sql_article = "select * from ".$db_article." where `show`=1 order by `click` desc, `post_time` desc limit 0,".$hot_num;
$query_article = $db->query($sql_article);
while ($article = $db->fetch_array($query_article))
{
	$tmp->append("HOT_LIST", array(
		'hot_id' => $article['id'],
		'hot_title' => $article['title'],
		'hot_short' => gbsubstr($article['title'], 0, $hot_len),
		));
}

$tmpH->output();
$tmp->output();
$tmpB->output();
?>
