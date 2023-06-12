<?php
require_once $_SERVER['DOCUMENT_ROOT'].'/school/core/init.php';

$date = date('Y-m-d H:i;s');
$userid = (int)clean($_SESSION['user']);
$currentLogSession = (int)clean($_SESSION['activelogin']);
$db->query("UPDATE logs SET log_out = '$date', status=0 WHERE id='$currentLogSession' AND userId='$userid' ");

session_destroy();
header('Location: ../index.php');
?>