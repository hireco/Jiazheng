<?php
error_reporting(7);

header("content-Type: text/html; charset=gb2312");

// Functions & Variables 
$header = "<head><meta http-equiv=\"Content-Type\" content=\"text/html; charset=gb2312\"><title>���޼���ϵͳ1.0��װ����</title><style type=\"text/css\"><!--TABLE {font-family: Georgia, \"Times New Roman\", Times, serif;font-size: 14px;color: #000000;}.header {font-family: Georgia, \"Times New Roman\", Times, serif;font-size: 18px;font-weight: bold;color: #FFFFFF;background-color: #6699FF;}--></style><style type=\"text/css\"><!--INPUT {font-family: Georgia, \"Times New Roman\", Times, serif;font-size: 14px;width: 260px;height: 28px;}.itemtitle {font-size: 16px;}--></style></head><body bgcolor=\"#F3F3F3\"><form name=\"form1\" method=\"post\" action=\"install.php?do=action\">  <table width=\"650\" border=\"0\" align=\"center\" cellpadding=\"10\" cellspacing=\"1\" bgcolor=\"#CCCCCC\">    <tr valign=\"top\" bgcolor=\"#666666\"><td height=\"80\" colspan=\"3\" bgcolor=\"#F3F3F3\" class=\"header\"><strong>���޼���ϵͳ1.0��װ����</strong>&nbsp;</td></tr><tr><td colspan=\"3\" bgcolor=\"#FFFFFF\">";

$footer = "</td></tr></table></form></body></html>";

function set_writeable($file) {
	if(is_writeable($file)) {
		echo"����ļ����У�$file ���� <strong>��д</strong><br>";
	} else {
		echo"����ļ����У�$file ���� <strong>����д</strong><br>���ڸı�Ȩ�� ���� ";
		if(@chmod($file,0777)) {
		echo"<strong>��д</strong><br>";
		} else {
		echo"<strong>ʧ��,���ֶ����Ĵ��ļ�����Ȩ�ޣ�</strong><br>";
		exit;
		}
	}
}

