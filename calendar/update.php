<?php
require_once $_SERVER['DOCUMENT_ROOT'].'/school/core/init.php';
//update.php

if(isset($_POST["id"])){
 $id          = (int)clean($_POST['id']);
 $title       = clean($_POST['title']);
 $start_event = clean($_POST['start']);
 $end_event   = clean($_POST['end']);
 $query = $db->query("UPDATE events 
                      SET title='$title', start_event='$start_event', end_event='$end_event' 
                      WHERE id='$id'");
}

?>