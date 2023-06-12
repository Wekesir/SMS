<?php
$data = file_get_contents('php://input');

$handle = fopen('confirmation.txt','w');
fwrite($handle,$data);
?>