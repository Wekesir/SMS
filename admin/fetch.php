<?php
require_once $_SERVER['DOCUMENT_ROOT'].'/school/core/init.php';//database connection

global $loggedInUserData;//this variable holds all data for the logged in user
global $db;

//searching for student from the student finnace tab
if(isset($_POST['UPINumber'])){
    $UPINUmber      =   clean(base64_decode($_POST['UPINumber']));
    $studentQuery   =   $db->query("SELECT * FROM `students` WHERE `registration_number`='{$UPINUmber}' AND deleted=0 AND accomplished=0");
    //check if the data exists
    if(mysqli_num_rows($studentQuery) == 0):
        $errors[].='<b>Error! </b>UPI Number not found.';
        echo displayErrors($errors); 
    endif;
    //check if ther is more than one entry of the same data
    if(mysqli_num_rows($studentQuery) > 1):
        $errors[].="<b>Fatal Error! </b> More than one entry with this UPI Number found";
        echo displayErrors($errors);
    endif;
    //fetch the data and store in an object
    $studentData = mysqli_fetch_array($studentQuery);
    //check whether thr student has transfered or has completed schooling
    if($studentData['accomplished']==1 || $studentData['deleted']==1):
        $errors[].="<b>Error! </b>This student has either transfered or has finihed schooling";
        echo displayErrors($errors);
    endif;

    if(empty($errors)):
        ob_start(); ?>
        <div id="notificationsDiv"></div>
        <div class="form-group">
            <label for="" class="font-weight-bold" >STUDENT NAME</label>
            <input type="text" name="" id="" class="form-control" value="<?=$studentData['stdname']?>" readonly>
            <input type="hidden" name="UPINumber" id="" class="form-control" value="<?=$UPINUmber?>">
        </div>
        <div class="form-group">
            <label class="radio-inline"><input type="radio" name="action_type" value="credit" checked> CREDIT ACC </label>
            <label class="radio-inline"><input type="radio" name="action_type" value="debit"> DEBIT ACC </label>
        </div>
        <div class="form-group">
            <label for="" class="font-weight-bold" >DESCRIPTION</label>
            <input type="text" name="description" id="" class="form-control" required="required">
        </div>
        <div class="form-group">
            <label for="" class="font-weight-bold" >Amount(Kshs.)</label>
            <input type="number" name="amount" id="" class="form-control" min=0 required="required">
        </div>
        <div class="form-group">
            <button type="submit" class="btn btn-md btn-primary formSubmitBtn">
                <span class="spinner-border spinner-border-sm" role="status" aria-hidden="true"></span>
                Submit
            </button>
        </div>
        <?php echo ob_get_clean(); 
    endif;
}

//getting tht number of users online
if(isset($_POST['onlineUsers'])){
    $userQ = $db->query("SELECT id FROM logs WHERE status=1");
    echo mysqli_num_rows($userQ);
}

