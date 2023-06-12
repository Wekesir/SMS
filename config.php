<?php
define ('BASEURL', $_SERVER['DOCUMENT_ROOT'].'/school/');

checkReg();

function checkReg(){
    global $db;
    $query = $db->query("SELECT * FROM system_configuration");
    $schoolData = mysqli_fetch_array($query);

    $status = $schoolData['system_status'];//gets the  registration status of the system

    if($status == 0){
        unset($_SESSION['user']);//unsets the current user logged in untilll the system is registered again
    }
}
?>

