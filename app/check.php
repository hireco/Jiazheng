<?php
header('Content-type: text/html; charset=gb2312');
header ("Cache-Control: no-cache, must-revalidate");
header ("Pragma: no-cache");
session_start();
if($_GET['check'] != $_SESSION['authnum'])
{
    echo "alert('��֤�벻��ȷ'";
    echo "document.getElementByid('check').focus();";
    exit;
}
?>
