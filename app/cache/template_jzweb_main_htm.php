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
<div align="center">
    <table cellspacing="0" cellpadding="0" width="760" border="0">
        <tr>
          <td valign="top" align="middle" height="22"><table cellspacing="0" width="100%" border="0">
            <tbody>
              <tr>
                <td style="BACKGROUND: #ff99cc; BORDER-BOTTOM: #666666 2px solid" 
          width="98" height="20"><p align="center">推荐雇员</p></td>
                <td style="BACKGROUND: #ffccff; BORDER-BOTTOM: #666666 2px solid"><p align="right"><a href="recommendlist.php">more</a>&nbsp;&nbsp;</p></td>
              </tr>
            </tbody>
          </table>
              <table cellspacing="0" cellpadding="0" width="100%" border="0">
                <tbody>
                  <tr>
                    <td height="2"></td>
                  </tr>
                </tbody>
              </table>
            <table width="100%" 
      border="1" align="center" cellpadding="0" cellspacing="1" bordercolor="#FFCCFF" class="border">
                <tbody>
                  <tr class="bg_l">
                    <td align="left" width="24%" height="24"><p align="center"><br />
                      </p>
					  <?php
if (!empty($_obj['REC_LIST'])){
if (!is_array($_obj['REC_LIST']))
$_obj['REC_LIST']=array(array('REC_LIST'=>$_obj['REC_LIST']));
$_tmp_arr_keys=array_keys($_obj['REC_LIST']);
if ($_tmp_arr_keys[0]!='0')
$_obj['REC_LIST']=array(0=>$_obj['REC_LIST']);
$_stack[$_stack_cnt++]=$_obj;
foreach ($_obj['REC_LIST'] as $rowcnt=>$REC_LIST) {
$REC_LIST['ROWCNT']=$rowcnt;
$REC_LIST['ALTROW']=$rowcnt%2;
$REC_LIST['ROWBIT']=$rowcnt%2;
$_obj=&$REC_LIST;
?>
                        <table width="25%" border="0" style="float:left;">
                          <tbody>
                            <tr>
                              <td align="center" valign="middle" width="120" height="120"><a href="employeeresume.php?id=<?php
echo $_obj['id'];
?>
"><img src="<?php
echo $_obj['pic'];
?>
" name="photo" width="<?php
echo $_obj['width'];
?>
" height="<?php
echo $_obj['height'];
?>
" border="0" id="photo" /></a></td>
                            </tr>
                            <tr>
                              <td><p align="center"><a href="employeeresume.php?id=<?php
echo $_obj['id'];
?>
">查看资料</a></p></td>
                            </tr>
                          </tbody>
                        </table>
						<?php
}
$_obj=$_stack[--$_stack_cnt];}
?>
                      </P></td>
                  </tr>
                </tbody>
            </table>
            <table cellspacing="0" cellpadding="0" width="100%" border="0">
                <tbody>
                  <tr>
                    <td height="2"></td>
                  </tr>
                </tbody>
            </table>
            <table cellspacing="0" width="100%" border="0">
                <tbody>
                  <tr>
                    <td style="BACKGROUND: #ff99cc; BORDER-BOTTOM: #666666 2px solid" 
          width="98" height="20"><p align="center">最新雇员</p></td>
                    <td style="BACKGROUND: #ffccff; BORDER-BOTTOM: #666666 2px solid"><p align="right">&nbsp;</p></td>
                    <td style="BACKGROUND: #ffccff; BORDER-BOTTOM: #666666 2px solid" 
          width="62"><p align="center"><a href="employeelist.php">more</a></p></td>
                  </tr>
                </tbody>
            </table>
            <table cellspacing="0" cellpadding="0" width="100%" border="0">
                <tbody>
                  <tr>
                    <td height="2"></td>
                  </tr>
                </tbody>
            </table>
            <table class="border" cellspacing="1" cellpadding="0" width="100%" align="center" 
      border="0">
                  <tr>
                    <td><table style="BORDER-COLLAPSE: collapse" bordercolor="#ffffff" 
            cellpadding="0" width="100%" border="1">
                        <tbody>
                          <tr bgcolor="#f7f7f7">
                            <td align="middle" width="10%" bgcolor="#efefef" height="25">编号</td>
                            <td align="middle" width="34%" bgcolor="#efefef">服务类型</td>
                            <td align="middle" width="13%" bgcolor="#efefef">地区</td>
                            <td align="middle" width="8%" bgcolor="#efefef">性别</td>
                            <td align="middle" width="21%" bgcolor="#efefef">薪酬要求</td>
                            <td align="middle" width="14%" bgcolor="#efefef">安排情况</td>
                          </tr>
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
" target="_blank">
							  <tr onMouseOver="mOvr(this,'#f8ecf9');" onMouseOut="mOut(this,'#F7F7F7');" 
							  bgColor="#f7f7f7" style="cursor:hand">
                            <td align="middle" height="25"><?php
