<?php
error_reporting(7);
require_once("config.php");
$type = $_GET['type'];
$id = $_GET['id'];
if ($type == "reservee")
{
	$db_reserve = $db_reservee;
}
else
{
	$db_reserve = $db_reserver;
}
$db->update($db_reserve, array(
	'read' => 1,
	), "`id`=".$id);
?>
