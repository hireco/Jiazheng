<meta http-equiv="Content-Type" content="text/html; charset=gb2312" />
<script language="Javascript" src="js/check.js"/></script>
<div align="center">
  <table border="1" width="760" cellspacing="0" cellpadding="0" style="border-collapse: collapse" bordercolor="#E4E4E4">
    <tr>
      <td width="200" bgcolor="#FFCCCC">��</td>
      <td><table cellspacing="0" cellpadding="0" width="550" border="0">
        <tr>
          <td  height="33"><table cellspacing="0" cellpadding="0" width="550" border="0">
            <tr>
              <td width="566"><table cellspacing="0" cellpadding="0" width="397" border="0">
                <tr>
                  <td width="15">��</td>
                  <td width="382"><table cellspacing="0" cellpadding="0" width="504" border="0">
                    <tr>
                      <td width="116" style="font-size: 9pt"><img src="template/jzweb/images/8.gif" width="116" height="41" /></td>
                      <td width="12" background="template/jzweb/images/zhuce-0005.gif" style="font-size: 9pt">��</td>
                      <td width="129" background="template/jzweb/images/zhuce-0005.gif" style="font-size: 9pt"><img src="template/jzweb/images/7.gif" width="116" height="41" /></td>
                      <td width="129" background="template/jzweb/images/zhuce-0005.gif" style="font-size: 9pt"><img src="template/jzweb/images/6.gif" width="116" height="41" /> </td>
                      <td width="118" align="right" background="template/jzweb/images/zhuce-0005.gif" style="font-size: 9pt"><img src="template/jzweb/images/5.gif" width="116" height="41" /></td>
                    </tr>
                    <tr>
                      <td colspan="5" style="font-size: 9pt">&nbsp;</td>
                    </tr>
                  </table></td>
                </tr>
              </table></td>
            </tr>
          </table></td>
        </tr>
        <tr>
          <td align="middle"><div id="pnlFirst">
            <table cellspacing="0" width="100%" border="1" bordercolor="#FFFFFF">
              <form action="register.php"  method="post" enctype="multipart/form-data"  name="form" id="form">
                <tr>
                  <td height="30" colspan="2" align="middle" bgcolor="#FFCCCC"><p> <span>ע��ڶ�������д�û���Ϣ</span>&nbsp; </p></td>
                </tr>
                <tr bgcolor="#fffae8">
                  <td height="25" colspan="2" bgcolor="#FFCCFF"><div align="left">��������Ϣ��
                      <input type="hidden" name="type" value="employee" />
                      <input type="hidden" name="step" value="3" />
                  </div></td>
                </tr>
                <tr bgcolor="#fffae8">
                  <td align="right" width="120" height="25"><font face="����">�� �� ����</font> </td>
                  <td align="left"><table border="0" width="100%" cellspacing="0" cellpadding="0">
                    <tr>
                      <td>
                                <input type="text" name="username"/>
*
<input type="button" name="Submit" value="����û����Ƿ����" onclick="return checkusername()" /></td>
                      </tr>
                  </table></td>
                </tr>
                <tr bgcolor="#fffae8">
                  <td align="right" width="120" height="25"><font face="����">��&nbsp;&nbsp;&nbsp; �룺</font> </td>
                  <td><div align="left"><font face="����">
                    <input id="txtPassword" type="password" name="password1" />
                    * ��6-16���ַ�</font></div></td>
                </tr>
                <tr bgcolor="#fffae8">
                  <td align="right" width="120" height="25"><font face="����">����ȷ�ϣ�</font> </td>
                  <td><div align="left"><font face="����">
                    <input id="txtPassword1" type="password" name="password2" />
*                  </font></div></td>
                </tr>
                <tr bgcolor="#fffae8">
                  <td align="right" width="120" height="25"><font face="����">��ʾ���⣺</font> </td>
                  <td><div align="left"><font face="����">
                    <input type="text" name="question" />
                    * ����ͨ���ش��������Ѱ������������</font></div></td>
                </tr>
                <tr bgcolor="#fffae8">
                  <td align="right" width="120" height="25"><font face="����">����𰸣�</font> </td>
                  <td><div align="left"><font face="����">
                    <input id="answer" name="answer" />
                    * ���μ���д�Ĵ�</font></div></td>
                </tr>
                <tr bgcolor="#fffae8">
                  <td height="25" colspan="2" align="right" bgcolor="#FFCCFF"><p align="left">����ϸ��Ϣ��</p></td>
                </tr>
                <tr bgcolor="#fffae8">
                  <td align="right" width="120" height="25"> ��ʵ����<font face="����">��</font></td>
                  <td align="left"><div align="left"><font face="����">
                    <input id="name" name="name" />
*                  </font></div></td>
                </tr>
                <tr bgcolor="#fffae8">
                  <td align="right" width="120" height="25"> �Ա�<font face="����">��</font></td>
                  <td align="left"><div align="left"><font face="����">
                    <select  name="sex">
                      <option value="��">��</option>
                      <option value="Ů" selected="selected">Ů</option>
                    </select>
