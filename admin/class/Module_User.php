<?php
/*
���Ź���ģ��
========
��Ҫ���ࣺconfig.php forms.php class_DataBase.php SmartTemplate class_User.php
========
��Ҫ���ܣ���$a == ��
--------------------
employee ��Ա�б�	showemployee �鿴��Ա	delemployee ɾ����Ա	dealemployee ���������Ա
docheckemployee ִ��������Ա	doqualifyemployee ִ����֤��Ա	dorecommendemployee ִ���Ƽ���Ա	donoteemployee ִ����ӹ�Ա��ע	dohireemployee ִ��Ƹ���Ա
qualifyemployee ��֤��Ա	checkemployee ������Ա	recommendemployee �Ƽ���Ա	hireemployee Ƹ���Ա
employer �����б�	showemployer �鿴����	delemployer ɾ������	dealemployer �����������
docheckemployer ִ����������	dotopemployer ִ���ö�����	donoteemployer ִ����ӹ�����ע
checkemployer ��������	topemployer �ö�����
search ����	dosearch ִ������

���ӹ��� (function)
-------------------

����Ȩ�޵�˵��
==============
0 ��ʾ��Ȩִ�иò���
1 ���ݲ������У���ʾ����ִ�иò���(list,edit,attdeleteΪ1ʱֻ�ܲ����Լ���)
2 ��ʾ����ִ�иò���
==============
Author:Victor_Dinho
E-Mail:dinho.victor@gmail.com
*/
if (DINHO != 1)
{
	header('HTTP/1.1  404  Not  Found');  
	header("status:  404  Not  Found");  
	exit();
}
$db_employee = "`".$mysql_prefix."employee`"; //��Ա���ݱ�
$db_employer = "`".$mysql_prefix."employer`"; //�������ݱ�
$db_area = "`".$mysql_prefix."area`"; //�������ݱ�
$db_degree = "`".$mysql_prefix."degree`"; //ѧ�����ݱ�
$db_contract = "`".$mysql_prefix."contract`"; //��Լ���ݱ�
$num_in_page = 20;  //ÿҳ��ʾ��Ŀ

$allow = array();

switch($usr->rights['News'])
{
case 'S':  //��������Ա
	$allow = array(
		'employee' => 2, 'showemployee' => 2, 'delemployee' => 2, 'dealemployee' => 2,
		'docheckemployee' => 2, 'doqualifyemployee' => 2, 'dorecommendemployee' => 2, 'donoteemployee' => 2, 'dohireemployee' => 2,
		'qualifyemployee' => 2, 'checkemployee' => 2, 'recommendemployee' => 2, 'hireemployee' => 2,
		'employer' => 2, 'showemployer' => 2, 'delemployer' => 2, 'dealemployer' => 2,
		'docheckemployer' => 2, 'dotopemployer' => 2, 'donoteemployer' => 2,
		'checkemployer' => 2, 'topemployer' => 2,
		'search' => 2, 'dosearch' => 2,
		);
	break;
case 'A':  //һ������Ա
	$allow = array(
		'employee' => 2, 'showemployee' => 2, 'delemployee' => 0, 'dealemployee' => 2,
		'docheckemployee' => 2, 'doqualifyemployee' => 2, 'dorecommendemployee' => 2, 'donoteemployee' => 2, 'dohireemployee' => 2,
		'qualifyemployee' => 2, 'checkemployee' => 2, 'recommendemployee' => 2, 'hireemployee' => 2,
		'employer' => 2, 'showemployer' => 2, 'delemployer' => 0, 'dealemployer' => 2,
		'docheckemployer' => 2, 'dotopemployer' => 2, 'donoteemployer' => 2,
		'checkemployer' => 2, 'topemployer' => 2,
		'search' => 2, 'dosearch' => 2,
		);
	break;
case 'M':  //��������Ա
	$allow = array(
		'employee' => 2, 'showemployee' => 1, 'delemployee' => 0, 'dealemployee' => 0,
		'docheckemployee' => 0, 'doqualifyemployee' => 0, 'dorecommendemployee' => 0, 'donoteemployee' => 0, 'dohireemployee' => 0,
		'qualifyemployee' => 0, 'checkemployee' => 0, 'recommendemployee' => 0, 'hireemployee' => 0,
		'employer' => 2, 'showemployer' => 1, 'delemployer' => 0, 'dealemployer' => 0,
		'docheckemployer' => 0, 'dotopemployer' => 0, 'donoteemployer' => 0,
		'checkemployer' => 0, 'topemployer' => 0,
		'search' => 0, 'dosearch' => 0,
		);
	break;
default:  //��Ȩ��
	$allow = array(
		'employee' => 0, 'checkemployee' => 0, 'delemployee' => 0, 'dealemployee' => 0,
		'docheckemployee' => 0, 'doqualifyemployee' => 0, 'dorecommendemployee' => 0, 'donoteemployee' => 0, 'dohireemployee' => 0,
		'qualifyemployee' => 0, 'checkemployee' => 0, 'recommendemployee' => 0, 'hireemployee' => 0,
		'employer' => 0, 'showemployer' => 0, 'delemployer' => 0, 'dealemployer' => 0,
		'docheckemployer' => 0, 'dotopemployer' => 0, 'donoteemployer' => 0,
		'checkemployer' => 0, 'topemployer' => 0,
		'search' => 0, 'dosearch' => 0,
		);
	break;
}
if (!($allow[$a] > 0)) $Form->oa_exit("��û��Ȩ��ִ�иò���~~");