echo $_obj['id'];
?>
</td>
                            <td align="middle"><?php
echo $_obj['service'];
?>
</td>
                            <td align="middle"><?php
echo $_obj['area'];
?>
</td>
                            <td align="middle"><?php
echo $_obj['sex'];
?>
</td>
                            <td align="middle"><?php
echo $_obj['salary'];
?>
</td>
                            <td align="middle"><?php
echo $_obj['occupied'];
?>
</td>
                          </tr>
					  </a>
						  <?php
}
$_obj=$_stack[--$_stack_cnt];}
?>
                    </table></td>
                  </tr>
            </table>
            <table cellspacing="0" cellpadding="0" width="100%" border="0">
                <tbody>
                  <tr>
                    <td height="2"></td>
                  </tr>
                </tbody>
            </table>
            <table cellspacing="0" cellpadding="0" width="100%" border="0">
                <tbody>
                  <tr>
                    <td height="9"></td>
                  </tr>
                </tbody>
            </table>
            <table cellspacing="0" width="100%" border="0">
                <tbody>
                  <tr>
                    <td style="BACKGROUND: #ff99cc; BORDER-BOTTOM: #666666 2px solid" 
          width="98" height="20"><p align="center">最新雇主</p></td>
                    <td style="BACKGROUND: #ffccff; BORDER-BOTTOM: #666666 2px solid"><p align="right">&nbsp;</p></td>
                    <td style="BACKGROUND: #ffccff; BORDER-BOTTOM: #666666 2px solid" 
          width="62"><p align="center"><a href="employerlist.php">more</a></p></td>
                  </tr>
                </tbody>
            </table>
            <table cellspacing="0" cellpadding="0" width="100%" border="0">
                <tbody>
                  <tr>
                    <td height="2"></td>
                  </tr>
                </tbody>
            </table>
            <table class="border" cellspacing="1" cellpadding="0" width="100%" align="center" 
      border="0">
                  <tr>
                    <td><table cellspacing="0" cellpadding="0" width="100%" border="0">
                        <tbody>
                          <tr>
                            <td height="2"></td>
                          </tr>
                        </tbody>
                    </table>
                        <table style="BORDER-COLLAPSE: collapse" bordercolor="#ffffff" 
            cellpadding="0" width="100%" border="1">
                          <tbody>
                            <tr bgcolor="#f7f7f7">
                              <td align="middle" width="10%" bgcolor="#efefef" height="25">编号</td>
                              <td align="middle" width="33%" bgcolor="#efefef">服务类型</td>
                              <td align="middle" width="12%" bgcolor="#efefef">地区</td>
                              <td align="middle" width="15%" bgcolor="#efefef">性别要求</td>
                              <td align="middle" width="15%" bgcolor="#efefef">薪酬要求</td>
                              <td align="middle" width="15%" bgcolor="#efefef">安排情况</td>
                            </tr>
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
" target="_blank">
							  <tr onMouseOver="mOvr(this,'#f8ecf9');" onMouseOut="mOut(this,'#F7F7F7');" 
							  bgColor="#f7f7f7" style="cursor:hand">
                              <td align="middle" height="25"><?php
echo $_obj['id'];
?>
</td>
                              <td align="middle"><?php
echo $_obj['service'];
?>
</td>
                              <td align="middle"><?php
echo $_obj['area'];
?>
</td>
                              <td align="middle"><?php
