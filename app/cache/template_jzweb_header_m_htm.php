<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=gb2312" />
<meta name="keywords" content="<?php
echo $_obj['keyword'];
?>
" />
<meta name="description" content="<?php
echo $_obj['description'];
?>
" />
<link rel="StyleSheet" href="template/jzweb/styles/style.css" type="text/css"/>
<title><?php
echo $_obj['TITLE'];
?>
</title>
</head>
<body style="font-size:12px;">
<div align="center">
<?php
echo $_obj['AD_LEFT'];
?>

</div>
<div align="center">
<table style="BORDER-RIGHT: 0px solid; BORDER-LEFT: 0px solid" 
bordercolor="#6c6c6c" cellpadding="0" width="760">
    <tbody>
      <tr>
        <td width="217" align="center" valign="middle">
		<iframe name="hidden_frame" style="display:none;"></iframe>
		<a href="<?php
echo $_obj['url'];
?>
" title="<?php
echo $_obj['TITLE'];
?>
"><img src="<?php
echo $_obj['logo'];
?>
" border="0" /></a>
		</td>
        <td align="right"><table cellspacing="0" width="100%" border="0">
              <tbody>
                <tr>
                  <td height="25"><p align="right"><span style="CURSOR: hand" onClick="window.external.addFavorite('<?php
echo $_obj['url'];
?>
','<?php
echo $_obj['TITLE'];
?>
')" title="<?php
echo $_obj['TITLE'];
?>
">收藏本站</span>
    </p></td>
                </tr>
              </tbody>
            </table>
          <table height="25" cellspacing="0" width="100%" border="0">
              <tbody>
                <tr>
                  <td><p align="right"><a href="register.php">注册</a>&nbsp;&nbsp;&nbsp;<a href="#" onclick="window.open('fastregister.php','newwin', 'height=320, width=480, toolbar=no, menubar=no, scrollbars=no, resizable=no,location=no, status=no')">快速登记</a></p></td>
                </tr>
              </tbody>
          </table></td>
      </tr>
    </tbody>
  </table>
  <table cellspacing="0" width="760" bgcolor="#ff99cc" border="0">
    <tbody>
      <tr>
        <td height="23"><p align="center" class="nav">
		<?php
if (!empty($_obj['NAV'])){
if (!is_array($_obj['NAV']))
$_obj['NAV']=array(array('NAV'=>$_obj['NAV']));
$_tmp_arr_keys=array_keys($_obj['NAV']);
if ($_tmp_arr_keys[0]!='0')
$_obj['NAV']=array(0=>$_obj['NAV']);
$_stack[$_stack_cnt++]=$_obj;
foreach ($_obj['NAV'] as $rowcnt=>$NAV) {
$NAV['ROWCNT']=$rowcnt;
$NAV['ALTROW']=$rowcnt%2;
$NAV['ROWBIT']=$rowcnt%2;
$_obj=&$NAV;
?>
		<a href="<?php
echo $_obj['link'];
?>
"><?php
echo $_obj['name'];
?>
</a><span>|
		<?php
}
$_obj=$_stack[--$_stack_cnt];}
?>
		</span>      </tr>
    </tbody>
  </table>
  <table cellspacing="0" cellpadding="0" width="760" border="0">
    <tbody>
      <tr>
        <td height="2"></td>
      </tr>
    </tbody>
  </table>
  <table width="760" height="25" border="1" cellpadding="0" bordercolor="#CCCCCC" class="border">
    <form method="get" action="search.php">
      <tbody>
        <tr>
          <td width="333" height="21" align="right" valign="middle"><select name="type" style="FONT-SIZE: 12px; BACKGROUND-COLOR: #ffffff" >
            <option value="employee" selected>做家政</option>
            <option value="employer">请家政</option>
          </select>              
            <select name="service" style="FONT-SIZE: 12px; BACKGROUND-COLOR: #ffffff">
              <option value="不限" selected="selected">分类不限</option>
			  <?php
