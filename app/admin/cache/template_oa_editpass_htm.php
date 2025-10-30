<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.0 Transitional//EN">
<HTML>
<HEAD>
<TITLE>红棉家政管理后台</TITLE>
<link href="styles/editpass.css" rel="stylesheet" type="text/css" />
</HEAD>
<BODY>
<div id="main">
<div id="passTable">
<form method="POST" action="index.php?a=doeditpass">
<div><font color=red>您好 <?php
echo $_obj['username'];
?>
，您的密码还未修改，或者已经过期了</font></div>
<div>请输入新密码 <input type="password" name="password" class="login_input" /></div>
<div>&nbsp;&nbsp;请再次输入 <input type="password" name="repassword" class="login_input" /><br/></div>
<div class="buttomli"><input type="submit" value="确定"/></div>
</form>
</div>

<div id="footer">
版权所有：
</div>
</div>
</BODY>
</HTML>
