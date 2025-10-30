<?php
error_reporting(7);

class cpForms {
	//��ͷ
	function formheader($arguments=array()) {
		global $_SERVER;
		if ($arguments['enctype']){
			$enctype="enctype=\"".$arguments['enctype']."\"";
		} else {
			$enctype="";
		}
		if ($arguments['target']){
			$target="target=\"".$arguments['target']."\"";
		} else {
			$target="";
		}
		if (!isset($arguments['method'])) {
			$arguments['method'] = "post";
		}
		if (!isset($arguments['action'])) {
			$arguments['action'] = $_SERVER['PHP_SELF'];
		}
		if (!$arguments['colspan']) {
			$arguments['colspan'] = 2;
		}

		echo "<table width=\"100%\" border=\"0\" cellspacing=\"1\" cellpadding=\"5\" bgcolor=\"#c0c0c0\" class=\"TRalt\">\n";
		echo "<form action=\"".$arguments['action']."\" ".$target.$enctype." method=\"".$arguments['method']."\" name=\"".$arguments['name']."\" ".$arguments['extra'].">\n";
		if ($arguments['title'] != "") {
			echo "<tr>\n";
			echo "	<td class=\"tblhead\" colspan=\"".$arguments['colspan']."\"><b>".$arguments['title']."</b></td>\n";
			echo "</tr>\n";
		}
	}
	
	//��β
	function formfooter($arguments=array()){
		echo "<tr>\n";
			if ($arguments['confirm']==1) {
				$arguments['button']['submit']['type'] = "submit";
				$arguments['button']['submit']['name'] = "submit";
				$arguments['button']['submit']['value'] = "ȷ��";
				$arguments['button']['submit']['accesskey'] = "y";

				$arguments['button']['back']['type'] = "button";
				$arguments['button']['back']['value'] = "ȡ��";
				$arguments['button']['back']['accesskey'] = "r";
				$arguments['button']['back']['extra'] = " onclick=\"history.back(1)\" ";
			} elseif (empty($arguments['button'])) {

				$arguments['button']['submit']['type'] = "submit";
				$arguments['button']['submit']['name'] = "submit";
				$arguments['button']['submit']['value'] = "�ύ";
				$arguments['button']['submit']['accesskey'] = "y";

				$arguments['button']['reset']['type'] = "reset";
				$arguments['button']['reset']['value'] = "����";
				$arguments['button']['reset']['accesskey'] = "r";
			}

			if (empty($arguments['colspan'])) {
				$arguments['colspan'] = 2;
			}

			echo "<td colspan=\"".$arguments['colspan']."\" align=\"center\">\n";
			if (isset($arguments) AND is_array($arguments)) {
				foreach ($arguments['button'] AS $k=>$button) {
					if (empty($button['type'])) {
						$button['type'] = "submit";
					}
					echo " <input class=\"button\" accesskey=\"".$button['accesskey']."\" type=\"".$button['type']."\" name=\"".$button['name']."\" value=\"".$button['value']."\" ".$button['extra'].">\n";
				}
			}
			echo "</td></tr>\n";
			echo "</form>\n";
			echo "</table>\n";

      }
	
	//TABLEͷ
	function tableheader($arguments=array()) {
		echo "<td bgcolor=\"#FFFFFF\"><table width=\"100%\" border=\"0\" cellspacing=\"5\" cellpadding=\"0\" bgcolor=\"#c0c0c0\" class=\"TRalt\">\n";
		if ($arguments['title'] != "") {
			echo "<tr>\n";
			echo "<td class=\"tblhead\" colspan=\"".$arguments['colspan']."\"><b>".$arguments['title']."</b></td>\n";
			echo "</tr>\n";
		}
	}

	//TABLEͷ2
	function tableheaderbig($arguments=array()) {
		echo "<td bgcolor=\"#FFFFFF\"><table width=\"100%\" border=\"0\" cellspacing=\"1\" cellpadding=\"6\"bgcolor=\"#c0c0c0\" class=\"TRalt\">\n";
		if ($arguments['title'] != "") {
			echo "<tr>\n";
			echo "<td class=\"tblhead\" colspan=\"".$arguments['colspan']."\"><b>".$arguments['title']."</b></td>\n";
			echo "</tr>\n";
		}
		
	}

