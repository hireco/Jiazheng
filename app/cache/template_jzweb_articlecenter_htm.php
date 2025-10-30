<table width="760" border="0" align="center" cellpadding="0" cellspacing="0">
  <tr>
    <td width="164" height="188" valign="top" bgcolor="#FFCCFF"><table width="100%" border="0" cellspacing="0" cellpadding="0">
      <tr>
        <td height="27" bgcolor="#FFCCFF"><div align="center">【热门文章列表】</div></td>
      </tr>
    </table>
        <table width="100%" height="161" border="0" cellpadding="0" cellspacing="1">
          <tr>
            <td valign="top" bgcolor="#FFFFFF"><table width="100%" border="0" cellspacing="0" cellpadding="0">
			<?php
if (!empty($_obj['HOT_LIST'])){
if (!is_array($_obj['HOT_LIST']))
$_obj['HOT_LIST']=array(array('HOT_LIST'=>$_obj['HOT_LIST']));
$_tmp_arr_keys=array_keys($_obj['HOT_LIST']);
if ($_tmp_arr_keys[0]!='0')
$_obj['HOT_LIST']=array(0=>$_obj['HOT_LIST']);
$_stack[$_stack_cnt++]=$_obj;
foreach ($_obj['HOT_LIST'] as $rowcnt=>$HOT_LIST) {
$HOT_LIST['ROWCNT']=$rowcnt;
$HOT_LIST['ALTROW']=$rowcnt%2;
$HOT_LIST['ROWBIT']=$rowcnt%2;
$_obj=&$HOT_LIST;
?>
                <tr>
                  <td width="11%" height="19"><a href="article.php?id=<?php
echo $_obj['hot_id'];
?>
" title="<?php
echo $_obj['hot_title'];
?>
"><?php
echo $_obj['hot_short'];
?>
</a></td>
                </tr>
			<?php
}
$_obj=$_stack[--$_stack_cnt];}
?>
            </table></td>
          </tr>
      </table></td>
    <td valign="top"><table width="100%" border="0" cellpadding="0" cellspacing="0">
      <tr>
        <td height="26" bgcolor="#FFCCCC">&nbsp;&nbsp;&nbsp;你所在位置-新闻中心</td>
      </tr>
      <tr>
        <td height="162" valign="top" bgcolor="#FFCCCC"><table width="100%" height="auto">
          <tr>
            <td height="342" valign="top" bgcolor="#FFFFFF">
<?php
if (!empty($_obj['LIST'])){
if (!is_array($_obj['LIST']))
$_obj['LIST']=array(array('LIST'=>$_obj['LIST']));
$_tmp_arr_keys=array_keys($_obj['LIST']);
if ($_tmp_arr_keys[0]!='0')
$_obj['LIST']=array(0=>$_obj['LIST']);
$_stack[$_stack_cnt++]=$_obj;
foreach ($_obj['LIST'] as $rowcnt=>$LIST) {
$LIST['ROWCNT']=$rowcnt;
$LIST['ALTROW']=$rowcnt%2;
$LIST['ROWBIT']=$rowcnt%2;
$_obj=&$LIST;
?>
<div style="margin-left:5px;margin-top:5px;width:280px;float:left;height:80px;">
  <table width="100%" border="1" bordercolor="#FFCCCC">
    <tr>
      <td bgcolor="#FFCC99"><a href="articlelist.php?id=<?php
echo $_obj['id'];
?>
"><?php
echo $_obj['name'];
?>
</a></td>
    </tr>
    <tr>
	  <td height="100" valign="top" bgcolor="#FFFFFF">
	  <?php
echo $_obj['article'];
?>
</td>
    </tr>
  </table>
</div>
<?php
}
$_obj=$_stack[--$_stack_cnt];}
?>
			</td>
          </tr>
        </table></td>
      </tr>
    </table></td>
  </tr>
</table>
</body>
</html>
