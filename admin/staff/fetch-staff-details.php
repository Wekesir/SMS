<?php
  require_once $_SERVER['DOCUMENT_ROOT'].'/school/core/init.php';

  $query = "SELECT * FROM `users` WHERE `deleted`=0";

  if(isset($_POST)):
    $name    = $_POST["STAFF_NAME"];
    $gender  = $_POST["STAFF_GENDER"];

    if(empty($name)):
        if($gender !== "BOTH"):
            $query = $query." AND `gender`='{$gender}'";
        endif;
    else:
        if($gender !== "BOTH"):
            $query = $query." AND `gender`='{$gender}'";
        else:
            
        endif;
    endif;

  endif;
?>