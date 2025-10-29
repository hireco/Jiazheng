<?php
error_reporting(7);
require_once("config.php");
if (isset($_POST['name']))
{
	$db->insert($db_register, array(
		'name' => checkStr($_POST['name']),
		'telephone' => checkStr($_POST['telephone']),
		'note' => $_POST['telephone'],
		'time' => time(),
		'ip' => getip(),
		));
	echo "<script>alert('你已经成功提交快速登记了')</script>";
	echo "<script>window.close();</script>";
}
else
{
	$tmp = template("fastregister");
	$tmp->output();
}
?>
