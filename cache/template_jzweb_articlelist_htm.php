<table width="760" border="0" align="center" cellpadding="0" cellspacing="0">
  <tr>
    <td width="163" height="188" valign="top" bgcolor="#FFCCFF"><table width="100%" border="0" cellspacing="0" cellpadding="0">
      <tr>
        <td height="27" bgcolor="#FFCCFF"><div align="center">【热门文章列表】</div></td>
      </tr>
    </table>
        <table width="100%" height="161" border="0" cellpadding="0" cellspacing="1">
          <tr>
            <td valign="top" bgcolor="#FFFFFF"><table width="100%" border="0" cellspacing="0" cellpadding="0">
			<?php
if (!empty($_obj['HOT_LIST'])){
if (!is_array($_obj['HOT_LIST']))
$_obj['HOT_LIST']=array(array('HOT_LIST'=>$_obj['HOT_LIST']));
$_tmp_arr_keys=array_keys($_obj['HOT_LIST']);
if ($_tmp_arr_keys[0]!='0')
$_obj['HOT_LIST']=array(0=>$_obj['HOT_LIST']);
$_stack[$_stack_cnt++]=$_obj;
foreach ($_obj['HOT_LIST'] as $rowcnt=>$HOT_LIST) {
$HOT_LIST['ROWCNT']=$rowcnt;
$HOT_LIST['ALTROW']=$rowcnt%2;
$HOT_LIST['ROWBIT']=$rowcnt%2;
$_obj=&$HOT_LIST;
?>
                <tr>
                  <td width="11%" height="19"><a href="article.php?id=<?php
echo $_obj['hot_id'];
?>
" title="<?php
echo $_obj['hot_title'];
?>
"><?php
echo $_obj['hot_short'];
?>
</a></td>
                </tr>
			<?php
}
$_obj=$_stack[--$_stack_cnt];}
?>
            </table></td>
          </tr>
    </table></td>
    <td valign="top"><table width="100%" border="0" cellspacing="0" cellpadding="0">
      <tr>
        <td height="27" colspan="3" bgcolor="#FFCCCC">&nbsp;&nbsp;&nbsp;你所在位置-<a href="articlecenter.php">文章中心</a>-文章列表</td>
      </tr>
      <tr>
        <td width="1%" height="auto">&nbsp;</td>
        <td width="98%" valign="top"><table width="100%" height="auto" border="0" cellpadding="0" cellspacing="1">
	    <?php
if (!empty($_obj['ARTICLE_LIST'])){
if (!is_array($_obj['ARTICLE_LIST']))
$_obj['ARTICLE_LIST']=array(array('ARTICLE_LIST'=>$_obj['ARTICLE_LIST']));
$_tmp_arr_keys=array_keys($_obj['ARTICLE_LIST']);
if ($_tmp_arr_keys[0]!='0')
$_obj['ARTICLE_LIST']=array(0=>$_obj['ARTICLE_LIST']);
$_stack[$_stack_cnt++]=$_obj;
foreach ($_obj['ARTICLE_LIST'] as $rowcnt=>$ARTICLE_LIST) {
$ARTICLE_LIST['ROWCNT']=$rowcnt;
$ARTICLE_LIST['ALTROW']=$rowcnt%2;
$ARTICLE_LIST['ROWBIT']=$rowcnt%2;
$_obj=&$ARTICLE_LIST;
?>
          <tr>
            <td height="17" bgcolor="#FFFFFF">
			<a href="article.php?id=<?php
echo $_obj['id'];
?>
" title="<?php
echo $_obj['title'];
?>
"><?php
echo $_obj['short'];
?>
</a>&nbsp;&nbsp;&nbsp;&nbsp;[<?php
echo $_obj['date'];
?>
]
			</td>
          </tr>
		<?php
}
$_obj=$_stack[--$_stack_cnt];}
?>
        </table></td>
        <td width="1%" valign="top" bgcolor="#FFFFFF">&nbsp;</td>
      </tr>
      <tr>
        <td height="auto">&nbsp;</td>
        <td align="right" valign="top"><?php
echo $_obj['pagechar'];
?>
</td>
        <td valign="top" bgcolor="#FFFFFF">&nbsp;</td>
      </tr>
	  <tr align="right"><td colspan="3">&nbsp;</td>
	  </tr>
    </table></td>
  </tr>
</table>
