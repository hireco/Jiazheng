
<?php
/*
�ҵ����
========
��Ҫ���ࣺconfig.php forms.php class_DataBase.php SmartTemplate
========
��Ҫ���ܣ���$a == ��
editinfo �޸����� doeditinfo ִ���޸�����
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
case 'S':  //��������Ա
case 'A':  //һ������Ա
case 'M':  //��������Ա
	$allow = array(
		'editinfo' => 2, 'doeditinfo' => 2, 
		);
	break;
default:  //����
	$allow = array(
		'editinfo' => 0, 'doeditinfo' => 0, 
		);
	break;
}

if (!($allow[$a] > 0)) $Form->oa_exit("��û��Ȩ��ִ�иò���~~");

if ($a == 'editinfo')  //�޸�����
{
	$sql = "select * from ".$db_admin." where `username`='".$username."'";
	$uL = $db->fetch_one_array($sql);
	$Form->cpheader('�޸�����');
	$Form->formheader(array(
		'title' => "�޸�����",
		'action' => "admin.php?j={$j}&a=doeditinfo"
	));
	$Form->maketd(array('colspan=2' => "<font color=red><b>����Ҫ�޸�����������</b></font>"));
	$Form->makeinput(array(
		'type' => "password",
		'text'  => "ԭ����",
		'name'  => "oldpassword",
		'value'  => "",
	));
	$Form->makeinput(array(
		'type' => "password",
		'text'  => "������",
		'name'  => "password",
		'value'  => "",
	));
	$Form->makeinput(array(
		'type' => "password",
		'text'  => "ȷ��������",
		'name'  => "password2",
		'value'  => "",
	));
	$Form->maketd(array('colspan=2' => "<font color=blue><b>�������û�����ϵ����</b></font>"));
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
		'text'  => "��ע",
		'note'  => "������ϵ��Ϣ",
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
		if ($password != $password2) $Form->oa_exit("�������벻ͬ!");
		$sql = "select `password` from ".$db_admin." where `username`='".$username."'";
		$userpass = $db->fetch_one($sql);
		if ($userpass != md5($oldpass)) $Form->oa_exit("ԭ���벻��ȷ!");
		$updarray['password'] = md5($password) ;
		$updarray['pass_time'] = time();
	}
	$db->update($db_admin,$updarray,"`username`='{$username}'");
	if ($updarray['password'])
	{
		$usr->logout();
		$Form->oa_exit("�޸����ϳɹ�!�����µ�¼","index.php?a=login","_top");
	}
	else
	{
		$Form->oa_exit("�޸����ϳɹ�!","index.php?a=main");
	}
}
else
{
	$Form->oa_exit("���ܲ�����","index.php?a=main");
}
