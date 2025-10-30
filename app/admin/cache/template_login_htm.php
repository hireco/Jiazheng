<html>
<head>
<meta http-equiv="Content-Type" content="text/html; charset=gbk">
<link rel="StyleSheet" href="styles/login.css" type="text/css"/>
<title>登陆</title>
</head>
<body>
<div id="loginForm">
<div id="loginTitle">
管理员登陆
</div>
<form method="POST" action="index.php?a=dologin">
<ul>
<li>用户名　<input type="text" name="username"class="inputBox" /></li>
<li>密　码　<input type="password" name="password" class="inputBox" /></li>
<?php
if (!empty($_obj['VERIFY'])){
?>
<li>验证码　<input type="text" name="code" class="inputBox" size="11" /><img src="picture.php" alt="点击刷新" onclick="this.src='picture.php'" style="cursor:hand;" /></li>
<?php
}
?>
<li><input type="submit" value="登陆" class="inputButton" /></li>
</ul>
</form>
</div>
</body>
