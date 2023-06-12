<?php 
require_once $_SERVER['DOCUMENT_ROOT'].'/school/core/init.php';
$id=((isset($_POST['userid'])?(int)$_POST['userid']:''));
$year=date('Y');
$password='HillstopAcademy'.$year;
$hashedpassword=password_hash($password,PASSWORD_DEFAULT);
$updateQuery=$db->query("UPDATE users set password='$hashedpassword' WHERE id='$id'");
?>