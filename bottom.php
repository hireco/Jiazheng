<?php
$sql = "select `footer` from ".$db_config." where `id`=1";
$footer = $db->fetch_one($sql)."<br/>".$copyright;
$tmpB->assign("footer", $footer);
?>
