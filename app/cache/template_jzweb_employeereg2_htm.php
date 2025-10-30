<meta http-equiv="Content-Type" content="text/html; charset=gb2312" />
<script language="Javascript" src="js/check.js"/></script>
<div align="center">
  <table border="1" width="760" cellspacing="0" cellpadding="0" style="border-collapse: collapse" bordercolor="#E4E4E4">
    <tr>
      <td width="200" bgcolor="#FFCCCC">　</td>
      <td><table cellspacing="0" cellpadding="0" width="550" border="0">
        <tr>
          <td  height="33"><table cellspacing="0" cellpadding="0" width="550" border="0">
            <tr>
              <td width="566"><table cellspacing="0" cellpadding="0" width="397" border="0">
                <tr>
                  <td width="15">　</td>
                  <td width="382"><table cellspacing="0" cellpadding="0" width="504" border="0">
                    <tr>
                      <td width="116" style="font-size: 9pt"><img src="template/jzweb/images/8.gif" width="116" height="41" /></td>
                      <td width="12" background="template/jzweb/images/zhuce-0005.gif" style="font-size: 9pt">　</td>
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
                  <td height="30" colspan="2" align="middle" bgcolor="#FFCCCC"><p> <span>注册第二步：填写用户信息</span>&nbsp; </p></td>
                </tr>
                <tr bgcolor="#fffae8">
                  <td height="25" colspan="2" bgcolor="#FFCCFF"><div align="left">【基本信息】
                      <input type="hidden" name="type" value="employee" />
                      <input type="hidden" name="step" value="3" />
                  </div></td>
                </tr>
                <tr bgcolor="#fffae8">
                  <td align="right" width="120" height="25"><font face="宋体">用 户 名：</font> </td>
                  <td align="left"><table border="0" width="100%" cellspacing="0" cellpadding="0">
                    <tr>
                      <td>
                                <input type="text" name="username"/>
*
<input type="button" name="Submit" value="检查用户名是否存在" onclick="return checkusername()" /></td>
                      </tr>
                  </table></td>
                </tr>
                <tr bgcolor="#fffae8">
                  <td align="right" width="120" height="25"><font face="宋体">密&nbsp;&nbsp;&nbsp; 码：</font> </td>
                  <td><div align="left"><font face="宋体">
                    <input id="txtPassword" type="password" name="password1" />
                    * 限6-16个字符</font></div></td>
                </tr>
                <tr bgcolor="#fffae8">
                  <td align="right" width="120" height="25"><font face="宋体">密码确认：</font> </td>
                  <td><div align="left"><font face="宋体">
                    <input id="txtPassword1" type="password" name="password2" />
*                  </font></div></td>
                </tr>
                <tr bgcolor="#fffae8">
                  <td align="right" width="120" height="25"><font face="宋体">提示问题：</font> </td>
                  <td><div align="left"><font face="宋体">
                    <input type="text" name="question" />
                    * 可以通过回答问题可以寻回遗忘的密码</font></div></td>
                </tr>
                <tr bgcolor="#fffae8">
                  <td align="right" width="120" height="25"><font face="宋体">问题答案：</font> </td>
                  <td><div align="left"><font face="宋体">
                    <input id="answer" name="answer" />
                    * 请牢记填写的答案</font></div></td>
                </tr>
                <tr bgcolor="#fffae8">
                  <td height="25" colspan="2" align="right" bgcolor="#FFCCFF"><p align="left">【详细信息】</p></td>
                </tr>
                <tr bgcolor="#fffae8">
                  <td align="right" width="120" height="25"> 真实姓名<font face="宋体">：</font></td>
                  <td align="left"><div align="left"><font face="宋体">
                    <input id="name" name="name" />
*                  </font></div></td>
                </tr>
                <tr bgcolor="#fffae8">
                  <td align="right" width="120" height="25"> 性别<font face="宋体">：</font></td>
                  <td align="left"><div align="left"><font face="宋体">
                    <select  name="sex">
                      <option value="男">男</option>
                      <option value="女" selected="selected">女</option>
                    </select>