if ($a == 'employee') //��Ա�б�
{
	$select = array('δ', '��');
	$sql_num = "select count(*) from ".$db_employee." where 1";
	$listNum = $db->fetch_one($sql_num);
	$formtitle = "��Ա [��".$listNum."��] [{$num_in_page}��/ҳ]";

	$cpage = isset($_GET['page']) ? intval($_GET['page']) : 1;
	$page_char = page($listNum,$num_in_page,$cpage,"admin.php?j=User&a=employee");
	$limitS = $cpage*$num_in_page-$num_in_page;

	$Form->cpheader();
	if($listNum > 0)
	{
		$Form->formheader(array("action" => "admin.php?j=User&a=dealemployee",
			"title" => $formtitle,
			"colspan" => "12",
			"name" => "form",
		));
		$Form->if_Del();
		$Form->js_checkall();
		echo "<tr align=\"center\">\n";
		echo "<td width=\"5%\">\n";
		echo "<input type=\"checkbox\" name=\"chkall\" value=\"on\" class=\"radio\" onclick=\"CheckAll(this.form)\"></td>\n";
		echo "<td width=\"8%\"><b>���</b></td>\n";
		echo "<td width=\"12%\"><b>����</b></td>\n";
		echo "<td width=\"12%\"><b>�绰</b></td>\n";
		echo "<td width=\"8%\"><b>����</b></td>\n";
		echo "<td width=\"6%\"><b>��ע</b></td>\n";
		echo "<td width=\"12%\"><b>ע������</b></td>\n";
		echo "<td width=\"9%\"><b>����</b></td>\n";
		echo "<td width=\"7%\"><b>Ƹ��</b></td>\n";
		echo "<td width=\"7%\"><b>��֤</b></td>\n";
		echo "<td width=\"7%\"><b>����</b></td>\n";
		echo "<td width=\"7%\"><b>�Ƽ�</b></td>\n";
		echo "</tr>\n";
		$lstRequest = "select * from ".$db_employee." where 1 order by `reg_time` desc limit ".$limitS.",".$num_in_page;
		$vRe = $db->query($lstRequest);
		while($nL = $db->fetch_array($vRe)) 
		{
			$tid = $nL['id'];
			$area_sql = "select `name` from ".$db_area." where `id`=".$nL['area'];
			$area = $db->fetch_one($area_sql);
			$tel = ($nL['mobile'] == "" ? $nL['telephone'] : $nL['mobile']);
			$name = ($nL['occupied'] == 1 ? "<font color=\"red\">".$nL['name']."</font>" : $nL['name']);
			$note = (checkStr($nL['note']) ? "Yes" : "");
			echo "<tr align=\"center\">\n";
			echo "<td><input type=\"checkbox\" name=\"employee[{$tid}]\" value=\"1\" class=\"radio\"></td>\n";
			echo "<td>".$nL['id']."</td>\n";
			echo "<td>".$name."</td>\n";
			echo "<td>".$tel."</td>\n";
			echo "<td>".$area."</td>\n";
			echo "<td>".$note."</td>\n";
			echo "<td>".date('y-m-d',$nL['reg_time'])."</td>\n";
			if ($allow[$a] == 2)
				echo "<td align=\"center\"><a href=\"admin.php?j=User&a=showemployee&id=".$nL['id']."\">�鿴</a> <a href=\"#\" onclick=\"ifDel('admin.php?j=User&a=delemployee&id=".$nL['id']."')\">ɾ��</a></td>\n";
			elseif ($allow[$a] == 1)
				echo "<td align=\"center\"><a href=\"admin.php?j=User&a=showemployee&id=".$nL['id']."\">�鿴</a></td>\n";
			echo "<td><a href=\"admin.php?j=User&a=hireemployee&id={$nL[id]}&page={$cpage}\">".$select[$nL['company']]."Ƹ��</a></td>\n";
			echo "<td><a href=\"admin.php?j=User&a=qualifyemployee&id={$nL[id]}&page={$cpage}\">".$select[$nL['qualified']]."��֤</a></td>\n";
			echo "<td><a href=\"admin.php?j=User&a=checkemployee&id={$nL[id]}&page={$cpage}\">".$select[$nL['checked']]."����</a></td>\n";
			echo "<td><a href=\"admin.php?j=User&a=recommendemployee&id={$nL[id]}&page={$cpage}\">".$select[$nL['recommended']]."�Ƽ�</a></td>\n";
			echo "</tr>\n";
		}
		echo "<tr><td colspan=\"12\" align=\"right\">".$page_char."</td></tr>";
		echo "<tr><td colspan=\"12\" align=\"center\"><select name=\"operation\"><option>��ѡ��</option><option value=1>Ƹ��</option><option value=2>��Ƹ��</option><option value=3>��֤</option><option value=4>����֤</option><option value=5>����</option><option value=6>������</option><option value=7>�Ƽ�</option><option value=8>���Ƽ�</option></select>&nbsp;&nbsp;&nbsp;&nbsp;<input class=\"button\" accesskey=\"\" type=\"submit\" name=\"\" value=\"����\" />";
		$Form->makehidden(array(
			'name' => "page",
			'value' => $cpage,
			));
		echo "\n</td></tr></form></table>\n";
	}
	else
	{
		$Form->tableheaderbig(array("title" => $formtitle,));
		$Form->maketd(array("��ʱû�й�Ա~~"));
		$Form->tablefooter();
	}
	$Form->cpfooter();
}
elseif ($a == 'showemployee') //�鿴��Ա
{
	$id = intval($_GET['id']);
	$sql_employee = "select * from ".$db_employee." where `id`='".$id."'";
	$nL = $db->fetch_one_array($sql_employee);
	if (empty($nL)) $Form->oa_exit("�ù�Ա������");

	$imgPath = "../attachment/user/";

	$area_sql = "select `name` from ".$db_area." where `id`=".$nL['area'];
	$area = $db->fetch_one($area_sql);
	$degree_sql = "select `name` from ".$db_degree." where `id`=".$nL['degree'];
	$degree = $db->fetch_one($degree_sql);
	$hired = ($nL['company'] == 1 ? "<font color=red>��Ƹ��</font>" : "δƸ��");
	$checked = ($nL['checked'] == 1 ? "<font color=red>��ͨ��</font>" : "δͨ��");
	$qualified = ($nL['qualified'] == 1 ? "<font color=red>����֤</font>" : "δ��֤");
	$recommended = ($nL['recommended'] == 1 ? "<font color=red>���Ƽ�</font>" : "δ�Ƽ�");
	
	$ori_width = 160;
	$ori_height = 120;
	if ($nL['picture'] == "")
	{
		if ($nL['sex'] == 'Ů')
			$path = $imgPath."lady.gif";
		else
			$path = $imgPath."man.gif";
		$width = $ori_width;;
		$height = $ori_height;
	}
	else
	{
		$path = $imgPath.$nL['picture'];
		$info = getimagesize($path);
		$picW = $info[0];
		$picH = $info[1];
		if ($picW / $picH < $ori_width / $ori_height)
		{
			$height = $ori_height;
			$width = $picW / $picH * $height;
		}
		else
		{
			$width = $ori_width;
			$height = $picH / $picW * $width;
		}
	}
	$picture = "<img src=\"".$path."\" width=\"".$width."\" height=\"".$height."\" />";

	if ($allow[$a] == 2)
	{
		$super = 1;
	}
	else
	{
		$super = 0;
	}

	$Tmp = template("employee");
	$Tmp->assign(array(
		'id' => $nL['id'],
		'username' => $nL['username'],
		'email' => $nL['email'],
		'name' => $nL['name'],
		'sex' => $nL['sex'],
		'age' => date("Y", time()) - $nL['birthyear'],
		'area' => $area,
		'nation' => $nL['nation'],
		'degree' => $degree,
		'visited_times' => $nL['visited_times'],
		'last_time' => date('Y-m-d', $nL['last_time']),
		'last_ip' => $nL['last_ip'],
		'identifyid' => $nL['identifyid'],
		'address' => $nL['address'],
		'telephone' => $nL['telephone'],
		'mobile' => $nL['mobile'],
		'qq' => $nL['qq'],
		'service' => trim(str_replace(',', ' ', $nL['service'])),
		'salary' => $nL['salary'],
		'experience' => $nL['experience'],
		'language' => trim(str_replace(',', ' ', $nL['language'])),
		'marriage' => $nL['marriage'],
		'hometown' => $nL['hometown'],
		'hired' => $hired,
		'checked' => $checked,
		'qualified' => $qualified,
		'recommended' => $recommended,
		'service_area' => trim(str_replace(',', ' ', $nL['service_area'])),
		'pic' => $picture,
		'note' => $nL['note'],
		'SUPER' => $super,
		));
	$sql_contract = "select * from ".$db_contract." where `employeeid`=".$nL['id'];
	$query_contract = $db->query($sql_contract);
	while ($contract = $db->fetch_array($query_contract))
	{
		$employee = $nL['name'];
		$employer_sql = "select `name` from ".$db_employer." where `id`=".$contract['employerid'];
		$employer_name = $db->fetch_one($employer_sql);
		$employer = "<a href=\"admin.php?j=User&a=showemployer&id=".$contract['employerid']."\">".$employer_name."</a>";
		$Tmp->append('CONTRACT_LIST', array(
			'employee' => $employee,
			'employer' => $employer,
			'agent' => $contract['agent'],
			'salary' => $contract['salary'],
			'note' => $contract['note'],
			'start_time' => date("Y-m-d", $contract['starttime']),
			'end_time' => date("Y-m-d", $contract['endtime']),
			));
	}
	$Tmp->output();
}
elseif ($a == 'delemployee') //ɾ����Ա
{
	$id = intval($_GET['id']);
	$sql = "select count(*) from ".$db_employee." where `id`='".$id."'";
	$num = $db->fetch_one($sql);
	
	if (!($num)) $Form->oa_exit("�ù�Ա������");

	$db->query("delete from ".$db_employee." where `id`='".$id."'");
	$Form->oa_exit("ɾ����Ա�ɹ�!","admin.php?j=User&a=employee");
}
elseif ($a == 'dealemployee') //���������Ա
{
	$page = $_POST['page'];
	$employee = $_POST["employee"];
	$operation = $_POST['operation'];
	if ($operation == 0)
	{
		$Form->oa_exit("��ѡ����Ĳ���", 'admin.php?j=User&a=employee&page='.$page);
	}
	$op = array('', 'company', 'company', 'qualified', 'qualified', 'checked', 'checked', 'recommended', 'recommended');
	$nop = array(0, 1, 0, 1, 0, 1, 0, 1, 0, 1, 0);
	if (is_array($employee))
	{
		$num = 0;
		foreach ($employee as $k => $v)
		{
			if ($v)
			{
				$tid = $k;
				$db->update($db_employee,array(
					$op[$operation] => $nop[$operation],
					"checker" => $username,
					"checkip" => getip(),
					),"`id`=".$tid);
				$num++;
				if ($operation == 7)
				{
					$db->update($db_employee, array(
						'rec_time' => time(),
						),"`id`=".$tid);
				}
				if ($operation == 8)
				{
					$db->update($db_employee, array(
						'rec_time' => 0,
						),"`id`=".$tid);
				}
			}
		}
		$Form->oa_exit("�ɹ�����{$num}����Ա","admin.php?j=User&a=employee&page={$page}");
	}
	else
		$Form->oa_exit("�㻹û��ѡ���Ա", "admin.php?j=User&a=employee&page={$page}");
}
elseif ($a == 'docheckemployee') //ִ��������Ա
{
	$check = $_POST['pass'];
	$id = $_POST['id'];
	if ($check == 0)
	{
		$db->update($db_employee,array(
			'checked' => 0,
			'reject_reason' => $_POST['reject_reason'],
			"checker" => $username,
			"checkip" => getip(),
			),"`id`='".$id."'");
	}
	else
	{
		$db->update($db_employee,array(
			'checked' => 1,
			'reject_reason' => "",
			"checker" => $username,
			"checkip" => getip(),
			),"`id`='".$id."'");
	}
	$Form->oa_exit("�ɹ�������Ա", "admin.php?j=User&a=showemployee&id=".$id);
}
elseif ($a == 'doqualifyemployee') //ִ����֤��Ա
{
	$qualify = $_POST['pass'];
	$id = $_POST['id'];
	$db->update($db_employee,array(
		'qualified' => $qualify,
		"checker" => $username,
		"checkip" => getip(),
		),"`id`='".$id."'");
	$Form->oa_exit("�ɹ���֤��Ա", "admin.php?j=User&a=showemployee&id=".$id);
}
elseif ($a == 'dorecommendemployee') //ִ���Ƽ���Ա
{
	$recommend = $_POST['pass'];
	if ($recommend == 0)
		$rec_time = 0;
	else
		$rec_time = time();
	$id = $_POST['id'];
	$db->update($db_employee,array(
		'recommended' => $recommend,
		'rec_time' => time(),
		"checker" => $username,
		"checkip" => getip(),
		),"`id`='".$id."'");
	$Form->oa_exit("�ɹ��Ƽ���Ա", "admin.php?j=User&a=showemployee&id=".$id);
}
elseif ($a == 'dohireemployee') //ִ��Ƹ���Ա
{
	$hired = $_POST['pass'];
	$id = $_POST['id'];
	$db->update($db_employee,array(
		'company' => $hired,
		"checker" => $username,
		"checkip" => getip(),
		),"`id`='".$id."'");
	$Form->oa_exit("�ɹ�Ƹ���Ա", "admin.php?j=User&a=showemployee&id=".$id);
}
elseif ($a == 'donoteemployee') //ִ���ύ��Ա��ע
{
	$note = checkStr($_POST['note']);
	$id = intval($_POST['id']);
	$db->update($db_employee, array(
		'note' => $note,
		), "`id`={$id}");
	$Form->oa_exit("�ɹ��ύ��Ա��ע", "admin.php?j=User&a=showemployee&id=".$id);
}
elseif ($a == 'qualifyemployee') //��֤��Ա
{
	$id = $_GET['id'];
	$page = $_GET['page'];
	$sql = "select `qualified` from ".$db_employee." where `id`=".$id;
	$qualified = $db->fetch_one($sql);
	if ($qualified == 0)
		$result = 1;
	else
		$result = 0;
	$db->update($db_employee,array(
		'qualified' => $result,
		"checker" => $username,
		"checkip" => getip(),
		),"`id`='".$id."'");
	$Form->oa_exit("�ɹ������Ա��֤", "admin.php?j=User&a=employee&page=".$page);
}
elseif ($a == 'checkemployee') //������Ա
{
	$id = $_GET['id'];
	$page = $_GET['page'];
	$sql = "select `checked` from ".$db_employee." where `id`=".$id;
	$checked = $db->fetch_one($sql);
	if ($checked == 0)
		$result = 1;
	else
		$result = 0;
	$db->update($db_employee,array(
		'checked' => $result,
		"checker" => $username,
		"checkip" => getip(),
		),"`id`='".$id."'");
	$Form->oa_exit("�ɹ������Ա����", "admin.php?j=User&a=employee&page=".$page);
}
elseif ($a == 'recommendemployee') //�Ƽ���Ա
{
	$id = $_GET['id'];
	$page = $_GET['page'];
	$sql = "select `recommended` from ".$db_employee." where `id`=".$id;
	$recommended = $db->fetch_one($sql);
	if ($recommended == 0)
	{
		$result = 1;
		$rec_time = time();
	}
	else
	{
		$result = 0;
		$rec_time = 0;
	}
	$db->update($db_employee,array(
		'recommended' => $result,
		'rec_time' => $rec_time,
		"checker" => $username,
		"checkip" => getip(),
		),"`id`='".$id."'");
	$Form->oa_exit("�ɹ������Ա�Ƽ�", "admin.php?j=User&a=employee&page=".$page);
}
elseif ($a == 'hireemployee') //Ƹ���Ա
{
	$id = $_GET['id'];
	$page = $_GET['page'];
	$sql = "select `company` from ".$db_employee." where `id`=".$id;
	$hired = $db->fetch_one($sql);
	if ($hired == 0)
		$result = 1;
	else
		$result = 0;
	$db->update($db_employee,array(
		'company' => $result,
		"checker" => $username,
		"checkip" => getip(),
		),"`id`='".$id."'");
	$Form->oa_exit("�ɹ������ԱƸ��", "admin.php?j=User&a=employee&page=".$page);
}
elseif ($a == 'employer') //�����б�
{
	$select = array('δ', '��');
	$sql_num = "select count(*) from ".$db_employer." where 1";
	$listNum = $db->fetch_one($sql_num);
	$formtitle = "���� [��".$listNum."��] [{$num_in_page}��/ҳ]";

	$cpage = isset($_GET['page']) ? intval($_GET['page']) : 1;
	$page_char = page($listNum,$num_in_page,$cpage,"admin.php?j=User&a=employer");
	$limitS = $cpage*$num_in_page-$num_in_page;

	$Form->cpheader();
	if($listNum > 0)
	{
		$Form->formheader(array("action" => "admin.php?j=User&a=dealemployer",
			"title" => $formtitle,
			"colspan" => "11",
			"name" => "form",
		));
		$Form->js_checkall();
		$Form->if_Del();
		echo "<tr align=\"center\">\n";
		echo "<td width=\"5%\">\n";
		echo "<input type=\"checkbox\" name=\"chkall\" value=\"on\" class=\"radio\" onclick=\"CheckAll(this.form)\"></td>\n";
		echo "<td width=\"10%\"><b>���</b></td>\n";
		echo "<td width=\"12%\"><b>����</b></td>\n";
		echo "<td width=\"18%\"><b>�绰</b></td>\n";
		echo "<td width=\"10%\"><b>����</b></td>\n";
		echo "<td width=\"6%\"><b>��ע</b></td>\n";
		echo "<td width=\"10%\"><b>ע������</b></td>\n";
		echo "<td width=\"10%\"><b>����</b></td>\n";
		echo "<td width=\"7%\"><b>����</b></td>\n";
		echo "<td width=\"7%\"><b>�ö�</b></td>\n";
		echo "</tr>\n";
		$lstRequest = "select * from ".$db_employer." where 1 order by `reg_time` desc limit ".$limitS.",".$num_in_page;
		$vRe = $db->query($lstRequest);
		while($nL = $db->fetch_array($vRe)) 
		{
			$sid = $nL['id'];
			$area_sql = "select `name` from ".$db_area." where `id`=".$nL['area'];
			$area = $db->fetch_one($area_sql);
			$tel = ($nL['mobile'] == "" ? $nL['telephone'] : $nL['mobile']);
			$name = ($nL['occupied'] == 1 ? "<font color=\"red\">".$nL['name']."</font>" : $nL['name']);
			$note = (checkStr($nL['note']) ? "Yes" : "");
			echo "<tr align=\"center\">\n";
			echo "<td><input type=\"checkbox\" name=\"employer[{$sid}]\" value=\"1\" class=\"radio\"></td>\n";
			echo "<td>".$nL['id']."</td>\n";
			echo "<td>".$name."</td>\n";
			echo "<td>".$tel."</td>\n";
			echo "<td>".$area."</td>\n";
			echo "<td>".$note."</td>\n";
			echo "<td>".date('y-m-d',$nL['reg_time'])."</td>\n";
			if ($allow[$a] == 2)
				echo "<td align=\"center\"><a href=\"admin.php?j=User&a=showemployer&id=".$nL['id']."\">�鿴</a> <a href=\"#\" onclick=\"ifDel('admin.php?j=User&a=delemployer&id=".$nL['id']."')\">ɾ��</a></td>\n";
			elseif ($allow[$a] == 1)
				echo "<td align=\"center\"><a href=\"admin.php?j=User&a=showemployer&id=".$nL['id']."\">�鿴</a></td>\n";
			echo "<td><a href=\"admin.php?j=User&a=checkemployer&id={$nL[id]}&page={$cpage}\">".$select[$nL['checked']]."����</a></td>\n";
			echo "<td><a href=\"admin.php?j=User&a=topemployer&id={$nL[id]}&page={$cpage}\">".$select[$nL['top']]."�ö�</a></td>\n";
			echo "</tr>\n";
		}
		echo "<tr><td colspan=\"11\" align=\"right\">".$page_char."</td></tr>";
		echo "<tr><td colspan=\"11\" align=\"center\"><select name=\"operation\"><option>��ѡ��</option><option value=1>����</option><option value=2>������</option><option value=3>�ö�</option><option value=4>���ö�</option></select>&nbsp;&nbsp;&nbsp;&nbsp;<input class=\"button\" accesskey=\"\" type=\"submit\" name=\"\" value=\"����\" />";
		$Form->makehidden(array(
			'name' => "page",
			'value' => $cpage,
			));
		echo "\n</td></tr></form></table>\n";
	}
	else
	{
		$Form->tableheaderbig(array("title" => $formtitle,));
		$Form->maketd(array("��ʱû�й���~~"));
		$Form->tablefooter();
	}
	$Form->cpfooter();
}
elseif ($a == 'showemployer') //�鿴����
{
	$id = intval($_GET['id']);
	$sql_employer = "select * from ".$db_employer." where `id`='".$id."'";
	$nL = $db->fetch_one_array($sql_employer);
	if (empty($nL)) $Form->oa_exit("�ù���������");

	$area_sql = "select `name` from ".$db_area." where `id`=".$nL['area'];
	$area = $db->fetch_one($area_sql);

	$degree_sql = "select `name` from ".$db_degree." where `id`=".$nL['ideal_degree'];
	$ideal_degree = $db->fetch_one($degree_sql);

	$home = ($nL['home'] == 1 ? "<font color=red>ס��</font>" : "��ס��");
	$checked = ($nL['checked'] == 1 ? "<font color=red>��ͨ��</font>" : "δͨ��");
	$top = ($nL['top'] == 1 ? "<font color=red>���ö�</font>" : "δ�ö�");

	$Tmp = template("employer");
	$Tmp->assign(array(
		'id' => $nL['id'],
		'username' => $nL['username'],
		'email' => $nL['email'],
		'name' => $nL['name'],
		'area' => $area,
		'last_time' => date('Y-m-d', $nL['last_time']),
		'last_ip' => $nL['last_ip'],
		'address' => $nL['address'],
		'telephone' => $nL['telephone'],
		'mobile' => $nL['mobile'],
		'qq' => $nL['qq'],
		'service' => trim(str_replace(',', ' ', $nL['service'])),
		'worktime' => $nL['worktime'],
		'home' => $home,
		'salary' => $nL['salary'],
		'visited_times' => $nL['visited_times'],
		'checked' => $checked,
		'top' => $top,
		'ideal_sex' => $nL['ideal_sex'],
		'ideal_age' => $nL['ideal_age'],
		'ideal_degree' => $ideal_degree,
		'note' => $nL['note'],
		));
	$sql_contract = "select * from ".$db_contract." where `employerid`=".$nL['id'];
	$query_contract = $db->query($sql_contract);
	while ($contract = $db->fetch_array($query_contract))
	{
		$employer = $nL['name'];
		$employee_sql = "select `name` from ".$db_employee." where `id`=".$contract['employeeid'];
		$employee_name = $db->fetch_one($employee_sql);
		$employee = "<a href=\"admin.php?j=User&a=showemployee&id=".$contract['employeeid']."\">".$employee_name."</a>";
		$Tmp->append('CONTRACT_LIST', array(
			'employee' => $employee,
			'employer' => $employer,
			'agent' => $contract['agent'],
			'salary' => $contract['salary'],
			'note' => $contract['note'],
			'start_time' => date("Y-m-d", $contract['starttime']),
			'end_time' => date("Y-m-d", $contract['endtime']),
			));
	}
	$Tmp->output();
}
elseif ($a == 'delemployer') //ɾ������
{
	$id = intval($_GET['id']);
	$sql = "select count(*) from ".$db_employer." where `id`='".$id."'";
	$num = $db->fetch_one($sql);

	if (!($num)) $Form->oa_exit("�ù���������");

	$db->query("delete from ".$db_employer." where `id`='".$id."'");
	$Form->oa_exit("ɾ�������ɹ�!","admin.php?j=User&a=employer");
}
elseif ($a == 'dealemployer') //�����������
{
	$page = $_POST['page'];
	$employer = $_POST["employer"];
	$operation = $_POST['operation'];
	if ($operation == 0)
	{
		$Form->oa_exit("��ѡ����Ĳ���", 'admin.php?j=User&a=employer&page='.$page);
	}
	if (is_array($employer))
	{
		$num = 0;
		foreach ($employer as $k => $v)
		{
			if ($v)
			{
				$tid = $k;
				if ($operation == 1)
					$db->update($db_employer,array(
						'checked' => 1,
						"checker" => $username,
						"checkip" => getip(),
						),"`id`='".$tid."'");
				elseif ($operation == 2)
					$db->update($db_employer,array(
						'checked' => 0,
						"checker" => $username,
						"checkip" => getip(),
						),"`id`='".$tid."'");
				elseif ($operation == 3)
					$db->update($db_employer,array(
						'top' => 1,
						'top_time' => time(),
						"checker" => $username,
						"checkip" => getip(),
						),"`id`='".$tid."'");
				elseif ($operation == 4)
					$db->update($db_employer,array(
						'top' => 0,
						'top_time' => 0,
						"checker" => $username,
						"checkip" => getip(),
						),"`id`='".$tid."'");
				else
					$Form->oa_exit("��������", "admin.php?j=User&a=employer&page={$page}");
				$num++;
			}
		}
		$Form->oa_exit("�ɹ�����{$num}������","admin.php?j=User&a=employer&page={$page}");
	}
	else
		$Form->oa_exit("�㻹û��ѡ�����", "admin.php?j=User&a=employer&page={$page}");
}
elseif ($a == 'docheckemployer') //ִ����������
{
	$check = $_POST['pass'];
	$id = $_POST['id'];
	if ($check == 0)
	{
		$db->update($db_employer,array(
			'checked' => 0,
			'reject_reason' => $_POST['reject_reason'],
			"checker" => $username,
			"checkip" => getip(),
			),"`id`='".$id."'");
	}
	else
	{
		$db->update($db_employer,array(
			'checked' => 1,
			'reject_reason' => "",
			"checker" => $username,
			"checkip" => getip(),
			),"`id`='".$id."'");
	}
	$Form->oa_exit("�ɹ���������", "admin.php?j=User&a=showemployer&id=".$id);
}
elseif ($a == 'dotopemployer') //ִ���ö�����
{
	$top = $_POST['pass'];
	if ($top == 0)
		$top_time = 0;
	else
		$top_time = time();
	$id = $_POST['id'];
	$db->update($db_employer,array(
		'top' => $top,
		'top_time' => $top_time,
		"checker" => $username,
		"checkip" => getip(),
		),"`id`='".$id."'");
	$Form->oa_exit("�ɹ��ö���Ա", "admin.php?j=User&a=showemployer&id=".$id);
}
elseif ($a == 'donoteemployer') //ִ���ύ������ע
{
	$note = checkStr($_POST['note']);
	$id = intval($_POST['id']);
	$db->update($db_employer, array(
		'note' => $note,
		), "`id`={$id}");
	$Form->oa_exit("�ɹ��ύ������ע", "admin.php?j=User&a=showemployer&id=".$id);
}
elseif ($a == 'checkemployer') //��������
{
	$id = $_GET['id'];
	$page = $_GET['page'];
	$sql = "select `checked` from ".$db_employer." where `id`=".$id;
	$checked = $db->fetch_one($sql);
	if ($checked == 0)
		$result = 1;
	else
		$result = 0;
	$db->update($db_employer,array(
		'checked' => $result,
		"checker" => $username,
		"checkip" => getip(),
		),"`id`='".$id."'");
	$Form->oa_exit("�ɹ������������", "admin.php?j=User&a=employer&page=".$page);
}
elseif ($a == 'topemployer') //�ö�����
{
	$id = $_GET['id'];
	$page = $_GET['page'];
	$sql = "select `top` from ".$db_employer." where `id`=".$id;
	$top = $db->fetch_one($sql);
	if ($top == 0)
		$result = 1;
	else
		$result = 0;
	$db->update($db_employer,array(
		'top' => $result,
		'top_time' => time(),
		"checker" => $username,
		"checkip" => getip(),
		),"`id`='".$id."'");
	$Form->oa_exit("�ɹ���������ö�", "admin.php?j=User&a=employer&page=".$page);
}
elseif ($a == 'search') //����
{
	$Form->cpheader("����");
	$Form->formheader(array(
		'title' => "����",
		'method' => "POST",
		'action' => "admin.php?j=User&a=dosearch",
		));
	$Form->makeselect(array(
		'option' => array('��ѡ��', '��Ա', '����'),
		'text' => "��Ա�����",
		'name' => "type",
		'selected' => 0,
		));
	$Form->makeinput(array(
		'text' => "���",
		'name' => "id",
		));
	$Form->makeinput(array(
		'text' => "�û���",
		'name' => "username",
		));
	$Form->makeinput(array(
		'text' => "����",
		'name' => "name",
		));
	$Form->makeinput(array(
		'text' => "�绰",
		'name' => "telephone",
		));
	$Form->makeinput(array(
		'text' => "�ֻ�",
		'name' => "mobile",
		));
	$Form->formfooter(array(
		"button" => array(
			array('value'=>"����"),
		)));
	$Form->cpfooter();
}
elseif ($a == 'dosearch') //ִ������
{
	$type = $_REQUEST['type'];
	if ($type == 0)
	{
		$Form->oa_exit("��ѡ��������Ա���ǹ���");
	}
	$id = intval($_REQUEST['id']);
	$username = checkStr($_REQUEST['username']);
	$name = checkStr($_REQUEST['name']);
	$telephoen = checkStr($_REQUEST['telephone']);
	$mobile = checkStr($_REQUEST['mobile']);
	if ($id && $username)
	{
		$Form->oa_exit("����ͬʱ�Ա�ź��û�����������");
	}
	if (!$id && !$username && !$name && !$telephone && !$mobile)
	{
		$Form->oa_exit("����д����һ������ѡ��");
	}
	$info = array(
		'type' => $type,
		'id' => $id,
		'username' => $username,
		'name' => $name,
		'telephone' => $telephone,
		'mobile' => $mobile,
		);
	$condition = makecondition($info);
	$addlink = makeaddlink($info);
	if ($type == 1)
	{
		$select = array('δ', '��');
		$sql_num = "select count(*) from ".$db_employee." where {$condition}";
		$listNum = $db->fetch_one($sql_num);
		$formtitle = "��Ա [��".$listNum."��] [{$num_in_page}��/ҳ]";

		$cpage = isset($_GET['page']) ? intval($_GET['page']) : 1;
		$page_char = page($listNum,$num_in_page,$cpage,"admin.php?j=User&a=employee{$addlink}");
		$limitS = $cpage*$num_in_page-$num_in_page;

		$Form->cpheader();
		if($listNum > 0)
		{
			$Form->formheader(array("action" => "admin.php?j=User&a=dealemployee",
				"title" => $formtitle,
				"colspan" => "12",
				"name" => "form",
			));
			$Form->if_Del();
			$Form->js_checkall();
			echo "<tr align=\"center\">\n";
			echo "<td width=\"5%\">\n";
			echo "<input type=\"checkbox\" name=\"chkall\" value=\"on\" class=\"radio\" onclick=\"CheckAll(this.form)\"></td>\n";
			echo "<td width=\"8%\"><b>���</b></td>\n";
			echo "<td width=\"12%\"><b>����</b></td>\n";
			echo "<td width=\"12%\"><b>�绰</b></td>\n";
			echo "<td width=\"8%\"><b>����</b></td>\n";
			echo "<td width=\"6%\"><b>��ע</b></td>\n";
			echo "<td width=\"12%\"><b>ע������</b></td>\n";
			echo "<td width=\"9%\"><b>����</b></td>\n";
			echo "<td width=\"7%\"><b>Ƹ��</b></td>\n";
			echo "<td width=\"7%\"><b>��֤</b></td>\n";
			echo "<td width=\"7%\"><b>����</b></td>\n";
			echo "<td width=\"7%\"><b>�Ƽ�</b></td>\n";
			echo "</tr>\n";
			$lstRequest = "select * from ".$db_employee." where {$condition} order by `reg_time` desc limit ".$limitS.",".$num_in_page;
			$vRe = $db->query($lstRequest);
			while($nL = $db->fetch_array($vRe)) 
			{
				$tid = $nL['id'];
				$area_sql = "select `name` from ".$db_area." where `id`=".$nL['area'];
				$area = $db->fetch_one($area_sql);
				$tel = ($nL['mobile'] == "" ? $nL['telephone'] : $nL['mobile']);
				$name = ($nL['occupied'] == 1 ? "<font color=\"red\">".$nL['name']."</font>" : $nL['name']);
				$note = (checkStr($nL['note']) ? "Yes" : "");
				echo "<tr align=\"center\">\n";
				echo "<td><input type=\"checkbox\" name=\"employee[{$tid}]\" value=\"1\" class=\"radio\"></td>\n";
				echo "<td>".$nL['id']."</td>\n";
				echo "<td>".$name."</td>\n";
				echo "<td>".$tel."</td>\n";
				echo "<td>".$area."</td>\n";
				echo "<td>".$note."</td>\n";
				echo "<td>".date('y-m-d',$nL['reg_time'])."</td>\n";
				if ($allow[$a] == 2)
					echo "<td align=\"center\"><a href=\"admin.php?j=User&a=showemployee&id=".$nL['id']."\">�鿴</a> <a href=\"#\" onclick=\"ifDel('admin.php?j=User&a=delemployee&id=".$nL['id']."')\">ɾ��</a></td>\n";
				elseif ($allow[$a] == 1)
					echo "<td align=\"center\"><a href=\"admin.php?j=User&a=showemployee&id=".$nL['id']."\">�鿴</a></td>\n";
				echo "<td><a href=\"admin.php?j=User&a=hireemployee&id={$nL[id]}&page={$cpage}\">".$select[$nL['company']]."Ƹ��</a></td>\n";
				echo "<td><a href=\"admin.php?j=User&a=qualifyemployee&id={$nL[id]}&page={$cpage}\">".$select[$nL['qualified']]."��֤</a></td>\n";
				echo "<td><a href=\"admin.php?j=User&a=checkemployee&id={$nL[id]}&page={$cpage}\">".$select[$nL['checked']]."����</a></td>\n";
				echo "<td><a href=\"admin.php?j=User&a=recommendemployee&id={$nL[id]}&page={$cpage}\">".$select[$nL['recommended']]."�Ƽ�</a></td>\n";
				echo "</tr>\n";
			}
			echo "<tr><td colspan=\"12\" align=\"right\">".$page_char."</td></tr>";
			echo "<tr><td colspan=\"12\" align=\"center\"><select name=\"operation\"><option>��ѡ��</option><option value=1>Ƹ��</option><option value=2>��Ƹ��</option><option value=3>��֤</option><option value=4>����֤</option><option value=5>����</option><option value=6>������</option><option value=7>�Ƽ�</option><option value=8>���Ƽ�</option></select>&nbsp;&nbsp;&nbsp;&nbsp;<input class=\"button\" accesskey=\"\" type=\"submit\" name=\"\" value=\"����\" />";
			$Form->makehidden(array(
				'name' => "page",
				'value' => $cpage,
				));
			echo "\n</td></tr></form></table>\n";
		}
		else
		{
			$Form->tableheaderbig(array("title" => $formtitle,));
			$Form->maketd(array("��ʱû�й�Ա~~"));
			$Form->tablefooter();
		}
		$Form->cpfooter();
	}
	elseif ($type == 2)
	{
		$select = array('δ', '��');
		$sql_num = "select count(*) from ".$db_employer." where {$condition}";
		$listNum = $db->fetch_one($sql_num);
		$formtitle = "���� [��".$listNum."��] [{$num_in_page}��/ҳ]";

		$cpage = isset($_GET['page']) ? intval($_GET['page']) : 1;
		$page_char = page($listNum,$num_in_page,$cpage,"admin.php?j=User&a=employer{$addlink}");
		$limitS = $cpage*$num_in_page-$num_in_page;

		$Form->cpheader();
		if($listNum > 0)
		{
			$Form->formheader(array("action" => "admin.php?j=User&a=dealemployer",
				"title" => $formtitle,
				"colspan" => "11",
				"name" => "form",
			));
			$Form->js_checkall();
			$Form->if_Del();
			echo "<tr align=\"center\">\n";
			echo "<td width=\"5%\">\n";
			echo "<input type=\"checkbox\" name=\"chkall\" value=\"on\" class=\"radio\" onclick=\"CheckAll(this.form)\"></td>\n";
			echo "<td width=\"10%\"><b>���</b></td>\n";
			echo "<td width=\"12%\"><b>����</b></td>\n";
			echo "<td width=\"18%\"><b>�绰</b></td>\n";
			echo "<td width=\"10%\"><b>����</b></td>\n";
			echo "<td width=\"6%\"><b>��ע</b></td>\n";
			echo "<td width=\"10%\"><b>ע������</b></td>\n";
			echo "<td width=\"10%\"><b>����</b></td>\n";
			echo "<td width=\"7%\"><b>����</b></td>\n";
			echo "<td width=\"7%\"><b>�ö�</b></td>\n";
			echo "</tr>\n";
			$lstRequest = "select * from ".$db_employer." where {$condition} order by `reg_time` desc limit ".$limitS.",".$num_in_page;
			$vRe = $db->query($lstRequest);
			while($nL = $db->fetch_array($vRe)) 
			{
				$sid = $nL['id'];
				$area_sql = "select `name` from ".$db_area." where `id`=".$nL['area'];
				$area = $db->fetch_one($area_sql);
				$tel = ($nL['mobile'] == "" ? $nL['telephone'] : $nL['mobile']);
				$name = ($nL['occupied'] == 1 ? "<font color=\"red\">".$nL['name']."</font>" : $nL['name']);
				$note = (checkStr($nL['note']) ? "Yes" : "");
				echo "<tr align=\"center\">\n";
				echo "<td><input type=\"checkbox\" name=\"employer[{$sid}]\" value=\"1\" class=\"radio\"></td>\n";
				echo "<td>".$nL['id']."</td>\n";
				echo "<td>".$name."</td>\n";
				echo "<td>".$tel."</td>\n";
				echo "<td>".$area."</td>\n";
				echo "<td>".$note."</td>\n";
				echo "<td>".date('y-m-d',$nL['reg_time'])."</td>\n";
				if ($allow[$a] == 2)
					echo "<td align=\"center\"><a href=\"admin.php?j=User&a=showemployer&id=".$nL['id']."\">�鿴</a> <a href=\"#\" onclick=\"ifDel('admin.php?j=User&a=delemployer&id=".$nL['id']."')\">ɾ��</a></td>\n";
				elseif ($allow[$a] == 1)
					echo "<td align=\"center\"><a href=\"admin.php?j=User&a=showemployer&id=".$nL['id']."\">�鿴</a></td>\n";
				echo "<td><a href=\"admin.php?j=User&a=checkemployer&id={$nL[id]}&page={$cpage}\">".$select[$nL['checked']]."����</a></td>\n";
				echo "<td><a href=\"admin.php?j=User&a=topemployer&id={$nL[id]}&page={$cpage}\">".$select[$nL['top']]."�ö�</a></td>\n";
				echo "</tr>\n";
			}
			echo "<tr><td colspan=\"11\" align=\"right\">".$page_char."</td></tr>";
			echo "<tr><td colspan=\"11\" align=\"center\"><select name=\"operation\"><option>��ѡ��</option><option value=1>����</option><option value=2>������</option><option value=3>�ö�</option><option value=4>���ö�</option></select>&nbsp;&nbsp;&nbsp;&nbsp;<input class=\"button\" accesskey=\"\" type=\"submit\" name=\"\" value=\"����\" />";
			$Form->makehidden(array(
				'name' => "page",
				'value' => $cpage,
				));
			echo "\n</td></tr></form></table>\n";
		}
		else
		{
			$Form->tableheaderbig(array("title" => $formtitle,));
			$Form->maketd(array("��ʱû�й���~~"));
			$Form->tablefooter();
		}
		$Form->cpfooter();
	}
}
else
{
	$Form->oa_exit("���ܲ�����","index.php?a=main");
}

