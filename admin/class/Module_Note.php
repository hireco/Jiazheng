<?php
/*
���Ź���ģ��
========
��Ҫ���ࣺconfig.php forms.php class_DataBase.php SmartTemplate class_User.php
========
��Ҫ���ܣ���$a == ��
--------------------
reserveemployee ��ԱԤ���б�	checkreserveemployee ��˹�ԱԤԼ	dealreserveemployee ���������ԱԤԼ	delreservee ɾ����ԱԤԼ
reserveemployer ����Ԥ���б�	checkreserveemployer ��˹���ԤԼ	dealreserveemployer �����������ԤԼ	delreserver ɾ������ԤԼ
register ���ٵǼ��б�	showregister �鿴���ٵǼ�	delregister	ɾ�����ٵǼ�
note �����б�	replynote �ظ�����	doreplynote ִ�лظ�����	delnote ɾ������

���ӹ��� (function)
-------------------

����Ȩ�޵�˵��
==============
0 ��ʾ��Ȩִ�иò���
1 ���ݲ������У���ʾ����ִ�иò���
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

$db_reservee = "`".$mysql_prefix."reservee`"; //ԤԼ��Ա���ݱ�
$db_reserver = "`".$mysql_prefix."reserver`"; //ԤԼ�������ݱ�
$db_register = "`".$mysql_prefix."register`"; //���ٵǼ����ݱ�
$db_note = "`".$mysql_prefix."guestbook`"; //���Ա����ݱ�
$db_employee = "`".$mysql_prefix."employee`"; //��Ա���ݱ�
$db_employer = "`".$mysql_prefix."employer`"; //�������ݱ�
$db_area = "`".$mysql_prefix."area`"; //�������ݱ�

$num_in_page = 20;  //ÿҳ��ʾ��Ŀ

$allow = array();

switch($usr->rights['Note'])
{
case 'S':  //��������Ա
	$allow = array(
		'reserveemployee' => 2, 'checkreserveemployee' => 2, 'docheckreserveemployee' => 2, 'dealreserveemployee' => 2, 'delreservee' => 2,
		'reserveemployer' => 2, 'checkreserveemployer' => 2, 'docheckreserveemployer' => 2, 'dealreserveemployer' => 2, 'delreserver' => 2,
		'register' => 2, 'showregister' => 2, 'delregister' => 2,
		'note' => 2, 'replynote' => 2, 'doreplynote' => 2, 'delnote'=> 2,
		);
	break;
case 'A':  //һ������Ա
	$allow = array(
		'reserveemployee' => 2, 'checkreserveemployee' => 2, 'docheckreserveemployee' => 2, 'dealreserveemployee' => 2, 'delreservee' => 2,
		'reserveemployer' => 2, 'checkreserveemployer' => 2, 'docheckreserveemployer' => 2, 'dealreserveemployer' => 2, 'delreserver' => 2,
		'register' => 2, 'showregister' => 2, 'delregister' => 2,
		'note' => 2, 'replynote' => 2, 'doreplynote' => 2, 'delnote'=> 2,
		);
	break;
case 'M':  //��������Ա
	$allow = array(
		'reserveemployee' => 0, 'checkreserveemployee' => 0, 'docheckreserveemployee' => 0, 'dealreserveemployee' => 0, 'delreservee' => 0,
		'reserveemployer' => 0, 'checkreserveemployer' => 0, 'docheckreserveemployer' => 0, 'dealreserveemployer' => 0, 'delreserver' => 0,
		'register' => 0, 'showregister' => 0, 'delregister' => 0,
		'note' => 1, 'replynote' => 1, 'doreplynote' => 1, 'delnote'=> 1,
		);
	break;
default:  //��Ȩ��
	$allow = array(
		'reserveemployee' => 0, 'checkreserveemployee' => 0, 'docheckreserveemployee' => 0, 'dealreserveemployee' => 0, 'delreservee' => 0,
		'reserveemployer' => 0, 'checkreserveemployer' => 0, 'docheckreserveemployer' => 0, 'dealreserveemployer' => 0, 'delreserver' => 0,
		'register' => 0, 'showregister' => 0, 'delregister' => 0,
		'note' => 0, 'replynote' => 0, 'doreplynote' => 0, 'delnote'=> 0,
		);
	break;
}

if (!($allow[$a] > 0)) $Form->oa_exit("��û��Ȩ��ִ�иò���~~");

if ($a == 'reserveemployee') //ԤԼ��Ա�б�
{
	$reserve_status = array('<font color=red>δ��</font>', '�˻�', '<font color=green>ͨ��</font>');

	$sql_num = "select count(*) from ".$db_reservee." where 1";
	$listNum = $db->fetch_one($sql_num);
	$formtitle = "ԤԼ��Ա [��".$listNum."��] [{$num_in_page}��/ҳ]";

	$cpage = isset($_GET['page']) ? intval($_GET['page']) : 1;
	$page_char = page($listNum,$num_in_page,$cpage,"admin.php?j=Note&a=reserveemployee");
	$limitS = $cpage*$num_in_page-$num_in_page;

	$Form->cpheader();
	if($listNum > 0)
	{
		$Form->formheader(array("action" => "admin.php?j=Note&a=dealreserveemployee",
			"title" => $formtitle,
			"colspan" => "8",
			"name" => "form",
		));
		$Form->if_Del();
		$Form->js_checkall();
		echo "<tr align=\"center\">\n";
		echo "<td width=\"5%\">\n";
		echo "<input type=\"checkbox\" name=\"chkall\" value=\"on\" class=\"radio\" onclick=\"CheckAll(this.form)\"></td>\n";
		echo "<td width=\"8%\"><b>״̬</b></td>\n";
		echo "<td width=\"14%\"><b>����</b></td>\n";
		echo "<td width=\"14%\"><b>��Ա</b></td>\n";
		echo "<td width=\"12%\"><b>����</b></td>\n";
		echo "<td width=\"12%\"><b>IP</b></td>\n";
		echo "<td width=\"15%\"><b>ʱ��</b></td>\n";
		echo "<td width=\"20%\"><b>����</b></td>\n";
		echo "</tr>\n";
		$lstRequest = "select * from ".$db_reservee." where 1 order by `date` desc limit ".$limitS.",".$num_in_page;
		$vRe = $db->query($lstRequest);
		while($nL = $db->fetch_array($vRe)) 
		{
			$id = $nL['id'];
			$sql = "select `username` from ".$db_employee." where `id`=".$nL['did'];
			$dname = $db->fetch_one($sql);
			if ($nL['sname'] == "")
			{
				$name = $db->fetch_one("select `username` from ".$db_employer." where `id`=".$nL['sid']);
				$sname = "<a href=\"admin.php?j=User&a=showemployer&id=".$nL['sid']."\">".$name."</a>";
			}
			else
			{
				$sname = $nL['sname'];
			}
			echo "<tr align=\"center\">\n";
			echo "<td><input type=\"checkbox\" name=\"reserve[{$id}]\" value=\"1\" class=\"radio\"></td>\n";
			echo "<td>".$reserve_status[$nL['status']]."</td>\n";
			echo "<td>".$sname."</td>\n";
			echo "<td><a href=\"admin.php?j=User&a=showemployee&id=".$nL['did']."\">".$dname."</a></td>\n";
			echo "<td>".trim(str_replace(',', ' ', $nL['service']))."</td>\n";
			echo "<td>".$nL['ip']."</td>\n";
			echo "<td>".date('n��j��Gʱ',$nL['date'])."</td>\n";
			echo "<td align=\"center\"><a href=\"admin.php?j=Note&a=checkreserveemployee&id=".$nL['id']."\">����</a> <a href=\"#\" onclick=\"ifDel('admin.php?j=Note&a=delreservee&id=".$nL['id']."')\">ɾ��</a></td>\n";
			echo "</tr>\n";
		}
		echo "<tr><td colspan=\"8\" align=\"right\">".$page_char."</td></tr>";
		echo "<tr><td colspan=\"8\" align=\"center\"><select name=\"operation\"><option value=\"0\">��ѡ��</option><option value=\"1\">ת��ԤԼ</option><option value=\"2\">�绰��ϵ</option><option value=\"�Բ��𣬶Է��ݲ�ԤԼ\">�ݲ�ԤԼ</option><option value=\"�Բ�������רҵ���ܲ�����\">���ܲ���</option><option value=\"�Բ���������ݲ�����\">��ݲ���</option><option value=\"�Բ��𣬿��ܼ�������̫Զ\">����̫Զ</option><option value=\"�����ظ�ԤԼ�˶��\">ԤԼ�ظ�</option><option value=\"������ϵ�绰��Ч\">�绰��Ч</option><option value=\"�Բ��𣬹���û��ѡ����\">ѡ�˱���</option><option value=\"��������дԤԼ��Ϣ\">��д����</option><option value=\"����Ϣ��ʱ��̫������Ч\">��Ϣ����</option><option value=\"�ü�����Ϣ�Ѿ�������\">�Ѿ�����</option></select>&nbsp;&nbsp;&nbsp;&nbsp;<input class=\"button\" accesskey=\"\" type=\"submit\" name=\"\" value=\"����\" />";
		$Form->makehidden(array(
			'name' => "page",
			'value' => $cpage,
			));
		echo "\n</td></tr></form></table>\n";
	}
	else
	{
		$Form->tableheaderbig(array("title" => $formtitle,));
		$Form->maketd(array("��ʱû��ԤԼ~~"));
		$Form->tablefooter();
	}
	$Form->cpfooter();
}
elseif ($a == 'checkreserveemployee') //���ԤԼ��Ա
{
	$id = intval($_GET['id']);
	$sql_reserve = "select * from ".$db_reservee." where `id`='".$id."'";
	$nL = $db->fetch_one_array($sql_reserve);
	if (empty($nL)) $Form->oa_exit("��ԤԼ������");
	$Form->cpheader("����ԤԼ");
	$Form->if_Del();
	$Form->formheader(array(
		'title' => "����ԤԼ",
		'method' => "POST",
		'action' => "admin.php?j=Note&a=docheckreserveemployee",
		));
	$Form->makehidden(array(
		'name' => "id",
		'value' => $id
		));
	$Form->maketd(array(
		"<b>����</b>",
		"ԤԼ��Ա",
		));
	if ($nL['sname'] == "")
	{
		$name = $db->fetch_one("select `username` from ".$db_employer." where `id`=".$nL['sid']);
		$employer = "<a href=\"admin.php?j=User&a=showemployer&id=".$nL['sid']."\">".$name."</a>";
	}
	else
	{
		$employer = $nL['sname'];
	}
	$dname = $db->fetch_one("select `username` from ".$db_employee." where `id`=".$nL['did']);
	$employee = "<a href=\"admin.php?j=User&a=showemployee&id=".$nL['did']."\">".$dname."</a>";
	$Form->maketd(array(
		"<b>����</b>",
		$employer,
		));
	$Form->maketd(array(
		"<b>��Ա</b>",
		$employee,
		));
	$Form->maketd(array(
		"<b>ԤԼʱ��</b>",
		date('y-m-d', $nL['date']),
		));
	$area = $db->fetch_one("select `name` from ".$db_area." where `id`=".$nL['area']);
	if (intval($nL['sid']) == 0)
	{
		$Form->maketd(array('colspan=2' => "<font color=blue><b>�����ǹ����Ļ�����Ϣ</b></font>"));
		$Form->maketd(array('<b>Email</b>', $nL['email']));
		$Form->maketd(array('<b>�绰����</b>', $nL['telephone']));
		$Form->maketd(array('<b>�ֻ�����</b>', $nL['mobile']));
		$Form->maketd(array('<b>QQ</b>', $nL['qq']));
		$Form->maketd(array('<b>����</b>', $area));
		$Form->maketd(array('<b>��ַ</b>', $nL['address']));
		$Form->maketd(array('<b>����</b>', trim(str_replace(',', ' ', $nL['service']))));
		$Form->maketd(array('<b>��ע</b>', str2html($nL['snote'])));
		$Form->maketd(array('colspan=2' => "<font color=blue><b>����������</b></font>"));
	}
	$Form->makeselect(array(
		'option' => array('����', '�˻�', 'ͨ��'),
		'text' => "����",
		'name' => "state",
		'selected' => $nL['status']));
	$Form->maketextarea(array(
		'text' => "��ע",
		'name' => "note",
		'value' => $nL['note'],
		), 0);
	$Form->formfooter(array(
		"button" => array(
			array('value'=>"����"),
			array('value'=>"ɾ��",'type'=>"button",'extra' => "onclick=\"ifDel('admin.php?j=Note&a=delreservee&id={$id}')\""),
			array('value'=>"����", 'type'=>"button", 'extra' => "onclick=\"goto('admin.php?j=Note&a=reserveemployee')\""),
		)));
	echo "<script>function goto(url){this.location.replace(url);}</script>";
	$Form->cpfooter();
}
elseif ($a == 'docheckreserveemployee') //ִ����˹�ԱԤԼ
{
	if (!isset($_POST['id'])) $Form->oa_exit("��������");
	$id = intval($_POST['id']);

	$sql_reserve = "select count(*) from ".$db_reservee." where `id`='".$id."'";
	if ($db->fetch_one($sql_reserve)==0) $Form->oa_exit("ԤԼ������");

	$db->update($db_reservee,array(
		'status' => intval($_POST['state']),
		'note' => checkStr($_POST['note']),
		'checker' => $username,
		'checkip' => getip(),
		),"`id`={$id}");
	$Form->oa_exit("ԤԼ�����ɹ�","admin.php?j=Note&a=reserveemployee");
}
elseif ($a == 'delreservee') //ɾ����ԱԤԼ
{
	$id = intval($_GET['id']);
	$sql = "select count(*) from ".$db_reservee." where `id`='".$id."'";
	$num = $db->fetch_one($sql);
	
	if (!($num)) $Form->oa_exit("��ԤԼ������");

	$db->query("delete from ".$db_reservee." where `id`='".$id."'");
	$Form->oa_exit("ɾ��ԤԼ�ɹ�!","admin.php?j=Note&a=reserveemployee");
}
elseif ($a == 'dealreserveemployee') //���������ԱԤԼ
{
	$page = $_POST['page'];
	$reserve = $_POST["reserve"];
	$operation = $_POST['operation'];
	if ($operation == '0')
	{
		$Form->oa_exit("��ѡ����Ĳ���", 'admin.php?j=Note&a=reserveemployee&page='.$page);
	}
	if (is_array($reserve))
	{
		$num = 0;
		foreach ($reserve as $k => $v)
		{
			if ($v)
			{
				$rid = $k;
				if ($operation == '1')
				{
					$db->update($db_reservee,array(
						"status" => 2,
						"note" => "��ת��ԤԼ����Ⱥ��������",
						"checker" => $username,
						"checkip" => getip(),
						),"`id`='".$rid."'");
				}
				elseif ($operation == '2')
				{
					$db->update($db_reservee,array(
						"status" => 2,
						"note" => "���ٵ绰��ϵ��������",
						"checker" => $username,
						"checkip" => getip(),
						),"`id`='".$rid."'");
				}
				else
				{
					$db->update($db_reservee,array(
						"status" => 1,
						"note" => checkStr($operation),
						"checker" => $username,
						"checkip" => getip(),
						),"`id`='".$rid."'");
				}
				$num++;
			}
		}
		$Form->oa_exit("�ɹ�����{$num}��ԤԼ","admin.php?j=Note&a=reserveemployee&page={$page}");
	}
	else
		$Form->oa_exit("�㻹û��ѡ��ѡ��", "admin.php?j=Note&a=reserveemployee&page={$page}");
}
elseif ($a == 'reserveemployer') //ԤԼ�����б�
{
	$reserve_status = array('<font color=red>δ��</font>', '�˻�', '<font color=green>ͨ��</font>');

	$sql_num = "select count(*) from ".$db_reserver." where 1";
	$listNum = $db->fetch_one($sql_num);
	$formtitle = "ԤԼ���� [��".$listNum."��] [{$num_in_page}��/ҳ]";

	$cpage = isset($_GET['page']) ? intval($_GET['page']) : 1;
	$page_char = page($listNum,$num_in_page,$cpage,"admin.php?j=Note&a=reserveemployer");
	$limitS = $cpage*$num_in_page-$num_in_page;

	$Form->cpheader();
	if($listNum > 0)
	{
		$Form->formheader(array("action" => "admin.php?j=Note&a=dealreserveemployer",
			"title" => $formtitle,
			"colspan" => "9",
			"name" => "form",
		));
		$Form->if_Del();
		$Form->js_checkall();
		echo "<tr align=\"center\">\n";
		echo "<td width=\"5%\">\n";
		echo "<input type=\"checkbox\" name=\"chkall\" value=\"on\" class=\"radio\" onclick=\"CheckAll(this.form)\"></td>\n";
		echo "<td width=\"6%\"><b>״̬</b></td>\n";
		echo "<td width=\"12%\"><b>��Ա</b></td>\n";
		echo "<td width=\"12%\"><b>����</b></td>\n";
		echo "<td width=\"12%\"><b>����</b></td>\n";
		echo "<td width=\"12%\"><b>����</b></td>\n";
		echo "<td width=\"12%\"><b>IP</b></td>\n";
		echo "<td width=\"14%\"><b>ʱ��</b></td>\n";
		echo "<td width=\"15%\"><b>����</b></td>\n";
		echo "</tr>\n";
		$lstRequest = "select * from ".$db_reserver." where 1 order by `date` desc limit ".$limitS.",".$num_in_page;
		$vRe = $db->query($lstRequest);
		while($nL = $db->fetch_array($vRe)) 
		{
			$id = $nL['id'];
			$ns = $db->fetch_one_array("select * from ".$db_employee." where `id`=".$nL['sid']);
			$area = $db->fetch_one("select `name` from ".$db_area." where `id`=".$ns['area']);
			$employee = "<a href=\"admin.php?j=User&a=showemployee&id=".$nL['sid']."\">".$ns['username']."</a>";
			$dname = $db->fetch_one("select `username` from ".$db_employer." where `id`=".$nL['did']);
			$employer = "<a href=\"admin.php?j=User&a=showemployer&id=".$nL['did']."\">".$dname."</a>";
			echo "<tr align=\"center\">\n";
			echo "<td><input type=\"checkbox\" name=\"reserve[{$id}]\" value=\"1\" class=\"radio\"></td>\n";
			echo "<td>".$reserve_status[$nL['status']]."</td>\n";
			echo "<td>".$employee."</td>\n";
			echo "<td>".$employer."</td>\n";
			echo "<td>".trim(str_replace(',', ' ', $ns['service']))."</td>\n";
			echo "<td>".$area."</td>\n";
			echo "<td>".$nL['ip']."</td>\n";
			echo "<td>".date('n��j��Gʱ',$nL['date'])."</td>\n";
			echo "<td align=\"center\"><a href=\"admin.php?j=Note&a=checkreserveemployer&id=".$nL['id']."\">����</a> <a href=\"#\" onclick=\"ifDel('admin.php?j=Note&a=delreserver&id=".$nL['id']."')\">ɾ��</a></td>\n";
			echo "</tr>\n";
		}
		echo "<tr><td colspan=\"9\" align=\"right\">".$page_char."</td></tr>";
		echo "<tr><td colspan=\"9\" align=\"center\"><select name=\"operation\"><option value=\"0\">��ѡ��</option><option value=\"1\">ת��ԤԼ</option><option value=\"2\">�绰��ϵ</option><option value=\"�Բ��𣬶Է��ݲ�ԤԼ\">�ݲ�ԤԼ</option><option value=\"�Բ��𣬿��ܼҽ̾���̫Զ\">����̫Զ</option><option value=\"�����ظ�ԤԼ�˶��\">ԤԼ�ظ�</option><option value=\"������ϵ�绰��Ч\">�绰��Ч</option><option value=\"�Բ��𣬹�Աû��ѡ����\">ѡ�˱���</option><option value=\"��������дԤԼ��Ϣ\">��д����</option><option value=\"����Ϣ��ʱ��̫������Ч\">��Ϣ����</option><option value=\"�üҽ���Ϣ�Ѿ�������\">�Ѿ�����</option></select>&nbsp;&nbsp;&nbsp;&nbsp;<input class=\"button\" accesskey=\"\" type=\"submit\" name=\"\" value=\"����\" />";
		$Form->makehidden(array(
			'name' => "page",
			'value' => $cpage,
			));
		echo "\n</td></tr></form></table>\n";
	}
	else
	{
		$Form->tableheaderbig(array("title" => $formtitle,));
		$Form->maketd(array("��ʱû��ԤԼ~~"));
		$Form->tablefooter();
	}
	$Form->cpfooter();
}
elseif ($a == 'checkreserveemployer') //��˹���ԤԼ
{
	$id = intval($_GET['id']);
	$sql_reserve = "select * from ".$db_reserver." where `id`='".$id."'";
	$nL = $db->fetch_one_array($sql_reserve);
	if (empty($nL)) $Form->oa_exit("��ԤԼ������");
	$Form->cpheader("����ԤԼ");
	$Form->if_Del();
	$Form->formheader(array(
		'title' => "����ԤԼ",
		'method' => "POST",
		'action' => "admin.php?j=Note&a=docheckreserveemployer",
		));
	$sname = $db->fetch_one("select `username` from ".$db_employee." where `id`=".$nL['sid']);
	$employee = "<a href=\"admin.php?j=User&a=showemployee&id=".$nL['sid']."\">".$sname."</a>";
	$dname = $db->fetch_one("select `username` from ".$db_employer." where `id`=".$nL['did']);
	$employer = "<a href=\"admin.php?j=User&a=showemployer&id=".$nL['did']."\">".$dname."</a>";

	$Form->makehidden(array(
		'name' => "id",
		'value' => $id
		));
	$Form->maketd(array(
		"<b>����</b>",
		"ԤԼ����",
		));
	$Form->maketd(array(
		"<b>��Ա</b>",
		$employee,
		));
	$Form->maketd(array(
		"<b>����</b>",
		$employer,
		));
	$Form->maketd(array(
		"<b>ԤԼʱ��</b>",
		date('n��j��Gʱ',$nL['date']),
		));
	$Form->makeselect(array(
		'option' => array('����', '�˻�', 'ͨ��'),
		'text' => "����",
		'name' => "state",
		'selected' => $nL['status']));
	$Form->maketextarea(array(
		'text' => "��ע",
		'name' => "note",
		'value' => $nL['note'],
		), 0);
	$Form->formfooter(array(
		"button" => array(
			array('value'=>"����"),
			array('value'=>"ɾ��",'type'=>"button",'extra' => "onclick=\"ifDel('admin.php?j=Note&a=delreserver&id={$id}')\""),
			array('value'=>"����", 'type'=>"button", 'extra' => "onclick=\"goto('admin.php?j=Note&a=reserveemployer')\""),
		)));
	echo "<script>function goto(url){this.location.replace(url);}</script>";
	$Form->cpfooter();
}
elseif ($a == 'docheckreserveemployer') //ִ����˹���ԤԼ
{
	if (!isset($_POST['id'])) $Form->oa_exit("��������");
	$id = intval($_POST['id']);

	$sql_reserve = "select count(*) from ".$db_reserver." where `id`='".$id."'";
	if ($db->fetch_one($sql_reserve)==0) $Form->oa_exit("ԤԼ������");

	$db->update($db_reserver,array(
		'status' => intval($_POST['state']),
		'note' => checkStr($_POST['note']),
		'checker' => $username,
		'checkip' => getip(),
		),"`id`={$id}");
	$Form->oa_exit("ԤԼ�����ɹ�","admin.php?j=Note&a=reserveemployer");
}
elseif ($a == 'delreserver') //ɾ������ԤԼ
{
	$id = intval($_GET['id']);
	$sql = "select count(*) from ".$db_reserver." where `id`='".$id."'";
	$num = $db->fetch_one($sql);
	
	if (!($num)) $Form->oa_exit("��ԤԼ������");

	$db->query("delete from ".$db_reserver." where `id`='".$id."'");
	$Form->oa_exit("ɾ��ԤԼ�ɹ�!","admin.php?j=Note&a=reserveemployer");
}
elseif ($a == 'dealreserveemployer') //�����������ԤԼ
{
	$page = $_POST['page'];
	$reserve = $_POST["reserve"];
	$operation = $_POST['operation'];
	if ($operation == '0')
	{
		$Form->oa_exit("��ѡ����Ĳ���", 'admin.php?j=Note&a=reserveemployer&page='.$page);
	}
	if (is_array($reserve))
	{
		$num = 0;
		foreach ($reserve as $k => $v)
		{
			if ($v)
			{
				$rid = $k;
				if ($operation == '1')
				{
					$db->update($db_reserver,array(
						"status" => 2,
						"note" => "��ת��ԤԼ����Ⱥ��Ա����",
						"checker" => $username,
						"checkip" => getip(),
						),"`id`='".$rid."'");
				}
				elseif ($operation == '2')
				{
					$db->update($db_reserver,array(
						"status" => 2,
						"note" => "���ٵ绰��ϵ����",
						"checker" => $username,
						"checkip" => getip(),
						),"`id`='".$rid."'");
				}
				else
				{
					$db->update($db_reserver,array(
						"status" => 1,
						"note" => checkStr($operation),
						"checker" => $username,
						"checkip" => getip(),
						),"`id`='".$rid."'");
				}
				$num++;
			}
		}
		$Form->oa_exit("�ɹ�����{$num}��ԤԼ","admin.php?j=Note&a=reserveemployer&page={$page}");
	}
	else
		$Form->oa_exit("�㻹û��ѡ��ѡ��", "admin.php?j=Note&a=reserveemployer&page={$page}");
}
elseif ($a == 'register') //���ٵǼ��б�
{
	$sql_num = "select count(*) from ".$db_register." where 1";
	$listNum = $db->fetch_one($sql_num);
	$formtitle = "���ٵǼ� [��".$listNum."��] [{$num_in_page}��/ҳ]";

	$cpage = isset($_GET['page']) ? intval($_GET['page']) : 1;
	$page_char = page($listNum,$num_in_page,$cpage,"admin.php?j=Note&a=register");
	$limitS = $cpage*$num_in_page-$num_in_page;

	$Form->cpheader();
	if($listNum > 0)
	{
		$Form->tableheaderbig(array(
			"title" => $formtitle,
			"colspan" => "5",
		));
		$Form->if_Del();
		echo "<tr align=\"center\">\n";
		echo "<td width=\"15%\"><b>����</b></td>\n";
		echo "<td width=\"15%\"><b>�绰����</b></td>\n";
		echo "<td width=\"40%\"><b>˵��</b></td>\n";
		echo "<td width=\"15%\"><b>ʱ��</b></td>\n";
		echo "<td width=\"15%\"><b>����</b></td>\n";
		echo "</tr>\n";
		$lstRequest = "select * from ".$db_register." where 1 order by `time` desc limit ".$limitS.",".$num_in_page;
		$vRe = $db->query($lstRequest);
		while($nL = $db->fetch_array($vRe)) 
		{
			$read = ($nL['read'] == 0 ? '<font color="red">�鿴</font>' : '�鿴');
			echo "<tr align=\"center\">\n";
			echo "<td>".$nL['name']."</td>\n";
			echo "<td>".$nL['telephone']."</td>\n";
			echo "<td>".str2html($nL['note'])."</td>\n";
			echo "<td>".date('y-m-d H:i',$nL['time'])."</td>\n";
			echo "<td align=\"center\"><a href=\"admin.php?j=Note&a=showregister&id=".$nL['id']."\">".$read."</a> <a href=\"#\" onclick=\"ifDel('admin.php?j=Note&a=delregister&id=".$nL['id']."')\">ɾ��</a></td>\n";
			echo "</tr>\n";
		}
		echo "<tr><td colspan=\"5\" align=\"right\">".$page_char."</td></tr>";
		$Form->tablefooter(array("colspan" => "5"));
	}
	else
	{
		$Form->tableheaderbig(array("title" => $formtitle,));
		$Form->maketd(array("��ʱû�п��ٵǼ�~~"));
		$Form->tablefooter();
	}
	$Form->cpfooter();
}
elseif ($a == 'showregister') //�鿴���ٵǼ�
{
	$id = intval($_GET['id']);
	$db->update($db_register, array(
		'read' => 1,
		), "`id`=".$id);
	$sql_register = "select * from ".$db_register." where `id`='".$id."'";
	$nL = $db->fetch_one_array($sql_register);
	if (empty($nL)) $Form->oa_exit("�ÿ��ٵǼǲ�����");
	$Form->cpheader("�鿴���ٵǼ�");
	$Form->if_Del();
	$Form->formheader(array(
		'title' => "�鿴���ٵǼ�",
		));
	$Form->makehidden(array(
		'name' => "id",
		'value' => $id
		));
	$Form->maketd(array(
		"<b>����</b>",
		$nL['name'],
		));
	$Form->maketd(array(
		"<b>�绰</b>",
		$nL['telephone'],
		));
	$Form->maketd(array(
		"<b>˵��</b>",
		str2html($nL['note']),
		));
	$Form->formfooter(array(
		"button" => array(
			array('value'=>"ɾ��",'type'=>"button",'extra' => "onclick=\"ifDel('admin.php?j=Note&a=delregister&id={$id}')\""),
			array('value'=>"����", 'type'=>"button", 'extra' => "onclick=\"goto('admin.php?j=Note&a=register')\""),
		)));
	echo "<script>function goto(url){this.location.replace(url);}</script>";
	$Form->cpfooter();
}
elseif ($a == 'delregister') //ɾ�����ٵǼ�
{
	$id = intval($_GET['id']);
	$sql = "select count(*) from ".$db_register." where `id`='".$id."'";
	$num = $db->fetch_one($sql);
	
	if (!($num)) $Form->oa_exit("�ÿ��ٵǼǲ�����");

	$db->query("delete from ".$db_register." where `id`='".$id."'");
	$Form->oa_exit("ɾ�����ٵǼǳɹ�!","admin.php?j=Note&a=register");
}
elseif ($a == 'note') //�����б�
{
	$status = array('<font color="red">δ��</a>', '<font color="green">ͨ��</font>');

	$sql_num = "select count(*) from ".$db_note." where 1";
	$listNum = $db->fetch_one($sql_num);
	$formtitle = "���� [��".$listNum."��] [{$num_in_page}��/ҳ]";

	$cpage = isset($_GET['page']) ? intval($_GET['page']) : 1;
	$page_char = page($listNum,$num_in_page,$cpage,"admin.php?j=Note&a=note");
	$limitS = $cpage*$num_in_page-$num_in_page;

	$Form->cpheader();
	$Form->if_Del();
	if($listNum > 0)
	{
		$Form->tableheaderbig(array(
			"title" => $formtitle,
			"colspan" => "8",
		));
		echo "<tr align=\"center\">\n";
		echo "<td width=\"10%\"><b>״̬</b></td>\n";
		echo "<td width=\"8%\"><b>�ǳ�</b></td>\n";
		echo "<td width=\"28%\"><b>����</b></td>\n";
		echo "<td width=\"6%\"><b>�ظ�</b></td>\n";
		echo "<td width=\"9%\"><b>�ظ���</b></td>\n";
		echo "<td width=\"14%\"><b>IP</b></td>\n";
		echo "<td width=\"15%\"><b>ʱ��</b></td>\n";
		echo "<td width=\"10%\"><b>����</b></td>\n";
		echo "</tr>\n";
		$lstRequest = "select * from ".$db_note." where 1 order by `time` desc limit ".$limitS.",".$num_in_page;
		$vRe = $db->query($lstRequest);
		while($nL = $db->fetch_array($vRe)) 
		{
			$read = ($nL['read'] == 0 ? '<font color="red">�鿴</font>' : '�鿴');
			$isreply = ($nL['reply'] == "" ? '' : 'Yes');
			echo "<tr align=\"center\">\n";
			echo "<td>".$status[$nL['status']]."</td>\n";
			echo "<td>".$nL['name']."</td>\n";
			echo "<td>".str2html($nL['content'])."</td>\n";
			echo "<td>".$isreply."</td>\n";
			echo "<td>".$nL['checker']."</td>\n";
			echo "<td>".$nL['ip']."</td>\n";
			echo "<td>".date('y-m-d H:i',$nL['time'])."</td>\n";
			echo "<td><a href=\"admin.php?j=Note&a=replynote&id={$nL['id']}\">".$read."</a> <a href=\"#\" onclick=\"ifDel('admin.php?j=Note&a=delnote&id={$nL['id']}')\">ɾ��</a></td>\n";
			echo "</tr>\n";
		}
		echo "<tr><td colspan=\"8\" align=\"right\">".$page_char."</td></tr>";
		$Form->tablefooter(array("colspan" => "8"));
	}
	else
	{
		$Form->tableheaderbig(array("title" => $formtitle,));
		$Form->maketd(array("��ʱû������~~"));
		$Form->tablefooter();
	}
	$Form->cpfooter();
}
elseif ($a == 'replynote') //�ظ�����
{
	$id = intval($_GET['id']);
	$db->update($db_note, array(
		'read' => 1,
		), "`id`=".$id);
	$sql_note = "select * from ".$db_note." where `id`='".$id."'";
	$nL = $db->fetch_one_array($sql_note);
	if (empty($nL)) $Form->oa_exit("�����Բ�����");
	$Form->cpheader("�鿴����");
	$Form->if_Del();
	$Form->formheader(array(
		'title' => "�鿴����",
		'method' => "POST",
		'action' => "admin.php?j=Note&a=doreplynote",
		));
	$Form->makehidden(array(
		'name' => "id",
		'value' => $id
		));
	$Form->maketd(array(
		"<b>������</b>",
		$nL['name'],
		));
	$Form->maketd(array(
		"<b>Email</b>",
		$nL['email'],
		));
	$Form->maketd(array(
		"<b>�绰����</b>",
		$nL['telephone'],
		));
	$Form->maketd(array(
		"<b>QQ</b>",
		$nL['qq'],
		));
	$Form->maketd(array(
		"<b>��������</b>",
		str2html($nL['content']),
		));
	$Form->makeselect(array(
		'text' => "����",
		'name' => "status",
		'option' => array("����", "ͨ��"),
		'selected' => $nL['status'],
		));
	$Form->maketextarea(array(
		'text' => "�ظ�",
		'name' => "reply",
		'value' => html2str($nL['reply'])
		), 0);
	$Form->formfooter(array(
		"button" => array(
			array('value'=>"ȷ��"),
			array('value'=>"ɾ��",'type'=>"button",'extra' => "onclick=\"ifDel('admin.php?j=Note&a=delnote&id={$id}')\""),
			array('value'=>"����", 'type'=>"button", 'extra' => "onclick=\"goto('admin.php?j=Note&a=note')\""),
		)));
	echo "<script>function goto(url){this.location.replace(url);}</script>";
	$Form->cpfooter();
}
elseif ($a == 'doreplynote') //ִ�лظ�����
{
	if (!isset($_POST['id'])) $Form->oa_exit("��������");
	$id = intval($_POST['id']);

	$sql_note = "select count(*) from ".$db_note." where `id`='".$id."'";
	if ($db->fetch_one($sql_note)==0) $Form->oa_exit("���Բ�����");

	$db->update($db_note,array(
		'reply' => $_POST['reply'],
		'status' => $_POST['status'],
		'checker' => $username,
		'checkip' => getip(),
		),"`id`={$id}");
	$Form->oa_exit("���������ɹ�","admin.php?j=Note&a=note");
}
elseif ($a == 'delnote') //ɾ������
{
	$id = intval($_GET['id']);
	$sql = "select count(*) from ".$db_note." where `id`='".$id."'";
	$num = $db->fetch_one($sql);
	
	if (!($num)) $Form->oa_exit("�����Բ�����");

	$db->query("delete from ".$db_note." where `id`='".$id."'");
	$Form->oa_exit("ɾ�����Գɹ�!","admin.php?j=Note&a=note");
}
else
{
	$Form->oa_exit("���ܲ�����","index.php?a=main");
}
?>

