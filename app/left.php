<?php
$qualified = array('<font color="red">δ��֤</font>', '����֤');
$top = array('δ�ö�', '<font color="red">���ö�</font>');
$recommended = array('δ�Ƽ�', '<font color="red">���Ƽ�</font>');
$hired = array('δƸ��', '<font color="red">��Ƹ��</font>');
if ($type == "employer") //������ߵĲ˵�
{
	$tmp->assign("EMPLOYER", 1);
	$tmp->assign("EMPLOYEE", 0);
	$sql = "select * from ".$db_employer." where `id`=".$userid;
	$info = $db->fetch_one_array($sql);
	$checked = array('<a href="#" title="����鿴δͨ��ԭ��" onclick="alert(\''.$info['reject_reason'].'\')"><font color="red">δͨ��</font></a>', '��ͨ��');
	$unreadnum = $db->fetch_one("select count(*) from ".$db_reserver." where `did`=".$userid." and `read`=0");
	if ($unreadnum > 0)
	{
		$receive = '<b><a href="membercenter.php?j=Reserve&a=receiver">�յ���ԤԼ('.$unreadnum.')</a></b>';
	}
	else
	{
		$receive = '<a href="membercenter.php?j=Reserve&a=receiver">�յ���ԤԼ</a>';
	}
	$send = '<a href="membercenter.php?j=Reserve&a=sender">������ԤԼ</a>';
	$tmp->assign(array(
		'id' => $userid,
		'type' => "����",
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
elseif ($type == "employee") //��Ա��ߵĲ˵�
{
	$tmp->assign("EMPLOYER", 0);
	$tmp->assign("EMPLOYEE", 1);
	$sql = "select * from ".$db_employee." where `id`=".$userid;
	$info = $db->fetch_one_array($sql);
	$checked = array('<a href="#" title="����鿴δͨ��ԭ��" onclick="alert(\''.$info['reject_reason'].'\')"><font color="red">δͨ��</font></a>', '��ͨ��');
	$unreadnum = $db->fetch_one("select count(*) from ".$db_reservee." where `did`=".$userid." and `read`=0 and `status`=2");
	if ($unreadnum > 0)
	{
		$receive = '<b><a href="membercenter.php?j=Reserve&a=receivee">�յ���ԤԼ('.$unreadnum.')</a></b>';
	}
	else
	{
		$receive = '<a href="membercenter.php?j=Reserve&a=receivee">�յ���ԤԼ</a>';
	}
	$send = '<a href="membercenter.php?j=Reserve&a=sendee">������ԤԼ</a>';
	$tmp->assign(array(
		'id' => $userid,
		'type' => "��Ա",
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
	oa_exit("��������");
}
?>
