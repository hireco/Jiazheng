<?php
/*
新闻功能模块
========
需要的类：config.php forms.php class_DataBase.php SmartTemplate class_User.php
========
主要功能：（$a == ）
--------------------
reserveemployee 雇员预订列表	checkreserveemployee 审核雇员预约	dealreserveemployee 批量处理雇员预约	delreservee 删除雇员预约
reserveemployer 雇主预订列表	checkreserveemployer 审核雇主预约	dealreserveemployer 批量处理雇主预约	delreserver 删除雇主预约
register 快速登记列表	showregister 查看快速登记	delregister	删除快速登记
note 留言列表	replynote 回复留言	doreplynote 执行回复留言	delnote 删除留言

附加功能 (function)
-------------------

关于权限的说明
==============
0 表示无权执行该操作
1 部份操作才有，表示限制执行该操作
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

$db_reservee = "`".$mysql_prefix."reservee`"; //预约雇员数据表
$db_reserver = "`".$mysql_prefix."reserver`"; //预约雇主数据表
$db_register = "`".$mysql_prefix."register`"; //快速登记数据表
$db_note = "`".$mysql_prefix."guestbook`"; //留言本数据表
$db_employee = "`".$mysql_prefix."employee`"; //雇员数据表
$db_employer = "`".$mysql_prefix."employer`"; //雇主数据表
$db_area = "`".$mysql_prefix."area`"; //地区数据表

$num_in_page = 20;  //每页显示数目

$allow = array();

switch($usr->rights['Note'])
{
case 'S':  //超级管理员
	$allow = array(
		'reserveemployee' => 2, 'checkreserveemployee' => 2, 'docheckreserveemployee' => 2, 'dealreserveemployee' => 2, 'delreservee' => 2,
		'reserveemployer' => 2, 'checkreserveemployer' => 2, 'docheckreserveemployer' => 2, 'dealreserveemployer' => 2, 'delreserver' => 2,
		'register' => 2, 'showregister' => 2, 'delregister' => 2,
		'note' => 2, 'replynote' => 2, 'doreplynote' => 2, 'delnote'=> 2,
		);
	break;
case 'A':  //一级管理员
	$allow = array(
		'reserveemployee' => 2, 'checkreserveemployee' => 2, 'docheckreserveemployee' => 2, 'dealreserveemployee' => 2, 'delreservee' => 2,
		'reserveemployer' => 2, 'checkreserveemployer' => 2, 'docheckreserveemployer' => 2, 'dealreserveemployer' => 2, 'delreserver' => 2,
		'register' => 2, 'showregister' => 2, 'delregister' => 2,
		'note' => 2, 'replynote' => 2, 'doreplynote' => 2, 'delnote'=> 2,
		);
	break;
case 'M':  //二级管理员
	$allow = array(
		'reserveemployee' => 0, 'checkreserveemployee' => 0, 'docheckreserveemployee' => 0, 'dealreserveemployee' => 0, 'delreservee' => 0,
		'reserveemployer' => 0, 'checkreserveemployer' => 0, 'docheckreserveemployer' => 0, 'dealreserveemployer' => 0, 'delreserver' => 0,
		'register' => 0, 'showregister' => 0, 'delregister' => 0,
		'note' => 1, 'replynote' => 1, 'doreplynote' => 1, 'delnote'=> 1,
		);
	break;
default:  //无权限
	$allow = array(
		'reserveemployee' => 0, 'checkreserveemployee' => 0, 'docheckreserveemployee' => 0, 'dealreserveemployee' => 0, 'delreservee' => 0,
		'reserveemployer' => 0, 'checkreserveemployer' => 0, 'docheckreserveemployer' => 0, 'dealreserveemployer' => 0, 'delreserver' => 0,
		'register' => 0, 'showregister' => 0, 'delregister' => 0,
		'note' => 0, 'replynote' => 0, 'doreplynote' => 0, 'delnote'=> 0,
		);
	break;
}

if (!($allow[$a] > 0)) $Form->oa_exit("你没有权限执行该操作~~");

if ($a == 'reserveemployee') //预约雇员列表
{
	$reserve_status = array('<font color=red>未审</font>', '退回', '<font color=green>通过</font>');

	$sql_num = "select count(*) from ".$db_reservee." where 1";
	$listNum = $db->fetch_one($sql_num);
	$formtitle = "预约雇员 [共".$listNum."条] [{$num_in_page}条/页]";

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
		echo "<td width=\"8%\"><b>状态</b></td>\n";
		echo "<td width=\"14%\"><b>雇主</b></td>\n";
		echo "<td width=\"14%\"><b>雇员</b></td>\n";
		echo "<td width=\"12%\"><b>服务</b></td>\n";
		echo "<td width=\"12%\"><b>IP</b></td>\n";
		echo "<td width=\"15%\"><b>时间</b></td>\n";
		echo "<td width=\"20%\"><b>操作</b></td>\n";
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
			echo "<td>".date('n月j日G时',$nL['date'])."</td>\n";
			echo "<td align=\"center\"><a href=\"admin.php?j=Note&a=checkreserveemployee&id=".$nL['id']."\">审批</a> <a href=\"#\" onclick=\"ifDel('admin.php?j=Note&a=delreservee&id=".$nL['id']."')\">删除</a></td>\n";
			echo "</tr>\n";
		}
		echo "<tr><td colspan=\"8\" align=\"right\">".$page_char."</td></tr>";
		echo "<tr><td colspan=\"8\" align=\"center\"><select name=\"operation\"><option value=\"0\">请选择</option><option value=\"1\">转发预约</option><option value=\"2\">电话联系</option><option value=\"对不起，对方暂不预约\">暂不预约</option><option value=\"对不起，您的专业技能不合适\">技能不合</option><option value=\"对不起，您的身份不合适\">身份不合</option><option value=\"对不起，可能家政距离太远\">距离太远</option><option value=\"您的重复预约了多次\">预约重复</option><option value=\"您的联系电话无效\">电话无效</option><option value=\"对不起，雇主没有选择您\">选了别人</option><option value=\"请认真填写预约信息\">填写错误</option><option value=\"该信息因时间太长而无效\">信息过期</option><option value=\"该家政信息已经被安排\">已经安排</option></select>&nbsp;&nbsp;&nbsp;&nbsp;<input class=\"button\" accesskey=\"\" type=\"submit\" name=\"\" value=\"处理\" />";
		$Form->makehidden(array(
			'name' => "page",
			'value' => $cpage,
			));
		echo "\n</td></tr></form></table>\n";
	}
	else
	{
		$Form->tableheaderbig(array("title" => $formtitle,));
		$Form->maketd(array("暂时没有预约~~"));
		$Form->tablefooter();
	}
	$Form->cpfooter();
}
elseif ($a == 'checkreserveemployee') //审核预约雇员
{
	$id = intval($_GET['id']);
	$sql_reserve = "select * from ".$db_reservee." where `id`='".$id."'";
	$nL = $db->fetch_one_array($sql_reserve);
	if (empty($nL)) $Form->oa_exit("该预约不存在");
	$Form->cpheader("审批预约");
	$Form->if_Del();
	$Form->formheader(array(
		'title' => "审批预约",
		'method' => "POST",
		'action' => "admin.php?j=Note&a=docheckreserveemployee",
		));
	$Form->makehidden(array(
		'name' => "id",
		'value' => $id
		));
	$Form->maketd(array(
		"<b>类型</b>",
		"预约雇员",
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
		"<b>雇主</b>",
		$employer,
		));
	$Form->maketd(array(
		"<b>雇员</b>",
		$employee,
		));
	$Form->maketd(array(
		"<b>预约时间</b>",
		date('y-m-d', $nL['date']),
		));
	$area = $db->fetch_one("select `name` from ".$db_area." where `id`=".$nL['area']);
	if (intval($nL['sid']) == 0)
	{
		$Form->maketd(array('colspan=2' => "<font color=blue><b>以下是雇主的基本信息</b></font>"));
		$Form->maketd(array('<b>Email</b>', $nL['email']));
		$Form->maketd(array('<b>电话号码</b>', $nL['telephone']));
		$Form->maketd(array('<b>手机号码</b>', $nL['mobile']));
		$Form->maketd(array('<b>QQ</b>', $nL['qq']));
		$Form->maketd(array('<b>地区</b>', $area));
		$Form->maketd(array('<b>地址</b>', $nL['address']));
		$Form->maketd(array('<b>服务</b>', trim(str_replace(',', ' ', $nL['service']))));
		$Form->maketd(array('<b>备注</b>', str2html($nL['snote'])));
		$Form->maketd(array('colspan=2' => "<font color=blue><b>以下是审批</b></font>"));
	}
	$Form->makeselect(array(
		'option' => array('待审', '退回', '通过'),
		'text' => "审批",
		'name' => "state",
		'selected' => $nL['status']));
	$Form->maketextarea(array(
		'text' => "备注",
		'name' => "note",
		'value' => $nL['note'],
		), 0);
	$Form->formfooter(array(
		"button" => array(
			array('value'=>"审批"),
			array('value'=>"删除",'type'=>"button",'extra' => "onclick=\"ifDel('admin.php?j=Note&a=delreservee&id={$id}')\""),
			array('value'=>"返回", 'type'=>"button", 'extra' => "onclick=\"goto('admin.php?j=Note&a=reserveemployee')\""),
		)));
	echo "<script>function goto(url){this.location.replace(url);}</script>";
	$Form->cpfooter();
}
elseif ($a == 'docheckreserveemployee') //执行审核雇员预约
{
	if (!isset($_POST['id'])) $Form->oa_exit("参数错误");
	$id = intval($_POST['id']);

	$sql_reserve = "select count(*) from ".$db_reservee." where `id`='".$id."'";
	if ($db->fetch_one($sql_reserve)==0) $Form->oa_exit("预约不存在");

	$db->update($db_reservee,array(
		'status' => intval($_POST['state']),
		'note' => checkStr($_POST['note']),
		'checker' => $username,
		'checkip' => getip(),
		),"`id`={$id}");
	$Form->oa_exit("预约审批成功","admin.php?j=Note&a=reserveemployee");
}
elseif ($a == 'delreservee') //删除雇员预约
{
	$id = intval($_GET['id']);
	$sql = "select count(*) from ".$db_reservee." where `id`='".$id."'";
	$num = $db->fetch_one($sql);
	
	if (!($num)) $Form->oa_exit("该预约不存在");

	$db->query("delete from ".$db_reservee." where `id`='".$id."'");
	$Form->oa_exit("删除预约成功!","admin.php?j=Note&a=reserveemployee");
}
elseif ($a == 'dealreserveemployee') //批量处理雇员预约
{
	$page = $_POST['page'];
	$reserve = $_POST["reserve"];
	$operation = $_POST['operation'];
	if ($operation == '0')
	{
		$Form->oa_exit("请选择处理的操作", 'admin.php?j=Note&a=reserveemployee&page='.$page);
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
						"note" => "已转发预约，请等候雇主决定",
						"checker" => $username,
						"checkip" => getip(),
						),"`id`='".$rid."'");
				}
				elseif ($operation == '2')
				{
					$db->update($db_reservee,array(
						"status" => 2,
						"note" => "请速电话联系家政中心",
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
		$Form->oa_exit("成功处理{$num}个预约","admin.php?j=Note&a=reserveemployee&page={$page}");
	}
	else
		$Form->oa_exit("你还没有选择选项", "admin.php?j=Note&a=reserveemployee&page={$page}");
}
elseif ($a == 'reserveemployer') //预约雇主列表
{
	$reserve_status = array('<font color=red>未审</font>', '退回', '<font color=green>通过</font>');

	$sql_num = "select count(*) from ".$db_reserver." where 1";
	$listNum = $db->fetch_one($sql_num);
	$formtitle = "预约雇主 [共".$listNum."条] [{$num_in_page}条/页]";

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
		echo "<td width=\"6%\"><b>状态</b></td>\n";
		echo "<td width=\"12%\"><b>雇员</b></td>\n";
		echo "<td width=\"12%\"><b>雇主</b></td>\n";
		echo "<td width=\"12%\"><b>服务</b></td>\n";
		echo "<td width=\"12%\"><b>地区</b></td>\n";
		echo "<td width=\"12%\"><b>IP</b></td>\n";
		echo "<td width=\"14%\"><b>时间</b></td>\n";
		echo "<td width=\"15%\"><b>操作</b></td>\n";
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
			echo "<td>".date('n月j日G时',$nL['date'])."</td>\n";
			echo "<td align=\"center\"><a href=\"admin.php?j=Note&a=checkreserveemployer&id=".$nL['id']."\">审批</a> <a href=\"#\" onclick=\"ifDel('admin.php?j=Note&a=delreserver&id=".$nL['id']."')\">删除</a></td>\n";
			echo "</tr>\n";
		}
		echo "<tr><td colspan=\"9\" align=\"right\">".$page_char."</td></tr>";
		echo "<tr><td colspan=\"9\" align=\"center\"><select name=\"operation\"><option value=\"0\">请选择</option><option value=\"1\">转发预约</option><option value=\"2\">电话联系</option><option value=\"对不起，对方暂不预约\">暂不预约</option><option value=\"对不起，可能家教距离太远\">距离太远</option><option value=\"您的重复预约了多次\">预约重复</option><option value=\"您的联系电话无效\">电话无效</option><option value=\"对不起，雇员没有选择您\">选了别人</option><option value=\"请认真填写预约信息\">填写错误</option><option value=\"该信息因时间太长而无效\">信息过期</option><option value=\"该家教信息已经被安排\">已经安排</option></select>&nbsp;&nbsp;&nbsp;&nbsp;<input class=\"button\" accesskey=\"\" type=\"submit\" name=\"\" value=\"处理\" />";
		$Form->makehidden(array(
			'name' => "page",
			'value' => $cpage,
			));
		echo "\n</td></tr></form></table>\n";
	}
	else
	{
		$Form->tableheaderbig(array("title" => $formtitle,));
		$Form->maketd(array("暂时没有预约~~"));
		$Form->tablefooter();
	}
	$Form->cpfooter();
}
elseif ($a == 'checkreserveemployer') //审核雇主预约
{
	$id = intval($_GET['id']);
	$sql_reserve = "select * from ".$db_reserver." where `id`='".$id."'";
	$nL = $db->fetch_one_array($sql_reserve);
	if (empty($nL)) $Form->oa_exit("该预约不存在");
	$Form->cpheader("审批预约");
	$Form->if_Del();
	$Form->formheader(array(
		'title' => "审批预约",
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
		"<b>类型</b>",
		"预约雇主",
		));
	$Form->maketd(array(
		"<b>雇员</b>",
		$employee,
		));
	$Form->maketd(array(
		"<b>雇主</b>",
		$employer,
		));
	$Form->maketd(array(
		"<b>预约时间</b>",
		date('n月j日G时',$nL['date']),
		));
	$Form->makeselect(array(
		'option' => array('待审', '退回', '通过'),
		'text' => "审批",
		'name' => "state",
		'selected' => $nL['status']));
	$Form->maketextarea(array(
		'text' => "备注",
		'name' => "note",
		'value' => $nL['note'],
		), 0);
	$Form->formfooter(array(
		"button" => array(
			array('value'=>"审批"),
			array('value'=>"删除",'type'=>"button",'extra' => "onclick=\"ifDel('admin.php?j=Note&a=delreserver&id={$id}')\""),
			array('value'=>"返回", 'type'=>"button", 'extra' => "onclick=\"goto('admin.php?j=Note&a=reserveemployer')\""),
		)));
	echo "<script>function goto(url){this.location.replace(url);}</script>";
	$Form->cpfooter();
}
elseif ($a == 'docheckreserveemployer') //执行审核雇主预约
{
	if (!isset($_POST['id'])) $Form->oa_exit("参数错误");
	$id = intval($_POST['id']);

	$sql_reserve = "select count(*) from ".$db_reserver." where `id`='".$id."'";
	if ($db->fetch_one($sql_reserve)==0) $Form->oa_exit("预约不存在");

	$db->update($db_reserver,array(
		'status' => intval($_POST['state']),
		'note' => checkStr($_POST['note']),
		'checker' => $username,
		'checkip' => getip(),
		),"`id`={$id}");
	$Form->oa_exit("预约审批成功","admin.php?j=Note&a=reserveemployer");
}
elseif ($a == 'delreserver') //删除雇主预约
{
	$id = intval($_GET['id']);
	$sql = "select count(*) from ".$db_reserver." where `id`='".$id."'";
	$num = $db->fetch_one($sql);
	
	if (!($num)) $Form->oa_exit("该预约不存在");

	$db->query("delete from ".$db_reserver." where `id`='".$id."'");
	$Form->oa_exit("删除预约成功!","admin.php?j=Note&a=reserveemployer");
}
elseif ($a == 'dealreserveemployer') //批量处理雇主预约
{
	$page = $_POST['page'];
	$reserve = $_POST["reserve"];
	$operation = $_POST['operation'];
	if ($operation == '0')
	{
		$Form->oa_exit("请选择处理的操作", 'admin.php?j=Note&a=reserveemployer&page='.$page);
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
						"note" => "已转发预约，请等候雇员决定",
						"checker" => $username,
						"checkip" => getip(),
						),"`id`='".$rid."'");
				}
				elseif ($operation == '2')
				{
					$db->update($db_reserver,array(
						"status" => 2,
						"note" => "请速电话联系红棉",
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
		$Form->oa_exit("成功处理{$num}个预约","admin.php?j=Note&a=reserveemployer&page={$page}");
	}
	else
		$Form->oa_exit("你还没有选择选项", "admin.php?j=Note&a=reserveemployer&page={$page}");
}
elseif ($a == 'register') //快速登记列表
{
	$sql_num = "select count(*) from ".$db_register." where 1";
	$listNum = $db->fetch_one($sql_num);
	$formtitle = "快速登记 [共".$listNum."条] [{$num_in_page}条/页]";

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
		echo "<td width=\"15%\"><b>姓名</b></td>\n";
		echo "<td width=\"15%\"><b>电话号码</b></td>\n";
		echo "<td width=\"40%\"><b>说明</b></td>\n";
		echo "<td width=\"15%\"><b>时间</b></td>\n";
		echo "<td width=\"15%\"><b>操作</b></td>\n";
		echo "</tr>\n";
		$lstRequest = "select * from ".$db_register." where 1 order by `time` desc limit ".$limitS.",".$num_in_page;
		$vRe = $db->query($lstRequest);
		while($nL = $db->fetch_array($vRe)) 
		{
			$read = ($nL['read'] == 0 ? '<font color="red">查看</font>' : '查看');
			echo "<tr align=\"center\">\n";
			echo "<td>".$nL['name']."</td>\n";
			echo "<td>".$nL['telephone']."</td>\n";
			echo "<td>".str2html($nL['note'])."</td>\n";
			echo "<td>".date('y-m-d H:i',$nL['time'])."</td>\n";
			echo "<td align=\"center\"><a href=\"admin.php?j=Note&a=showregister&id=".$nL['id']."\">".$read."</a> <a href=\"#\" onclick=\"ifDel('admin.php?j=Note&a=delregister&id=".$nL['id']."')\">删除</a></td>\n";
			echo "</tr>\n";
		}
		echo "<tr><td colspan=\"5\" align=\"right\">".$page_char."</td></tr>";
		$Form->tablefooter(array("colspan" => "5"));
	}
	else
	{
		$Form->tableheaderbig(array("title" => $formtitle,));
		$Form->maketd(array("暂时没有快速登记~~"));
		$Form->tablefooter();
	}
	$Form->cpfooter();
}
elseif ($a == 'showregister') //查看快速登记
{
	$id = intval($_GET['id']);
	$db->update($db_register, array(
		'read' => 1,
		), "`id`=".$id);
	$sql_register = "select * from ".$db_register." where `id`='".$id."'";
	$nL = $db->fetch_one_array($sql_register);
	if (empty($nL)) $Form->oa_exit("该快速登记不存在");
	$Form->cpheader("查看快速登记");
	$Form->if_Del();
	$Form->formheader(array(
		'title' => "查看快速登记",
		));
	$Form->makehidden(array(
		'name' => "id",
		'value' => $id
		));
	$Form->maketd(array(
		"<b>姓名</b>",
		$nL['name'],
		));
	$Form->maketd(array(
		"<b>电话</b>",
		$nL['telephone'],
		));
	$Form->maketd(array(
		"<b>说明</b>",
		str2html($nL['note']),
		));
	$Form->formfooter(array(
		"button" => array(
			array('value'=>"删除",'type'=>"button",'extra' => "onclick=\"ifDel('admin.php?j=Note&a=delregister&id={$id}')\""),
			array('value'=>"返回", 'type'=>"button", 'extra' => "onclick=\"goto('admin.php?j=Note&a=register')\""),
		)));
	echo "<script>function goto(url){this.location.replace(url);}</script>";
	$Form->cpfooter();
}
elseif ($a == 'delregister') //删除快速登记
{
	$id = intval($_GET['id']);
	$sql = "select count(*) from ".$db_register." where `id`='".$id."'";
	$num = $db->fetch_one($sql);
	
	if (!($num)) $Form->oa_exit("该快速登记不存在");

	$db->query("delete from ".$db_register." where `id`='".$id."'");
	$Form->oa_exit("删除快速登记成功!","admin.php?j=Note&a=register");
}
elseif ($a == 'note') //留言列表
{
	$status = array('<font color="red">未审</a>', '<font color="green">通过</font>');

	$sql_num = "select count(*) from ".$db_note." where 1";
	$listNum = $db->fetch_one($sql_num);
	$formtitle = "留言 [共".$listNum."条] [{$num_in_page}条/页]";

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
		echo "<td width=\"10%\"><b>状态</b></td>\n";
		echo "<td width=\"8%\"><b>昵称</b></td>\n";
		echo "<td width=\"28%\"><b>内容</b></td>\n";
		echo "<td width=\"6%\"><b>回复</b></td>\n";
		echo "<td width=\"9%\"><b>回复者</b></td>\n";
		echo "<td width=\"14%\"><b>IP</b></td>\n";
		echo "<td width=\"15%\"><b>时间</b></td>\n";
		echo "<td width=\"10%\"><b>操作</b></td>\n";
		echo "</tr>\n";
		$lstRequest = "select * from ".$db_note." where 1 order by `time` desc limit ".$limitS.",".$num_in_page;
		$vRe = $db->query($lstRequest);
		while($nL = $db->fetch_array($vRe)) 
		{
			$read = ($nL['read'] == 0 ? '<font color="red">查看</font>' : '查看');
			$isreply = ($nL['reply'] == "" ? '' : 'Yes');
			echo "<tr align=\"center\">\n";
			echo "<td>".$status[$nL['status']]."</td>\n";
			echo "<td>".$nL['name']."</td>\n";
			echo "<td>".str2html($nL['content'])."</td>\n";
			echo "<td>".$isreply."</td>\n";
			echo "<td>".$nL['checker']."</td>\n";
			echo "<td>".$nL['ip']."</td>\n";
			echo "<td>".date('y-m-d H:i',$nL['time'])."</td>\n";
			echo "<td><a href=\"admin.php?j=Note&a=replynote&id={$nL['id']}\">".$read."</a> <a href=\"#\" onclick=\"ifDel('admin.php?j=Note&a=delnote&id={$nL['id']}')\">删除</a></td>\n";
			echo "</tr>\n";
		}
		echo "<tr><td colspan=\"8\" align=\"right\">".$page_char."</td></tr>";
		$Form->tablefooter(array("colspan" => "8"));
	}
	else
	{
		$Form->tableheaderbig(array("title" => $formtitle,));
		$Form->maketd(array("暂时没有留言~~"));
		$Form->tablefooter();
	}
	$Form->cpfooter();
}
elseif ($a == 'replynote') //回复留言
{
	$id = intval($_GET['id']);
	$db->update($db_note, array(
		'read' => 1,
		), "`id`=".$id);
	$sql_note = "select * from ".$db_note." where `id`='".$id."'";
	$nL = $db->fetch_one_array($sql_note);
	if (empty($nL)) $Form->oa_exit("该留言不存在");
	$Form->cpheader("查看留言");
	$Form->if_Del();
	$Form->formheader(array(
		'title' => "查看留言",
		'method' => "POST",
		'action' => "admin.php?j=Note&a=doreplynote",
		));
	$Form->makehidden(array(
		'name' => "id",
		'value' => $id
		));
	$Form->maketd(array(
		"<b>留言者</b>",
		$nL['name'],
		));
	$Form->maketd(array(
		"<b>Email</b>",
		$nL['email'],
		));
	$Form->maketd(array(
		"<b>电话号码</b>",
		$nL['telephone'],
		));
	$Form->maketd(array(
		"<b>QQ</b>",
		$nL['qq'],
		));
	$Form->maketd(array(
		"<b>留言内容</b>",
		str2html($nL['content']),
		));
	$Form->makeselect(array(
		'text' => "审批",
		'name' => "status",
		'option' => array("待审", "通过"),
		'selected' => $nL['status'],
		));
	$Form->maketextarea(array(
		'text' => "回复",
		'name' => "reply",
		'value' => html2str($nL['reply'])
		), 0);
	$Form->formfooter(array(
		"button" => array(
			array('value'=>"确定"),
			array('value'=>"删除",'type'=>"button",'extra' => "onclick=\"ifDel('admin.php?j=Note&a=delnote&id={$id}')\""),
			array('value'=>"返回", 'type'=>"button", 'extra' => "onclick=\"goto('admin.php?j=Note&a=note')\""),
		)));
	echo "<script>function goto(url){this.location.replace(url);}</script>";
	$Form->cpfooter();
}
elseif ($a == 'doreplynote') //执行回复留言
{
	if (!isset($_POST['id'])) $Form->oa_exit("参数错误");
	$id = intval($_POST['id']);

	$sql_note = "select count(*) from ".$db_note." where `id`='".$id."'";
	if ($db->fetch_one($sql_note)==0) $Form->oa_exit("留言不存在");

	$db->update($db_note,array(
		'reply' => $_POST['reply'],
		'status' => $_POST['status'],
		'checker' => $username,
		'checkip' => getip(),
		),"`id`={$id}");
	$Form->oa_exit("留言审批成功","admin.php?j=Note&a=note");
}
elseif ($a == 'delnote') //删除留言
{
	$id = intval($_GET['id']);
	$sql = "select count(*) from ".$db_note." where `id`='".$id."'";
	$num = $db->fetch_one($sql);
	
	if (!($num)) $Form->oa_exit("该留言不存在");

	$db->query("delete from ".$db_note." where `id`='".$id."'");
	$Form->oa_exit("删除留言成功!","admin.php?j=Note&a=note");
}
else
{
	$Form->oa_exit("功能不存在","index.php?a=main");
}
?>