if (!empty($_obj['SERVICE_LIST'])){
if (!is_array($_obj['SERVICE_LIST']))
$_obj['SERVICE_LIST']=array(array('SERVICE_LIST'=>$_obj['SERVICE_LIST']));
$_tmp_arr_keys=array_keys($_obj['SERVICE_LIST']);
if ($_tmp_arr_keys[0]!='0')
$_obj['SERVICE_LIST']=array(0=>$_obj['SERVICE_LIST']);
$_stack[$_stack_cnt++]=$_obj;
foreach ($_obj['SERVICE_LIST'] as $rowcnt=>$SERVICE_LIST) {
$SERVICE_LIST['ROWCNT']=$rowcnt;
$SERVICE_LIST['ALTROW']=$rowcnt%2;
$SERVICE_LIST['ROWBIT']=$rowcnt%2;
$_obj=&$SERVICE_LIST;
?>
			  <option value="<?php
echo $_obj['service_name'];
?>
"><?php
echo $_obj['service_name'];
?>
</option>
			  <?php
}
$_obj=$_stack[--$_stack_cnt];}
?>
            </select>            
            <select name="area" style="FONT-SIZE: 12px; BACKGROUND-COLOR: #ffffff" size="1">
              <option value="0" selected="selected">市区不限</option>
              <?php
if (!empty($_obj['AREA_LIST'])){
if (!is_array($_obj['AREA_LIST']))
$_obj['AREA_LIST']=array(array('AREA_LIST'=>$_obj['AREA_LIST']));
$_tmp_arr_keys=array_keys($_obj['AREA_LIST']);
if ($_tmp_arr_keys[0]!='0')
$_obj['AREA_LIST']=array(0=>$_obj['AREA_LIST']);
$_stack[$_stack_cnt++]=$_obj;
foreach ($_obj['AREA_LIST'] as $rowcnt=>$AREA_LIST) {
$AREA_LIST['ROWCNT']=$rowcnt;
$AREA_LIST['ALTROW']=$rowcnt%2;
$AREA_LIST['ROWBIT']=$rowcnt%2;
$_obj=&$AREA_LIST;
?>
              <option value="<?php
echo $_obj['area_id'];
?>
"><?php
echo $_obj['area_name'];
?>
</option>
              <?php
}
$_obj=$_stack[--$_stack_cnt];}
?>
            </select>          
          &nbsp;&nbsp; </td><td width="284" valign="middle" nowrap="nowrap"  style="DISPLAY: block">
		  <select name="degree" style="FONT-SIZE: 12px; BACKGROUND-COLOR: #ffffff" size="1">
            <option value="0" selected="selected">文凭不限</option>
              <?php
if (!empty($_obj['DEGREE_LIST'])){
if (!is_array($_obj['DEGREE_LIST']))
$_obj['DEGREE_LIST']=array(array('DEGREE_LIST'=>$_obj['DEGREE_LIST']));
$_tmp_arr_keys=array_keys($_obj['DEGREE_LIST']);
if ($_tmp_arr_keys[0]!='0')
$_obj['DEGREE_LIST']=array(0=>$_obj['DEGREE_LIST']);
$_stack[$_stack_cnt++]=$_obj;
foreach ($_obj['DEGREE_LIST'] as $rowcnt=>$DEGREE_LIST) {
$DEGREE_LIST['ROWCNT']=$rowcnt;
$DEGREE_LIST['ALTROW']=$rowcnt%2;
$DEGREE_LIST['ROWBIT']=$rowcnt%2;
$_obj=&$DEGREE_LIST;
?>
              <option value="<?php
echo $_obj['degree_id'];
?>
"><?php
echo $_obj['degree_name'];
?>
</option>
              <?php
}
$_obj=$_stack[--$_stack_cnt];}
?>
          </select>
&nbsp;
<select name="age" style="FONT-SIZE: 12px; BACKGROUND-COLOR: #ffffff" size="1">
  <option value="0" selected="selected">年龄不限</option>
  <option value="1">20岁以下</option>
  <option value="2">20-30岁</option>
  <option value="3">30-40岁</option>
  <option value="4">40-50岁</option>
  <option value="5">50-60岁</option>
  <option value="6">60岁以上</option>
</select>
&nbsp; <font color="#ffffff"><b>
<select name="sex" style="FONT-SIZE: 12px; BACKGROUND-COLOR: #ffffff" size="1">
  <option  value="不限" selected="selected">性别不限</option>
  <option value="男">男</option>
  <option value="女">女</option>
</select>
</b></font></td>
          <td width="190" nowrap="nowrap" style="DISPLAY: block"><div align="center">
            <input type="submit" value="搜索" />
          </div></td>
        </tr>
      </tbody>
    </form>
  </table>
  <table cellspacing="0" cellpadding="0" width="760" border="0">
    <tbody>
      <tr>
        <td height="5"></td>
      </tr>
    </tbody>
  </table>
</div>