//FILTERING SCHOOL FEES RECORDS
if(isset($_POST['filterParam'])){
    $regNumber  = clean($_POST['filterParam']['regNo']);
    $toDate     = clean($_POST['filterParam']['to']);
    $fromDate   = clean($_POST['filterParam']['from']);
    $singleDate = clean($_POST['filterParam']['dateF']);
    $dateParam  = clean($_POST['filterParam']['filter']);
    $count = 1;

    if($dateParam=="single"){
        if(!empty($regNumber)):
            $feesQ = $db->query("SELECT * FROM `fees_invoices` INNER JOIN `students` WHERE `fees_invoices`.`student_id`=`students`.`id` AND `students`.`registration_number`='{$regNumber}' AND `fees_invoices`.`date`='{$singleDate}'");
        else:
            $feesQ = $db->query("SELECT * FROM `fees_invoices` INNER JOIN `students` WHERE `fees_invoices`.`student_id`=`students`.`id` AND `fees_invoices`.`date`='{$singleDate}'");
        endif;
    }else if($dateParam=="range"){
        if(!empty($regNumber)):
           $feesQ = $db->query("SELECT * FROM `fees_invoices` INNER JOIN `students` WHERE `fees_invoices`.`student_id`=`students`.`id` AND `students`.`registration_number`='{$regNumber}' AND `fees_invoices`.`date` BETWEEN CAST('{$fromDate}' AS DATE) AND CAST('{$toDate}' AS DATE)");
        else:
           $feesQ = $db->query("SELECT * FROM `fees_invoices` INNER JOIN `students` WHERE `fees_invoices`.`student_id`=`students`.`id` AND `fees_invoices`.`date` BETWEEN CAST('{$fromDate}' AS DATE) AND CAST('{$toDate}' AS DATE)");
        endif;
    }else{//none
        if(!empty($regNumber)):
            $feesQ = $db->query("SELECT * FROM `fees_invoices` INNER JOIN `students` WHERE `fees_invoices`.`student_id`=`students`.`id` AND `students`.`registration_number`='{$regNumber}'");
        else:
            $feesQ = $db->query("SELECT * FROM `fees_invoices` INNER JOIN `students` WHERE `fees_invoices`.`student_id`=`students`.`id` ORDER BY `fees_invoices`.`id` ASC");
        endif;        
    }
    ob_start();
    while($result = mysqli_fetch_array($feesQ)):
    ?>
     <tr>
        <td><?=$count;?></td>
        <td><?=$result['stdname'];?></td>
        <td><?=$result['mode'];?></td>
        <td><?=$result['amount'];?></td>
        <td><?=date("jS F, Y", strtotime($result['date']));?></td>
    </tr>
    <?php
    $count++; endwhile;
    echo ob_get_clean();
}

////CODE FOR SERACHIG FOR A SCHOOL DOCUMENT
    if(isset($_POST['docName'])){
        $docName = clean(trim($_POST['docName']));
        if(empty($docName)){
            $query=$db->query("SELECT * FROM   `school_documents` ORDER BY `document_name`");
        }else{
            $query=$db->query("SELECT * FROM `school_documents` WHERE `document_name` LIKE '%".$docName."%' ORDER BY `document_name`");
        }
        ob_start();
        $count = 1;
        while($queryData = mysqli_fetch_array($query)):
        ?>
            <tr>
                <td class="text-center"><?=$count;?></td>
                <td> <?=$queryData['document_name'];?> </td>
                <td class="text-center"><a href="<?=$queryData['document_path'];?>" title="Click to download doc." class="btn-default small_font"><i class="fas fa-file-download"></i> download.</a></td>
                <td class="text-center">   
                    <a href="schooldocuments.php?editDocument=<?=encodeURL($queryData['id']);?>"><i class="fas fa-pencil-alt"></i> edit.</a>                              
                    <a href="schooldocuments.php?delDocument=<?=encodeURL($queryData['id']);?>" class="text-danger" title="Click to delete document from server"><i class="fas fa-trash-alt"></i> delete.</a>                                        
                </td>
            </tr>
        <?php $count++; endwhile; echo ob_get_clean();
    }
//////SEARCHING SCHOOL DOCUMENT ENDS HERE

/***************************************************************************************************************************************
 * SEARCHING FOR STUDENT WHEN MAKING PAYMENT
 ***************************************************************************************************************************************/
