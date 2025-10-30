<?php
if (DINHO != 1)
{
	header('HTTP/1.1  404  Not  Found');  
	header("status:  404  Not  Found");  
	exit();
}

$num_in_page = 20;

$allow = array();

switch($type)
{
case 'employer':  //����
	$allow = array(
		'receivee' => 0, 'sendee' => 0, 'viewreceivee' => 0,
		'receiver' => 1, 'sender' => 1,
		);
	break;
case 'employee':  //��Ա
	$allow = array(
		'receivee' => 1, 'sendee' => 1, 'viewreceivee' => 1,
		'receiver' => 0, 'sender' => 0,
		);
	break;
default:  //��Ȩ��
	$allow = array(
		'receivee' => 0, 'sendee' => 0, 'viewreceivee' => 0,
		'receiver' => 0, 'sender' => 0,
		);
	break;
}

if (!($allow[$a] > 0)) oa_exit("��û��Ȩ��ִ�иò���~~");

if ($a == 'receivee') //��Ա�յ���Ϣ�б�
{
	$tmp = template("receivee");
	$service_len = 20;
	//��Ϣ��ҳ
	$sql_num = "select count(*) from ".$db_reservee." where `status`=2 and `did`=".$userid;
	$listNum = $db->fetch_one($sql_num);

	$cpage = isset($_GET['page']) ? intval($_GET['page']) : 1;
	$page_char = page($listNum,$num_in_page,$cpage,"membercenter.php?a=Reserve&j=receivee");
	$limitS = $cpage*$num_in_page-$num_in_page;

	//��Ϣ�б�
	$sql_receivee = "select * from ".$db_reservee." where `status`=2 and `did`=".$userid." order by `date` desc limit ".$limitS.",".$num_in_page;
	$query_receivee = $db->query($sql_receivee);
	while ($receivee = $db->fetch_array($query_receivee))
	{
		if ($receivee['sid'] == 0)
		{
			$source = '<a href="membercenter.php?j=Reserve&a=viewreceivee&id='.$receivee['id'].'" target="_blank">'.$receivee['sname'].'</a>';
		}
		else
		{
			$source = '<a href="employerresume.php?id='.$receivee['sid'].'" target="_blank" onclick="window.open(\'updateread.php?type=reservee&id='.$receivee['id'].'\', \'hidden_frame\', \'height=0, width=0, top=0, left=0, toolbar=no, menubar=no, scrollbars=no, resizable=no,location=no, status=no\')">'.$receivee['sid'].'</a>';
		}
		if ($receivee['read'] == 0)
		{
			$tmp->append("RESERVE_LIST", array(
				'id' => $receivee['id'],
				'source' => "<b>".$source."</b>",
				'snote' => "<b>".$receivee['snote']."</b>",
				'date' => "<b>".date('y-m-d', $receivee['date'])."</b>",
				));
		}
		else
		{
			$tmp->append("RESERVE_LIST", array(
				'id' => $receivee['id'],
				'source' => $source,
				'snote' => $receivee['snote'],
				'date' => date('y-m-d', $receivee['date']),
				));
		}
	}
	$tmp->assign("pagechar", $page_char);
}
elseif ($a == 'receiver') //�����յ���Ϣ�б�
{
	$tmp = template("receiver");
	$service_len = 20;
	//��Ϣ��ҳ
	$sql_num = "select count(*) from ".$db_reserver." where `status`=2 and `did`=".$userid;
	$listNum = $db->fetch_one($sql_num);

	$cpage = isset($_GET['page']) ? intval($_GET['page']) : 1;
	$page_char = page($listNum,$num_in_page,$cpage,"membercenter.php?a=Reserve&j=receiver");
	$limitS = $cpage*$num_in_page-$num_in_page;

	//��Ϣ�б�
	$sql_receiver = "select * from ".$db_reserver." where `status`=2 and `did`=".$userid." order by `date` desc limit ".$limitS.",".$num_in_page;
	$query_receiver = $db->query($sql_receiver);
	while ($receiver = $db->fetch_array($query_receiver))
	{
		if ($receiver['read'] == 0)
		{
			$tmp->append("RESERVE_LIST", array(
				'id' => $receiver['id'],
				'source' => '<b><a href="employeeresume.php?id='.$receiver['sid'].'" target="_blank" onclick="window.open(\'updateread.php?type=reserver&id='.$receiver['id'].'\', \'hidden_frame\', \'height=0, width=0, top=0, left=0, toolbar=no, menubar=no, scrollbars=no, resizable=no,location=no, status=no\')">'.$receiver['sid'].'</a></b>',
				'snote' => '<b>'.$receiverp['snote'].'</b>',
				'date' => '<b>'.date('y-m-d', $receiver['date']).'</b>',
				));
		}
		else
		{
			$tmp->append("RESERVE_LIST", array(
				'id' => $receiver['id'],
				'source' => '<a href="employeeresume.php?id='.$receiver['sid'].'" target="_blank">'.$receiver['sid'].'</a>',
				'snote' => $receiverp['snote'],
				'date' => date('y-m-d', $receiver['date']),
				));
		}
	}
	$tmp->assign("pagechar", $page_char);
}
elseif ($a == 'sendee') //��Ա������Ϣ�б�
{
	$tmp = template("sendee");
	$service_len = 20;
	//��Ϣ��ҳ
	$sql_num = "select count(*) from ".$db_reserver." where `sid`=".$userid;
	$listNum = $db->fetch_one($sql_num);

	$cpage = isset($_GET['page']) ? intval($_GET['page']) : 1;
	$page_char = page($listNum,$num_in_page,$cpage,"membercenter.php?a=Reserve&j=sendee");
	$limitS = $cpage*$num_in_page-$num_in_page;

	//��Ϣ�б�
	$sql_sendee = "select * from ".$db_reserver." where `sid`=".$userid." order by `date` desc limit ".$limitS.",".$num_in_page;
	$query_sendee = $db->query($sql_sendee);
	while ($sendee = $db->fetch_array($query_sendee))
	{
		$status = array('<font color="red">δ��</font>', '�˻�', '<font color="green">ͨ��</font>');
		$tmp->append("RESERVE_LIST", array(
			'id' => $sendee['id'],
			'status' => $status[$sendee['status']],
			'did' => '<a href="employerresume.php?id='.$sendee['did'].'" target="_blank">'.$sendee['did'].'</a>',
			'note' => $sendee['note'],
			'date' => date('y-m-d', $sendee['date']),
			));
	}
	$tmp->assign("pagechar", $page_char);
}
elseif ($a == 'sender') //����������Ϣ�б�
{
	$tmp = template("sender");
	$service_len = 20;
	//��Ϣ��ҳ
	$sql_num = "select count(*) from ".$db_reservee." where `sid`=".$userid;
	$listNum = $db->fetch_one($sql_num);

	$cpage = isset($_GET['page']) ? intval($_GET['page']) : 1;
	$page_char = page($listNum,$num_in_page,$cpage,"membercenter.php?a=Reserve&j=sender");
	$limitS = $cpage*$num_in_page-$num_in_page;

	//��Ϣ�б�
	$sql_sender = "select * from ".$db_reservee." where  `sid`=".$userid." order by `date` desc limit ".$limitS.",".$num_in_page;
	$query_sender = $db->query($sql_sender);
	while ($sender = $db->fetch_array($query_sender))
	{
		$status = array('<font color="red">δ��</font>', '�˻�', '<font color="green">ͨ��</font>');
		$tmp->append("RESERVE_LIST", array(
			'id' => $sender['id'],
			'status' => $status[$sender['status']],
			'did' => '<a href="employeeresume.php?id='.$sender['did'].'" target="_blank">'.$sender['did'].'</a>',
			'note' => $sender['note'],
			'date' => date('y-m-d', $sender['date']),
			));
	}
	$tmp->assign("pagechar", $page_char);
}
elseif ($a == 'viewreceivee') //��Ա�鿴�յ���Ϣ
{
	$tmp = template("viewreceivee");
	$id = intval($_GET['id']);
	$sql_receivee = "select * from ".$db_reservee." where `id`=".$id;
	$receivee = $db->fetch_one_array($sql_receivee);
	$area = $db->fetch_one("select `name` from ".$db_area." where `id`=".$receivee['area']);
	$tmp->assign(array(
		'id' => $receivee['id'],
		'sname' => $receivee['sname'],
		'area' => $area,
		'service' => $receivee['service'],
		'date' => date('m-d', $receivee['date']),
		));
	$db->update($db_reservee, array(
		'read' => 1,
		), "`id`=".$id);
}
else
{
	oa_exit("���ܲ�����");
}
?>
