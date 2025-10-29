<?php
error_reporting(7);

require_once("config.php");

$tmpH = template("header");
$tmp = template("article");
$tmpB = template("bottom");

require_once("header.php");
require_once("bottom.php");

//文章显示
$id = intval($_GET['id']);

$sql_article = "select * from ".$db_article." where `id`=".$id;
$article = $db->fetch_one_array($sql_article);

$db->update($db_article, array(
	'click' => $article['click'] + 1,
	), "`id`=".$id);

$tmp->assign(array(
	'id' => $article['id'],
	'title' => $article['title'],
	'source' => $article['source'],
	'author' => $article['author'],
	'click' => $article['click'],
	'content' => $article['content'],
	'date' => date("Y年n月j日", $article['post_time']),
	));

//显示相关文章
$relative_num = 5;
$article_len = 22;
$current_num = 0;
$tags = explode(',', $article['tag']);
foreach ($tags as $tag)
{
	if ($tag != "")
	{
		$sql_num = "select count(*) from ".$db_article." where `tag` like '%,".$tag.",%' and `id`<>".$article['id'];
		$num = $db->fetch_one($sql_num);
		if ($current_num + $num > $relative_num)
		{
			$show_num = $current_num + $num - $relative_num;
			$sql = "select * from ".$db_article." where `tag` like '%,".$tag.",%' and `id`<>".$article['id']." order by `post_time` desc limit 0,".$show_num;
			$query = $db->query($sql);
			while ($relative = $db->fetch_array($query))
			{
				$tmp->append("RELATIVE", array(
					'id' => $relative['id'],
					'title' => $relative['title'],
					'short' => gbsubstr($article['title'], 0, $article_len),
					));
			}
			break;
		}
		else
		{
			$sql = "select * from ".$db_article." where `tag` like '%,".$tag.",%' and `id`<>".$article['id']." order by `post_time` desc";
			$query = $db->query($sql);
			while ($relative = $db->fetch_array($query))
			{
				$tmp->append("RELATIVE", array(
					'id' => $relative['id'],
					'title' => $relative['title'],
					'short' => gbsubstr($article['title'], 0, $article_len),
					));
			}
		}
	}
}
$tmp->assign("COMMENT", $article['comment']);

$comment_num = $db->fetch_one("select count(*) from ".$db_comment." where `aid`=".$id);
$tmp->assign("comment_num", $comment_num);

//最新评论
$comment_num = 10;
$sql_comment = "select * from ".$db_comment." where `aid`=".$article['id']." order by `time` desc limit 0,".$comment_num;
$query_comment = $db->query($sql_comment);
while ($comment = $db->fetch_array($query_comment))
{
	$tmp->append('NEWEST_COMMENT', array(
		'ip' => showip($comment['ip']),
		'content' => $comment['content'],
		));
}

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

$tmpH->output();
$tmp->output();
$tmpB->output();
?>
