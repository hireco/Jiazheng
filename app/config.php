<?php
error_reporting(7);

require_once('global/mysql.php');
require_once('global/function.php');
require_once('global/class_DataBase.php');

global $db;
$db = new DataBase;
define("DINHO",1);

//����MYSQL
//class_DataBase.php

$db->connect($mysql_add,$mysql_user,$mysql_pass,$mysql_dbname);

//���ݱ�
$db_nav = "`".$mysql_prefix."navigator`"; //�������ݱ�
$db_service = "`".$mysql_prefix."service`"; //�������ݱ�
$db_degree = "`".$mysql_prefix."degree`"; //ѧ�����ݱ�
$db_article = "`".$mysql_prefix."article`"; //�������ݱ�
$db_employee = "`".$mysql_prefix."employee`"; //��Ա���ݱ�
$db_employer = "`".$mysql_prefix."employer`"; //�������ݱ�
$db_friend = "`".$mysql_prefix."friend`"; //�����������ݱ�
$db_area = "`".$mysql_prefix."area`"; //�������ݱ�
$db_comment = "`".$mysql_prefix."comment`"; //�������ݱ�
$db_company = "`".$mysql_prefix."company`"; //�����������ݱ�
$db_sort = "`".$mysql_prefix."sort`"; //������Ŀ���ݱ�
$db_guestbook = "`".$mysql_prefix."guestbook`"; //���Ա����ݱ�
$db_reservee = "`".$mysql_prefix."reservee`"; //ԤԼ��Ա���ݱ�
$db_reserver = "`".$mysql_prefix."reserver`"; //ԤԼ�������ݱ�
$db_register = "`".$mysql_prefix."register`"; //���ٵǼ����ݱ�
$db_config = "`".$mysql_prefix."config`"; //��վ�������ݱ�
$db_ad = "`".$mysql_prefix."advertise`"; //������ݱ�

//����ģ����
require_once("global/class.smarttemplate.php");
global $template;
$template = $db->fetch_one("select `template` from ".$db_config." where `id`=1");
function template($name) 
{
	global $template;
	Return new SmartTemplate('template/'.$template."/".$name.'.htm');
}

$url = "http://localhost/jiazheng";

$copyright = '<p align="center">��Ȩ���У�����</p>';

//��ʾ��Ϣ
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
	echo "<title>��Ϣ</title>";
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
	echo "<td bgcolor=\"#DEEBFF\"><strong>��Ϣ</strong></td>";
	echo "</tr>";
	echo "<tr>";
	echo "<td align=\"center\"><br>".$msg."<br><a href=".$url." ".$target.">�������ﷵ��</a><br><br></td>\n";
	echo "</tr>";
	echo "</table>";
	echo "</td>";
	echo "</tr>";
	echo "</table>";
	echo "</body>\n</html>";
	exit;
}

?>