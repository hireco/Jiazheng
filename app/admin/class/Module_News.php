<?php
/*
新闻功能模块
========
需要的类：config.php forms.php class_DataBase.php SmartTemplate class_User.php
========
主要功能：（$a == ）
--------------------
add 添加新闻 doadd 执行添加
list 新闻列表
show 查看新闻 check 审批新闻 docheck 执行审批新闻
edit 编辑新闻 doedit 执行编辑新闻

comment 评论列表	delcomment 删除评论

addsort 添加新闻栏目 doaddsort 执行添加新闻栏目
editsort 编辑新闻栏目 doeditsort 执行编辑新闻栏目
sort 新闻栏目管理
ordersort 栏目重新排序
activesort 栏目重新激活
disactivesort 栏目屏蔽
delsort 栏目删除

attachment 新闻附件中心
attlist 附件列表
attupload 附件上传
attdelete 附件删除
attupdate 附件修改

附加功能 (function)
-------------------
state_addlink 这个主要是为了使操作更人性化，对新闻操作完成时方便返回到原列表
build_sorts_cache 这个是给分类建立缓存

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
$db_news = "`".$mysql_prefix."article`"; //新闻数据表
$db_pic =  "`".$mysql_prefix."picture`"; //图片数据表
$db_sort =  "`".$mysql_prefix."sort`"; //分类数据表
$db_comment = "`".$mysql_prefix."comment`"; //评论数据表
$sortsfor = 'news';//这里表示分类只服务新闻，可能有点难懂~~
$imgPath = "../attachment/news/"; //附件上传目录
$sortscache = "class/cache/news_sorts.php";//新闻分类缓存
$num_in_page = 20;  //每页显示数目
$att_every = 5; //每行附件个数

$allow = array();

switch($usr->rights['News'])
{
case 'S':  //超级管理员
	$allow = array(
		'add' => 2, 'doadd' => 2, 'list' => 2, 'show' => 2, 'check' => 2, 'docheck' => 2, 'edit' => 2, 'doedit' => 2,
		'comment' => 2, 'delcomment' => 2,
		'search' => 2, 'dosearch' => 2,
		'addsort' => 2, 'doaddsort' => 2, 'editsort' => 2, 'doeditsort' => 2, 'sort' => 2, 'ordersort' => 2, 'activesort' => 2, 'disactivesort' => 2, 'delsort' => 2,
		'attachment' => 2, 'attlist' => 2, 'attupload' => 2, 'attdelete' => 2, 'attupdate' => 2,
		);
	break;
case 'A':  //一级管理员
	$allow = array(
		'add' => 2, 'doadd' => 2, 'list' => 2, 'show' => 2, 'check' => 2, 'docheck' => 2, 'edit' => 2, 'doedit' => 2,
		'comment' => 2, 'delcomment' => 2,
		'search' => 2, 'dosearch' => 2,
		'addsort' => 0, 'doaddsort' => 0, 'editsort' => 0, 'doeditsort' => 0, 'sort' => 0, 'ordersort' => 0, 'activesort' => 0, 'disactivesort' => 0, 'delsort' => 0,
		'attachment' => 2, 'attlist' => 2, 'attupload' => 2, 'attdelete' => 2, 'attupdate' => 2,
		);
	break;
case 'M':  //二级管理员
	$allow = array(
		'add' => 2, 'doadd' => 2, 'list' => 1, 'show' => 2, 'check' => 0, 'docheck' => 0, 'edit' => 1, 'doedit' => 1,
		'comment' => 0, 'delcomment' => 0,
		'search' => 1, 'dosearch' => 1,
		'addsort' => 0, 'doaddsort' => 0, 'editsort' => 0, 'doeditsort' => 0, 'sort' => 0, 'ordersort' => 0, 'activesort' => 0, 'disactivesort' => 0, 'delsort' => 0,
		'attachment' => 2, 'attlist' => 2, 'attupload' => 2, 'attdelete' => 1, 'attupdate' => 2,
		);
	break;
default:  //无权限
	$allow = array(
		'add' => 0, 'doadd' => 0, 'list' => 0, 'show' => 0, 'check' => 0, 'docheck' => 0, 'edit' => 0, 'doedit' => 0,
		'comment' => 0, 'delcomment' => 0,
		'search' => 0, 'dosearch' => 0,
		'addsort' => 0, 'doaddsort' => 0, 'editsort' => 0, 'doeditsort' => 0, 'sort' => 0, 'ordersort' => 0, 'activesort' => 0, 'disactivesort' => 0, 'delsort' => 0,
		'attachment' => 0, 'attlist' => 0, 'attupload' => 0, 'attdelete' => 0, 'attupdate' => 0,
		);
	break;
}

if (!($allow[$a] > 0)) $Form->oa_exit("你没有权限执行该操作~~");
$sortname_short = array();
$sortname_all = array();

if (!file_exists($sortscache)) 	build_sorts_cache($db_sort,$sortscache);

include($sortscache);

if ($a == 'add')  //快速撰写
{
	$Form->cpheader("添加文章");
	$Form->formheader(array(
		'title' => "添加文章",
		'action' => "admin.php?j=News&a=doadd"
		));
	$Form->makeselect(array(
		'text' => "栏目",
		'name' => "sortid",
		'option' => $sortname_all));
	$Form->makeinput(array(
		'text' => "标题",
		'name' => "title",
		'size' => "50"
		));
	$Form->makeinput(array(
		'text' => "来源",
		'name' => "source",
		));
	$Form->makeinput(array(
		'text' => "标签",
		'name' => "tags",
		'size' => "50"
		));
	$Form->maketextarea(array(
		'text' => "正文",
		'name' => "content",
		'cols' => "600",
		'rows' => "400",
		));
	$Form->makeselect(array(
		'text' => "是否允许评论",
		'name' => "comment",
		'option' => array("否", "是"),
		'selected' => 1,
		));
	$Form->formfooter(array(
		"button" => array(
			array('value'=>"下一步"),
			array('value'=>"重置",'type'=>"reset"),
		)));
	$Form->cpfooter();
}
elseif ($a == 'doadd')  //执行快速撰写
{
	$title = checkStr($_POST['title']);
	if (!$title) $Form->oa_exit("请填写新闻标题名称");
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
	$Form->oa_exit("文章录入成功,请添加相关图片","admin.php?j=News&a=attachment&id=".$db->insert_id());
}
elseif ($a == 'list') //新闻列表
{
	$condition = "1";
	$state_addlink = "";
	$status = array("<font color=red>待审</font>","<font color=green>通过</font>","<font color=blue>置顶</font>");
	$istop = array("","Yes");
	$statetitle = "全部新闻";
	$listaction = 'check';

	if (isset($_GET['state']))
	{
		$state =  intval($_GET['state']);
		if ($state >= 0 && $state <= 3)
		{
			$condition = "`show`='".$state."'";
			$state_addlink = "&state=".$state;
			$statetitle = $status[$state]."新闻";
		}
	}
	if ($allow['list'] == 1)
	{
		$statetitle = "我的".$statetitle;
		$condition .= " and `author`='".$username."'";
		$listaction = "show";
	}
	$sql_num = "select count(*) from ".$db_news." where {$condition}";
	$listNum = $db->fetch_one($sql_num);
	$formtitle = "{$statetitle} [共".$listNum."条] [{$num_in_page}条/页]";

	$cpage = isset($_GET['page']) ? intval($_GET['page']) : 1;
	$page_char = page($listNum,$num_in_page,$cpage,"admin.php?j=News&a=list{$state_addlink}");
	$limitS = $cpage*$num_in_page-$num_in_page;

	$Form->cpheader();
	$Form->tableheaderbig();
	$Form->maketd(array("<b>请选择列表类别</b>: <a href=\"admin.php?j=News&a=list\">全部</a> <a href=\"admin.php?j=News&a=list&state=0\">待审</a> <a href=\"admin.php?j=News&a=list&state=1\">通过</a> <a href=\"admin.php?j=News&a=list&state=2\">置顶</a>"));
	$Form->tablefooter();

	if($listNum > 0)
	{
		$Form->tableheaderbig(array(
			"title" => $formtitle,
			"colspan" => "8",
		));
		echo "<tr align=\"center\">\n";
		echo "<td width=\"6%\"><b>置顶</b></td>\n";
		echo "<td width=\"6%\"><b>状态</b></td>\n";
		echo "<td width=\"27%\"><b>文章标题</b></td>\n";
		echo "<td width=\"9%\"><b>文章评论</b></td>\n";
		echo "<td width=\"9%\"><b>文章附件</b></td>\n";
		echo "<td width=\"12%\"><b>文章栏目</b></td>\n";
		echo "<td width=\"10%\"><b>录入者</b></td>\n";
		echo "<td width=\"15%\"><b>时间</b></td>\n";
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
			echo "<td><a href=\"admin.php?j=News&a=comment&id={$nL['id']}{$state_addlink}\">查看[{$comnum}]</a></td>\n";
			echo "<td><a href=\"admin.php?j=News&a=attachment&id={$nL['id']}{$state_addlink}\">查看[{$attnum}]</a></td>\n";
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
		$Form->maketd(array("暂时没有本类新闻~~"));
		$Form->tablefooter();
	}
	$Form->cpfooter();
}
elseif ($a == 'show')  //查看新闻（貌似已荒废）
{
	$id = intval($_GET['id']);
	$sql_news = "select * from ".$db_news." where `id`='".$id."' and `author`='".$username."'";
	$nL = $db->fetch_one_array($sql_news);
	
	if (empty($nL)) $Form->oa_exit("该新闻不存在或你没有权限查看");


	$status = array("<font color=red>待审</font>","<font color=green>通过</font>","<font color=blue>置顶</font>");
	$sortid = $nL['sort'];
	$istop = array("","Yes");
	$Form->cpheader("查看新闻");
	$Form->formheader(array(
		'title' => "查看新闻",
		'method' => "GET",
		'action' => "admin.php".state_addlink()
		));
	$Form->makehidden(array('name' => "j",'value' => 'News'));
	$Form->makehidden(array('name' => "a",'value' => 'edit'));
	$Form->makehidden(array('name' => "id",'value' => $id));
	$Form->maketd(array(
		"<b>栏目</b>",
		$sortname_short[$sortid]."—".$sortname_all[$sortid],
		));
	$Form->maketd(array(
		"<b>标题</b>",
		$nL['title'],
		));
	$Form->maketd(array(
		"<b>原作者</b>",
		$nL['source'],
		));
	$Form->maketd(array(
		"<b>Tags</b>",
		deal_tags($nL['tag'],1),
		));
	echo "<tr nowrap>";
	echo "<td width=\"12%\" valign=\"top\"><b>正文</b></td>";
	echo "<td width=\"78%\">".$nL['content']."</td>";
	echo "</tr>\n";
	$Form->maketd(array(
		"<b>预览</b>",
		"<a href=\"../news.php?id={$id}\" target=\"_blank\">点击预览</a>",
		));
	$Form->maketd(array(
		"<b>状态</b>",
		$status[$nL['show']],
		));
	$Form->maketd(array(
		"<b>置顶</b>",
		$istop[$nL['top']],
		));
	if ($nL['show'] < 1)
	{
		$Form->formfooter(array(
			"button" => array(
				array('value'=>"编辑"),
				array('value'=>"返回", 'type'=>"button", 'extra' => "onclick=\"goto('admin.php?j=News&a=list".state_addlink()."')\""),
			)));
	}
	else
	{
		$Form->formfooter(array(
			"button" => array(
				array('value'=>"返回", 'type'=>"button", 'extra' => "onclick=\"goto('admin.php?j=News&a=list".state_addlink()."')\""),
			)));
	}
	echo "<script>function goto(url){this.location.replace(url);}</script>";
	$Form->cpfooter();
}
elseif ($a == 'check')  //审批新闻
{
	$id = intval($_GET['id']);
	$sql_news = "select * from ".$db_news." where `id`='".$id."'";
	$nL = $db->fetch_one_array($sql_news);
	
	if (empty($nL)) $Form->oa_exit("该新闻不存在");

	$sortid = intval($nL['sort']);
	$comment = array("否", "是");
	$Form->cpheader("审批新闻");
	$Form->formheader(array(
		'title' => "审批新闻",
		'action' => "admin.php?j=News&a=docheck".state_addlink()
		));
	$Form->makehidden(array(
		'name' => "id",
		'value' => $id
		));
	$Form->maketd(array(
		"<b>栏目</b>",
		$sortname_short[$sortid]."—".$sortname_all[$sortid],
		));
	$Form->maketd(array(
		"<b>标题</b>",
		$nL['title'],
		));
	$Form->maketd(array(
		"<b>原作者</b>",
		$nL['source'],
		));
	$Form->maketd(array(
		"<b>Tags</b>",
		deal_tags($nL['tag'],1),
		));
	echo "<tr nowrap>";
	echo "<td width=\"12%\" valign=\"top\"><b>正文</b></td>";
	echo "<td width=\"78%\">".$nL['content']."</td>";
	echo "</tr>\n";
	$Form->maketd(array(
		"<b>是否允许评论</b>",
		$comment[$nL['comment']],
		));
	$Form->maketd(array(
		"<b>预览</b>",
		"<a href=\"../news.php?id={$id}\" target=\"_blank\">点击预览</a>",
		));
	$Form->makeselect(array(
		'option' => array('待审','通过'),
		'text' => "审批",
		'name' => "state",
		'selected' => $nL['show']));
	$Form->makeyesno(array(
		'text' => "置顶",
		'name' => "istop",
		'selected' => $nL['top']));
	$Form->formfooter(array(
		"button" => array(
			array('value'=>"审批"),
			array('value'=>"编辑",'type'=>"button",'extra' => "onclick=\"goto('admin.php?j=News&a=edit&id={$id}".state_addlink()."')\""),
			array('value'=>"返回", 'type'=>"button", 'extra' => "onclick=\"goto('admin.php?j=News&a=list".state_addlink()."')\""),
		)));
	echo "<script>function goto(url){this.location.replace(url);}</script>";
	$Form->cpfooter();
}
elseif ($a == 'docheck')  //执行审批新闻
{
	if (!isset($_POST['id'])) $Form->oa_exit("参数错误");
	$id = intval($_POST['id']);

	$sql_news = "select count(*) from ".$db_news." where `id`='".$id."'";
	if ($db->fetch_one($sql_news)==0) $Form->oa_exit("新闻不存在");

	$db->update($db_news,array(
		'show' => intval($_POST['state']),
		'top' => intval($_POST['istop']),
		'checker' => $username,
		'checkip' => getip(),
		),"`id`={$id}");
	$Form->oa_exit("新闻审批成功","admin.php?j=News&a=list".state_addlink());
}
elseif ($a == 'edit')  //编辑新闻
{
	$id = intval($_GET['id']);
	if ($allow['edit'] == 2) 
		$sql_news = "select * from ".$db_news." where `id`='".$id."'";
	else
		$sql_news = "select * from ".$db_news." where `id`='".$id."' and `submiter`='".$username."' and `state` < 2";

	$nL = $db->fetch_one_array($sql_news);
	if (empty($nL)) $Form->oa_exit("该新闻不存在或你没有权限编辑该新闻");

	$Form->cpheader("编辑新闻");
	$Form->formheader(array(
		'title' => "编辑新闻",
		'action' => "admin.php?j=News&a=doedit".state_addlink()
		));
	$Form->makehidden(array(
		'name' => "id",
		'value' => $id
		));
	$Form->makeselect(array(
		'option' => $sortname_all,
		'text' => "栏目",
		'name' => "sortid",
		'selected' => $nL['sort']
		));
	$Form->makeinput(array(
		'text' => "标题",
		'name' => "title",
		'size' => "50",
		'value' => $nL['title']
		));
	$Form->makeinput(array(
		'text' => "原作者",
		'name' => "author",
		'value' => $nL['source']
		));
	$Form->makeinput(array(
		'text' => "标签",
		'name' => "tags",
		'size' => "50",
		'value' => deal_tags($nL['tag'],1),
		));
	$Form->maketextarea(array(
		'text' => "正文",
		'name' => "content",
		'cols' => "600",
		'rows' => "400",
		'value' => $nL['content']
		));
	$Form->makeselect(array(
		'option' => array('否','是'),
		'text' => "是否允许评论",
		'name' => "comment",
		'selected' => $nL['comment']));
	if ($allow['check'] == 2)
	{
		$Form->makeselect(array(
			'option' => array('待审','通过'),
			'text' => "审批",
			'name' => "state",
			'selected' => $nL['show']));
		$Form->makeyesno(array(
			'text' => "置顶",
			'name' => "istop",
			'selected' => $nL['istop']));
	}
	$Form->formfooter(array(
		"button" => array(
			array('value'=>"保存"),
			array('value'=>"重置", 'type'=>"reset"),
			array('value'=>"返回", 'type'=>"button", 'extra' => "onclick=\"goto('admin.php?j=News&a=list".state_addlink()."')\""),
		)));
	echo "<script>function goto(url){this.location.replace(url);}</script>";
	$Form->tablefooter();
	$Form->cpfooter();
}
elseif ($a == 'doedit')  //执行编辑新闻
{
	if (!isset($_POST['id'])) $Form->oa_exit("参数错误");
	$id = intval($_POST['id']);
	$title = checkStr($_POST['title']);

	if ($allow['edit'] == 2) 
		$sql_news = "select * from ".$db_news." where `id`='".$id."'";
	else
		$sql_news = "select * from ".$db_news." where `id`='".$id."' and `submiter`='".$username."' and `state` < 1";

	$nL = $db->fetch_one_array($sql_news);
	if (empty($nL)) $Form->oa_exit("该新闻不存在或你没有权限编辑该新闻");

	if (!$title) $Form->oa_exit("请填写新闻标题名称");
	
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
	$Form->oa_exit("新闻编辑成功","admin.php?j=News&a=list".state_addlink());
}
elseif ($a == 'comment') //评论列表
{
	if (!isset($_GET['id']))
	{
		$Form->oa_exit("参数错误");
	}
	else
	{
		$id = $_GET['id'];
	}
	$statetitle = "评论列表";
	$sql_num = "select count(*) from ".$db_comment." where `aid`=".$id;
	$listNum = $db->fetch_one($sql_num);
	$formtitle = "{$statetitle} [共".$listNum."条] [{$num_in_page}条/页]";

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
		echo "<td width=\"60%\"><b>内容</b></td>\n";
		echo "<td width=\"15%\"><b>IP</b></td>\n";
		echo "<td width=\"15%\"><b>时间</b></td>\n";
		echo "<td width=\"10%\"><b>操作</b></td>\n";
		echo "</tr>\n";
		$lstRequest = "select * from ".$db_comment." where `aid`={$id} order by `time` desc limit ".$limitS.",".$num_in_page;
		$vRe = $db->query($lstRequest);
		while($nL = $db->fetch_array($vRe)) 
		{
			echo "<tr align=\"center\">\n";
			echo "<td>".str2html($nL['content'])."</td>\n";
			echo "<td>".$nL['ip']."</td>\n";
			echo "<td>".date('y-m-d H:i',$nL['time'])."</td>\n";
			echo "<td align=\"center\"><a href=\"admin.php?j=News&a=delcomment&id=".$nL['id']."\">删除</a></td>\n";
			echo "</tr>\n";
		}
		echo "<tr><td colspan=\"5\" align=\"right\">".$page_char."</td></tr>";
		$Form->tablefooter(array("colspan" => "5"));
	}
	else
	{
		$Form->tableheaderbig(array("title" => $formtitle,));
		$Form->maketd(array("此文章暂时没有评论~~"));
		$Form->tablefooter();
	}
	$Form->cpfooter();
}
elseif ($a == 'delcomment') //删除评论
{
}
elseif ($a == 'search') //搜索新闻
{
	$Form->cpheader("搜索新闻");
	$Form->formheader(array(
		'title' => "搜索新闻",
		'action' => "admin.php?j=News&a=dosearch".state_addlink()
		));
	$Form->makeselect(array(
		'text' => "栏目",
		'name' => "sortid",
		'option' => $sortname_all));
	$Form->makeinput(array(
		'text' => "标题",
		'name' => "title",
		'size' => "50"
		));
	$Form->makeinput(array(
		'text' => "作者",
		'name' => "author",
		));
	$Form->makeinput(array(
		'text' => "来源",
		'name' => "source",
		));
	$Form->makeinput(array(
		'text' => "标签",
		'name' => "tag",
		));
/*	$Form->makeinput(array(
		'text' => "正文",
		'name' => "content",
		));*/
	$Form->formfooter(array(
		"button" => array(
			array('value'=>"搜索"),
			array('value'=>"重置",'type'=>"reset"),
		)));
	$Form->cpfooter();
}
elseif ($a == 'dosearch') //执行搜索新闻
{
	$search = array(
		'sort' => intval($_REQUEST['sortid']),
		'title' => checkStr($_REQUEST['title']),
		'author' => checkStr($_REQUEST['author']),
		'source' => checkStr($_REQUEST['source']),
		'tag' => checkStr($_REQUEST['tag']),
		'permission' => $allow['dosearch'],
	);
	$status = array("<font color=red>待审</font>","<font color=green>通过</font>","<font color=blue>置顶</font>");
	$istop = array("","Yes");
	$statetitle = "搜索结果";
	$state_addlink = "&sort=".$sort."&title=".$title."&author=".$author."&source=".$source."&tag=".$tag;
	$condition = make_condition($search);
	$sql_num = "select count(*) from ".$db_news." where {$condition}";
	$listNum = $db->fetch_one($sql_num);
	$formtitle = "{$statetitle} [共".$listNum."条] [{$num_in_page}条/页]";

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
		echo "<td width=\"6%\"><b>置顶</b></td>\n";
		echo "<td width=\"6%\"><b>状态</b></td>\n";
		echo "<td width=\"30%\"><b>文章标题</b></td>\n";
		echo "<td width=\"6%\"><b>文章评论</b></td>\n";
		echo "<td width=\"9%\"><b>文章附件</b></td>\n";
		echo "<td width=\"12%\"><b>文章栏目</b></td>\n";
		echo "<td width=\"10%\"><b>录入者</b></td>\n";
		echo "<td width=\"15%\"><b>时间</b></td>\n";
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
			echo "<td><a href=\"admin.php?j=News&a=comment&id={$nL['id']}{$state_addlink}\">查看[{$attnum}]</a></td>\n";
			echo "<td><a href=\"admin.php?j=News&a=attachment&id={$nL['id']}{$state_addlink}\">查看[{$attnum}]</a></td>\n";
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
		$Form->maketd(array("暂时没有本类新闻~~"));
		$Form->tablefooter();
	}
	$Form->cpfooter();
}
elseif ($a == 'addsort') //添加新闻栏目
{
	$default_order = $db->fetch_one("select max(`order`) from {$db_sort}") + 1;
	$Form->cpheader();
	$Form->formheader(array(
		'title' => "添加栏目",
		'action' => "admin.php?j=News&a=doaddsort"
		));
	$Form->makehidden(array(
		'name' => "for",
		'value' => "news"
		));
	$Form->makeinput(array(
		'name' => "order",
		'text' => "顺序",
		'note' => "数字越小排序越靠前",
		'value' => $default_order
		));
	$Form->makeinput(array(
		'name' => "short",
		'text' => "简称",
		'note' => "栏目简称,建议使用两个字"
		));
	$Form->makeinput(array(
		'name' => "sortname",
		'text' => "全称",
		'note' => "栏目的全称"
		));
	$Form->formfooter();
	$Form->cpfooter();
}
elseif ($a == 'doaddsort') //执行添加新闻栏目
{
	if (!isset($_POST['for'])) $Form->oa_exit("参数错误~");
	$short = checkStr($_POST['short']);
	$sortname = checkStr($_POST['sortname']);
	if (!$short) $Form->oa_exit("请填写新闻栏目简称");
	if (!$sortname) $Form->oa_exit("请填写新闻栏目全称");
	$sql = "select count(*) from {$db_sort} where `short`='{$short}' or `name`='{$sortname}'";
	if ($db->fetch_one($sql) > 0) $Form->oa_exit("栏目简称或全称已经存在!");
	$db->insert($db_sort,array(
		'order' => intval($_POST['order']),
		'short' => $short,
		'name' => $sortname,
		'visible' => 1
		));
	build_sorts_cache($db_sort,$sortscache);
	$Form->oa_exit("添加新闻栏目成功","admin.php?j=News&a=sort");
}
elseif ($a == 'editsort') //编辑新闻栏目
{
	$id = intval($_GET['id']);
	$sql = "select * from ".$db_sort." where `id`='".$id."'";
	$sL = $db->fetch_one_array($sql);
	if (empty($sL)) $Form->oa_exit("该新闻栏目不存在");

	$Form->cpheader();
	$Form->formheader(array(
		'title' => "编辑栏目",
		'action' => "admin.php?j=News&a=doeditsort",
		));
	$Form->makehidden(array(
		'name' => "id",
		'value' => $id,
		));
	$Form->makeinput(array(
		'name' => "order",
		'text' => "顺序",
		'note' => "数字越小排序越靠前",
		'value' => $sL['order']
		));
	$Form->makeinput(array(
		'name' => "short",
		'text' => "简称",
		'note' => "建议使用两个字",
		'value' => $sL['short']
		));
	$Form->makeinput(array(
		'name' => "sortname",
		'text' => "全称",
		'note' => "栏目的全称",
		'value' => $sL['name']
		));
	$Form->formfooter();
	$Form->cpfooter();
}
elseif ($a == 'doeditsort') //执行编辑新闻栏目
{
	if (!isset($_POST['id'])) $Form->oa_exit("参数错误~");
	$sortname = checkStr($_POST['sortname']);
	$short = checkStr($_POST['short']);
	$id = intval($_POST['id']);
	if (!$sortname) $Form->oa_exit("请填写新闻栏目全称");

	$sql = "select count(*) from {$db_sort} where (`short`='{$short}' or `name`='{$name}') and `id`!={$id}";
	if ($db->fetch_one($sql) > 0) $Form->oa_exit("栏目的简称或全称已经存在!");
	$db->update($db_sort,array(
		'order' => intval($_POST['order']),
		'short' => $short,
		'name' => $sortname,
		),"`id`={$id}");
	build_sorts_cache($db_sort,$sortscache);
	$Form->oa_exit("编辑新闻栏目成功","admin.php?j=News&a=sort");
}
elseif ($a == 'sort') //新闻栏目管理
{
	$sql = "select * from ".$db_sort." order by `visible` desc, `order` asc";
	$query = $db->query($sql);
	$Form->cpheader();
	$Form->formheader(array(
		'title' => "分类管理中心",
		'colspan' => 3,
		'action' => "admin.php?j=News&a=ordersort",
		));
	$Form->maketd(array('顺序','栏目(简称—全称)','操作'));
	while ($sL = $db->fetch_array($query))
	{
		if ($sL['visible'])
		{
			$Form->maketd(array(
				"<input type=\"text\" size=\"5\" name=\"sort[".$sL['id']."]\" value=\"".$sL['order']."\">",
				$sL['short'].'—'.$sL['name'],
				"[<a href=\"admin.php?j=News&a=editsort&id=".$sL['id']."\">编辑</a>] [<a href=\"admin.php?j=News&a=disactivesort&id=".$sL['id']."\">屏蔽</a>] [<a href=\"admin.php?j=News&a=delsort&id=".$sL['id']."\">删除</a>]"));
		}
		else
		{
			$Form->maketd(array(
				"已屏蔽",
				$sL['short'].'—'.$sL['name'],
				"[<a href=\"admin.php?j=News&a=activesort&id=".$sL['id']."\">激活</a>] [<a href=\"admin.php?j=News&a=delsort&id=".$sL['id']."\">删除</a>]"));
		}
	}

	$Form->formfooter(array('colspan' => 3, "button" =>array("submit"=>array("value"=>"更新排序"))));
	$Form->cpfooter();
}
elseif ($a == 'ordersort') //栏目重新排序
{
	$sort = $_POST['sort'];
	foreach($sort as $key=>$val) 
	{
		$db->update($db_sort,array(
			'order' => $val
			),"`id` = $key");
	}
	build_sorts_cache($db_sort,$sortscache);
	$Form->oa_exit("分类排序已经更新","admin.php?j=News&a=sort");
}
elseif ($a == 'activesort') //栏目重新激活
{
	if (!isset($_GET['id'])) $Form->oa_exit("参数错误");
	$id = intval($_GET['id']);
	$db->update($db_sort,array('visible' => 1),"`id`={$id}");
	build_sorts_cache($db_sort,$sortscache);
	$Form->oa_exit("新闻栏目成功激活","admin.php?j=News&a=sort");
}
elseif ($a == 'disactivesort') //栏目屏蔽
{
	if (!isset($_GET['id'])) $Form->oa_exit("参数错误");
	$id = intval($_GET['id']);
	$db->update($db_sort,array('visible' => 0),"`id`={$id}");
	build_sorts_cache($db_sort,$sortscache);
	$Form->oa_exit("新闻栏目成功屏蔽","admin.php?j=News&a=sort");
}
elseif ($a == 'delsort') //栏目删除
{
	if (!isset($_GET['id'])) $Form->oa_exit("参数错误");
	$id = intval($_GET['id']);
	$num = $db->fetch_one("select count(*) from {$db_news} where `sort`='".$id."'");
	if ($num)
	{
		$Form->oa_exit("新闻栏目非空!!");
	}
	else
	{
		$sql = "delete from {$db_sort} where `id`={$id}";
		$db->query($sql);
		build_sorts_cache($db_sort,$sortscache);
		$Form->oa_exit("新闻栏目成功删除","admin.php?j=News&a=sort");
	}
}
//以下是新闻附件
elseif ($a == 'attachment')  //新闻附件中心
{
	$id = intval($_GET['id']);
	$sql_news = "select * from ".$db_news." where `id`='".$id."'";
	$nL = $db->fetch_one_array($sql_news);
	switch ($id)
	{
	case -2:
		$nL['title'] = "非图片附件";
		break;
	case -1:
		$nL['title'] = "全部附件";
		break;
	case 0:
		$nL['title'] = "未使用附件";
		break;
	default:
	}
	if (empty($nL)) $Form->oa_exit("找不到该新闻");
	$Form->cpheader("新闻附件管理");
	if ($nL['show'] < 1)
	{
		$Form->formheader(array(
			'title' => "新闻附件管理中心——{$nL['title']}",
			'action' => "admin.php?j=News&a=attupload",
			'target' => "attlist",
			'enctype' => "multipart/form-data"
			));
	}
	else
	{
		$Form->tableheaderbig(array(
			'title' => "新闻附件管理中心——{$nL['title']}",
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
			'text' => "附件说明",
			'name' => "intro",
			'size' => "60"
			));
		$Form->makefile(array(
			'text' => "附件上传",
			'name' => "file",
			'size' => "50"
			));
		echo "<tr nowrap>";
		echo "<td colspan=\"2\" align=\"center\"><input class=\"button\" type=\"submit\" value=\"上传\"> <input class=\"button\" type=\"button\" value=\"完成\" onclick=\"goto('admin.php?j=News&a=list".state_addlink()."')\"></td>";
		echo "</tr>\n";
	}
	else
	{
		echo "<tr nowrap><td align=\"center\">";
		echo "<input class=\"button\" type=\"button\" value=\"返回\" onclick=\"goto('admin.php?j=News&a=list".state_addlink()."')\"></td>";
		echo "</tr>\n";
	}
	echo "<script>function goto(url){this.location.replace(url);}</script>";
	$Form->tablefooter();
	$Form->cpfooter();
}
elseif ($a == 'attlist')//附件列表
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
	echo "<script src=\"js/att.js\"></script>";//frame自动适应的脚本
