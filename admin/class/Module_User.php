<?php
/*
新闻功能模块
========
需要的类：config.php forms.php class_DataBase.php SmartTemplate class_User.php
========
主要功能：（$a == ）
--------------------
employee 雇员列表	showemployee 查看雇员	delemployee 删除雇员	dealemployee 批量处理雇员
docheckemployee 执行审批雇员	doqualifyemployee 执行认证雇员	dorecommendemployee 执行推荐雇员	donoteemployee 执行添加雇员备注	dohireemployee 执行聘请雇员
qualifyemployee 认证雇员	checkemployee 审批雇员	recommendemployee 推荐雇员	hireemployee 聘请雇员
employer 雇主列表	showemployer 查看雇主	delemployer 删除雇主	dealemployer 批量处理雇主
docheckemployer 执行审批雇主	dotopemployer 执行置顶雇主	donoteemployer 执行添加雇主备注
checkemployer 审批雇主	topemployer 置顶雇主
search 搜索	dosearch 执行搜索

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
$db_employee = "`".$mysql_prefix."employee`"; //雇员数据表
$db_employer = "`".$mysql_prefix."employer`"; //雇主数据表
$db_area = "`".$mysql_prefix."area`"; //地区数据表
$db_degree = "`".$mysql_prefix."degree`"; //学历数据表
$db_contract = "`".$mysql_prefix."contract`"; //合约数据表
$num_in_page = 20;  //每页显示数目

$allow = array();

switch($usr->rights['News'])
{
case 'S':  //超级管理员
	$allow = array(
		'employee' => 2, 'showemployee' => 2, 'delemployee' => 2, 'dealemployee' => 2,
		'docheckemployee' => 2, 'doqualifyemployee' => 2, 'dorecommendemployee' => 2, 'donoteemployee' => 2, 'dohireemployee' => 2,
		'qualifyemployee' => 2, 'checkemployee' => 2, 'recommendemployee' => 2, 'hireemployee' => 2,
		'employer' => 2, 'showemployer' => 2, 'delemployer' => 2, 'dealemployer' => 2,
		'docheckemployer' => 2, 'dotopemployer' => 2, 'donoteemployer' => 2,
		'checkemployer' => 2, 'topemployer' => 2,
		'search' => 2, 'dosearch' => 2,
		);
	break;
case 'A':  //一级管理员
	$allow = array(
		'employee' => 2, 'showemployee' => 2, 'delemployee' => 0, 'dealemployee' => 2,
		'docheckemployee' => 2, 'doqualifyemployee' => 2, 'dorecommendemployee' => 2, 'donoteemployee' => 2, 'dohireemployee' => 2,
		'qualifyemployee' => 2, 'checkemployee' => 2, 'recommendemployee' => 2, 'hireemployee' => 2,
		'employer' => 2, 'showemployer' => 2, 'delemployer' => 0, 'dealemployer' => 2,
		'docheckemployer' => 2, 'dotopemployer' => 2, 'donoteemployer' => 2,
		'checkemployer' => 2, 'topemployer' => 2,
		'search' => 2, 'dosearch' => 2,
		);
	break;
case 'M':  //二级管理员
	$allow = array(
		'employee' => 2, 'showemployee' => 1, 'delemployee' => 0, 'dealemployee' => 0,
		'docheckemployee' => 0, 'doqualifyemployee' => 0, 'dorecommendemployee' => 0, 'donoteemployee' => 0, 'dohireemployee' => 0,
		'qualifyemployee' => 0, 'checkemployee' => 0, 'recommendemployee' => 0, 'hireemployee' => 0,
		'employer' => 2, 'showemployer' => 1, 'delemployer' => 0, 'dealemployer' => 0,
		'docheckemployer' => 0, 'dotopemployer' => 0, 'donoteemployer' => 0,
		'checkemployer' => 0, 'topemployer' => 0,
		'search' => 0, 'dosearch' => 0,
		);
	break;
default:  //无权限
	$allow = array(
		'employee' => 0, 'checkemployee' => 0, 'delemployee' => 0, 'dealemployee' => 0,
		'docheckemployee' => 0, 'doqualifyemployee' => 0, 'dorecommendemployee' => 0, 'donoteemployee' => 0, 'dohireemployee' => 0,
		'qualifyemployee' => 0, 'checkemployee' => 0, 'recommendemployee' => 0, 'hireemployee' => 0,
		'employer' => 0, 'showemployer' => 0, 'delemployer' => 0, 'dealemployer' => 0,
		'docheckemployer' => 0, 'dotopemployer' => 0, 'donoteemployer' => 0,
		'checkemployer' => 0, 'topemployer' => 0,
		'search' => 0, 'dosearch' => 0,
		);
	break;
}
if (!($allow[$a] > 0)) $Form->oa_exit("你没有权限执行该操作~~");

if ($a == 'employee') //雇员列表
{
	$select = array('未', '已');
	$sql_num = "select count(*) from ".$db_employee." where 1";
	$listNum = $db->fetch_one($sql_num);
	$formtitle = "雇员 [共".$listNum."个] [{$num_in_page}个/页]";

	$cpage = isset($_GET['page']) ? intval($_GET['page']) : 1;
	$page_char = page($listNum,$num_in_page,$cpage,"admin.php?j=User&a=employee");
	$limitS = $cpage*$num_in_page-$num_in_page;

	$Form->cpheader();
	if($listNum > 0)
	{
		$Form->formheader(array("action" => "admin.php?j=User&a=dealemployee",
			"title" => $formtitle,
			"colspan" => "12",
			"name" => "form",
		));
		$Form->if_Del();
		$Form->js_checkall();
		echo "<tr align=\"center\">\n";
		echo "<td width=\"5%\">\n";
		echo "<input type=\"checkbox\" name=\"chkall\" value=\"on\" class=\"radio\" onclick=\"CheckAll(this.form)\"></td>\n";
		echo "<td width=\"8%\"><b>编号</b></td>\n";
		echo "<td width=\"12%\"><b>姓名</b></td>\n";
		echo "<td width=\"12%\"><b>电话</b></td>\n";
		echo "<td width=\"8%\"><b>地区</b></td>\n";
		echo "<td width=\"6%\"><b>备注</b></td>\n";
		echo "<td width=\"12%\"><b>注册日期</b></td>\n";
		echo "<td width=\"9%\"><b>操作</b></td>\n";
		echo "<td width=\"7%\"><b>聘请</b></td>\n";
		echo "<td width=\"7%\"><b>认证</b></td>\n";
		echo "<td width=\"7%\"><b>审批</b></td>\n";
		echo "<td width=\"7%\"><b>推荐</b></td>\n";
		echo "</tr>\n";
		$lstRequest = "select * from ".$db_employee." where 1 order by `reg_time` desc limit ".$limitS.",".$num_in_page;
		$vRe = $db->query($lstRequest);
		while($nL = $db->fetch_array($vRe)) 
		{
			$tid = $nL['id'];
			$area_sql = "select `name` from ".$db_area." where `id`=".$nL['area'];
			$area = $db->fetch_one($area_sql);
			$tel = ($nL['mobile'] == "" ? $nL['telephone'] : $nL['mobile']);
			$name = ($nL['occupied'] == 1 ? "<font color=\"red\">".$nL['name']."</font>" : $nL['name']);
			$note = (checkStr($nL['note']) ? "Yes" : "");
			echo "<tr align=\"center\">\n";
			echo "<td><input type=\"checkbox\" name=\"employee[{$tid}]\" value=\"1\" class=\"radio\"></td>\n";
			echo "<td>".$nL['id']."</td>\n";
			echo "<td>".$name."</td>\n";
			echo "<td>".$tel."</td>\n";
			echo "<td>".$area."</td>\n";
			echo "<td>".$note."</td>\n";
			echo "<td>".date('y-m-d',$nL['reg_time'])."</td>\n";
			if ($allow[$a] == 2)
				echo "<td align=\"center\"><a href=\"admin.php?j=User&a=showemployee&id=".$nL['id']."\">查看</a> <a href=\"#\" onclick=\"ifDel('admin.php?j=User&a=delemployee&id=".$nL['id']."')\">删除</a></td>\n";
			elseif ($allow[$a] == 1)
				echo "<td align=\"center\"><a href=\"admin.php?j=User&a=showemployee&id=".$nL['id']."\">查看</a></td>\n";
			echo "<td><a href=\"admin.php?j=User&a=hireemployee&id={$nL[id]}&page={$cpage}\">".$select[$nL['company']]."聘请</a></td>\n";
			echo "<td><a href=\"admin.php?j=User&a=qualifyemployee&id={$nL[id]}&page={$cpage}\">".$select[$nL['qualified']]."认证</a></td>\n";
			echo "<td><a href=\"admin.php?j=User&a=checkemployee&id={$nL[id]}&page={$cpage}\">".$select[$nL['checked']]."审批</a></td>\n";
			echo "<td><a href=\"admin.php?j=User&a=recommendemployee&id={$nL[id]}&page={$cpage}\">".$select[$nL['recommended']]."推荐</a></td>\n";
			echo "</tr>\n";
		}
		echo "<tr><td colspan=\"12\" align=\"right\">".$page_char."</td></tr>";
		echo "<tr><td colspan=\"12\" align=\"center\"><select name=\"operation\"><option>请选择</option><option value=1>聘请</option><option value=2>不聘请</option><option value=3>认证</option><option value=4>不认证</option><option value=5>审批</option><option value=6>不审批</option><option value=7>推荐</option><option value=8>不推荐</option></select>&nbsp;&nbsp;&nbsp;&nbsp;<input class=\"button\" accesskey=\"\" type=\"submit\" name=\"\" value=\"处理\" />";
		$Form->makehidden(array(
			'name' => "page",
			'value' => $cpage,
			));
		echo "\n</td></tr></form></table>\n";
	}
	else
	{
		$Form->tableheaderbig(array("title" => $formtitle,));
		$Form->maketd(array("暂时没有雇员~~"));
		$Form->tablefooter();
	}
	$Form->cpfooter();
}
elseif ($a == 'showemployee') //查看雇员
{
	$id = intval($_GET['id']);
	$sql_employee = "select * from ".$db_employee." where `id`='".$id."'";
	$nL = $db->fetch_one_array($sql_employee);
	if (empty($nL)) $Form->oa_exit("该雇员不存在");

	$imgPath = "../attachment/user/";

	$area_sql = "select `name` from ".$db_area." where `id`=".$nL['area'];
	$area = $db->fetch_one($area_sql);
	$degree_sql = "select `name` from ".$db_degree." where `id`=".$nL['degree'];
	$degree = $db->fetch_one($degree_sql);
	$hired = ($nL['company'] == 1 ? "<font color=red>已聘请</font>" : "未聘请");
	$checked = ($nL['checked'] == 1 ? "<font color=red>已通过</font>" : "未通过");
	$qualified = ($nL['qualified'] == 1 ? "<font color=red>已认证</font>" : "未认证");
	$recommended = ($nL['recommended'] == 1 ? "<font color=red>已推荐</font>" : "未推荐");
	
	$ori_width = 160;
	$ori_height = 120;
	if ($nL['picture'] == "")
	{
		if ($nL['sex'] == '女')
			$path = $imgPath."lady.gif";
		else
			$path = $imgPath."man.gif";
		$width = $ori_width;;
		$height = $ori_height;
	}
	else
	{
		$path = $imgPath.$nL['picture'];
		$info = getimagesize($path);
		$picW = $info[0];
		$picH = $info[1];
		if ($picW / $picH < $ori_width / $ori_height)
		{
			$height = $ori_height;
			$width = $picW / $picH * $height;
		}
		else
		{
			$width = $ori_width;
			$height = $picH / $picW * $width;
		}
	}
	$picture = "<img src=\"".$path."\" width=\"".$width."\" height=\"".$height."\" />";

	if ($allow[$a] == 2)
	{
		$super = 1;
	}
	else
	{
		$super = 0;
	}

	$Tmp = template("employee");
	$Tmp->assign(array(
		'id' => $nL['id'],
		'username' => $nL['username'],
		'email' => $nL['email'],
		'name' => $nL['name'],
		'sex' => $nL['sex'],
		'age' => date("Y", time()) - $nL['birthyear'],
		'area' => $area,
		'nation' => $nL['nation'],
		'degree' => $degree,
		'visited_times' => $nL['visited_times'],
		'last_time' => date('Y-m-d', $nL['last_time']),
		'last_ip' => $nL['last_ip'],
		'identifyid' => $nL['identifyid'],
		'address' => $nL['address'],
		'telephone' => $nL['telephone'],
		'mobile' => $nL['mobile'],
		'qq' => $nL['qq'],
		'service' => trim(str_replace(',', ' ', $nL['service'])),
		'salary' => $nL['salary'],
		'experience' => $nL['experience'],
		'language' => trim(str_replace(',', ' ', $nL['language'])),
		'marriage' => $nL['marriage'],
		'hometown' => $nL['hometown'],
		'hired' => $hired,
		'checked' => $checked,
		'qualified' => $qualified,
		'recommended' => $recommended,
		'service_area' => trim(str_replace(',', ' ', $nL['service_area'])),
		'pic' => $picture,
		'note' => $nL['note'],
		'SUPER' => $super,
		));
	$sql_contract = "select * from ".$db_contract." where `employeeid`=".$nL['id'];
	$query_contract = $db->query($sql_contract);
	while ($contract = $db->fetch_array($query_contract))
	{
		$employee = $nL['name'];
		$employer_sql = "select `name` from ".$db_employer." where `id`=".$contract['employerid'];
		$employer_name = $db->fetch_one($employer_sql);
		$employer = "<a href=\"admin.php?j=User&a=showemployer&id=".$contract['employerid']."\">".$employer_name."</a>";
		$Tmp->append('CONTRACT_LIST', array(
			'employee' => $employee,
			'employer' => $employer,
			'agent' => $contract['agent'],
			'salary' => $contract['salary'],
			'note' => $contract['note'],
			'start_time' => date("Y-m-d", $contract['starttime']),
			'end_time' => date("Y-m-d", $contract['endtime']),
			));
	}
	$Tmp->output();
}
elseif ($a == 'delemployee') //删除雇员
{
	$id = intval($_GET['id']);
	$sql = "select count(*) from ".$db_employee." where `id`='".$id."'";
	$num = $db->fetch_one($sql);
	
	if (!($num)) $Form->oa_exit("该雇员不存在");

	$db->query("delete from ".$db_employee." where `id`='".$id."'");
	$Form->oa_exit("删除雇员成功!","admin.php?j=User&a=employee");
}
elseif ($a == 'dealemployee') //批量处理雇员
{
	$page = $_POST['page'];
	$employee = $_POST["employee"];
	$operation = $_POST['operation'];
	if ($operation == 0)
	{
		$Form->oa_exit("请选择处理的操作", 'admin.php?j=User&a=employee&page='.$page);
	}
	$op = array('', 'company', 'company', 'qualified', 'qualified', 'checked', 'checked', 'recommended', 'recommended');
	$nop = array(0, 1, 0, 1, 0, 1, 0, 1, 0, 1, 0);
	if (is_array($employee))
	{
		$num = 0;
		foreach ($employee as $k => $v)
		{
			if ($v)
			{
				$tid = $k;
				$db->update($db_employee,array(
					$op[$operation] => $nop[$operation],
					"checker" => $username,
					"checkip" => getip(),
					),"`id`=".$tid);
				$num++;
				if ($operation == 7)
				{
					$db->update($db_employee, array(
						'rec_time' => time(),
						),"`id`=".$tid);
				}
				if ($operation == 8)
				{
					$db->update($db_employee, array(
						'rec_time' => 0,
						),"`id`=".$tid);
				}
			}
		}
		$Form->oa_exit("成功处理{$num}个雇员","admin.php?j=User&a=employee&page={$page}");
	}
	else
		$Form->oa_exit("你还没有选择雇员", "admin.php?j=User&a=employee&page={$page}");
}
elseif ($a == 'docheckemployee') //执行审批雇员
{
	$check = $_POST['pass'];
	$id = $_POST['id'];
	if ($check == 0)
	{
		$db->update($db_employee,array(
			'checked' => 0,
			'reject_reason' => $_POST['reject_reason'],
			"checker" => $username,
			"checkip" => getip(),
			),"`id`='".$id."'");
	}
	else
	{
		$db->update($db_employee,array(
			'checked' => 1,
			'reject_reason' => "",
			"checker" => $username,
			"checkip" => getip(),
			),"`id`='".$id."'");
	}
	$Form->oa_exit("成功审批雇员", "admin.php?j=User&a=showemployee&id=".$id);
}
elseif ($a == 'doqualifyemployee') //执行认证雇员
{
	$qualify = $_POST['pass'];
	$id = $_POST['id'];
	$db->update($db_employee,array(
		'qualified' => $qualify,
		"checker" => $username,
		"checkip" => getip(),
		),"`id`='".$id."'");
	$Form->oa_exit("成功认证雇员", "admin.php?j=User&a=showemployee&id=".$id);
}
elseif ($a == 'dorecommendemployee') //执行推荐雇员
{
	$recommend = $_POST['pass'];
	if ($recommend == 0)
		$rec_time = 0;
	else
		$rec_time = time();
	$id = $_POST['id'];
	$db->update($db_employee,array(
		'recommended' => $recommend,
		'rec_time' => time(),
		"checker" => $username,
		"checkip" => getip(),
		),"`id`='".$id."'");
	$Form->oa_exit("成功推荐雇员", "admin.php?j=User&a=showemployee&id=".$id);
}
elseif ($a == 'dohireemployee') //执行聘请雇员
{
	$hired = $_POST['pass'];
	$id = $_POST['id'];
	$db->update($db_employee,array(
		'company' => $hired,
		"checker" => $username,
		"checkip" => getip(),
		),"`id`='".$id."'");
	$Form->oa_exit("成功聘请雇员", "admin.php?j=User&a=showemployee&id=".$id);
}
elseif ($a == 'donoteemployee') //执行提交雇员备注
{
	$note = checkStr($_POST['note']);
	$id = intval($_POST['id']);
	$db->update($db_employee, array(
		'note' => $note,
		), "`id`={$id}");
	$Form->oa_exit("成功提交雇员备注", "admin.php?j=User&a=showemployee&id=".$id);
}
elseif ($a == 'qualifyemployee') //认证雇员
{
	$id = $_GET['id'];
	$page = $_GET['page'];
	$sql = "select `qualified` from ".$db_employee." where `id`=".$id;
	$qualified = $db->fetch_one($sql);
	if ($qualified == 0)
		$result = 1;
	else
		$result = 0;
	$db->update($db_employee,array(
		'qualified' => $result,
		"checker" => $username,
		"checkip" => getip(),
		),"`id`='".$id."'");
	$Form->oa_exit("成功处理雇员认证", "admin.php?j=User&a=employee&page=".$page);
}
elseif ($a == 'checkemployee') //审批雇员
{
	$id = $_GET['id'];
	$page = $_GET['page'];
	$sql = "select `checked` from ".$db_employee." where `id`=".$id;
	$checked = $db->fetch_one($sql);
	if ($checked == 0)
		$result = 1;
	else
		$result = 0;
	$db->update($db_employee,array(
		'checked' => $result,
		"checker" => $username,
		"checkip" => getip(),
		),"`id`='".$id."'");
	$Form->oa_exit("成功处理雇员审批", "admin.php?j=User&a=employee&page=".$page);
}
elseif ($a == 'recommendemployee') //推荐雇员
{
	$id = $_GET['id'];
	$page = $_GET['page'];
	$sql = "select `recommended` from ".$db_employee." where `id`=".$id;
	$recommended = $db->fetch_one($sql);
	if ($recommended == 0)
	{
		$result = 1;
		$rec_time = time();
	}
	else
	{
		$result = 0;
		$rec_time = 0;
	}
	$db->update($db_employee,array(
		'recommended' => $result,
		'rec_time' => $rec_time,
		"checker" => $username,
		"checkip" => getip(),
		),"`id`='".$id."'");
	$Form->oa_exit("成功处理雇员推荐", "admin.php?j=User&a=employee&page=".$page);
}
elseif ($a == 'hireemployee') //聘请教员
{
	$id = $_GET['id'];
	$page = $_GET['page'];
	$sql = "select `company` from ".$db_employee." where `id`=".$id;
	$hired = $db->fetch_one($sql);
	if ($hired == 0)
		$result = 1;
	else
		$result = 0;
	$db->update($db_employee,array(
		'company' => $result,
		"checker" => $username,
		"checkip" => getip(),
		),"`id`='".$id."'");
	$Form->oa_exit("成功处理雇员聘请", "admin.php?j=User&a=employee&page=".$page);
}
elseif ($a == 'employer') //雇主列表
{
	$select = array('未', '已');
	$sql_num = "select count(*) from ".$db_employer." where 1";
	$listNum = $db->fetch_one($sql_num);
	$formtitle = "雇主 [共".$listNum."个] [{$num_in_page}个/页]";

	$cpage = isset($_GET['page']) ? intval($_GET['page']) : 1;
	$page_char = page($listNum,$num_in_page,$cpage,"admin.php?j=User&a=employer");
	$limitS = $cpage*$num_in_page-$num_in_page;

	$Form->cpheader();
	if($listNum > 0)
	{
		$Form->formheader(array("action" => "admin.php?j=User&a=dealemployer",
			"title" => $formtitle,
			"colspan" => "11",
			"name" => "form",
		));
		$Form->js_checkall();
		$Form->if_Del();
		echo "<tr align=\"center\">\n";
		echo "<td width=\"5%\">\n";
		echo "<input type=\"checkbox\" name=\"chkall\" value=\"on\" class=\"radio\" onclick=\"CheckAll(this.form)\"></td>\n";
		echo "<td width=\"10%\"><b>编号</b></td>\n";
		echo "<td width=\"12%\"><b>姓名</b></td>\n";
		echo "<td width=\"18%\"><b>电话</b></td>\n";
		echo "<td width=\"10%\"><b>地区</b></td>\n";
		echo "<td width=\"6%\"><b>备注</b></td>\n";
		echo "<td width=\"10%\"><b>注册日期</b></td>\n";
		echo "<td width=\"10%\"><b>操作</b></td>\n";
		echo "<td width=\"7%\"><b>审批</b></td>\n";
		echo "<td width=\"7%\"><b>置顶</b></td>\n";
		echo "</tr>\n";
		$lstRequest = "select * from ".$db_employer." where 1 order by `reg_time` desc limit ".$limitS.",".$num_in_page;
		$vRe = $db->query($lstRequest);
		while($nL = $db->fetch_array($vRe)) 
		{
			$sid = $nL['id'];
			$area_sql = "select `name` from ".$db_area." where `id`=".$nL['area'];
			$area = $db->fetch_one($area_sql);
			$tel = ($nL['mobile'] == "" ? $nL['telephone'] : $nL['mobile']);
			$name = ($nL['occupied'] == 1 ? "<font color=\"red\">".$nL['name']."</font>" : $nL['name']);
			$note = (checkStr($nL['note']) ? "Yes" : "");
			echo "<tr align=\"center\">\n";
			echo "<td><input type=\"checkbox\" name=\"employer[{$sid}]\" value=\"1\" class=\"radio\"></td>\n";
			echo "<td>".$nL['id']."</td>\n";
			echo "<td>".$name."</td>\n";
			echo "<td>".$tel."</td>\n";
			echo "<td>".$area."</td>\n";
			echo "<td>".$note."</td>\n";
			echo "<td>".date('y-m-d',$nL['reg_time'])."</td>\n";
			if ($allow[$a] == 2)
				echo "<td align=\"center\"><a href=\"admin.php?j=User&a=showemployer&id=".$nL['id']."\">查看</a> <a href=\"#\" onclick=\"ifDel('admin.php?j=User&a=delemployer&id=".$nL['id']."')\">删除</a></td>\n";
			elseif ($allow[$a] == 1)
				echo "<td align=\"center\"><a href=\"admin.php?j=User&a=showemployer&id=".$nL['id']."\">查看</a></td>\n";
			echo "<td><a href=\"admin.php?j=User&a=checkemployer&id={$nL[id]}&page={$cpage}\">".$select[$nL['checked']]."审批</a></td>\n";
			echo "<td><a href=\"admin.php?j=User&a=topemployer&id={$nL[id]}&page={$cpage}\">".$select[$nL['top']]."置顶</a></td>\n";
			echo "</tr>\n";
		}
		echo "<tr><td colspan=\"11\" align=\"right\">".$page_char."</td></tr>";
		echo "<tr><td colspan=\"11\" align=\"center\"><select name=\"operation\"><option>请选择</option><option value=1>审批</option><option value=2>不审批</option><option value=3>置顶</option><option value=4>不置顶</option></select>&nbsp;&nbsp;&nbsp;&nbsp;<input class=\"button\" accesskey=\"\" type=\"submit\" name=\"\" value=\"处理\" />";
		$Form->makehidden(array(
			'name' => "page",
			'value' => $cpage,
			));
		echo "\n</td></tr></form></table>\n";
	}
	else
	{
		$Form->tableheaderbig(array("title" => $formtitle,));
		$Form->maketd(array("暂时没有雇主~~"));
		$Form->tablefooter();
	}
	$Form->cpfooter();
}
elseif ($a == 'showemployer') //查看雇主
{
	$id = intval($_GET['id']);
	$sql_employer = "select * from ".$db_employer." where `id`='".$id."'";
	$nL = $db->fetch_one_array($sql_employer);
	if (empty($nL)) $Form->oa_exit("该雇主不存在");

	$area_sql = "select `name` from ".$db_area." where `id`=".$nL['area'];
	$area = $db->fetch_one($area_sql);

	$degree_sql = "select `name` from ".$db_degree." where `id`=".$nL['ideal_degree'];
	$ideal_degree = $db->fetch_one($degree_sql);

	$home = ($nL['home'] == 1 ? "<font color=red>住家</font>" : "不住家");
	$checked = ($nL['checked'] == 1 ? "<font color=red>已通过</font>" : "未通过");
	$top = ($nL['top'] == 1 ? "<font color=red>已置顶</font>" : "未置顶");

	$Tmp = template("employer");
	$Tmp->assign(array(
		'id' => $nL['id'],
		'username' => $nL['username'],
		'email' => $nL['email'],
		'name' => $nL['name'],
		'area' => $area,
		'last_time' => date('Y-m-d', $nL['last_time']),
		'last_ip' => $nL['last_ip'],
		'address' => $nL['address'],
		'telephone' => $nL['telephone'],
		'mobile' => $nL['mobile'],
		'qq' => $nL['qq'],
		'service' => trim(str_replace(',', ' ', $nL['service'])),
		'worktime' => $nL['worktime'],
		'home' => $home,
		'salary' => $nL['salary'],
		'visited_times' => $nL['visited_times'],
		'checked' => $checked,
		'top' => $top,
		'ideal_sex' => $nL['ideal_sex'],
		'ideal_age' => $nL['ideal_age'],
		'ideal_degree' => $ideal_degree,
		'note' => $nL['note'],
		));
	$sql_contract = "select * from ".$db_contract." where `employerid`=".$nL['id'];
	$query_contract = $db->query($sql_contract);
	while ($contract = $db->fetch_array($query_contract))
	{
		$employer = $nL['name'];
		$employee_sql = "select `name` from ".$db_employee." where `id`=".$contract['employeeid'];
		$employee_name = $db->fetch_one($employee_sql);
		$employee = "<a href=\"admin.php?j=User&a=showemployee&id=".$contract['employeeid']."\">".$employee_name."</a>";
		$Tmp->append('CONTRACT_LIST', array(
			'employee' => $employee,
			'employer' => $employer,
			'agent' => $contract['agent'],
			'salary' => $contract['salary'],
			'note' => $contract['note'],
			'start_time' => date("Y-m-d", $contract['starttime']),
			'end_time' => date("Y-m-d", $contract['endtime']),
			));
	}
	$Tmp->output();
}
elseif ($a == 'delemployer') //删除雇主
{
	$id = intval($_GET['id']);
	$sql = "select count(*) from ".$db_employer." where `id`='".$id."'";
	$num = $db->fetch_one($sql);

	if (!($num)) $Form->oa_exit("该雇主不存在");

	$db->query("delete from ".$db_employer." where `id`='".$id."'");
	$Form->oa_exit("删除雇主成功!","admin.php?j=User&a=employer");
}
elseif ($a == 'dealemployer') //批量处理雇主
{
	$page = $_POST['page'];
	$employer = $_POST["employer"];
	$operation = $_POST['operation'];
	if ($operation == 0)
	{
		$Form->oa_exit("请选择处理的操作", 'admin.php?j=User&a=employer&page='.$page);
	}
	if (is_array($employer))
	{
		$num = 0;
		foreach ($employer as $k => $v)
		{
			if ($v)
			{
				$tid = $k;
				if ($operation == 1)
					$db->update($db_employer,array(
						'checked' => 1,
						"checker" => $username,
						"checkip" => getip(),
						),"`id`='".$tid."'");
				elseif ($operation == 2)
					$db->update($db_employer,array(
						'checked' => 0,
						"checker" => $username,
						"checkip" => getip(),
						),"`id`='".$tid."'");
				elseif ($operation == 3)
					$db->update($db_employer,array(
						'top' => 1,
						'top_time' => time(),
						"checker" => $username,
						"checkip" => getip(),
						),"`id`='".$tid."'");
				elseif ($operation == 4)
					$db->update($db_employer,array(
						'top' => 0,
						'top_time' => 0,
						"checker" => $username,
						"checkip" => getip(),
						),"`id`='".$tid."'");
				else
					$Form->oa_exit("参数错误", "admin.php?j=User&a=employer&page={$page}");
				$num++;
			}
		}
		$Form->oa_exit("成功处理{$num}个雇主","admin.php?j=User&a=employer&page={$page}");
	}
	else
		$Form->oa_exit("你还没有选择雇主", "admin.php?j=User&a=employer&page={$page}");
}
elseif ($a == 'docheckemployer') //执行审批雇主
{
	$check = $_POST['pass'];
	$id = $_POST['id'];
	if ($check == 0)
	{
		$db->update($db_employer,array(
			'checked' => 0,
			'reject_reason' => $_POST['reject_reason'],
			"checker" => $username,
			"checkip" => getip(),
			),"`id`='".$id."'");
	}
	else
	{
		$db->update($db_employer,array(
			'checked' => 1,
			'reject_reason' => "",
			"checker" => $username,
			"checkip" => getip(),
			),"`id`='".$id."'");
	}
	$Form->oa_exit("成功审批雇主", "admin.php?j=User&a=showemployer&id=".$id);
}
elseif ($a == 'dotopemployer') //执行置顶雇主
{
	$top = $_POST['pass'];
	if ($top == 0)
		$top_time = 0;
	else
		$top_time = time();
	$id = $_POST['id'];
	$db->update($db_employer,array(
		'top' => $top,
		'top_time' => $top_time,
		"checker" => $username,
		"checkip" => getip(),
		),"`id`='".$id."'");
	$Form->oa_exit("成功置顶雇员", "admin.php?j=User&a=showemployer&id=".$id);
}
elseif ($a == 'donoteemployer') //执行提交雇主备注
{
	$note = checkStr($_POST['note']);
	$id = intval($_POST['id']);
	$db->update($db_employer, array(
		'note' => $note,
		), "`id`={$id}");
	$Form->oa_exit("成功提交雇主备注", "admin.php?j=User&a=showemployer&id=".$id);
}
elseif ($a == 'checkemployer') //审批雇主
{
	$id = $_GET['id'];
	$page = $_GET['page'];
	$sql = "select `checked` from ".$db_employer." where `id`=".$id;
	$checked = $db->fetch_one($sql);
	if ($checked == 0)
		$result = 1;
	else
		$result = 0;
	$db->update($db_employer,array(
		'checked' => $result,
		"checker" => $username,
		"checkip" => getip(),
		),"`id`='".$id."'");
	$Form->oa_exit("成功处理雇主审批", "admin.php?j=User&a=employer&page=".$page);
}
elseif ($a == 'topemployer') //置顶雇主
{
	$id = $_GET['id'];
	$page = $_GET['page'];
	$sql = "select `top` from ".$db_employer." where `id`=".$id;
	$top = $db->fetch_one($sql);
	if ($top == 0)
		$result = 1;
	else
		$result = 0;
	$db->update($db_employer,array(
		'top' => $result,
		'top_time' => time(),
		"checker" => $username,
		"checkip" => getip(),
		),"`id`='".$id."'");
	$Form->oa_exit("成功处理雇主置顶", "admin.php?j=User&a=employer&page=".$page);
}
elseif ($a == 'search') //搜索
{
	$Form->cpheader("搜索");
	$Form->formheader(array(
		'title' => "搜索",
		'method' => "POST",
		'action' => "admin.php?j=User&a=dosearch",
		));
	$Form->makeselect(array(
		'option' => array('请选择', '雇员', '雇主'),
		'text' => "雇员或雇主",
		'name' => "type",
		'selected' => 0,
		));
	$Form->makeinput(array(
		'text' => "编号",
		'name' => "id",
		));
	$Form->makeinput(array(
		'text' => "用户名",
		'name' => "username",
		));
	$Form->makeinput(array(
		'text' => "姓名",
		'name' => "name",
		));
	$Form->makeinput(array(
		'text' => "电话",
		'name' => "telephone",
		));
	$Form->makeinput(array(
		'text' => "手机",
		'name' => "mobile",
		));
	$Form->formfooter(array(
		"button" => array(
			array('value'=>"搜索"),
		)));
	$Form->cpfooter();
}
elseif ($a == 'dosearch') //执行搜索
{
	$type = $_REQUEST['type'];
	if ($type == 0)
	{
		$Form->oa_exit("请选择搜索雇员还是雇主");
	}
	$id = intval($_REQUEST['id']);
	$username = checkStr($_REQUEST['username']);
	$name = checkStr($_REQUEST['name']);
	$telephoen = checkStr($_REQUEST['telephone']);
	$mobile = checkStr($_REQUEST['mobile']);
	if ($id && $username)
	{
		$Form->oa_exit("不能同时对编号和用户名进行搜索");
	}
	if (!$id && !$username && !$name && !$telephone && !$mobile)
	{
		$Form->oa_exit("请填写至少一个搜索选项");
	}
	$info = array(
		'type' => $type,
		'id' => $id,
		'username' => $username,
		'name' => $name,
		'telephone' => $telephone,
		'mobile' => $mobile,
		);
	$condition = makecondition($info);
	$addlink = makeaddlink($info);
	if ($type == 1)
	{
		$select = array('未', '已');
		$sql_num = "select count(*) from ".$db_employee." where {$condition}";
		$listNum = $db->fetch_one($sql_num);
		$formtitle = "雇员 [共".$listNum."个] [{$num_in_page}个/页]";

		$cpage = isset($_GET['page']) ? intval($_GET['page']) : 1;
		$page_char = page($listNum,$num_in_page,$cpage,"admin.php?j=User&a=employee{$addlink}");
		$limitS = $cpage*$num_in_page-$num_in_page;

		$Form->cpheader();
		if($listNum > 0)
		{
			$Form->formheader(array("action" => "admin.php?j=User&a=dealemployee",
				"title" => $formtitle,
				"colspan" => "12",
				"name" => "form",
			));
			$Form->if_Del();
			$Form->js_checkall();
			echo "<tr align=\"center\">\n";
			echo "<td width=\"5%\">\n";
			echo "<input type=\"checkbox\" name=\"chkall\" value=\"on\" class=\"radio\" onclick=\"CheckAll(this.form)\"></td>\n";
			echo "<td width=\"8%\"><b>编号</b></td>\n";
			echo "<td width=\"12%\"><b>姓名</b></td>\n";
			echo "<td width=\"12%\"><b>电话</b></td>\n";
			echo "<td width=\"8%\"><b>地区</b></td>\n";
			echo "<td width=\"6%\"><b>备注</b></td>\n";
			echo "<td width=\"12%\"><b>注册日期</b></td>\n";
			echo "<td width=\"9%\"><b>操作</b></td>\n";
			echo "<td width=\"7%\"><b>聘请</b></td>\n";
			echo "<td width=\"7%\"><b>认证</b></td>\n";
			echo "<td width=\"7%\"><b>审批</b></td>\n";
			echo "<td width=\"7%\"><b>推荐</b></td>\n";
			echo "</tr>\n";
			$lstRequest = "select * from ".$db_employee." where {$condition} order by `reg_time` desc limit ".$limitS.",".$num_in_page;
			$vRe = $db->query($lstRequest);
			while($nL = $db->fetch_array($vRe)) 
			{
				$tid = $nL['id'];
				$area_sql = "select `name` from ".$db_area." where `id`=".$nL['area'];
				$area = $db->fetch_one($area_sql);
				$tel = ($nL['mobile'] == "" ? $nL['telephone'] : $nL['mobile']);
				$name = ($nL['occupied'] == 1 ? "<font color=\"red\">".$nL['name']."</font>" : $nL['name']);
				$note = (checkStr($nL['note']) ? "Yes" : "");
				echo "<tr align=\"center\">\n";
				echo "<td><input type=\"checkbox\" name=\"employee[{$tid}]\" value=\"1\" class=\"radio\"></td>\n";
				echo "<td>".$nL['id']."</td>\n";
				echo "<td>".$name."</td>\n";
				echo "<td>".$tel."</td>\n";
				echo "<td>".$area."</td>\n";
				echo "<td>".$note."</td>\n";
				echo "<td>".date('y-m-d',$nL['reg_time'])."</td>\n";
				if ($allow[$a] == 2)
					echo "<td align=\"center\"><a href=\"admin.php?j=User&a=showemployee&id=".$nL['id']."\">查看</a> <a href=\"#\" onclick=\"ifDel('admin.php?j=User&a=delemployee&id=".$nL['id']."')\">删除</a></td>\n";
				elseif ($allow[$a] == 1)
					echo "<td align=\"center\"><a href=\"admin.php?j=User&a=showemployee&id=".$nL['id']."\">查看</a></td>\n";
				echo "<td><a href=\"admin.php?j=User&a=hireemployee&id={$nL[id]}&page={$cpage}\">".$select[$nL['company']]."聘请</a></td>\n";
				echo "<td><a href=\"admin.php?j=User&a=qualifyemployee&id={$nL[id]}&page={$cpage}\">".$select[$nL['qualified']]."认证</a></td>\n";
				echo "<td><a href=\"admin.php?j=User&a=checkemployee&id={$nL[id]}&page={$cpage}\">".$select[$nL['checked']]."审批</a></td>\n";
				echo "<td><a href=\"admin.php?j=User&a=recommendemployee&id={$nL[id]}&page={$cpage}\">".$select[$nL['recommended']]."推荐</a></td>\n";
				echo "</tr>\n";
			}
			echo "<tr><td colspan=\"12\" align=\"right\">".$page_char."</td></tr>";
			echo "<tr><td colspan=\"12\" align=\"center\"><select name=\"operation\"><option>请选择</option><option value=1>聘请</option><option value=2>不聘请</option><option value=3>认证</option><option value=4>不认证</option><option value=5>审批</option><option value=6>不审批</option><option value=7>推荐</option><option value=8>不推荐</option></select>&nbsp;&nbsp;&nbsp;&nbsp;<input class=\"button\" accesskey=\"\" type=\"submit\" name=\"\" value=\"处理\" />";
			$Form->makehidden(array(
				'name' => "page",
				'value' => $cpage,
				));
			echo "\n</td></tr></form></table>\n";
		}
		else
		{
			$Form->tableheaderbig(array("title" => $formtitle,));
			$Form->maketd(array("暂时没有雇员~~"));
			$Form->tablefooter();
		}
		$Form->cpfooter();
	}
	elseif ($type == 2)
	{
		$select = array('未', '已');
		$sql_num = "select count(*) from ".$db_employer." where {$condition}";
		$listNum = $db->fetch_one($sql_num);
		$formtitle = "雇主 [共".$listNum."个] [{$num_in_page}个/页]";

		$cpage = isset($_GET['page']) ? intval($_GET['page']) : 1;
		$page_char = page($listNum,$num_in_page,$cpage,"admin.php?j=User&a=employer{$addlink}");
		$limitS = $cpage*$num_in_page-$num_in_page;

		$Form->cpheader();
		if($listNum > 0)
		{
			$Form->formheader(array("action" => "admin.php?j=User&a=dealemployer",
				"title" => $formtitle,
				"colspan" => "11",
				"name" => "form",
			));
			$Form->js_checkall();
			$Form->if_Del();
			echo "<tr align=\"center\">\n";
			echo "<td width=\"5%\">\n";
			echo "<input type=\"checkbox\" name=\"chkall\" value=\"on\" class=\"radio\" onclick=\"CheckAll(this.form)\"></td>\n";
			echo "<td width=\"10%\"><b>编号</b></td>\n";
			echo "<td width=\"12%\"><b>姓名</b></td>\n";
			echo "<td width=\"18%\"><b>电话</b></td>\n";
			echo "<td width=\"10%\"><b>地区</b></td>\n";
			echo "<td width=\"6%\"><b>备注</b></td>\n";
			echo "<td width=\"10%\"><b>注册日期</b></td>\n";
			echo "<td width=\"10%\"><b>操作</b></td>\n";
			echo "<td width=\"7%\"><b>审批</b></td>\n";
			echo "<td width=\"7%\"><b>置顶</b></td>\n";
			echo "</tr>\n";
			$lstRequest = "select * from ".$db_employer." where {$condition} order by `reg_time` desc limit ".$limitS.",".$num_in_page;
			$vRe = $db->query($lstRequest);
			while($nL = $db->fetch_array($vRe)) 
			{
				$sid = $nL['id'];
				$area_sql = "select `name` from ".$db_area." where `id`=".$nL['area'];
				$area = $db->fetch_one($area_sql);
				$tel = ($nL['mobile'] == "" ? $nL['telephone'] : $nL['mobile']);
				$name = ($nL['occupied'] == 1 ? "<font color=\"red\">".$nL['name']."</font>" : $nL['name']);
				$note = (checkStr($nL['note']) ? "Yes" : "");
				echo "<tr align=\"center\">\n";
				echo "<td><input type=\"checkbox\" name=\"employer[{$sid}]\" value=\"1\" class=\"radio\"></td>\n";
				echo "<td>".$nL['id']."</td>\n";
				echo "<td>".$name."</td>\n";
				echo "<td>".$tel."</td>\n";
				echo "<td>".$area."</td>\n";
				echo "<td>".$note."</td>\n";
				echo "<td>".date('y-m-d',$nL['reg_time'])."</td>\n";
				if ($allow[$a] == 2)
					echo "<td align=\"center\"><a href=\"admin.php?j=User&a=showemployer&id=".$nL['id']."\">查看</a> <a href=\"#\" onclick=\"ifDel('admin.php?j=User&a=delemployer&id=".$nL['id']."')\">删除</a></td>\n";
				elseif ($allow[$a] == 1)
					echo "<td align=\"center\"><a href=\"admin.php?j=User&a=showemployer&id=".$nL['id']."\">查看</a></td>\n";
				echo "<td><a href=\"admin.php?j=User&a=checkemployer&id={$nL[id]}&page={$cpage}\">".$select[$nL['checked']]."审批</a></td>\n";
				echo "<td><a href=\"admin.php?j=User&a=topemployer&id={$nL[id]}&page={$cpage}\">".$select[$nL['top']]."置顶</a></td>\n";
				echo "</tr>\n";
			}
			echo "<tr><td colspan=\"11\" align=\"right\">".$page_char."</td></tr>";
			echo "<tr><td colspan=\"11\" align=\"center\"><select name=\"operation\"><option>请选择</option><option value=1>审批</option><option value=2>不审批</option><option value=3>置顶</option><option value=4>不置顶</option></select>&nbsp;&nbsp;&nbsp;&nbsp;<input class=\"button\" accesskey=\"\" type=\"submit\" name=\"\" value=\"处理\" />";
			$Form->makehidden(array(
				'name' => "page",
				'value' => $cpage,
				));
			echo "\n</td></tr></form></table>\n";
		}
		else
		{
			$Form->tableheaderbig(array("title" => $formtitle,));
			$Form->maketd(array("暂时没有雇主~~"));
			$Form->tablefooter();
		}
		$Form->cpfooter();
	}
}
else
{
	$Form->oa_exit("功能不存在","index.php?a=main");
}

function makecondition($arguments = array())
{
	$condition = "";
	$leading = "";
	if ($arguments['id'])
	{
		$condition .= $leading."`id`=".$arguments['id'];
		$leading = " and ";
	}
	if ($arguments['username'])
	{
		$condition .= $leading."`username`='".$arguments['username']."'";
		$leading = " and ";
	}
	if ($arguments['name'])
	{
		$condition .= $leading."`name`='".$arguments['name']."'";
		$leading = " and ";
	}
	if ($arguments['telephone'])
	{
		$condition .= $leading."`telephone`='".$arguments['telephone']."'";
		$leading = " and ";
	}
	if ($arguments['mobile'])
	{
		$condition .= $leading."`mobile`='".$arguments['mobile']."'";
		$leading = " and ";
	}
	return $condition;
}

function makeaddlink($arguments = array())
{
	$addlink = "";
	$addlink .= "&type=".$arguments['type'];
	if ($arguments['id'])
	{
		$addlink .= "&id=".$arguments['id'];
	}
	if ($arguments['username'])
	{
		$addlink .= "&username=".$arguments['username'];
	}
	if ($arguments['name'])
	{
		$addlink .= "&name=".$arguments['name'];
	}
	if ($arguments['telephone'])
	{
		$addlink .= "&telephone=".$arguments['telephone'];
	}
	if ($arguments['mobile'])
	{
		$addlink .= "&mobile=".$arguments['mobile'];
	}
	return $addlink;
}

?>