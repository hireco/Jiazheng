<html>
<head>
<meta http-equiv="Content-Type" content="text/html; charset=gbk">
<link rel="StyleSheet" href="styles/login.css" type="text/css"/>
<title>��½</title>
</head>
<body>
<div id="loginForm">
<div id="loginTitle">
����Ա��½
</div>
<form method="POST" action="index.php?a=dologin">
<ul>
<li>�û�����<input type="text" name="username"class="inputBox" /></li>
<li>�ܡ��롡<input type="password" name="password" class="inputBox" /></li>
<?php
if (!empty($_obj['VERIFY'])){
?>
<li>��֤�롡<input type="text" name="code" class="inputBox" size="11" /><img src="picture.php" alt="���ˢ��" onclick="this.src='picture.php'" style="cursor:hand;" /></li>
<?php
}
?>
<li><input type="submit" value="��½" class="inputButton" /></li>
</ul>
</form>
</div>
</body>
