<?php

$web_title = $db->fetch_one("select `title` from ".$db_config." where `id`=1");
$tmpH->assign("TITLE", $web_title);
$imgPath = "attachment/config/";
$logo = $imgPath.$db->fetch_one("select `logo` from ".$db_config." where `id`=1");
$tmpH->assign("logo", $logo);
$keyword = $db->fetch_one("select `keyword` from ".$db_config." where `id`=1");
$tmpH->assign("keyword", $keyword);
$description = $db->fetch_one("select `description` from ".$db_config." where `id`=1");
$tmpH->assign("description", $description);
$tmpH->assign("url", $url);

//导航条
$sql_nav = "select * from ".$db_nav." where 1";
$query_nav = $db->query($sql_nav);
while ($nav = $db->fetch_array($query_nav))
{
	$tmpH->append("NAV", array(
		'name' => $nav['name'],
		'link' => $nav['link'],
		));
}

//服务列表
$sql_service = "select * from ".$db_service." where 1 order by `id` asc";
$query_service = $db->query($sql_service);
while ($service = $db->fetch_array($query_service))
{
	$tmpH->append("SERVICE_LIST", array(
		'service_id' => $service['id'],
		'service_name' => $service['name'],
		));
}

//地区列表
$sql_area = "select * from ".$db_area." where 1 order by `id` asc";
$query_area = $db->query($sql_area);
while ($area = $db->fetch_array($query_area))
{
	$tmpH->append("AREA_LIST", array(
		'area_id' => $area['id'],
		'area_name' => $area['name'],
		));
}

//学历列表
$sql_degree = "select * from ".$db_degree." where 1 order by `id` asc";
$query_degree = $db->query($sql_degree);
while ($degree = $db->fetch_array($query_degree))
{
	$tmpH->append("DEGREE_LIST", array(
		'degree_id' => $degree['id'],
		'degree_name' => $degree['name'],
		));
}
?>
