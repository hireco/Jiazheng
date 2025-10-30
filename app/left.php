<?php
$qualified = array('<font color="red">未认证</font>', '已认证');
$top = array('未置顶', '<font color="red">已置顶</font>');
$recommended = array('未推荐', '<font color="red">已推荐</font>');
$hired = array('未聘请', '<font color="red">已聘请</font>');
if ($type == "employer") //雇主左边的菜单
{
	$tmp->assign("EMPLOYER", 1);
	$tmp->assign("EMPLOYEE", 0);
	$sql = "select * from ".$db_employer." where `id`=".$userid;
	$info = $db->fetch_one_array($sql);
	$checked = array('<a href="#" title="点击查看未通过原因" onclick="alert(\''.$info['reject_reason'].'\')"><font color="red">未通过</font></a>', '已通过');
	$unreadnum = $db->fetch_one("select count(*) from ".$db_reserver." where `did`=".$userid." and `read`=0");
	if ($unreadnum > 0)
	{
		$receive = '<b><a href="membercenter.php?j=Reserve&a=receiver">收到的预约('.$unreadnum.')</a></b>';
	}
	else
	{
		$receive = '<a href="membercenter.php?j=Reserve&a=receiver">收到的预约</a>';
	}
	$send = '<a href="membercenter.php?j=Reserve&a=sender">发出的预约</a>';
	$tmp->assign(array(
		'id' => $userid,
		'type' => "雇主",
		'checked' => $checked[$info['checked']],
		'reason' => "alert('".$info['reject_reason']."')",
		'top' => $top[$info['top']],
		'visit_times' => $info['visit_times'],
		'visited_times' => $info['visited_times'],
		'reg_time' => date("y-m-d", $info['reg_time']),
		'edit' => "editemployer",
		'receive' => $receive,
		'send' => $send,
		));
}
elseif ($type == "employee") //雇员左边的菜单
{
	$tmp->assign("EMPLOYER", 0);
	$tmp->assign("EMPLOYEE", 1);
	$sql = "select * from ".$db_employee." where `id`=".$userid;
	$info = $db->fetch_one_array($sql);
	$checked = array('<a href="#" title="点击查看未通过原因" onclick="alert(\''.$info['reject_reason'].'\')"><font color="red">未通过</font></a>', '已通过');
	$unreadnum = $db->fetch_one("select count(*) from ".$db_reservee." where `did`=".$userid." and `read`=0 and `status`=2");
	if ($unreadnum > 0)
	{
		$receive = '<b><a href="membercenter.php?j=Reserve&a=receivee">收到的预约('.$unreadnum.')</a></b>';
	}
	else
	{
		$receive = '<a href="membercenter.php?j=Reserve&a=receivee">收到的预约</a>';
	}
	$send = '<a href="membercenter.php?j=Reserve&a=sendee">发出的预约</a>';
	$tmp->assign(array(
		'id' => $userid,
		'type' => "雇员",
		'qualified' => $qualified[$info['qualified']],
		'checked' => $checked[$info['checked']],
		'reason' => "alert('".$info['reject_reason']."')",
		'recommended' => $top[$info['recommended']],
		'hired' => $hired[$info['company']],
		'visit_times' => $info['visit_times'],
		'visited_times' => $info['visited_times'],
		'reg_time' => date("y-m-d", $info['reg_time']),
		'edit' => "editemployee",
		'receive' => $receive,
		'send' => $send,
		));
}
else
{
	oa_exit("参数错误");
}
?>
