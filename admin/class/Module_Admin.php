<?php
/*
�û�������ģ��
========
��Ҫ���ࣺconfig.php forms.php class_DataBase.php SmartTemplate
========
��Ҫ���ܣ���$a == ��
--------------------
���ӹ��� (function)
-------------------

����Ȩ�޵�˵��
==============

==============
Author:Victor_Dinho
E-Mail:dinho.victor@gmail.com
*/
if (DINHO != 1)
{
	header('HTTP/1.1  404  Not  Found');  
	header('status:  404  Not  Found');  
	exit();
}
$num_in_page = 20; //ÿҳ��ʾ����
//�û����ݱ��Ѱ���admin.php
switch($usr->rights['Admin'])
{
case 'S':  //��������Ա
	$allow = array(
		'add' => 2, 'doadd' => 2, 'list' => 2, 'edit' => 2, 'doedit' => 2, 'del' => 2, 'resettime' => 2,
		);
	//�û�Ȩ����Ȩ
	$rightslist = array(
		'Myoa' => array('N' => "��Ȩ��", 'M' => "��������Ա", 'A' => 'һ������Ա', 'S' => '��������Ա'),
		'Config' => array('N' => "��Ȩ��", 'M' => "��������Ա", 'A' => 'һ������Ա', 'S' => '��������Ա'),
		'User' => array('N' => "��Ȩ��", 'M' => "��������Ա", 'A' => 'һ������Ա', 'S' => '��������Ա'),
		'News' => array('N' => "��Ȩ��", 'M' => "��������Ա", 'A' => 'һ������Ա', 'S' => '��������Ա'),
		'Note' => array('N' => "��Ȩ��", 'M' => "��������Ա", 'A' => 'һ������Ա', 'S' => '��������Ա'),
		'Contract' => array('N' => "��Ȩ��", 'M' => "��������Ա", 'A' => 'һ������Ա', 'S' => '��������Ա'),
		'Ad' => array('N' => "��Ȩ��", 'M' => "��������Ա", 'A' => 'һ������Ա', 'S' => '��������Ա'),
		'Friend' => array('N' => "��Ȩ��", 'M' => "��������Ա", 'A' => 'һ������Ա', 'S' => '��������Ա'),
		'Stat' => array('N' => "��Ȩ��", 'M' => "��������Ա", 'A' => 'һ������Ա', 'S' => '��������Ա'),
		'Admin' => array('N' => "��Ȩ��", 'M' => "��������Ա", 'A' => 'һ������Ա', 'S' => '��������Ա'),
	);
	break;
case 'A':  //һ������Ա
	$allow = array(
		'add' => 1, 'doadd' => 1, 'list' => 2, 'edit' => 1, 'doedit' => 1, 'del' => 0, 'resettime' => 0,
		);
	//�û�Ȩ����Ȩ
	$rightslist = array(
		'Myoa' => array('N' => "��Ȩ��", 'M' => "��������Ա"),
		'Config' => array('N' => "��Ȩ��", 'M' => "��������Ա"),
		'User' => array('N' => "��Ȩ��", 'M' => "��������Ա"),
		'News' => array('N' => "��Ȩ��", 'M' => "��������Ա"),
		'Note' => array('N' => "��Ȩ��", 'M' => "��������Ա"),
		'Contract' => array('N' => "��Ȩ��", 'M' => "��������Ա"),
		'Ad' => array('N' => "��Ȩ��", 'M' => "��������Ա"),
		'Friend' => array('N' => "��Ȩ��", 'M' => "��������Ա"),
		'Stat' => array('N' => "��Ȩ��", 'M' => "��������Ա"),
		'Admin' => array('N' => "��Ȩ��", 'M' => "��������Ա"),
	);
	break;
default:  //����
	$allow = array(
		'add' => 0, 'doadd' => 0, 'list' => 0, 'show' => 0, 'edit' => 0, 'doedit' => 0,
		);
	break;
}

if (!($allow[$a] > 0)) $Form->oa_exit("��û��Ȩ��ִ�иò���~~");

