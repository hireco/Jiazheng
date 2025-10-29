<?php
if (DINHO != 1)
{
	header('HTTP/1.1  404  Not  Found');  
	header("status:  404  Not  Found");  
	exit();
}

$allow = array();

switch($type)
{
case 'employer':  //雇主
	$allow = array(
		'editemployee' => 0, 'doeditemployee' => 0, 'delpic' => 0,
		'editemployer' => 2, 'doeditemployer' => 2, 'editrequirement' => 2, 'doeditrequirement' => 2,
		'editpass' => 2, 'doeditpass' => 2,
		);
	break;
case 'employee':  //雇员
	$allow = array(
		'editemployee' => 2, 'doeditemployee' => 2, 'delpic' => 2,
		'editemployer' => 0, 'doeditemployer' => 0, 'editrequirement' => 0, 'doeditrequirement' => 0,
		'editpass' => 2, 'doeditpass' => 2,
		);
	break;
default:  //无权限
	$allow = array(
		'editemployee' => 0, 'doeditemployee' => 0, 'delpic' => 0,
		'editemployer' => 0, 'doeditemployer' => 0, 'editrequirement' => 0, 'doeditrequirement' => 0,
		'editpass' => 0, 'doeditpass' => 0,
		);
	break;
}

if (!($allow[$a] > 0)) oa_exit("你没有权限执行该操作~~");

