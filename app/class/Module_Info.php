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
case 'employer':  //����
	$allow = array(
		'editemployee' => 0, 'doeditemployee' => 0, 'delpic' => 0,
		'editemployer' => 2, 'doeditemployer' => 2, 'editrequirement' => 2, 'doeditrequirement' => 2,
		'editpass' => 2, 'doeditpass' => 2,
		);
	break;
case 'employee':  //��Ա
	$allow = array(
		'editemployee' => 2, 'doeditemployee' => 2, 'delpic' => 2,
		'editemployer' => 0, 'doeditemployer' => 0, 'editrequirement' => 0, 'doeditrequirement' => 0,
		'editpass' => 2, 'doeditpass' => 2,
		);
	break;
default:  //��Ȩ��
	$allow = array(
		'editemployee' => 0, 'doeditemployee' => 0, 'delpic' => 0,
		'editemployer' => 0, 'doeditemployer' => 0, 'editrequirement' => 0, 'doeditrequirement' => 0,
		'editpass' => 0, 'doeditpass' => 0,
		);
	break;
}

if (!($allow[$a] > 0)) oa_exit("��û��Ȩ��ִ�иò���~~");

if ($a == 'editemployee') //�޸Ĺ�Ա����
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
	//ѧ���б�
	$sql_degree = "select * from ".$db_degree." where 1 order by `id` asc";
	$query_degree = $db->query($sql_degree);
	while ($degree = $db->fetch_array($query_degree))
	{
		$tmp->append("DEGREE_LIST", array(
			'degree_id' => $degree['id'],
			'degree_name' => $degree['name'],
			));
	}
	//��������б�
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
	//������Ŀ�б�
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
	//�����б�
	$language_selected = $employee['language'];
	$language = array('��ͨ��', '���绰', '���ػ�', '��������');
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
elseif ($a == 'doeditemployee') //ִ���޸Ĺ�Ա����
{
	require("admin/class/class_Upload.php");
	$filepath = $_FILES['file']['name'];
	$imgPath = "attachment/user/";
	if (strlen($filepath) > 0)
	{
		$upd = new cUpload;
		$filetmp = $_FILES['file']['tmp_name'];
		$filesize = $_FILES['file']['size'];
		if($filesize == 0) $Form->oa_exit("�ļ�������ļ�������");
		$extname = $upd->getext($filepath);
		$uploadpath = M_random(6).date('ydmHis').".".$extname;
		switch($upd->upload($filetmp,$imgPath.$uploadpath))
		{
		case 1:
			oa_exit("�ļ����Ͳ�����");break;
		case 2:
			oa_exit("�ϴ����������������");break;
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
	oa_exit("�ɹ��޸��������ϣ���ȴ�����Ա���", "membercenter.php?j=System&a=main");
}
elseif ($a == 'delpic') //ɾ��������Ƭ
{
	$imgPath = "attachment/user/";
	$sql = "select `picture` from ".$db_employee." where `id`=".$userid;
	$filepath = $db->fetch_one($sql);
	$db->update($db_employee,array(
		'picture' => "",
		),"`id`=".$userid);
	@unlink ($imgPath.$filepath);
	oa_exit("������Ƭɾ���ɹ�");
}
elseif ($a == 'editemployer') //�޸Ĺ�������
{
	$tmp = template("editemployer");
	$sql_employer = "select * from ".$db_employer." where `id`=".$userid;
	$employer = $db->fetch_one_array($sql_employer);
	//�����б�
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
elseif ($a == 'doeditemployer') //ִ���޸Ĺ�������
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
	oa_exit("�ɹ��޸��������ϣ���ȴ�����Ա���", "membercenter.php?j=System&a=main");
}
elseif ($a == 'editrequirement') //�޸Ĺ���Ҫ��
{
	$tmp = template("editrequirement");
	$sql_employer = "select * from ".$db_employer." where `id`=".$userid;
	$employer = $db->fetch_one_array($sql_employer);
	//������Ŀ�б�
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
	//ѧ���б�
	$sql_degree = "select * from ".$db_degree." where 1 order by `id` asc";
	$query_degree = $db->query($sql_degree);
	while ($degree = $db->fetch_array($query_degree))
	{
		$tmp->append("DEGREE_LIST", array(
			'degree_id' => $degree['id'],
			'degree_name' => $degree['name'],
			));
	}
	$yesorno = array('��', '��');
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
elseif ($a == 'doeditrequirement') //ִ���޸Ĺ���Ҫ��
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
	oa_exit("�ɹ��޸��������ϣ���ȴ�����Ա���", "membercenter.php?j=System&a=main");
}
elseif ($a == 'editpass') //�޸�����
{
	$tmp = template("editpass");
}
elseif ($a == 'doeditpass') //ִ���޸�����
{
	if ($_POST['pass1'] != $_POST['pass2'])
	{
		oa_exit("��������벻һ��");
	}
	$ori_pass = $_POST['ori_pass'];
	$now_pass = $_POST['pass1'];
	$db_user = ($type == 'employer' ? $db_employer : $db_employee);
	$password = $db->fetch_one("select `password` from ".$db_user." where `id`=".$userid);
	if ($password != md5($ori_pass))
	{
		oa_exit("�����ԭ���벻��ȷ");
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
		oa_exit("�޸�����ɹ��������µ�½", "membercenter.php?j=System&a=logout");
	}
}
else
{
	oa_exit("���ܲ�����");
}
?>
