<?php
error_reporting(7);
require_once("config.php");

$tmp = template("aboutus");
$tmpH = template("header");
$tmpB = template("bottom");

require_once("header.php");
require_once("bottom.php");

$imgPath = "template/victor/images/icons/";
if (!isset($_GET['id']))
{
	$sql_min = "select min(`id`) from ".$db_company." where 1";
	$id = $db->fetch_one($sql_min);
}
else
{
	$id = intval($_GET['id']);
}
$sql_num = "select count(*) from ".$db_company." where `id`=".$id;
if ($db->fetch_one($sql_num) == 0)
{
	oa_exit("²ÎÊý´íÎó");
}
$sql_company = "select * from ".$db_company." where 1";
$query_company = $db->query($sql_company);
while ($company = $db->fetch_array($query_company))
{
	$tmp->append('COMPANY_LIST', array(
		'id' => $company['id'],
		'name' => $company['name'],
		));
}
$sql_this = "select * from ".$db_company." where `id`=".$id;
$this = $db->fetch_one_array($sql_this);
$tmp->assign(array(
	'content' => $this['content'],
	'name' => $this['name'],
	));
$tmpH->output();
$tmp->output();
$tmpB->output();
?>
