<?php
srand((double)microtime()*1000000);//����һ������������ֵ����ӣ��Է���������������ɵ�ʹ��
session_start();//�����������session��
$_SESSION['authnum']="";

while(($authnum=rand()%10000)<1000);
//����λ������֤�����ͼƬ 
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
              <img src="picture.php?num=<? echo $authnum; ?>" alt="���ˢ��" style="cursor:hand;" onclick="parent.code_check.location.reload();" />
				<input type="hidden" name="authnum" id="authnum" value="<? echo $authnum; ?>" />
		      </td>
        </tr>
      </table>
    </form></td>
  </tr>
</table>
