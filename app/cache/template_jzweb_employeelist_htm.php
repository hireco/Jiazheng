<SCRIPT language=javaScript>
<!--
function mOvr(src,clrOver){ 
	if (!src.contains(event.fromElement)) { 
		src.bgColor = clrOver; 
	}
}
function mOut(src,clrIn)  { 
	if (!src.contains(event.toElement)) { 
		src.bgColor = clrIn; 
	}
} 
//-->
</SCRIPT>
<DIV align=center>
<TABLE cellSpacing=0 cellPadding=0 width=760 border=0>
  <TBODY>
  <TR>
    <TD height=5></TD></TR></TBODY></TABLE>
<TABLE cellSpacing=0 width=760 border=0>
  <TBODY>
  <TR>
    <TD style="BACKGROUND: #ff6699; BORDER-BOTTOM: #666666 2px solid" width=98 
    height=20>
      <P align="center">雇员列表</P></TD>
    <TD style="BACKGROUND: #ffccff; BORDER-BOTTOM: #666666 2px solid">
      <P align="right"> </P></TD></TR></TBODY></TABLE>
<TABLE cellSpacing=0 cellPadding=0 width=760 border=0>
  <TBODY>
  <TR>
    <TD height=5></TD></TR></TBODY></TABLE>
<TABLE style="BORDER-COLLAPSE: collapse" borderColor=#ffffff cellPadding=0 
width=760 border=1>
  <TBODY>
  <TR bgColor=#f7f7f7>
    <TD width="12%" height="24" align="middle" bgColor="#efefef">编号</TD>
    <TD width="13%" align="middle" bgColor="#efefef">地区</TD>
    <TD width="7%" align="middle" bgColor="#efefef">性别</TD>
    <TD width="35%" align="middle" bgColor="#efefef">服务类型</TD>
    <TD width="21%" align="middle" bgColor="#efefef">报酬</TD>
    <TD width="12%" align="middle" bgColor="#efefef">聘用状态</TD></TR>
	<?php
if (!empty($_obj['EMPLOYEE_LIST'])){
if (!is_array($_obj['EMPLOYEE_LIST']))
$_obj['EMPLOYEE_LIST']=array(array('EMPLOYEE_LIST'=>$_obj['EMPLOYEE_LIST']));
$_tmp_arr_keys=array_keys($_obj['EMPLOYEE_LIST']);
if ($_tmp_arr_keys[0]!='0')
$_obj['EMPLOYEE_LIST']=array(0=>$_obj['EMPLOYEE_LIST']);
$_stack[$_stack_cnt++]=$_obj;
foreach ($_obj['EMPLOYEE_LIST'] as $rowcnt=>$EMPLOYEE_LIST) {
$EMPLOYEE_LIST['ROWCNT']=$rowcnt;
$EMPLOYEE_LIST['ALTROW']=$rowcnt%2;
$EMPLOYEE_LIST['ROWBIT']=$rowcnt%2;
$_obj=&$EMPLOYEE_LIST;
?>
	<a href="employeeresume.php?id=<?php
echo $_obj['id'];
?>
">
  <TR onMouseOver="mOvr(this,'#f8ecf9');" onMouseOut="mOut(this,'#F7F7F7');" 
  bgColor="#f7f7f7" style="cursor:hand">
    <TD align="middle" width="12%" height="25"><?php
echo $_obj['id'];
?>
</TD>
    <TD align="middle" width="13%"><?php
echo $_obj['area'];
?>
</TD>
    <TD align="middle" width="7%"><?php
echo $_obj['sex'];
?>
</TD>
    <TD align="middle" width="35%"><?php
echo $_obj['service'];
?>
</TD>
    <TD align="middle" width="21%"><?php
echo $_obj['salary'];
?>
</TD>
    <TD align="middle" width="12%"><?php
echo $_obj['occupied'];
?>
</TD>
  </TR>
  </a>
  <?php
}
$_obj=$_stack[--$_stack_cnt];}
?>
  <TR align="right" 
  bgColor=#f7f7f7 onMouseOver="mOvr(this,'#f8ecf9');" onMouseOut="mOut(this,'#F7F7F7');">
    <TD height=25 colspan="6"><?php
echo $_obj['pagechar'];
?>
</TD>
    </TR>
  </TBODY></TABLE>
</DIV>
