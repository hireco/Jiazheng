<?php
error_reporting(7);
require_once("config.php");

$tmpH = template("header");
$tmp = template("servicelist");
$tmpB = template("bottom");

require_once("header.php");
require_once("bottom.php");

//分页
$num_in_page = 20;
$sql_num = "select count(*) from ".$db_service." where 1";
$listNum = $db->fetch_one($sql_num);

$cpage = isset($_GET['page']) ? intval($_GET['page']) : 1;
$page_char = page($listNum,$num_in_page,$cpage,"serviceklist.php?");
$limitS = $cpage*$num_in_page-$num_in_page;

//文章列表
$sql_service = "select * from ".$db_service." where 1 order by `id` asc limit ".$limitS.",".$num_in_page;
$query_service = $db->query($sql_service);
while ($service = $db->fetch_array($query_service))
{
	$tmp->append("SERVICE_LIST", array(
		'name' => $service['name'],
		'fee' => $service['fee'],
		'intro' => html2str($service['intro']),
		));
}
$tmp->assign("pagechar", $page_char);

$tmpH->output();
$tmp->output();
$tmpB->output();
?>
