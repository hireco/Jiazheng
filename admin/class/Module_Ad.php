<?php
/*
新闻功能模块
========
需要的类：config.php forms.php class_DataBase.php SmartTemplate class_User.php
========
主要功能：（$a == ）
--------------------
add 添加广告	doadd 执行添加广告
list 广告列表
show 查看广告	edit 编辑广告	doedit 执行编辑广告
del 删除广告

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
$db_ad = "`".$mysql_prefix."advertise`"; //新闻数据表
$num_in_page = 20;  //每页显示数目

$allow = array();

switch($usr->rights['Ad'])
{
case 'S':  //超级管理员
	$allow = array(
		'add' => 2, 'doadd' => 2, 'list' => 2, 'show' => 2, 'edit' => 2, 'doedit' => 2, 'del' => 2,
		);
	break;
case 'A':  //一级管理员
	$allow = array(
		'add' => 2, 'doadd' => 2, 'list' => 2, 'show' => 2, 'edit' => 2, 'doedit' => 2, 'del' => 2,
		);
	break;
case 'M':  //二级管理员
	$allow = array(
		'add' => 0, 'doadd' => 0, 'list' => 0, 'show' => 0, 'edit' => 0, 'doedit' => 0, 'del' => 0,
		);
	break;
default:  //无权限
	$allow = array(
		'add' => 0, 'doadd' => 0, 'list' => 0, 'show' => 0, 'edit' => 0, 'doedit' => 0, 'del' => 0,
		);
	break;
}

if (!($allow[$a] > 0)) $Form->oa_exit("你没有权限执行该操作~~");

$type = array('图片', 'Flash');
$position = array('左侧'=>'左侧', '右侧'=>'右侧',);

if ($a == 'add') //添加广告
{
	$Form->cpheader("添加广告");
	$Form->formheader(array(
		'title' => "添加广告",
		'action' => "admin.php?j=Ad&a=doadd"
		));
	$Form->makeselect(array(
		'text' => "位置",
		'name' => "position",
		'option' => $position));
	$Form->maketextarea(array(
		'text' => "内容",
		'note' => "广告的宽度请不要超过100px",
		'name' => "content",
		'cols' => "600",
		'rows' => "400",
		));
	$Form->formfooter(array(
		"button" => array(
			array('value'=>"添加"),
			array('value'=>"重置",'type'=>"reset"),
		)));
	$Form->cpfooter();
}
elseif ($a == 'doadd') //执行添加广告
{
	$db->insert($db_ad,array(
		'position' => $_POST['position'],
		'content' => $_POST['content'],
		'adder' => $username,
		'time' => time(),
		'addip' => getip(),
		));
	$Form->oa_exit("添加广告成功","admin.php?j=Ad&a=list");
}
elseif ($a == 'list') //广告列表
{
	$sql_num = "select count(*) from ".$db_ad." where 1";
	$listNum = $db->fetch_one($sql_num);
	$formtitle = "广告 [共".$listNum."条] [{$num_in_page}条/页]";

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
		echo "<td width=\"18%\"><b>位置</b></td>\n";
		echo "<td width=\"18%\"><b>添加者</b></td>\n";
		echo "<td width=\"18%\"><b>IP</b></td>\n";
		echo "<td width=\"18%\"><b>时间</b></td>\n";
		echo "<td width=\"28%\"><b>操作</b></td>\n";
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
			echo "<td align=\"center\"><a href=\"admin.php?j=Ad&a=show&id=".$nL['id']."\">查看</a> <a href=\"admin.php?j=Ad&a=edit&id=".$nL['id']."\">编辑</a> <a href=\"admin.php?j=Ad&a=del&id=".$nL['id']."\">删除</a></td>\n";
			echo "</tr>\n";
		}
		echo "<tr><td colspan=\"5\" align=\"right\">".$page_char."</td></tr>";
		$Form->tablefooter(array("colspan" => "5"));
	}
	else
	{
		$Form->tableheaderbig(array("title" => $formtitle,));
		$Form->maketd(array("暂时没有广告~~"));
		$Form->tablefooter();
	}
	$Form->cpfooter();
}
elseif ($a == 'show') //查看广告
{
	$Form->if_del();
	$id = intval($_GET['id']);
	$sql_ad = "select * from ".$db_ad." where `id`='".$id."'";
	$nL = $db->fetch_one_array($sql_ad);
	if (empty($nL)) $Form->oa_exit("该广告不存在");
	$Form->cpheader("查看广告");
	$Form->formheader(array(
		'title' => "查看广告",
		));
	$Form->maketd(array(
		"<b>位置</b>",
		$position[$nL['position']],
		));
	$Form->maketd(array(
		"<b>内容</b>",
		$nL['content'],
		));
	$Form->formfooter(array(
		"button" => array(
			array('value'=>"编辑",'type'=>"button",'extra' => "onclick=\"goto('admin.php?j=Ad&a=edit&id={$id}')\""),
			array('value'=>"删除",'type'=>"button",'extra' => "onclick=\"ifDel('admin.php?j=Ad&a=del&id={$id}')\""),
			array('value'=>"返回", 'type'=>"button", 'extra' => "onclick=\"goto('admin.php?j=Ad&a=list')\""),
		)));
	echo "<script>function goto(url){this.location.replace(url);}</script>";
	$Form->cpfooter();
}
elseif ($a == 'edit') //编辑广告
{
	$id = intval($_GET['id']);
	$sql_ad = "select * from ".$db_ad." where `id`='".$id."'";
	$nL = $db->fetch_one_array($sql_ad);
	if (empty($nL)) $Form->oa_exit("该广告不存在");

	$Form->cpheader("编辑广告");
	$Form->formheader(array(
		'title' => "编辑广告",
		'action' => "admin.php?j=Ad&a=doedit",
		));
	$Form->makehidden(array(
		'name' => "id",
		'value' => $id
		));
	$Form->makeselect(array(
		'option' => $position,
		'text' => "位置",
		'name' => "position",
		'selected' => $nL['position']));
	$Form->maketextarea(array(
		'text' => "内容",
		'name' => "content",
		'cols' => "600",
		'rows' => "400",
		'value' => $nL['content'],
		));
	$Form->formfooter(array(
		"button" => array(
			array('value'=>"保存"),
			array('value'=>"重置", 'type'=>"reset"),
			array('value'=>"返回", 'type'=>"button", 'extra' => "onclick=\"goto('admin.php?j=Ad&a=list')\""),
		)));
	echo "<script>function goto(url){this.location.replace(url);}</script>";
	$Form->tablefooter();
	$Form->cpfooter();
}
elseif ($a == 'doedit') //执行编辑广告
{
	if (!isset($_POST['id'])) $Form->oa_exit("参数错误");
	$id = intval($_POST['id']);

	$sql_ad = "select count(*) from ".$db_ad." where `id`='".$id."'";
	if ($db->fetch_one($sql_ad)==0) $Form->oa_exit("留言不存在");

	$db->update($db_ad,array(
		'position' => $_POST['position'],
		'content' => $_POST['content'],
		'adder' => $username,
		'addip' => getip(),
		'time' => time(),
		),"`id`={$id}");
	$Form->oa_exit("广告审批成功","admin.php?j=Ad&a=list");
}
elseif ($a == 'del') //删除广告
{
	$id = intval($_GET['id']);
	$sql = "select count(*) from ".$db_ad." where `id`='".$id."'";
	$num = $db->fetch_one($sql);
	
	if (!($num)) $Form->oa_exit("该广告不存在");

	$db->query("delete from ".$db_ad." where `id`='".$id."'");
	$Form->oa_exit("删除广告成功!","admin.php?j=Ad&a=list");
}
else
{
	$Form->oa_exit("功能不存在","index.php?a=main");
}
?>