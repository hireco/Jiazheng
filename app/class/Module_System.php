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
		'main' => 1, 'logout' => 1,
		);
	break;
case 'employee':  //��Ա
	$allow = array(
		'main' => 1, 'logout' => 1,
		);
	break;
default:  //��Ȩ��
	$allow = array(
		'main' => 0, 'logout' => 0,
		);
	break;
}

if (!($allow[$a] > 0)) oa_exit("��û��Ȩ��ִ�иò���~~");

if ($a == 'main') //��ҳ��
{
	$tmp = template("membercenter");
	$tmp->assign("username", $username);
}
elseif ($a == 'logout') //�ǳ�
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
		oa_exit("��������");
	}
	oa_exit("���Ѿ���ȫ�˳�", "index.php");
}
else
{
	oa_exit("���ܲ�����");
}
?>
