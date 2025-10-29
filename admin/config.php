<?php
error_reporting(7);

require_once('../global/mysql.php');
require_once('../global/function.php');
require_once('../global/class_DataBase.php');
require_once('class/forms.php');
require_once('class/class_User.php');

global $db;
$db = new DataBase;
$Form = new cpForms;
define("DINHO",1);

//连接MYSQL
//class_DataBase.php

$db->connect($mysql_add,$mysql_user,$mysql_pass,$mysql_dbname);

//所有功能模块
/*如果需要加入新功能的话，还需
1 修改 module_User.php rights 
2 修改菜单
3 修改 class_User session
4 在数据库添加权限字段
*/
$modules = array('Myoa', 'Config', 'User', 'News', 'Note', 'Contract', 'Ad', 'Friend', 'Stat', 'Admin'); 
$modulename = array(
	'Myoa' => "个人设置",
	'Config' => "网站配置",
	'User' => "会员管理",
	'News' => "信息中心",
	'Note' => "留言预订",
	'Contract' => "客户合约",
	'Friend' => "友情链接",
	'Ad' => "广告管理",
	'Stat' => "网站统计",
	'Admin' => "帐号管理",
); 
//判断登录
$db_admin = "`".$mysql_prefix."admin`"; //用户数据表

$usr = new cUser($db_admin);

$pass_period = 5184000; //密码过期时间，60天

//加载模板类
require_once("../global/class.smarttemplate.php");
function template($name) 
{
	Return new SmartTemplate('template/'.$name.'.htm');
}

?>