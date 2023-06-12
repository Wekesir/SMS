<?php
require_once $_SERVER['DOCUMENT_ROOT'].'/school/core/init.php';//connection to database
$messages = array();

$name    = trim(clean(((isset($_POST['name'])? $_POST['name'] : ''))));
$phone   = trim(clean(((isset($_POST['phone'])? $_POST['phone'] : ''))));
$message = trim(clean(((isset($_POST['message'])? $_POST['message'] : ''))));
$date    = date('Y-m-d H:i:s');

$db->query("INSERT INTO `messages` (`first_name`,`phonenumber`,`message`,`message_date`)
            VALUES ('$name','$phone','$message','$date')");

$messages[].='<b>Success! </b>Message sent';
echo displayMessages($messages);
?>