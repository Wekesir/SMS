<?php
require_once $_SERVER['DOCUMENT_ROOT'].'/school/core/init.php';

if(isset($_POST)){
    $groupId   = ((isset($_POST['editGroupId']))? (int)clean($_POST['editGroupId']):'');
    $groupName = ((isset($_POST['group_name']))? strtoupper(clean($_POST['group_name'])):'');
    if(empty($groupId)):
        $groupQ = $db->query("SELECT contact_group FROM contact_groups WHERE contact_group='$groupName'");
        if(mysqli_num_rows($groupQ)>0):
            $errors[].='<b>Error! </b>A group by this name already exists.';
            echo displayErrors($errors);
        else:
             $db->query("INSERT INTO contact_groups (contact_group) VALUES('$groupName') ");
             $messages[].='<b>Success! </b>Contact group added.';
             echo displayMessages($messages);
        endif;       
    else:
        $db->query("UPDATE contact_groups SET contact_group='$groupName' WHERE id='$groupId'");
        $messages[].='<b>Success! </b>Group has been updated.';
        echo displayMessages($messages);
    endif;
}
?>