if(isset($_POST['findstudent']) && $_POST['findstudent'] != ''){
    global $db;

        $regNumber    = clean($_POST['findstudent']);
        $query        = $db->query("SELECT * FROM students WHERE registration_number='$regNumber' AND deleted=0 AND accomplished=0");
        //check if the data exists
        if(mysqli_num_rows($query) == 0){
            $errors[].='<b>Error! </b>The registration number was not found.';
            echo displayErrors($errors);
        }else{
        $studentArray = mysqli_fetch_array($query); 
        $Id           = (int)$studentArray['id'];
        $regNumber    = $studentArray['registration_number'];
        $name         = $studentArray['stdname'];
        $grade        = $studentArray['stdgrade'];
        $transport    = $studentArray['transport'];
        $food         = $studentArray['food'];

        $financeQuery = mysqli_fetch_array($db->query("SELECT * FROM `fees_account` WHERE `student_id`='{$Id}'"));
        $accountBalance       = $financeQuery['amount'];
        ob_start();
         ?>
         <label class="float-right"> <a href="/school/admin/students.php?edit=<?=$Id;?>" title="Edit this student's information"><i class="fas fa-pencil">  </i> Edit student info. </a> </label>

        <div class="form-group">
            <label for="">Student Name</label>
            <input type="text" class="form-control" value="<?=$name?>" readonly> 
        </div>
        <div class="form-group">
            <label for="">Current Level of education</label>
            <input type="text" class="form-control" value="<?=$grade?>" readonly>
        </div>
        <?php if($configurationData['transport'] == 'YES'){?>
        <div class="form-group">
            <Label for="transport">Transportation charges included?</Label>
            <div class="radio">
                <label for="transport" class="radio-inline"><input type="radio"  name="transport" value="YES" <?php if($transport=='YES'){echo 'checked';}?>>YES</label>
                <label for="transport" class="radio-inline"><input type="radio"  name="transport" value="NO" <?php if($transport=='NO'){echo 'checked';}?>>NO</label>
            </div>
        </div>
        <?php } if($configurationData['food'] == 'YES'){?>
        <div class="form-group">
            <Label for="food">Food charges included?</Label>
            <div class="radio">
                <label for="food" class="radio-inline"><input type="radio"  name="food" value="YES" <?php if($food=='YES'){echo 'checked';}?>>YES</label>
                <label for="food" class="radio-inline"><input type="radio"  name="food" value="NO" <?php if($food=='NO'){echo 'checked';}?>>NO</label>
            </div>
        </div>
        <?php }?>
        <div class="form-group">
            <label for="">Student Finance Account (Kshs.)</label>
            <input type="number" class="form-control" value="<?=$accountBalance?>" readonly>
        </div>   

    <?php       echo ob_get_clean(); 
        }
}
/***************************************************************************************************************************************
 * FIND STUDENT ENDS HERE
 ***************************************************************************************************************************************/

//this is for verifying the phone number length
if(isset($_POST['phone_length']) && $_POST['phone_length'] != '' ||isset($_POST['phone2_length']) && $_POST['phone2_length'] != ''){
    $phonelength=clean(((isset($_POST['phone_length'])?$_POST['phone_length'] : '')));
    if(strlen($phonelength) < 10){
        echo '<b>Phone number is less then 10 characters long</b>';
    }else if(strlen($phonelength)>10){
        echo '<b>Phone number is more than 10 characters long</b>';
    }
}

//function for fetching unread complains from the database
if(isset($_POST['complains'])){
    $message_query=$db->query("SELECT * FROM complains WHERE status=0");
    $count=mysqli_num_rows($message_query);
    echo $count;
}

//function for fetching messages from the database
if(isset($_POST['messages'])){
    $message_query=$db->query("SELECT * FROM messages WHERE read_status=0");
    $count=mysqli_num_rows($message_query);
    echo $count;
}

//if the delete student id is set and is not null
if(isset($_POST['delete_student_id']) && $_POST['delete_student_id']){
    $id=(int)clean($_POST['delete_student_id']);
    $db->query("UPDATE students SET deleted=1 WHERE id='$id'");
}

//autocomplete staff names for the finance
if(isset($_POST['staff_finance']) && $_POST['staff_finance'] != ''){
    $fetch_name=clean($_POST['staff_finance']);   
    $query=$db->query("SELECT * FROM users WHERE name LIKE '%".$fetch_name."%' AND id !=1");
        if(mysqli_num_rows($query) > 0){
            ob_start();?>
            <ul>
                <?php while($queryData=mysqli_fetch_array($query)) :  ?>          
                       <a href="salaries.php?searchstaff=<?=$queryData['id'];?>">
                       <li class="text-left small_font" id="<?=$queryData['id'];?>"> <b> <?=$queryData['name'];?> </b> </li>
                        </a>
             <?php   endwhile; ?>
           </ul>
         <?php    echo ob_get_clean();
        }else{
            echo '<span class="small_font text-danger text-left"><b>Oops!</b> No data found.</span>';
        }
}