//这一段是修改界面
echo <<<SCR
<div id="editDIV" style="display:none;">
<form name="editform" method="post" action="admin.php?j=News&a=attupdate">
<input name="newsid" type="hidden" value="{$id}">
顺序
<input name="order" type="text" size="3" value="">
附件说明
<input name="attid" type="hidden" value="">
<input name="intro" size="40" type="input">
<input type="submit" value="修改">
<input type="button" onclick="editclose()" value="取消">
</form></div>
<table width="620" border="0" cellpadding="5" cellspacing="1">
SCR;
//修改界面结束
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
		$intro = strlen($nL['intro'])>0 ? gbsubstr($nL['intro'],0,16) : '无说明';
		$intro = $nL['order']." ".$intro;
		$attid = $nL['id'];
		echo "<table width=\"120\" border=\"0\" cellpadding=\"1\" cellspacing=\"1\" bgcolor=\"#CCCCCC\">";
		echo "<tr><td bgcolor=\"#FFFFFF\">".$intro."</td></tr>";
		echo "<tr><td bgcolor=\"#FFFFFF\"><img src=\"{$imgthumb}\" width=\"120\" height=\"90\" alt=\"{$nL['intro']}\"></td></tr>";
		echo "<tr><td bgcolor=\"#FFFFFF\" align=\"center\"><a href=\"{$img}\" target=\"_blank\">查看</a> <a href=\"javascript:editatt({$attid},'".$nL['order']."','".$nL['intro']."')\">编辑</a> <a href=\"#\" onclick=\"ifDel('admin.php?j=News&a=attdelete&newsid={$id}&id={$attid}')\">删除</a></td></tr>";
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
elseif ($a== 'attupload')//附件上传
{
	if (!isset($_POST['id'])) $Form->oa_exit("参数错误");
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
			echo "<script>alert(\"文件过大或文件不存在\");this.location=\"admin.php?j=News&a=attlist&id={$newsid}\"</script>";
			exit;
		}
		$extname = $upd->getext($filepath);
		$uploadpath = "news-".date('Ymd').M_random(8).".".$extname;
		if (in_array($extname,array('gif','jpg','png')))//判断是否为图片
			$ispic=1;
		switch($upd->upload($filetmp,$imgPath.$uploadpath))
		{
		case 1:
			echo "<script>alert(\"文件类型不允许\");this.location=\"admin.php?j=News&a=attlist&id={$newsid}\"</script>";
			exit;
		case 2:
			echo "<script>alert(\"上传附件发生意外错误\");this.location=\"admin.php?j=News&a=attlist&id={$newsid}\"</script>";
			exit;
		default:
		}
		$upd->makeThumb($imgPath.$uploadpath,$imgPath."thumb/",240,180);
		$upd->makeThumb($imgPath.$uploadpath,$imgPath."800/",800,600);
		$sql_news = "select count(*) from ".$db_news." where `id`='".$newsid."'";
		if ($newsid>0 && $db->fetch_one($sql_news)==0) $newsid=0;//判断附件的新闻是否还在
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
		echo "<script>alert(\"未选取文件\");this.location=\"admin.php?j=News&a=attlist&id={$newsid}\"</script>";
		exit;
	}
}
elseif ($a== 'attdelete')//附件删除
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
		echo "<script>alert(\"你没有权限删除该文件\");this.location=\"admin.php?j=News&a=attlist&id={$newsid}\"</script>";
	}
}
elseif ($a== 'attupdate')//附件修改
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
	$Form->oa_exit("功能不存在","index.php?a=main");
}

function deal_tags($data, $d=0)//$d=1 为反处理
{
	if ($d)
	{
		if (substr($data,0,1) == ',') $data = substr($data,1);
		if (substr($data,-1,1) == ',') $data = substr($data,0,strlen($data)-1);
	}
	else
	{
		$data = checkStr($data);
		$data = str_replace('，',',',$data);
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
		$Form->oa_exit("你没有权限进行搜索");
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