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
		'main' => 1, 'logout' => 1,
		);
	break;
case 'employee':  //雇员
	$allow = array(
		'main' => 1, 'logout' => 1,
		);
	break;
default:  //无权限
	$allow = array(
		'main' => 0, 'logout' => 0,
		);
	break;
}

if (!($allow[$a] > 0)) oa_exit("你没有权限执行该操作~~");

if ($a == 'main') //主页面
{
	$tmp = template("membercenter");
	$tmp->assign("username", $username);
}
elseif ($a == 'logout') //登出
{
	if ($using == "cookie")
	{
		setcookie("userid", "");
		setcookie("password", "");
		setcookie("type", "");
	}
	elseif ($using == "session")
	{
		session_unregister("userid");
		session_unregister("password");
		session_unregister("type");
	}
	else
	{
		oa_exit("参数错误");
	}
	oa_exit("你已经安全退出", "index.php");
}
else
{
	oa_exit("功能不存在");
}
?>
