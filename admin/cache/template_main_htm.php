<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html>
<head>
<meta http-equiv="Content-Type" content="text/html; charset=gbk">
<title>Main</title>
<LINK href="styles/main.css" type="text/css" rel="stylesheet">	
</head>
<body>
<h4>��ӭ���ʺ��޼���ϵͳ�������</h4>
<div class="info">
<div class="title">
���޲�Ʒ����
</div>
<ul>
<li></li>
</ul>
</div>
<div class="info">
<div class="title">
�������
</div>
<ul>
<li></li>
</ul>
</div>
<div class="info">
<div class="title">
ϵͳ��Ϣ
</div>
<div id="leftlist">
<ul>
<li>��������ַ��������<?php
echo $_obj['serveraddress'];
?>
</li>
<li>�����������������<?php
echo $_obj['software'];
?>
</li>
<li>������ϵͳ��������<?php
echo $_obj['OS'];
?>
 </li>
<li>PHP ����汾������<?php
echo $_obj['phpversion'];
?>
</li>
<li>MYSQL �汾��������<?php
echo $_obj['mysqlversion'];
?>
</li>
<li>�ļ��ϴ�����������<?php
echo $_obj['upload'];
?>
</li>
<li>����ϴ����ƣ�����<?php
echo $_obj['maxupload'];
?>
</li>
</ul>
</div>
<div id="rightlist">
<ul>
<li>���ִ��ʱ�䣺����<?php
echo $_obj['maxtime'];
?>
</li>
<li>�ʼ�֧��ģʽ������<?php
echo $_obj['mail'];
?>
</li>
<li>Cookie���ԣ�������<?php
echo $_obj['cookie'];
?>
</li>
<li>register_globals��<?php
echo $_obj['register_globals'];
?>
</li>
<li>������ʱ����������<?php
echo $_obj['timezone'];
?>
</li>
<li>����������ʱ�䣺��<?php
echo $_obj['servertime'];
?>
</li>
</ul>
</div>
</div>
<div class="info" id="clear">
<div class="title">
�����Ŷ�
</div>
<ul>
<li></li>
</ul>
</div>
</body>
</html>