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
	$db_config = "`".$mysql_prefix."config`"; //管理员数据表
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
	$db_loginlog = "`".$mysql_prefix."loginlog`"; //登陆记录数据表
	$db_admin = "`".$mysql_prefix."admin`"; //管理员数据表
	$code = intval($_POST['code']);
	if ($code != $_SESSION['authnum'])
	{
		$Form->oa_exit("验证码错误");
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
		if ($usr->active == 0) $Form->oa_exit("欢迎你{$username},您还未修改密码，<br/>或者您的密码已过期，请修改您的密码 :(","index.php?a=editpass");
		$Form->oa_exit("欢迎你{$username},你已成功登录<br/><br/>你上次登录的ip是".$usr->lastip."<br/>时间是".date('Y-m-d H:i:s',$usr->lasttime)."<br/><font color=\"red\"><b>注意：你的密码将在".$day."天后过期，请及时更改密码</b></font><br/>","index.php?a=frame");
	}
	elseif ($result == 0)
	{
		$db->insert($db_loginlog,array(
			'username' => $username,
			'time' => time(),
			'ip' => getip(),
			'result' => 0,
			));
		$Form->oa_exit("登录失败,请检查用户名及密码的准确性");
	}
	elseif ($result == -1)
	{
		$db->insert($db_loginlog,array(
			'username' => $username,
			'time' => time(),
			'ip' => getip(),
			'result' => 0,
			));
		$Form->oa_exit("对不起，你的帐号已过期");
	}
}
elseif ($a == 'editpass')
{
	if (!$usr->logined) $Form->oa_exit("还没有登录 :(","index.php?a=login");
	$active = $db->fetch_one("select `active` from {$db_admin} where `username`='".$usr->username."'");
	if ($active != 0) $Form->oa_exit("您已经修改过密码 :(","index.php?a=login");
	$tmp = template("oa_editpass");
	$tmp->assign('username', $usr->username);
	$tmp->output();
}
elseif ($a == 'doeditpass')
{
	if (!$usr->logined) $Form->oa_exit("还没有登录 :(","index.php?a=login");
	$active = $db->fetch_one("select `active` from {$db_admin} where `username`='".$usr->username."'");
	if ($active != 0) $Form->oa_exit("您已经修改过密码 :(","index.php?a=login");
	if ($_POST['password'] == $_POST['repassword'])
	{
		if (strlen($_POST['password']) >=6)
		{
			$db->update($db_admin, array(
				'password' => md5($_POST['password']),
				'active' => 1,
				'pass_time' => time(),
			), "`username`='".$usr->username."'");
			$Form->oa_exit("修改密码成功，请用新密码进行登录","index.php?a=login");
		}
		else
		{
			$Form->oa_exit("为了您的帐号安全，密码长度必须>=6");
		}
	}
	else
	{
		$Form->oa_exit("两次密码输入不一样~~");
	}
}
elseif ($a == "logout")
{
	$usr->logout();
	$Form->oa_exit("你已成功退出系统,感谢你的使用","index.php?a=login");
}
elseif ($a == "frame")
{
	if (!$usr->logined) $Form->oa_exit("还没有登录 :(","index.php?a=login");
	if ($usr->active != 1) $Form->oa_exit("您还未修改密码，请修改您的密码 :(","index.php?a=editpass");
	$tmp = template("frame");
	$tmp->output();
}
elseif ($a == "main")
{
	$os = defined('PHP_OS') ? PHP_OS : '未知';
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
	$Form->oa_exit("没有所需要的功能模块");
}
?>
