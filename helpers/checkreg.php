<?php
require_once $_SERVER['DOCUMENT_ROOT'].'/school/core/init.php';

if(isset($_POST['request'])){

    global $db;

    $query = $db->query("SELECT * FROM `system_configuration`");
    $schoolData = mysqli_fetch_array($query);

    $status = $schoolData['system_status'];//gets the  registration status of the system

    echo $status;
}

?>