*                  </font></div></td>
                </tr>
                <tr bgcolor="#fffae8">
                  <td align="right" width="120" height="25">������ݣ�</td>
                  <td align="left"><div align="left"><font face="����">
                    <input id="txtEmail0" name="birthyear" />
                  *</font></div></td>
                </tr>
                <tr bgcolor="#fffae8">
                  <td align="right" width="120" height="25">����<font face="����">��</font></td>
                  <td align="left"><div align="left">
                  <select name="horoscopes" id="horoscopes">
                    <option value="��" selected="selected">��</option>
                    <option value="ţ">ţ</option>
                    <option value="��">��</option>
                    <option value="��">��</option>
                    <option value="��">��</option>
                    <option value="��">��</option>
                    <option value="��">��</option>
                    <option value="��">��</option>
                    <option value="��">��</option>
                    <option value="��">��</option>
                    <option value="��">��</option>
                    <option value="��">��</option>
                  </select>
                  *</div></td>
                </tr>
                <tr bgcolor="#fffae8">
                  <td align="right" height="25">���֤���룺</td>
                  <td align="left"><input type="text" name="identifyid" /> 
                    * </td>
                </tr>
                <tr bgcolor="#fffae8">
                  <td align="right" height="25">���᣺</td>
                  <td align="left"><input type="text" name="hometown" /></td>
                </tr>
                <tr bgcolor="#fffae8">
                  <td align="right" height="25">���壺</td>
                  <td align="left"><input type="text" name="nation" /></td>
                </tr>
                <tr bgcolor="#fffae8">
                  <td align="right" height="25">ѧ����</td>
                  <td align="left"><select name="degree">
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
                    * 
				  </td>
                </tr>
                <tr bgcolor="#fffae8">
                  <td align="right" height="25">�̶��绰��</td>
                  <td align="left"><input type="text" name="telephone" /> 
                    * </td>
                </tr>
                <tr bgcolor="#fffae8">
                  <td align="right" height="25">�ֻ���</td>
                  <td align="left"><input type="text" name="mobile" /> 
                    * </td>
                </tr>
                <tr bgcolor="#fffae8">
                  <td align="right" height="25">�����ʼ���</td>
                  <td align="left"><input type="text" name="email" size="40" /></td>
                </tr>
                <tr bgcolor="#fffae8">
                  <td align="right" height="25">QQ/MSN��</td>
                  <td align="left"><input type="text" name="qq" /></td>
                </tr>
                <tr bgcolor="#fffae8">
                  <td align="right" height="25">���ڵ�����</td>
                  <td align="left"><select name="area">
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
                <tr bgcolor="#fffae8">
                  <td align="right" height="25">��ϸ��ϵ��ַ��</td>
                  <td align="left"><input type="text" name="address" size="50"/>
* </td>
                </tr>
                <tr bgcolor="#fffae8">
                  <td align="right" height="25">���������</td>
                  <td align="left"><select name="service_area[]" size="8" multiple="multiple" id="service_area">
                    <?php
if (!empty($_obj['SERVICE_AREA_LIST'])){
if (!is_array($_obj['SERVICE_AREA_LIST']))
$_obj['SERVICE_AREA_LIST']=array(array('SERVICE_AREA_LIST'=>$_obj['SERVICE_AREA_LIST']));
$_tmp_arr_keys=array_keys($_obj['SERVICE_AREA_LIST']);
if ($_tmp_arr_keys[0]!='0')
$_obj['SERVICE_AREA_LIST']=array(0=>$_obj['SERVICE_AREA_LIST']);
$_stack[$_stack_cnt++]=$_obj;
foreach ($_obj['SERVICE_AREA_LIST'] as $rowcnt=>$SERVICE_AREA_LIST) {
$SERVICE_AREA_LIST['ROWCNT']=$rowcnt;
$SERVICE_AREA_LIST['ALTROW']=$rowcnt%2;
$SERVICE_AREA_LIST['ROWBIT']=$rowcnt%2;
$_obj=&$SERVICE_AREA_LIST;
?>
                    <option value="<?php
echo $_obj['area_name'];
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
                <tr bgcolor="#fffae8">
                  <td align="right" height="25">н��Ҫ��</td>
                  <td align="left"><input type="text" name="salary" /> 
                    *����������飩</td>
                </tr>
                <tr bgcolor="#fffae8">
                  <td align="right" height="93">�������飺</td>
                  <td align="left"><textarea name="experience" cols="40" rows="5"></textarea> 
                    * </td>
                </tr>
                <tr bgcolor="#fffae8">
                  <td align="right" height="25">���ԣ�</td>
                  <td align="left"><select name="language[]" size="4" multiple="multiple" id="language">
                    <option value="��ͨ��">��ͨ��</option>
                    <option value="���ػ�">���ػ�</option>
                    <option value="���绰">���绰</option>
                    <option value="��������">��������</option>
                  </select></td>
                </tr>
                <tr bgcolor="#fffae8">
                  <td align="right" height="25">����״����</td>
                  <td align="left"><select name="marriage" id="marriage">
                    <option value="�ѻ�" selected="selected">�ѻ�</option>
                    <option value="δ��">δ��</option>
                    <option value="�����޺�">�����޺�</option>
                    <option value="�����к�">�����к�</option>
                  </select> 
                    * </td>
                </tr>
                <tr bgcolor="#fffae8">
                  <td align="right" height="25">�������ͣ�</td>
                  <td align="left"><select name="service[]" size="8" multiple="multiple" id="service">
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
                <tr bgcolor="#fffae8">
                  <td align="right" height="25">�ϴ���Ƭ��</td>
                  <td align="left"><input type="file" name="file" size="50"/></td>
                </tr>
                <tr>
                  <td align="middle" bgcolor="#fff2cd" colspan="2" height="30"><div align="center">
                    <input id="submit"  type="submit" value=" �ύ " name="submit" onclick="return checkemployee();" />
&nbsp;
<input onclick="javascript:history.go(-1)" type="button" value="������һҳ" name="back" />
</div></td>
                </tr>
              </form>
            </table>
          </div></td>
        </tr>
      </table></td>
    </tr>
  </table>
  <table height="6" cellspacing="0" cellpadding="0" width="760" align="center" border="0">
    <tr>
      <td align="middle" style="font-size: 12px">��</td>
    </tr>
  </table>
</div>
