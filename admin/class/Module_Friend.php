<?php
/*
新闻功能模块
========
需要的类：config.php forms.php class_DataBase.php SmartTemplate class_User.php
========
主要功能：（$a == ）
--------------------
list 友情链接列表	check 编辑友情链接	docheck	执行编辑友情链接	del	删除友情链接

附加功能 (function)
-------------------

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
$db_friend = "`".$mysql_prefix."friend`"; //友情链接数据表
$num_in_page = 20;  //每页显示数目

$allow = array();

switch($usr->rights['Friend'])
{
case 'S':  //超级管理员
	$allow = array(
		'list' => 2, 'check' => 2, 'docheck' => 2, 'del' => 2,
		);
	break;
case 'A':  //一级管理员
	$allow = array(
		'list' => 2, 'check' => 2, 'docheck' => 2, 'del' => 2,
		);
	break;
case 'M':  //二级管理员
	$allow = array(
		'list' => 0, 'check' => 0, 'docheck' => 0, 'del' => 0,
		);
	break;
default:  //无权限
	$allow = array(
		'list' => 0, 'check' => 0, 'docheck' => 0, 'del' => 0,
		);
	break;
}

if (!($allow[$a] > 0)) $Form->oa_exit("你没有权限执行该操作~~");

if ($a == 'list') //友情链接列表
{
	$top = array('', '<font color=red>Yes</a>');
	$status = array('<font color=red>未审</font>', '<font color=green>通过</font>');
	$type = array('文字', 'LOGO');

	$sql_num = "select count(*) from ".$db_friend." where 1";

	$listNum = $db->fetch_one($sql_num);
	$formtitle = "友情链接 [共".$listNum."条] [{$num_in_page}条/页]";

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
		echo "<td width=\"6%\"><b>置顶</b></td>\n";
		echo "<td width=\"9%\"><b>状态</b></td>\n";
		echo "<td width=\"10%\"><b>类型</b></td>\n";
		echo "<td width=\"25%\"><b>网站名称</b></td>\n";
		echo "<td width=\"15%\"><b>IP</b></td>\n";
		echo "<td width=\"15%\"><b>时间</b></td>\n";
		echo "<td width=\"20%\"><b>操作</b></td>\n";
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
			echo "<td align=\"center\"><a href=\"admin.php?j=Friend&a=check&id=".$nL['id']."\">审批</a> <a href=\"admin.php?j=Friend&a=del&id=".$nL['id']."\">删除</a></td>\n";
			echo "</tr>\n";
		}
		echo "<tr><td colspan=\"7\" align=\"right\">".$page_char."</td></tr>";
		$Form->tablefooter(array("colspan" => "7"));
	}
	else
	{
		$Form->tableheaderbig(array("title" => $formtitle,));
		$Form->maketd(array("暂时没有友情链接~~"));
		$Form->tablefooter();
	}
	$Form->cpfooter();
}
elseif ($a == 'check') 
{
	$id = intval($_GET['id']);
	$type = array('文字链接', 'LOGO链接');
	$sql_friend = "select * from ".$db_friend." where `id`='".$id."'";
	$nL = $db->fetch_one_array($sql_friend);
	if (empty($nL)) $Form->oa_exit("该友情链接不存在");
	$Form->cpheader("审批友情链接");
	$Form->formheader(array(
		'title' => "审批友情链接",
		'method' => "POST",
		'action' => "admin.php?j=Friend&a=docheck",
		));
	$Form->makehidden(array(
		'name' => "id",
		'value' => $id
		));
	$Form->maketd(array(
		"<b>类型</b>",
		$type[$nL['type']],
		));
	$Form->maketd(array(
		"<b>网站名称</b>",
		$nL['title'],
		));
	if ($nL['type'] == 1)
	{
		$Form->maketd(array(
		"<b>网站LOGO</b>",
		"<img src=\"".$nL['pic']."\" width=\"90px\" height=\"34px\" />",
		));
	}
	$Form->maketd(array(
		"<b>网站链接</b>",
		"<a href=\"".$nL['link']."\" target=\"_blank\">".$nL['link']."</a>",
		));
	$Form->maketd(array(
		"<b>网站简介</b>",
		$nL['intro'],
		));
	$Form->maketd(array(
		"<b>网站管理员</b>",
		$nL['name'],
		));
	$Form->maketd(array(
		"<b>管理员邮箱</b>",
		$nL['email'],
		));
	$Form->makeselect(array(
		'option' => array('待审', '通过'),
		'text' => "审批",
		'name' => "state",
		'selected' => $nL['status']));
	$Form->makeselect(array(
		'option' => array('不置顶', '置顶'),
		'text' => "置顶",
		'name' => "top",
		'selected' => $nL['top']));
	$Form->formfooter(array(
		"button" => array(
			array('value'=>"确定"),
			array('value'=>"删除",'type'=>"button",'extra' => "onclick=\"goto('admin.php?j=Friend&a=del&id={$id}')\""),
			array('value'=>"返回", 'type'=>"button", 'extra' => "onclick=\"goto('admin.php?j=Friend&a=list')\""),
		)));
	echo "<script>function goto(url){this.location.replace(url);}</script>";
	$Form->cpfooter();
}
elseif ($a == 'docheck') //执行审批友情链接
{
	if (!isset($_POST['id'])) $Form->oa_exit("参数错误");
	$id = intval($_POST['id']);

	$sql_friend = "select count(*) from ".$db_friend." where `id`='".$id."'";
	if ($db->fetch_one($sql_friend)==0) $Form->oa_exit("友情链接不存在");

	$db->update($db_friend,array(
		'status' => intval($_POST['state']),
		'top' => intval($_POST['top']),
		'checker' => $username,
		'checkip' => getip(),
		),"`id`={$id}");
	$Form->oa_exit("预约审批成功","admin.php?j=Friend&a=list");
}
elseif ($a == 'del') //删除友情链接
{
	$id = intval($_GET['id']);
	$sql = "select count(*) from ".$db_friend." where `id`='".$id."'";
	$num = $db->fetch_one($sql);
	
	if (!($num)) $Form->oa_exit("该友情链接不存在");

	$db->query("delete from ".$db_friend." where `id`='".$id."'");
	$Form->oa_exit("删除友情链接成功!","admin.php?j=Friend&a=list");
}
else
{
	$Form->oa_exit("功能不存在","index.php?a=main");
}
?>