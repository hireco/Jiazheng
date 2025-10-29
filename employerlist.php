<?php
error_reporting(7);
require_once("config.php");

$tmpH = template("header");
$tmp = template("employerlist");
$tmpB = template("bottom");

require_once("header.php");
require_once("bottom.php");

//分页
$num_in_page = 20;
$sql_num = "select count(*) from ".$db_employer." where `checked`=1";
$listNum = $db->fetch_one($sql_num);

$cpage = isset($_GET['page']) ? intval($_GET['page']) : 1;
$page_char = page($listNum,$num_in_page,$cpage,"employerlist.php?");
$limitS = $cpage*$num_in_page-$num_in_page;

//列表
$occupied = array('<font color="red">未安排</font>', '已安排');
$employer_len = 40;
$sql_employer = "select * from ".$db_employer." where `checked`=1 order by `mod_time` desc limit ".$limitS.",".$num_in_page;
$query_employer = $db->query($sql_employer);
while ($employer = $db->fetch_array($query_employer))
{
	$area = $db->fetch_one("select `name` from ".$db_area." where `id`=".$employer['area']);
	$service = gbsubstr(trim(str_replace(',', ' ', $employer['service'])), 0, $employer_len);
	$tmp->append("EMPLOYER_LIST", array(
		'id' => $employer['id'],
		'area' => $area,
		'ideal_sex' => $employer['ideal_sex'],
		'service' => $service,
		'salary' => $employer['salary'],
		'occupied' => $occupied[$employer['occupied']],
		));
}
$tmp->assign("pagechar", $page_char);

$tmpH->output();
$tmp->output();
$tmpB->output();
?>
