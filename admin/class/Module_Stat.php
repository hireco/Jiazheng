<?php
/*
���Ź���ģ��
========
��Ҫ���ࣺconfig.php forms.php class_DataBase.php SmartTemplate class_User.php
========
��Ҫ���ܣ���$a == ��
--------------------
loginlist ��½��¼�б�	loginclear ��յ�½��¼
adminlist ������¼�б�	adminclear ��ղ�����¼

���ӹ��� (function)
-------------------

����Ȩ�޵�˵��
==============
0 ��ʾ��Ȩִ�иò���
1 ���ݲ������У���ʾ����ִ�иò���(list,edit,attdeleteΪ1ʱֻ�ܲ����Լ���)
2 ��ʾ����ִ�иò���
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
$db_loginlog = "`".$mysql_prefix."loginlog`"; //��½��¼���ݱ�
$db_adminlog = "`".$mysql_prefix."adminlog`"; //������¼���ݱ�
$num_in_page = 20;  //ÿҳ��ʾ��Ŀ

$allow = array();

switch($usr->rights['News'])
{
case 'S':  //��������Ա
	$allow = array(
		'loginlist' => 2, 'loginclear' => 2,
		'adminlist' => 2, 'adminclear' => 2,
		);
	break;
case 'A':  //һ������Ա
	$allow = array(
		'loginlist' => 0, 'loginclear' => 0,
		'adminlist' => 0, 'adminclear' => 0,
		);
	break;
case 'M':  //��������Ա
	$allow = array(
		'loginlist' => 0, 'loginclear' => 0,
		'adminlist' => 0, 'adminclear' => 0,
		);
	break;
default:  //��Ȩ��
	$allow = array(
		'loginlist' => 0, 'loginclear' => 0,
		'adminlist' => 0, 'adminclear' => 0,
		);
	break;
}

if (!($allow[$a] > 0)) $Form->oa_exit("��û��Ȩ��ִ�иò���~~");

if ($a == 'loginlist') //��½��¼�б�
{
	$result = array('<font color=red>ʧ��</font>', '�ɹ�');
	$sql_num = "select count(*) from ".$db_loginlog." where 1";
	$listNum = $db->fetch_one($sql_num);
	$formtitle = "��½��¼ [��".$listNum."��] [{$num_in_page}��/ҳ]";

	$cpage = isset($_GET['page']) ? intval($_GET['page']) : 1;
	$page_char = page($listNum,$num_in_page,$cpage,"admin.php?j=Stat&a=loginlist");
	$limitS = $cpage*$num_in_page-$num_in_page;

	$Form->cpheader();
	$Form->tableheaderbig(array(
		"title" => $formtitle,
		"colspan" => "5",
	));
	echo "<tr align=\"center\">\n";
	echo "<td width=\"20%\"><b>ID</b></td>\n";
	echo "<td width=\"20%\"><b>IP</b></td>\n";
	echo "<td width=\"20%\"><b>�û���</b></td>\n";
	echo "<td width=\"20%\"><b>ʱ��</b></td>\n";
	echo "<td width=\"20%\"><b>���</b></td>\n";
	echo "</tr>\n";
	$lstRequest = "select * from ".$db_loginlog." where 1 order by `time` desc limit ".$limitS.",".$num_in_page;
	$vRe = $db->query($lstRequest);
	while($nL = $db->fetch_array($vRe)) 
	{
		echo "<tr align=\"center\">\n";
		echo "<td>".$nL['id']."</td>\n";
		echo "<td>".$nL['ip']."</td>\n";
		echo "<td>".$nL['username']."</td>\n";
		echo "<td>".date('y-m-d H:i',$nL['time'])."</td>\n";
		echo "<td>".$result[$nL['result']]."</td>\n";
		echo "</tr>\n";
	}
	echo "<tr><td colspan=\"5\" align=\"right\">".$page_char."</td></tr>";
	$Form->formfooter(array(
		"colspan"=>'5',
		"button" => array(
			array('value'=>"��ռ�¼", 'type'=>"button", 'extra' => "onclick=\"goto('admin.php?j=Stat&a=loginclear')\""),
		)));
	$Form->tablefooter(array("colspan" => "5"));
	echo "<script>function goto(url){this.location.replace(url);}</script>";
	$Form->cpfooter();
}
elseif ($a == 'loginclear') //��յ�½��¼
{
	$sql = "truncate table ".$db_loginlog;
	$db->query($sql);
	$Form->oa_exit("��½��¼�Ѿ����", "admin.php?j=Stat&a=loginlist");
}
elseif ($a == 'adminlist') //������¼�б�
{
	$sql_num = "select count(*) from ".$db_adminlog." where 1";
	$listNum = $db->fetch_one($sql_num);
	$formtitle = "������¼ [��".$listNum."��] [{$num_in_page}��/ҳ]";

	$cpage = isset($_GET['page']) ? intval($_GET['page']) : 1;
	$page_char = page($listNum,$num_in_page,$cpage,"admin.php?j=Stat&a=adminlist");
	$limitS = $cpage*$num_in_page-$num_in_page;

	$Form->cpheader();
	$Form->tableheaderbig(array(
		"title" => $formtitle,
		"colspan" => "4",
	));
	echo "<tr align=\"center\">\n";
	echo "<td width=\"10%\"><b>ID</b></td>\n";
	echo "<td width=\"50%\"><b>ҳ��</b></td>\n";
	echo "<td width=\"20%\"><b>IP</b></td>\n";
	echo "<td width=\"29%\"><b>ʱ��</b></td>\n";
	echo "</tr>\n";
	$lstRequest = "select * from ".$db_adminlog." where 1 order by `time` desc limit ".$limitS.",".$num_in_page;
	$vRe = $db->query($lstRequest);
	while($nL = $db->fetch_array($vRe)) 
	{
		echo "<tr align=\"center\">\n";
		echo "<td>".$nL['id']."</td>\n";
		echo "<td>".$nL['script']."</td>\n";
		echo "<td>".$nL['ip']."</td>\n";
		echo "<td>".date('y-m-d H:i',$nL['time'])."</td>\n";
		echo "</tr>\n";
	}
	echo "<tr><td colspan=\"5\" align=\"right\">".$page_char."</td></tr>";
	$Form->formfooter(array(
		"colspan"=>'4',
		"button" => array(
			array('value'=>"��ռ�¼", 'type'=>"button", 'extra' => "onclick=\"goto('admin.php?j=Stat&a=adminclear')\""),
		)));
	$Form->tablefooter(array("colspan" => "4"));
	echo "<script>function goto(url){this.location.replace(url);}</script>";
	$Form->cpfooter();
}
elseif ($a == 'adminclear') //��ղ�����¼
{
	$sql = "truncate table ".$db_adminlog;
	$db->query($sql);
	$Form->oa_exit("��½��¼�Ѿ����", "admin.php?j=Stat&a=adminlist");
}
else
{
	$Form->oa_exit("���ܲ�����","index.php?a=main");
}

?>