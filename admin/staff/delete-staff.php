<?php
    require_once $_SERVER['DOCUMENT_ROOT'].'/school/core/init.php';

    if(isset($_POST['DELETE_ID'])):
        $id = (int)$_POST['DELETE_ID'];
        //check if the value is an integer
        if(!is_int($id)):
            $errors[].= "<b>Fatal Error!</b> The value being passed has been compromised."; echo displayErrors($errors);
        else:
            //check if the value being passed exists in the Db
            $staffQuery = $db->query("SELECT `id` FROM `users` WHERE `id`='{$id}'");
            if(mysqli_num_rows($staffQuery) == 0):
                $errors[].="<b>Error! </b>The user does bot exist."; echo displayErrors($errors);
            else:
                $queryData = mysqli_fetch_array($staffQuery);
                $getId = $queryData['id'];
                $db->query("UPDATE `users` SET `deleted`=1 WHERE `id`='{$getId}'");
                $messages[].="<b>Success! </b> This user has been deleted."; echo displayMessages($messages);
            endif;
        endif;
    endif;