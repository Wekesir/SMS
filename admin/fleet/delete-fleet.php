<?php
require_once $_SERVER['DOCUMENT_ROOT'].'/school/core/init.php';
if(isset($_POST['delId'])){
    $id = clean((int)$_POST['delId']);
    $data = mysqli_fetch_array($db->query("SELECT image FROM fleet WHERE id='$id'"));
    $image = $data['image'];//gets the path to the image stored in the server
    if(unlink($_SERVER['DOCUMENT_ROOT'].$image)){//if the image has been removed from server
        $db->query("DELETE FROM fleet WHERE id='$id'");
        echo 'Vehicle has been deleted successfully!';
    }else{
        echo 'There was an error trying to remove file from server!';
    }
    $db->close();
}
?>