<?php
require_once $_SERVER['DOCUMENT_ROOT'].'/school/core/init.php';
//delete.php

if(isset($_POST["id"])){
 $delId = (int)clean($_POST['id']);
 $query = $db->query("DELETE FROM events WHERE id='$delId' ");
}
?>