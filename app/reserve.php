<?php
error_reporting(7);
require_once("config.php");

$tmpH = template("header");
$tmpB = template("bottom");

require_once("header.php");
require_once("bottom.php");
require_once("checklogin.php");

$step = (isset($_POST['step']) ? intval($_POST['step']) : 1);
if ($step == 1)
{
	$did = intval($_POST['id']);
	$dtype = $_POST['type'];
	if ($dtype == $type)
	{
		oa_exit("不能雇主预约雇主或者雇员预约雇员");
	}
	if ($logined == 0 && $dtype == "employer")
	{
		oa_exit("请登陆后再预约");
	}
	if ($logined == 1 && $type == 'employee')
	{
		if (!isset($_COOKIE[$did]))
		{
			setcookie($did, $did, time()+3600);
		}
		else
		{
			oa_exit("对不起，不能在一个小时之内预约同一个人");
		}
		$db->insert($db_reserver, array(
			'sid' => $userid,
			'did' => $did,
			'date' => time(),
			'ip' => getip(),
			'status' => 0,
			'read' => 0,
			));
		oa_exit("已成功预约");
	}
	if ($logined == 0 && $dtype == "employee")
	{
		if (isset($_COOKIE[$did]))
		{
			oa_exit("对不起，不能在一个小时之内预约同一个人");
		}
		$tmp = template("reserveunlogined");
		$sql_area = "select * from ".$db_area." where 1 order by `id` asc";
		$query_area = $db->query($sql_area);
		while ($area = $db->fetch_array($query_area))
		{
			$tmp->append("AREA_LIST", array(
				'area_id' => $area['id'],
				'area_name' => $area['name'],
				));
		}
		$sql_service = "select * from ".$db_service." where 1 order by `id` asc";
		$query_service = $db->query($sql_service);
		while ($service = $db->fetch_array($query_service))
		{
			$tmp->append("SERVICE_LIST", array(
				'service_id' => $service['id'],
				'service_name' => $service['name'],
				));
		}
		$tmp->assign("did", $did);
		$tmpH->output();
		$tmp->output();
		$tmpB->output();
	}
	if ($logined == 1 && $type == 'employer')
	{
		if (isset($_COOKIE[$did]))
		{
			oa_exit("对不起，不能在一个小时之内预约同一个人");
		}
		$tmp = template("reservelogined");
		$source = $db->fetch_one_array("select * from ".$db_employer." where `id`=".$userid);
		$area = $db->fetch_one("select `name` from ".$db_area." where `id`=".$source['area']);
		$tmp->assign(array(
			'did' => $did,
			'sid' => $userid,
			'telephone' => $source['telephone'],
			'mobile' => $source['mobile'],
			'email' => $source['email'],
			'qq' => $source['qq'],
			'area' => $area,
			'areaid' => $source['area'],
			'address' => $source['address'],
			'service' => trim(str_replace(',', ' ', $source['service'])),
			'service_all' => $source['service'],
			));
		$tmpH->output();
		$tmp->output();
		$tmpB->output();
	}
}
elseif ($step == 2)
{
	$did = intval($_POST['did']);
	if (!isset($_COOKIE[$did]))
	{
		setcookie($did, $did, time()+3600);
	}
	else
	{
		oa_exit("对不起，不能在一个小时之内预约同一个人");
	}
	if ($logined == 1)
	{
		$sid = $userid;
		$sname = "";
		$area = $_POST['areaid'];
		$services = $_POST['service_all'];
	}
	else
	{
		$sid = 0;
		$sname = $_POST['sname'];
		$area = $_POST['area'];
		$services = ",";
		foreach($_POST['service'] as $service)
		{
			$services .= ($service.",");
		}
	}
	$db->insert($db_reservee, array(
		'did' => intval($_POST['did']),
		'sid' => $sid,
		'sname' => $sname,
		'telephone' => $_POST['telephone'],
		'mobile' => $_POST['mobile'],
		'qq' => $_POST['qq'],
		'area' => $area,
		'address' => $_POST['address'],
		'service' => $services,
		'ip' => getip(),
		'date' => time(),
		));
	oa_exit("已成功预约", "employeeresume.php?id=".intval($_POST['did']));
}
else
{
	oa_exit("参数错误");
}
?>
