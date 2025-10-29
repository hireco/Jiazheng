<?php
/*
新闻功能模块
========
需要的类：config.php forms.php class_DataBase.php SmartTemplate class_User.php
========
主要功能：（$a == ）
--------------------
basic 基本设置	dobasic 执行基本设置	delpic 删除LOGO
security 安全设置	dosecurity 执行安全设置
company 公司设置	docompany 执行公司设置
us 关于我们列表	addus	添加关于我们	doaddus 执行添加关于我们	editus 编辑关于我们	doeditus 执行编辑关于我们	delus 删除关于我们
data 数据设置
area 地区列表	addarea 添加地区	doaddarea 执行添加地区	editarea 编辑地区	doeditarea 执行编辑地区	delarea 删除地区
degree 学历列表	adddegree 添加学历	doadddegree 执行添加学历	editdegree 编辑学历	doeditdegree 执行编辑学历	deldegree 删除学历
service 服务列表	addservice 添加服务	doaddservice 执行添加服务	editservice 编辑服务	doeditservice 执行编辑服务	delservice 删除服务
index 首页设置	doindex 执行首页设置
nav	导航条列表	editnav	编辑导航条

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
$db_config = "`".$mysql_prefix."config`"; //设置数据表
$db_us = "`".$mysql_prefix."company`"; //关于我们数据表
$db_area = "`".$mysql_prefix."area`"; //地区数据表
$db_degree = "`".$mysql_prefix."degree`"; //学历数据表
$db_service = "`".$mysql_prefix."service`"; //服务数据表
$db_nav = "`".$mysql_prefix."navigator`"; //导航条数据表
$imgPath = "../attachment/config/"; //LOGO目录
$num_in_page = 20;  //每页显示数目

$allow = array();

switch($usr->rights['News'])
{
case 'S':  //超级管理员
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
default:  //无权限
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

if (!($allow[$a] > 0)) $Form->oa_exit("你没有权限执行该操作~~");

if ($a == 'basic') //基本设置
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
	$Form->cpheader("基本设置");
	$Form->formheader(array(
		'title' => "基本设置",
		'action' => "admin.php?j=Config&a=dobasic",
		'enctype' => "multipart/form-data",
		));
	$Form->makeinput(array(
		'text' => "网站标题",
		'name' => "title",
		'size' => "50",
		'value' => $config['title'],
		));
	$Form->makeinput(array(
		'text' => "网站管理员",
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
		$Form->maketd(array("<b>LOGO</b><br/>(小于2M)","已上传：[<a href=\"{$imgPath}{$config['logo']}\" target=\"_blank\">查看</a>] [<a href=\"#\" onclick=\"ifDel('admin.php?j=Config&a=delpic')\">删除</a>]"));
	}
	else
	{
		$Form->makefile(array(
			'text' => "LOGO",
			'note' => "(小于2M)",
			'name' => "file",
			'size' => "50"
			));
	}
	if (strlen($config['link_logo']) > 1)
	{
		$Form->if_Del();
		$Form->maketd(array("<b>友情链接LOGO</b><br/>(小于2M)","已上传：[<a href=\"{$imgPath}{$config['link_logo']}\" target=\"_blank\">查看</a>] [<a href=\"#\" onclick=\"ifDel('admin.php?j=Config&a=delpic&t=1')\">删除</a>]"));
	}
	else
	{
		$Form->makefile(array(
			'text' => "友情链接LOGO",
			'note' => "(小于2M)",
			'name' => "link_logo",
			'size' => "50"
			));
	}
	$Form->maketextarea(array(
		'text' => "网站介绍",
		'name' => "intro",
		'value' => $config['intro'],
		), 0);
	$Form->maketextarea(array(
		'text' => "META关键字",
		'note' => "方便搜索引擎搜索到本网站",
		'name' => "keyword",
		'value' => $config['keyword'],
		), 0);
	$Form->maketextarea(array(
		'text' => "META描述",
		'note' => "搜索引擎显示的描述",
		'name' => "description",
		'value' => $config['description'],
		), 0);
	$Form->makeinput(array(
		'text' => "ICP备案信息",
		'name' => "ICPinfo",
		'size' => "50",
		'value' => $config['icpinfo'],
		));
	$Form->makeinput(array(
		'text' => "ICP备案信息链接地址",
		'name' => "ICPlink",
		'size' => "50",
		'value' => $config['icplink'],
		));
	$Form->maketextarea(array(
		'text' => "注册许可协议",
		'name' => "reginfo",
		'value' => $config['reginfo'],
		), 0);
	$Form->makeselect(array(
				"text"  => "设定模版",
				"note"  => "选择您要使用的模板",
				"name"  => "template",
				"option" => $dir,
				"selected" => $config['template'],
            ));
	$Form->formfooter(array(
		"button" => array(
			array('value'=>"确定"),
			array('value'=>"重置",'type'=>"reset"),
		)));
}
elseif ($a == 'dobasic') //执行基本设置
{
	require("class/class_Upload.php");
	$filepath = $_FILES['file']['name'];
	if (strlen($filepath) > 0)
	{
		$upd = new cUpload;
		$filetmp = $_FILES['file']['tmp_name'];
		$filesize = $_FILES['file']['size'];
		if($filesize == 0) $Form->oa_exit("文件过大或文件不存在");
		$extname = $upd->getext($filepath);
		$uploadpath = "logo_".date('ydmHis').".".$extname;
		switch($upd->upload($filetmp,$imgPath.$uploadpath))
		{
		case 1:
			$Form->oa_exit("文件类型不允许");break;
		case 2:
			$Form->oa_exit("上传附件发生意外错误");break;
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
		if($filesize == 0) $Form->oa_exit("文件过大或文件不存在");
		$extname = $upd2->getext($filepath);
		$uploadpath = "llogo_".date('ydmHis').".".$extname;
		switch($upd2->upload($filetmp,$imgPath.$uploadpath))
		{
		case 1:
			$Form->oa_exit("文件类型不允许");break;
		case 2:
			$Form->oa_exit("上传附件发生意外错误");break;
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
	$Form->oa_exit("成功修改基本设置", "admin.php?j=Config&a=basic");
}
elseif($a == 'delpic') //删除选项图片
{
	$sql = "select `logo` from ".$db_config." where `id`=1";
	$filepath = $db->fetch_one($sql);
	$db->update($db_config,array(
		'logo' => "",
		),"`id`=1");
	@unlink ($imgPath.$filepath);
	$Form->oa_exit("LOGO删除成功","admin.php?j=Config&a=basic");
}
elseif ($a == 'security') //安全设置
{
	$select = array('否', '是');
	$config_sql = "select * from ".$db_config." where 1";
	$query = $db->query($config_sql);
	$config = $db->fetch_array($query);

	$Form->cpheader("安全设置");
	$Form->formheader(array(
		'title' => "安全设置",
		'action' => "admin.php?j=Config&a=dosecurity",
		));
	$Form->makehidden(array(
		'name' => "hidden",
		'size' => "50",
		));
	$Form->makeselect(array(
		'name' => "regverify",
		'text' => "注册认证码功能",
		'note' => "只有在服务器支持GD时才可以开启",
		'option' => $select,
		'selected' => $config['regverify'],
		));
	$Form->makeselect(array(
		'name' => "commentverify",
		'text' => "评论认证码功能",
		'note' => "只有在服务器支持GD时才可以开启",
		'option' => $select,
		'selected' => $config['commentverify'],
		));
	$Form->makeselect(array(
		'name' => "noteverify",
		'text' => "留言认证码功能",
		'note' => "只有在服务器支持GD时才可以开启",
		'option' => $select,
		'selected' => $config['noteverify'],
		));
	$Form->makeselect(array(
		'name' => "oaloginverify",
		'text' => "后台登录认证码功能",
		'note' => "只有在服务器支持GD时才可以开启",
		'option' => $select,
		'selected' => $config['oaloginverify'],
		));
	$Form->formfooter(array(
		"button" => array(
			array('value'=>"确定"),
			array('value'=>"重置",'type'=>"reset"),
		)));
}
elseif ($a == 'dosecurity') //执行安全设置
{
	$db->update($db_config,array(
		'regverify' => $_POST['regverify'],
		'commentverify' => $_POST['commentverify'],
		'noteverify' => $_POST['noteverify'],
		'oaloginverify' => $_POST['oaloginverify'],
		),"`id`=1");
	$Form->oa_exit("成功修改安全设置", "admin.php?j=Config&a=security");
}
elseif ($a == 'company') //公司设置
{
	$config_sql = "select * from ".$db_config." where 1";
	$query = $db->query($config_sql);
	$config = $db->fetch_array($query);

	$Form->cpheader("公司设置");
	$Form->formheader(array(
		'title' => "公司设置",
		'action' => "admin.php?j=Config&a=docompany",
		));
	$Form->makeinput(array(
		'text' => "电话号码",
		'name' => "telephone",
		'value' => $config['telephone'],
		));
	$Form->makeinput(array(
		'text' => "传真",
		'name' => "fax",
		'value' => $config['fax'],
		));
	$Form->makeinput(array(
		'text' => "地址",
		'name' => "address",
		'size' => "100",
		'value' => $config['address'],
		));
	$Form->formfooter(array(
		"button" => array(
			array('value'=>"确定"),
			array('type' => "button", 'value'=>"添加更多", "extra"=>"onclick=\"goto('admin.php?j=Config&a=us')\""),
			array('value'=>"重置",'type'=>"reset"),
		)));
	echo "<script>function goto(url){this.location.replace(url);}</script>";
}
elseif ($a == 'docompany') //执行公司设置
{
	$db->update($db_config,array(
		'telephone' => $_POST['telephone'],
		'fax' => $_POST['fax'],
		'address' => $_POST['address'],
		),"`id`=1");
	$Form->oa_exit("成功修改公司设置", "admin.php?j=Config&a=company");
}
elseif ($a == 'us') //公司选项列表
{
	$sql_num = "select count(*) from ".$db_us." where 1";
	$listNum = $db->fetch_one($sql_num);
	$formtitle = "公司选项 [共".$listNum."个] [{$num_in_page}个/页]";

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
		echo "<td width=\"25%\"><b>选项</b></td>\n";
		echo "<td width=\"50%\"><b>内容</b></td>\n";
		echo "<td width=\"25%\"><b>操作</b></td>\n";
		echo "</tr>\n";
		$lstRequest = "select * from ".$db_us." where 1 order by `id` desc limit ".$limitS.",".$num_in_page;
		$vRe = $db->query($lstRequest);
		while($nL = $db->fetch_array($vRe)) 
		{
			$icon = $iconPath.$nL['icon'];
			echo "<tr align=\"center\">\n";
			echo "<td>".$nL['name']."</td>\n";
			echo "<td>".gbsubstr($nL['content'],0,100)."</td>\n";
			echo "<td align=\"center\"><a href=\"admin.php?j=Config&a=editus&id=".$nL['id']."\">修改</a> <a href=\"admin.php?j=Config&a=delus&id=".$nL['id']."\">删除</a></td>\n";
			echo "</tr>\n";
		}
		echo "<tr><td colspan=\"3\" align=\"right\">".$page_char."</td></tr>";
		$Form->formfooter(array(
			"colspan"=>'3',
			"button" => array(
				array('value'=>"添加", 'type'=>"button", 'extra' => "onclick=\"goto('admin.php?j=Config&a=addus')\""),
				array('value'=>"返回", 'type'=>"button", 'extra' => "onclick=\"goto('admin.php?j=Config&a=company')\""),
			)));
		$Form->tablefooter(array("colspan" => "4"));
	}
	else
	{
		$Form->tableheaderbig(array("title" => $formtitle,));
		$Form->maketd(array("暂时没有公司选项~~"));
		$Form->formfooter(array(
			"colspan"=>'4',
			"button" => array(
				array('value'=>"添加", 'type'=>"button", 'extra' => "onclick=\"goto('admin.php?j=Config&a=addus')\""),
				array('value'=>"返回", 'type'=>"button", 'extra' => "onclick=\"goto('admin.php?j=Config&a=company')\""),
			)));
		$Form->tablefooter();
	}
	echo "<script>function goto(url){this.location.replace(url);}</script>";
	$Form->cpfooter();
}
elseif ($a == 'addus') //添加公司选项
{
	$Form->cpheader("添加公司选项");
	$Form->change();
	$Form->formheader(array(
		'title' => "添加公司选项",
		'action' => "admin.php?j=Config&a=doaddus"
		));
	$Form->makeinput(array(
		'text' => "名称",
		'name' => "name",
		'size' => "50",
		));
	$Form->maketextarea(array(
		'text' => "内容",
		'name' => "content",
		'cols' => "600",
		'rows' => "400",
		'value' => $config['content'],
		));
	$Form->formfooter(array(
		"button" => array(
			array('value'=>"添加"),
			array('value'=>"重置",'type'=>"reset"),
			array('value'=>"返回", 'type'=>"button", 'extra' => "onclick=\"goto('admin.php?j=Config&a=us')\""),
		)));
	echo "<script>function goto(url){this.location.replace(url);}</script>";
	$Form->cpfooter();
}
elseif ($a == 'doaddus') //执行添加公司选项
{
	$name = $_POST['name'];
	if (!$name) $Form->oa_exit("请填写公司选项名称");
	$db->insert($db_us,array(
		'name' => $name,
		'content' => $_POST['content'],
		));
	$Form->oa_exit("添加公司选项成功","admin.php?j=Config&a=us");
}
elseif ($a == 'editus') //编辑公司选项
{
	if (!isset($_GET['id']))
		$Form->oa_exit("参数错误");
	$id = $_GET['id'];
	$sql_num = "select count(*) from ".$db_us." where `id`=".$id;
	if ($db->fetch_one($sql_num) == 0)
		$Form->oa_exit("不存在这个公司选项");
	$sql = "select * from ".$db_us." where `id`=".$id;
	$query = $db->query($sql);
	$info = $db->fetch_array($query);
	$Form->cpheader("编辑公司选项");
	$Form->change();
	$Form->formheader(array(
		'title' => "编辑公司选项",
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
		'text' => "名称",
		'name' => "name",
		'size' => "50",
		'value' => $info['name'],
		));
	$Form->maketextarea(array(
		'text' => "内容",
		'name' => "content",
		'cols' => "600",
		'rows' => "400",
		'value' => $info['content'],
		));
	$Form->formfooter(array(
		"button" => array(
			array('value'=>"修改"),
			array('value'=>"重置",'type'=>"reset"),
			array('value'=>"返回", 'type'=>"button", 'extra' => "onclick=\"goto('admin.php?j=Config&a=us')\""),
		)));
	echo "<script>function goto(url){this.location.replace(url);}</script>";
	$Form->cpfooter();
}
elseif ($a == 'doeditus') //执行编辑公司选项
{
	$name = $_POST['name'];
	$id = $_POST['id'];
	if (!$name) $Form->oa_exit("请填写公司选项名称");
	$db->update($db_us,array(
		'name' => $name,
		'content' => $_POST['content'],
		),"`id`={$id}");
	$Form->oa_exit("编辑公司选项成功","admin.php?j=Config&a=us");
}
elseif ($a == 'delus') //删除公司选项
{
	$id = intval($_GET['id']);
	$sql = "select count(*) from ".$db_us." where `id`='".$id."'";
	$num = $db->fetch_one($sql);
	
	if (!($num)) $Form->oa_exit("该公司选项不存在");

	$db->query("delete from ".$db_us." where `id`='".$id."'");
	$Form->oa_exit("删除公司选项成功!","admin.php?j=Config&a=us");
}
elseif ($a == 'data') //数据设置
{
	$formtitle = "数据设置";
	$Form->cpheader();
	$Form->tableheaderbig(array(
		"title" => $formtitle,
		"colspan" => "3",
	));
	echo "<tr align=\"center\">\n";
	echo "<td width=\"34%\"><b>服务设置</b></td>\n";
	echo "<td width=\"33%\"><b>地区设置</b></td>\n";
	echo "<td width=\"33%\"><b>学历设置</b></td>\n";
	echo "</tr>\n";
	echo "<tr align=\"center\">\n";
	echo "<td><a href=\"admin.php?j=Config&a=service\">编辑</a></td>\n";
	echo "<td><a href=\"admin.php?j=Config&a=area\">编辑</a></td>\n";
	echo "<td><a href=\"admin.php?j=Config&a=degree\">编辑</a></td>\n";
	echo "</tr>\n";
	$Form->tablefooter();
}
elseif ($a == 'service') //服务列表
{
	$sql_num = "select count(*) from ".$db_service." where 1";
	$listNum = $db->fetch_one($sql_num);
	$formtitle = "服务 [共".$listNum."个] [{$num_in_page}个/页]";

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
		echo "<td width=\"50%\"><b>服务</b></td>\n";
		echo "<td width=\"50%\"><b>操作</b></td>\n";
		echo "</tr>\n";
		$lstRequest = "select * from ".$db_service." where 1 order by `id` desc limit ".$limitS.",".$num_in_page;
		$vRe = $db->query($lstRequest);
		while($nL = $db->fetch_array($vRe)) 
		{
			echo "<tr align=\"center\">\n";
			echo "<td>".$nL['name']."</td>\n";
			echo "<td align=\"center\"><a href=\"admin.php?j=Config&a=editservice&id=".$nL['id']."\">修改</a> <a href=\"admin.php?j=Config&a=delservice&id=".$nL['id']."\">删除</a></td>\n";
			echo "</tr>\n";
		}
		echo "<tr><td colspan=\"2\" align=\"right\">".$page_char."</td></tr>";
		$Form->formfooter(array(
			"colspan"=>'2',
			"button" => array(
				array('value'=>"添加服务", 'type'=>"button", 'extra' => "onclick=\"goto('admin.php?j=Config&a=addservice')\""),
				array('value'=>"返回", 'type'=>"button", 'extra' => "onclick=\"goto('admin.php?j=Config&a=data')\""),
			)));
		$Form->tablefooter(array("colspan" => "2"));
	}
	else
	{
		$Form->tableheaderbig(array("title" => $formtitle,));
		$Form->maketd(array("暂时没有服务~~"));
		$Form->formfooter(array(
			"colspan"=>'2',
			"button" => array(
				array('value'=>"添加服务", 'type'=>"button", 'extra' => "onclick=\"goto('admin.php?j=Config&a=addservice')\""),
				array('value'=>"返回", 'type'=>"button", 'extra' => "onclick=\"goto('admin.php?j=Config&a=data')\""),
			)));
		$Form->tablefooter();
	}
	echo "<script>function goto(url){this.location.replace(url);}</script>";
	$Form->cpfooter();
}
elseif ($a == 'addservice') //添加服务
{
	$Form->cpheader("添加服务");
	$Form->formheader(array(
		'title' => "添加服务",
		'action' => "admin.php?j=Config&a=doaddservice"
		));
	$Form->makeinput(array(
		'text' => "服务名称",
		'name' => "name",
		'size' => "50",
		));
	$Form->makeinput(array(
		'text' => "收费标准",
		'name' => "fee",
		'size' => "60",
		));
	$Form->maketextarea(array(
		'text' => "服务简介",
		'name' => "intro",
		), 0);
	$Form->formfooter(array(
		"button" => array(
			array('value'=>"添加"),
			array('value'=>"重置",'type'=>"reset"),
			array('value'=>"返回", 'type'=>"button", 'extra' => "onclick=\"goto('admin.php?j=Config&a=service')\""),
		)));
	echo "<script>function goto(url){this.location.replace(url);}</script>";
	$Form->cpfooter();
}
elseif ($a == 'doaddservice') //执行添加服务
{
	$name = $_POST['name'];
	if (!$name) $Form->oa_exit("请填写服务名称");
	$db->insert($db_service,array(
		'name' => $name,
		'fee' => $_POST['fee'],
		'intro' => $_POST['intro'],
		));
	$Form->oa_exit("添加服务成功","admin.php?j=Config&a=service");
}
elseif ($a == 'editservice') //编辑服务
{
	if (!isset($_GET['id']))
		$Form->oa_exit("参数错误");
	$id = $_GET['id'];
	$sql_num = "select count(*) from ".$db_service." where `id`=".$id;
	if ($db->fetch_one($sql_num) == 0)
		$Form->oa_exit("不存在这个服务");
	$sql = "select * from ".$db_service." where `id`=".$id;
	$query = $db->query($sql);
	$info = $db->fetch_array($query);
	$Form->cpheader("编辑服务");
	$Form->formheader(array(
		'title' => "编辑服务",
		'action' => "admin.php?j=Config&a=doeditservice"
		));
	$Form->makehidden(array(
		'name' => "id",
		'value' => $id
		));
	$Form->makeinput(array(
		'text' => "服务名称",
		'name' => "name",
		'size' => "50",
		'value' => $info['name'],
		));
	$Form->makeinput(array(
		'text' => "收费标准",
		'name' => "fee",
		'size' => "60",
		'value' => $info['fee'],
		));
	$Form->maketextarea(array(
		'text' => "服务简介",
		'name' => "intro",
		'value' => $info['intro'],
		), 0);
	$Form->formfooter(array(
		"button" => array(
			array('value'=>"修改"),
			array('value'=>"重置",'type'=>"reset"),
			array('value'=>"返回", 'type'=>"button", 'extra' => "onclick=\"goto('admin.php?j=Config&a=service')\""),
		)));
	echo "<script>function goto(url){this.location.replace(url);}</script>";
	$Form->cpfooter();
}
elseif ($a == 'doeditservice') //执行编辑服务
{
	$name = $_POST['name'];
	$id = $_POST['id'];
	if (!$name) $Form->oa_exit("请填写服务名称");
	$db->update($db_service,array(
		'name' => $name,
		'fee' => $_POST['fee'],
		'intro' => $_POST['intro'],
		),"`id`={$id}");
	$Form->oa_exit("编辑服务成功","admin.php?j=Config&a=service");
}
elseif ($a == 'delservice') //删除服务
{
	$id = intval($_GET['id']);
	$sql = "select count(*) from ".$db_service." where `id`='".$id."'";
	$num = $db->fetch_one($sql);
	
	if (!($num)) $Form->oa_exit("该服务不存在");

	$db->query("delete from ".$db_service." where `id`='".$id."'");
	$Form->oa_exit("删除服务成功!","admin.php?j=Config&a=service");
}
elseif ($a == 'area') //地区列表
{
	$sql_num = "select count(*) from ".$db_area." where 1";
	$listNum = $db->fetch_one($sql_num);
	$formtitle = "地区 [共".$listNum."个] [{$num_in_page}个/页]";

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
		echo "<td width=\"50%\"><b>地区</b></td>\n";
		echo "<td width=\"50%\"><b>操作</b></td>\n";
		echo "</tr>\n";
		$lstRequest = "select * from ".$db_area." where 1 order by `id` desc limit ".$limitS.",".$num_in_page;
		$vRe = $db->query($lstRequest);
		while($nL = $db->fetch_array($vRe)) 
		{
			echo "<tr align=\"center\">\n";
			echo "<td>".$nL['name']."</td>\n";
			echo "<td align=\"center\"><a href=\"admin.php?j=Config&a=editarea&id=".$nL['id']."\">修改</a> <a href=\"admin.php?j=Config&a=delarea&id=".$nL['id']."\">删除</a></td>\n";
			echo "</tr>\n";
		}
		echo "<tr><td colspan=\"2\" align=\"right\">".$page_char."</td></tr>";
		$Form->formfooter(array(
			"colspan"=>'2',
			"button" => array(
				array('value'=>"添加地区", 'type'=>"button", 'extra' => "onclick=\"goto('admin.php?j=Config&a=addarea')\""),
				array('value'=>"返回", 'type'=>"button", 'extra' => "onclick=\"goto('admin.php?j=Config&a=data')\""),
			)));
		$Form->tablefooter(array("colspan" => "2"));
	}
	else
	{
		$Form->tableheaderbig(array("title" => $formtitle,));
		$Form->maketd(array("暂时没有地区~~"));
		$Form->formfooter(array(
			"colspan"=>'2',
			"button" => array(
				array('value'=>"添加地区", 'type'=>"button", 'extra' => "onclick=\"goto('admin.php?j=Config&a=addarea')\""),
				array('value'=>"返回", 'type'=>"button", 'extra' => "onclick=\"goto('admin.php?j=Config&a=data')\""),
			)));
		$Form->tablefooter();
	}
	echo "<script>function goto(url){this.location.replace(url);}</script>";
	$Form->cpfooter();
}
elseif ($a == 'addarea') //添加地区
{
	$Form->cpheader("添加地区");
	$Form->formheader(array(
		'title' => "添加地区",
		'action' => "admin.php?j=Config&a=doaddarea"
		));
	$Form->makeinput(array(
		'text' => "地区名称",
		'name' => "name",
		'size' => "50",
		));
	$Form->formfooter(array(
		"button" => array(
			array('value'=>"添加"),
			array('value'=>"重置",'type'=>"reset"),
			array('value'=>"返回", 'type'=>"button", 'extra' => "onclick=\"goto('admin.php?j=Config&a=area')\""),
		)));
	echo "<script>function goto(url){this.location.replace(url);}</script>";
	$Form->cpfooter();
}
elseif ($a == 'doaddarea') //执行添加地区
{
	$name = $_POST['name'];
	if (!$name) $Form->oa_exit("请填写地区名称");
	$db->insert($db_area,array(
		'name' => $name,
		));
	$Form->oa_exit("添加地区成功","admin.php?j=Config&a=area");
}
elseif ($a == 'editarea') //编辑地区
{
	if (!isset($_GET['id']))
		$Form->oa_exit("参数错误");
	$id = $_GET['id'];
	$sql_num = "select count(*) from ".$db_area." where `id`=".$id;
	if ($db->fetch_one($sql_num) == 0)
		$Form->oa_exit("不存在这个地区");
	$sql = "select * from ".$db_area." where `id`=".$id;
	$query = $db->query($sql);
	$info = $db->fetch_array($query);
	$Form->cpheader("编辑地区");
	$Form->formheader(array(
		'title' => "编辑地区",
		'action' => "admin.php?j=Config&a=doeditarea"
		));
	$Form->makehidden(array(
		'name' => "id",
		'value' => $id
		));
	$Form->makeinput(array(
		'text' => "地区名称",
		'name' => "name",
		'size' => "50",
		'value' => $info['name'],
		));
	$Form->formfooter(array(
		"button" => array(
			array('value'=>"修改"),
			array('value'=>"重置",'type'=>"reset"),
			array('value'=>"返回", 'type'=>"button", 'extra' => "onclick=\"goto('admin.php?j=Config&a=area')\""),
		)));
	echo "<script>function goto(url){this.location.replace(url);}</script>";
	$Form->cpfooter();
}
elseif ($a == 'doeditarea') //执行编辑地区
{
	$name = $_POST['name'];
	$id = $_POST['id'];
	if (!$name) $Form->oa_exit("请填写地区名称");
	$db->update($db_area,array(
		'name' => $name,
		),"`id`={$id}");
	$Form->oa_exit("编辑地区成功","admin.php?j=Config&a=area");
}
elseif ($a == 'delarea') //删除地区
{
	$id = intval($_GET['id']);
	$sql = "select count(*) from ".$db_area." where `id`='".$id."'";
	$num = $db->fetch_one($sql);
	
	if (!($num)) $Form->oa_exit("该地区不存在");

	$db->query("delete from ".$db_area." where `id`='".$id."'");
	$Form->oa_exit("删除地区成功!","admin.php?j=Config&a=area");
}
elseif ($a == 'degree') //学历列表
{
	$sql_num = "select count(*) from ".$db_degree." where 1";
	$listNum = $db->fetch_one($sql_num);
	$formtitle = "学历 [共".$listNum."个] [{$num_in_page}个/页]";

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
		echo "<td width=\"50%\"><b>学历</b></td>\n";
		echo "<td width=\"50%\"><b>操作</b></td>\n";
		echo "</tr>\n";
		$lstRequest = "select * from ".$db_degree." where 1 order by `id` desc limit ".$limitS.",".$num_in_page;
		$vRe = $db->query($lstRequest);
		while($nL = $db->fetch_array($vRe)) 
		{
			echo "<tr align=\"center\">\n";
			echo "<td>".$nL['name']."</td>\n";
			echo "<td align=\"center\"><a href=\"admin.php?j=Config&a=editdegree&id=".$nL['id']."\">修改</a> <a href=\"admin.php?j=Config&a=deldegree&id=".$nL['id']."\">删除</a></td>\n";
			echo "</tr>\n";
		}
		echo "<tr><td colspan=\"2\" align=\"right\">".$page_char."</td></tr>";
		$Form->formfooter(array(
			"colspan"=>'2',
			"button" => array(
				array('value'=>"添加学历", 'type'=>"button", 'extra' => "onclick=\"goto('admin.php?j=Config&a=adddegree')\""),
				array('value'=>"返回", 'type'=>"button", 'extra' => "onclick=\"goto('admin.php?j=Config&a=data')\""),
			)));
		$Form->tablefooter(array("colspan" => "2"));
	}
	else
	{
		$Form->tableheaderbig(array("title" => $formtitle,));
		$Form->maketd(array("暂时没有学历~~"));
		$Form->formfooter(array(
			"colspan"=>'2',
			"button" => array(
				array('value'=>"添加学历", 'type'=>"button", 'extra' => "onclick=\"goto('admin.php?j=Config&a=adddegree')\""),
				array('value'=>"返回", 'type'=>"button", 'extra' => "onclick=\"goto('admin.php?j=Config&a=data')\""),
			)));
		$Form->tablefooter();
	}
	echo "<script>function goto(url){this.location.replace(url);}</script>";
	$Form->cpfooter();
}
elseif ($a == 'adddegree') //添加学历
{
	$Form->cpheader("添加学历");
	$Form->formheader(array(
		'title' => "添加学历",
		'action' => "admin.php?j=Config&a=doadddegree"
		));
	$Form->makeinput(array(
		'text' => "学历名称",
		'name' => "name",
		'size' => "50",
		));
	$Form->formfooter(array(
		"button" => array(
			array('value'=>"添加"),
			array('value'=>"重置",'type'=>"reset"),
			array('value'=>"返回", 'type'=>"button", 'extra' => "onclick=\"goto('admin.php?j=Config&a=degree')\""),
		)));
	echo "<script>function goto(url){this.location.replace(url);}</script>";
	$Form->cpfooter();
}
elseif ($a == 'doadddegree') //执行添加学历
{
	$name = $_POST['name'];
	if (!$name) $Form->oa_exit("请填写学历名称");
	$db->insert($db_degree,array(
		'name' => $name,
		));
	$Form->oa_exit("添加学历成功","admin.php?j=Config&a=degree");
}
elseif ($a == 'editdegree') //编辑学历
{
	if (!isset($_GET['id']))
		$Form->oa_exit("参数错误");
	$id = $_GET['id'];
	$sql_num = "select count(*) from ".$db_degree." where `id`=".$id;
	if ($db->fetch_one($sql_num) == 0)
		$Form->oa_exit("不存在这个学历");
	$sql = "select * from ".$db_degree." where `id`=".$id;
	$query = $db->query($sql);
	$info = $db->fetch_array($query);
	$Form->cpheader("编辑学历");

	$Form->formheader(array(
		'title' => "编辑学历",
		'action' => "admin.php?j=Config&a=doeditdegree"
		));
	$Form->makehidden(array(
		'name' => "id",
		'value' => $id
		));
	$Form->makeinput(array(
		'text' => "学历名称",
		'name' => "name",
		'size' => "50",
		'value' => $info['name'],
		));
	$Form->formfooter(array(
		"button" => array(
			array('value'=>"修改"),
			array('value'=>"重置",'type'=>"reset"),
			array('value'=>"返回", 'type'=>"button", 'extra' => "onclick=\"goto('admin.php?j=Config&a=degree')\""),
		)));
	echo "<script>function goto(url){this.location.replace(url);}</script>";
	$Form->cpfooter();
}
elseif ($a == 'doeditdegree') //执行编辑学历
{
	$name = $_POST['name'];
	$id = $_POST['id'];
	if (!$name) $Form->oa_exit("请填写学历名称");
	$db->update($db_degree,array(
		'name' => $name,
		),"`id`={$id}");
	$Form->oa_exit("编辑学历成功","admin.php?j=Config&a=degree");
}
elseif ($a == 'deldegree') //删除学历
{
	$id = intval($_GET['id']);
	$sql = "select count(*) from ".$db_degree." where `id`='".$id."'";
	$num = $db->fetch_one($sql);
	
	if (!($num)) $Form->oa_exit("该学历不存在");

	$db->query("delete from ".$db_degree." where `id`='".$id."'");
	$Form->oa_exit("删除学历成功!","admin.php?j=Config&a=degree");
}
elseif ($a == 'index') //首页设置
{
	$config_sql = "select * from ".$db_config." where 1";
	$query = $db->query($config_sql);
	$config = $db->fetch_array($query);

	$Form->cpheader("首页设置");
	$Form->formheader(array(
		'title' => "首页设置",
		'action' => "admin.php?j=Config&a=doindex",
		));
	$Form->maketd(array(
		"<b>导航条设置</b>",
		'<a href="admin.php?j=Config&a=nav">编辑</a>',
		));
	$Form->maketextarea(array(
		'text' => "页脚设置",
		'name' => "footer",
		'value' => $config['footer'],
		));
	$Form->formfooter(array(
		"button" => array(
			array('value'=>"确定"),
			array('value'=>"重置",'type'=>"reset"),
		)));
}
elseif ($a == 'doindex') //执行首页设置
{
	$db->update($db_config, array(
		'footer' => $_POST['footer'],
		), "`id`=1");
	$Form->oa_exit("成功设置首页", "admin.php?j=Config&a=index");
}
elseif ($a == 'nav') //导航条列表
{
	$sql_num = "select count(*) from ".$db_nav." where 1";
	$listNum = $db->fetch_one($sql_num);
	$formtitle = "导航条选项";

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
		echo "<td width=\"10%\"><b>名称</b></td>\n";
		echo "<td width=\"30%\"><b>链接</b></td>\n";
		echo "<td width=\"55%\"><b>简介</b></td>\n";
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
		echo "<tr><td colspan=\"4\" align=\"center\"><input class=\"button\" accesskey=\"\" type=\"submit\" name=\"\" value=\"编辑\" />";
		echo "\n</td></tr></form></table>\n";
	}
	else
	{
		$Form->tableheaderbig(array("title" => $formtitle,));
		$Form->maketd(array("暂时没有导航条选项~~"));
		$Form->tablefooter();
	}
	$Form->cpfooter();
}
elseif ($a == 'editnav') //编辑导航条
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
	$Form->oa_exit("编辑成功","admin.php?j=Config&a=index");
}
else
{
	$Form->oa_exit("功能不存在","index.php?a=main");
}
?>