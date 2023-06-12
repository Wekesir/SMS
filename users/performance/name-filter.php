<?php
require_once $_SERVER['DOCUMENT_ROOT'].'/school/core/init.php';
$count=1;
/***************************************************************************************************
 * SEARCHIN GSTUDENT MARKS
 ***************************************************************************************************/

 if(isset($_REQUEST['searchname'])){

     $searchname    =   clean($_REQUEST['searchname']);

     if(empty($searchname)){

            $query   =   $db->query("SELECT * FROM students,formerstudents_marks 
                                        WHERE students.id=formerstudents_marks.student_id ORDER BY formerstudents_marks.id DESC");

     }else if(!empty($searchname)){

            $query =   $db->query("SELECT * FROM marksview WHERE stdname LIKE '%".$searchname."%' ORDER BY id DESC");
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

/******************************************************************************************************************
 * CODE FOR SEARCHING ENDS HERE
 *****************************************************************************************************************/
     
 }
?>