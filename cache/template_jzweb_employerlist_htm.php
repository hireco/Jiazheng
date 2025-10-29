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
<DIV align="center">
<TABLE cellSpacing=0 cellPadding=0 width=760 border=0>
  <TBODY>
  <TR>
    <TD height=5></TD></TR></TBODY></TABLE>
<TABLE cellSpacing=0 width=760 border=0>
  <TBODY>
  <TR>
    <TD style="BACKGROUND: #ff6699; BORDER-BOTTOM: #666666 2px solid" width=98 
    height=20>
      <P align="center">雇主列表</P></TD>
    <TD style="BACKGROUND: #ffccff; BORDER-BOTTOM: #666666 2px solid">
      <P align=right> </P></TD></TR></TBODY></TABLE>
<TABLE cellSpacing=0 cellPadding=0 width=760 border=0>
  <TBODY>
  <TR>
    <TD height=5></TD></TR></TBODY></TABLE>
<TABLE style="border-collapse: collapse" bordercolor=#ffffff cellPadding=0 
width=760 border=1>
  <TBODY>
  <TR bgColor=#f7f7f7>
    <TD width="12%" height=24 align=middle bgColor="#efefef">编号</TD>
    <TD width="13%" align=middle bgColor="#efefef">地区</TD>
    <TD width="9%" align=middle bgColor="#efefef">要求性别</TD>
    <TD width="35%" align=middle bgColor="#efefef">服务类型</TD>
    <TD width="19%" align=middle bgColor="#efefef">报酬</TD>
    <TD width="12%" align=middle bgColor="#efefef">聘用状态</TD></TR>
	<?php
if (!empty($_obj['EMPLOYER_LIST'])){
if (!is_array($_obj['EMPLOYER_LIST']))
$_obj['EMPLOYER_LIST']=array(array('EMPLOYER_LIST'=>$_obj['EMPLOYER_LIST']));
$_tmp_arr_keys=array_keys($_obj['EMPLOYER_LIST']);
if ($_tmp_arr_keys[0]!='0')
$_obj['EMPLOYER_LIST']=array(0=>$_obj['EMPLOYER_LIST']);
$_stack[$_stack_cnt++]=$_obj;
foreach ($_obj['EMPLOYER_LIST'] as $rowcnt=>$EMPLOYER_LIST) {
$EMPLOYER_LIST['ROWCNT']=$rowcnt;
$EMPLOYER_LIST['ALTROW']=$rowcnt%2;
$EMPLOYER_LIST['ROWBIT']=$rowcnt%2;
$_obj=&$EMPLOYER_LIST;
?>
	<a href="employerresume.php?id=<?php
echo $_obj['id'];
?>
">
  <TR onMouseOver="mOvr(this,'#f8ecf9');" onMouseOut="mOut(this,'#F7F7F7');" 
  bgColor="#f7f7f7" style="cursor:hand">
    <TD align=middle width="12%" height=25><?php
echo $_obj['id'];
?>
</TD>
    <TD align=middle width="13%"><?php
echo $_obj['area'];
?>
</TD>
    <TD align=middle width="9%"><?php
echo $_obj['ideal_sex'];
?>
</TD>
    <TD align=middle width="35%"><?php
echo $_obj['service'];
?>
</TD>
    <TD align=middle width="19%"><?php
echo $_obj['salary'];
?>
</TD>
    <TD align=middle width="12%"><?php
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
