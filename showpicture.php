<?php
srand((double)microtime()*1000000);//播下一个生成随机数字的种子，以方便下面随机数生成的使用
session_start();//将随机数存入session中
$_SESSION['authnum']="";

while(($authnum=rand()%10000)<1000);
//将四位整数验证码绘入图片 
$_SESSION['authnum']=$authnum;
?>
<meta http-equiv="Content-Type" content="text/html; charset=gb2312">
<style type="text/css">
<!--
body {
	margin-left: 0px;
	margin-top: 0px;
}
-->
</style>
<table border="0" align="left" cellpadding="0" cellspacing="0">
  <tr>
    <td><form name="form1">
      <table border="0" align="left" cellpadding="0" cellspacing="0">
        <tr>
          <td>
			<input type="text" name="input_authnum" id="input_authnum" size="6" />
              <img src="picture.php?num=<? echo $authnum; ?>" alt="点击刷新" style="cursor:hand;" onclick="parent.code_check.location.reload();" />
				<input type="hidden" name="authnum" id="authnum" value="<? echo $authnum; ?>" />
		      </td>
        </tr>
      </table>
    </form></td>
  </tr>
</table>
