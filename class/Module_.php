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
		);
	break;
case 'employee':  //雇员
	$allow = array(
		);
	break;
default:  //无权限
	$allow = array(
		);
	break;
}

if (!($allow[$a] > 0)) oa_exit("你没有权限执行该操作~~");

if ($a == '  ')
{
}
else
{
	oa_exit("功能不存在");
}
?>