	//TABLEβ
	function tablefooter() {
		echo "</table>\n";
	}

	//����TD
	function maketd($arguments = array()) {
		echo "<tr nowrap>";
		foreach ($arguments AS $k=>$v) {
			if (strlen($k) > 5)
				echo "<td ".$k.">".$v."</td>";
			else
				echo "<td>".$v."</td>";
		}
		echo "</tr>\n";
	}
	
	//����INPUT
	function makeinput($arguments = array()) {
		if (empty($arguments['size'])) {
			$arguments['size'] = 35;
		}
		if (empty($arguments['maxlength'])) {
			$arguments['maxlength'] = 200;
		}
		if ($arguments['html']) {
			$arguments['value'] = htmlspecialchars($arguments['value']);
		}
		if (!empty($arguments['css'])) {
			$class = "class=\"$arguments[css]\"";
		} else {
			$class = "class=\"formfield\"";
		}
		if (empty($arguments['type'])) {
			$arguments['type'] = "text";
		}
		if(!isset($arguments['otherelement'])) {
			$arguments['otherelement'] = "";
		}
		echo "<tr nowrap>\n";
		echo "	<td><b>".$arguments['text']."</b><br>".$arguments['note']."</td>\n";
		echo "	<td><input ".$class." type=\"".$arguments['type']."\" name=\"".$arguments['name']."\" size=\"".$arguments['size']."\" maxlength=\"".$arguments['maxlength']."\" value=\"".$arguments['value']."\" ".$arguments['extra'].">".$arguments['otherelement']."</td>\n";
		echo "</tr>\n";
	}

	function maketimeinput($arguments = array(),$prefix = '') {
		if (!empty($arguments['css'])) {
			$class = "class=\"$arguments[css]\"";
		} else {
			$class = "class=\"formfield\"";
		}
		echo "<tr nowrap>\n";
		echo "	<td><b>".$arguments['text']."</b><br>".$arguments['note']."</td>\n";
		echo "<td><input type='text' name='{$prefix}year' size='4' value=\"".$arguments['year']."\" maxlength='4' ".$class."> �� - <input type='text' name='{$prefix}month' size='2' value=\"".$arguments['month']."\" maxlength='2' ".$class."> �� - <input type='text' name='{$prefix}day' size='2' value=\"".$arguments['day']."\" maxlength='2' ".$class."> �� -  <input type='text' name='{$prefix}hour' size='2' value=\"".$arguments['hour']."\" maxlength='2' ".$class."> ʱ -  <input type='text' name='{$prefix}minute' size='2' value=\"".$arguments['minute']."\" maxlength='2' ".$class."> ��  -  <input type='text' name='{$prefix}second' size='2' value=\"".$arguments['second']."\" maxlength='2' ".$class."> ��</td>\n";
		echo "</tr>\n";
	}

	//�����ļ��ϴ���
	function makefile($arguments = array(),$submit = 0) {
		if(!isset($arguments['size'])) {
			$arguments['size'] = 30;
		}
		echo "<tr nowrap>\n";
		echo "	<td><b>".$arguments['text']."</b><br>".$arguments['note']."</td>\n";
		echo "	<td><input class=\"formfield\" type=\"file\" name=\"".$arguments['name']."\""." size=\"".$arguments['size']."\" ".$arguments['extra'].">";
		if ($submit)
			echo "&nbsp;<input class=\"minibutton\" type=\"submit\" value=\"�ϴ�\">";
		echo "</td>\n";
		echo "</tr>\n";
	}

