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
		);
	break;
case 'employee':  //��Ա
	$allow = array(
		);
	break;
default:  //��Ȩ��
	$allow = array(
		);
	break;
}

if (!($allow[$a] > 0)) oa_exit("��û��Ȩ��ִ�иò���~~");

if ($a == '  ')
{
}
else
{
	oa_exit("���ܲ�����");
}
?>