function querySQL() {
	global $mysql_prefix;

	$sql[] = "drop table if exists `".$mysql_prefix."admin`;";
	$sql[] = "CREATE TABLE `".$mysql_prefix."admin` ( `id` int(5) NOT NULL auto_increment, `username` varchar(12) NOT NULL default '', `password` varchar(32) NOT NULL default '', `available_time` varchar(20) NOT NULL default '', `usable` tinyint(1) NOT NULL default '0', `time` varchar(20) NOT NULL default '', `email` varchar(40) NOT NULL default '', `qq` varchar(10) NOT NULL default '', `other` text NOT NULL, `R_Myoa` enum('S','A','M','N') NOT NULL default 'N', `R_Config` enum('S','A','M','N') NOT NULL default 'N', `R_User` enum('S','A','M','N') NOT NULL default 'N', `R_News` enum('S','A','M','N') NOT NULL default 'N', `R_Note` enum('S','A','M','N') NOT NULL default 'N', `R_Contract` enum('S','A','M','N') NOT NULL default 'N', `R_Ad` enum('S','A','M','N') NOT NULL default 'N', `R_Friend` enum('S','A','M','N') NOT NULL default 'N', `R_Stat` enum('S','A','M','N') NOT NULL default 'N', `R_Admin` enum('S','A','M','N') NOT NULL default 'N', `last_ip` varchar(20) NOT NULL default '', `last_time` varchar(20) NOT NULL default '', `pass_time` varchar(20) NOT NULL default '', `active` tinyint(1) NOT NULL default '0', PRIMARY KEY  (`id`) ) ENGINE=MyISAM AUTO_INCREMENT=2 COMMENT='����Ա��' AUTO_INCREMENT=2 ;";
	$sql[] = "INSERT INTO `".$mysql_prefix."admin` ( `id` , `username` , `password` , `available_time` , `usable` , `time` , `email` , `qq` , `other` , `R_Myoa` , `R_Config` , `R_User` , `R_News` , `R_Note` , `R_Contract` , `R_Ad` , `R_Friend` , `R_Stat` , `R_Admin` , `last_ip` , `last_time` , `pass_time` , `active` ) VALUES ( '', 'admin', '96e79218965eb72c92a549dd5a330112', '0', '1', '0', '', '', '', 'S', 'S', 'S', 'S', 'S', 'S', 'S', 'S', 'S', 'S', '', '', '', '0' );";

	$sql[] = "drop table if exists `".$mysql_prefix."adminlog`;";
	$sql[] = "CREATE TABLE `".$mysql_prefix."adminlog` ( `id` int(10) NOT NULL auto_increment, `script` varchar(60) NOT NULL default '', `time` varchar(20) NOT NULL default '', `ip` varchar(20) NOT NULL default '', PRIMARY KEY  (`id`) ) ENGINE=MyISAM AUTO_INCREMENT=184 COMMENT='������¼��' AUTO_INCREMENT=184 ;";

	$sql[] = "drop table if exists `".$mysql_prefix."advertise`;";
	$sql[] = "CREATE TABLE `".$mysql_prefix."advertise` ( `id` int(3) NOT NULL auto_increment, `position` varchar(20) NOT NULL default '', `content` text NOT NULL, `adder` varchar(20) NOT NULL default '', `addip` varchar(20) NOT NULL default '', `time` varchar(20) NOT NULL default '', PRIMARY KEY  (`id`) ) ENGINE=MyISAM AUTO_INCREMENT=5 COMMENT='����' AUTO_INCREMENT=5 ;";

	$sql[] = "drop table if exists `".$mysql_prefix."area`;";
	$sql[] = "CREATE TABLE `".$mysql_prefix."area` ( `id` int(2) NOT NULL auto_increment, `name` varchar(10) NOT NULL default '', PRIMARY KEY  (`id`) ) ENGINE=MyISAM COMMENT='������' AUTO_INCREMENT=1 ;";

	$sql[] = "drop table if exists `".$mysql_prefix."article`;";
	$sql[] = "CREATE TABLE `".$mysql_prefix."article` ( `id` int(5) NOT NULL auto_increment, `title` varchar(100) NOT NULL default '', `sort` int(2) NOT NULL default '0', `author` varchar(12) NOT NULL default '', `source` varchar(20) NOT NULL default '', `content` text NOT NULL, `tag` text NOT NULL, `click` int(8) NOT NULL default '0', `show` tinyint(1) NOT NULL default '0', `top` tinyint(1) NOT NULL default '0', `comment` tinyint(1) NOT NULL default '0', `post_time` varchar(20) NOT NULL default '', `post_ip` varchar(20) NOT NULL default '', `checker` varchar(20) NOT NULL default '', `checkip` varchar(20) NOT NULL default '', PRIMARY KEY  (`id`) ) ENGINE=MyISAM AUTO_INCREMENT=2 COMMENT='���±�' AUTO_INCREMENT=2 ;";

	$sql[] = "drop table if exists `".$mysql_prefix."comment`;";
	$sql[] = "CREATE TABLE `".$mysql_prefix."comment` ( `id` int(8) NOT NULL auto_increment, `aid` int(5) NOT NULL default '0', `name` varchar(20) NOT NULL default '', `content` text NOT NULL, `time` varchar(20) NOT NULL default '', `ip` varchar(20) NOT NULL default '', PRIMARY KEY  (`id`) ) ENGINE=MyISAM COMMENT='�������۱�' AUTO_INCREMENT=1 ;";

	$sql[] = "drop table if exists `".$mysql_prefix."company`;";
	$sql[] = "CREATE TABLE `".$mysql_prefix."company` ( `id` int(2) NOT NULL auto_increment, `name` varchar(10) NOT NULL default '', `content` text NOT NULL, PRIMARY KEY  (`id`) ) ENGINE=MyISAM COMMENT='��˾��ر�' AUTO_INCREMENT=1 ;";

	$sql[] = "drop table if exists `".$mysql_prefix."config`;";
	$sql[] = "CREATE TABLE `".$mysql_prefix."config` ( `id` int(4) NOT NULL auto_increment, `title` varchar(50) NOT NULL default '', `logo` varchar(50) NOT NULL default '', `admin` varchar(20) NOT NULL default '', `email` varchar(40) NOT NULL default '', `link_logo` varchar(50) NOT NULL default '', `intro` text NOT NULL, `keyword` text NOT NULL, `description` text NOT NULL, `icpinfo` varchar(50) NOT NULL default '', `icplink` varchar(50) NOT NULL default '', `reginfo` text NOT NULL, `template` varchar(30) NOT NULL default '', `regverify` tinyint(1) NOT NULL default '0', `commentverify` tinyint(1) NOT NULL default '0', `noteverify` tinyint(1) NOT NULL default '0', `oaloginverify` tinyint(1) NOT NULL default '0', `telephone` varchar(12) NOT NULL default '', `fax` varchar(15) NOT NULL default '', `address` varchar(50) NOT NULL default '', `footer` text NOT NULL, PRIMARY KEY  (`id`) ) ENGINE=MyISAM AUTO_INCREMENT=2 COMMENT='��վ���ñ�' AUTO_INCREMENT=2 ;";
	$sql[] = "INSERT INTO `".$mysql_prefix."config` VALUES (1, '���޼�����', 'logo.jpg', 'Victor', 'dinho.victor@gmail.com', 'logo.jpg', '���޼�����', '����', '����', '', '', '����ע���ˡ�����', 'jzweb', 1, 1, 1, 1, '88888888', '88888888', '88888888', '');";

	$sql[] = "drop table if exists `".$mysql_prefix."contract`;";
	$sql[] = "CREATE TABLE `".$mysql_prefix."contract` ( `id` int(8) NOT NULL auto_increment, `employerid` int(6) NOT NULL default '0', `employeeid` int(6) NOT NULL default '0', `agent` int(4) NOT NULL default '0', `salary` int(4) NOT NULL default '0', `note` text NOT NULL, `starttime` varchar(20) NOT NULL default '', `endtime` varchar(20) NOT NULL default '', `adder` varchar(12) NOT NULL default '', `addip` varchar(20) NOT NULL default '', PRIMARY KEY  (`id`) ) ENGINE=MyISAM COMMENT='��Լ��' AUTO_INCREMENT=1 ;";

	$sql[] = "drop table if exists `".$mysql_prefix."degree`;";
	$sql[] = "CREATE TABLE `".$mysql_prefix."degree` ( `id` int(2) NOT NULL auto_increment, `name` varchar(10) NOT NULL default '', PRIMARY KEY  (`id`) ) ENGINE=MyISAM COMMENT='ѧ����' AUTO_INCREMENT=1 ;";

	$sql[] = "drop table if exists `".$mysql_prefix."employee`;";
	$sql[] = "CREATE TABLE `".$mysql_prefix."employee` ( `id` int(6) NOT NULL auto_increment, `username` varchar(12) NOT NULL default '', `password` varchar(32) NOT NULL default '', `question` varchar(50) NOT NULL default '', `answer` varchar(50) NOT NULL default '', `name` varchar(20) NOT NULL default '', `identifyid` varchar(18) NOT NULL default '', `sex` char(2) NOT NULL default '', `age` int(2) NOT NULL default '0', `birthyear` varchar(4) NOT NULL default '', `horoscopes` char(2) NOT NULL default '', `hometown` varchar(20) NOT NULL default '', `nation` varchar(10) NOT NULL default '', `degree` int(2) NOT NULL default '0', `telephone` varchar(12) NOT NULL default '', `mobile` varchar(11) NOT NULL default '', `email` varchar(40) NOT NULL default '', `qq` varchar(10) NOT NULL default '', `area` int(2) NOT NULL default '0', `address` varchar(100) NOT NULL default '', `service_area` tinyint(4) NOT NULL default '0', `salary` varchar(20) NOT NULL default '', `experience` text NOT NULL, `language` varchar(40) NOT NULL default '', `marriage` varchar(10) NOT NULL default '', `service` text NOT NULL, `reg_time` varchar(20) NOT NULL default '', `reg_ip` varchar(20) NOT NULL default '', `mod_time` varchar(20) NOT NULL default '', `mod_ip` varchar(20) NOT NULL default '', `last_time` varchar(20) NOT NULL default '', `last_ip` varchar(20) NOT NULL default '', `qualified` tinyint(1) NOT NULL default '0', `checked` tinyint(1) NOT NULL default '0', `recommended` tinyint(1) NOT NULL default '0', `rec_time` varchar(20) NOT NULL default '', `occupied` tinyint(1) NOT NULL default '0', `company` tinyint(1) NOT NULL default '0', `intro` text NOT NULL, `picture` varchar(100) NOT NULL default '', `visit_times` int(10) NOT NULL default '0', `checker` varchar(12) NOT NULL default '', `checkip` varchar(20) NOT NULL default '', PRIMARY KEY  (`id`) ) ENGINE=MyISAM AUTO_INCREMENT=2 COMMENT='��Ա��' AUTO_INCREMENT=2 ;";

	$sql[] = "drop table if exists `".$mysql_prefix."employer`;";
	$sql[] = "CREATE TABLE `".$mysql_prefix."employer` ( `id` int(6) NOT NULL default '0', `username` varchar(12) NOT NULL default '', `password` varchar(32) NOT NULL default '', `question` varchar(50) NOT NULL default '', `answer` varchar(50) NOT NULL default '', `name` varchar(20) NOT NULL default '', `telephone` varchar(12) NOT NULL default '', `mobile` varchar(11) NOT NULL default '', `email` varchar(40) NOT NULL default '', `qq` varchar(10) NOT NULL default '', `area` int(2) NOT NULL default '0', `address` varchar(100) NOT NULL default '', `salary` varchar(20) NOT NULL default '', `service` text NOT NULL, `ideal_sex` char(2) NOT NULL default '', `ideal_degree` int(2) NOT NULL default '0', `ideal_age` varchar(20) NOT NULL default '', `home` tinyint(1) NOT NULL default '0', `worktime` varchar(20) NOT NULL default '', `requirement` text NOT NULL, `reg_time` varchar(20) NOT NULL default '', `reg_ip` varchar(20) NOT NULL default '', `mod_time` varchar(20) NOT NULL default '', `mod_ip` varchar(20) NOT NULL default '', `last_time` varchar(20) NOT NULL default '', `last_ip` varchar(20) NOT NULL default '', `visit_times` int(10) NOT NULL default '0', `checked` tinyint(1) NOT NULL default '0', `occupied` tinyint(1) NOT NULL default '0', `top` tinyint(1) NOT NULL default '0', `top_time` varchar(20) NOT NULL default '', `checker` varchar(12) NOT NULL default '', `checkip` varchar(20) NOT NULL default '' ) ENGINE=MyISAM COMMENT='��Ա��';";

	$sql[] = "drop table if exists `".$mysql_prefix."friend`;";
	$sql[] = "CREATE TABLE `".$mysql_prefix."friend` ( `id` int(3) NOT NULL auto_increment, `type` tinyint(1) NOT NULL default '0', `title` varchar(20) NOT NULL default '', `pic` varchar(100) NOT NULL default '', `link` varchar(100) NOT NULL default '', `intro` text NOT NULL, `name` varchar(20) NOT NULL default '', `email` varchar(40) NOT NULL default '', `status` tinyint(1) NOT NULL default '0', `top` tinyint(1) NOT NULL default '0', `time` varchar(20) NOT NULL default '', `ip` varchar(20) NOT NULL default '', `checker` varchar(12) NOT NULL default '', `checkip` varchar(20) NOT NULL default '', PRIMARY KEY  (`id`) ) ENGINE=MyISAM AUTO_INCREMENT=2 COMMENT='�������ӱ�' AUTO_INCREMENT=2 ;";

	$sql[] = "drop table if exists `".$mysql_prefix."guestbook`;";
	$sql[] = "CREATE TABLE `".$mysql_prefix."guestbook` ( `id` int(5) NOT NULL auto_increment, `name` varchar(20) NOT NULL default '', `image` varchar(40) NOT NULL default '', `email` varchar(40) NOT NULL default '', `telephone` varchar(12) NOT NULL default '', `qq` varchar(10) NOT NULL default '', `content` text NOT NULL, `time` varchar(20) NOT NULL default '', `ip` varchar(20) NOT NULL default '', `viewed` tinyint(1) NOT NULL default '0', `status` tinyint(1) NOT NULL default '0', `checker` varchar(12) NOT NULL default '', `checkip` varchar(20) NOT NULL default '', PRIMARY KEY  (`id`) ) ENGINE=MyISAM COMMENT='���Ա�' AUTO_INCREMENT=1 ;";

	$sql[] = "drop table if exists `".$mysql_prefix."loginlog`;";
	$sql[] = "CREATE TABLE `".$mysql_prefix."loginlog` ( `id` int(10) NOT NULL auto_increment, `username` varchar(12) NOT NULL default '', `time` varchar(20) NOT NULL default '', `ip` varchar(20) NOT NULL default '', `result` tinyint(1) NOT NULL default '0', PRIMARY KEY  (`id`) ) ENGINE=MyISAM AUTO_INCREMENT=8 COMMENT='��½��¼��' AUTO_INCREMENT=8 ;";

	$sql[] = "drop table if exists `".$mysql_prefix."navigator`;";
	$sql[] = "CREATE TABLE `".$mysql_prefix."navigator` ( `id` int(1) NOT NULL auto_increment, `name` varchar(10) NOT NULL default '', `link` varchar(100) NOT NULL default '', PRIMARY KEY  (`id`) ) ENGINE=MyISAM COMMENT='���������ñ�' AUTO_INCREMENT=1 ;";
	$sql[] = "INSERT INTO `".$mysql_prefix."navigator` VALUES (1, '��ҳ', 'index.php');";
	$sql[] = "INSERT INTO `".$mysql_prefix."navigator` VALUES (2, '��Ա����', 'member_center.php'); ";
	$sql[] = "INSERT INTO `".$mysql_prefix."navigator` VALUES (3, '�˳�', 'logout.php');";
	$sql[] = "INSERT INTO `".$mysql_prefix."navigator` VALUES (4, '��������', 'article_center.php');";

	$sql[] = "drop table if exists `".$mysql_prefix."picture`;";
	$sql[] = "CREATE TABLE `".$mysql_prefix."picture` ( `id` int(7) NOT NULL auto_increment, `aid` int(5) NOT NULL default '0', `url` varchar(40) NOT NULL default '', `intro` text NOT NULL, `uploader` varchar(12) NOT NULL default '', `order` char(2) NOT NULL default '', `date` varchar(20) NOT NULL default '', `ispic` tinyint(1) NOT NULL default '0', PRIMARY KEY  (`id`) ) ENGINE=MyISAM AUTO_INCREMENT=4 COMMENT='����ͼƬ��' AUTO_INCREMENT=4 ;";

	$sql[] = "drop table if exists `".$mysql_prefix."register`;";
	$sql[] = "CREATE TABLE `".$mysql_prefix."register` ( `id` int(6) NOT NULL auto_increment, `name` varchar(20) NOT NULL default '', `telephone` varchar(12) NOT NULL default '', `note` text NOT NULL, `time` varchar(20) NOT NULL default '', `ip` varchar(20) NOT NULL default '', PRIMARY KEY  (`id`) ) ENGINE=MyISAM COMMENT='���ٵǼǱ�' AUTO_INCREMENT=1 ;";

	$sql[] = "drop table if exists `".$mysql_prefix."reservee`;";
	$sql[] = "CREATE TABLE `".$mysql_prefix."reservee` ( `id` int(8) NOT NULL auto_increment, `sid` int(6) NOT NULL default '0', `telephone` varchar(12) NOT NULL default '', `mobile` varchar(11) NOT NULL default '', `email` varchar(40) NOT NULL default '', `qq` varchar(10) NOT NULL default '', `area` int(2) NOT NULL default '0', `address` varchar(100) NOT NULL default '', `service` text NOT NULL, `snote` text NOT NULL, `did` int(6) NOT NULL default '0', `date` varchar(20) NOT NULL default '', `status` tinyint(1) NOT NULL default '0', `note` text NOT NULL, `read` tinyint(1) NOT NULL default '0', `checker` varchar(12) NOT NULL default '', `checkip` varchar(20) NOT NULL default '', PRIMARY KEY  (`id`) ) ENGINE=MyISAM COMMENT='ԤԼ��Ա��' AUTO_INCREMENT=1 ;";

	$sql[] = "drop table if exists `".$mysql_prefix."reserver`;";
	$sql[] = "CREATE TABLE `".$mysql_prefix."reserver` ( `id` int(8) NOT NULL auto_increment, `sid` int(6) NOT NULL default '0', `did` int(6) NOT NULL default '0', `date` varchar(20) NOT NULL default '', `status` tinyint(1) NOT NULL default '0', `note` varchar(100) NOT NULL default '', `read` tinyint(1) NOT NULL default '0', `checker` varchar(12) NOT NULL default '', `checkip` varchar(20) NOT NULL default '', PRIMARY KEY  (`id`) ) ENGINE=MyISAM COMMENT='ԤԼ������' AUTO_INCREMENT=1 ;";

	$sql[] = "drop table if exists `".$mysql_prefix."service`;";
	$sql[] = "CREATE TABLE `".$mysql_prefix."service` ( `id` int(2) NOT NULL auto_increment, `name` varchar(20) NOT NULL default '', `fee` text NOT NULL, `intro` text NOT NULL, PRIMARY KEY  (`id`) ) ENGINE=MyISAM COMMENT='������Ŀ��' AUTO_INCREMENT=1 ;";

	$sql[] = "drop table if exists `".$mysql_prefix."sort`;";
	$sql[] = "CREATE TABLE `".$mysql_prefix."sort` ( `id` int(2) NOT NULL auto_increment, `name` varchar(10) NOT NULL default '', `short` varchar(4) NOT NULL default '', `order` int(2) NOT NULL default '0', `visible` tinyint(1) NOT NULL default '0', PRIMARY KEY  (`id`) ) ENGINE=MyISAM AUTO_INCREMENT=3 COMMENT='���·����' AUTO_INCREMENT=3 ;";
	$sql[] = "INSERT INTO `".$mysql_prefix."sort` VALUES (1, '���Ź���', '����', 1, 1); ";
	$sql[] = "INSERT INTO `".$mysql_prefix."sort` VALUES (2, '�����ٵ�', '�ٵ�', 2, 1);";
	$sql[] = "INSERT INTO `".$mysql_prefix."sort` VALUES (3, '������Ѷ', '��Ѷ', 3, 1);";

	foreach($sql as $key=>$val) {
		if(!mysql_query($val)) {
			die("��������ʧ��:<br>query:<br>".$val);
		}
	}
	Return true;
}