function makecondition($arguments = array())
{
	$condition = "";
	$leading = "";
	if ($arguments['id'])
	{
		$condition .= $leading."`id`=".$arguments['id'];
		$leading = " and ";
	}
	if ($arguments['username'])
	{
		$condition .= $leading."`username`='".$arguments['username']."'";
		$leading = " and ";
	}
	if ($arguments['name'])
	{
		$condition .= $leading."`name`='".$arguments['name']."'";
		$leading = " and ";
	}
	if ($arguments['telephone'])
	{
		$condition .= $leading."`telephone`='".$arguments['telephone']."'";
		$leading = " and ";
	}
	if ($arguments['mobile'])
	{
		$condition .= $leading."`mobile`='".$arguments['mobile']."'";
		$leading = " and ";
	}
	return $condition;
}

function makeaddlink($arguments = array())
{
	$addlink = "";
	$addlink .= "&type=".$arguments['type'];
	if ($arguments['id'])
	{
		$addlink .= "&id=".$arguments['id'];
	}
	if ($arguments['username'])
	{
		$addlink .= "&username=".$arguments['username'];
	}
	if ($arguments['name'])
	{
		$addlink .= "&name=".$arguments['name'];
	}
	if ($arguments['telephone'])
	{
		$addlink .= "&telephone=".$arguments['telephone'];
	}
	if ($arguments['mobile'])
	{
		$addlink .= "&mobile=".$arguments['mobile'];
	}
	return $addlink;
}

?>