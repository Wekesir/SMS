<?php
require_once $_SERVER['DOCUMENT_ROOT'].'/school/core/init.php';
if(isset($_POST)){
    $deleteId = ((isset($_POST['deleteId']))?(int)clean($_POST['deleteId']):'');
    if(empty($deleteId)):
        $errors[].='<b>Error! </b>There was a problem deleting group. Try again.';
        echo displayErrors($errors);
    else:
        $db->query("DELETE FROM `contact_groups` WHERE `id` = '$deleteId'");
        echo 'Group deleted.';
    endif;
} 
?>