function writeAdmin() {
	global $d_add,$d_name,$d_user,$d_pass,$d_prefix;
	$fp = fopen("global/mysql.php","w") or die("�޷����ļ�");
	$write_data = "<?php"
				."\n"
				."//mysql.php"
				."\n\n"
				."/* Mysql Server */\n"
				."\$mysql_add\t\t\t= "
				."'".$d_add."';"
				."\n\n"
				."/* Mysql User */\n"
				."\$mysql_user\t\t\t= "
				."'".$d_user."';"
				."\n\n"
				."/* Mysql Password */\n"
				."\$mysql_pass\t\t\t= "
				."'".$s_pass."';"
				."\n\n"
				."/* Mysql Database Name */\n"
				."\$mysql_dbname\t\t= "
				."'".$d_name."';"
				."\n\n"
				."/* Mysql Database Table Prefix */\n"
				."\$mysql_prefix\t\t= "
				."'".$d_prefix."';"
				."\n\n?>";
	if(!fwrite($fp, $write_data)) {
		die("�ļ�д��ʧ�ܣ�");
	}
}

function updateAdmin() {
	global $a_user,$a_pass,$mysql_prefix;
	$a_pass = md5($a_pass);
	$adminsql[] = "UPDATE `".$mysql_prefix."admin` SET username= '".$a_user."', password= '".$a_pass."'";
	foreach($adminsql as $key=>$val) {
		if(!mysql_query($val)) {
			die("�趨����Ա����");
		}
	}
	echo "�趨����Ա ���� �ɹ�";
}

