<?php
error_reporting(7);
require_once("config.php");

$tmpH = template("header");
$tmp = template("employeelist");
$tmpB = template("bottom");

require_once("header.php");
require_once("bottom.php");

//分页
$num_in_page = 20;
$sql_num = "select count(*) from ".$db_employee." where `checked`=1 and `recommended`=1";
$listNum = $db->fetch_one($sql_num);

$cpage = isset($_GET['page']) ? intval($_GET['page']) : 1;
$page_char = page($listNum,$num_in_page,$cpage,"employeelist.php?");
$limitS = $cpage*$num_in_page-$num_in_page;

//文章列表
$occupied = array('<font color="red">未安排</font>', '已安排');
$employee_len = 40;
$sql_employee = "select * from ".$db_employee." where `checked`=1 and `recommended`=1 order by 'rec_time' desc, `mod_time` desc limit ".$limitS.",".$num_in_page;
$query_employee = $db->query($sql_employee);
while ($employee = $db->fetch_array($query_employee))
{
	$area = $db->fetch_one("select `name` from ".$db_area." where `id`=".$employee['area']);
	$service = gbsubstr(trim(str_replace(',', ' ', $employee['service'])), 0, $employee_len);
	$tmp->append("EMPLOYEE_LIST", array(
		'id' => $employee['id'],
		'area' => $area,
		'sex' => $employee['sex'],
		'service' => $service,
		'salary' => $employee['salary'],
		'occupied' => $occupied[$employee['occupied']],
		));
}
$tmp->assign("pagechar", $page_char);

$tmpH->output();
$tmp->output();
$tmpB->output();
?>