echo $_obj['ideal_sex'];
?>
</td>
                              <td align="middle"><?php
echo $_obj['salary'];
?>
</td>
                              <td align="middle"><?php
echo $_obj['occupied'];
?>
</td>
                           </tr>
					      </a>
  						   <?php
}
$_obj=$_stack[--$_stack_cnt];}
?>
                        </table></td>
                  </tr>
                </tbody>
            </table></td>
          <td valign="top" align="middle" width="250" height="22"><table width="100%" border="0" cellpadding="0" cellspacing="0">
            <tbody>
              <tr>
                <td width="2"></td>
                <td><table width="100%" border="1" 
            align="center" cellpadding="0" cellspacing="0" bordercolor="#FFCCFF" class="border">
                  <tbody>
                    <tr>
                      <td height="22" align="middle" bgcolor="#FFFFFF" class="bg_l"><table bordercolor="#000000" cellspacing="0" cellpadding="0" 
                  width="100%" bgcolor="#ff6699" border="0">
                        <tbody>
                          <tr>
                            <td align="middle" width="31%" 
                        height="20"><font color="#ffffff">联系方式</font></td>
                            <td width="69%" bgcolor="#FFCCFF"><div align="right">
                              <div class="a06" align="right"></div>
                            </div></td>
                          </tr>
                        </tbody>
                      </table></td>
                    </tr>
                    <tr>
                      <td height="66" align="left" valign="middle" bgcolor="#FFFFFF" style="line-height:18px;"><p>&nbsp;电话：<?php
echo $_obj['telephone'];
?>
<br>
                        &nbsp;传真：<?php
echo $_obj['fax'];
?>
<br>
                        &nbsp;地址：<?php
echo $_obj['address'];
?>
</p>
                        </td>
                    </tr>
                  </tbody>
                </table></td>
              </tr>
            </tbody>
          </table>
              <table cellspacing="0" cellpadding="0" width="100%" border="0">
                <tbody>
                  <tr>
                    <td height="2"></td>
                  </tr>
                </tbody>
              </table>
            <table cellspacing="0" cellpadding="0" width="100%" border="0">
                <tbody>
                  <tr>
                    <td width="2"></td>
                    <td><table class="border" cellspacing="1" cellpadding="0" width="100%" 
            align="center" border="0">
                        <tbody>
                          <tr>
                            <td class="bg_l" align="middle" height="22"><table bordercolor="#000000" cellspacing="0" cellpadding="0" 
                  width="100%" bgcolor="#666666" border="0">
                                <tbody>
                                  <tr>
                                    <td align="middle" width="31%" bgcolor="#ff6699" 
                        height="21"><span class="style16"><font 
                        color="#ffffff">我要登陆</font></span></td>
                                    <td width="69%" bgcolor="#FFCCFF"><div align="right">
                                        <div class="a06" align="right"></div>
                                    </div></td>
                                  </tr>
                                </tbody>
                            </table></td>
                          </tr>
                          <tr>
                            <td><table width="100%" border="0" cellspacing="0" cellpadding="0">
                              <tr>
                                <td bgcolor="#F5F5F5">
								<form method="post" action="login.php">
								<table width="169" height="88" border="0" align="center" cellpadding="0" cellspacing="3">
                                    <tr>
                                      <td colspan="2"><span class="STYLE3"><span class="style11">用户名：</span>
                                            <input name="username" type="text" id="username" size="12" />
                                      </span></td>
                                    </tr>
                                    <tr>
                                      <td colspan="2"><span class="STYLE3"><span class="style11">密　码：</span>
                                            <input name="password" type="password" id="password" size="12" />
                                      </span></td>
                                    </tr>
                                    <tr>
                                      <td width="89" align="center"><label> <span class="STYLE3">
                                        <input type="radio" name="type" value="employee" />
                                        <span class="style11">雇员</span></span></label></td>
                                      <td width="107" align="center"><label> <span class="STYLE3">
                                        <input type="radio" name="type" value="employer" />
                                        <span class="style11">雇主</span></span></label></td>
                                    </tr>
                                    <tr>
                                      <td height="21" align="center"><select name="cookie">
                                          <option value="0">不保存</option>
                                          <option value="1">一天</option>
                                          <option value="7">一周</option>
                                          <option value="30">一个月</option>
                                          <option value="365">一年</option>
                                          <option value="99999">永久</option>
                                      </select></td>
                                      <td align="center"><input type="submit" name="Submit2" value="登陆" /></td>
                                    </tr>
                                  </table>
                                    <table width="100%">
                                      <tr>
                                        <td width="45%" height="15"><div align="right"><a href="register.php">我要注册</a></div></td>
                                        <td width="55%" align="center"><a href="findpass.php">找回密码</a></td>
                                      </tr>
                                  </table>
								  </form>
							    </td>
                              </tr>
                              <tr>
                                <td bgcolor="#F3F3F3"><form id="form1" name="form1" method="post" action="">
                                </form>                                </td>
                              </tr>
                            </table></td>
                          </tr>
                        </tbody>
                    </table>
                        <table cellspacing="0" cellpadding="0" width="100%" border="0">
                          <tbody>
                            <tr>
                              <td height="2"></td>
                            </tr>
                          </tbody>
                        </table>
                      <table width="100%" border="1" 
            align="center" cellpadding="0" cellspacing="0" bordercolor="#FFCCFF" class="border">
                          <tbody>
                            <tr>
                              <td class="bg_l" align="middle" height="22"><table bordercolor="#000000" cellspacing="0" cellpadding="0" 
                  width="100%" bgcolor="#666666" border="0">
                                  <tbody>
                                    <tr>
                                      <td align="middle" width="31%" bgcolor="#ff6699" 
                        height="20"><font color="#ffffff">最新公告</font></td>
                                      <td width="69%" bgcolor="#FFCCFF"><div align="right">
                                          <div class="a06" align="right"><a href="articlelist.php?id=1">more</a></div>
                                      </div></td>
                                    </tr>
                                  </tbody>
                              </table></td>
                            </tr>
                            <tr>
                              <td height="20"><table width="100%" height="27" border="0" cellpadding="2" cellspacing="1">
                                  <tbody>
								  <?php
