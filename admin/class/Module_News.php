<?php
/*
���Ź���ģ��
========
��Ҫ���ࣺconfig.php forms.php class_DataBase.php SmartTemplate class_User.php
========
��Ҫ���ܣ���$a == ��
--------------------
add ������� doadd ִ�����
list �����б�
show �鿴���� check �������� docheck ִ����������
edit �༭���� doedit ִ�б༭����

comment �����б�	delcomment ɾ������

addsort ���������Ŀ doaddsort ִ�����������Ŀ
editsort �༭������Ŀ doeditsort ִ�б༭������Ŀ
sort ������Ŀ����
ordersort ��Ŀ��������
activesort ��Ŀ���¼���
disactivesort ��Ŀ����
delsort ��Ŀɾ��

attachment ���Ÿ�������
attlist �����б�
attupload �����ϴ�
attdelete ����ɾ��
attupdate �����޸�

���ӹ��� (function)
-------------------
state_addlink �����Ҫ��Ϊ��ʹ���������Ի��������Ų������ʱ���㷵�ص�ԭ�б�
build_sorts_cache ����Ǹ����ཨ������

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
$db_news = "`".$mysql_prefix."article`"; //�������ݱ�
$db_pic =  "`".$mysql_prefix."picture`"; //ͼƬ���ݱ�
$db_sort =  "`".$mysql_prefix."sort`"; //�������ݱ�
$db_comment = "`".$mysql_prefix."comment`"; //�������ݱ�
$sortsfor = 'news';//�����ʾ����ֻ�������ţ������е��Ѷ�~~
$imgPath = "../attachment/news/"; //�����ϴ�Ŀ¼
$sortscache = "class/cache/news_sorts.php";//���ŷ��໺��
$num_in_page = 20;  //ÿҳ��ʾ��Ŀ
$att_every = 5; //ÿ�и�������

$allow = array();

switch($usr->rights['News'])
{
case 'S':  //��������Ա
	$allow = array(
		'add' => 2, 'doadd' => 2, 'list' => 2, 'show' => 2, 'check' => 2, 'docheck' => 2, 'edit' => 2, 'doedit' => 2,
		'comment' => 2, 'delcomment' => 2,
		'search' => 2, 'dosearch' => 2,
		'addsort' => 2, 'doaddsort' => 2, 'editsort' => 2, 'doeditsort' => 2, 'sort' => 2, 'ordersort' => 2, 'activesort' => 2, 'disactivesort' => 2, 'delsort' => 2,
		'attachment' => 2, 'attlist' => 2, 'attupload' => 2, 'attdelete' => 2, 'attupdate' => 2,
		);
	break;
case 'A':  //һ������Ա
	$allow = array(
		'add' => 2, 'doadd' => 2, 'list' => 2, 'show' => 2, 'check' => 2, 'docheck' => 2, 'edit' => 2, 'doedit' => 2,
		'comment' => 2, 'delcomment' => 2,
		'search' => 2, 'dosearch' => 2,
		'addsort' => 0, 'doaddsort' => 0, 'editsort' => 0, 'doeditsort' => 0, 'sort' => 0, 'ordersort' => 0, 'activesort' => 0, 'disactivesort' => 0, 'delsort' => 0,
		'attachment' => 2, 'attlist' => 2, 'attupload' => 2, 'attdelete' => 2, 'attupdate' => 2,
		);
	break;
case 'M':  //��������Ա
	$allow = array(
		'add' => 2, 'doadd' => 2, 'list' => 1, 'show' => 2, 'check' => 0, 'docheck' => 0, 'edit' => 1, 'doedit' => 1,
		'comment' => 0, 'delcomment' => 0,
		'search' => 1, 'dosearch' => 1,
		'addsort' => 0, 'doaddsort' => 0, 'editsort' => 0, 'doeditsort' => 0, 'sort' => 0, 'ordersort' => 0, 'activesort' => 0, 'disactivesort' => 0, 'delsort' => 0,
		'attachment' => 2, 'attlist' => 2, 'attupload' => 2, 'attdelete' => 1, 'attupdate' => 2,
		);
	break;
default:  //��Ȩ��
	$allow = array(
		'add' => 0, 'doadd' => 0, 'list' => 0, 'show' => 0, 'check' => 0, 'docheck' => 0, 'edit' => 0, 'doedit' => 0,
		'comment' => 0, 'delcomment' => 0,
		'search' => 0, 'dosearch' => 0,
		'addsort' => 0, 'doaddsort' => 0, 'editsort' => 0, 'doeditsort' => 0, 'sort' => 0, 'ordersort' => 0, 'activesort' => 0, 'disactivesort' => 0, 'delsort' => 0,
		'attachment' => 0, 'attlist' => 0, 'attupload' => 0, 'attdelete' => 0, 'attupdate' => 0,
		);
	break;
}

if (!($allow[$a] > 0)) $Form->oa_exit("��û��Ȩ��ִ�иò���~~");
$sortname_short = array();
$sortname_all = array();

if (!file_exists($sortscache)) 	build_sorts_cache($db_sort,$sortscache);

include($sortscache);

if ($a == 'add')  //����׫д
{
	$Form->cpheader("�������");
	$Form->formheader(array(
		'title' => "�������",
		'action' => "admin.php?j=News&a=doadd"
		));
	$Form->makeselect(array(
		'text' => "��Ŀ",
		'name' => "sortid",
		'option' => $sortname_all));
	$Form->makeinput(array(
		'text' => "����",
		'name' => "title",
		'size' => "50"
		));
	$Form->makeinput(array(
		'text' => "��Դ",
		'name' => "source",
		));
	$Form->makeinput(array(
		'text' => "��ǩ",
		'name' => "tags",
		'size' => "50"
		));
	$Form->maketextarea(array(
		'text' => "����",
		'name' => "content",
		'cols' => "600",
		'rows' => "400",
		));
	$Form->makeselect(array(
		'text' => "�Ƿ���������",
		'name' => "comment",
		'option' => array("��", "��"),
		'selected' => 1,
		));
	$Form->formfooter(array(
		"button" => array(
			array('value'=>"��һ��"),
			array('value'=>"����",'type'=>"reset"),
		)));
	$Form->cpfooter();
}
elseif ($a == 'doadd')  //ִ�п���׫д
{
	$title = checkStr($_POST['title']);
	if (!$title) $Form->oa_exit("����д���ű�������");
	$db->insert($db_news,array(
		'sort' => intval($_POST['sortid']),
		'title' => $title,
		'source' => checkStr($_POST['source']),
		'tag' => deal_tags($_POST['tags']),
		'content' => $_POST['content'],
		'author' => $username,
		'comment' => intval($_POST['comment']),
		'post_time' => time(),
		'post_ip' => getip(),
		));
	$Form->oa_exit("����¼��ɹ�,��������ͼƬ","admin.php?j=News&a=attachment&id=".$db->insert_id());
}
elseif ($a == 'list') //�����б�
{
	$condition = "1";
	$state_addlink = "";
	$status = array("<font color=red>����</font>","<font color=green>ͨ��</font>","<font color=blue>�ö�</font>");
	$istop = array("","Yes");
	$statetitle = "ȫ������";
	$listaction = 'check';

	if (isset($_GET['state']))
	{
		$state =  intval($_GET['state']);
		if ($state >= 0 && $state <= 3)
		{
			$condition = "`show`='".$state."'";
			$state_addlink = "&state=".$state;
			$statetitle = $status[$state]."����";
		}
	}
	if ($allow['list'] == 1)
	{
		$statetitle = "�ҵ�".$statetitle;
		$condition .= " and `author`='".$username."'";
		$listaction = "show";
	}
	$sql_num = "select count(*) from ".$db_news." where {$condition}";
	$listNum = $db->fetch_one($sql_num);
	$formtitle = "{$statetitle} [��".$listNum."��] [{$num_in_page}��/ҳ]";

	$cpage = isset($_GET['page']) ? intval($_GET['page']) : 1;
	$page_char = page($listNum,$num_in_page,$cpage,"admin.php?j=News&a=list{$state_addlink}");
	$limitS = $cpage*$num_in_page-$num_in_page;

	$Form->cpheader();
	$Form->tableheaderbig();
	$Form->maketd(array("<b>��ѡ���б����</b>: <a href=\"admin.php?j=News&a=list\">ȫ��</a> <a href=\"admin.php?j=News&a=list&state=0\">����</a> <a href=\"admin.php?j=News&a=list&state=1\">ͨ��</a> <a href=\"admin.php?j=News&a=list&state=2\">�ö�</a>"));
	$Form->tablefooter();

	if($listNum > 0)
	{
		$Form->tableheaderbig(array(
			"title" => $formtitle,
			"colspan" => "8",
		));
		echo "<tr align=\"center\">\n";
		echo "<td width=\"6%\"><b>�ö�</b></td>\n";
		echo "<td width=\"6%\"><b>״̬</b></td>\n";
		echo "<td width=\"27%\"><b>���±���</b></td>\n";
		echo "<td width=\"9%\"><b>��������</b></td>\n";
		echo "<td width=\"9%\"><b>���¸���</b></td>\n";
		echo "<td width=\"12%\"><b>������Ŀ</b></td>\n";
		echo "<td width=\"10%\"><b>¼����</b></td>\n";
		echo "<td width=\"15%\"><b>ʱ��</b></td>\n";
		echo "</tr>\n";
		$lstRequest = "select * from ".$db_news." where {$condition} order by `top` desc, `post_time` desc limit ".$limitS.",".$num_in_page;
		$vRe = $db->query($lstRequest);
		while($nL = $db->fetch_array($vRe)) 
		{
			$attnum = $db->fetch_one("select count(*) from ".$db_pic." where `aid`=".$nL['id']);
			$comnum = $db->fetch_one("select count(*) from ".$db_comment." where `aid`=".$nL['id']);
			$sortid = intval($nL['sort']);
			echo "<tr align=\"center\">\n";
			echo "<td>".$istop[$nL['top']]."</td>\n";
			echo "<td>".$status[$nL['show']]."</td>\n";
			echo "<td align=\"left\"><a href=\"admin.php?j=News&a={$listaction}&id={$nL['id']}{$state_addlink}\">{$nL['title']}</a></td>\n";
			echo "<td><a href=\"admin.php?j=News&a=comment&id={$nL['id']}{$state_addlink}\">�鿴[{$comnum}]</a></td>\n";
			echo "<td><a href=\"admin.php?j=News&a=attachment&id={$nL['id']}{$state_addlink}\">�鿴[{$attnum}]</a></td>\n";
			echo "<td>".$sortname_short[$sortid]."</td>\n";
			echo "<td>".$nL['author']."</td>\n";
			echo "<td>".date('y-m-d H:i',$nL['post_time'])."</td>\n";
			echo "</tr>\n";
		}
		echo "<tr><td colspan=\"8\" align=\"right\">".$page_char."</td></tr>";
		$Form->tablefooter(array("colspan" => "8"));
	}
	else
	{
		$Form->tableheaderbig(array("title" => $formtitle,));
		$Form->maketd(array("��ʱû�б�������~~"));
		$Form->tablefooter();
	}
	$Form->cpfooter();
}
elseif ($a == 'show')  //�鿴���ţ�ò���ѻķϣ�
{
	$id = intval($_GET['id']);
	$sql_news = "select * from ".$db_news." where `id`='".$id."' and `author`='".$username."'";
	$nL = $db->fetch_one_array($sql_news);
	
	if (empty($nL)) $Form->oa_exit("�����Ų����ڻ���û��Ȩ�޲鿴");


	$status = array("<font color=red>����</font>","<font color=green>ͨ��</font>","<font color=blue>�ö�</font>");
	$sortid = $nL['sort'];
	$istop = array("","Yes");
	$Form->cpheader("�鿴����");
	$Form->formheader(array(
		'title' => "�鿴����",
		'method' => "GET",
		'action' => "admin.php".state_addlink()
		));
	$Form->makehidden(array('name' => "j",'value' => 'News'));
	$Form->makehidden(array('name' => "a",'value' => 'edit'));
	$Form->makehidden(array('name' => "id",'value' => $id));
	$Form->maketd(array(
		"<b>��Ŀ</b>",
		$sortname_short[$sortid]."��".$sortname_all[$sortid],
		));
	$Form->maketd(array(
		"<b>����</b>",
		$nL['title'],
		));
	$Form->maketd(array(
		"<b>ԭ����</b>",
		$nL['source'],
		));
	$Form->maketd(array(
		"<b>Tags</b>",
		deal_tags($nL['tag'],1),
		));
	echo "<tr nowrap>";
	echo "<td width=\"12%\" valign=\"top\"><b>����</b></td>";
	echo "<td width=\"78%\">".$nL['content']."</td>";
	echo "</tr>\n";
	$Form->maketd(array(
		"<b>Ԥ��</b>",
		"<a href=\"../news.php?id={$id}\" target=\"_blank\">���Ԥ��</a>",
		));
	$Form->maketd(array(
		"<b>״̬</b>",
		$status[$nL['show']],
		));
	$Form->maketd(array(
		"<b>�ö�</b>",
		$istop[$nL['top']],
		));
	if ($nL['show'] < 1)
	{
		$Form->formfooter(array(
			"button" => array(
				array('value'=>"�༭"),
				array('value'=>"����", 'type'=>"button", 'extra' => "onclick=\"goto('admin.php?j=News&a=list".state_addlink()."')\""),
			)));
	}
	else
	{
		$Form->formfooter(array(
			"button" => array(
				array('value'=>"����", 'type'=>"button", 'extra' => "onclick=\"goto('admin.php?j=News&a=list".state_addlink()."')\""),
			)));
	}
	echo "<script>function goto(url){this.location.replace(url);}</script>";
	$Form->cpfooter();
}
elseif ($a == 'check')  //��������
{
	$id = intval($_GET['id']);
	$sql_news = "select * from ".$db_news." where `id`='".$id."'";
	$nL = $db->fetch_one_array($sql_news);
	
	if (empty($nL)) $Form->oa_exit("�����Ų�����");

	$sortid = intval($nL['sort']);
	$comment = array("��", "��");
	$Form->cpheader("��������");
	$Form->formheader(array(
		'title' => "��������",
		'action' => "admin.php?j=News&a=docheck".state_addlink()
		));
	$Form->makehidden(array(
		'name' => "id",
		'value' => $id
		));
	$Form->maketd(array(
		"<b>��Ŀ</b>",
		$sortname_short[$sortid]."��".$sortname_all[$sortid],
		));
	$Form->maketd(array(
		"<b>����</b>",
		$nL['title'],
		));
	$Form->maketd(array(
		"<b>ԭ����</b>",
		$nL['source'],
		));
	$Form->maketd(array(
		"<b>Tags</b>",
		deal_tags($nL['tag'],1),
		));
	echo "<tr nowrap>";
	echo "<td width=\"12%\" valign=\"top\"><b>����</b></td>";
	echo "<td width=\"78%\">".$nL['content']."</td>";
	echo "</tr>\n";
	$Form->maketd(array(
		"<b>�Ƿ���������</b>",
		$comment[$nL['comment']],
		));
	$Form->maketd(array(
		"<b>Ԥ��</b>",
		"<a href=\"../news.php?id={$id}\" target=\"_blank\">���Ԥ��</a>",
		));
	$Form->makeselect(array(
		'option' => array('����','ͨ��'),
		'text' => "����",
		'name' => "state",
		'selected' => $nL['show']));
	$Form->makeyesno(array(
		'text' => "�ö�",
		'name' => "istop",
		'selected' => $nL['top']));
	$Form->formfooter(array(
		"button" => array(
			array('value'=>"����"),
			array('value'=>"�༭",'type'=>"button",'extra' => "onclick=\"goto('admin.php?j=News&a=edit&id={$id}".state_addlink()."')\""),
			array('value'=>"����", 'type'=>"button", 'extra' => "onclick=\"goto('admin.php?j=News&a=list".state_addlink()."')\""),
		)));
	echo "<script>function goto(url){this.location.replace(url);}</script>";
	$Form->cpfooter();
}
elseif ($a == 'docheck')  //ִ����������
{
	if (!isset($_POST['id'])) $Form->oa_exit("��������");
	$id = intval($_POST['id']);

	$sql_news = "select count(*) from ".$db_news." where `id`='".$id."'";
	if ($db->fetch_one($sql_news)==0) $Form->oa_exit("���Ų�����");

	$db->update($db_news,array(
		'show' => intval($_POST['state']),
		'top' => intval($_POST['istop']),
		'checker' => $username,
		'checkip' => getip(),
		),"`id`={$id}");
	$Form->oa_exit("���������ɹ�","admin.php?j=News&a=list".state_addlink());
}
elseif ($a == 'edit')  //�༭����
{
	$id = intval($_GET['id']);
	if ($allow['edit'] == 2) 
		$sql_news = "select * from ".$db_news." where `id`='".$id."'";
	else
		$sql_news = "select * from ".$db_news." where `id`='".$id."' and `submiter`='".$username."' and `state` < 2";

	$nL = $db->fetch_one_array($sql_news);
	if (empty($nL)) $Form->oa_exit("�����Ų����ڻ���û��Ȩ�ޱ༭������");

	$Form->cpheader("�༭����");
	$Form->formheader(array(
		'title' => "�༭����",
		'action' => "admin.php?j=News&a=doedit".state_addlink()
		));
	$Form->makehidden(array(
		'name' => "id",
		'value' => $id
		));
	$Form->makeselect(array(
		'option' => $sortname_all,
		'text' => "��Ŀ",
		'name' => "sortid",
		'selected' => $nL['sort']
		));
	$Form->makeinput(array(
		'text' => "����",
		'name' => "title",
		'size' => "50",
		'value' => $nL['title']
		));
	$Form->makeinput(array(
		'text' => "ԭ����",
		'name' => "author",
		'value' => $nL['source']
		));
	$Form->makeinput(array(
		'text' => "��ǩ",
		'name' => "tags",
		'size' => "50",
		'value' => deal_tags($nL['tag'],1),
		));
	$Form->maketextarea(array(
		'text' => "����",
		'name' => "content",
		'cols' => "600",
		'rows' => "400",
		'value' => $nL['content']
		));
	$Form->makeselect(array(
		'option' => array('��','��'),
		'text' => "�Ƿ���������",
		'name' => "comment",
		'selected' => $nL['comment']));
	if ($allow['check'] == 2)
	{
		$Form->makeselect(array(
			'option' => array('����','ͨ��'),
			'text' => "����",
			'name' => "state",
			'selected' => $nL['show']));
		$Form->makeyesno(array(
			'text' => "�ö�",
			'name' => "istop",
			'selected' => $nL['istop']));
	}
	$Form->formfooter(array(
		"button" => array(
			array('value'=>"����"),
			array('value'=>"����", 'type'=>"reset"),
			array('value'=>"����", 'type'=>"button", 'extra' => "onclick=\"goto('admin.php?j=News&a=list".state_addlink()."')\""),
		)));
	echo "<script>function goto(url){this.location.replace(url);}</script>";
	$Form->tablefooter();
	$Form->cpfooter();
}
elseif ($a == 'doedit')  //ִ�б༭����
{
	if (!isset($_POST['id'])) $Form->oa_exit("��������");
	$id = intval($_POST['id']);
	$title = checkStr($_POST['title']);

	if ($allow['edit'] == 2) 
		$sql_news = "select * from ".$db_news." where `id`='".$id."'";
	else
		$sql_news = "select * from ".$db_news." where `id`='".$id."' and `submiter`='".$username."' and `state` < 1";

	$nL = $db->fetch_one_array($sql_news);
	if (empty($nL)) $Form->oa_exit("�����Ų����ڻ���û��Ȩ�ޱ༭������");

	if (!$title) $Form->oa_exit("����д���ű�������");
	
	if ($allow['check'] == 2)
	{
		$db->update($db_news,array(
			'sort' => intval($_POST['sortid']),
			'title' => $title,
			'source' => checkStr($_POST['author']),
			'tag' => deal_tags($_POST['tags']),
			'content' => $_POST['content'],
			'comment' => intval($_POST['comment']),

			'show' => intval($_POST['state']),
			'top' => intval($_POST['istop']),
			'checker' => $username,
			'checkip' => getip(),
			),"`id`={$id}");
	}
	else
	{
		$db->update($db_news,array(
			'sort' => intval($_POST['sortid']),
			'title' => $title,
			'source' => checkStr($_POST['author']),
			'tag' => deal_tags($_POST['tags']),
			'content' => $_POST['content'],
			'show' => 0,
			'comment' => intval($_POST['comment']),
			'submitip' => getip(),
			),"`id`={$id}");
	}
	$Form->oa_exit("���ű༭�ɹ�","admin.php?j=News&a=list".state_addlink());
}
elseif ($a == 'comment') //�����б�
{
	if (!isset($_GET['id']))
	{
		$Form->oa_exit("��������");
	}
	else
	{
		$id = $_GET['id'];
	}
	$statetitle = "�����б�";
	$sql_num = "select count(*) from ".$db_comment." where `aid`=".$id;
	$listNum = $db->fetch_one($sql_num);
	$formtitle = "{$statetitle} [��".$listNum."��] [{$num_in_page}��/ҳ]";

	$cpage = isset($_GET['page']) ? intval($_GET['page']) : 1;
	$page_char = page($listNum,$num_in_page,$cpage,"admin.php?j=News&a=comment&id=".$id);
	$limitS = $cpage*$num_in_page-$num_in_page;

	$Form->cpheader();

	if($listNum > 0)
	{
		$Form->tableheaderbig(array(
			"title" => $formtitle,
			"colspan" => "5",
		));
		echo "<tr align=\"center\">\n";
		echo "<td width=\"60%\"><b>����</b></td>\n";
		echo "<td width=\"15%\"><b>IP</b></td>\n";
		echo "<td width=\"15%\"><b>ʱ��</b></td>\n";
		echo "<td width=\"10%\"><b>����</b></td>\n";
		echo "</tr>\n";
		$lstRequest = "select * from ".$db_comment." where `aid`={$id} order by `time` desc limit ".$limitS.",".$num_in_page;
		$vRe = $db->query($lstRequest);
		while($nL = $db->fetch_array($vRe)) 
		{
			echo "<tr align=\"center\">\n";
			echo "<td>".str2html($nL['content'])."</td>\n";
			echo "<td>".$nL['ip']."</td>\n";
			echo "<td>".date('y-m-d H:i',$nL['time'])."</td>\n";
			echo "<td align=\"center\"><a href=\"admin.php?j=News&a=delcomment&id=".$nL['id']."\">ɾ��</a></td>\n";
			echo "</tr>\n";
		}
		echo "<tr><td colspan=\"5\" align=\"right\">".$page_char."</td></tr>";
		$Form->tablefooter(array("colspan" => "5"));
	}
	else
	{
		$Form->tableheaderbig(array("title" => $formtitle,));
		$Form->maketd(array("��������ʱû������~~"));
		$Form->tablefooter();
	}
	$Form->cpfooter();
}
elseif ($a == 'delcomment') //ɾ������
{
}
elseif ($a == 'search') //��������
{
	$Form->cpheader("��������");
	$Form->formheader(array(
		'title' => "��������",
		'action' => "admin.php?j=News&a=dosearch".state_addlink()
		));
	$Form->makeselect(array(
		'text' => "��Ŀ",
		'name' => "sortid",
		'option' => $sortname_all));
	$Form->makeinput(array(
		'text' => "����",
		'name' => "title",
		'size' => "50"
		));
	$Form->makeinput(array(
		'text' => "����",
		'name' => "author",
		));
	$Form->makeinput(array(
		'text' => "��Դ",
		'name' => "source",
		));
	$Form->makeinput(array(
		'text' => "��ǩ",
		'name' => "tag",
		));
/*	$Form->makeinput(array(
		'text' => "����",
		'name' => "content",
		));*/
	$Form->formfooter(array(
		"button" => array(
			array('value'=>"����"),
			array('value'=>"����",'type'=>"reset"),
		)));
	$Form->cpfooter();
}
elseif ($a == 'dosearch') //ִ����������
{
	$search = array(
		'sort' => intval($_REQUEST['sortid']),
		'title' => checkStr($_REQUEST['title']),
		'author' => checkStr($_REQUEST['author']),
		'source' => checkStr($_REQUEST['source']),
		'tag' => checkStr($_REQUEST['tag']),
		'permission' => $allow['dosearch'],
	);
	$status = array("<font color=red>����</font>","<font color=green>ͨ��</font>","<font color=blue>�ö�</font>");
	$istop = array("","Yes");
	$statetitle = "�������";
	$state_addlink = "&sort=".$sort."&title=".$title."&author=".$author."&source=".$source."&tag=".$tag;
	$condition = make_condition($search);
	$sql_num = "select count(*) from ".$db_news." where {$condition}";
	$listNum = $db->fetch_one($sql_num);
	$formtitle = "{$statetitle} [��".$listNum."��] [{$num_in_page}��/ҳ]";

	$cpage = isset($_GET['page']) ? intval($_GET['page']) : 1;
	$page_char = page($listNum,$num_in_page,$cpage,"admin.php?j=News&a=dosearch{$state_addlink}");
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
		echo "<td width=\"6%\"><b>״̬</b></td>\n";
		echo "<td width=\"30%\"><b>���±���</b></td>\n";
		echo "<td width=\"6%\"><b>��������</b></td>\n";
		echo "<td width=\"9%\"><b>���¸���</b></td>\n";
		echo "<td width=\"12%\"><b>������Ŀ</b></td>\n";
		echo "<td width=\"10%\"><b>¼����</b></td>\n";
		echo "<td width=\"15%\"><b>ʱ��</b></td>\n";
		echo "</tr>\n";
		$lstRequest = "select * from ".$db_news." where {$condition} order by `top` desc, `post_time` desc limit ".$limitS.",".$num_in_page;
		$vRe = $db->query($lstRequest);
		while($nL = $db->fetch_array($vRe)) 
		{
			$attnum = $db->fetch_one("select count(*) from ".$db_pic." where `aid`=".$nL['id']);
			$comnum = $db->fetch_one("select count(*) from ".$db_comment." where `aid`=".$nL['id']);
			$sortid = intval($nL['sort']);
			echo "<tr align=\"center\">\n";
			echo "<td>".$istop[$nL['top']]."</td>\n";
			echo "<td>".$status[$nL['show']]."</td>\n";
			echo "<td align=\"left\"><a href=\"admin.php?j=News&a={$listaction}&id={$nL['id']}{$state_addlink}\">{$nL['title']}</a></td>\n";
			echo "<td><a href=\"admin.php?j=News&a=comment&id={$nL['id']}{$state_addlink}\">�鿴[{$attnum}]</a></td>\n";
			echo "<td><a href=\"admin.php?j=News&a=attachment&id={$nL['id']}{$state_addlink}\">�鿴[{$attnum}]</a></td>\n";
			echo "<td>".$sortname_short[$sortid]."</td>\n";
			echo "<td>".$nL['author']."</td>\n";
			echo "<td>".date('y-m-d H:i',$nL['post_time'])."</td>\n";
			echo "</tr>\n";
		}
		echo "<tr><td colspan=\"8\" align=\"right\">".$page_char."</td></tr>";
		$Form->tablefooter(array("colspan" => "8"));
	}
	else
	{
		$Form->tableheaderbig(array("title" => $formtitle,));
		$Form->maketd(array("��ʱû�б�������~~"));
		$Form->tablefooter();
	}
	$Form->cpfooter();
}
elseif ($a == 'addsort') //���������Ŀ
{
	$default_order = $db->fetch_one("select max(`order`) from {$db_sort}") + 1;
	$Form->cpheader();
	$Form->formheader(array(
		'title' => "�����Ŀ",
		'action' => "admin.php?j=News&a=doaddsort"
		));
	$Form->makehidden(array(
		'name' => "for",
		'value' => "news"
		));
	$Form->makeinput(array(
		'name' => "order",
		'text' => "˳��",
		'note' => "����ԽС����Խ��ǰ",
		'value' => $default_order
		));
	$Form->makeinput(array(
		'name' => "short",
		'text' => "���",
		'note' => "��Ŀ���,����ʹ��������"
		));
	$Form->makeinput(array(
		'name' => "sortname",
		'text' => "ȫ��",
		'note' => "��Ŀ��ȫ��"
		));
	$Form->formfooter();
	$Form->cpfooter();
}
elseif ($a == 'doaddsort') //ִ�����������Ŀ
{
	if (!isset($_POST['for'])) $Form->oa_exit("��������~");
	$short = checkStr($_POST['short']);
	$sortname = checkStr($_POST['sortname']);
	if (!$short) $Form->oa_exit("����д������Ŀ���");
	if (!$sortname) $Form->oa_exit("����д������Ŀȫ��");
	$sql = "select count(*) from {$db_sort} where `short`='{$short}' or `name`='{$sortname}'";
	if ($db->fetch_one($sql) > 0) $Form->oa_exit("��Ŀ��ƻ�ȫ���Ѿ�����!");
	$db->insert($db_sort,array(
		'order' => intval($_POST['order']),
		'short' => $short,
		'name' => $sortname,
		'visible' => 1
		));
	build_sorts_cache($db_sort,$sortscache);
	$Form->oa_exit("���������Ŀ�ɹ�","admin.php?j=News&a=sort");
}
elseif ($a == 'editsort') //�༭������Ŀ
{
	$id = intval($_GET['id']);
	$sql = "select * from ".$db_sort." where `id`='".$id."'";
	$sL = $db->fetch_one_array($sql);
	if (empty($sL)) $Form->oa_exit("��������Ŀ������");

	$Form->cpheader();
	$Form->formheader(array(
		'title' => "�༭��Ŀ",
		'action' => "admin.php?j=News&a=doeditsort",
		));
	$Form->makehidden(array(
		'name' => "id",
		'value' => $id,
		));
	$Form->makeinput(array(
		'name' => "order",
		'text' => "˳��",
		'note' => "����ԽС����Խ��ǰ",
		'value' => $sL['order']
		));
	$Form->makeinput(array(
		'name' => "short",
		'text' => "���",
		'note' => "����ʹ��������",
		'value' => $sL['short']
		));
	$Form->makeinput(array(
		'name' => "sortname",
		'text' => "ȫ��",
		'note' => "��Ŀ��ȫ��",
		'value' => $sL['name']
		));
	$Form->formfooter();
	$Form->cpfooter();
}
elseif ($a == 'doeditsort') //ִ�б༭������Ŀ
{
	if (!isset($_POST['id'])) $Form->oa_exit("��������~");
	$sortname = checkStr($_POST['sortname']);
	$short = checkStr($_POST['short']);
	$id = intval($_POST['id']);
	if (!$sortname) $Form->oa_exit("����д������Ŀȫ��");

	$sql = "select count(*) from {$db_sort} where (`short`='{$short}' or `name`='{$name}') and `id`!={$id}";
	if ($db->fetch_one($sql) > 0) $Form->oa_exit("��Ŀ�ļ�ƻ�ȫ���Ѿ�����!");
	$db->update($db_sort,array(
		'order' => intval($_POST['order']),
		'short' => $short,
		'name' => $sortname,
		),"`id`={$id}");
	build_sorts_cache($db_sort,$sortscache);
	$Form->oa_exit("�༭������Ŀ�ɹ�","admin.php?j=News&a=sort");
}
elseif ($a == 'sort') //������Ŀ����
{
	$sql = "select * from ".$db_sort." order by `visible` desc, `order` asc";
	$query = $db->query($sql);
	$Form->cpheader();
	$Form->formheader(array(
		'title' => "�����������",
		'colspan' => 3,
		'action' => "admin.php?j=News&a=ordersort",
		));
	$Form->maketd(array('˳��','��Ŀ(��ơ�ȫ��)','����'));
	while ($sL = $db->fetch_array($query))
	{
		if ($sL['visible'])
		{
			$Form->maketd(array(
				"<input type=\"text\" size=\"5\" name=\"sort[".$sL['id']."]\" value=\"".$sL['order']."\">",
				$sL['short'].'��'.$sL['name'],
				"[<a href=\"admin.php?j=News&a=editsort&id=".$sL['id']."\">�༭</a>] [<a href=\"admin.php?j=News&a=disactivesort&id=".$sL['id']."\">����</a>] [<a href=\"admin.php?j=News&a=delsort&id=".$sL['id']."\">ɾ��</a>]"));
		}
		else
		{
			$Form->maketd(array(
				"������",
				$sL['short'].'��'.$sL['name'],
				"[<a href=\"admin.php?j=News&a=activesort&id=".$sL['id']."\">����</a>] [<a href=\"admin.php?j=News&a=delsort&id=".$sL['id']."\">ɾ��</a>]"));
		}
	}

	$Form->formfooter(array('colspan' => 3, "button" =>array("submit"=>array("value"=>"��������"))));
	$Form->cpfooter();
}
elseif ($a == 'ordersort') //��Ŀ��������
{
	$sort = $_POST['sort'];
	foreach($sort as $key=>$val) 
	{
		$db->update($db_sort,array(
			'order' => $val
			),"`id` = $key");
	}
	build_sorts_cache($db_sort,$sortscache);
	$Form->oa_exit("���������Ѿ�����","admin.php?j=News&a=sort");
}
elseif ($a == 'activesort') //��Ŀ���¼���
{
	if (!isset($_GET['id'])) $Form->oa_exit("��������");
	$id = intval($_GET['id']);
	$db->update($db_sort,array('visible' => 1),"`id`={$id}");
	build_sorts_cache($db_sort,$sortscache);
	$Form->oa_exit("������Ŀ�ɹ�����","admin.php?j=News&a=sort");
}
elseif ($a == 'disactivesort') //��Ŀ����
{
	if (!isset($_GET['id'])) $Form->oa_exit("��������");
	$id = intval($_GET['id']);
	$db->update($db_sort,array('visible' => 0),"`id`={$id}");
	build_sorts_cache($db_sort,$sortscache);
	$Form->oa_exit("������Ŀ�ɹ�����","admin.php?j=News&a=sort");
}
elseif ($a == 'delsort') //��Ŀɾ��
{
	if (!isset($_GET['id'])) $Form->oa_exit("��������");
	$id = intval($_GET['id']);
	$num = $db->fetch_one("select count(*) from {$db_news} where `sort`='".$id."'");
	if ($num)
	{
		$Form->oa_exit("������Ŀ�ǿ�!!");
	}
	else
	{
		$sql = "delete from {$db_sort} where `id`={$id}";
		$db->query($sql);
		build_sorts_cache($db_sort,$sortscache);
		$Form->oa_exit("������Ŀ�ɹ�ɾ��","admin.php?j=News&a=sort");
	}
}
//���������Ÿ���
elseif ($a == 'attachment')  //���Ÿ�������
{
	$id = intval($_GET['id']);
	$sql_news = "select * from ".$db_news." where `id`='".$id."'";
	$nL = $db->fetch_one_array($sql_news);
	switch ($id)
	{
	case -2:
		$nL['title'] = "��ͼƬ����";
		break;
	case -1:
		$nL['title'] = "ȫ������";
		break;
	case 0:
		$nL['title'] = "δʹ�ø���";
		break;
	default:
	}
	if (empty($nL)) $Form->oa_exit("�Ҳ���������");
	$Form->cpheader("���Ÿ�������");
	if ($nL['show'] < 1)
	{
		$Form->formheader(array(
			'title' => "���Ÿ����������ġ���{$nL['title']}",
			'action' => "admin.php?j=News&a=attupload",
			'target' => "attlist",
			'enctype' => "multipart/form-data"
			));
	}
	else
	{
		$Form->tableheaderbig(array(
			'title' => "���Ÿ����������ġ���{$nL['title']}",
			'colspan' => "2"
			));
	}
	echo "<tr nowrap>";
	echo "<td colspan=\"2\"><IFRAME id=\"attlist\" name=\"attlist\" src=\"admin.php?j=News&a=attlist&id={$id}\" frameBorder=0 scrolling=no allowTransparency=\"true\"></IFRAME></td>";
	echo "</tr>\n";
	if ($nL['show'] < 1)
	{
		$Form->makehidden(array(
			'name' => "id",
			'value' => $id,
			));
		$Form->makeinput(array(
			'text' => "����˵��",
			'name' => "intro",
			'size' => "60"
			));
		$Form->makefile(array(
			'text' => "�����ϴ�",
			'name' => "file",
			'size' => "50"
			));
		echo "<tr nowrap>";
		echo "<td colspan=\"2\" align=\"center\"><input class=\"button\" type=\"submit\" value=\"�ϴ�\"> <input class=\"button\" type=\"button\" value=\"���\" onclick=\"goto('admin.php?j=News&a=list".state_addlink()."')\"></td>";
		echo "</tr>\n";
	}
	else
	{
		echo "<tr nowrap><td align=\"center\">";
		echo "<input class=\"button\" type=\"button\" value=\"����\" onclick=\"goto('admin.php?j=News&a=list".state_addlink()."')\"></td>";
		echo "</tr>\n";
	}
	echo "<script>function goto(url){this.location.replace(url);}</script>";
	$Form->tablefooter();
	$Form->cpfooter();
}
elseif ($a == 'attlist')//�����б�
{
	$id = intval($_GET['id']);
	$sql_num = "select count(*) from ".$db_pic." where 1";
	$listNum = $db->fetch_one($sql_num);
	if($listNum == 0) exit;

	if ($id >= 0)
	{
		$lstRequest = "select * from ".$db_pic." where `aid`={$id} order by `order` asc, `date` desc";
	}
	elseif ($id == -1)
	{
		$lstRequest = "select * from ".$db_pic." where 1 order by `order` asc,`date` desc";
	}
	elseif ($id == -2)
	{
		$lstRequest = "select * from ".$db_pic." where `ispic`=0 order by `order` asc,`date` desc";
	}
	$vRe = $db->query($lstRequest);
	$Form->cpheader("","style_att");
	$Form->if_del();
	echo "<script src=\"js/att.js\"></script>";//frame�Զ���Ӧ�Ľű�
//��һ�����޸Ľ���
echo <<<SCR
<div id="editDIV" style="display:none;">
<form name="editform" method="post" action="admin.php?j=News&a=attupdate">
<input name="newsid" type="hidden" value="{$id}">
˳��
<input name="order" type="text" size="3" value="">
����˵��
<input name="attid" type="hidden" value="">
<input name="intro" size="40" type="input">
<input type="submit" value="�޸�">
<input type="button" onclick="editclose()" value="ȡ��">
</form></div>
<table width="620" border="0" cellpadding="5" cellspacing="1">
SCR;
//�޸Ľ������
	$echotr = 0;
	$att_w = 100 / $att_every;
	while($nL = $db->fetch_array($vRe)) 
	{
		if ($echotr % $att_every == 0) echo "<tr>";
		if ($nL['ispic']==1)
			$imgthumb = $imgPath."thumb/".$nL['url'];
		else
			$imgthumb = $imgPath."notpic.jpg";
		$img = $imgPath.'800/'.$nL['url'];
		if ($echotr<$att_every)
			echo "<td width=\"{$att_w}%\">";
		else
			echo "<td>";
		$intro = strlen($nL['intro'])>0 ? gbsubstr($nL['intro'],0,16) : '��˵��';
		$intro = $nL['order']." ".$intro;
		$attid = $nL['id'];
		echo "<table width=\"120\" border=\"0\" cellpadding=\"1\" cellspacing=\"1\" bgcolor=\"#CCCCCC\">";
		echo "<tr><td bgcolor=\"#FFFFFF\">".$intro."</td></tr>";
		echo "<tr><td bgcolor=\"#FFFFFF\"><img src=\"{$imgthumb}\" width=\"120\" height=\"90\" alt=\"{$nL['intro']}\"></td></tr>";
		echo "<tr><td bgcolor=\"#FFFFFF\" align=\"center\"><a href=\"{$img}\" target=\"_blank\">�鿴</a> <a href=\"javascript:editatt({$attid},'".$nL['order']."','".$nL['intro']."')\">�༭</a> <a href=\"#\" onclick=\"ifDel('admin.php?j=News&a=attdelete&newsid={$id}&id={$attid}')\">ɾ��</a></td></tr>";
		echo "</table>";
		echo "</td>";
		$echotr++;
		if ($echotr % $att_every == 0) echo "</tr>\n";
	}
	if ($echotr % $att_every != 0) 
	{
		if ($echotr<$att_every)
		{
			$w = $att_w * ($att_every-$echotr%$att_every);
			echo "<td width=\"{$w}%\"></td>";
		}
		echo "</tr>\n";
	}
	echo "</table>";
	echo "<script>framechange();</script>";
	$Form->cpfooter();
}
elseif ($a== 'attupload')//�����ϴ�
{
	if (!isset($_POST['id'])) $Form->oa_exit("��������");
	$newsid = intval($_POST['id']);
	$intro = checkStr($_POST['intro']);
	$ispic= 0 ;
	$filepath = $_FILES['file']['name'];
	if (strlen($filepath) >0)
	{
		require("class/class_Upload.php");
		$upd = new cUpload;
		$filetmp = $_FILES['file']['tmp_name'];
		$filesize = $_FILES['file']['size'];
		if($filesize == 0) 
		{
			echo "<script>alert(\"�ļ�������ļ�������\");this.location=\"admin.php?j=News&a=attlist&id={$newsid}\"</script>";
			exit;
		}
		$extname = $upd->getext($filepath);
		$uploadpath = "news-".date('Ymd').M_random(8).".".$extname;
		if (in_array($extname,array('gif','jpg','png')))//�ж��Ƿ�ΪͼƬ
			$ispic=1;
		switch($upd->upload($filetmp,$imgPath.$uploadpath))
		{
		case 1:
			echo "<script>alert(\"�ļ����Ͳ�����\");this.location=\"admin.php?j=News&a=attlist&id={$newsid}\"</script>";
			exit;
		case 2:
			echo "<script>alert(\"�ϴ����������������\");this.location=\"admin.php?j=News&a=attlist&id={$newsid}\"</script>";
			exit;
		default:
		}
		$upd->makeThumb($imgPath.$uploadpath,$imgPath."thumb/",240,180);
		$upd->makeThumb($imgPath.$uploadpath,$imgPath."800/",800,600);
		$sql_news = "select count(*) from ".$db_news." where `id`='".$newsid."'";
		if ($newsid>0 && $db->fetch_one($sql_news)==0) $newsid=0;//�жϸ����������Ƿ���
		$attnewsid = ($newsid>0) ? $newsid : 0;
		$default_order = $db->fetch_one("select max(`order`) from {$db_pic} where `aid`='".$newsid."'") + 1;
		$db->insert($db_pic,array(
			'aid' => $attnewsid,
			'ispic' => $ispic,
			'intro' => $intro,
			'url' => $uploadpath,
			'order' => $default_order,
			'date' => time(),
			'uploader' => $username,
			));
		echo "<script>this.location=\"admin.php?j=News&a=attlist&id={$newsid}\"</script>";
	}
	else
	{
		echo "<script>alert(\"δѡȡ�ļ�\");this.location=\"admin.php?j=News&a=attlist&id={$newsid}\"</script>";
		exit;
	}
}
elseif ($a== 'attdelete')//����ɾ��
{
	$id = intval($_GET['id']);
	$newsid = intval($_GET['newsid']);
	$attRequest = "select * from ".$db_pic." where `id`={$id}";
	$aL = $db->fetch_one_array($attRequest);
	$delRequest = "delete from".$db_pic." where `id`={$id}";
	if ($allow['attdelete'] == 2 || $aL['uploader'] == $username)
	{
		$db->query($delRequest);
		@unlink($imgPath."800/".$aL['path']);
		@unlink($imgPath."thumb/".$aL['path']);
		@unlink($imgPath.$aL['path']);
		header("location:admin.php?j=News&a=attlist&id=".$newsid);
	}
	else
	{
		echo "<script>alert(\"��û��Ȩ��ɾ�����ļ�\");this.location=\"admin.php?j=News&a=attlist&id={$newsid}\"</script>";
	}
}
elseif ($a== 'attupdate')//�����޸�
{
	$id = intval($_POST['attid']);
	$newsid = intval($_POST['newsid']);
	$db->update($db_pic,array(
		'order' => intval($_POST['order']),
		'intro' => checkStr($_POST['intro']),
		),"`id`={$id}");
	header("location:admin.php?j=News&a=attlist&id=".$newsid);
}
else
{
	$Form->oa_exit("���ܲ�����","index.php?a=main");
}

