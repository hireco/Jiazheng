<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html>
<head>
<meta http-equiv="Content-Type" content="text/html; charset=gbk">
<title>Main</title>
<LINK href="styles/main.css" type="text/css" rel="stylesheet">	
</head>
<body>
<h4>欢迎访问红棉家政系统控制面板</h4>
<div class="info">
<div class="title">
红棉产品介绍
</div>
<ul>
<li></li>
</ul>
</div>
<div class="info">
<div class="title">
管理帮助
</div>
<ul>
<li></li>
</ul>
</div>
<div class="info">
<div class="title">
系统信息
</div>
<div id="leftlist">
<ul>
<li>服务器地址：　　　<?php
echo $_obj['serveraddress'];
?>
</li>
<li>服务器软件：　　　<?php
echo $_obj['software'];
?>
</li>
<li>服务器系统：　　　<?php
echo $_obj['OS'];
?>
 </li>
<li>PHP 程序版本：　　<?php
echo $_obj['phpversion'];
?>
</li>
<li>MYSQL 版本：　　　<?php
echo $_obj['mysqlversion'];
?>
</li>
<li>文件上传：　　　　<?php
echo $_obj['upload'];
?>
</li>
<li>最大上传限制：　　<?php
echo $_obj['maxupload'];
?>
</li>
</ul>
</div>
<div id="rightlist">
<ul>
<li>最大执行时间：　　<?php
echo $_obj['maxtime'];
?>
</li>
<li>邮件支持模式：　　<?php
echo $_obj['mail'];
?>
</li>
<li>Cookie测试：　　　<?php
echo $_obj['cookie'];
?>
</li>
<li>register_globals：<?php
echo $_obj['register_globals'];
?>
</li>
<li>服务器时区：　　　<?php
echo $_obj['timezone'];
?>
</li>
<li>服务器所在时间：　<?php
echo $_obj['servertime'];
?>
</li>
</ul>
</div>
</div>
<div class="info" id="clear">
<div class="title">
开发团队
</div>
<ul>
<li></li>
</ul>
</div>
</body>
</html>