if (!empty($_obj['NOTICE'])){
if (!is_array($_obj['NOTICE']))
$_obj['NOTICE']=array(array('NOTICE'=>$_obj['NOTICE']));
$_tmp_arr_keys=array_keys($_obj['NOTICE']);
if ($_tmp_arr_keys[0]!='0')
$_obj['NOTICE']=array(0=>$_obj['NOTICE']);
$_stack[$_stack_cnt++]=$_obj;
foreach ($_obj['NOTICE'] as $rowcnt=>$NOTICE) {
$NOTICE['ROWCNT']=$rowcnt;
$NOTICE['ALTROW']=$rowcnt%2;
$NOTICE['ROWBIT']=$rowcnt%2;
$_obj=&$NOTICE;
?>
                                    <tr>
                                      <td width="82%" height="23" align="left" bgcolor="#f8ecf9"><a href="article.php?id=<?php
echo $_obj['id'];
?>
" title="<?php
echo $_obj['title'];
?>
"><?php
echo $_obj['short'];
?>
</a></td>
                                    </tr>
								  <?php
}
$_obj=$_stack[--$_stack_cnt];}
?>
                                  </tbody>
                              </table></td>
                            </tr>
                          </tbody>
                      </table>
                      <table cellspacing="0" cellpadding="0" width="100%" border="0">
                          <tbody>
                            <tr>
                              <td height="2"></td>
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
  <table cellspacing="0" cellpadding="0" width="760" border="0">
    <tbody>
      <tr>
        <td height="2"></td>
      </tr>
    </tbody>
  </table>
  <table cellspacing="0" cellpadding="0" width="760" border="0">
    <tbody>
      <tr>
        <td height="2"></td>
      </tr>
    </tbody>
  </table>
  <table width="760" 
  border="1" cellpadding="0" cellspacing="0" bordercolor="#FFCCFF" style="BORDER-COLLAPSE: collapse">
    <tbody>
      <tr>
        <td valign="top" nowrap="nowrap"><table width="100%" height="100%" border="0" cellpadding="0" cellspacing="0">
            <tr>
              <td width="29%" height="20" nowrap="nowrap" bgcolor="#FF6699"><span class="style16"><?php
