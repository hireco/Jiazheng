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

//����MYSQL
//class_DataBase.php

$db->connect($mysql_add,$mysql_user,$mysql_pass,$mysql_dbname);

//���й���ģ��
/*�����Ҫ�����¹��ܵĻ�������
1 �޸� module_User.php rights 
2 �޸Ĳ˵�
3 �޸� class_User session
4 �����ݿ����Ȩ���ֶ�
*/
$modules = array('Myoa', 'Config', 'User', 'News', 'Note', 'Contract', 'Ad', 'Friend', 'Stat', 'Admin'); 
$modulename = array(
	'Myoa' => "��������",
	'Config' => "��վ����",
	'User' => "��Ա����",
	'News' => "��Ϣ����",
	'Note' => "����Ԥ��",
	'Contract' => "�ͻ���Լ",
	'Friend' => "��������",
	'Ad' => "������",
	'Stat' => "��վͳ��",
	'Admin' => "�ʺŹ���",
); 
//�жϵ�¼
$db_admin = "`".$mysql_prefix."admin`"; //�û����ݱ�

$usr = new cUser($db_admin);

$pass_period = 5184000; //�������ʱ�䣬60��

//����ģ����
require_once("../global/class.smarttemplate.php");
function template($name) 
{
	Return new SmartTemplate('template/'.$name.'.htm');
}

?>