if(isset($_GET['do']) && $_GET['do'] == 'action') {
	echo $header;
	echo "<b>����ļ�Ŀ¼�Ƿ��д��</b>";
	echo "<hr size=1>";

	set_writeable("./cache");
	set_writeable("./attachment");
	set_writeable("./global/mysql.php");
	set_writeable("./");
	
	$d_add			= trim($_POST['d_add']);
	$d_name			= trim($_POST['d_name']);
	$d_user			= trim($_POST['d_user']);
	$d_pass			= trim($_POST['d_pass']);
	$d_prefix		= trim($_POST['d_prefix']);
	$a_user		= trim($_POST['a_user']);
	$a_pass		= trim($_POST['a_pass']);
	$a_repass		= trim($_POST['a_repass']);
	$mysql_prefix = $d_prefix;

	echo "<hr size=1>";
	$conn = @mysql_connect($d_add,$d_user,$d_pass)
		or die("<br><b><font color=red>Could not connect: " . mysql_error()."</font></b>");
	if(@mysql_query("CREATE DATABASE ".$d_name)) {
		echo "���ݿ⽨���ɹ� ���� �ɹ�<br>";
	}
	mysql_select_db($d_name) or die('<br><b><font color="red">Can not select database!</font></b>');
	writeAdmin();
	echo "�������ݱ� ���� ";
	if(querySQL()) {
		echo "�ɹ�";
	}
	echo "<hr size=1>";
	updateAdmin();

	echo "<hr size=1>";
	die("��ϲ������װ�ɹ���<br>������ɾ�� <b>install.php</b> ,���Ϳ���ʹ���ˣ�".$footer);
	echo $footer;
}