*                  </font></div></td>
                </tr>
                <tr bgcolor="#fffae8">
                  <td align="right" width="120" height="25">出生年份：</td>
                  <td align="left"><div align="left"><font face="宋体">
                    <input id="txtEmail0" name="birthyear" />
                  *</font></div></td>
                </tr>
                <tr bgcolor="#fffae8">
                  <td align="right" width="120" height="25">属相<font face="宋体">：</font></td>
                  <td align="left"><div align="left">
                  <select name="horoscopes" id="horoscopes">
                    <option value="鼠" selected="selected">鼠</option>
                    <option value="牛">牛</option>
                    <option value="虎">虎</option>
                    <option value="兔">兔</option>
                    <option value="龙">龙</option>
                    <option value="蛇">蛇</option>
                    <option value="马">马</option>
                    <option value="羊">羊</option>
                    <option value="猴">猴</option>
                    <option value="鸡">鸡</option>
                    <option value="狗">狗</option>
                    <option value="猪">猪</option>
                  </select>
                  *</div></td>
                </tr>
                <tr bgcolor="#fffae8">
                  <td align="right" height="25">身份证号码：</td>
                  <td align="left"><input type="text" name="identifyid" /> 
                    * </td>
                </tr>
                <tr bgcolor="#fffae8">
                  <td align="right" height="25">籍贯：</td>
                  <td align="left"><input type="text" name="hometown" /></td>
                </tr>
                <tr bgcolor="#fffae8">
                  <td align="right" height="25">民族：</td>
                  <td align="left"><input type="text" name="nation" /></td>
                </tr>
                <tr bgcolor="#fffae8">
                  <td align="right" height="25">学历：</td>
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
                  <td align="right" height="25">固定电话：</td>
                  <td align="left"><input type="text" name="telephone" /> 
                    * </td>
                </tr>
                <tr bgcolor="#fffae8">
                  <td align="right" height="25">手机：</td>
                  <td align="left"><input type="text" name="mobile" /> 
                    * </td>
                </tr>
                <tr bgcolor="#fffae8">
                  <td align="right" height="25">电子邮件：</td>
                  <td align="left"><input type="text" name="email" size="40" /></td>
                </tr>
                <tr bgcolor="#fffae8">
                  <td align="right" height="25">QQ/MSN：</td>
                  <td align="left"><input type="text" name="qq" /></td>
                </tr>
                <tr bgcolor="#fffae8">
                  <td align="right" height="25">所在地区：</td>
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
                  <td align="right" height="25">详细联系地址：</td>
                  <td align="left"><input type="text" name="address" size="50"/>
* </td>
                </tr>
                <tr bgcolor="#fffae8">
                  <td align="right" height="25">服务地区：</td>
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
                  <td align="right" height="25">薪酬要求：</td>
                  <td align="left"><input type="text" name="salary" /> 
                    *（最好填面议）</td>
                </tr>
                <tr bgcolor="#fffae8">
                  <td align="right" height="93">家政经验：</td>
                  <td align="left"><textarea name="experience" cols="40" rows="5"></textarea> 
                    * </td>
                </tr>
                <tr bgcolor="#fffae8">
                  <td align="right" height="25">语言：</td>
                  <td align="left"><select name="language[]" size="4" multiple="multiple" id="language">
                    <option value="普通话">普通话</option>
                    <option value="本地话">本地话</option>
                    <option value="家乡话">家乡话</option>
                    <option value="其他语言">其他语言</option>
                  </select></td>
                </tr>
                <tr bgcolor="#fffae8">
                  <td align="right" height="25">婚姻状况：</td>
                  <td align="left"><select name="marriage" id="marriage">
                    <option value="已婚" selected="selected">已婚</option>
                    <option value="未婚">未婚</option>
                    <option value="离异无孩">离异无孩</option>
                    <option value="离异有孩">离异有孩</option>
                  </select> 
                    * </td>
                </tr>
                <tr bgcolor="#fffae8">
                  <td align="right" height="25">服务类型：</td>
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
                  <td align="right" height="25">上传照片：</td>
                  <td align="left"><input type="file" name="file" size="50"/></td>
                </tr>
                <tr>
                  <td align="middle" bgcolor="#fff2cd" colspan="2" height="30"><div align="center">
                    <input id="submit"  type="submit" value=" 提交 " name="submit" onclick="return checkemployee();" />
&nbsp;
<input onclick="javascript:history.go(-1)" type="button" value="返回上一页" name="back" />
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
      <td align="middle" style="font-size: 12px">　</td>
    </tr>
  </table>
</div>
