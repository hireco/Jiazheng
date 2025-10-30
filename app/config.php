<?php
error_reporting(7);

require_once('global/mysql.php');
require_once('global/function.php');
require_once('global/class_DataBase.php');

global $db;
$db = new DataBase;
define("DINHO",1);

//连接MYSQL
//class_DataBase.php

$db->connect($mysql_add,$mysql_user,$mysql_pass,$mysql_dbname);

//数据表
$db_nav = "`".$mysql_prefix."navigator`"; //文章数据表
$db_service = "`".$mysql_prefix."service`"; //服务数据表
$db_degree = "`".$mysql_prefix."degree`"; //学历数据表
$db_article = "`".$mysql_prefix."article`"; //文章数据表
$db_employee = "`".$mysql_prefix."employee`"; //雇员数据表
$db_employer = "`".$mysql_prefix."employer`"; //雇主数据表
$db_friend = "`".$mysql_prefix."friend`"; //友情链接数据表
$db_area = "`".$mysql_prefix."area`"; //地区数据表
$db_comment = "`".$mysql_prefix."comment`"; //评论数据表
$db_company = "`".$mysql_prefix."company`"; //关于我们数据表
$db_sort = "`".$mysql_prefix."sort`"; //新闻栏目数据表
$db_guestbook = "`".$mysql_prefix."guestbook`"; //留言本数据表
$db_reservee = "`".$mysql_prefix."reservee`"; //预约雇员数据表
$db_reserver = "`".$mysql_prefix."reserver`"; //预约雇主数据表
$db_register = "`".$mysql_prefix."register`"; //快速登记数据表
$db_config = "`".$mysql_prefix."config`"; //网站设置数据表
$db_ad = "`".$mysql_prefix."advertise`"; //广告数据表

//加载模板类
require_once("global/class.smarttemplate.php");
global $template;
$template = $db->fetch_one("select `template` from ".$db_config." where `id`=1");
function template($name) 
{
	global $template;
	Return new SmartTemplate('template/'.$template."/".$name.'.htm');
}

$url = "http://localhost/jiazheng";

$copyright = '<p align="center">版权所有：红棉</p>';

//提示信息
function oa_exit($msg, $url="",$target="") {
	if(empty($url)) {
		$url = "javascript:history.go(-1);";
	}
	if(empty($target)) {
		$target = "";
	} else {
		$target = "target=\"".$target."\"";
	}

	echo "<html>\n";
	echo "<head>\n";
	echo "<meta http-equiv=\"Content-Type\" content=\"text/html; charset=gb2312\" />\n";
	echo "<meta http-equiv=\"refresh\" content=\"3;URL=".$url."\">\n";
	echo "<title>信息</title>";
	echo "<style type=\"text/css\">\n";
	echo "<!--\n";
	echo "table {";
	echo "font-size: 12px;";
	echo "}\n";
	echo "a:link,a:visited,a:hover,a:active {";
	echo "color: #000;";
	echo "}\n";
	echo "-->\n";
	echo "</style>";
	echo "</head>";
	echo "<body bgcolor=\"#DEEBFF\">";
	echo "<table width=\"350\" border=\"0\" align=\"center\" cellpadding=\"5\" cellspacing=\"1\" bgcolor=\"#CCCCCC\" class=\"ob\">";
	echo "<tr>";
	echo "<td bgcolor=\"#FFFFFF\"> ";
	echo "<table width=\"100%\" border=\"0\" cellpadding=\"5\" cellspacing=\"0\" class=\"ob\">";
	echo "<tr> ";
	echo "<td bgcolor=\"#DEEBFF\"><strong>信息</strong></td>";
	echo "</tr>";
	echo "<tr>";
	echo "<td align=\"center\"><br>".$msg."<br><a href=".$url." ".$target.">请点击这里返回</a><br><br></td>\n";
	echo "</tr>";
	echo "</table>";
	echo "</td>";
	echo "</tr>";
	echo "</table>";
	echo "</body>\n</html>";
	exit;
}

?>