	//����TEXTAREA
	function maketextarea($arguments = array(),$Eweb=1){
		if (!empty($arguments['html'])) {
			$arguments['value'] = htmlspecialchars($arguments['value']);
		}
		if ($Eweb == 1)
		{
			if (empty($arguments['cols'])) {
				$arguments['cols'] = 600;
			}
			if (empty($arguments['rows'])) {
				$arguments['rows'] = 400;
			}
			$style = "coolblue";
		
			echo "<tr nowrap>\n";
			echo "	<td valign=\"top\"><b>".$arguments['text']."</b><br>".$arguments['note']."</td>\n";
			echo "	<td>";
			echo "<input type=\"hidden\" name=\"".$arguments['name']."\" value=\"".$arguments['value']."\">\n";
			echo "<IFRAME ID=\"eWebEditor1\" src=\"ewebeditor/ewebeditor.htm?id=".$arguments['name']."&style=".$style."\" frameborder=\"0\" scrolling=\"yes\" width=\"".$arguments['cols']."\" height=\"".$arguments['rows']."\"></IFRAME></td>\n";
			echo "</tr>\n";
		}
		else
		{
			if (empty($arguments['cols'])) {
				$arguments['cols'] = 80;
			}
			if (empty($arguments['rows'])) {
				$arguments['rows'] = 10;
			}
			echo "<tr nowrap>\n";
			echo "	<td valign=\"top\"><b>".$arguments['text']."</b><br>".$arguments['note']."</td>\n";
			echo "	<td>";
			echo "  <textarea name=\"".$arguments['name']."\" rows=\"".$arguments['rows']."\" cols=\"".$arguments['cols']."\">".$arguments['value']."</textarea></td>\n";
			echo "</tr>\n";
		}
	}

	//���ɵ�ѡ��
	function makeradio($arguments = array())
	{
		if ($arguments['html'] == 1) {
			$value = htmlspecialchars($value);
		}
		$label = isset($arguments['label']) ? $arguments['label'] : $arguments['name'];
		echo "<tr>\n";
		echo "	<td valign=\"top\"><b>".$arguments['text']."</b><br>".$arguments['note']."</td>\n";
		echo "	<td>\n";
			if (is_array($arguments['option'])) {
				foreach ($arguments['option'] AS $key=>$value) {
					if ($arguments['selected']==$key) {
						echo "<input type=\"radio\" name=\"".$arguments['name']."\" value=\"{$key}\" checked class=\"radio\" id=\"{$label}_{$key}\"></option><label for=\"{$label}_{$key}\">{$value}</label> &nbsp;\n";
					} else {
						echo "<input type=\"radio\" name=\"".$arguments['name']."\" value=\"".$key."\" class=\"radio\" id=\"{$label}_{$key}\"></option><label for=\"{$label}_{$key}\">{$value}</label> &nbsp;\n";
					}
				}
			}

		echo "</select>\n";
		echo "</td></tr>\n";

	}
	//���������б�
	function makeselect($arguments = array()){
		if ($arguments['html'] == 1) {
			$value = htmlspecialchars($value);
		}
		if ($arguments['multiple']==1) {
			$multiple = " multiple";
		}
		if ($arguments['size']>0) {
				$size = "size=".$arguments['size']."";
			}
		if($arguments['disable'] == 1) {
			$disable = "disabled";
		}
		echo "<tr>\n";
		echo "	<td valign=\"top\"><b>".$arguments['text']."</b><br>".$arguments['note']."</td>\n";
		echo "	<td><select name=\"".$arguments['name']."\" ".$multiple." ".$size." ".$disable."  {$arguments[extra]}>\n";
			if (is_array($arguments['option'])) {
				foreach ($arguments['option'] AS $key=>$value) {
					if (!is_array($arguments['selected'])) {
						if ($arguments['selected']==$key) {
							echo "<option value=\"".$key."\" selected class=\"{$arguments[css][$key]}\">".$value."</option>\n";
						} else {
							echo "<option value=\"".$key."\" class=\"{$arguments[css][$key]}\">".$value."</option>\n";
						}

					} elseif (is_array($arguments['selected'])) {
						if ($arguments['selected'][$key]==1) {
							echo "<option value=\"".$key."\" selected class=\"{$arguments[css][$key]}\">".$value."</option>\n";
						} else {
							echo "<option value=\"".$key."\" class=\"{$arguments[css][$key]}\">".$value."</option>\n";
						}
					}
				}
			}

		echo "</select>\n";
		echo "</td></tr>\n";
	}

