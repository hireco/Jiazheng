<?php
error_reporting(7);
include_once('config.php');
$j = isset($_GET["j"]) ? $_GET["j"] : 'News';
$a = isset($_GET["a"]) ? $_GET["a"] : 'add';

if (!$usr->logined) $Form->oa_exit("��û�е�¼ :(");
$username = $usr->username;
$link = "class/Module_{$j}.php";
$db_adminlog = "`".$mysql_prefix."adminlog`"; //������¼���ݱ�
if (in_array($j,$modules) && file_exists($link))
{
	$script = $_SERVER['PHP_SELF']."?".$_SERVER["QUERY_STRING"];
	$db->insert($db_adminlog,array(
		'script' => $script,
		'time' => time(),
		'ip' => getip(),
		));
	require($link);
}
else
	$Form->oa_exit("����ģ�鲻����","index.php?a=main");

?>