function deal_tags($data, $d=0)//$d=1 Ϊ������
{
	if ($d)
	{
		if (substr($data,0,1) == ',') $data = substr($data,1);
		if (substr($data,-1,1) == ',') $data = substr($data,0,strlen($data)-1);
	}
	else
	{
		$data = checkStr($data);
		$data = str_replace('��',',',$data);
		$data = str_replace(',,',',',$data);
		if (substr($data,0,1) != ',') $data = ','.$data;
		if (substr($data,-1,1) != ',') $data = $data.',';
	}
	return ($data);
}
function state_addlink()
{
	$state_addlink = "";
	if (isset($_GET['state']))
	{
		$state =  intval($_GET['state']);
		if ($state >= 0 && $state <= 3)
		{
			$condition = "`state`='".$state."'";
			$state_addlink = "&state=".$state;
		}
	}
	return $state_addlink;
}
function build_sorts_cache($db_sort,$sortscache)
{
	global $db;
	$fp = fopen($sortscache,"w");
	$sql = "select * from ".$db_sort." where `visible`=1 order by `order` asc";
	$query = $db->query($sql);

	$cache1 = "\$sortname_short = array(\n";
	$cache2 = "\$sortname_all = array(\n";
	while($sL = $db->fetch_array($query))
	{
		$cache1 .= $sL['id']." => \"".$sL['short']."\",\n";
		$cache2 .= $sL['id']." => \"".$sL['name']."\",\n";
	}
	$cache1 .= ");\n";
	$cache2 .= ");\n";
	$cache = "<?php\n".$cache1.$cache2."?>";
	fwrite($fp,$cache);
	fclose($fp);
}

function make_condition($argument = array())
{
	$Form = new cpForms;
	if ($argument['permission'] == 1)
	{
		$condition = "`username` =".$username;
		$start = 1;
	}
	elseif ($argument['permission'] == 2)
	{
		$condition = "";
		$start = 0;
	}
	else
		$Form->oa_exit("��û��Ȩ�޽�������");
	if ($start == 0)
	{
		$condition .= '`sort`='.$argument['sort'];
	}
	else
	{
		$condition .= ' and `sort`='.$argument['sort'];
	}
	if ($argument['title'] != "")
		$condition .= " and `title` LIKE '%".$argument['title']."%'";
	if ($argument['author'] != "")
		$condition .= " and `author` LIKE '%".$argument['author']."%'";
	if ($argument['source'] != "")
		$condition .= " and `source` LIKE '%".$argument['source']."%'";
	if ($argument['tag'] != "")
		$condition .= " and `tag` LIKE '%,".$argument['tag'].",%'";
	return $condition;
}
?>