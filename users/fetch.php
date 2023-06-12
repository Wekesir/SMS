<?php
require_once $_SERVER['DOCUMENT_ROOT'].'/school/core/init.php';

if(isset($_POST['searchStudent'])):
    $count=1;
    $studentName = clean(trim($_POST['searchStudent']));
    if(empty($studentName)):
        $students=$db->query("SELECT * FROM `students` WHERE `deleted`=0 ORDER BY `stdname` ASC");
    else:
        $students=$db->query("SELECT * FROM `students` WHERE `stdname` LIKE '%".$studentName."%' AND `deleted`=0 ORDER BY `stdname` ASC");
    endif;    
    while( $student_data=mysqli_fetch_array($students)) :?>
    <tr>       
    <th scope="row"><?=$count;?></th>                              
    <td><?=$student_data['registration_number'];?></td>
    <td><?=$student_data['stdname'];?></td>
    <td><?=$student_data['stdgrade'];?></td>
    <td><?=$student_data['stdgender'];?></td>                   
    </tr>
<?php $count++; endwhile;
endif;
?>