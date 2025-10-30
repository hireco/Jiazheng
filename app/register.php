<?php
session_start();
error_reporting(7);
require_once("config.php");

$tmpH = template("header");
$tmpB = template("bottom");

require_once("header.php");
require_once("bottom.php");

$step = (isset($_POST['step']) ? intval($_POST['step']) : 1);
if ($_GET['step'] == 4)
{
	$step = 4;
}

if ($step == 1) //会员协议
{
	$tmp = template("register");
	$sql = "select `reginfo` from ".$db_config." where `id`=1";
	$reginfo = $db->fetch_one($sql);
	$tmp->assign("reginfo", html2str($reginfo));
	$regverify = $db->fetch_one("select `regverify` from ".$db_config." where `id`=1");
	if ($regverify == 0)
	{
		session_unregister("authnum");
		$check_fun = "checkreg1";
	}
	else
	{
		$check_fun = "checkreg2";
	}
	$tmp->assign("VERIFY", $regverify);
	$tmp->assign("check", $check_fun);
}
elseif ($step == 2) //填写信息
{
	$type = $_POST['type'];
	if ($type == "employer") //请家政
	{
		$tmp = template("employerreg2");
	}
	elseif ($type == "employee") //做家政
	{
		$tmp = template("employeereg2");
	}
	else
	{
		oa_exit("参数错误");
	}
	//地区列表
	$sql_area = "select * from ".$db_area." where 1 order by `id` asc";
	$query_area = $db->query($sql_area);
	while ($area = $db->fetch_array($query_area))
	{
		$tmp->append("AREA_LIST", array(
			'area_id' => $area['id'],
			'area_name' => $area['name'],
			));
		$tmp->append("SERVICE_AREA_LIST", array(
			'area_id' => $area['id'],
			'area_name' => $area['name'],
			));
	}
	//服务列表
	$sql_service = "select * from ".$db_service." where 1 order by `id` asc";
	$query_service = $db->query($sql_service);
	while ($service = $db->fetch_array($query_service))
	{
		$tmp->append("SERVICE_LIST", array(
			'service_id' => $service['id'],
			'service_name' => $service['name'],
			));
	}
	//学历列表
	$sql_degree = "select * from ".$db_degree." where 1 order by `id` asc";
	$query_degree = $db->query($sql_degree);
	while ($degree = $db->fetch_array($query_degree))
	{
		$tmp->append("DEGREE_LIST", array(
			'degree_id' => $degree['id'],
			'degree_name' => $degree['name'],
			));
	}
}
elseif ($step == 3) //提交信息
{
	$type = $_POST['type'];
	$username = checkStr($_POST['username']);
	$count1 = $db->fetch_one("select count(*) from ".$db_employee." where `username`='".$username."'");
	$count2 = $db->fetch_one("select count(*) from ".$db_employer." where `username`='".$username."'");
	if ($count1 + $count2 > 0)
	{
		oa_exit("对不起，用户名已经存在");
	}
	if ($type == "employer") //请家政
	{
		$services = ",";
		foreach($_POST['service'] as $service)
		{
			$services .= ($service.",");
		}
		$db->insert($db_employer, array(
			'username' => $username,
			'password' => md5($_POST['password1']),
			'question' => $_POST['question'],
			'answer' => checkStr($_POST['answer']),
			'name' => checkStr($_POST['name']),
			'mobile' => $_POST['mobile'],
			'telephone' => $_POST['telephone'],
			'qq' => $_POST['qq'],
			'email' => $_POST['email'],
			'area' => $_POST['area'],
			'address' => checkStr($_POST['address']),
			'service' => $services,
			'salary' => checkStr($_POST['salary']),
			'ideal_degree' => $_POST['ideal_degree'],
			'ideal_sex' => $_POST['ideal_sex'],
			'ideal_age' => $_POST['ideal_age'],
			'home' => $_POST['home'],
			'worktime' => checkStr($_POST['worktime']),
			'requirement' => checkStr($_POST['requirement']),
			'reg_time' => time(),
			'reg_ip' => getip(),
			'mod_time' => time(),
			'mod_ip' => getip(),
			));
		$id = $db->fetch_one("select `id` from ".$db_employer." where `username`='".$username."'");
		oa_exit("注册成功", "register.php?step=4&type=employer&a=".$id."&b=".strrev(md5($_POST['password1'])));
	}
	elseif ($type == "employee") //做家政
	{
		require("admin/class/class_Upload.php");
		$filepath = $_FILES['file']['name'];
		$imgPath = "attachment/user/";
		$uploadpath = "";
		if (strlen($filepath) > 0)
		{
			$upd = new cUpload;
			$filetmp = $_FILES['file']['tmp_name'];
			$filesize = $_FILES['file']['size'];
			if($filesize == 0) $Form->oa_exit("文件过大或文件不存在");
			$extname = $upd->getext($filepath);
			$uploadpath = M_random(6).date('ydmHis').".".$extname;
			switch($upd->upload($filetmp,$imgPath.$uploadpath))
			{
			case 1:
				oa_exit("文件类型不允许");break;
			case 2:
				oa_exit("上传附件发生意外错误");break;
			default:
			}
		}
		else
		{
			$filepath = "";
		}
		$services = ",";
		foreach($_POST['service'] as $service)
		{
			$services .= ($service.",");
		}
		$areas = ",";
		foreach($_POST['service_area'] as $area)
		{
			$areas .= ($area.",");
		}
		$languages = ",";
		foreach($_POST['language'] as $language)
		{
			$languages .= ($language.",");
		}
		$db->insert($db_employee, array(
			'username' => $username,
			'password' => md5($_POST['password1']),
			'question' => $_POST['question'],
			'answer' => checkStr($_POST['answer']),
			'name' => checkStr($_POST['name']),
			'sex' => $_POST['sex'],
			'birthyear' => intval($_POST['birthyear']),
			'horoscopes' => checkStr($_POST['horoscopes']),
			'identifyid' => checkStr($_POST['identifyid']),
			'hometown' => checkStr($_POST['hometown']),
			'nation' => $_POST['nation'],
			'degree' => $_POST['degree'],
			'mobile' => $_POST['mobile'],
			'telephone' => $_POST['telephone'],
			'email' => $_POST['email'],
			'qq' => $_POST['qq'],
			'area' => $_POST['area'],
			'service_area' => $areas,
			'salary' => $_POST['salary'],
			'experience' => checkStr($_POST['experience']),
			'language' => $languages,
			'marriage' => $_POST['marriage'],
			'address' => checkStr($_POST['address']),
			'service' => $services,
			'picture' => $uploadpath,
			'reg_time' => time(),
			'reg_ip' => getip(),
			'mod_time' => time(),
			'mod_ip' => getip(),
			));
		$id = $db->fetch_one("select `id` from ".$db_employee." where `username`='".$username."'");
		oa_exit("注册成功", "register.php?step=4&type=employee&a=".$id."&b=".strrev(md5($_POST['password1'])));
	}
}
elseif ($step == 4) //注册成功
{
	$tmp = template("register3");
	$type = $_GET['type'];
	$tmp->assign("type", $type);
	$db_user = ($type == "employee" ? $db_employee : $db_employer);
	$password = strrev($_GET['b']);
	if (isset($_COOKIE)) //能使用cookies
	{
		setcookie("userid", $_GET['a']);
		setcookie("password", $password);
		setcookie("type", $type);
	}
	else //只能使用session
	{
		$_SESSION['userid'] = $_GET['a'];
		$_SESSION['password'] = $_GET['b'];
		$_SESSION['type'] = $type;
	}
	$db->update($db_user, array(
		'last_ip' => getip(),
		'last_time' => time(),
		), "`id`=".$_GET['a']);
}
$tmpH->output();
$tmp->output();
$tmpB->output();
?>