?>

<html>
<head>
<meta http-equiv="Content-Type" content="text/html; charset=gb2312">
<title>���޼���ϵͳ1.0��װ����?</title>
<style type="text/css">
<!--
TABLE {
	font-family: Courier New, Courier, monospace, "Times New Roman", Times, serif;
	font-size: 14px;
	color: #000000;
}
.header {
	font-family: Courier New, Courier, monospace, "Times New Roman", Times, serif;
	font-size: 18px;
	font-weight: bold;
	color: #FFFFFF;
	background-color: #6699FF;
}
-->
</style>
<style type="text/css">
<!--
INPUT {
	font-family: Courier New, Courier, monospace, "Times New Roman", Times, serif;
	font-size: 14px;
	width: 260px;
	height: 28px;
}
.itemtitle {
	font-size: 16px;
}
-->
</style>
</head>

<body bgcolor="#F3F3F3">
<form name="form1" method="post" action="install.php?do=action">
  <table width="650" border="0" align="center" cellpadding="10" cellspacing="1" bgcolor="#CCCCCC">
    <tr valign="top" bgcolor="#666666"> 
      <td height="41" colspan="3" bgcolor="#F3F3F3" class="header">���޼���ϵͳ1.0��װ����</td>
    </tr>
    <tr> 
      <td colspan="3" bgcolor="#FFFFFF">
            <table width="100%" border="0" cellspacing="0" cellpadding="4">
          <tr class="itemtitle"> 
            <td><strong>�����ļ���Ȩ��</strong></td>
            <td>&nbsp;</td>
          </tr>
          <tr> 
            <td colspan="2">��linuxϵͳ�����б���װ����ʱ������ftp�������ӵ����������������ļ�����������Ϊ��д(777)��</td>
          </tr>
          <tr> 
            <td colspan="2"><ul>
                <li>��./cache</li>
                <li>��./attachment</li>
                <li>��./global/mysql.php</li>
				<li>��./templates �����ļ����µ������ļ�(��)</li>
                <li>��./</li>
              </ul></td>
          </tr>
          <tr> 
            <td>&nbsp;</td>
            <td>&nbsp;</td>
          </tr>
          <tr class="itemtitle"> 
            <td><strong>���ݿ�����</strong></td>
            <td>&nbsp;</td>
          </tr>
          <tr> 
            <td>���ݿ��ַ��</td>
            <td><input name="d_add" type="text" id="d_add" value="localhost"></td>
          </tr>
          <tr> 
            <td height="26">���ݿ��û�����</td>
            <td><input name="d_user" type="text" id="d_user" value="root"></td>
          </tr>
          <tr> 
            <td>���ݿ����룺</td>
            <td><input name="d_pass" type="password" id="d_pass"></td>
          </tr>
          <tr> 
            <td>���ݿ����ƣ�</td>
            <td><input name="d_name" type="text" id="d_name" value="dbname"></td>
          </tr>
          <tr>
            <td>���ݱ�ǰ׺��</td>
            <td><input name="d_prefix" type="text" id="d_prefix" value="jz_"></td>
          </tr>
          <tr> 
            <td>&nbsp;</td>
            <td>&nbsp;</td>
          </tr>
          <tr class="itemtitle"> 
            <td><strong>��������</strong></td>
            <td>&nbsp;</td>
          </tr>
          <tr> 
            <td>&nbsp;</td>
            <td>&nbsp;</td>
          </tr>
          <tr class="itemtitle"> 
            <td><strong>����Ա����</strong></td>
            <td>&nbsp;</td>
          </tr>
          <tr> 
            <td>�û�����</td>
            <td><input name="a_user" type="text" id="a_user"></td>
          </tr>
          <tr> 
            <td>���룺</td>
            <td><input name="a_pass" type="password" id="a_pass"></td>
          </tr>
          <tr> 
            <td>&nbsp;</td>
            <td>&nbsp;</td>
          </tr>
          <tr align="center"> 
            <td colspan="2"> <input type="submit" name="Submit" value="��ʼ��װ��"> 
              <input type="reset" name="Submit2" value="����"> </td>
          </tr>
        </table>
          </li>
        </ul>
      </td>
    </tr>
  </table>
</form>
</body>
</html>
