<?php
require_once $_SERVER['DOCUMENT_ROOT'].'/school/core/init.php';
$query = $db->query("SELECT * FROM formerstudents_marks");
while($queryData    =   mysqli_fetch_assoc($query)){
    $id = $queryData['id'];
    $examType        = $queryData['examType'];
        $level           = $queryData['level']; 
        $term            = $queryData['term']; 
        $year            = $queryData['year']; 
        $marksEncoded    = $queryData['performance']; 
    
        $marksDecoded    =   json_decode($marksEncoded,true);

        foreach($marksDecoded as $subject){
            $mathematics    =   $subject['Mathematics'];
            $english        =   $subject['English'];
            $kiswahili      =   $subject['Kiswahili'];
            $science        =   $subject['Science'];
            $sst            =   $subject['Social Studies & CRE'];
        }

        $total  =   ($mathematics + $english + $kiswahili + $science + $sst);

    $db->query("UPDATE formerstudents_marks SET total='{$total}' WHERE id='$id'");
}
?>