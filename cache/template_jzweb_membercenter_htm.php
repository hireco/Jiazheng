<div align="center">
  <table style="BORDER-COLLAPSE: collapse" bordercolor="#e4e4e4" cellpadding="0" 
width="760" border="1">
    <tbody>
      <tr>
        <td width="200" valign="top"><table width="100%" border="0">
          <tbody>
            <tr>
              <td colspan="2"><table cellspacing="0" cellpadding="0" width="100%" border="0">
                  <tbody>
                    <tr>
                      <td bgcolor="#FFCCFF" height="20"><div align="center">��<?php
echo $_obj['type'];
?>
��Ϣ����</div></td>
                      <td width="2" bgcolor="#e9e9e9"></td>
                    </tr>
                    <tr>
                      <td bgcolor="#e9e9e9" height="2"></td>
                      <td bgcolor="#e9e9e9" height="2"></td>
                    </tr>
                  </tbody>
              </table></td>
            </tr>
            <tr>
              <td width="44%" align="left">&nbsp;&nbsp;&nbsp;��Ա���</td>
              <td width="56%"><?php
echo $_obj['id'];
?>
</td>
            </tr>
			<?php
if (!empty($_obj['EMPLOYEE'])){
?>
            <tr>
              <td align="left">&nbsp;&nbsp;&nbsp;��֤״��</td>
              <td><?php
echo $_obj['qualified'];
?>
</td>
            </tr>
			<?php
}
?>
            <tr>
              <td align="left">&nbsp;&nbsp;&nbsp;���״��</td>
              <td><?php
echo $_obj['checked'];
?>
</td>
            </tr>
			<?php
if (!empty($_obj['EMPLOYER'])){
?>
            <tr>
              <td align="left">&nbsp;&nbsp;&nbsp;�ö�״��</td>
              <td><?php
echo $_obj['top'];
?>
</td>
            </tr>
			<?php
}
?>
			<?php
if (!empty($_obj['EMPLOYEE'])){
?>
            <tr>
              <td align="left">&nbsp;&nbsp;&nbsp;�Ƽ�״��</td>
              <td><?php
echo $_obj['recommended'];
?>
</td>
            </tr>
            <tr>
              <td align="left">&nbsp;&nbsp;&nbsp;Ƹ��״��</td>
              <td><?php
echo $_obj['hired'];
?>
</td>
            </tr>
			<?php
}
?>
            <tr>
              <td align="left"><p align="left">&nbsp;&nbsp;&nbsp;��½����</p></td>
              <td><?php
echo $_obj['visit_times'];
?>
</td>
            </tr>
            <tr>
              <td><p align="left">&nbsp;&nbsp;&nbsp;�����ʴ���</p></td>
              <td><?php
echo $_obj['visited_times'];
?>
</td>
            </tr>
            <tr>
              <td align="left"><p align="left">&nbsp;&nbsp;&nbsp;ע������</p></td>
              <td><?php
echo $_obj['reg_time'];
?>
</td>
            </tr>
          </tbody>
        </table>
        <table width="100%" border="0">
              <tbody>
                <tr>
                  <td><table cellspacing="0" cellpadding="0" width="100%" border="0">
                      <tbody>
                        <tr>
                          <td bgcolor="#FFCCFF" height="20"><div align="center">��<?php
echo $_obj['type'];
?>
���ϡ���</div></td>
                          <td width="2" bgcolor="#e9e9e9"></td>
                        </tr>
                        <tr>
                          <td bgcolor="#e9e9e9" height="2"></td>
                          <td bgcolor="#e9e9e9" height="2"></td>
                        </tr>
                      </tbody>
                  </table></td>
                </tr>
                <tr>
                  <td><p align="left">&nbsp;&nbsp;&nbsp;<a href="membercenter.php?j=Info&a=<?php
echo $_obj['edit'];
?>
">�����޸�</a></p></td>
                </tr>
				<?php
if (!empty($_obj['EMPLOYER'])){
?>
                <tr>
                  <td><p align="left">&nbsp;&nbsp;&nbsp;<a href="membercenter.php?j=Info&a=editrequirement">Ҫ���޸�</a></p></td>
                </tr>
				<?php
}
?>
                <tr>
                  <td><p align="left">&nbsp;&nbsp;&nbsp;<a href="membercenter.php?j=Info&a=editpass">�����޸�</a></p></td>
                </tr>
              </tbody>
          </table>
          <table width="100%" border="0">
              <tbody>
                <tr>
                  <td><table cellspacing="0" cellpadding="0" width="100%" border="0">
                      <tbody>
                        <tr>
                          <td bgcolor="#FFCCFF" height="20"><div align="center">��ԤԼ��Ϣ����</div></td>
                          <td width="2" bgcolor="#e9e9e9"></td>
                        </tr>
                        <tr>
                          <td bgcolor="#e9e9e9" height="2"></td>
                          <td bgcolor="#e9e9e9" height="2"></td>
                        </tr>
                      </tbody>
                  </table></td>
                </tr>
                
                <tr>
                  <td><p align="left">&nbsp;&nbsp;&nbsp;<?php
echo $_obj['receive'];
?>
</td>
                </tr>
                <tr>
                  <td><p align="left">&nbsp;&nbsp;&nbsp;<?php
echo $_obj['send'];
?>
</p></td>
                </tr>
              </tbody>
          </table>
          <table width="100%" border="0">
            <tbody>
              <tr>
                <td><table cellspacing="0" cellpadding="0" width="100%" border="0">
                    <tbody>
                      <tr>
                        <td bgcolor="#FFCCFF" height="20"><div align="center">��ϵͳ��������</div></td>
                        <td width="2" bgcolor="#e9e9e9"></td>
                      </tr>
                      <tr>
                        <td bgcolor="#e9e9e9" height="2"></td>
                        <td bgcolor="#e9e9e9" height="2"></td>
                      </tr>
                    </tbody>
                </table></td>
              </tr>
              <tr>
                <td><p align="left">&nbsp;&nbsp;&nbsp;<a href="membercenter.php?j=System&a=logout">��ȫ�˳�</a></p></td>
              </tr>
            </tbody>
          </table></td>
        <td valign="top"><div align="center">
          <table width="95%" border="0">
            <tbody>
              <tr>
                <td valign="top" bgcolor="#FFCCCC"><table width="100%" border="0" cellspacing="0" cellpadding="0">
                  <tr>
                    <td height="34" colspan="2" bgcolor="#FFFFFF"><div align="left">�㵱ǰ��λ��-��Ա����</div></td>
                    <td bgcolor="#FFFFFF">&nbsp;</td>
                  </tr>
                  <tr>
                    <td width="22%" height="51">&nbsp;</td>
                    <td width="56%" align="left" valign="bottom"><div align="left">��ã�<?php
echo $_obj['username'];
?>
</div></td>
                    <td width="22%">&nbsp;</td>
                  </tr>
                  <tr>
                    <td height="78">&nbsp;</td>
                    <td align="left" valign="top"> &nbsp;&nbsp;ף�����Ѿ��ɹ���½����������������ܵ��������ʵķ���</td>
                    <td>&nbsp;</td>
                  </tr>
                </table></td>
              </tr>
              <tr>
                <td height="14">��</td>
              </tr>
            </tbody>
          </table>
        </div></td>
      </tr>
    </tbody>
  </table>
</div>
