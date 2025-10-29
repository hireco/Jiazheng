<?php
error_reporting(7);
require_once("config.php");

$tmpH = template("header");
$tmp = template("employerresume");
$tmpB = template("bottom");

require_once("header.php");
require_once("bottom.php");

$id = intval($_GET['id']);
$employer = $db->fetch_one_array("select * from ".$db_employer." where `id`=".$id);
$db->update($db_employer, array(
	'visited_times' => $employer['visited_times'] + 1,
	), "`id`=".$id);
if (intval($employer['checked'] == 0))
{
	oa_exit("对不起，该雇主信息没有被通过");
}
$yesorno = array('否', '是');
$ideal_degree = $db->fetch_one("select `name` from ".$db_degree." where `id`=".$employer['ideal_degree']);
$occupied = array('未安排', '已安排');
$tmp->assign(array(
	'id' => $id,
	'service' => trim(str_replace(',', ' ', $employer['service'])),
	'ideal_sex' => $employer['ideal_sex'],
	'ideal_age' => $employer['ideal_age'],
	'ideal_degree' => $ideal_degree,
	'salary' => $employer['salary'],
	'home' => $yesorno[$employer['home']],
	'worktime' => $employer['worktime'],
	'requirement' => $employer['requirement'],
	'mod_time' => date("Y-m-d", $employer['mod_time']),
	'occupied' => $occupied[$employer['occupied']],
	));
$tmpH->output();
$tmp->output();
$tmpB->output();
?>
