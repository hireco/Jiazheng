<table width="760" border="1" align="center" cellpadding="0" cellspacing="0" bordercolor="#FFFFFF">
  <tr>
    <td width="166" bgcolor="#FFCCCC"><div align="center">项目名称</div></td>
    <td width="80" height="20" bgcolor="#FFCCCC"><div align="center">收费标准</div></td>
    <td width="514" bgcolor="#FFCCCC"><div align="center">服务内容</div></td>
  </tr>
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
  <tr>
    <td align="center" bgcolor="#FDF0F0"><?php
echo $_obj['name'];
?>
</td>
    <td height="20" align="center" bgcolor="#FDF0F0"><?php
echo $_obj['fee'];
?>
</td>
    <td bgcolor="#FDF0F0"><?php
echo $_obj['intro'];
?>
</td>
  </tr>
  <?php
}
$_obj=$_stack[--$_stack_cnt];}
?>
</table>
