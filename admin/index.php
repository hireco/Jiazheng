<?php
error_reporting(7);
include_once('config.php');
include_once('class/cache/menu.php');

if (!isset($_GET['a']))
	$a = "login";
else
	$a = $_GET['a'];

if ($a == "login")
{
	$db_config = "`".$mysql_prefix."config`"; //����Ա���ݱ�
	$tmp = template("login");
	$sql = "select `oaloginverify` from ".$db_config." where 1";
	$oaloginverify = $db->fetch_one($sql);
	if ($oaloginverify == 0)
	{
		session_unregister("authnum");
	}
	$tmp->assign('VERIFY', $oaloginverify);
	$tmp->output();
}
elseif ($a == "dologin")
{
	$db_loginlog = "`".$mysql_prefix."loginlog`"; //��½��¼���ݱ�
	$db_admin = "`".$mysql_prefix."admin`"; //����Ա���ݱ�
	$code = intval($_POST['code']);
	if ($code != $_SESSION['authnum'])
	{
		$Form->oa_exit("��֤�����");
	}
	$username = checkStr($_POST["username"]);
	$password = checkStr($_POST["password"]);
	$result = $usr->login($username, $password);
	if ($result == 1)
	{
		$db->insert($db_loginlog,array(
			'username' => $username,
			'time' => time(),
			'ip' => getip(),
			'result' => 1,
			));
		$sql = "select * from ".$db_admin." where `username`='".$username."'";
		$userL = $db->fetch_one_array($sql);
		$pass_time = $userL['pass_time'];
		$remain = $pass_time + $pass_period - time();
		if ($remain <= 0)
		{
			$usr->active = 0;
			$db->update($db_admin, array(
				'active' => 0,
				), "`username`='{$username}'");
		}
		else
		{
			$day = intval(date("z", $remain));
		}
		if ($usr->active == 0) $Form->oa_exit("��ӭ��{$username},����δ�޸����룬<br/>�������������ѹ��ڣ����޸��������� :(","index.php?a=editpass");
		$Form->oa_exit("��ӭ��{$username},���ѳɹ���¼<br/><br/>���ϴε�¼��ip��".$usr->lastip."<br/>ʱ����".date('Y-m-d H:i:s',$usr->lasttime)."<br/><font color=\"red\"><b>ע�⣺������뽫��".$day."�����ڣ��뼰ʱ��������</b></font><br/>","index.php?a=frame");
	}
	elseif ($result == 0)
	{
		$db->insert($db_loginlog,array(
			'username' => $username,
			'time' => time(),
			'ip' => getip(),
			'result' => 0,
			));
		$Form->oa_exit("��¼ʧ��,�����û����������׼ȷ��");
	}
	elseif ($result == -1)
	{
		$db->insert($db_loginlog,array(
			'username' => $username,
			'time' => time(),
			'ip' => getip(),
			'result' => 0,
			));
		$Form->oa_exit("�Բ�������ʺ��ѹ���");
	}
}
elseif ($a == 'editpass')
{
	if (!$usr->logined) $Form->oa_exit("��û�е�¼ :(","index.php?a=login");
	$active = $db->fetch_one("select `active` from {$db_admin} where `username`='".$usr->username."'");
	if ($active != 0) $Form->oa_exit("���Ѿ��޸Ĺ����� :(","index.php?a=login");
	$tmp = template("oa_editpass");
	$tmp->assign('username', $usr->username);
	$tmp->output();
}
elseif ($a == 'doeditpass')
{
	if (!$usr->logined) $Form->oa_exit("��û�е�¼ :(","index.php?a=login");
	$active = $db->fetch_one("select `active` from {$db_admin} where `username`='".$usr->username."'");
	if ($active != 0) $Form->oa_exit("���Ѿ��޸Ĺ����� :(","index.php?a=login");
	if ($_POST['password'] == $_POST['repassword'])
	{
		if (strlen($_POST['password']) >=6)
		{
			$db->update($db_admin, array(
				'password' => md5($_POST['password']),
				'active' => 1,
				'pass_time' => time(),
			), "`username`='".$usr->username."'");
			$Form->oa_exit("�޸�����ɹ���������������е�¼","index.php?a=login");
		}
		else
		{
			$Form->oa_exit("Ϊ�������ʺŰ�ȫ�����볤�ȱ���>=6");
		}
	}
	else
	{
		$Form->oa_exit("�����������벻һ��~~");
	}
}
elseif ($a == "logout")
{
	$usr->logout();
	$Form->oa_exit("���ѳɹ��˳�ϵͳ,��л���ʹ��","index.php?a=login");
}
elseif ($a == "frame")
{
	if (!$usr->logined) $Form->oa_exit("��û�е�¼ :(","index.php?a=login");
	if ($usr->active != 1) $Form->oa_exit("����δ�޸����룬���޸��������� :(","index.php?a=editpass");
	$tmp = template("frame");
	$tmp->output();
}
elseif ($a == "main")
{
	$os = defined('PHP_OS') ? PHP_OS : 'δ֪';
	if (function_exists('ini_get'))
	{
		$upload = ini_get('file_uploads');
	}
	else
	{
		$upload = get_cfg_var('file_uploads');
	}
	if ($upload)
	{
		$upload="Able";
	}
	else
	{
		$upload="Diable";
	}
	if (function_exists('ini_get'))
	{
		$maxupload = ini_get('upload_max_filesize');
	}
	elseif ($upload) 
	{
		$maxupload = get_cfg_var('upload_max_filesize');
	}
	else
	{
		$maxupload = "Disabled";
	}
	isset($_COOKIE) ? $ifcookie="SUCCESS" : $ifcookie="FAIL";
	if (function_exists('ini_get')){
		$onoff = ini_get('register_globals');
	} else {
		$onoff = get_cfg_var('register_globals');
	}
	if ($onoff){
		$onoff="On";
	}else{
		$onoff="Off";
	}

	$tmp = template("main");
	$tmp->assign(array(
		'serveraddress' => @$_SERVER['SERVER_ADDR'],
		'software' => @$_SERVER["SERVER_SOFTWARE"],
		'OS' => $os,
		'phpversion' => @phpversion(),
		'mysqlversion' => @mysql_get_server_info(),
		'upload' => @$upload,
		'maxupload' => @$maxupload,
		'maxtime' => ini_get('max_execution_time').' seconds',
		'mail' => ini_get('sendmail_path') ? 'Unix Sendmail ( Path: '.ini_get('sendmail_path').')' : ( ini_get('SMTP') ? 'SMTP ( Server: '.ini_get('SMTP').')': 'Disabled' ),
		'cookie' => $ifcookie,
		'register_globals' => @$onoff,
		'timezone' => @date("T",time()),
		'servertime' => gmdate("Y-m-d H:i",time()+$db_timedf*3600),
		));
	$tmp->output();
}
elseif ($a == 'top')
{
	$tmp = template("frame_top");
	$tmp->assign('username',$usr->username);
	$tmp->output();
}
elseif ($a == "info")
{
	echo '<html>
<head>
<meta http-equiv="Content-Type" content="text/html; charset=gb2312">
<title>TopMenu</title>
<LINK href="styles/frame.css" type=text/css rel="stylesheet">
<script type="text/javascript" src="js/menu.js"></script>
</head>
<body class="left_body">
<table border=0 width="100%">';
	foreach($modulename as $k => $v)
	{
		$Menu = "";
		switch($usr->rights[$k])
		{
		case 'S':
			$Menu = $k.'_S';
			break;
		case 'A':
			$Menu = $k.'_A';
			break;
		case 'V':
			$Menu = $k.'_V';
			break;
		case 'M':
			$Menu = $k.'_M';
			break;
		default:
			$Menu = "";
		}
		if ($Menu)
			$Form->makenav($v,$menu[$Menu],strtolower($k));
	}
	echo "</table>";
	$Form->cpfooter();
}
else
{
	$Form->oa_exit("û������Ҫ�Ĺ���ģ��");
}
?>
