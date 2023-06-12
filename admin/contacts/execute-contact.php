<?php
    require_once $_SERVER['DOCUMENT_ROOT'].'/school/core/init.php';

    if(isset($_POST)){
        $editId   = ((isset($_POST['editId']))?(int)clean($_POST['editId']):'');
        $name     = ((isset($_POST['name']))?strtoupper(clean($_POST['name'])):'');
        $phone    = ((isset($_POST['phone']))?clean($_POST['phone']):'');
        $email    = ((isset($_POST['email']))?clean($_POST['email']):'');
        $location = ((isset($_POST['location']))? strtoupper(clean($_POST['location'])):'');

        if(!empty($errors)):
            echo displayErrors($errors);
        else:
            if($editId>0):
                $db->query("UPDATE contacts SET name='$name',phone='$phone',email='$email',address='$location' WHERE id='$editId'");
                $messages[].='<b>Success! </b>Contact has been updated.';
            elseif($editId==0):
                $db->query("INSERT INTO `contacts`(`name`, `phone`, `email`, `address`, `inserted_on`) VALUES ('$name','$phone','$email','$location','$todayDate')");
                $messages[].='<b>Success! </b>New contact has been inserted successfully.';
            endif;            
            echo displayMessages($messages);
        endif;      
    }
    ?>