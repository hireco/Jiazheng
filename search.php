<?php
error_reporting(7);
require_once("config.php");

$tmpH = template("header");
$tmpB = template("bottom");

require_once("header.php");
require_once("bottom.php");

$type = $_GET['type'];

if ($type == 'employer')
{
	$tmp = template("employerlist");
	$db_user = $db_employer;
}
else
{
	$tmp = template("employeelist");
	$db_user = $db_employee;
}

$info = array(
	'type' => $type,
	'service' => $_GET['service'],
	'area' => $_GET['area'],
	'degree' => $_GET['degree'],
	'age' => $_GET['age'],
	'sex' => $_GET['sex'],
	);
$condition = makecondition($info);
$addlink = makeaddlink($info);

//分页
$num_in_page = 5;
$sql_num = "select count(*) from ".$db_user." where `checked`=1{$condition}";
$listNum = $db->fetch_one($sql_num);

$cpage = isset($_GET['page']) ? intval($_GET['page']) : 1;
$page_char = page($listNum,$num_in_page,$cpage,"search.php?{$addlink}");
$limitS = $cpage*$num_in_page-$num_in_page;

//列表
$occupied = array('<font color="red">未安排</font>', '已安排');
$user_len = 40;
$sql_user = "select * from ".$db_user." where `checked`=1{$condition} order by `mod_time` desc limit ".$limitS.",".$num_in_page;
$query_user = $db->query($sql_user);
if ($type == 'employee')
{
	while ($user = $db->fetch_array($query_user))
	{
		$area = $db->fetch_one("select `name` from ".$db_area." where `id`=".$user['area']);
		$service = gbsubstr(trim(str_replace(',', ' ', $user['service'])), 0, $user_len);
		$tmp->append("EMPLOYEE_LIST", array(
			'id' => $user['id'],
			'area' => $area,
			'sex' => $user['sex'],
			'service' => $service,
			'salary' => $user['salary'],
			'occupied' => $occupied[$user['occupied']],
			));
	}
}
else
{
	while ($user = $db->fetch_array($query_user))
	{
		$area = $db->fetch_one("select `name` from ".$db_area." where `id`=".$user['area']);
		$service = gbsubstr(trim(str_replace(',', ' ', $user['service'])), 0, $user_len);
		$tmp->append("EMPLOYER_LIST", array(
			'id' => $user['id'],
			'area' => $area,
			'ideal_sex' => $user['ideal_sex'],
			'service' => $service,
			'salary' => $user['salary'],
			'occupied' => $occupied[$user['occupied']],
			));
	}
}
$tmp->assign("pagechar", $page_char);

$tmpH->output();
$tmp->output();
$tmpB->output();

function makecondition($arguments = array())
{
	$year = intval(date('Y', time()));
	$condition = "";
	if ($arguments['service'] != "不限")
	{
		$condition .= " and `service` like '%,".$arguments['service'].",%'";
	}
	if ($arguments['area'] != 0)
	{
		$condition .= " and `area`=".$arguments['area'];
	}
	if ($arguments['degree'] != 0)
	{
		$condition .= " and `degree`=".$arguments['degree'];
	}
	$yearbefore = array($year-20, $year-30, $year-40, $year-50, $year-60);
	if ($arguments['type'] == "employee")
	{
		switch ($arguments['age'])
		{
			case 0:
				break;
			case 1:
				$condition .= " and `birthyear`>".$yearbefore[0];
				break;
			case 2:
				$condition .= " and `birthyear`<=".$yearbefore[0];
				$condition .= " and `birthyear`>".$yearbefore[1];
				break;
			case 3:
				$condition .= " and `birthyear`<=".$yearbefore[1];
				$condition .= " and `birthyear`>".$yearbefore[2];
				break;
			case 4:
				$condition .= " and `birthyear`<=".$yearbefore[2];
				$condition .= " and `birthyear`>".$yearbefore[3];
				break;
			case 5:
				$condition .= " and `birthyear`<=".$yearbefore[3];
				$condition .= " and `birthyear`>".$yearbefore[4];
				break;
			case 6:
				$condition .= " and `birthyear`<=".$yearbefore[4];
				break;
			default:
				$condition .= " and 0";
		}
		if ($arguments['sex'] != "不限")
		{
			$condition .= " and `sex`='".$arguments['sex']."'";
		}
	}
	return $condition;
}

function makeaddlink($arguments = array())
{
	$addlink = "";
	$addlink .= "type=".$arguments['type'];
	$addlink .= "&service=".$arguments['service'];
	$addlink .= "&area=".$arguments['area'];
	$addlink .= "&degree=".$arguments['degree'];
	$addlink .= "&age=".$arguments['age'];
	$addlink .= "&sex=".$arguments['sex'];
	return $addlink;
}

?>
