<?php
/*
���Ź���ģ��
========
��Ҫ���ࣺconfig.php forms.php class_DataBase.php SmartTemplate class_User.php
========
��Ҫ���ܣ���$a == ��
--------------------
basic ��������	dobasic ִ�л�������	delpic ɾ��LOGO
security ��ȫ����	dosecurity ִ�а�ȫ����
company ��˾����	docompany ִ�й�˾����
us ���������б�	addus	��ӹ�������	doaddus ִ����ӹ�������	editus �༭��������	doeditus ִ�б༭��������	delus ɾ����������
data ��������
area �����б�	addarea ��ӵ���	doaddarea ִ����ӵ���	editarea �༭����	doeditarea ִ�б༭����	delarea ɾ������
degree ѧ���б�	adddegree ���ѧ��	doadddegree ִ�����ѧ��	editdegree �༭ѧ��	doeditdegree ִ�б༭ѧ��	deldegree ɾ��ѧ��
service �����б�	addservice ��ӷ���	doaddservice ִ����ӷ���	editservice �༭����	doeditservice ִ�б༭����	delservice ɾ������
index ��ҳ����	doindex ִ����ҳ����
nav	�������б�	editnav	�༭������

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
$db_config = "`".$mysql_prefix."config`"; //�������ݱ�
$db_us = "`".$mysql_prefix."company`"; //�����������ݱ�
$db_area = "`".$mysql_prefix."area`"; //�������ݱ�
$db_degree = "`".$mysql_prefix."degree`"; //ѧ�����ݱ�
$db_service = "`".$mysql_prefix."service`"; //�������ݱ�
$db_nav = "`".$mysql_prefix."navigator`"; //���������ݱ�
$imgPath = "../attachment/config/"; //LOGOĿ¼
$num_in_page = 20;  //ÿҳ��ʾ��Ŀ

$allow = array();

switch($usr->rights['News'])
{
case 'S':  //��������Ա
	$allow = array(
		'basic' => 2, 'dobasic' => 2, 'delpic' => 2,
		'security' => 2, 'dosecurity' => 2,
		'company' => 2, 'docompany' => 2,
		'us' => 2, 'addus' => 2, 'doaddus' => 2, 'editus' => 2, 'doeditus' => 2, 'delus' => 2,
		'data' => 2,
		'area' => 2, 'addarea' => 2, 'doaddarea' => 2, 'editarea' => 2, 'doeditarea' => 2, 'delarea' => 2,
		'degree' => 2, 'adddegree' => 2, 'doadddegree' => 2, 'editdegree' => 2, 'doeditdegree' => 2, 'deldegree' => 2,
		'service' => 2, 'addservice' => 2, 'doaddservice' => 2, 'editservice' => 2, 'doeditservice' => 2, 'delservice' => 2,
		'index' => 2, 'doindex' => 2,
		'nav' => 2, 'editnav' => 2,
		);
	break;
default:  //��Ȩ��
	$allow = array(
		'basic' => 0, 'dobasic' => 0, 'delpic' => 0,
		'security' => 0, 'dosecurity' => 0,
		'company' => 0, 'docompany' => 0,
		'us' => 0, 'addus' => 0, 'doaddus' => 0, 'editus' => 0, 'doeditus' => 0, 'delus' => 0,
		'data' => 0,
		'area' => 0, 'addarea' => 0, 'doaddarea' => 0, 'editarea' => 0, 'doeditarea' => 0, 'delarea' => 0,
		'degree' => 0, 'adddegree' => 0, 'doadddegree' => 0, 'editdegree' => 0, 'doeditdegree' => 0, 'deldegree' => 0,
		'service' => 0, 'addservice' => 0, 'doaddservice' => 0, 'editservice' => 0, 'doeditservice' => 0, 'delservice' => 0,
		'index' => 2, 'doindex' => 2,
		'nav' => 0, 'editnav' => 0,
		);
	break;
}

if (!($allow[$a] > 0)) $Form->oa_exit("��û��Ȩ��ִ�иò���~~");

if ($a == 'basic') //��������
{
	$config_sql = "select * from ".$db_config." where 1";
	$query = $db->query($config_sql);
	$config = $db->fetch_array($query);

	if ($handle = @opendir('../template')) {
		while (false !== ($file = readdir($handle))) {
			if(is_dir('../template/'.$file) && $file != "." && $file != "..") {
				$dir[$file] = $file;
			}
		}
		closedir($handle);
	}
	$Form->cpheader("��������");
	$Form->formheader(array(
		'title' => "��������",
		'action' => "admin.php?j=Config&a=dobasic",
		'enctype' => "multipart/form-data",
		));
	$Form->makeinput(array(
		'text' => "��վ����",
		'name' => "title",
		'size' => "50",
		'value' => $config['title'],
		));
	$Form->makeinput(array(
		'text' => "��վ����Ա",
		'name' => "admin",
		'value' => $config['admin'],
		));
	$Form->makeinput(array(
		'text' => "Email",
		'name' => "email",
		'value' => $config['email'],
		'size' => "50",
		));
	if (strlen($config['logo']) > 1)
	{
		$Form->if_Del();
		$Form->maketd(array("<b>LOGO</b><br/>(С��2M)","���ϴ���[<a href=\"{$imgPath}{$config['logo']}\" target=\"_blank\">�鿴</a>] [<a href=\"#\" onclick=\"ifDel('admin.php?j=Config&a=delpic')\">ɾ��</a>]"));
	}
	else
	{
		$Form->makefile(array(
			'text' => "LOGO",
			'note' => "(С��2M)",
			'name' => "file",
			'size' => "50"
			));
	}
	if (strlen($config['link_logo']) > 1)
	{
		$Form->if_Del();
		$Form->maketd(array("<b>��������LOGO</b><br/>(С��2M)","���ϴ���[<a href=\"{$imgPath}{$config['link_logo']}\" target=\"_blank\">�鿴</a>] [<a href=\"#\" onclick=\"ifDel('admin.php?j=Config&a=delpic&t=1')\">ɾ��</a>]"));
	}
	else
	{
		$Form->makefile(array(
			'text' => "��������LOGO",
			'note' => "(С��2M)",
			'name' => "link_logo",
			'size' => "50"
			));
	}
	$Form->maketextarea(array(
		'text' => "��վ����",
		'name' => "intro",
		'value' => $config['intro'],
		), 0);
	$Form->maketextarea(array(
		'text' => "META�ؼ���",
		'note' => "����������������������վ",
		'name' => "keyword",
		'value' => $config['keyword'],
		), 0);
	$Form->maketextarea(array(
		'text' => "META����",
		'note' => "����������ʾ������",
		'name' => "description",
		'value' => $config['description'],
		), 0);
	$Form->makeinput(array(
		'text' => "ICP������Ϣ",
		'name' => "ICPinfo",
		'size' => "50",
		'value' => $config['icpinfo'],
		));
	$Form->makeinput(array(
		'text' => "ICP������Ϣ���ӵ�ַ",
		'name' => "ICPlink",
		'size' => "50",
		'value' => $config['icplink'],
		));
	$Form->maketextarea(array(
		'text' => "ע�����Э��",
		'name' => "reginfo",
		'value' => $config['reginfo'],
		), 0);
	$Form->makeselect(array(
				"text"  => "�趨ģ��",
				"note"  => "ѡ����Ҫʹ�õ�ģ��",
				"name"  => "template",
				"option" => $dir,
				"selected" => $config['template'],
            ));
	$Form->formfooter(array(
		"button" => array(
			array('value'=>"ȷ��"),
			array('value'=>"����",'type'=>"reset"),
		)));
}
elseif ($a == 'dobasic') //ִ�л�������
{
	require("class/class_Upload.php");
	$filepath = $_FILES['file']['name'];
	if (strlen($filepath) > 0)
	{
		$upd = new cUpload;
		$filetmp = $_FILES['file']['tmp_name'];
		$filesize = $_FILES['file']['size'];
		if($filesize == 0) $Form->oa_exit("�ļ�������ļ�������");
		$extname = $upd->getext($filepath);
		$uploadpath = "logo_".date('ydmHis').".".$extname;
		switch($upd->upload($filetmp,$imgPath.$uploadpath))
		{
		case 1:
			$Form->oa_exit("�ļ����Ͳ�����");break;
		case 2:
			$Form->oa_exit("�ϴ����������������");break;
		default:
		}
		$db->update($db_config,array(
			'logo' => $uploadpath,
			),"`id`=1");
	}
	$filepath = $_FILES['link_logo']['name'];
	if (strlen($filepath) > 0)
	{
		$upd2 = new cUpload;
		$filetmp = $_FILES['link_logo']['tmp_name'];
		$filesize = $_FILES['link_logo']['size'];
		if($filesize == 0) $Form->oa_exit("�ļ�������ļ�������");
		$extname = $upd2->getext($filepath);
		$uploadpath = "llogo_".date('ydmHis').".".$extname;
		switch($upd2->upload($filetmp,$imgPath.$uploadpath))
		{
		case 1:
			$Form->oa_exit("�ļ����Ͳ�����");break;
		case 2:
			$Form->oa_exit("�ϴ����������������");break;
		default:
		}
		$db->update($db_config,array(
			'link_logo' => $uploadpath,
			),"`id`=1");
	}
	$db->update($db_config,array(
		'title' => $_POST['title'],
		'admin' => $_POST['admin'],
		'email' => $_POST['email'],
		'intro' => $_POST['intro'],
		'keyword' => $_POST['keyword'],
		'description' => $_POST['description'],
		'icpinfo' => $_POST['icpinfo'],
		'icplink' => $_POST['icplink'],
		'reginfo' => $_POST['reginfo'],
		'template' => $_POST['template'],
		),"`id`=1");
	$Form->oa_exit("�ɹ��޸Ļ�������", "admin.php?j=Config&a=basic");
}
elseif($a == 'delpic') //ɾ��ѡ��ͼƬ
{
	$sql = "select `logo` from ".$db_config." where `id`=1";
	$filepath = $db->fetch_one($sql);
	$db->update($db_config,array(
		'logo' => "",
		),"`id`=1");
	@unlink ($imgPath.$filepath);
	$Form->oa_exit("LOGOɾ���ɹ�","admin.php?j=Config&a=basic");
}
elseif ($a == 'security') //��ȫ����
{
	$select = array('��', '��');
	$config_sql = "select * from ".$db_config." where 1";
	$query = $db->query($config_sql);
	$config = $db->fetch_array($query);

	$Form->cpheader("��ȫ����");
	$Form->formheader(array(
		'title' => "��ȫ����",
		'action' => "admin.php?j=Config&a=dosecurity",
		));
	$Form->makehidden(array(
		'name' => "hidden",
		'size' => "50",
		));
	$Form->makeselect(array(
		'name' => "regverify",
		'text' => "ע����֤�빦��",
		'note' => "ֻ���ڷ�����֧��GDʱ�ſ��Կ���",
		'option' => $select,
		'selected' => $config['regverify'],
		));
	$Form->makeselect(array(
		'name' => "commentverify",
		'text' => "������֤�빦��",
		'note' => "ֻ���ڷ�����֧��GDʱ�ſ��Կ���",
		'option' => $select,
		'selected' => $config['commentverify'],
		));
	$Form->makeselect(array(
		'name' => "noteverify",
		'text' => "������֤�빦��",
		'note' => "ֻ���ڷ�����֧��GDʱ�ſ��Կ���",
		'option' => $select,
		'selected' => $config['noteverify'],
		));
	$Form->makeselect(array(
		'name' => "oaloginverify",
		'text' => "��̨��¼��֤�빦��",
		'note' => "ֻ���ڷ�����֧��GDʱ�ſ��Կ���",
		'option' => $select,
		'selected' => $config['oaloginverify'],
		));
	$Form->formfooter(array(
		"button" => array(
			array('value'=>"ȷ��"),
			array('value'=>"����",'type'=>"reset"),
		)));
}
elseif ($a == 'dosecurity') //ִ�а�ȫ����
{
	$db->update($db_config,array(
		'regverify' => $_POST['regverify'],
		'commentverify' => $_POST['commentverify'],
		'noteverify' => $_POST['noteverify'],
		'oaloginverify' => $_POST['oaloginverify'],
		),"`id`=1");
	$Form->oa_exit("�ɹ��޸İ�ȫ����", "admin.php?j=Config&a=security");
}
elseif ($a == 'company') //��˾����
{
	$config_sql = "select * from ".$db_config." where 1";
	$query = $db->query($config_sql);
	$config = $db->fetch_array($query);

	$Form->cpheader("��˾����");
	$Form->formheader(array(
		'title' => "��˾����",
		'action' => "admin.php?j=Config&a=docompany",
		));
	$Form->makeinput(array(
		'text' => "�绰����",
		'name' => "telephone",
		'value' => $config['telephone'],
		));
	$Form->makeinput(array(
		'text' => "����",
		'name' => "fax",
		'value' => $config['fax'],
		));
	$Form->makeinput(array(
		'text' => "��ַ",
		'name' => "address",
		'size' => "100",
		'value' => $config['address'],
		));
	$Form->formfooter(array(
		"button" => array(
			array('value'=>"ȷ��"),
			array('type' => "button", 'value'=>"��Ӹ���", "extra"=>"onclick=\"goto('admin.php?j=Config&a=us')\""),
			array('value'=>"����",'type'=>"reset"),
		)));
	echo "<script>function goto(url){this.location.replace(url);}</script>";
}
elseif ($a == 'docompany') //ִ�й�˾����
{
	$db->update($db_config,array(
		'telephone' => $_POST['telephone'],
		'fax' => $_POST['fax'],
		'address' => $_POST['address'],
		),"`id`=1");
	$Form->oa_exit("�ɹ��޸Ĺ�˾����", "admin.php?j=Config&a=company");
}
elseif ($a == 'us') //��˾ѡ���б�
{
	$sql_num = "select count(*) from ".$db_us." where 1";
	$listNum = $db->fetch_one($sql_num);
	$formtitle = "��˾ѡ�� [��".$listNum."��] [{$num_in_page}��/ҳ]";

	$config_sql = "select `template` from ".$db_config." where 1";
	$template = $db->fetch_one($config_sql);
	$iconPath = "../template/".$template."/images/icons/";

	$cpage = isset($_GET['page']) ? intval($_GET['page']) : 1;
	$page_char = page($listNum,$num_in_page,$cpage,"admin.php?j=Config&a=us");
	$limitS = $cpage*$num_in_page-$num_in_page;

	$Form->cpheader();
	if($listNum > 0)
	{
		$Form->tableheaderbig(array(
			"title" => $formtitle,
			"colspan" => "3",
		));
		echo "<tr align=\"center\">\n";
		echo "<td width=\"25%\"><b>ѡ��</b></td>\n";
		echo "<td width=\"50%\"><b>����</b></td>\n";
		echo "<td width=\"25%\"><b>����</b></td>\n";
		echo "</tr>\n";
		$lstRequest = "select * from ".$db_us." where 1 order by `id` desc limit ".$limitS.",".$num_in_page;
		$vRe = $db->query($lstRequest);
		while($nL = $db->fetch_array($vRe)) 
		{
			$icon = $iconPath.$nL['icon'];
			echo "<tr align=\"center\">\n";
			echo "<td>".$nL['name']."</td>\n";
			echo "<td>".gbsubstr($nL['content'],0,100)."</td>\n";
			echo "<td align=\"center\"><a href=\"admin.php?j=Config&a=editus&id=".$nL['id']."\">�޸�</a> <a href=\"admin.php?j=Config&a=delus&id=".$nL['id']."\">ɾ��</a></td>\n";
			echo "</tr>\n";
		}
		echo "<tr><td colspan=\"3\" align=\"right\">".$page_char."</td></tr>";
		$Form->formfooter(array(
			"colspan"=>'3',
			"button" => array(
				array('value'=>"���", 'type'=>"button", 'extra' => "onclick=\"goto('admin.php?j=Config&a=addus')\""),
				array('value'=>"����", 'type'=>"button", 'extra' => "onclick=\"goto('admin.php?j=Config&a=company')\""),
			)));
		$Form->tablefooter(array("colspan" => "4"));
	}
	else
	{
		$Form->tableheaderbig(array("title" => $formtitle,));
		$Form->maketd(array("��ʱû�й�˾ѡ��~~"));
		$Form->formfooter(array(
			"colspan"=>'4',
			"button" => array(
				array('value'=>"���", 'type'=>"button", 'extra' => "onclick=\"goto('admin.php?j=Config&a=addus')\""),
				array('value'=>"����", 'type'=>"button", 'extra' => "onclick=\"goto('admin.php?j=Config&a=company')\""),
			)));
		$Form->tablefooter();
	}
	echo "<script>function goto(url){this.location.replace(url);}</script>";
	$Form->cpfooter();
}
elseif ($a == 'addus') //��ӹ�˾ѡ��
{
	$Form->cpheader("��ӹ�˾ѡ��");
	$Form->change();
	$Form->formheader(array(
		'title' => "��ӹ�˾ѡ��",
		'action' => "admin.php?j=Config&a=doaddus"
		));
	$Form->makeinput(array(
		'text' => "����",
		'name' => "name",
		'size' => "50",
		));
	$Form->maketextarea(array(
		'text' => "����",
		'name' => "content",
		'cols' => "600",
		'rows' => "400",
		'value' => $config['content'],
		));
	$Form->formfooter(array(
		"button" => array(
			array('value'=>"���"),
			array('value'=>"����",'type'=>"reset"),
			array('value'=>"����", 'type'=>"button", 'extra' => "onclick=\"goto('admin.php?j=Config&a=us')\""),
		)));
	echo "<script>function goto(url){this.location.replace(url);}</script>";
	$Form->cpfooter();
}
elseif ($a == 'doaddus') //ִ����ӹ�˾ѡ��
{
	$name = $_POST['name'];
	if (!$name) $Form->oa_exit("����д��˾ѡ������");
	$db->insert($db_us,array(
		'name' => $name,
		'content' => $_POST['content'],
		));
	$Form->oa_exit("��ӹ�˾ѡ��ɹ�","admin.php?j=Config&a=us");
}
elseif ($a == 'editus') //�༭��˾ѡ��
{
	if (!isset($_GET['id']))
		$Form->oa_exit("��������");
	$id = $_GET['id'];
	$sql_num = "select count(*) from ".$db_us." where `id`=".$id;
	if ($db->fetch_one($sql_num) == 0)
		$Form->oa_exit("�����������˾ѡ��");
	$sql = "select * from ".$db_us." where `id`=".$id;
	$query = $db->query($sql);
	$info = $db->fetch_array($query);
	$Form->cpheader("�༭��˾ѡ��");
	$Form->change();
	$Form->formheader(array(
		'title' => "�༭��˾ѡ��",
		'action' => "admin.php?j=Config&a=doeditus"
		));
	$Form->makehidden(array(
		'name' => "id",
		'value' => $id
		));
	$Form->makehidden(array(
		'name' => "template",
		'value' => $path,
		'id' => "template",
		));
	$Form->makeinput(array(
		'text' => "����",
		'name' => "name",
		'size' => "50",
		'value' => $info['name'],
		));
	$Form->maketextarea(array(
		'text' => "����",
		'name' => "content",
		'cols' => "600",
		'rows' => "400",
		'value' => $info['content'],
		));
	$Form->formfooter(array(
		"button" => array(
			array('value'=>"�޸�"),
			array('value'=>"����",'type'=>"reset"),
			array('value'=>"����", 'type'=>"button", 'extra' => "onclick=\"goto('admin.php?j=Config&a=us')\""),
		)));
	echo "<script>function goto(url){this.location.replace(url);}</script>";
	$Form->cpfooter();
}
elseif ($a == 'doeditus') //ִ�б༭��˾ѡ��
{
	$name = $_POST['name'];
	$id = $_POST['id'];
	if (!$name) $Form->oa_exit("����д��˾ѡ������");
	$db->update($db_us,array(
		'name' => $name,
		'content' => $_POST['content'],
		),"`id`={$id}");
	$Form->oa_exit("�༭��˾ѡ��ɹ�","admin.php?j=Config&a=us");
}
elseif ($a == 'delus') //ɾ����˾ѡ��
{
	$id = intval($_GET['id']);
	$sql = "select count(*) from ".$db_us." where `id`='".$id."'";
	$num = $db->fetch_one($sql);
	
	if (!($num)) $Form->oa_exit("�ù�˾ѡ�����");

	$db->query("delete from ".$db_us." where `id`='".$id."'");
	$Form->oa_exit("ɾ����˾ѡ��ɹ�!","admin.php?j=Config&a=us");
}
elseif ($a == 'data') //��������
{
	$formtitle = "��������";
	$Form->cpheader();
	$Form->tableheaderbig(array(
		"title" => $formtitle,
		"colspan" => "3",
	));
	echo "<tr align=\"center\">\n";
	echo "<td width=\"34%\"><b>��������</b></td>\n";
	echo "<td width=\"33%\"><b>��������</b></td>\n";
	echo "<td width=\"33%\"><b>ѧ������</b></td>\n";
	echo "</tr>\n";
	echo "<tr align=\"center\">\n";
	echo "<td><a href=\"admin.php?j=Config&a=service\">�༭</a></td>\n";
	echo "<td><a href=\"admin.php?j=Config&a=area\">�༭</a></td>\n";
	echo "<td><a href=\"admin.php?j=Config&a=degree\">�༭</a></td>\n";
	echo "</tr>\n";
	$Form->tablefooter();
}
elseif ($a == 'service') //�����б�
{
	$sql_num = "select count(*) from ".$db_service." where 1";
	$listNum = $db->fetch_one($sql_num);
	$formtitle = "���� [��".$listNum."��] [{$num_in_page}��/ҳ]";

	$cpage = isset($_GET['page']) ? intval($_GET['page']) : 1;
	$page_char = page($listNum,$num_in_page,$cpage,"admin.php?j=Config&a=service");
	$limitS = $cpage*$num_in_page-$num_in_page;

	$Form->cpheader();
	if($listNum > 0)
	{
		$Form->tableheaderbig(array(
			"title" => $formtitle,
			"colspan" => "2",
		));
		echo "<tr align=\"center\">\n";
		echo "<td width=\"50%\"><b>����</b></td>\n";
		echo "<td width=\"50%\"><b>����</b></td>\n";
		echo "</tr>\n";
		$lstRequest = "select * from ".$db_service." where 1 order by `id` desc limit ".$limitS.",".$num_in_page;
		$vRe = $db->query($lstRequest);
		while($nL = $db->fetch_array($vRe)) 
		{
			echo "<tr align=\"center\">\n";
			echo "<td>".$nL['name']."</td>\n";
			echo "<td align=\"center\"><a href=\"admin.php?j=Config&a=editservice&id=".$nL['id']."\">�޸�</a> <a href=\"admin.php?j=Config&a=delservice&id=".$nL['id']."\">ɾ��</a></td>\n";
			echo "</tr>\n";
		}
		echo "<tr><td colspan=\"2\" align=\"right\">".$page_char."</td></tr>";
		$Form->formfooter(array(
			"colspan"=>'2',
			"button" => array(
				array('value'=>"��ӷ���", 'type'=>"button", 'extra' => "onclick=\"goto('admin.php?j=Config&a=addservice')\""),
				array('value'=>"����", 'type'=>"button", 'extra' => "onclick=\"goto('admin.php?j=Config&a=data')\""),
			)));
		$Form->tablefooter(array("colspan" => "2"));
	}
	else
	{
		$Form->tableheaderbig(array("title" => $formtitle,));
		$Form->maketd(array("��ʱû�з���~~"));
		$Form->formfooter(array(
			"colspan"=>'2',
			"button" => array(
				array('value'=>"��ӷ���", 'type'=>"button", 'extra' => "onclick=\"goto('admin.php?j=Config&a=addservice')\""),
				array('value'=>"����", 'type'=>"button", 'extra' => "onclick=\"goto('admin.php?j=Config&a=data')\""),
			)));
		$Form->tablefooter();
	}
	echo "<script>function goto(url){this.location.replace(url);}</script>";
	$Form->cpfooter();
}
elseif ($a == 'addservice') //��ӷ���
{
	$Form->cpheader("��ӷ���");
	$Form->formheader(array(
		'title' => "��ӷ���",
		'action' => "admin.php?j=Config&a=doaddservice"
		));
	$Form->makeinput(array(
		'text' => "��������",
		'name' => "name",
		'size' => "50",
		));
	$Form->makeinput(array(
		'text' => "�շѱ�׼",
		'name' => "fee",
		'size' => "60",
		));
	$Form->maketextarea(array(
		'text' => "������",
		'name' => "intro",
		), 0);
	$Form->formfooter(array(
		"button" => array(
			array('value'=>"���"),
			array('value'=>"����",'type'=>"reset"),
			array('value'=>"����", 'type'=>"button", 'extra' => "onclick=\"goto('admin.php?j=Config&a=service')\""),
		)));
	echo "<script>function goto(url){this.location.replace(url);}</script>";
	$Form->cpfooter();
}
elseif ($a == 'doaddservice') //ִ����ӷ���
{
	$name = $_POST['name'];
	if (!$name) $Form->oa_exit("����д��������");
	$db->insert($db_service,array(
		'name' => $name,
		'fee' => $_POST['fee'],
		'intro' => $_POST['intro'],
		));
	$Form->oa_exit("��ӷ���ɹ�","admin.php?j=Config&a=service");
}
elseif ($a == 'editservice') //�༭����
{
	if (!isset($_GET['id']))
		$Form->oa_exit("��������");
	$id = $_GET['id'];
	$sql_num = "select count(*) from ".$db_service." where `id`=".$id;
	if ($db->fetch_one($sql_num) == 0)
		$Form->oa_exit("�������������");
	$sql = "select * from ".$db_service." where `id`=".$id;
	$query = $db->query($sql);
	$info = $db->fetch_array($query);
	$Form->cpheader("�༭����");
	$Form->formheader(array(
		'title' => "�༭����",
		'action' => "admin.php?j=Config&a=doeditservice"
		));
	$Form->makehidden(array(
		'name' => "id",
		'value' => $id
		));
	$Form->makeinput(array(
		'text' => "��������",
		'name' => "name",
		'size' => "50",
		'value' => $info['name'],
		));
	$Form->makeinput(array(
		'text' => "�շѱ�׼",
		'name' => "fee",
		'size' => "60",
		'value' => $info['fee'],
		));
	$Form->maketextarea(array(
		'text' => "������",
		'name' => "intro",
		'value' => $info['intro'],
		), 0);
	$Form->formfooter(array(
		"button" => array(
			array('value'=>"�޸�"),
			array('value'=>"����",'type'=>"reset"),
			array('value'=>"����", 'type'=>"button", 'extra' => "onclick=\"goto('admin.php?j=Config&a=service')\""),
		)));
	echo "<script>function goto(url){this.location.replace(url);}</script>";
	$Form->cpfooter();
}
elseif ($a == 'doeditservice') //ִ�б༭����
{
	$name = $_POST['name'];
	$id = $_POST['id'];
	if (!$name) $Form->oa_exit("����д��������");
	$db->update($db_service,array(
		'name' => $name,
		'fee' => $_POST['fee'],
		'intro' => $_POST['intro'],
		),"`id`={$id}");
	$Form->oa_exit("�༭����ɹ�","admin.php?j=Config&a=service");
}
elseif ($a == 'delservice') //ɾ������
{
	$id = intval($_GET['id']);
	$sql = "select count(*) from ".$db_service." where `id`='".$id."'";
	$num = $db->fetch_one($sql);
	
	if (!($num)) $Form->oa_exit("�÷��񲻴���");

	$db->query("delete from ".$db_service." where `id`='".$id."'");
	$Form->oa_exit("ɾ������ɹ�!","admin.php?j=Config&a=service");
}
elseif ($a == 'area') //�����б�
{
	$sql_num = "select count(*) from ".$db_area." where 1";
	$listNum = $db->fetch_one($sql_num);
	$formtitle = "���� [��".$listNum."��] [{$num_in_page}��/ҳ]";

	$cpage = isset($_GET['page']) ? intval($_GET['page']) : 1;
	$page_char = page($listNum,$num_in_page,$cpage,"admin.php?j=Config&a=area");
	$limitS = $cpage*$num_in_page-$num_in_page;

	$Form->cpheader();
	if($listNum > 0)
	{
		$Form->tableheaderbig(array(
			"title" => $formtitle,
			"colspan" => "2",
		));
		echo "<tr align=\"center\">\n";
		echo "<td width=\"50%\"><b>����</b></td>\n";
		echo "<td width=\"50%\"><b>����</b></td>\n";
		echo "</tr>\n";
		$lstRequest = "select * from ".$db_area." where 1 order by `id` desc limit ".$limitS.",".$num_in_page;
		$vRe = $db->query($lstRequest);
		while($nL = $db->fetch_array($vRe)) 
		{
			echo "<tr align=\"center\">\n";
			echo "<td>".$nL['name']."</td>\n";
			echo "<td align=\"center\"><a href=\"admin.php?j=Config&a=editarea&id=".$nL['id']."\">�޸�</a> <a href=\"admin.php?j=Config&a=delarea&id=".$nL['id']."\">ɾ��</a></td>\n";
			echo "</tr>\n";
		}
		echo "<tr><td colspan=\"2\" align=\"right\">".$page_char."</td></tr>";
		$Form->formfooter(array(
			"colspan"=>'2',
			"button" => array(
				array('value'=>"��ӵ���", 'type'=>"button", 'extra' => "onclick=\"goto('admin.php?j=Config&a=addarea')\""),
				array('value'=>"����", 'type'=>"button", 'extra' => "onclick=\"goto('admin.php?j=Config&a=data')\""),
			)));
		$Form->tablefooter(array("colspan" => "2"));
	}
	else
	{
		$Form->tableheaderbig(array("title" => $formtitle,));
		$Form->maketd(array("��ʱû�е���~~"));
		$Form->formfooter(array(
			"colspan"=>'2',
			"button" => array(
				array('value'=>"��ӵ���", 'type'=>"button", 'extra' => "onclick=\"goto('admin.php?j=Config&a=addarea')\""),
				array('value'=>"����", 'type'=>"button", 'extra' => "onclick=\"goto('admin.php?j=Config&a=data')\""),
			)));
		$Form->tablefooter();
	}
	echo "<script>function goto(url){this.location.replace(url);}</script>";
	$Form->cpfooter();
}
elseif ($a == 'addarea') //��ӵ���
{
	$Form->cpheader("��ӵ���");
	$Form->formheader(array(
		'title' => "��ӵ���",
		'action' => "admin.php?j=Config&a=doaddarea"
		));
	$Form->makeinput(array(
		'text' => "��������",
		'name' => "name",
		'size' => "50",
		));
	$Form->formfooter(array(
		"button" => array(
			array('value'=>"���"),
			array('value'=>"����",'type'=>"reset"),
			array('value'=>"����", 'type'=>"button", 'extra' => "onclick=\"goto('admin.php?j=Config&a=area')\""),
		)));
	echo "<script>function goto(url){this.location.replace(url);}</script>";
	$Form->cpfooter();
}
elseif ($a == 'doaddarea') //ִ����ӵ���
{
	$name = $_POST['name'];
	if (!$name) $Form->oa_exit("����д��������");
	$db->insert($db_area,array(
		'name' => $name,
		));
	$Form->oa_exit("��ӵ����ɹ�","admin.php?j=Config&a=area");
}
elseif ($a == 'editarea') //�༭����
{
	if (!isset($_GET['id']))
		$Form->oa_exit("��������");
	$id = $_GET['id'];
	$sql_num = "select count(*) from ".$db_area." where `id`=".$id;
	if ($db->fetch_one($sql_num) == 0)
		$Form->oa_exit("�������������");
	$sql = "select * from ".$db_area." where `id`=".$id;
	$query = $db->query($sql);
	$info = $db->fetch_array($query);
	$Form->cpheader("�༭����");
	$Form->formheader(array(
		'title' => "�༭����",
		'action' => "admin.php?j=Config&a=doeditarea"
		));
	$Form->makehidden(array(
		'name' => "id",
		'value' => $id
		));
	$Form->makeinput(array(
		'text' => "��������",
		'name' => "name",
		'size' => "50",
		'value' => $info['name'],
		));
	$Form->formfooter(array(
		"button" => array(
			array('value'=>"�޸�"),
			array('value'=>"����",'type'=>"reset"),
			array('value'=>"����", 'type'=>"button", 'extra' => "onclick=\"goto('admin.php?j=Config&a=area')\""),
		)));
	echo "<script>function goto(url){this.location.replace(url);}</script>";
	$Form->cpfooter();
}
elseif ($a == 'doeditarea') //ִ�б༭����
{
	$name = $_POST['name'];
	$id = $_POST['id'];
	if (!$name) $Form->oa_exit("����д��������");
	$db->update($db_area,array(
		'name' => $name,
		),"`id`={$id}");
	$Form->oa_exit("�༭�����ɹ�","admin.php?j=Config&a=area");
}
elseif ($a == 'delarea') //ɾ������
{
	$id = intval($_GET['id']);
	$sql = "select count(*) from ".$db_area." where `id`='".$id."'";
	$num = $db->fetch_one($sql);
	
	if (!($num)) $Form->oa_exit("�õ���������");

	$db->query("delete from ".$db_area." where `id`='".$id."'");
	$Form->oa_exit("ɾ�������ɹ�!","admin.php?j=Config&a=area");
}
elseif ($a == 'degree') //ѧ���б�
{
	$sql_num = "select count(*) from ".$db_degree." where 1";
	$listNum = $db->fetch_one($sql_num);
	$formtitle = "ѧ�� [��".$listNum."��] [{$num_in_page}��/ҳ]";

	$cpage = isset($_GET['page']) ? intval($_GET['page']) : 1;
	$page_char = page($listNum,$num_in_page,$cpage,"admin.php?j=Config&a=degree");
	$limitS = $cpage*$num_in_page-$num_in_page;

	$Form->cpheader();
	if($listNum > 0)
	{
		$Form->tableheaderbig(array(
			"title" => $formtitle,
			"colspan" => "2",
		));
		echo "<tr align=\"center\">\n";
		echo "<td width=\"50%\"><b>ѧ��</b></td>\n";
		echo "<td width=\"50%\"><b>����</b></td>\n";
		echo "</tr>\n";
		$lstRequest = "select * from ".$db_degree." where 1 order by `id` desc limit ".$limitS.",".$num_in_page;
		$vRe = $db->query($lstRequest);
		while($nL = $db->fetch_array($vRe)) 
		{
			echo "<tr align=\"center\">\n";
			echo "<td>".$nL['name']."</td>\n";
			echo "<td align=\"center\"><a href=\"admin.php?j=Config&a=editdegree&id=".$nL['id']."\">�޸�</a> <a href=\"admin.php?j=Config&a=deldegree&id=".$nL['id']."\">ɾ��</a></td>\n";
			echo "</tr>\n";
		}
		echo "<tr><td colspan=\"2\" align=\"right\">".$page_char."</td></tr>";
		$Form->formfooter(array(
			"colspan"=>'2',
			"button" => array(
				array('value'=>"���ѧ��", 'type'=>"button", 'extra' => "onclick=\"goto('admin.php?j=Config&a=adddegree')\""),
				array('value'=>"����", 'type'=>"button", 'extra' => "onclick=\"goto('admin.php?j=Config&a=data')\""),
			)));
		$Form->tablefooter(array("colspan" => "2"));
	}
	else
	{
		$Form->tableheaderbig(array("title" => $formtitle,));
		$Form->maketd(array("��ʱû��ѧ��~~"));
		$Form->formfooter(array(
			"colspan"=>'2',
			"button" => array(
				array('value'=>"���ѧ��", 'type'=>"button", 'extra' => "onclick=\"goto('admin.php?j=Config&a=adddegree')\""),
				array('value'=>"����", 'type'=>"button", 'extra' => "onclick=\"goto('admin.php?j=Config&a=data')\""),
			)));
		$Form->tablefooter();
	}
	echo "<script>function goto(url){this.location.replace(url);}</script>";
	$Form->cpfooter();
}
elseif ($a == 'adddegree') //���ѧ��
{
	$Form->cpheader("���ѧ��");
	$Form->formheader(array(
		'title' => "���ѧ��",
		'action' => "admin.php?j=Config&a=doadddegree"
		));
	$Form->makeinput(array(
		'text' => "ѧ������",
		'name' => "name",
		'size' => "50",
		));
	$Form->formfooter(array(
		"button" => array(
			array('value'=>"���"),
			array('value'=>"����",'type'=>"reset"),
			array('value'=>"����", 'type'=>"button", 'extra' => "onclick=\"goto('admin.php?j=Config&a=degree')\""),
		)));
	echo "<script>function goto(url){this.location.replace(url);}</script>";
	$Form->cpfooter();
}
elseif ($a == 'doadddegree') //ִ�����ѧ��
{
	$name = $_POST['name'];
	if (!$name) $Form->oa_exit("����дѧ������");
	$db->insert($db_degree,array(
		'name' => $name,
		));
	$Form->oa_exit("���ѧ���ɹ�","admin.php?j=Config&a=degree");
}
elseif ($a == 'editdegree') //�༭ѧ��
{
	if (!isset($_GET['id']))
		$Form->oa_exit("��������");
	$id = $_GET['id'];
	$sql_num = "select count(*) from ".$db_degree." where `id`=".$id;
	if ($db->fetch_one($sql_num) == 0)
		$Form->oa_exit("���������ѧ��");
	$sql = "select * from ".$db_degree." where `id`=".$id;
	$query = $db->query($sql);
	$info = $db->fetch_array($query);
	$Form->cpheader("�༭ѧ��");

	$Form->formheader(array(
		'title' => "�༭ѧ��",
		'action' => "admin.php?j=Config&a=doeditdegree"
		));
	$Form->makehidden(array(
		'name' => "id",
		'value' => $id
		));
	$Form->makeinput(array(
		'text' => "ѧ������",
		'name' => "name",
		'size' => "50",
		'value' => $info['name'],
		));
	$Form->formfooter(array(
		"button" => array(
			array('value'=>"�޸�"),
			array('value'=>"����",'type'=>"reset"),
			array('value'=>"����", 'type'=>"button", 'extra' => "onclick=\"goto('admin.php?j=Config&a=degree')\""),
		)));
	echo "<script>function goto(url){this.location.replace(url);}</script>";
	$Form->cpfooter();
}
elseif ($a == 'doeditdegree') //ִ�б༭ѧ��
{
	$name = $_POST['name'];
	$id = $_POST['id'];
	if (!$name) $Form->oa_exit("����дѧ������");
	$db->update($db_degree,array(
		'name' => $name,
		),"`id`={$id}");
	$Form->oa_exit("�༭ѧ���ɹ�","admin.php?j=Config&a=degree");
}
elseif ($a == 'deldegree') //ɾ��ѧ��
{
	$id = intval($_GET['id']);
	$sql = "select count(*) from ".$db_degree." where `id`='".$id."'";
	$num = $db->fetch_one($sql);
	
	if (!($num)) $Form->oa_exit("��ѧ��������");

	$db->query("delete from ".$db_degree." where `id`='".$id."'");
	$Form->oa_exit("ɾ��ѧ���ɹ�!","admin.php?j=Config&a=degree");
}
elseif ($a == 'index') //��ҳ����
{
	$config_sql = "select * from ".$db_config." where 1";
	$query = $db->query($config_sql);
	$config = $db->fetch_array($query);

	$Form->cpheader("��ҳ����");
	$Form->formheader(array(
		'title' => "��ҳ����",
		'action' => "admin.php?j=Config&a=doindex",
		));
	$Form->maketd(array(
		"<b>����������</b>",
		'<a href="admin.php?j=Config&a=nav">�༭</a>',
		));
	$Form->maketextarea(array(
		'text' => "ҳ������",
		'name' => "footer",
		'value' => $config['footer'],
		));
	$Form->formfooter(array(
		"button" => array(
			array('value'=>"ȷ��"),
			array('value'=>"����",'type'=>"reset"),
		)));
}
elseif ($a == 'doindex') //ִ����ҳ����
{
	$db->update($db_config, array(
		'footer' => $_POST['footer'],
		), "`id`=1");
	$Form->oa_exit("�ɹ�������ҳ", "admin.php?j=Config&a=index");
}
elseif ($a == 'nav') //�������б�
{
	$sql_num = "select count(*) from ".$db_nav." where 1";
	$listNum = $db->fetch_one($sql_num);
	$formtitle = "������ѡ��";

	$Form->cpheader();
	if($listNum > 0)
	{
		$Form->formheader(array("action" => "admin.php?j=Config&a=editnav",
			"title" => $formtitle,
			"colspan" => "4",
			"name" => "form",
		));
		$Form->if_Del();
		$Form->js_checkall();
		echo "<tr align=\"center\">\n";
		echo "<td width=\"5%\">&nbsp;</td>\n";
		echo "<td width=\"10%\"><b>����</b></td>\n";
		echo "<td width=\"30%\"><b>����</b></td>\n";
		echo "<td width=\"55%\"><b>���</b></td>\n";
		echo "</tr>\n";
		$lstRequest = "select * from ".$db_nav." where 1 order by `id` desc";
		$vRe = $db->query($lstRequest);
		while($nL = $db->fetch_array($vRe)) 
		{
			$id = $nL['id'];
			if ($nL['show'] == 1)
			{
				$checked = " checked=\"checked\"";
			}
			else
			{
				$checked = "";
			}
			if ($nL['changable'] == 1)
			{
				$disable = "";
			}
			else
			{
				$disable = " disabled=\"disabled\"";
			}
			$name = $nL['name'];
			echo "<tr align=\"center\">\n";
			echo "<td><input type=\"checkbox\" name=\"nav[{$id}]\" value=\"1\" class=\"radio\"".$checked.$disable."></td>\n";
			echo "<td><input type=\"text\" name=\"name{$id}\" value=\"$name\" /></td>\n";
			echo "<td>".$nL['link']."</td>\n";
			echo "<td>".$nL['intro']."</td>\n";
			echo "</tr>\n";
		}
		echo "<tr><td colspan=\"4\" align=\"center\"><input class=\"button\" accesskey=\"\" type=\"submit\" name=\"\" value=\"�༭\" />";
		echo "\n</td></tr></form></table>\n";
	}
	else
	{
		$Form->tableheaderbig(array("title" => $formtitle,));
		$Form->maketd(array("��ʱû�е�����ѡ��~~"));
		$Form->tablefooter();
	}
	$Form->cpfooter();
}
elseif ($a == 'editnav') //�༭������
{
	$nav = $_POST["nav"];
	if (is_array($nav))
	{
		$num = 0;
		foreach ($nav as $k => $v)
		{
			if ($v)
			{
				$vid = $k;
				$db->update($db_nav, array(
					'show' => 1,
					'name' => checkStr($_POST['name'.$vid]),
					), "`id`=".$vid);
				$num++;
			}
			else
			{
				$db->update($db_nav, array(
					'show' => 0,
					), "`id`=".$vid);
			}
		}
	}
	$Form->oa_exit("�༭�ɹ�","admin.php?j=Config&a=index");
}
else
{
	$Form->oa_exit("���ܲ�����","index.php?a=main");
}
?>