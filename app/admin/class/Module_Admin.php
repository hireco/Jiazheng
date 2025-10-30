<?php
/*
用户管理功能模块
========
需要的类：config.php forms.php class_DataBase.php SmartTemplate
========
主要功能：（$a == ）
--------------------
附加功能 (function)
-------------------

关于权限的说明
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
$num_in_page = 20; //每页显示个数
//用户数据表已包在admin.php
switch($usr->rights['Admin'])
{
case 'S':  //超级管理员
	$allow = array(
		'add' => 2, 'doadd' => 2, 'list' => 2, 'edit' => 2, 'doedit' => 2, 'del' => 2, 'resettime' => 2,
		);
	//用户权限授权
	$rightslist = array(
		'Myoa' => array('N' => "无权限", 'M' => "二级管理员", 'A' => '一级管理员', 'S' => '超级管理员'),
		'Config' => array('N' => "无权限", 'M' => "二级管理员", 'A' => '一级管理员', 'S' => '超级管理员'),
		'User' => array('N' => "无权限", 'M' => "二级管理员", 'A' => '一级管理员', 'S' => '超级管理员'),
		'News' => array('N' => "无权限", 'M' => "二级管理员", 'A' => '一级管理员', 'S' => '超级管理员'),
		'Note' => array('N' => "无权限", 'M' => "二级管理员", 'A' => '一级管理员', 'S' => '超级管理员'),
		'Contract' => array('N' => "无权限", 'M' => "二级管理员", 'A' => '一级管理员', 'S' => '超级管理员'),
		'Ad' => array('N' => "无权限", 'M' => "二级管理员", 'A' => '一级管理员', 'S' => '超级管理员'),
		'Friend' => array('N' => "无权限", 'M' => "二级管理员", 'A' => '一级管理员', 'S' => '超级管理员'),
		'Stat' => array('N' => "无权限", 'M' => "二级管理员", 'A' => '一级管理员', 'S' => '超级管理员'),
		'Admin' => array('N' => "无权限", 'M' => "二级管理员", 'A' => '一级管理员', 'S' => '超级管理员'),
	);
	break;
case 'A':  //一级管理员
	$allow = array(
		'add' => 1, 'doadd' => 1, 'list' => 2, 'edit' => 1, 'doedit' => 1, 'del' => 0, 'resettime' => 0,
		);
	//用户权限授权
	$rightslist = array(
		'Myoa' => array('N' => "无权限", 'M' => "二级管理员"),
		'Config' => array('N' => "无权限", 'M' => "二级管理员"),
		'User' => array('N' => "无权限", 'M' => "二级管理员"),
		'News' => array('N' => "无权限", 'M' => "二级管理员"),
		'Note' => array('N' => "无权限", 'M' => "二级管理员"),
		'Contract' => array('N' => "无权限", 'M' => "二级管理员"),
		'Ad' => array('N' => "无权限", 'M' => "二级管理员"),
		'Friend' => array('N' => "无权限", 'M' => "二级管理员"),
		'Stat' => array('N' => "无权限", 'M' => "二级管理员"),
		'Admin' => array('N' => "无权限", 'M' => "二级管理员"),
	);
	break;
default:  //其它
	$allow = array(
		'add' => 0, 'doadd' => 0, 'list' => 0, 'show' => 0, 'edit' => 0, 'doedit' => 0,
		);
	break;
}

if (!($allow[$a] > 0)) $Form->oa_exit("你没有权限执行该操作~~");

//默认权限
if ($a == 'add')  //添加用户
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
	$Form->cpheader('添加用户');
	$Form->formheader(array(
		'title' => "添加用户",
		'action' => "admin.php?j=Admin&a=doadd"
	));
	$Form->makeinput(array(
		'text'  => "用户名",
		'name'  => "user_id",
		'value'  => "",
	));
	$Form->makeinput(array(
		'text'  => "用户有效时间",
		'note' => "单位：天，空表示无限时间",
		'name'  => "available_time",
		'value'  => "",
	));
	$Form->maketd(array(
		'<b>密码</b>','111111  （将在第一次登录时进行修改）'
	));
	$Form->maketd(array('colspan=2' => "<font color=red><b>以下是用户的权限配置</b></font>"));
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
	$Form->maketd(array('colspan=2' => "<font color=blue><b>以下是用户的联系资料</b></font>"));
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
		'text'  => "备注",
		'note'  => "其它联系信息",
		'name'  => "other",
		'value'  => "",
	), 0);
	$Form->formfooter();
	$Form->cpfooter();
}
elseif ($a == 'doadd')  //执行添加用户
{
	$username = checkStr(strtolower($_POST['user_id']));
	if (!$username) $Form->oa_exit("请填写用户名！~");
	$sql = "select count(*) from {$db_admin} where `username`='{$username}'";
	if ($db->fetch_one($sql)) $Form->oa_exit("该用户名已经存在！~");

	foreach($modulename as $k => $v)
	{
		$rights[$k] = (isset($rightslist[$k][$_POST["rights"][$k]])) ? $_POST["rights"][$k] : 'N';
	}
	$db->insert($db_admin,array(
		'username' => $username,
		'password' => '96e79218965eb72c92a549dd5a330112',//初始密码 111111
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
	$Form->oa_exit("添加用户成功!","admin.php?j=Admin&a=list");
}
elseif ($a == 'list') //用户列表
{
	$sql_num = "select count(*) from ".$db_admin." where 1";
	$listNum = $db->fetch_one($sql_num);
	$formtitle = "{$statetitle} [共".$listNum."个] [{$num_in_page}个/页]";

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
		echo "<td width=\"28%\"><b>用户名</b></td>\n";
		echo "<td width=\"34%\"><b>权限</b></td>\n";
		echo "<td width=\"20%\"><b>最后登录时间</b></td>\n";
		echo "<td width=\"18%\"><b>最后登录ip</b></td>\n";
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
		$Form->maketd(array("暂时没有用户~~"));
		$Form->tablefooter();
	}
	$Form->cpfooter();
}
elseif ($a == 'edit')  //编辑用户
{
	$id = intval($_GET['id']);
	$sql = "select * from ".$db_admin." where `id`='".$id."'";
	$uL = $db->fetch_one_array($sql);
	
	if (empty($uL)) $Form->oa_exit("该用户不存在");
	
	$rightname = array('N' => "无权限", 'M' => "二级管理员", 'A' => "一级管理员", 'S' => "超级管理员");
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
	$Form->cpheader('添加用户');
	$Form->formheader(array(
		'title' => "添加用户",
		'action' => "admin.php?j=Admin&a=doedit"
	));
	$Form->maketd(array(
		"用户名",
		$uL['username']
	));
	$Form->makeinput(array(
		'text'  => "用户有效时间",
		'note' => "单位：天，空表示无限时间",
		'name'  => "available_time",
		'value'  => $uL['available_time'],
	));	$Form->maketd(array(
		"开始计算日期",
		date('Y-m-d',$uL['time'])."&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<font color=red><a href=\"admin.php?j=Admin&a=resettime&id=".$uL['id']."\">重新设置</a></font>",
	));

	$Form->makehidden(array(
		'name' => "id",
		'value' => $uL['id']
	));
	$Form->maketd(array('colspan=2' => "<font color=red><b>以下是用户的权限配置</b></font>"));
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
	$Form->maketd(array('colspan=2' => "<font color=blue><b>以下是用户的联系资料</b></font>"));
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
		'text'  => "备注",
		'note'  => "其它联系信息",
		'name'  => "other",
		'value'  => html2str($uL['other']),
	), 0);
	if ($allow['del'])
	{
		$Form->formfooter(array(
			"button" => array(
				array('value'=>"保存"),
				array('value'=>"重置", 'type'=>"reset"),
				array('value'=>"删除", 'type'=>"button", 'extra' => "onclick=\"ifDel('admin.php?j=Admin&a=del&id=".$uL['id']."')\""),
				array('value'=>"返回", 'type'=>"button", 'extra' => "onclick=\"goto('admin.php?j=Admin&a=list')\""),
			)));
	}
	else
	{
		$Form->formfooter(array(
			"button" => array(
				array('value'=>"保存"),
				array('value'=>"重置", 'type'=>"reset"),
				array('value'=>"返回", 'type'=>"button", 'extra' => "onclick=\"goto('admin.php?j=Admin&a=list')\""),
			)));
	}
	$Form->If_Del();
	echo "<script>function goto(url){this.location.replace(url);}</script>";
	$Form->cpfooter();
}
elseif ($a == 'doedit')  //执行编辑用户
{
	$id = intval($_POST['id']);
	$sql = "select * from ".$db_admin." where `id`='".$id."'";
	$uL = $db->fetch_one_array($sql);
	
	if (empty($uL)) $Form->oa_exit("该用户不存在");

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
	$Form->oa_exit("编辑用户成功!设置将在用户下次登录生效","admin.php?j=Admin&a=list");
}
elseif ($a == 'del')  //删除用户
{
	$id = intval($_GET['id']);
	$sql = "select count(*) from ".$db_admin." where `id`='".$id."'";
	$num = $db->fetch_one($sql);
	
	if (!($num)) $Form->oa_exit("该用户不存在");

	$db->query("delete from ".$db_admin." where `id`='".$id."'");
	$Form->oa_exit("删除用户成功!","admin.php?j=User&a=list");
}
elseif ($a == 'resettime') //重新设置时间
{
	$id = intval($_GET['id']);
	$db->update($db_admin,array(
		'time' => time(),
		'usable' => 1,
		), "`id`=$id");
	$Form->oa_exit("重置时间成功", "admin.php?j=Admin&a=edit&id={$id}");
}
else
{
	$Form->oa_exit("功能不存在","index.php?a=main");
}

?>