<div align="center">
  <table id="table3" cellspacing="0" cellpadding="0" width="778" border="0">
    <tbody>
      <tr>
        <td background="" height="1"></td>
      </tr>
    </tbody>
  </table>
  <table width="760" border="0" cellspacing="0" cellpadding="0">
    <tr>
      <td width="235" valign="top"><table width="100%" height="24" border="1" cellpadding="0" cellspacing="0" bordercolor="#CCCCCC">
        <tr>
          <td height="22" bgcolor="#ffccff"><table width="100%" border="0" cellspacing="0" cellpadding="0">
            <tr>
              <td height="19"><div align="center">【关于我们】</div></td>
            </tr>
          </table>            </td>
        </tr>

        
      </table>
        <table width="100%" border="0" cellspacing="0" cellpadding="0">
		<?php
if (!empty($_obj['COMPANY_LIST'])){
if (!is_array($_obj['COMPANY_LIST']))
$_obj['COMPANY_LIST']=array(array('COMPANY_LIST'=>$_obj['COMPANY_LIST']));
$_tmp_arr_keys=array_keys($_obj['COMPANY_LIST']);
if ($_tmp_arr_keys[0]!='0')
$_obj['COMPANY_LIST']=array(0=>$_obj['COMPANY_LIST']);
$_stack[$_stack_cnt++]=$_obj;
foreach ($_obj['COMPANY_LIST'] as $rowcnt=>$COMPANY_LIST) {
$COMPANY_LIST['ROWCNT']=$rowcnt;
$COMPANY_LIST['ALTROW']=$rowcnt%2;
$COMPANY_LIST['ROWBIT']=$rowcnt%2;
$_obj=&$COMPANY_LIST;
?>
          <tr>
            <td height="25"><div align="center"><a href="aboutus.php?id=<?php
echo $_obj['id'];
?>
"><?php
echo $_obj['name'];
?>
</a></div></td>
          </tr>
		<?php
}
$_obj=$_stack[--$_stack_cnt];}
?>
        </table>
      <p>&nbsp;</p>
      <p>&nbsp;</p>
      <p>&nbsp;</p>
      </td>
      <td width="525"><table width="100%" height="200" border="0" cellpadding="0" cellspacing="0">
        <tr>
          <td width="1%">&nbsp;</td>
          <td width="96%" height="22" bgcolor="#ffcccc"><div align="left">&nbsp;&nbsp;&nbsp;&nbsp;你所在的位置-<a href="index.php">首页</a>-关于我们</div></td>
          <td width="3%" bgcolor="#FFcccc">&nbsp;</td>
        </tr>
        <tr>
          <td height="178" colspan="3"><table width="100%" height="167" border="0" cellpadding="0" cellspacing="0">
            <tr>
              <td height="18">&nbsp;</td>
              <td><div align="center"><?php
echo $_obj['name'];
?>
</div></td>
              <td>&nbsp;</td>
            </tr>
            <tr height="auto">
              <td width="2%" height="149">&nbsp;</td>
              <td width="96%"><?php
echo $_obj['content'];
?>
</td>
              <td width="2%">&nbsp;</td>
            </tr>
          </table></td>
        </tr>
      </table></td>
    </tr>
  </table>
  </div>
</body>
</html>
