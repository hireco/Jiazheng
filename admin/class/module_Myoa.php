
<?php
/*
我的面板
========
需要的类：config.php forms.php class_DataBase.php SmartTemplate
========
主要功能：（$a == ）
editinfo 修改资料 doeditinfo 执行修改资料
==============
Author:Victor_Dinho
E-Mail:dinho.victor@gmail.com
*/
if (DINHO != 1)
{
	header('HTTP/1.1  404  Not  Found');  
	header("status:  404  Not  Found");  
	exit();
}

$allow = array();

switch($usr->rights['Myoa'])
{
case 'S':  //超级管理员
case 'A':  //一级管理员
case 'M':  //二级管理员
	$allow = array(
		'editinfo' => 2, 'doeditinfo' => 2, 
		);
	break;
default:  //其它
	$allow = array(
		'editinfo' => 0, 'doeditinfo' => 0, 
		);
	break;
}

if (!($allow[$a] > 0)) $Form->oa_exit("你没有权限执行该操作~~");

if ($a == 'editinfo')  //修改资料
{
	$sql = "select * from ".$db_admin." where `username`='".$username."'";
	$uL = $db->fetch_one_array($sql);
	$Form->cpheader('修改资料');
	$Form->formheader(array(
		'title' => "修改资料",
		'action' => "admin.php?j={$j}&a=doeditinfo"
	));
	$Form->maketd(array('colspan=2' => "<font color=red><b>不需要修改密码请留空</b></font>"));
	$Form->makeinput(array(
		'type' => "password",
		'text'  => "原密码",
		'name'  => "oldpassword",
		'value'  => "",
	));
	$Form->makeinput(array(
		'type' => "password",
		'text'  => "新密码",
		'name'  => "password",
		'value'  => "",
	));
	$Form->makeinput(array(
		'type' => "password",
		'text'  => "确认新密码",
		'name'  => "password2",
		'value'  => "",
	));
	$Form->maketd(array('colspan=2' => "<font color=blue><b>以下是用户的联系资料</b></font>"));
	$Form->makeinput(array(
		'text'  => "QQ",
		'name'  => "qq",
		'value'  => $uL["qq"],
	));
	$Form->makeinput(array(
		'text'  => "E-mail",
		'name'  => "email",
		'value'  => $uL["email"],
	));
	$Form->maketextarea(array(
		'text'  => "备注",
		'note'  => "其它联系信息",
		'name'  => "other",
		'value'  => html2str($uL["other"]),
	), 0);
	$Form->formfooter();
	$Form->cpfooter();
}
elseif ($a == 'doeditinfo')
{
	$oldpass = checkStr($_POST["oldpassword"]);
	$password = checkStr($_POST["password"]);
	$password2 = $_POST["password2"];
	$updarray = array(
		'qq' => checkStr($_POST['qq']),
		'email' => checkStr($_POST['email']),
		'other' => str2html($_POST['other']),
	);
	if (strlen($password) > 0)
	{
		if ($password != $password2) $Form->oa_exit("两次密码不同!");
		$sql = "select `password` from ".$db_admin." where `username`='".$username."'";
		$userpass = $db->fetch_one($sql);
		if ($userpass != md5($oldpass)) $Form->oa_exit("原密码不正确!");
		$updarray['password'] = md5($password) ;
		$updarray['pass_time'] = time();
	}
	$db->update($db_admin,$updarray,"`username`='{$username}'");
	if ($updarray['password'])
	{
		$usr->logout();
		$Form->oa_exit("修改资料成功!请重新登录","index.php?a=login","_top");
	}
	else
	{
		$Form->oa_exit("修改资料成功!","index.php?a=main");
	}
}
else
{
	$Form->oa_exit("功能不存在","index.php?a=main");
}