if ($a == 'editemployee') //修改雇员资料
{
	$tmp = template("editemployee");
	$sql_employee = "select * from ".$db_employee." where `id`=".$userid;
	$employee = $db->fetch_one_array($sql_employee);
	$degree = $db->fetch_one("select `name` from ".$db_degree." where `id`=".$employee['degree']);
	$area = $db->fetch_one("select `name` from ".$db_area." where `id`=".$employee['area']);
	$tmp->assign(array(
		'name' => $employee['name'],
		'sex' => $employee['sex'],
		'birthyear' => $employee['birthyear'],
		'horoscopes' => $employee['horoscopes'],
		'identifyid' => $employee['identifyid'],
		'hometown' => $employee['hometown'],
		'nation' => $employee['nation'],
		'degree' => $degree,
		'degreeid' => $employee['degree'],
		'telephone' => $employee['telephone'],
		'mobile' => $employee['mobile'],
		'email' => $employee['email'],
		'qq' => $employee['qq'],
		'area' => $area,
		'areaid' => $employee['area'],
		'address' => $employee['address'],
		'salary' => $employee['salary'],
		'experience' => $employee['experience'],
		'marriage' => $employee['marriage'],
		));
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
	//服务地区列表
	$service_area_selected = $employee['service_area'];
	$sql_area = "select * from ".$db_area." where 1 order by `id` asc";
	$query_area = $db->query($sql_area);
	while ($area = $db->fetch_array($query_area))
	{
		$tmp->append("AREA_LIST", array(
			'area_id' => $area['id'],
			'area_name' => $area['name'],
			));
		if (strstr($service_area_selected, ",".$area['name'].","))
		{
			$selected = "selected=\"selected\"";
		}
		else
		{
			$selected = "";
		}
		$tmp->append("SERVICE_AREA_LIST", array(
			'area_id' => $area['id'],
			'area_name' => $area['name'],
			'selected' => $selected,
			));
	}
	//服务项目列表
	$service_seleted = $employee['service'];
	$sql_service = "select * from ".$db_service." where 1 order by `id` asc";
	$query_service = $db->query($sql_service);
	while ($service = $db->fetch_array($query_service))
	{
		if (strstr($service_seleted, ",".$service['name'].","))
		{
			$selected = "selected=\"selected\"";
		}
		else
		{
			$selected = "";
		}
		$tmp->append("SERVICE_LIST", array(
			'service_id' => $service['id'],
			'service_name' => $service['name'],
			'selected' => $selected,
			));
	}
	//语言列表
	$language_selected = $employee['language'];
	$language = array('普通话', '家乡话', '本地话', '其他语言');
	for ($i=0; $i<4; $i++)
	{
		if (strstr($language_selected, ",".$language[$i].","))
		{
			$selected = "selected=\"selected\"";
		}
		else
		{
			$selected = "";
		}
		$tmp->append("LANGUAGE_LIST", array(
			'language_name' => $language[$i],
			'selected' => $selected,
			));
	}
	if (strlen(checkStr($employee['picture'])) >0)
	{
		$imgPath = "attachment/user/";
		$hasphoto = 1;
		$tmp->assign("path", $imgPath.$employee['picture']);
	}
	else
	{
		$hasphoto = 0;
	}
	$tmp->assign('HASPHOTO', $hasphoto);
}
elseif ($a == 'doeditemployee') //执行修改雇员资料
{
	require("admin/class/class_Upload.php");
	$filepath = $_FILES['file']['name'];
	$imgPath = "attachment/user/";
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
		$db->update($db_employee, array(
			'picture' => $uploadpath,
			), "`id`=".$userid);
	}
	$areas = ",";
	foreach($_POST['service_area'] as $area)
	{
		$areas .= ($area.",");
	}
	$services = ",";
	foreach($_POST['service'] as $service)
	{
		$services .= ($service.",");
	}
	$languages = ",";
	foreach($_POST['language'] as $language)
	{
		$languages .= ($language.",");
	}
	$db->update($db_employee, array(
		'name' => checkStr($_POST['name']),
		'sex' => checkStr($_POST['sex']),
		'birthyear' => intval($_POST['birthyear']),
		'horoscopes' => checkStr($_POST['horoscopes']),
		'identifyid' => checkStr($_POST['identifyid']),
		'hometown' => checkStr($_POST['hometown']),
		'nation' => checkStr($_POST['nation']),
		'degree' => $_POST['degree'],
		'telephone' => $_POST['telephone'],
		'mobile' => $_POST['mobile'],
		'email' => checkStr($_POST['email']),
		'qq' => $_POST['qq'],
		'area' => $_POST['area'],
		'address' => checkStr($_POST['address']),
		'service_area' => $areas,
		'salary' => $_POST['salary'],
		'experience' => checkStr($_POST['experience']),
		'language' => $languages,
		'marriage' => $_POST['marriage'],
		'service' => $services,
		'checked' => 0,
		'mod_time' => time(),
		'mod_ip' => getip(),
		), "`id`=".$userid);
	oa_exit("成功修改您的资料，请等待管理员审核", "membercenter.php?j=System&a=main");
}
elseif ($a == 'delpic') //删除个人照片
{
	$imgPath = "attachment/user/";
	$sql = "select `picture` from ".$db_employee." where `id`=".$userid;
	$filepath = $db->fetch_one($sql);
	$db->update($db_employee,array(
		'picture' => "",
		),"`id`=".$userid);
	@unlink ($imgPath.$filepath);
	oa_exit("个人照片删除成功");
}
elseif ($a == 'editemployer') //修改雇主资料
{
	$tmp = template("editemployer");
	$sql_employer = "select * from ".$db_employer." where `id`=".$userid;
	$employer = $db->fetch_one_array($sql_employer);
	//地区列表
	$sql_area = "select * from ".$db_area." where 1 order by `id` asc";
	$query_area = $db->query($sql_area);
	while ($area = $db->fetch_array($query_area))
	{
		$tmp->append("AREA_LIST", array(
			'area_id' => $area['id'],
			'area_name' => $area['name'],
			));
	}
	$area = $db->fetch_one("select `name` from ".$db_area." where `id`=".$employer['area']);
	$tmp->assign(array(
		'name' => $employer['name'],
		'telephone' => $employer['telephone'],
		'mobile' => $employer['mobile'],
		'email' => $employer['email'],
		'qq' => $employer['qq'],
		'area' => $area,
		'areaid' => $employer['area'],
		'area' => $area,
		'address' => $employer['address'],
		));
}
elseif ($a == 'doeditemployer') //执行修改雇主资料
{
	$db->update($db_employer, array(
		'name' => checkStr($_POST['name']),
		'telephone' => $_POST['telephone'],
		'mobile' => $_POST['mobile'],
		'email' => checkStr($_POST['email']),
		'qq' => $_POST['qq'],
		'area' => $_POST['area'],
		'address' => checkStr($_POST['address']),
		'checked' => 0,
		'mod_time' => time(),
		'mod_ip' => getip(),
		), "`id`=".$userid);
	oa_exit("成功修改您的资料，请等待管理员审核", "membercenter.php?j=System&a=main");
}
elseif ($a == 'editrequirement') //修改雇主要求
{
	$tmp = template("editrequirement");
	$sql_employer = "select * from ".$db_employer." where `id`=".$userid;
	$employer = $db->fetch_one_array($sql_employer);
	//服务项目列表
	$service_seleted = $employer['service'];
	$sql_service = "select * from ".$db_service." where 1 order by `id` asc";
	$query_service = $db->query($sql_service);
	while ($service = $db->fetch_array($query_service))
	{
		if (strstr($service_seleted, ",".$service['name'].","))
		{
			$selected = "selected";
		}
		else
		{
			$selected = "";
		}
		$tmp->append("SERVICE_LIST", array(
			'service_id' => $service['id'],
			'service_name' => $service['name'],
			'selected' => $selected,
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
	$yesorno = array('否', '是');
	$ideal_degree = $db->fetch_one("select `name` from ".$db_degree." where `id`=".$employer['ideal_degree']);
	$tmp->assign(array(
		'salary' => $employer['salary'],
		'ideal_degree' => $ideal_degree,
		'ideal_degreeid' => $employer['ideal_degree'],
		'ideal_sex' => $employer['ideal_sex'],
		'ideal_age' => $employer['ideal_age'],
		'homeid' => $employer['home'],
		'home' => $yesorno[$employer['home']],
		'worktime' => $employer['worktime'],
		'requirement' => $employer['requirement'],
		));
}
elseif ($a == 'doeditrequirement') //执行修改雇主要求
{
	$services = ",";
	foreach($_POST['service'] as $service)
	{
		$services .= ($service.",");
	}
	$db->update($db_employer, array(
		'service' => $services,
		'salary' => checkStr($_POST['salary']),
		'ideal_degree' => $_POST['ideal_degree'],
		'ideal_sex' => checkStr($_POST['ideal_sex']),
		'ideal_age' => intval($_POST['ideal_age']),
		'home' => intval($_POST['home']),
		'worktime' => checkStr($_POST['worktime']),
		'requirement' => checkStr($_POST['requirement']),
		'checked' => 0,
		'mod_time' => time(),
		'mod_ip' => getip(),
		), "`id`=".$userid);
	oa_exit("成功修改您的资料，请等待管理员审核", "membercenter.php?j=System&a=main");
}
elseif ($a == 'editpass') //修改密码
{
	$tmp = template("editpass");
}
elseif ($a == 'doeditpass') //执行修改密码
{
	if ($_POST['pass1'] != $_POST['pass2'])
	{
		oa_exit("输入的密码不一致");
	}
	$ori_pass = $_POST['ori_pass'];
	$now_pass = $_POST['pass1'];
	$db_user = ($type == 'employer' ? $db_employer : $db_employee);
	$password = $db->fetch_one("select `password` from ".$db_user." where `id`=".$userid);
	if ($password != md5($ori_pass))
	{
		oa_exit("输入的原密码不正确");
	}
	else
	{
		$db->update($db_user, array(
			'password' => md5($now_pass),
			), "`id`=".$userid);
		if ($using == 'cookie')
		{
			setcookie("password", md5($now_pass));
		}
		elseif ($using == 'session')
		{
			$_SESSION['password'] = md5($now_pass);
		}
		oa_exit("修改密码成功，请重新登陆", "membercenter.php?j=System&a=logout");
	}
}
else
{
	oa_exit("功能不存在");
}
?>
