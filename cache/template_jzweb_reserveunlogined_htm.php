<script language="Javascript" src="js/check.js"/></script>
<div align="center">
<form id="form" name="form" method="post" action="reserve.php">
  <table cellspacing="0" cellpadding="0" width="760" border="0">
    <tbody>
      <tr>
        <td valign="top" width="198" bgcolor="#FFCCCC">　</td>
        <td valign="top" width="2">　</td>
        <td valign="top" width="560"><table cellspacing="0" cellpadding="0" width="100%" border="0">
          <tbody>
            <tr>
              <td width="100%"><table class="border" cellspacing="0" cellpadding="0" width="100%" 
            align="center">
                <tbody>
                  <tr class="bg_l">
                    <td height="25" align="right" bgcolor="#FFCCCC"><p align="left">&nbsp;您所在的位置:<a href="index.php">首页</a>&nbsp;&gt;请家政</p></td>
                  </tr>
                </tbody>
              </table></td>
            </tr>
          </tbody>
        </table>
            <table cellspacing="0" cellpadding="0" width="100%" align="center">
              <tbody>
                <tr>
                  <td align="right" height="3"></td>
                </tr>
              </tbody>
            </table>
          <table cellspacing="0" cellpadding="0" width="100%" border="0">
              <tbody>
                <tr>
                  <td width="1"></td>
                  <td width="100%" valign="top"><table class="border" cellspacing="0" cellpadding="0" width="100%" 
            align="center">
                      <tbody>
                        <tr class="bg_l">
                          <td height="24" align="left" bgcolor="#FFCCFF">&nbsp;<strong>预约雇员</strong></td>
                        </tr>
                      </tbody>
                  </table>
                      <table cellspacing="0" cellpadding="0" width="98%" align="center">
                        <tbody>
                          <tr>
                            <td align="right" height="3"></td>
                          </tr>
                        </tbody>
                      </table>
                    <table width="100%" border="1" 
            align="center" cellpadding="0" cellspacing="1" bordercolor="#FFCCCC" bgcolor="#FFFFFF" class="border">
                        <tbody>
                          <tr class="bg_l">
                            <td height="24" align="left" nowrap="NOWRAP">&nbsp;被预约编号：</td>
                            <td width="448" align="left">&nbsp;<input type="text" name="did" value="<?php
echo $_obj['did'];
?>
" readonly="readonly" /></td>
                          </tr>
                          <tr class="bg_l">
                            <td height="24" align="left" nowrap="NOWRAP">&nbsp;发出预约者姓名:</td>
                            <td align="left">&nbsp;<input name="sname" type="text" /> 
                            * </td>
                          </tr>
                          <tr class="bg_l">
                            <td height="24" align="left" nowrap="nowrap">&nbsp;服务项目:</td>
                            <td align="left">&nbsp;<select name="service[]" size="8" multiple="multiple" id="service">
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
                            * </td>
                          </tr>
                          <tr class="bg_l">
                            <td height="24" align="left" nowrap="NOWRAP">&nbsp;发出预约者电话:</td>
                            <td align="left">&nbsp;<input name="telephone" type="text" /> 
                            * </td>
                          </tr>
                          <tr class="bg_l">
                            <td height="24" align="left" nowrap="NOWRAP">&nbsp;发出预约者手机:</td>
                            <td align="left">&nbsp;<input name="mobile" type="text" /> 
                            * </td>
                          </tr>
                          <tr class="bg_l">
                            <td height="24" align="left" nowrap="nowrap">&nbsp;发出预约者邮件:</td>
                            <td align="left">&nbsp;<input name="email" type="text" /></td>
                          </tr>
                          <tr class="bg_l">
                            <td height="24" align="left" nowrap="nowrap">&nbsp;发出预约者地区:</td>
                            <td align="left">&nbsp;<select name="area">
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
                            * </td>
                          </tr>
                          <tr class="bg_l">
                            <td height="24" align="left" nowrap="nowrap">&nbsp;MSN/QQ:</td>
                            <td align="left">&nbsp;<input name="qq" type="text" /></td>
                          </tr>
                          <tr class="bg_l">
                            <td height="24" align="left" nowrap="nowrap">&nbsp;详细地址:</td>
                            <td 
                  align="left">&nbsp;<input name="address" type="text" size="50" /> 
                            * </td>
                          </tr>
                          <tr class="bg_l">
                            <td height="24" align="left" nowrap="nowrap">&nbsp;特别说明：</td>
                            <td 
                  align="left">&nbsp;<textarea name="snote" cols="50" rows="5"></textarea></td>
                          </tr>
                          <tr class="bg_l">
                            <td height="24" colspan="2" align="left">
                              <table cellspacing="0" cellpadding="0" width="99%" align="center">
                                <tbody>
                                  <tr>
                                    <td width="544" height="35" valign="bottom"><label> </label>
                                      <div align="center">
                                          <input type="submit" name="Submit" value="预约" onclick="return checkreserve()" />
                                          <input type="hidden" name="step" value="2">
                                      </div></td>
                                  </tr>
                                </tbody>
                              </table>
                            </td>
                          </tr>
                        </tbody>
                  </table></td>
                </tr>
              </tbody>
          </table>
        </td>
      </tr>
    </tbody>
  </table>
</form>
</div>
