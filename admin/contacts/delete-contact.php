<?php
require_once $_SERVER['DOCUMENT_ROOT'].'/school/core/init.php';

if(isset($_POST['contactId'])){
    $deleteId = (int) clean($_POST['contactId']);
    $db->query("DELETE FROM contacts WHERE id='$deleteId'");
    $messages[].='<b>Success! </b>Contact has been deleted';
    echo displayMessages($messages);
}
?>