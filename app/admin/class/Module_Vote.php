<?php
/*
���Ź���ģ��
========
��Ҫ���ࣺconfig.php forms.php class_DataBase.php SmartTemplate class_User.php
========
��Ҫ���ܣ���$a == ��
--------------------
add ���ͶƱ����	doadd ִ�����ͶƱ����
list ͶƱ�����б�	edit �༭ͶƱ����	doedit ִ�б༭ͶƱ����	del ɾ��ͶƱ����

���ӹ��� (function)
-------------------
correct($choice = array()) �ж�ͶƱѡ���ù��Ƿ�Ϸ�

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
$db_vote = "`".$mysql_prefix."vote`"; //ͶƱ���ݱ�
$num_in_page = 20;  //ÿҳ��ʾ��Ŀ

$allow = array();

switch($usr->rights['News'])
{
case 'S':  //��������Ա
	$allow = array(
		'add' => 2, 'doadd' => 2, 'list' => 2, 'edit' => 2, 'doedit' => 2, 'del' => 2,
		);
	break;
case 'A':  //һ������Ա
	$allow = array(
		'add' => 2, 'doadd' => 2, 'list' => 2, 'edit' => 2, 'doedit' => 2, 'del' => 2,
		);
	break;
case 'M':  //��������Ա
	$allow = array(
		'add' => 0, 'doadd' => 0, 'list' => 0, 'edit' => 0, 'doedit' => 0, 'del' => 0,
		);
	break;
default:  //��Ȩ��
	$allow = array(
		'add' => 0, 'doadd' => 0, 'list' => 0, 'edit' => 0, 'doedit' => 0, 'del' => 0,
		);
	break;
}

if (!($allow[$a] > 0)) $Form->oa_exit("��û��Ȩ��ִ�иò���~~");

if ($a == 'add') //���ͶƱ����
{
	$Form->cpheader("���ͶƱ����");
	$Form->formheader(array(
		'title' => "���ͶƱ����",
		'action' => "admin.php?j=Vote&a=doadd"
		));
	$Form->makeinput(array(
		'text' => "����",
		'name' => "title",
		'size' => "100"
		));
	for ($i=1; $i<=5; $i++)
	{
		$Form->makeinput(array(
			'text' => "��".$i."��ѡ��",
			'name' => "choice".$i,
			'size' => "50"
			));
	}
	$Form->formfooter(array(
		"button" => array(
			array('value'=>"���"),
			array('value'=>"����",'type'=>"reset"),
		)));
	$Form->cpfooter();
}
elseif ($a == 'doadd') //ִ�����ͶƱ����
{
	$title = checkStr($_POST['title']);
	if (!$title) $Form->oa_exit("����дͶƱ��������");
	for ($i=1; $i<=5; $i++)
	{
		$choice[$i] = checkStr($_POST['choice'.$i]);
	}
	if (!correct($choice)) $Form->oa_exit("ͶƱѡ���д���");
	$db->insert($db_vote,array(
		'title' => $title,
		'choice1' => $choice[1],
		'choice2' => $choice[2],
		'choice3' => $choice[3],
		'choice4' => $choice[4],
		'choice5' => $choice[5],
		'adder' => $username,
		'time' => time(),
		'ip' => getip(),
		));
	$Form->oa_exit("���ͶƱ����ɹ�","admin.php?j=Vote&a=list");
}
elseif ($a == 'list') //ͶƱ�����б�
{
	$sql_num = "select count(*) from ".$db_vote." where 1";
	$listNum = $db->fetch_one($sql_num);
	$formtitle = "ͶƱ���� [��".$listNum."��] [{$num_in_page}��/ҳ]";

	$cpage = isset($_GET['page']) ? intval($_GET['page']) : 1;
	$page_char = page($listNum,$num_in_page,$cpage,"admin.php?j=Vote&a=list");
	$limitS = $cpage*$num_in_page-$num_in_page;

	$Form->cpheader();
	if($listNum > 0)
	{
		$Form->tableheaderbig(array(
			"title" => $formtitle,
			"colspan" => "4",
		));
		echo "<tr align=\"center\">\n";
		echo "<td width=\"55%\"><b>����</b></td>\n";
		echo "<td width=\"15%\"><b>�����</b></td>\n";
		echo "<td width=\"15%\"><b>IP</b></td>\n";
		echo "<td width=\"15%\"><b>ʱ��</b></td>\n";
		echo "</tr>\n";
		$lstRequest = "select * from ".$db_vote." where 1 order by `time` desc limit ".$limitS.",".$num_in_page;
		$vRe = $db->query($lstRequest);
		while($nL = $db->fetch_array($vRe)) 
		{
			echo "<tr align=\"center\">\n";
			echo "<td><a href=\"admin.php?j=Vote&a=edit&id={$nL[id]}\">".$nL['title']."</a></td>\n";
			echo "<td>".$nL['adder']."</td>\n";
			echo "<td>".$nL['ip']."</td>\n";
			echo "<td>".date('y-m-d H:i',$nL['time'])."</td>\n";
			echo "</tr>\n";
		}
		echo "<tr><td colspan=\"4\" align=\"right\">".$page_char."</td></tr>";
		$Form->tablefooter(array("colspan" => "4"));
	}
	else
	{
		$Form->tableheaderbig(array("title" => $formtitle,));
		$Form->maketd(array("��ʱû��ͶƱ����~~"));
		$Form->tablefooter();
	}
	$Form->cpfooter();
}
elseif ($a == 'edit') //�༭ͶƱ����
{
	$id = intval($_GET['id']);
	$sql_vote = "select * from ".$db_vote." where `id`='".$id."'";
	$nL = $db->fetch_one_array($sql_vote);
	if (empty($nL)) $Form->oa_exit("��ͶƱ���ⲻ����");

	$Form->cpheader("���ͶƱ����");
	$Form->formheader(array(
		'title' => "���ͶƱ����",
		'action' => "admin.php?j=Vote&a=doedit"
		));
	$Form->makehidden(array(
		'name' => "id",
		'value' => $id
		));
	$Form->makeinput(array(
		'text' => "����",
		'name' => "title",
		'size' => "100",
		'value' => $nL['title'],
		));
	for ($i=1; $i<=5; $i++)
	{
		$Form->makeinput(array(
			'text' => "��".$i."��ѡ��",
			'name' => "choice".$i,
			'size' => "50",
			'value' => $nL['choice'.$i],
			));
	}
	$Form->formfooter(array(
		"button" => array(
			array('value'=>"�༭"),
			array('value'=>"ɾ��",'type'=>"button",'extra' => "onclick=\"goto('admin.php?j=Vote&a=del&id={$id}')\""),
			array('value'=>"����",'type'=>"reset"),
		)));
	echo "<script>function goto(url){this.location.replace(url);}</script>";
	$Form->cpfooter();
}
elseif ($a == 'doedit') //ִ�б༭ͶƱ����
{
	$id = $_POST['id'];
	$title = checkStr($_POST['title']);
	if (!$title) $Form->oa_exit("����дͶƱ��������");
	for ($i=1; $i<=5; $i++)
	{
		$choice[$i] = checkStr($_POST['choice'.$i]);
	}
	if (!correct($choice)) $Form->oa_exit("ͶƱѡ���д���");
	$db->update($db_vote,array(
		'title' => $title,
		'choice1' => $choice[1],
		'choice2' => $choice[2],
		'choice3' => $choice[3],
		'choice4' => $choice[4],
		'choice5' => $choice[5],
		'result1' => 0,
		'result2' => 0,
		'result3' => 0,
		'result4' => 0,
		'result5' => 0,
		'adder' => $username,
		'time' => time(),
		'ip' => getip(),
		),"`id`={$id}");
	$Form->oa_exit("�༭ͶƱ����ɹ�","admin.php?j=Vote&a=list");
}
elseif ($a == 'del') //ɾ��ͶƱ����
{
	$id = intval($_GET['id']);
	$sql = "select count(*) from ".$db_vote." where `id`='".$id."'";
	$num = $db->fetch_one($sql);
	
	if (!($num)) $Form->oa_exit("�����Բ�����");

	$db->query("delete from ".$db_vote." where `id`='".$id."'");
	$Form->oa_exit("ɾ��ͶƱ����ɹ�!","admin.php?j=Vote&a=list");
}
else
{
	$Form->oa_exit("���ܲ�����","index.php?a=main");
}

function correct($choice = array())
{
	if ($choice[1] == "")
	{
		return 0;
	}
	for ($i=2; $i<=4; $i++)
	{
		if ($choice[$i] == "")
		{
			for ($j = $i+1; $i<=5; $i++)
			{
				if ($choice[$j] != "")
					return 0;
			}
		}
	}
	return 1;
}
?>