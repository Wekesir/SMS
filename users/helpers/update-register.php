<?php
require_once $_SERVER['DOCUMENT_ROOT'].'/school/core/init.php';//database connection file

$updateId = (int)clean(((isset($_COOKIE['editRegisterId'])?$_COOKIE['editRegisterId']:0)));

if(isset($_POST)){
   $array[] = $_POST;
   foreach($_POST as $x=>$x_value){
      $newArray[] = array(
         'Id' => $x,
         'Status' => $x_value
      );
   }

    $attendance = json_encode($newArray); 
    if($updateId == 0):
        $errors[].='<b>Error! </b>There was a problem updating the attendance try selectiing data again.';
        echo displayError($errors);
    else:   
        $db->query("UPDATE 'studentattendance' SET attendance='{$attendance}' WHERE id='$updateId'");
        $messages[].='<b>Success! </b>You have successfully edited the register.';
         //deleting the $_COOKIE['editRegisterId']
        setcookie("editRegisterId", "", time() - 3600, "/");
        echo displayMessages($messages); 
       
    endif;    
}
?>