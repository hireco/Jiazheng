<script language="Javascript" src="js/check.js"/></script>
<table width="760" border="1" align="center" bordercolor="#e4e4e4" style="BORDER-COLLAPSE: collapse">
  <tbody>
    <tr>
      <td width="200" height="343" bgcolor="#FFCCCC">　</td>
      <td><table cellspacing="0" cellpadding="0" width="550" border="0">
        <tbody>
          <tr>
            <td align="middle"><table cellspacing="0" cellpadding="0" width="550" border="0">
              <tr>
                <td width="566"><table cellspacing="0" cellpadding="0" width="397" border="0">
                    <tr>
                      <td width="15">　</td>
                      <td width="382"><table cellspacing="0" cellpadding="0" width="504" border="0">
                          <tr>
                            <td width="116" background="template/jzweb/images/zhuce-0005.gif" style="font-size: 9pt"><img src="template/jzweb/images/8.gif" width="116" height="41" /></td>
                            <td width="12" background="template/jzweb/images/zhuce-0005.gif" style="font-size: 9pt">　</td>
                            <td width="129" background="template/jzweb/images/zhuce-0005.gif" style="font-size: 9pt"><img src="template/jzweb/images/7.gif" width="116" height="41" /></td>
                            <td width="129" background="template/jzweb/images/zhuce-0005.gif" style="font-size: 9pt"><img src="template/jzweb/images/6.gif" width="116" height="41" /></td>
                            <td width="118" align="right" background="template/jzweb/images/zhuce-0005.gif" style="font-size: 9pt"><img src="template/jzweb/images/5.gif" width="116" height="41" /></td>
                          </tr>
                          <tr>
                            <td colspan="5" style="font-size: 9pt">&nbsp;</td>
                          </tr>
                      </table></td>
                    </tr>
                </table></td>
              </tr>
            </table>
            <table height="288" cellspacing="1" width="100%" border="0">
                    <tbody>
                      <tr>
                        <td height="30" bgcolor="#FFCCCC"><div align="left"><span><strong>注册第一步：同意协意</strong></span></div></td>
                      </tr>
                      <tr>
                        <td height="30" valign="top" bgcolor="#FFFae8"><table width="100%" height="184" border="0" cellpadding="0" cellspacing="0">
                          <tr>
                            <td width="10%" height="29">&nbsp;</td>
                            <td width="81%"><div align="center">会员协议</div></td>
                            <td width="9%">&nbsp;</td>
                          </tr>
                          <tr>
                            <td>&nbsp;</td>
                            <td valign="top"><table width="100%" height="156" border="0" cellpadding="0" cellspacing="0">
                              <tr>
                                <td><div align="left"><?php
echo $_obj['reginfo'];
?>
</div>                                  </td>
                              </tr>
                            </table></td>
                            <td>&nbsp;</td>
                          </tr>
                        </table></td>
                      </tr>
                      <tr>
                        <td height="67" align="middle" valign="middle">
						<form id="form1" name="form1" method="post" action="register.php">
                          <table width="100%" height="50" border="0" cellpadding="0" cellspacing="0">
                            <tr>
                              <td bgcolor="#FFCCCC"><div align="center">会员类型
                                <input type="radio" value="employer" name="type" />
                                    <label>请家政</label>
                                    <input type="radio" value="employee" name="type" />
                                    <label>做家政</label>
									<input type="hidden" name="step" value="2" />
                              </div></td>
                            </tr>
							<?php
if (!empty($_obj['VERIFY'])){
?>
                <tr bgcolor="#fffae8">
                  <td align="center" bgcolor="#fffae8">验证码：
                    <IFRAME frameBorder="0" id="code_check" scrolling="no" name="code_check" src='showpicture.php' style='HEIGHT: 25px; VISIBILITY: inherit; WIDTH: 135px; Z-INDEX: 1'></IFRAME></td>
                            </tr>
							<?php
}
?>
                            <tr>
                              <td height="33"><label></label>
                                <table width="100%" height="26" border="0" cellpadding="0" cellspacing="0">
                                  <tr>
                                    <td align="center"><label>
                                      <div align="center">
                                        <input id="com_sub" type="submit" value="提 交" name="submit" onclick="return <?php
echo $_obj['check'];
?>
();" />
                                        &nbsp;&nbsp;&nbsp;
                                        <input type="button" name="Submit2" value="不同意" onclick="history.go(-1)" />
									  </div></label></td>
                                  </tr>
                                </table></td>
                            </tr>
                          </table>
                      </form></td>
                      </tr>
                    </tbody>
                </table>
              <div></div></td>
          </tr>
        </tbody>
      </table></td>
    </tr>
  </tbody>
</table>
