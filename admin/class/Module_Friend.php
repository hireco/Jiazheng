<?php
/*
���Ź���ģ��
========
��Ҫ���ࣺconfig.php forms.php class_DataBase.php SmartTemplate class_User.php
========
��Ҫ���ܣ���$a == ��
--------------------
list ���������б�	check �༭��������	docheck	ִ�б༭��������	del	ɾ����������

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
$db_friend = "`".$mysql_prefix."friend`"; //�����������ݱ�
$num_in_page = 20;  //ÿҳ��ʾ��Ŀ

$allow = array();

switch($usr->rights['Friend'])
{
case 'S':  //��������Ա
	$allow = array(
		'list' => 2, 'check' => 2, 'docheck' => 2, 'del' => 2,
		);
	break;
case 'A':  //һ������Ա
	$allow = array(
		'list' => 2, 'check' => 2, 'docheck' => 2, 'del' => 2,
		);
	break;
case 'M':  //��������Ա
	$allow = array(
		'list' => 0, 'check' => 0, 'docheck' => 0, 'del' => 0,
		);
	break;
default:  //��Ȩ��
	$allow = array(
		'list' => 0, 'check' => 0, 'docheck' => 0, 'del' => 0,
		);
	break;
}

if (!($allow[$a] > 0)) $Form->oa_exit("��û��Ȩ��ִ�иò���~~");

if ($a == 'list') //���������б�
{
	$top = array('', '<font color=red>Yes</a>');
	$status = array('<font color=red>δ��</font>', '<font color=green>ͨ��</font>');
	$type = array('����', 'LOGO');

	$sql_num = "select count(*) from ".$db_friend." where 1";

	$listNum = $db->fetch_one($sql_num);
	$formtitle = "�������� [��".$listNum."��] [{$num_in_page}��/ҳ]";

	$cpage = isset($_GET['page']) ? intval($_GET['page']) : 1;
	$page_char = page($listNum,$num_in_page,$cpage,"admin.php?j=Friend&a=list");
	$limitS = $cpage*$num_in_page-$num_in_page;

	$Form->cpheader();
	if($listNum > 0)
	{
		$Form->tableheaderbig(array(
			"title" => $formtitle,
			"colspan" => "8",
		));
		echo "<tr align=\"center\">\n";
		echo "<td width=\"6%\"><b>�ö�</b></td>\n";
		echo "<td width=\"9%\"><b>״̬</b></td>\n";
		echo "<td width=\"10%\"><b>����</b></td>\n";
		echo "<td width=\"25%\"><b>��վ����</b></td>\n";
		echo "<td width=\"15%\"><b>IP</b></td>\n";
		echo "<td width=\"15%\"><b>ʱ��</b></td>\n";
		echo "<td width=\"20%\"><b>����</b></td>\n";
		echo "</tr>\n";
		$lstRequest = "select * from ".$db_friend." where 1 order by `top` desc, `time` desc limit ".$limitS.",".$num_in_page;
		$vRe = $db->query($lstRequest);
		while($nL = $db->fetch_array($vRe)) 
		{
			echo "<tr align=\"center\">\n";
			echo "<td>".$top[$nL['top']]."</td>\n";
			echo "<td>".$status[$nL['status']]."</td>\n";
			echo "<td>".$type[$nL['type']]."</td>\n";
			echo "<td>".$nL['title']."</td>\n";
			echo "<td>".$nL['ip']."</td>\n";
			echo "<td>".date('y-m-d H:i',$nL['time'])."</td>\n";
			echo "<td align=\"center\"><a href=\"admin.php?j=Friend&a=check&id=".$nL['id']."\">����</a> <a href=\"admin.php?j=Friend&a=del&id=".$nL['id']."\">ɾ��</a></td>\n";
			echo "</tr>\n";
		}
		echo "<tr><td colspan=\"7\" align=\"right\">".$page_char."</td></tr>";
		$Form->tablefooter(array("colspan" => "7"));
	}
	else
	{
		$Form->tableheaderbig(array("title" => $formtitle,));
		$Form->maketd(array("��ʱû����������~~"));
		$Form->tablefooter();
	}
	$Form->cpfooter();
}
elseif ($a == 'check') 
{
	$id = intval($_GET['id']);
	$type = array('��������', 'LOGO����');
	$sql_friend = "select * from ".$db_friend." where `id`='".$id."'";
	$nL = $db->fetch_one_array($sql_friend);
	if (empty($nL)) $Form->oa_exit("���������Ӳ�����");
	$Form->cpheader("������������");
	$Form->formheader(array(
		'title' => "������������",
		'method' => "POST",
		'action' => "admin.php?j=Friend&a=docheck",
		));
	$Form->makehidden(array(
		'name' => "id",
		'value' => $id
		));
	$Form->maketd(array(
		"<b>����</b>",
		$type[$nL['type']],
		));
	$Form->maketd(array(
		"<b>��վ����</b>",
		$nL['title'],
		));
	if ($nL['type'] == 1)
	{
		$Form->maketd(array(
		"<b>��վLOGO</b>",
		"<img src=\"".$nL['pic']."\" width=\"90px\" height=\"34px\" />",
		));
	}
	$Form->maketd(array(
		"<b>��վ����</b>",
		"<a href=\"".$nL['link']."\" target=\"_blank\">".$nL['link']."</a>",
		));
	$Form->maketd(array(
		"<b>��վ���</b>",
		$nL['intro'],
		));
	$Form->maketd(array(
		"<b>��վ����Ա</b>",
		$nL['name'],
		));
	$Form->maketd(array(
		"<b>����Ա����</b>",
		$nL['email'],
		));
	$Form->makeselect(array(
		'option' => array('����', 'ͨ��'),
		'text' => "����",
		'name' => "state",
		'selected' => $nL['status']));
	$Form->makeselect(array(
		'option' => array('���ö�', '�ö�'),
		'text' => "�ö�",
		'name' => "top",
		'selected' => $nL['top']));
	$Form->formfooter(array(
		"button" => array(
			array('value'=>"ȷ��"),
			array('value'=>"ɾ��",'type'=>"button",'extra' => "onclick=\"goto('admin.php?j=Friend&a=del&id={$id}')\""),
			array('value'=>"����", 'type'=>"button", 'extra' => "onclick=\"goto('admin.php?j=Friend&a=list')\""),
		)));
	echo "<script>function goto(url){this.location.replace(url);}</script>";
	$Form->cpfooter();
}
elseif ($a == 'docheck') //ִ��������������
{
	if (!isset($_POST['id'])) $Form->oa_exit("��������");
	$id = intval($_POST['id']);

	$sql_friend = "select count(*) from ".$db_friend." where `id`='".$id."'";
	if ($db->fetch_one($sql_friend)==0) $Form->oa_exit("�������Ӳ�����");

	$db->update($db_friend,array(
		'status' => intval($_POST['state']),
		'top' => intval($_POST['top']),
		'checker' => $username,
		'checkip' => getip(),
		),"`id`={$id}");
	$Form->oa_exit("ԤԼ�����ɹ�","admin.php?j=Friend&a=list");
}
elseif ($a == 'del') //ɾ����������
{
	$id = intval($_GET['id']);
	$sql = "select count(*) from ".$db_friend." where `id`='".$id."'";
	$num = $db->fetch_one($sql);
	
	if (!($num)) $Form->oa_exit("���������Ӳ�����");

	$db->query("delete from ".$db_friend." where `id`='".$id."'");
	$Form->oa_exit("ɾ���������ӳɹ�!","admin.php?j=Friend&a=list");
}
else
{
	$Form->oa_exit("���ܲ�����","index.php?a=main");
}
?>