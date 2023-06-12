<?php
require_once $_SERVER['DOCUMENT_ROOT'].'/school/core/init.php';
$count=1;

/***************************************************************************************************
 * FILTER STUDENT RESULT
 ***************************************************************************************************/
if(isset($_POST)){
    $termFilter = clean($_POST['termFilter']);
    $levelFilter = clean($_POST['levelFilter']);
    $yearFilter = clean($_POST['yearFilter']);
    if(empty($levelFilter) && empty($termFilter)){
        $query = $db->query("SELECT * FROM students,formerstudents_marks 
                                        WHERE students.id=formerstudents_marks.student_id AND formerstudents_marks.year='$yearFilter'  ORDER BY formerstudents_marks.total DESC");
    }else if(!empty($levelFilter) && empty($termFilter)){
        $query = $db->query("SELECT * FROM students,formerstudents_marks 
                                        WHERE students.id=formerstudents_marks.student_id AND formerstudents_marks.year='$yearFilter' AND formerstudents_marks.level='$levelFilter'  ORDER BY formerstudents_marks.total DESC");
    }else{
        $query = $db->query("SELECT * FROM students,formerstudents_marks 
                                        WHERE students.id=formerstudents_marks.student_id AND formerstudents_marks.year='$yearFilter' AND formerstudents_marks.term='$termFilter'  ORDER BY formerstudents_marks.total DESC");
    }

    while($queryData    =   mysqli_fetch_assoc($query)) :
        ob_start();
        
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
        
        ?>

            <tr>
                <td><?=$count;?>.</td>
                <td><?=$queryData['stdname']?></td>
                <td><?=$mathematics?></td>
                <td><?=$english?></td>
                <td><?=$kiswahili?></td>
                <td><?=$science?></td>
                <td><?=$sst?></td>
                <td><?=$total?></td>
                <td><?=$examType?></td>
                <td><?=$term?></td>
                <td><?=$year?></td>
            </tr>
          

        <?php $count++; endwhile; echo ob_get_clean();
}

?>