echo $_obj['sort2'];
?>
</span></td>
              <td width="71%" nowrap="nowrap" bgcolor="#FFCCFF"><div align="right"><a href="articlelist.php?id=2">more&gt;&gt;</a></div></td>
            </tr>
        </table></td>
        <td valign="top"><table width="100%" border="0" cellpadding="0" cellspacing="0">
            <tr>
              <td width="29%" height="20" bgcolor="#FF6699"><?php
echo $_obj['sort3'];
?>
</td>
              <td bgcolor="#FFCCFF"><div align="right"><a href="newslist.php?id=2">more&gt;&gt;</a></div></td>
            </tr>
        </table></td>
      </tr>
      <tr>
        <td valign="top"><table cellspacing="1" cellpadding="3" width="100%" border="0">
            <tbody>
              <tr>
                <td align="left"><ul>
                    <?php
if (!empty($_obj['ARTICLE_LIST2'])){
if (!is_array($_obj['ARTICLE_LIST2']))
$_obj['ARTICLE_LIST2']=array(array('ARTICLE_LIST2'=>$_obj['ARTICLE_LIST2']));
$_tmp_arr_keys=array_keys($_obj['ARTICLE_LIST2']);
if ($_tmp_arr_keys[0]!='0')
$_obj['ARTICLE_LIST2']=array(0=>$_obj['ARTICLE_LIST2']);
$_stack[$_stack_cnt++]=$_obj;
foreach ($_obj['ARTICLE_LIST2'] as $rowcnt=>$ARTICLE_LIST2) {
$ARTICLE_LIST2['ROWCNT']=$rowcnt;
$ARTICLE_LIST2['ALTROW']=$rowcnt%2;
$ARTICLE_LIST2['ROWBIT']=$rowcnt%2;
$_obj=&$ARTICLE_LIST2;
?>
                    <li align="left"><a href="article.php?id=<?php
echo $_obj['id'];
?>
" title="<?php
echo $_obj['title'];
?>
"><?php
echo $_obj['short'];
?>
</a></li>
                    <?php
}
$_obj=$_stack[--$_stack_cnt];}
?>
                </ul></td>
              </tr>
            </tbody>
        </table></td>
        <td width="375" valign="top"><table cellspacing="1" cellpadding="3" width="100%" border="0">
            <tbody>
              <tr>
                <td align="left"><ul>
                    <?php
if (!empty($_obj['ARTICLE_LIST3'])){
if (!is_array($_obj['ARTICLE_LIST3']))
$_obj['ARTICLE_LIST3']=array(array('ARTICLE_LIST3'=>$_obj['ARTICLE_LIST3']));
$_tmp_arr_keys=array_keys($_obj['ARTICLE_LIST3']);
if ($_tmp_arr_keys[0]!='0')
$_obj['ARTICLE_LIST3']=array(0=>$_obj['ARTICLE_LIST3']);
$_stack[$_stack_cnt++]=$_obj;
foreach ($_obj['ARTICLE_LIST3'] as $rowcnt=>$ARTICLE_LIST3) {
$ARTICLE_LIST3['ROWCNT']=$rowcnt;
$ARTICLE_LIST3['ALTROW']=$rowcnt%2;
$ARTICLE_LIST3['ROWBIT']=$rowcnt%2;
$_obj=&$ARTICLE_LIST3;
?>
                    <li align="left"><a href="article.php?id=<?php
echo $_obj['id'];
?>
" title="<?php
echo $_obj['title'];
?>
"><?php
echo $_obj['short'];
?>
</a></li>
                    <?php
}
$_obj=$_stack[--$_stack_cnt];}
?>
                </ul></td>
              </tr>
            </tbody>
        </table></td>
      </tr>
    </tbody>
  </table>
  <table id="table3" cellspacing="0" cellpadding="0" width="778" border="0">
    <tbody>
      <tr>
        <td background="" height="1"></td>
      </tr>
    </tbody>
  </table>
  <table id="table1" cellspacing="0" cellpadding="0" width="760" bgcolor="#ffffff" 
  border="0">
    <tbody>
      <tr bgcolor="#FFFFFF">
        <td rowspan="3" valign="top" background=""><table width="760" border="0" cellpadding="0" cellspacing="0" id="table2">
            <tbody>
              <tr>
                <td width="92" bgcolor="#FF6699"><div align="center">友情链接</div></td>
                <td width="269" align="center" bgcolor="#FFCCFF">点击<a href="friend.php">此处</a>申请加入本站友情链接</td>
                <td width="377" align="center" bgcolor="#FFCCFF">&nbsp;</td>
              </tr>
            </tbody>
          </table>
            <table width="760" border="1" cellspacing="0" bordercolor="#FFCCFF">
              <tr>
                <td width="762" height="auto" bgcolor="#FFFFFF"><?php