//autocomplete student names
if(isset($_POST['student_name'])){
    $fetch_name=clean($_POST['student_name']);   
    $count = 1;
    $myclass=decodeURL($_POST['search_student_level']);
    if(empty($fetch_name)):      
        $query=$db->query("SELECT * FROM `students` WHERE `deleted`=0 AND `stdgrade`='{$myclass}' ORDER BY `stdname` ASC");
    else:
        $query=$db->query("SELECT * FROM `students` WHERE `stdname` LIKE '%".$fetch_name."%' AND `stdgrade`='{$myclass}' AND `deleted`=0 AND `accomplished`=0");
    endif;
        if(mysqli_num_rows($query) > 0):
            ob_start();
            while($student_data=mysqli_fetch_array($query)) :  ?>      
                <tr>      
                <th scope="row"><?=$count;?></th>                              
                <td><?=$student_data['registration_number'];?></td>
                <td><?=$student_data['stdname'];?></td>
                <td><?=$student_data['stdgrade'];?></td>
                <td><?=$student_data['stdgender'];?></td>                   
                <td class="text-center"> <a href="../gradestudent.php?studentId=<?=encodeURL($student_data['id']);?>" class="btn btn-default btn-xs text-center text-primary" id="<?=$student_data['id'];?>"> <i class="fas fa-poll"></i> evaluate</a> </td>
                <td class="text-center"> <a href="#" class="btn btn-default btn-xs text-center marksBtn" id="<?=encodeURL($student_data['id']);?>"> <i class="fas fa-poll"></i> marks</a> </td>
                </tr>
            <?php 
            $count++;  endwhile; echo ob_get_clean();
        endif;
}

//FOR FETCHING NOTIFICATIONS
if(isset($_POST['notifications'])){//this is for checking notifications
    $query=$db->query("SELECT * FROM applications WHERE status=0");
    $count=mysqli_num_rows($query);
    echo $count;//echos out the number of rows with status zero
}


//FOR FETCHING BOOKS FROM DATABASE WHEN BUTTON IS CLICKED
if(isset($_POST['grade_id']) && $_POST['grade_id'] !=''){
    $grade_id=(int)clean(((isset($_POST['grade_id'])? $_POST['grade_id'] : '')));
    ob_start();
     
    $gradeQuery=$db->query("SELECT * FROM grade WHERE id='$grade_id'");
    $gradeData=mysqli_fetch_array($gradeQuery);
    ?>

        <hr><h5 class="text-center" style="background-color:black;color:white;"><?=strtoupper($gradeData['grade']);?></h5>

        <table class="table-bordered" width=100%;>
            <thead>        
                <th></th>       
                <th>BOOK</th>
                 <?php if($loggedInUserData['permissions'] != 'General user'){?>
                    <th>EDIT</th>                
                    <th>DELETE</th>
                 <?php }?>
            </thead>
            <tbody>
                <?php 
                $gradeQuery=$db->query("SELECT * FROM books WHERE grade_id='$grade_id' ORDER BY id DESC");  
                $count=1;
                while($gradeData=mysqli_fetch_array($gradeQuery)) : ?>
                    <tr>                        
                        <td><?=$count;?></td>
                        <td>
                            <?=$gradeData['book_name'];?>
                        </td>
                         <?php if($loggedInUserData['permissions'] != 'General user'){?>
                            <td class="text-center">
                                <a href="books.php?editbook=<?=$gradeData['id'];?>" class="btn btn-default text-success" id="<?=$gradeData['id'];?>">
                                    <i class="fas fa-pencil-alt"></i>
                                </a>
                            </td>
                            <td class="text-center">                        
                                <button class="btn btn-default text-danger displaydeletemodalbtn" id="<?=$gradeData['id'];?>"><i class="fas fa-trash-alt"></i></button>                           
                            </td>
                         <?php }?>
                    </tr>
                <?php  
                $count++;
                endwhile; ?>
            </tbody>
        </table>
    <?php
   
    echo ob_get_clean();
}

?>