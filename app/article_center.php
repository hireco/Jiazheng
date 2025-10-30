<?php
error_reporting(7);
require_once("config.php");

$tmpH = template("header");
$tmp = template("articlecenter");
$tmpB = template("bottom");

require_once("header.php");
require_once("bottom.php");


$article_num = 5;
$title_len = 40;
$sql_sort = "select * from ".$db_sort." where 1 order by `order` asc";
$query_sort = $db->query($sql_sort);
while ($sort = $db->fetch_array($query_sort))
{
	$sql_num = "select count(*) from ".$db_article. "where `show`=1 and `sort`=".$sort['id'];
	$num = $db->fetch_one($sql_num);
	if ($num == 0)
		continue;
	$sql_article = "select * from ".$db_article. "where `show`=1 and `sort`=".$sort['id']." order by `top` desc, `post_time` desc limit 0,".$article_num;
	$query_article = $db->query($sql_article);
	$article_html = "<ul style=\"list-style-type:none;margin-left:10px;\">";
	while ($article = $db->fetch_array($query_article))
	{
		$article_html .= '<li><a href="article.php?id='.$article['id'].'" title="'.$article['title'].'">'.gbsubstr($article['title'], 0, $title_len).'</a></li>';
	}
	$article_html .= "</ul>";
	$tmp->append("LIST", array(
		'id' => $sort['id'],
		'name' => $sort['name'],
		'article' => $article_html,
		));
}

//热门文章列表
$hot_num = 5;
$hot_len = 22;
$sql_article = "select * from ".$db_article." where `show`=1 order by `click` desc, `post_time` desc limit 0,".$hot_num;
$query_article = $db->query($sql_article);
while ($hot = $db->fetch_array($query_article))
{
	$tmp->append("HOT_LIST", array(
		'hot_id' => $hot['id'],
		'hot_title' => $hot['title'],
		'hot_short' => gbsubstr($hot['title'], 0, $hot_len),
		));
}

$tmpH->output();
$tmp->output();
$tmpB->output();
?>