if (!empty($_obj['FRIEND_WORD_LIST'])){
if (!is_array($_obj['FRIEND_WORD_LIST']))
$_obj['FRIEND_WORD_LIST']=array(array('FRIEND_WORD_LIST'=>$_obj['FRIEND_WORD_LIST']));
$_tmp_arr_keys=array_keys($_obj['FRIEND_WORD_LIST']);
if ($_tmp_arr_keys[0]!='0')
$_obj['FRIEND_WORD_LIST']=array(0=>$_obj['FRIEND_WORD_LIST']);
$_stack[$_stack_cnt++]=$_obj;
foreach ($_obj['FRIEND_WORD_LIST'] as $rowcnt=>$FRIEND_WORD_LIST) {
$FRIEND_WORD_LIST['ROWCNT']=$rowcnt;
$FRIEND_WORD_LIST['ALTROW']=$rowcnt%2;
$FRIEND_WORD_LIST['ROWBIT']=$rowcnt%2;
$_obj=&$FRIEND_WORD_LIST;
?>
                    <div style="width:auto;float:left; margin-left:10px; margin-top:10px;"><a href="<?php
echo $_obj['link'];
?>
" title="<?php
echo $_obj['title'];
?>
" target="_blank"><?php
echo $_obj['title'];
?>
</a></div>
                    <?php
}
$_obj=$_stack[--$_stack_cnt];}
?>
                </td>
              </tr>
              <tr>
                <td height="auto" bgcolor="#FFFFFF"><?php
if (!empty($_obj['FRIEND_PIC_LIST'])){
if (!is_array($_obj['FRIEND_PIC_LIST']))
$_obj['FRIEND_PIC_LIST']=array(array('FRIEND_PIC_LIST'=>$_obj['FRIEND_PIC_LIST']));
$_tmp_arr_keys=array_keys($_obj['FRIEND_PIC_LIST']);
if ($_tmp_arr_keys[0]!='0')
$_obj['FRIEND_PIC_LIST']=array(0=>$_obj['FRIEND_PIC_LIST']);
$_stack[$_stack_cnt++]=$_obj;
foreach ($_obj['FRIEND_PIC_LIST'] as $rowcnt=>$FRIEND_PIC_LIST) {
$FRIEND_PIC_LIST['ROWCNT']=$rowcnt;
$FRIEND_PIC_LIST['ALTROW']=$rowcnt%2;
$FRIEND_PIC_LIST['ROWBIT']=$rowcnt%2;
$_obj=&$FRIEND_PIC_LIST;
?>
                    <div style="width:auto;float:left; margin-left:10px; margin-top:10px;"><a href="<?php
echo $_obj['link'];
?>
" title="<?php
echo $_obj['title'];
?>
" target="_blank"><img src="<?php
echo $_obj['pic'];
?>
" width="90" height="34" border="0"/></a></div>
                    <?php
}
$_obj=$_stack[--$_stack_cnt];}
?>
                </td>
              </tr>
          </table></td>
      </tr>
    </tbody>
  </table>
  <table height="6" cellspacing="0" cellpadding="0" width="760" align="center" border="0">
    <tbody>
      <tr>
        <td style="FONT-SIZE: 12px" align="middle" height="5"></td>
      </tr>
    </tbody>
  </table>
</div>
