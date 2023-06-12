<?php
require_once $_SERVER['DOCUMENT_ROOT'].'/school/core/init.php';

if(isset($_POST)){
    $userid   = (int)$_SESSION['user'];
    $subject  = strtoupper(clean($_POST['subject']));
    $complain = trim(clean($_POST['complain']));

    $db->query("INSERT INTO complains(subject,submitted_by,details,submitted_on)
                VALUES('$subject','$userid','$complain','$todayDate')");
    $messages[].='<b>Success! </b>Complain submitted.';
    echo displayMessages($messages);
}
?>