	//�����Ƿǵ�ѡ��ť
	function makeyesno($arguments = array()) {
		$arguments['option'] = array('1'=>'��','0'=>'��');
		$this->makeselect($arguments,$disable);
	}

	//����������
	function makehidden($arguments = array()){
		if ($arguments['id'] != "")
		{
			$id = "id=\"".$arguments['id']."\"";
		}
		echo "<input type=\"hidden\" name=\"".$arguments['name']."\" value=\"".$arguments['value']."\">\n";
	}


	// ��������ҳ��ҳü
	function cpheader($pageTitle = "",$css='style') {
		global $options;
		echo "<html>\n<head>\n<title>".$pageTitle."</title>\n";
		echo "<meta content=\"text/html; charset=gb2312\" http-equiv=\"Content-Type\">\n";
		echo "<link rel=\"stylesheet\" href=\"styles/{$css}.css\" type=\"text/css\">\n";
		echo "</head>\n";
		echo "<body>\n";
	}

	// ��������ҳ��ҳ��
	function cpfooter() {
		echo "</body>\n</html>";
	}
	//ѡ�����е�JS
	function js_checkall() {
		?>
<script language="JavaScript">
function CheckAll(form) {
	for (var i=0;i<form.elements.length;i++) {
		var e = form.elements[i];
		if (e.name != 'chkall')
		e.checked = form.chkall.checked;
	}
}
</script>
		<?php
	}

	//�ж��Ƿ�ɾ����JS
	function if_del()
	{
		?>
<script language="JavaScript">
function ifDel(delurl) {
	var truthBeTold = window.confirm("��ȷ��Ҫɾ����");
	if (truthBeTold) {
		location=delurl;
	}  else  {
		return;
	}
}
</script>
		<?php
	}

	//�б��ı�
	function change()
	{
		?>
<script language="JavaScript">
	function change()
		{
			var iconselect = document.getElementById("iconselect");
			var id = document.getElementById("template");
			var path = id.value+"/"+iconselect.options.value;
			document.images.icon.src = path;
		}
</script>
		<?php
	}
	// �������
/*
	function makenav($ctitle = "", $nav=array(), $logo = "") {
		$current_auth_char="addNews,listNews";
		static $nc=0;
		$show_nav_title = 1;
		foreach($nav as $link) {
			preg_match("/^admin.php\?a=([^\/]+)/i",$link,$current_action_title);
			if(strstr($current_auth_char,$current_action_title[1])) {
				$show_nav_title = 1;
			}
		}
		if($show_nav_title) {
			if (!$logo) $logo = "default";
			echo "<tr style=\"cursor: hand;\" onClick=\"javascript:showDiv('menu_{$nc}','img_{$nc}');\" >\n";
			echo "<td><div class=\"menuTitle\"><div><img src=\"images/{$logo}.gif\"></div><p>".$ctitle."</p></div></td>\n";
			echo "</tr>\n";
			echo "<tr id=\"menu_{$nc}\"><td><table>";
		}
		foreach ($nav as $title=>$link)	{
			preg_match("/^admin.php\?a=([^\/&]+)/i",$link,$current_action);
			//if(strstr($current_auth_char,$current_action[1])) {
				echo "<tr>\n";
				echo "<td class=\"menuLi\"><div><img src=\"images/menu.gif\"></div><p><a href=\"$link\" target=\"mainFrame\">".$title."</a></p></td>\n";
				echo "</tr>\n";
			//}
		}
		if($show_nav_title) {
			echo "</table></td></tr>";
		}
		$nc++;
	}
 */
	function makenav($ctitle = "", $nav=array(), $logo = "") {
		$current_auth_char="addNews,listNews";
		static $nc=0;
		$show_nav_title = 1;
		foreach($nav as $link) {
			preg_match("/^admin.php\?a=([^\/]+)/i",$link,$current_action_title);
			if(strstr($current_auth_char,$current_action_title[1])) {
				$show_nav_title = 1;
			}
		}
		if($show_nav_title) {
			echo "<div class=\"menu\"><tr style=\"cursor: hand;\" onClick=\"javascript:showDiv('menu_{$nc}');\" >\n";
			echo "<td><p class=\"menuTitle\">".$ctitle."</p></td>\n";
			echo "</tr>\n";
			echo "<tr id=\"menu_{$nc}\"><td><table>";
		}
		foreach ($nav as $title=>$link)	{
			preg_match("/^admin.php\?a=([^\/&]+)/i",$link,$current_action);
			//if(strstr($current_auth_char,$current_action[1])) {
				echo "<tr>\n";
				echo "<td class=\"menuList\"><div><img src=\"images/menu.gif\" /></div><p><a href=\"$link\" target=\"mainFrame\">".$title."</a></p></td>\n";
				echo "</tr>\n";
			//}
		}
		if($show_nav_title) {
			echo "</table></td></tr></div>";
		}
		$nc++;
	}
	// ��ҳ��
	function makepage($page_char = "", $colspan ,$only) {
		echo "<tr>";
		echo "<td colspan=\"".$colspan."\" align=\"right\">".$page_char."</td>";
		echo "</tr>\n";
	}
	
