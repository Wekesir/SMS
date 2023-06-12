<?php
require_once $_SERVER["DOCUMENT_ROOT"].'/school/core/init.php';

if(isset($_POST['SEARCH_NAME'])):
    $studentName = clean(trim($_POST['SEARCH_NAME']));
    $searchQuery = $db->query("SELECT * FROM `students` WHERE `accomplished`=0 AND `deleted`=0 AND `stdname` LIKE '%".$studentName."%' ORDER BY `stdname` LIMIT 20");
    if(mysqli_num_rows($searchQuery) == 0):
        $errors[].="<b>Errors! </b> No match found.";
    else:
        $rowcount = mysqli_num_rows($searchQuery);
        ob_start();?>      
        <table class="table table-hover table-bordered table-sm">          
        <tbody>
            <?php while($queryData = mysqli_fetch_array($searchQuery)): ?>
            <tr>
            <th scope="row">
                <input type="checkbox" id="" name="" value="<?=$queryData['registration_number']?>">
            </th>
            <td><?=$queryData['registration_number']?></td>
            <td><?=$queryData['stdname']?></td>
            <td><?=$queryData['stdgrade']?></td>
            </tr>
            <tr>
            <?php endwhile;?>
        </tbody>
        </table>
        <?php 
        echo ob_get_clean();
    endif;
endif;

//THE STUDENTS IN THE SCHOOL FEEDING PROGRAMME
if(isset($_POST['students'])):
    $studentQuery = $db->query("SELECT * FROM `food_programme_view` ORDER BY `stdname`");   
    ob_start();
    $count = 1;
    while($queryData = mysqli_fetch_array($studentQuery)) : ?>
    <tr>    
        <th scope="row"><?=$count;?></th>
        <td>
            <input type="checkbox" id="vehicle1" name="vehicle1" value="Bike">
            <label for="vehicle1"> </label>
        </td>
        <td><?=$queryData['registration_number'];?> </td>
        <td><?=$queryData['stdname'];?></td>
        <td><?=$queryData['stdgrade'];?></td>
        <td id="payment">0</td>
        <td>
            <input type="hidden" name="studentId" value="<?=$queryData['id']?>">
            <button class="btn btn-sm btn-default text-danger deleteStudent" data-studentId="<?=$queryData['id'];?>" title="Click to remove student from the food program."><i class="fas fa-trash"></i> delete</button>
        </td>
    </tr>
    <?php $count++; endwhile;
endif;

//searching students in the whole school
if(isset($_POST['search_all_students'])):
    $searchName = clean(trim(strtoupper($_POST['search_all_students'])));
    if(empty($searchName)):
       $searchQuery = $db->query("SELECT * FROM `students` WHERE `accomplished`=0 AND `deleted`=0 ORDER BY `stdname`");
    else:
       $searchQuery = $db->query("SELECT * FROM `students` WHERE `accomplished`=0 AND `deleted`=0 AND `stdname` LIKE '%".$searchName."%' ORDER BY `stdname`");
    endif; 
   
    ob_start();
       $count=1;
        while($queryData = mysqli_fetch_array($searchQuery)) :
        $studentId     = (int)$queryData['id'];
        $checkStudent  = mysqli_num_rows($db->query("SELECT `id` FROM `food_programme` WHERE `student_id`='{$studentId}'")); ?>
        <tr>    
        <th scope="row"><?=$count;?></th>
        <td>
            <input type="checkbox" id="vehicle1" name="vehicle1" value="Bike">
            <label for="vehicle1"> </label>
        </td>
        <td><?=$queryData['registration_number'];?></td>
        <td><?=$queryData['stdname'];?></td>
        <td><?=$queryData['stdgrade'];?></td>
        <td id="payment"> 0 </td>
        <td>
            <input type="hidden" name="studentId" value="<?=$queryData['id']?>">
            <button class="btn btn-sm btn-default text-danger deleteStudent" data-studentId="<?=$queryData['id'];?>" title="Click to remove student from the food program."><i class="fas fa-trash"></i> delete</button>
        </td>
        </tr>
    <?php $count++; endwhile;
endif;


//searching students who are already in teh school food programme
if(isset($_POST['UPI'])):
    $searchUPI = clean(trim(strtoupper($_POST['UPI'])));
    if(empty($searchUPI)):
        $searchQuery = $db->query("SELECT * FROM `food_programme_view` ORDER BY `stdname`");
    else:
        $searchQuery = $db->query("SELECT * FROM `food_programme_view` WHERE `registration_number`='{$searchUPI}'");
    endif; 
    ob_start();
       $count=1;
        while($queryData = mysqli_fetch_array($searchQuery)) :
        $studentId     = (int)$queryData['id'];
        $checkStudent  = mysqli_num_rows($db->query("SELECT `id` FROM `food_programme` WHERE `student_id`='{$studentId}'")); ?>
        <tr>    
        <th scope="row"><?=$count;?></th>
        <td>
            <input type="checkbox" id="vehicle1" name="vehicle1" value="Bike">
            <label for="vehicle1"> </label>
        </td>
        <td><?=$queryData['registration_number'];?></td>
        <td><?=$queryData['stdname'];?></td>
        <td><?=$queryData['stdgrade'];?></td>
        <td id="payment"> 0 </td>
        <td>
            <input type="hidden" name="studentId" value="<?=$queryData['id']?>">
            <button class="btn btn-sm btn-default text-danger deleteStudent" data-studentId="<?=$queryData['id'];?>" title="Click to remove student from the food program."><i class="fas fa-trash"></i> delete</button>
        </td>
        </tr>
    <?php $count++; endwhile;
endif;    
?>