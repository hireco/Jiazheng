<?php
/*
���Ź���ģ��
========
��Ҫ���ࣺconfig.php forms.php class_DataBase.php SmartTemplate class_User.php
========
��Ҫ���ܣ���$a == ��
--------------------
add ��Ӻ�Լ	makesure ȷ�Ϻ�Լ	doadd ִ����Ӻ�Լ
list ��Լ�б�	show �鿴��Լ

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
$db_contract = "`".$mysql_prefix."contract`"; //��Լ���ݱ�
$db_employee = "`".$mysql_prefix."employee`"; //��Ա���ݱ�
$db_employer = "`".$mysql_prefix."employer`"; //�������ݱ�
$num_in_page = 20;  //ÿҳ��ʾ��Ŀ

$allow = array();

switch($usr->rights['Contract'])
{
case 'S':  //��������Ա
	$allow = array(
		'add' => 2, 'doadd' => 2, 'makesure' => 2, 'list' => 2, 'del' => 2,
		);
	break;
case 'A':  //һ������Ա
	$allow = array(
		'add' => 2, 'doadd' => 2, 'makesure' => 2, 'list' => 2, 'del' => 0,
		);
	break;
case 'M':  //��������Ա
	$allow = array(
		'add' => 0, 'doadd' => 0, 'makesure' => 0, 'list' => 0, 'del' => 0,
		);
	break;
default:  //��Ȩ��
	$allow = array(
		'add' => 0, 'doadd' => 0, 'makesure' => 0, 'list' => 0, 'del' => 0,
		);
	break;
}

if (!($allow[$a] > 0)) $Form->oa_exit("��û��Ȩ��ִ�иò���~~");

if ($a == 'add') //��Ӻ�Լ
{
	$starttime_stamp = time();
	$interval = 15552000; //180��
	$endtime_stamp = $starttime_stamp + $interval;
	$endtime = array();
	$endtime['year'] = oadate("Y",$endtime_stamp);;
	$endtime['month'] =oadate("n",$endtime_stamp);
	$endtime['day'] = oadate("j",$endtime_stamp);
	$endtime['hour'] = 0;
	$endtime['minute'] = 0;
	$endtime['second'] = 0;
	$endtime['text'] = "��Լ����ʱ��";
	$endtime['note'] = "(Ĭ��Ϊ��Լ��ʼʱ��֮��180��)";
	

	$Form->cpheader("��Ӻ�Լ");
	$Form->formheader(array(
		'title' => "��Ӻ�Լ",
		'action' => "admin.php?j=Contract&a=makesure"
		));
	$Form->makeinput(array(
		'text' => "��Ա���",
		'name' => "employeeid",
		));
	$Form->makeinput(array(
		'text' => "�������",
		'name' => "employerid",
		));
	$Form->makeinput(array(
		'text' => "�н��",
		'name' => "agent",
		));
	$Form->makeinput(array(
		'text' => "����",
		'name' => "salary",
		));
	$Form->maketimeinput($endtime);
	$Form->maketextarea(array(
		'text' => "��ע",
		'name' => "note",
		), 0);
	$Form->formfooter(array(
		"button" => array(
			array('value'=>"��һ��"),
			array('value'=>"����",'type'=>"reset"),
		)));
	$Form->cpfooter();
}
elseif ($a == 'makesure') //ȷ�Ϻ�Լ
{
	$endtime = mktime($_POST['hour'], $_POST['minute'], $_POST['second'], $_POST['month'], $_POST['day'], $_POST['year']);
	$Form->cpheader("ȷ�Ϻ�Լ");
	$Form->formheader(array(
		'title' => "ȷ�Ϻ�Լ",
		'action' => "admin.php?j=Contract&a=doadd",
		));
	$Form->makehidden(array(
		'name' => "employeeid",
		'value' => $_POST['employeeid'],
		));
	$Form->makehidden(array(
		'name' => "employerid",
		'value' => $_POST['employerid'],
		));
	$Form->makehidden(array(
		'name' => "agent",
		'value' => $_POST['agent'],
		));
	$Form->makehidden(array(
		'name' => "salary",
		'value' => $_POST['salary'],
		));
	$Form->makehidden(array(
		'name' => "endtime",
		'value' => $endtime,
		));
	$Form->maketd(array(
		"<b>��Ա���</b>",
		$_POST['employeeid'],
		));
	$Form->maketd(array(
		"<b>�������</b>",
		$_POST['employerid'],
		));
	$Form->maketd(array(
		"<b>�н��</b>",
		$_POST['agent'],
		));
	$Form->maketd(array(
		"<b>����</b>",
		$_POST['salary'],
		));
	$Form->maketd(array(
		"<b>��Լ����ʱ��</b>",
		date('Y��n��j��', $endtime),
		));
	$Form->maketd(array(
		"<b>��ע</b>",
		$_POST['note'],
		));
	$Form->formfooter(array(
		"button" => array(
			array('value'=>"ȷ��"),
			array('value'=>"����", 'type'=>"button", 'extra' => "onclick='history.back(-1)'"),
		)));
	echo "<script>function goto(url){this.location.replace(url);}</script>";
	$Form->cpfooter();
}
elseif ($a == 'doadd') //ִ����Ӻ�Լ
{
	$db->insert($db_contract,array(
		'employeeid' => intval($_POST['employeeid']),
		'employerid' => intval($_POST['employerid']),
		'agent' => intval($_POST['agent']),
		'salary' => $_POST['salary'],
		'note' => checkStr($_POST['note']),
		'endtime' => $_POST['endtime'],
		'starttime' => time(),
		'adder' => $username,
		'addip' => getip(),
		));
	$db->update($db_employer, array(
		'occupied' => 1,
		), "`id`=".$_POST['employerid']);
	$db->update($db_employee, array(
		'occupied' => 1,
		), "`id`=".$_POST['employeeid']);
	$Form->oa_exit("��Լ��ӳɹ�","admin.php?j=Contract&a=list");
}
elseif ($a == 'list') //��Լ�б�
{
	//�����Ա��occupied����
	$sql_employer = "select * from ".$db_employer." where `occupied`=1";
	$query_employer = $db->query($sql_employer);
	while ($employer = $db->fetch_array($query_employer))
	{
		$sql_contract = "select max(`endtime`) from ".$db_contract." where `employerid`=".$employer['id'];
		if ($db->fetch_one($sql_contract) <= time())
		{
			$db->update($db_employer, array(
				'occupied' => 0,
				), "`id`=".$employer['id']);
		}
	}
	$sql_employee = "select * from ".$db_employee." where `occupied`=1";
	$query_employee = $db->query($sql_employee);
	while ($employee = $db->fetch_array($query_employee))
	{
		$sql_contract = "select max(`endtime`) from ".$db_contract." where `employerid`=".$employee['id'];
		if ($db->fetch_one($sql_contract) <= time())
		{
			$db->update($db_employee, array(
				'occupied' => 0,
				), "`id`=".$employee['id']);
		}
	}

	$sql_num = "select count(*) from ".$db_contract." where 1";
	$listNum = $db->fetch_one($sql_num);
	$formtitle = "��Լ [��".$listNum."��] [{$num_in_page}��/ҳ]";

	$cpage = isset($_GET['page']) ? intval($_GET['page']) : 1;
	$page_char = page($listNum,$num_in_page,$cpage,"admin.php?j=Contract&a=list");
	$limitS = $cpage*$num_in_page-$num_in_page;

	$Form->cpheader();
	if($listNum > 0)
	{
		$Form->if_del();
		$Form->tableheaderbig(array(
			"title" => $formtitle,
			"colspan" => "8",
		));
		echo "<tr align=\"center\">\n";
		echo "<td width=\"15%\"><b>��Ա</b></td>\n";
		echo "<td width=\"15%\"><b>����</b></td>\n";
		echo "<td width=\"12%\"><b>�н��</b></td>\n";
		echo "<td width=\"14%\"><b>����</b></td>\n";
		echo "<td width=\"12%\"><b>��ʼ����</b></td>\n";
		echo "<td width=\"12%\"><b>��������</b></td>\n";
		echo "<td width=\"12%\"><b>�����</b></td>\n";
		echo "<td width=\"6%\"><b>����</b></td>\n";
		echo "</tr>\n";
		$lstRequest = "select * from ".$db_contract." where 1 order by `starttime` desc limit ".$limitS.",".$num_in_page;
		$vRe = $db->query($lstRequest);
		while($nL = $db->fetch_array($vRe)) 
		{
			$sql_employee = "select `name` from ".$db_employee." where `id`=".$nL['employeeid'];
			$tname = $db->fetch_one($sql_employee);
			$sql_employer = "select `name` from ".$db_employer." where `id`=".$nL['employerid'];
			$sname = $db->fetch_one($sql_employer);
			echo "<tr align=\"center\">\n";
			echo "<td><a href=\"admin.php?j=User&a=showemployee&id={$nL['employeeid']}\">".$tname."</a></td>\n";
			echo "<td><a href=\"admin.php?j=User&a=showemployer&id={$nL['employerid']}\">".$sname."</a></td>\n";
			echo "<td>".$nL['agent']."</td>\n";
			echo "<td>".$nL['salary']."</td>\n";
			echo "<td>".date('Y��n��j��',$nL['starttime'])."</td>\n";
			echo "<td>".date('Y��n��j��',$nL['endtime'])."</td>\n";
			echo "<td>".$nL['adder']."</td>\n";
			echo "<td><a href=\"#\" onclick=\"ifDel('admin.php?j=Contract&a=del&id={$nL['id']}')\">ɾ��</a></td>\n";
			echo "</tr>\n";
		}
		echo "<tr><td colspan=\"8\" align=\"right\">".$page_char."</td></tr>";
		$Form->tablefooter(array("colspan" => "8"));
	}
	else
	{
		$Form->tableheaderbig(array("title" => $formtitle,));
		$Form->maketd(array("��ʱû�к�Լ~~"));
		$Form->tablefooter();
	}
	$Form->cpfooter();
}
elseif ($a == 'del') //ɾ����Լ
{
	$id = intval($_GET['id']);
	$sql = "select count(*) from ".$db_contract." where `id`='".$id."'";
	$num = $db->fetch_one($sql);
	
	if (!($num)) $Form->oa_exit("�ú�Լ������");

	$db->query("delete from ".$db_contract." where `id`='".$id."'");
	$Form->oa_exit("ɾ����Լ�ɹ�!","admin.php?j=Contract&a=list");
}
else
{
	$Form->oa_exit("���ܲ�����","index.php?a=main");
}

?>