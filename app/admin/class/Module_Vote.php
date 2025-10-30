<?php
/*
新闻功能模块
========
需要的类：config.php forms.php class_DataBase.php SmartTemplate class_User.php
========
主要功能：（$a == ）
--------------------
add 添加投票主题	doadd 执行添加投票主题
list 投票主题列表	edit 编辑投票主题	doedit 执行编辑投票主题	del 删除投票主题

附加功能 (function)
-------------------
correct($choice = array()) 判断投票选西拿过是否合法

关于权限的说明
==============
0 表示无权执行该操作
1 部份操作才有，表示限制执行该操作(list,edit,attdelete为1时只能操作自己的)
2 表示允许执行该操作
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
$db_vote = "`".$mysql_prefix."vote`"; //投票数据表
$num_in_page = 20;  //每页显示数目

$allow = array();

switch($usr->rights['News'])
{
case 'S':  //超级管理员
	$allow = array(
		'add' => 2, 'doadd' => 2, 'list' => 2, 'edit' => 2, 'doedit' => 2, 'del' => 2,
		);
	break;
case 'A':  //一级管理员
	$allow = array(
		'add' => 2, 'doadd' => 2, 'list' => 2, 'edit' => 2, 'doedit' => 2, 'del' => 2,
		);
	break;
case 'M':  //二级管理员
	$allow = array(
		'add' => 0, 'doadd' => 0, 'list' => 0, 'edit' => 0, 'doedit' => 0, 'del' => 0,
		);
	break;
default:  //无权限
	$allow = array(
		'add' => 0, 'doadd' => 0, 'list' => 0, 'edit' => 0, 'doedit' => 0, 'del' => 0,
		);
	break;
}

if (!($allow[$a] > 0)) $Form->oa_exit("你没有权限执行该操作~~");

if ($a == 'add') //添加投票主题
{
	$Form->cpheader("添加投票主题");
	$Form->formheader(array(
		'title' => "添加投票主题",
		'action' => "admin.php?j=Vote&a=doadd"
		));
	$Form->makeinput(array(
		'text' => "标题",
		'name' => "title",
		'size' => "100"
		));
	for ($i=1; $i<=5; $i++)
	{
		$Form->makeinput(array(
			'text' => "第".$i."个选项",
			'name' => "choice".$i,
			'size' => "50"
			));
	}
	$Form->formfooter(array(
		"button" => array(
			array('value'=>"添加"),
			array('value'=>"重置",'type'=>"reset"),
		)));
	$Form->cpfooter();
}
elseif ($a == 'doadd') //执行添加投票主题
{
	$title = checkStr($_POST['title']);
	if (!$title) $Form->oa_exit("请填写投票主题名称");
	for ($i=1; $i<=5; $i++)
	{
		$choice[$i] = checkStr($_POST['choice'.$i]);
	}
	if (!correct($choice)) $Form->oa_exit("投票选项有错误");
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
	$Form->oa_exit("添加投票主题成功","admin.php?j=Vote&a=list");
}
elseif ($a == 'list') //投票主题列表
{
	$sql_num = "select count(*) from ".$db_vote." where 1";
	$listNum = $db->fetch_one($sql_num);
	$formtitle = "投票主题 [共".$listNum."条] [{$num_in_page}条/页]";

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
		echo "<td width=\"55%\"><b>标题</b></td>\n";
		echo "<td width=\"15%\"><b>添加者</b></td>\n";
		echo "<td width=\"15%\"><b>IP</b></td>\n";
		echo "<td width=\"15%\"><b>时间</b></td>\n";
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
		$Form->maketd(array("暂时没有投票主题~~"));
		$Form->tablefooter();
	}
	$Form->cpfooter();
}
elseif ($a == 'edit') //编辑投票主题
{
	$id = intval($_GET['id']);
	$sql_vote = "select * from ".$db_vote." where `id`='".$id."'";
	$nL = $db->fetch_one_array($sql_vote);
	if (empty($nL)) $Form->oa_exit("该投票主题不存在");

	$Form->cpheader("添加投票主题");
	$Form->formheader(array(
		'title' => "添加投票主题",
		'action' => "admin.php?j=Vote&a=doedit"
		));
	$Form->makehidden(array(
		'name' => "id",
		'value' => $id
		));
	$Form->makeinput(array(
		'text' => "标题",
		'name' => "title",
		'size' => "100",
		'value' => $nL['title'],
		));
	for ($i=1; $i<=5; $i++)
	{
		$Form->makeinput(array(
			'text' => "第".$i."个选项",
			'name' => "choice".$i,
			'size' => "50",
			'value' => $nL['choice'.$i],
			));
	}
	$Form->formfooter(array(
		"button" => array(
			array('value'=>"编辑"),
			array('value'=>"删除",'type'=>"button",'extra' => "onclick=\"goto('admin.php?j=Vote&a=del&id={$id}')\""),
			array('value'=>"重置",'type'=>"reset"),
		)));
	echo "<script>function goto(url){this.location.replace(url);}</script>";
	$Form->cpfooter();
}
elseif ($a == 'doedit') //执行编辑投票主题
{
	$id = $_POST['id'];
	$title = checkStr($_POST['title']);
	if (!$title) $Form->oa_exit("请填写投票主题名称");
	for ($i=1; $i<=5; $i++)
	{
		$choice[$i] = checkStr($_POST['choice'.$i]);
	}
	if (!correct($choice)) $Form->oa_exit("投票选项有错误");
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
	$Form->oa_exit("编辑投票主题成功","admin.php?j=Vote&a=list");
}
elseif ($a == 'del') //删除投票主题
{
	$id = intval($_GET['id']);
	$sql = "select count(*) from ".$db_vote." where `id`='".$id."'";
	$num = $db->fetch_one($sql);
	
	if (!($num)) $Form->oa_exit("该留言不存在");

	$db->query("delete from ".$db_vote." where `id`='".$id."'");
	$Form->oa_exit("删除投票主题成功!","admin.php?j=Vote&a=list");
}
else
{
	$Form->oa_exit("功能不存在","index.php?a=main");
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