//Ĭ��Ȩ��
if ($a == 'add')  //����û�
{
	$defaultright = array(
		'Myoa' => 'M',
		'Config' => 'N',
		'User' => 'M',
		'News' => 'M',
		'Note' => 'M',
		'Contract' => 'N',
		'Ad' => 'N',
		'Friend' => 'N',
		'Stat' => 'N',
		'Admin' => 'N',
	);
	$Form->cpheader('����û�');
	$Form->formheader(array(
		'title' => "����û�",
		'action' => "admin.php?j=Admin&a=doadd"
	));
	$Form->makeinput(array(
		'text'  => "�û���",
		'name'  => "user_id",
		'value'  => "",
	));
	$Form->makeinput(array(
		'text'  => "�û���Чʱ��",
		'note' => "��λ���죬�ձ�ʾ����ʱ��",
		'name'  => "available_time",
		'value'  => "",
	));
	$Form->maketd(array(
		'<b>����</b>','111111  �����ڵ�һ�ε�¼ʱ�����޸ģ�'
	));
	$Form->maketd(array('colspan=2' => "<font color=red><b>�������û���Ȩ������</b></font>"));
	$i = 0;
	foreach($modulename as $k => $v)
	{
		if ($rightslist[$k])
		{
			$Form->makeradio(array(
				'text'  => $v,
				'name'  => "rights[".$k."]",
				'label' => $k,
				'option'  => $rightslist[$k],
				'selected' => $defaultright[$k],
			));
		}
	}
	$Form->maketd(array('colspan=2' => "<font color=blue><b>�������û�����ϵ����</b></font>"));
	$Form->makeinput(array(
		'text'  => "QQ",
		'name'  => "qq",
		'value'  => "",
	));
	$Form->makeinput(array(
		'text'  => "E-mail",
		'name'  => "email",
		'value'  => "",
	));
	$Form->maketextarea(array(
		'text'  => "��ע",
		'note'  => "������ϵ��Ϣ",
		'name'  => "other",
		'value'  => "",
	), 0);
	$Form->formfooter();
	$Form->cpfooter();
}
elseif ($a == 'doadd')  //ִ������û�
{
	$username = checkStr(strtolower($_POST['user_id']));
	if (!$username) $Form->oa_exit("����д�û�����~");
	$sql = "select count(*) from {$db_admin} where `username`='{$username}'";
	if ($db->fetch_one($sql)) $Form->oa_exit("���û����Ѿ����ڣ�~");

	foreach($modulename as $k => $v)
	{
		$rights[$k] = (isset($rightslist[$k][$_POST["rights"][$k]])) ? $_POST["rights"][$k] : 'N';
	}
	$db->insert($db_admin,array(
		'username' => $username,
		'password' => '96e79218965eb72c92a549dd5a330112',//��ʼ���� 111111
		'available_time' => intval($_POST['available_time']),
		'usable' => 1,
		'time' => time(),
		'R_Myoa' => $rights["Myoa"],
		'R_Config' => $rights["Config"],
		'R_User' => $rights["User"],
		'R_News' => $rights["News"],
		'R_Note' => $rights["Note"],
		'R_Contract' => $rights["Contract"],
		'R_Ad' => $rights["Ad"],
		'R_Friend' => $rights["Friend"],
		'R_Stat' => $rights["Stat"],
		'R_Admin' => $rights["Admin"],
		'qq' => checkStr($_POST['qq']),
		'email' => checkStr($_POST['email']),
		'other' => str2html($_POST['other']),
		));
	$Form->oa_exit("����û��ɹ�!","admin.php?j=Admin&a=list");
}
elseif ($a == 'list') //�û��б�
{
	$sql_num = "select count(*) from ".$db_admin." where 1";
	$listNum = $db->fetch_one($sql_num);
	$formtitle = "{$statetitle} [��".$listNum."��] [{$num_in_page}��/ҳ]";

	$cpage = isset($_GET['page']) ? intval($_GET['page']) : 1;
	$page_char = page($listNum,$num_in_page,$cpage,"admin.php?j=Admin&a=list");
	$limitS = $cpage*$num_in_page-$num_in_page;

	$Form->cpheader();
	if($listNum > 0)
	{
		$Form->tableheaderbig(array(
			"title" => $formtitle,
			"colspan" => "4",
		));
		echo "<tr align=\"center\">\n";
		echo "<td width=\"28%\"><b>�û���</b></td>\n";
		echo "<td width=\"34%\"><b>Ȩ��</b></td>\n";
		echo "<td width=\"20%\"><b>����¼ʱ��</b></td>\n";
		echo "<td width=\"18%\"><b>����¼ip</b></td>\n";
		echo "</tr>\n";
		$lstWork = "select * from ".$db_admin." where 1 order by `id` asc limit ".$limitS.",".$num_in_page;
		$vRe = $db->query($lstWork);
		while($uL = $db->fetch_array($vRe)) 
		{
			if ($uL['active'] == '0') 
			{
				$user_id = "<font color=red>".$uL['username']."</font>";
			}
			else
			{
				$user_id = $uL['username'];
			}
			if ($uL['last_time'] == '0')
				$last_time = '';
			else
				$last_time = date('Y-m-d H:i:s', $uL['last_time']);
			echo "<tr align=\"center\">\n";
			echo "<td align=\"left\"><a href=\"admin.php?j=Admin&a=edit&id={$uL['id']}\">{$user_id}</a></td>\n";
			echo "<td>{$uL['R_Myoa']} {$uL['R_Config']} {$uL['R_User']} {$uL['R_News']} {$uL['R_Note']} {$uL['R_Contract']} {$uL['R_Ad']} {$uL['R_Friend']} {$uL['R_Vote']} {$uL['R_Stat']} {$uL['R_Admin']}</td>\n";
			echo "<td>".$last_time."</td>\n";
			echo "<td>{$uL['last_ip']}</td>\n";
			echo "</tr>\n";
		}
		echo "<tr><td colspan=\"4\" align=\"right\">{$page_char}</td></tr>";
		$Form->tablefooter(array("colspan" => "4"));
	}
	else
	{
		$Form->tableheaderbig(array("title" => $formtitle,));
		$Form->maketd(array("��ʱû���û�~~"));
		$Form->tablefooter();
	}
	$Form->cpfooter();
}
elseif ($a == 'edit')  //�༭�û�
{
	$id = intval($_GET['id']);
	$sql = "select * from ".$db_admin." where `id`='".$id."'";
	$uL = $db->fetch_one_array($sql);
	
	if (empty($uL)) $Form->oa_exit("���û�������");
	
	$rightname = array('N' => "��Ȩ��", 'M' => "��������Ա", 'A' => "һ������Ա", 'S' => "��������Ա");
	$defaultright = array(
		'Myoa' => $uL['R_Myoa'],
		'Config' => $uL['R_Config'],
		'User' => $uL['R_User'],
		'News' => $uL['R_News'],
		'Note' => $uL['R_Note'],
		'Contract' => $uL['R_Contract'],
		'Ad' => $uL['R_Ad'],
		'Friend' => $uL['R_Friend'],
		'Stat' => $uL['R_Stat'],
		'Admin' => $uL['R_Admin'],
	);
	$Form->cpheader('����û�');
	$Form->formheader(array(
		'title' => "����û�",
		'action' => "admin.php?j=Admin&a=doedit"
	));
	$Form->maketd(array(
		"�û���",
		$uL['username']
	));
	$Form->makeinput(array(
		'text'  => "�û���Чʱ��",
		'note' => "��λ���죬�ձ�ʾ����ʱ��",
		'name'  => "available_time",
		'value'  => $uL['available_time'],
	));	$Form->maketd(array(
		"��ʼ��������",
		date('Y-m-d',$uL['time'])."&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<font color=red><a href=\"admin.php?j=Admin&a=resettime&id=".$uL['id']."\">��������</a></font>",
	));

	$Form->makehidden(array(
		'name' => "id",
		'value' => $uL['id']
	));
	$Form->maketd(array('colspan=2' => "<font color=red><b>�������û���Ȩ������</b></font>"));
	$i = 0;
	foreach($modulename as $k => $v)
	{
		if ($rightslist[$k])
		{
			if (($defaultright[$k] == 'A' || $defaultright[$k] == 'S') && $allow['edit'] < 2)
			{
				$Form->maketd(array($v,$rightname[$defaultright[$k]]));
			}
			else
			{
				$Form->makeradio(array(
					'text'  => $v,
					'name'  => "rights[".$k."]",
					'label' => $k,
					'option'  => $rightslist[$k],
					'selected' => $defaultright[$k],
				));
			}
		}
	}
	$Form->maketd(array('colspan=2' => "<font color=blue><b>�������û�����ϵ����</b></font>"));
	$Form->makeinput(array(
		'text'  => "QQ",
		'name'  => "qq",
		'value'  => $uL['qq'],
	));
	$Form->makeinput(array(
		'text'  => "E-mail",
		'name'  => "email",
		'value'  => $uL['email'],
	));
	$Form->maketextarea(array(
		'text'  => "��ע",
		'note'  => "������ϵ��Ϣ",
		'name'  => "other",
		'value'  => html2str($uL['other']),
	), 0);
	if ($allow['del'])
	{
		$Form->formfooter(array(
			"button" => array(
				array('value'=>"����"),
				array('value'=>"����", 'type'=>"reset"),
				array('value'=>"ɾ��", 'type'=>"button", 'extra' => "onclick=\"ifDel('admin.php?j=Admin&a=del&id=".$uL['id']."')\""),
				array('value'=>"����", 'type'=>"button", 'extra' => "onclick=\"goto('admin.php?j=Admin&a=list')\""),
			)));
	}
	else
	{
		$Form->formfooter(array(
			"button" => array(
				array('value'=>"����"),
				array('value'=>"����", 'type'=>"reset"),
				array('value'=>"����", 'type'=>"button", 'extra' => "onclick=\"goto('admin.php?j=Admin&a=list')\""),
			)));
	}
	$Form->If_Del();
	echo "<script>function goto(url){this.location.replace(url);}</script>";
	$Form->cpfooter();
}
elseif ($a == 'doedit')  //ִ�б༭�û�
{
	$id = intval($_POST['id']);
	$sql = "select * from ".$db_admin." where `id`='".$id."'";
	$uL = $db->fetch_one_array($sql);
	
	if (empty($uL)) $Form->oa_exit("���û�������");

	$updarray = array(
		'available_time' => intval($_POST['available_time']),
		'qq' => checkStr($_POST['qq']),
		'email' => checkStr($_POST['email']),
		'other' => str2html($_POST['other']),
	);
	foreach($modulename as $k => $v)
	{
		if (isset($_POST["rights"][$k]) && isset($rightslist[$k][$_POST["rights"][$k]]))
		{
			$r = 'R_'.$k;
			$updarray[$r] = $_POST["rights"][$k];
		}
	}
	$db->update($db_admin,$updarray,"`id`='{$id}'");
	$Form->oa_exit("�༭�û��ɹ�!���ý����û��´ε�¼��Ч","admin.php?j=Admin&a=list");
}
elseif ($a == 'del')  //ɾ���û�
{
	$id = intval($_GET['id']);
	$sql = "select count(*) from ".$db_admin." where `id`='".$id."'";
	$num = $db->fetch_one($sql);
	
	if (!($num)) $Form->oa_exit("���û�������");

	$db->query("delete from ".$db_admin." where `id`='".$id."'");
	$Form->oa_exit("ɾ���û��ɹ�!","admin.php?j=User&a=list");
}
elseif ($a == 'resettime') //��������ʱ��
{
	$id = intval($_GET['id']);
	$db->update($db_admin,array(
		'time' => time(),
		'usable' => 1,
		), "`id`=$id");
	$Form->oa_exit("����ʱ��ɹ�", "admin.php?j=Admin&a=edit&id={$id}");
}
else
{
	$Form->oa_exit("���ܲ�����","index.php?a=main");
}

?>