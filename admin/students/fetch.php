<?php
require_once $_SERVER['DOCUMENT_ROOT'].'/school/core/init.php';
global $db;

/********************************************************************
 * TTHIS IS THE FILTERING CODE FOR STUDEMTS BASED ON gENDER aND LEVEL
 * *****************************************************************
 */

 if(isset($_POST['filterGrade']) && isset($_POST['filterGender'])){
     $level  = clean($_POST['filterGrade']);
     $gender = clean($_POST['filterGender']); 

     if(empty($level)){
         $studentQuery = $db->query("SELECT * FROM students WHERE stdgender='$gender' ORDER BY stdname ASC");
     }else if(empty($gender)){
         $studentQuery = $db->query("SELECT * FROM students WHERE stdgrade='$level' ORDER BY stdname ASC");
     }else if(!empty($level) && !empty($gender)){
          $studentQuery = $db->query("SELECT * FROM students WHERE stdgrade='$level' AND stdgender='$gender' ORDER BY stdname ASC");
     }else if(empty($level) && empty($gender)){
           $studentQuery = $db->query("SELECT * FROM students WHERE accomplished=0 AND deleted=0 ORDER BY stdname ASC");
     }

     if(mysqli_num_rows($studentQuery) == 0){//if there are no records found
         echo '<label class="text-danger"><b>Oops! </b>No data found.</label>';
     }else{ 
        ob_start(); ?>                   
        <?php  
        $count=1;
        while($student_data=mysqli_fetch_array($studentQuery)) :  ?>      
            <tr>       
                <td class="text-center"><?=$count;?></td>                             
                <td><?=$student_data['registration_number'];?></td>
                <td><?=$student_data['stdname'];?></td>
                <td><?=$student_data['stdgrade'];?></td>
                <td class="text-center"><a href="#"  id="<?=$student_data['id'];?>" class=" view_student" title="Click to view student information."><i class="fas fa-eye"></i> view</a>
                </td>  
                <td class="text-center"><a href="students.php?edit=<?=$student_data['id'];?>" title="Click to edit student data."><i class="fas fa-pencil-alt fa-1x"></i>  edit</a>
                </td>  
                <td class="text-center"> <a id="<?=$student_data['id'];?>" class=" text-danger delete_student" title="Click to delete student."><i class="fas fa-trash-alt"></i> delete</a></td>
                <td class="text-center"> <a id="<?=$student_data['id'];?>" class="documents text-center" id="<?=$student_data['id'];?>" title="Click to view student documents."> <i class="fas fa-folder-open"></i> docs. </a> </td>
            </tr>
        <?php   
        $count++;
        endwhile; ?>       
    <?php echo ob_get_clean();
     }
    $db->close();
 }


//searching student from the admin panel
if(isset($_POST['search_student_name'])):
    $studentName = base64_decode($_POST['search_student_name']);
    if(empty($studentName)):
        $studentSearchQuery = $db->query("SELECT * FROM `students` WHERE `deleted`=0 AND `accomplished`=0 ORDER BY `stdname`");
    else:
        $studentSearchQuery = $db->query("SELECT * FROM `students` WHERE `deleted`=0 AND `accomplished`=0 AND `stdname` LIKE '%".$studentName."%' ORDER BY `stdname` ");
    endif;
    ob_start();
    $count=1; while( $student_data=mysqli_fetch_array($studentSearchQuery)) : ?>
        <tr>
            <th scope="row"><?=$count;?></th>                             
            <td><?=$student_data['registration_number'];?></td>
            <td><?=$student_data['stdname'];?></td>
            <td><?=$student_data['stdgrade'];?></td>
                <td class="text-center"><a href="#"  id="<?=$student_data['id'];?>" class=" view_student" title="Click to view student information."><i class="fas fa-eye"></i> view</a>
            </td>  
                <td class="text-center"><a href="students.php?edit=<?=$student_data['id'];?>" title="Click to edit student data."><i class="fas fa-pencil-alt fa-1x"></i>  edit</a>
            </td>  
            <td class="text-center"> <a id="<?=$student_data['id'];?>" class=" text-danger delete_student" title="Click to delete student."><i class="fas fa-trash-alt"></i> delete</a></td>
            <td class="text-center"> <a id="<?=$student_data['id'];?>" class="documents text-center" id="<?=$student_data['id'];?>" title="Click to view student documents."> <i class="fas fa-folder-open"></i> docs. </a> </td>
        </tr>
    <?php $count++; endwhile;
    echo ob_get_clean();