	//��Ϊtable�޷���ȷ���flush()Ч�������Ի���DIV��������������̬ҳʱʹ��
	function div_top($arg = array()) {
		?>
		<style type="text/css">
		<!--
		#outdiv {
			border: 1px solid #cccccc;
			background-color: #FFFFFF;
			padding: 6px;
		}
		#outdiv #contentdiv {
			font-family: Verdana, Arial, Helvetica, sans-serif;
			font-size: 11px;
			color: #000000;
			padding: 5px;
		}
		#outdiv #topdiv {
			background-color: #f3f3f3;
			padding: 6px;
			font-family: Verdana, Arial, Helvetica, sans-serif;
			font-size: 11px;
			font-weight: bold;
			color: #000000;
		}
		-->
		</style>
		<?php
		echo "<div class=\"outdiv\" id=\"outdiv\"><div class=\"topdiv\" id=\"topdiv\"><strong>{$arg['title']}</strong></div><div class=\"contentdiv\" id=\"contentdiv\">";
	}
	
	//��Ϊtable�޷���ȷ���flush()Ч�������Ի���DIV��������������̬ҳʱʹ��
	function div_bo() {
		echo "</div></div>";
	}
//��ʾ��Ϣ
	function oa_exit($msg, $url="",$target="") {
		if(empty($url)) {
			$url = "javascript:history.go(-1);";
		}
		if(empty($target)) {
			$target = "";
		} else {
			$target = "target=\"".$target."\"";
		}

		echo "<html>\n";
		echo "<head>\n";
		echo "<meta http-equiv=\"Content-Type\" content=\"text/html; charset=gb2312\" />\n";
		echo "<meta http-equiv=\"refresh\" content=\"3;URL=".$url."\">\n";
		echo "<title>��Ϣ</title>";
		echo "<style type=\"text/css\">\n";
		echo "<!--\n";
		echo "table {";
		echo "font-size: 12px;";
		echo "}\n";
		echo "a:link,a:visited,a:hover,a:active {";
		echo "color: #000;";
		echo "}\n";
		echo "-->\n";
		echo "</style>";
		echo "</head>";
		echo "<body bgcolor=\"#DEEBFF\">";
		echo "<table width=\"350\" border=\"0\" align=\"center\" cellpadding=\"5\" cellspacing=\"1\" bgcolor=\"#CCCCCC\" class=\"ob\">";
		echo "<tr>";
		echo "<td bgcolor=\"#FFFFFF\"> ";
		echo "<table width=\"100%\" border=\"0\" cellpadding=\"5\" cellspacing=\"0\" class=\"ob\">";
		echo "<tr> ";
		echo "<td bgcolor=\"#DEEBFF\"><strong>���޼��������̨</strong></td>";
		echo "</tr>";
		echo "<tr>";
		echo "<td align=\"center\"><br>".$msg."<br><a href=".$url." ".$target.">�������ﷵ��</a><br><br></td>\n";
		echo "</tr>";
		echo "</table>";
		echo "</td>";
		echo "</tr>";
		echo "</table>";
		echo "</body>\n</html>";
		exit;
	}

}
?>