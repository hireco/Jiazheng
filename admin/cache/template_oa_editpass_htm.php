<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.0 Transitional//EN">
<HTML>
<HEAD>
<TITLE>���޼��������̨</TITLE>
<link href="styles/editpass.css" rel="stylesheet" type="text/css" />
</HEAD>
<BODY>
<div id="main">
<div id="passTable">
<form method="POST" action="index.php?a=doeditpass">
<div><font color=red>���� <?php
echo $_obj['username'];
?>
���������뻹δ�޸ģ������Ѿ�������</font></div>
<div>������������ <input type="password" name="password" class="login_input" /></div>
<div>&nbsp;&nbsp;���ٴ����� <input type="password" name="repassword" class="login_input" /><br/></div>
<div class="buttomli"><input type="submit" value="ȷ��"/></div>
</form>
</div>

<div id="footer">
��Ȩ���У�
</div>
</div>
</BODY>
</HTML>