endif;

/*****************************************************************************************************************
 * FETCHING FORMER STUDENT BY NAME
 ****************************************************************************************************************/

 if(isset($_POST['searchFormerStudent'])){
     $formerStudentName =   clean($_POST['searchFormerStudent']);
     if(empty($formerStudentName)){
        $studentQuery = $db->query("SELECT * FROM `former_students`");
     }else if(!empty($formerStudentName)){
        $studentQuery = $db->query("SELECT * FROM `former_students` WHERE `name` LIKE '%".$formerStudentName."%'");
     }
    ob_start();
    $count = 1;
    while($student = mysqli_fetch_array($studentQuery)) :?>
        <tr>
            <td><?=$count;?></td>   
            <td><?=$student['name'];?></td>
            <td><?=$student['gender'];?></td>
            <td><?=$student['phone'];?></td>
            <td><?=$student['year_accomplished'];?></td>
            <td><a href="/school/admin/formerstudents.php?addmarks=<?=$student['id']?>"> <i class="fas fa-plus"></i> Add</a></td>
            <td><a href="/school/admin/formerstudents.php?viewmarks=<?=$student['id']?>"> <i class="far fa-eye"></i> View</a></td>
            <td>
                <a href="/school/admin/formerstudents.php?edit=<?=$student['id']?>"> <i class="fas fa-pencil-alt"></i> edit </a>
                <a href="#" class="text-danger deleteStudent" id="<?=$student['id']?>"> <i class="fas fa-trash-alt"></i> delete </a>
            </td>
        </tr>
        <?php $count++; endwhile;      
    echo ob_get_clean();
 }

 if(isset($_POST['formerCbcNameSearch']))://name search for the former student
    $studentName = base64_decode($_POST['formerCbcNameSearch']);
    if(empty($studentName)):
        $studentQuery = $db->query("SELECT * FROM `students` WHERE `deleted`=1 OR `accomplished`=1");
    else:
        $studentQuery = $db->query("SELECT * FROM `students` WHERE `stdname` LIKE '%".$studentName."%' AND `deleted`=1 OR `accomplished`=1 ORDER BY `stdname`");
    endif;
    ob_start();
    $count = 1;                    
    while($student_data=mysqli_fetch_array($studentQuery)):?>
        <tr>       
            <th scope="row"><?=$count;?></th>                             
            <td><?=$student_data['registration_number'];?></td>
            <td><?=$student_data['stdname'];?></td>
            <td><?=$student_data['stdgrade'];?></td>
            <td class="text-center"><a href="#"  id="<?=$student_data['id'];?>" class=" view_student" title="Click to view student information."><i class="fas fa-eye"></i> view</a>                            
            <td class="text-center"> <a href='#' id="<?=$student_data['id'];?>" class="documents text-center" id="<?=$student_data['id'];?>" title="Click to view student documents."> <i class="fas fa-folder-open"></i> docs. </a> </td>
            <td><a href="/school/gradestudent.php?studentId=<?=encodeURL($student_data['id'])?>" title="Click to view evaluation for this student.">evaluation.</a></td>
            <td><?=(($student_data['deleted']==1) ? '<span class="badge badge-warning">Transferred.</span>' : '<span class="badge badge-info">Completed</span>')?></td>
            <td><?=(($student_data['deleted']==1) ? date("jS F, Y", strtotime($student_data['delete_date'])): $student_data['accomplished_year'])?></td>
        </tr>
    <?php
    $count++; endwhile;
    echo ob_get_clean();
 endif;
?>