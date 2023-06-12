<?php
require_once $_SERVER['DOCUMENT_ROOT'].'/school/core/init.php';
//insert.php

if(isset($_POST["title"])){
 $title       = strtoupper(clean($_POST['title']));
 $start_event = clean($_POST['start']);
 $end_event   = clean($_POST['end']);

 $query = $db->query("INSERT INTO events 
                    (title, start_event, end_event) 
                    VALUES 
                    ('$title', '$start_event', '$end_event')");
}
?>