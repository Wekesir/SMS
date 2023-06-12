<?php
require_once $_SERVER['DOCUMENT_ROOT'].'/school/core/init.php';

if(isset($_POST)){
    $action     =  clean($_POST['action']);
    $userId     =  (int) clean($_POST['employee_id']);
    $action     =  clean($_POST['action']);
    $classData  = ((isset($_POST['classData'])?$_POST['classData']:''));
    $accessData = ((isset($_POST['accessData'])?$_POST['accessData']:''));

    //check on the permissions being assigned and exploding the specific array
    if(empty($classData) && !empty($accessData)){
       $db->query("UPDATE users SET permissions='{$accessData}' WHERE id='$userId'");
       echo 'Access level(s) set successfully!';     
    }elseif(!empty($classData) && empty($accessData)){
       $db->query("UPDATE users SET class_assigned='{$classData}' WHERE id='$userId'");
       echo 'Class(es) assigned successfully!';
    }
}
?>