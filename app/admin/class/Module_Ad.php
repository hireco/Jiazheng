<?php
/*
���Ź���ģ��
========
��Ҫ���ࣺconfig.php forms.php class_DataBase.php SmartTemplate class_User.php
========
��Ҫ���ܣ���$a == ��
--------------------
add ��ӹ��	doadd ִ����ӹ��
list ����б�
show �鿴���	edit �༭���	doedit ִ�б༭���
del ɾ�����

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
$db_ad = "`".$mysql_prefix."advertise`"; //�������ݱ�
$num_in_page = 20;  //ÿҳ��ʾ��Ŀ

$allow = array();

switch($usr->rights['Ad'])
{
case 'S':  //��������Ա
	$allow = array(
		'add' => 2, 'doadd' => 2, 'list' => 2, 'show' => 2, 'edit' => 2, 'doedit' => 2, 'del' => 2,
		);
	break;
case 'A':  //һ������Ա
	$allow = array(
		'add' => 2, 'doadd' => 2, 'list' => 2, 'show' => 2, 'edit' => 2, 'doedit' => 2, 'del' => 2,
		);
	break;
case 'M':  //��������Ա
	$allow = array(
		'add' => 0, 'doadd' => 0, 'list' => 0, 'show' => 0, 'edit' => 0, 'doedit' => 0, 'del' => 0,
		);
	break;
default:  //��Ȩ��
	$allow = array(
		'add' => 0, 'doadd' => 0, 'list' => 0, 'show' => 0, 'edit' => 0, 'doedit' => 0, 'del' => 0,
		);
	break;
}

if (!($allow[$a] > 0)) $Form->oa_exit("��û��Ȩ��ִ�иò���~~");

$type = array('ͼƬ', 'Flash');
$position = array('���'=>'���', '�Ҳ�'=>'�Ҳ�',);

if ($a == 'add') //��ӹ��
{
	$Form->cpheader("��ӹ��");
	$Form->formheader(array(
		'title' => "��ӹ��",
		'action' => "admin.php?j=Ad&a=doadd"
		));
	$Form->makeselect(array(
		'text' => "λ��",
		'name' => "position",
		'option' => $position));
	$Form->maketextarea(array(
		'text' => "����",
		'note' => "���Ŀ���벻Ҫ����100px",
		'name' => "content",
		'cols' => "600",
		'rows' => "400",
		));
	$Form->formfooter(array(
		"button" => array(
			array('value'=>"���"),
			array('value'=>"����",'type'=>"reset"),
		)));
	$Form->cpfooter();
}
elseif ($a == 'doadd') //ִ����ӹ��
{
	$db->insert($db_ad,array(
		'position' => $_POST['position'],
		'content' => $_POST['content'],
		'adder' => $username,
		'time' => time(),
		'addip' => getip(),
		));
	$Form->oa_exit("��ӹ��ɹ�","admin.php?j=Ad&a=list");
}
elseif ($a == 'list') //����б�
{
	$sql_num = "select count(*) from ".$db_ad." where 1";
	$listNum = $db->fetch_one($sql_num);
	$formtitle = "��� [��".$listNum."��] [{$num_in_page}��/ҳ]";

	$cpage = isset($_GET['page']) ? intval($_GET['page']) : 1;
	$page_char = page($listNum,$num_in_page,$cpage,"admin.php?j=Ad&a=list");
	$limitS = $cpage*$num_in_page-$num_in_page;

	$Form->cpheader();
	if($listNum > 0)
	{
		$Form->tableheaderbig(array(
			"title" => $formtitle,
			"colspan" => "5",
		));
		echo "<tr align=\"center\">\n";
		echo "<td width=\"18%\"><b>λ��</b></td>\n";
		echo "<td width=\"18%\"><b>�����</b></td>\n";
		echo "<td width=\"18%\"><b>IP</b></td>\n";
		echo "<td width=\"18%\"><b>ʱ��</b></td>\n";
		echo "<td width=\"28%\"><b>����</b></td>\n";
		echo "</tr>\n";
		$lstRequest = "select * from ".$db_ad." where 1 order by `time` desc limit ".$limitS.",".$num_in_page;
		$vRe = $db->query($lstRequest);
		while($nL = $db->fetch_array($vRe)) 
		{
			$isreply = ($nL['reply'] == "" ? '' : 'Yes');
			echo "<tr align=\"center\">\n";
			echo "<td>".$nL['position']."</td>\n";
			echo "<td>".$nL['adder']."</td>\n";
			echo "<td>".$nL['addip']."</td>\n";
			echo "<td>".date('y-m-d H:i',$nL['time'])."</td>\n";
			echo "<td align=\"center\"><a href=\"admin.php?j=Ad&a=show&id=".$nL['id']."\">�鿴</a> <a href=\"admin.php?j=Ad&a=edit&id=".$nL['id']."\">�༭</a> <a href=\"admin.php?j=Ad&a=del&id=".$nL['id']."\">ɾ��</a></td>\n";
			echo "</tr>\n";
		}
		echo "<tr><td colspan=\"5\" align=\"right\">".$page_char."</td></tr>";
		$Form->tablefooter(array("colspan" => "5"));
	}
	else
	{
		$Form->tableheaderbig(array("title" => $formtitle,));
		$Form->maketd(array("��ʱû�й��~~"));
		$Form->tablefooter();
	}
	$Form->cpfooter();
}
elseif ($a == 'show') //�鿴���
{
	$Form->if_del();
	$id = intval($_GET['id']);
	$sql_ad = "select * from ".$db_ad." where `id`='".$id."'";
	$nL = $db->fetch_one_array($sql_ad);
	if (empty($nL)) $Form->oa_exit("�ù�治����");
	$Form->cpheader("�鿴���");
	$Form->formheader(array(
		'title' => "�鿴���",
		));
	$Form->maketd(array(
		"<b>λ��</b>",
		$position[$nL['position']],
		));
	$Form->maketd(array(
		"<b>����</b>",
		$nL['content'],
		));
	$Form->formfooter(array(
		"button" => array(
			array('value'=>"�༭",'type'=>"button",'extra' => "onclick=\"goto('admin.php?j=Ad&a=edit&id={$id}')\""),
			array('value'=>"ɾ��",'type'=>"button",'extra' => "onclick=\"ifDel('admin.php?j=Ad&a=del&id={$id}')\""),
			array('value'=>"����", 'type'=>"button", 'extra' => "onclick=\"goto('admin.php?j=Ad&a=list')\""),
		)));
	echo "<script>function goto(url){this.location.replace(url);}</script>";
	$Form->cpfooter();
}
elseif ($a == 'edit') //�༭���
{
	$id = intval($_GET['id']);
	$sql_ad = "select * from ".$db_ad." where `id`='".$id."'";
	$nL = $db->fetch_one_array($sql_ad);
	if (empty($nL)) $Form->oa_exit("�ù�治����");

	$Form->cpheader("�༭���");
	$Form->formheader(array(
		'title' => "�༭���",
		'action' => "admin.php?j=Ad&a=doedit",
		));
	$Form->makehidden(array(
		'name' => "id",
		'value' => $id
		));
	$Form->makeselect(array(
		'option' => $position,
		'text' => "λ��",
		'name' => "position",
		'selected' => $nL['position']));
	$Form->maketextarea(array(
		'text' => "����",
		'name' => "content",
		'cols' => "600",
		'rows' => "400",
		'value' => $nL['content'],
		));
	$Form->formfooter(array(
		"button" => array(
			array('value'=>"����"),
			array('value'=>"����", 'type'=>"reset"),
			array('value'=>"����", 'type'=>"button", 'extra' => "onclick=\"goto('admin.php?j=Ad&a=list')\""),
		)));
	echo "<script>function goto(url){this.location.replace(url);}</script>";
	$Form->tablefooter();
	$Form->cpfooter();
}
elseif ($a == 'doedit') //ִ�б༭���
{
	if (!isset($_POST['id'])) $Form->oa_exit("��������");
	$id = intval($_POST['id']);

	$sql_ad = "select count(*) from ".$db_ad." where `id`='".$id."'";
	if ($db->fetch_one($sql_ad)==0) $Form->oa_exit("���Բ�����");

	$db->update($db_ad,array(
		'position' => $_POST['position'],
		'content' => $_POST['content'],
		'adder' => $username,
		'addip' => getip(),
		'time' => time(),
		),"`id`={$id}");
	$Form->oa_exit("��������ɹ�","admin.php?j=Ad&a=list");
}
elseif ($a == 'del') //ɾ�����
{
	$id = intval($_GET['id']);
	$sql = "select count(*) from ".$db_ad." where `id`='".$id."'";
	$num = $db->fetch_one($sql);
	
	if (!($num)) $Form->oa_exit("�ù�治����");

	$db->query("delete from ".$db_ad." where `id`='".$id."'");
	$Form->oa_exit("ɾ�����ɹ�!","admin.php?j=Ad&a=list");
}
else
{
	$Form->oa_exit("���ܲ�����","index.php?a=main");
}
?>