<?php
error_reporting(7);
require_once("config.php");

$tmpH = template("header");
$tmp = template("employeeresume");
$tmpB = template("bottom");

require_once("header.php");
require_once("bottom.php");

$id = intval($_GET['id']);
$employee = $db->fetch_one_array("select * from ".$db_employee." where `id`=".$id);
$db->update($db_employee, array(
	'visit_times' => $employee['visit_times'] + 1,
	), "`id`=".$id);
if (intval($employee['checked'] == 0))
{
	oa_exit("对不起，该雇员信息没有被通过");
}

$imgPath = "attachment/user/";
$ori_width = 120;
$ori_height = 160;
if ($employee['picture'] == "")
{
	if ($employee['sex'] == '女')
		$path = $imgPath."lady.gif";
	else
		$path = $imgPath."man.gif";
}
else
{
	$path = $imgPath.$employee['picture'];
}
$info = getimagesize($path);
$picW = $info[0];
$picH = $info[1];
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

$degree = $db->fetch_one("select `name` from ".$db_degree." where `id`=".$employee['degree']);
$occupied = array('未安排', '已安排');
$hired = array('未聘请', '已聘请');
$year = intval(date("Y", time()));
$hometown = ($employee['hometown'] == "" ? '未填' : $employee['hometown']);
$nation = ($employee['nation'] == "" ? '未填' : $employee['nation']);
$tmp->assign(array(
	'id' => $id,
	'service' => trim(str_replace(',', ' ', $employee['service'])),
	'sex' => $employee['sex'],
	'age' => $year - $employee['birthyear'],
	'horoscopes' => $employee['horoscopes'],
	'hometown' => $hometown,
	'nation' => $nation,
	'degree' => $degree,
	'salary' => $employee['salary'],
	'requirement' => $employee['requirement'],
	'experience' => $employee['experience'],
	'mod_time' => date("Y-m-d", $employee['mod_time']),
	'occupied' => $occupied[$employee['occupied']],
	'hired' => $hired[$employee['company']],
	'photo' => $path,
	'width' => $width,
	'height' => $height,
	));
$tmpH->output();
$tmp->output();
$tmpB->output();
?>
