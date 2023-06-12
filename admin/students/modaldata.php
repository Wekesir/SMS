<?php
require_once $_SERVER['DOCUMENT_ROOT'].'/school/core/init.php';


$year        = date('Y');
$studentId   = ((isset($_POST['studentId'])? (int)clean($_POST['studentId']) : ''));
$examtype    = ((isset($_POST['examType'])? strtoupper(clean($_POST['examType'])) : ''));
$level       = ((isset($_POST['level'])? clean($_POST['level']) : ''));
$term        = ((isset($_POST['term'])? clean($_POST['term']) : ''));
    
$mathematics = ((isset($_POST['mathematics'])? clean($_POST['mathematics']) : ''));
$science     = ((isset($_POST['science'])? clean($_POST['science']) : ''));
$kiswahili   = ((isset($_POST['kiswahili'])? clean($_POST['kiswahili']) : ''));
$english     = ((isset($_POST['english'])? clean($_POST['english']) : ''));
$sst         = ((isset($_POST['sst'])? clean($_POST['sst']) : ''));

$performanceArray[] = array(
    'Mathematics'           =>    $mathematics,
    'Science'               =>    $science,
    'Kiswahili'             =>    $kiswahili,
    'English'               =>    $english,
    'Social Studies & CRE'  =>     $sst
);

$performanceEncoded = json_encode($performanceArray);

$db->query("INSERT INTO formerStudents_marks(student_id, performance, examType, level, term, year)
            VALUES ('$studentId','{$performanceEncoded}','$examtype','$level','$term','$year')  ");

$messages[].='<b>Success! </b>Marks inserted';
echo displayMessages($messages);

?>