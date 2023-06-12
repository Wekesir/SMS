<?php
require_once $_SERVER['DOCUMENT_ROOT'].'/school/core/init.php';
$query = $db->query("SELECT * FROM events ORDER BY id");

$data = array();

while($row = mysqli_fetch_array($query)){
$data[] = array(
  'id'      => $row["id"],
  'title'   => $row["title"],
  'start'   => $row["start_event"],
  'end'     => $row["end_event"]
 );
}

echo json_encode($data);
?>