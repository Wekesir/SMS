<?php require_once $_SERVER['DOCUMENT_ROOT']."/school/core/init.php"?>
<!DOCTYPE html>
<html>
<head>
   <?php 
   include '../admin/header.php'; ?>
</head>
<body>
<?php  include '../admin/navigation.php';?>
<div class="container-fluid">
<div class="row bg-light">
<div class="col-md-3">
    <?php include '../admin/left.php';?>
</div>
<div class="col-md-9" id="wrapper">
    <?php
    $regAbbrev = $configurationData['registrationNumber_abbreviation'];//gets the value from the system configuration table
   
    if(isset($_GET['add']) ||isset($_GET['edit'])){//if the add student button is clicked the following page should be presented with an add value opof 1
        
        $stdname         = trim(clean(((isset($_POST['name'])? $_POST['name']:''))));  
        $stddob          = trim(clean(((isset($_POST['dob'])? $_POST['dob']:''))));  
        $stdgender       = trim(clean(((isset($_POST['gender'])? $_POST['gender']:''))));  
        $stdgrade        = trim(clean(((isset($_POST['grade'])? $_POST['grade']:''))));  
        $stdpostal       = trim(clean(((isset($_POST['postal'])? $_POST['postal']:''))));  
        $stdimage        = trim(clean(((isset($_POST['stdimage'])? $_POST['stdimage']:''))));  
        $parname         = trim(clean(((isset($_POST['pname'])? $_POST['pname']:''))));  
        $parname2        = trim(clean(((isset($_POST['pname2'])? $_POST['pname2']:''))));  
        $parphone        = trim(clean(((isset($_POST['phone'])? $_POST['phone']:'')))); 
        $parphone2       = trim(clean(((isset($_POST['phone2'])? $_POST['phone2']:'')))); 
        $contacts        = $parphone.','.$parphone2;
        $paremail        = trim(clean(((isset($_POST['email'])? $_POST['email']:'')))); 
        $paraddress      = trim(clean(((isset($_POST['address'])? $_POST['address']:'')))); 
        $idnumber        = trim(clean(((isset($_POST['id_number'])? $_POST['id_number']:'')))); 
        $food            = trim(clean(((isset($_POST['food'])? $_POST['food']:'')))); 
        $transport       = trim(clean(((isset($_POST['transport'])? $_POST['transport']:'')))); 
        $scholarType     = trim(clean(((isset($_POST['scholarType'])? $_POST['scholarType']:'')))); 
        $regnumber       = trim(clean(((isset($_POST['regno'])? $_POST['regno']:''))));
        $filename        = trim(clean(isset($_FILES['image']['name'])?$_FILES['image']['name']:''));  


        if(isset($_GET['edit'])){
            $edit_id  = (int)$_GET['edit'];
            $query    = $db->query("SELECT * FROM `students` WHERE `id`='$edit_id'");
            $student  = mysqli_fetch_array($query);        
            $filename = trim(clean(((isset($_FILES['image']['name'])?$_FILES['image']['name']:''))));       
                if($filename !=''){//if  A DIFFERENT IMAGE HAS BEEN PROVIDED
                    $target_dir             =   '/uploads/students/';
                    $fileDestination        =   BASEURL.$target_dir.$_FILES['image']['name'];
                    $fileTempName           =   $_FILES["image"]["tmp_name"];
                    $fileError              =   $_FILES['image']['error'];
                    $fileSize               =   $_FILES['image']['size'];
                    $studentimageurl        =   '/school/uploads/students/'.$_FILES['image']['name'];
                    $imageFileNameExtension =   strtolower(pathinfo($filename,PATHINFO_EXTENSION));
                    $check                  =   getimagesize($_FILES['image']['tmp_name']);

                    if(file_exists($fileDestination))://check if file already exists
                        $errors[].='File already exists!';
                    endif;

                    if($fileSize>1000000)://checks the file size
                        $errors[].='The file is too large. Please select another and try again';
                    endif;

                    $extensions = array('jpg','jpeg','png','gif');
                    if(!in_array($imageFileNameExtension,$extensions,TRUE))://checks if the file extension is allowed
                        $errors[].='Only png, jpeg, jpg and png are allowed!';
                    endif;

                    if($check===false)://check if the file is an image
                        $errors[].='The file you chose is not not an image.';
                    endif;
                }
            $stdname          = strtoupper(trim(clean(((isset($_POST['name'])? $_POST['name']:$student['stdname'])))));  
            $stddob           = trim(clean(((isset($_POST['dob'])? $_POST['dob']:$student['stddob']))));  
            $stdgender        = strtoupper(trim(clean(((isset($_POST['gender'])? $_POST['gender']:$student['stdgender'])))));  
            $stdgrade         = strtoupper(trim(clean(((isset($_POST['grade'])? $_POST['grade']:$student['stdgrade'])))));  
            $level            =(int)get_student_level_id($stdgrade); 
            $stdpostal        = trim(clean(((isset($_POST['postal'])? $_POST['postal']:$student['stdpostal']))));                  
            $parname          = strtoupper(trim(clean(((isset($_POST['pname'])? $_POST['pname']:$student['parname'])))));  
            $parname2         = strtoupper(trim(clean(((isset($_POST['pname2'])? $_POST['pname2']:$student['parname2'])))));  
            $contacts_explode = explode(',',$student['contacts']);
            $parphone         = trim(clean(((isset($_POST['phone'])? $_POST['phone']:$contacts_explode[0])))); 
            $parphone2        = trim(clean(((isset($_POST['phone2'])? $_POST['phone2']:$contacts_explode[1])))); 
            $contacts         = $parphone.','.$parphone2;
            $paremail         = strtolower(trim(clean(((isset($_POST['email'])? $_POST['email']:$student['paremail']))))); 
            $paraddress       = strtoupper(trim(clean(((isset($_POST['address'])? $_POST['address']:$student['paraddress']))))); 
            $idnumber         = trim(clean(((isset($_POST['id_number'])? $_POST['id_number']:$student['idnumber'])))); 
            $food             = trim(clean(((isset($_POST['food'])? $_POST['food']:$student['food'])))); 
            $transport        = trim(clean(((isset($_POST['transport'])? $_POST['transport']:$student['transport'])))); 
            $scholarType      = trim(clean(((isset($_POST['scholarType'])? $_POST['scholarType']:$student['scholarType'])))); 
            $regnumber        = trim(clean(((isset($_POST['regno'])? $_POST['regno']:$student['registration_number']))));                 
            $stdimage         = trim(clean(((isset($filename) && $filename !=''? $studentimageurl:$student['stdimage']))));
        }         

            if(isset($_POST['updatebtn'])){//if the update button has been clicked to update student data                
                if($filename !=''){//if there is an image  provuded then move uploaded file
                 move_uploaded_file($fileTempName,$fileDestination);
                }
                $query=$db->query("UPDATE `students` SET
                                    `stdname`             =   '$stdname',
                                    `registration_number` =   '$regnumber',
                                    `idnumber`            =   '$idnumber',
                                    `stddob`              =    $stddob',
                                    `stdgender`           =   '$stdgender',
                                    `stdgrade`            =   '$stdgrade',
                                    `level`               =   '$level',
                                    `stdpostal`           =   '$stdpostal',
                                    `stdimage`            =   '$stdimage',
                                    `parname`             =   '$parname',
                                    `parname2`            =   '$parname2',
                                    `contacts`            =   '$contacts',
                                    `paremail`            =   '$paremail',
                                    `paraddress`          =   '$paraddress',
                                    `food`                =   '$food',
                                    `transport`           =   '$transport',
                                    `scholarType`         =   '$scholarType'
                                    WHERE `id` = '$edit_id'
                                     ");
                $messages[].='<b>Success! </b>Student data updated successfully.';
                displayMessages($messages);             
            }

        if(isset($_POST['addbtn'])){
        $stdname   = strtoupper(trim(clean(((isset($_POST['name'])? $_POST['name']:'')))));  
        $stddob    = trim(clean(((isset($_POST['dob'])? $_POST['dob']:''))));  
        $stdgender = strtoupper(trim(clean(((isset($_POST['gender'])? $_POST['gender']:'')))));  
        $stdgrade  = strtoupper(trim(clean(((isset($_POST['grade'])? $_POST['grade']:'')))));  
        $level     = get_student_level_id($stdgrade); //this function fetches thre particular level ID ans stores it in this variable
        $stdpostal = trim(clean(((isset($_POST['postal'])? $_POST['postal']:''))));  
        $studentimageurl = '';
        $filename  = trim(clean($_FILES['image']['name']));
        if($filename !=''){
            $target_dir='/uploads/students/';
            $fileDestination=BASEURL.$target_dir.$_FILES['image']['name'];
            $fileTempName =$_FILES["image"]["tmp_name"];
            $fileError=$_FILES['image']['error'];
            $fileSize=$_FILES['image']['size'];
            $studentimageurl='/school/uploads/students/'.$_FILES['image']['name'];
            $imageFileNameExtension=strtolower(pathinfo($filename,PATHINFO_EXTENSION));
            $check=getimagesize($_FILES['image']['tmp_name']);
            if(file_exists($fileDestination)){//check if file already exists
                $errors[].='<b>Error! </b>File already exists!';
            }
            if($fileSize>1000000){//checks the file size
                $errors[].='<b>Error! </b>The file is too large. Please select another and try again';
            }
            $extensions=array('jpg','jpeg','png','gif');
            if(!in_array($imageFileNameExtension,$extensions,TRUE)){//checks if the file extension is allowed
                $errors[].='<b>Error! </b>Only png, jpeg, jpg and png are allowed!';
            }
            if($check===false){//check if the file is an image
                $errors[].='<b>Error! </b>The file you chose is not not an image.';
            }
        }
     
        $parname         = strtoupper(trim(clean(((isset($_POST['pname'])? $_POST['pname']:'')))));  
        $parname2        = strtoupper(trim(clean(((isset($_POST['pname2'])? $_POST['pname2']:'')))));  
        $parphone        = trim(clean(((isset($_POST['phone'])? $_POST['phone']:'')))); 
        $parphone2       = trim(clean(((isset($_POST['phone2'])? $_POST['phone2']:'')))); 
        $contacts        = $parphone.','.$parphone2;
        $paremail        = strtolower(trim(clean(((isset($_POST['email'])? $_POST['email']:''))))); 
        $paraddress      = strtoupper(trim(clean(((isset($_POST['address'])? $_POST['address']:''))))); 
        $idnumber        = trim(clean(((isset($_POST['id_number'])? $_POST['id_number']:'')))); 
        $food            = trim(clean(((isset($_POST['food'])? $_POST['food']:'')))); 
        $transport       = trim(clean(((isset($_POST['transport'])? $_POST['transport']:'')))); 
        $scholarType     = trim(clean(((isset($_POST['scholarType'])? $_POST['scholarType']:'')))); 
        $regnumber       = trim(clean(((isset($_POST['regno'])? $_POST['regno']:'')))); 
        $year            = date('Y'); 
        
            if($regnumber != ''){//if the registration Number has been entered check if it already exists
                $regcheck = $db->query("SELECT registration_number FROM students WHERE registration_number='$regnumber'");
                if(mysqli_num_rows($regcheck) > 0){
                    $errors[].='<b>Error! </b>The registration number already exists.';
                }
            }            

            $namecheck = $db->query("SELECT * FROM students WHERE stdname='$stdname'");
            if(mysqli_num_rows($namecheck) > 0){
                $errors[].='<b>Error! </b>A student by the same name already exists.';
            }        

            $required_info  = array($stdname,$stddob,$stdgender,$stdgrade,$parname,$parphone,$idnumber);
            foreach($required_info as $info){
                if(empty($info)){
                    $errors[].='<b>Error! </b>Please provide all information marked *'; break;
                }
            }  
            if(!empty($errors)){
                displayErrors($errors);
            }else{//insert student data into the database
                if(!empty($filename)){//move the uploaded file only if its not empty
                    move_uploaded_file($fileTempName,$fileDestination);
                }
                $date=date('Y-m-d H:i:s');
                $db->query("INSERT INTO `students` 
                            (`stdname`,`stddob`,`registration_number`,`idnumber`,`stdgender`,`stdgrade`, `level`,`stdpostal`,`stdimage`,`parname`,`parname2`,`contacts`,`paremail`,`paraddress`,`doa`,`food`,`transport`,`scholarType`)
                            VALUES
                            ('$stdname','$stddob','$regnumber','$idnumber','$stdgender','$stdgrade', '$level','$stdpostal','$studentimageurl','$parname','$parname2','$contacts','$paremail','$paraddress','$date','$food','$transport','$scholarType')");
               
                $last_id = $db->insert_id;  

                $db->query("INSERT INTO `fees_account` (`student_id`) VALUES ('$last_id')");//creates a finance account for the student 

                if(empty($regnumber)){
                    assignRegNumber($last_id,$regAbbrev);//this function updates the inserted student and assigns new reg number 
                }
               
                $messages[].='<b>Success! </b>Student added to database successfully!';
                if(!empty($messages)){
                    displayMessages($messages);
                }
        }
    }

    function get_student_level_id($level){
        global $db;
        $gradeQuery = $db->query("SELECT `id` FROM `grade` WHERE `grade`='{$level}'");
        $gradeData = mysqli_fetch_array($gradeQuery);
        return (int)$gradeData['id']; //this is the ID associated with this specific level as input in the DB
    }
        ?>
        <h6 class="text-center" style="background: #f8f8f8;padding: 10px;">
            <label class="float-left"> <a href="/school/admin/students.php"> Back. </a> </label>
            <label> <?php if(isset($_GET['edit']) && $_GET['edit'] !=''){echo 'EDIT STUDENT DATA';}else{echo 'ADD NEW STUDENT';};?></label>
        </h6>
        <hr>
        <div class="container-fluid">
        <form method="post" action="<?php if(isset($_GET['edit']) && $_GET['edit'] != ''){echo 'students.php?edit='.$_GET['edit'].'';}else{ echo 'students.php?add=1';};?>" enctype="multipart/form-data">
        <div class="row">     
            <div class="form-group col-md-4">
                <Label for="name">Student Name</Label>
                <input type="text" class="form-control" name="name" required=required value="<?=$stdname;?>" required=required>
            </div>
             <div class="form-group col-md-4">
                <Label for="regno">UPI Number</Label>
                <input type="text" class="form-control" name="regno" value="<?=$regnumber;?>" >
            </div>
             <div class="form-group col-md-4">
                <Label for="dob">Date of birth</Label>
                <input type="date" class="form-control" name="dob" required=required value=<?=$stddob;?> max="<?=date("Y-m-d",strtotime("-5years"))?>" required=required>
            </div>
             <div class="form-group col-md-4">
                <Label for="gender">Gender*</Label>
                <div class="radio">
                <label for="gender" class="radio-inline"><input type="radio"  name="gender" value="MALE" <?php if($stdgender=='MALE'){echo 'checked';}?>> Male</label>
                 <label for="gender" class="radio-inline"><input type="radio"  name="gender" value="FEMALE" <?php if($stdgender=='FEMALE'){echo 'checked';}?>> Female</label>
                </div>
            </div>
            <div class="form-group col-md-4">
                <label for="grade">Enter grade</label>
                <select name="grade" id="grade" class="form-control" required=required>
                     <option value="" name="grade" id="grade"></option>
                     <?php $gradequery=$db->query("SELECT * FROM grade");
                            while($gradequeryData=mysqli_fetch_array($gradequery)):?>
                     <option value="<?=$gradequeryData['grade'];?>" name="grade" id="grade" <?php if($stdgrade==$gradequeryData['grade']){echo 'selected';};?>><?=$gradequeryData['grade'];?></option>     
                     <?php endwhile;?>              
                </select>
            </div>
             <?php if($configurationData['transport'] == 'YES'){?>
            <div class="form-group col-md-4">
                <label for="">Does the student use school transport?</label>
                <select name="transport" id="transport" class="form-control" required=required>
                        <option value=""></option>
                        <option value="YES" <?php if($transport == 'YES'){echo 'selected';}?>>YES</option>
                       <option value="NO" <?php if($transport == 'NO'){echo 'selected';}?>>NO</option>
                </select>
            </div>
             <?php }?>
            <?php if($configurationData['food'] == 'YES'){?>
            <div class="form-group col-md-4">
                <label for="">Does the student eat at school?</label>
                <select name="food" id="food" class="form-control" required=required>
                        <option value=""></option>
                        <option value="YES" <?php if($food == 'YES'){echo 'selected';}?>>YES</option>
                        <option value="NO" <?php if($food == 'NO'){echo 'selected';}?>>NO</option>
                </select>
            </div>
            <?php }?>
             <?php if($configurationData['system_type'] == 'BOARDING'){?>
            <div class="form-group col-md-4">
                <label for="">Boarding/Day scholar?</label>
                 <select name="scholarType" id="scholarType" class="form-control" required=required>
                        <option value=""></option>
                        <option value="DAY" <?php if($scholarType == 'DAY'){echo 'selected';}?>>DAY</option>
                        <option value="BOARDING" <?php if($scholarType == 'BOARDING'){echo 'selected';}?>>BOARDING</option>
                </select>
            </div>
            <?php }?>
             <div class="form-group col-md-4">
                 <label for="postal">Postal Address</label>
                <input type="text" name="postal" class="form-control" placeholder="(Optional)" value="<?=$stdpostal;?>">
            </div>
            <div class="form-group col-md-4">
                 <label for="image">Student image</label>
                 <?php if(isset($_GET['edit']) && $_GET['edit'] !=''){echo '
                    <div class="form-group"><img src="'.$stdimage.'" style="height: 200px;" alt=""></div>
                    ';}?>
                <input type="file" name="image" class="form-control">
            </div>
        
            
            <div class="form-group col-md-4">
                <label for="pname">Guardian's name*</label>
                <input type="text" class="form-control" name="pname" required=required value="<?=$parname;?>">
            </div>
            <div class="form-group col-md-4">
                 <label for="pname2">Second Guardian's name</label>
                <input type="text" name="pname2" class="form-control" placeholder="(Optional)" value="<?=$parname2;?>">
            </div>
            <div class="form-row col-md-4">
                <div class="form-group col-md-6">
                <label for="phone">Phone No. 1*</label><br>
                <input type="tel" name="phone" id="phone" maxlength="10" minlength="10" class="form-control" required=required placeholder="(Compulsory)" value="<?=$parphone;?>">
                 </div>
                <div class="form-group col-md-6">
                 <label for="phone">Phone Number 2</label><br>
                <input type="tel" name="phone2" id="phone2" maxlength="10" minlength="10" class="form-control" placeholder="(Optional)" value="<?=$parphone2;?>">
                </div>
                <div class="text-danger exsmall_font" id="phone_verify"></div>
            </div>
            <div class="form-group col-md-4">
                <label for="id">ID No.*:</label>
                <input type="number" name="id_number" class="form-control" id="id_number" value="<?=$idnumber?>" required=required>
            </div>
            <div class="form-group col-md-4">
                 <label for="email">Parent Email</label>
                <input type="email" name="email" class="form-control" placeholder="(Optional)" value="<?=$paremail;?>">
            </div>
             <div class="form-group col-md-4">
                 <label for="address">Residence*</label>
                <input type="text" name="address" class="form-control" value="<?=$paraddress;?>" required=required>
            </div>
        
      </div><!--closing parents row div-->

      <input type="submit" class="btn btn-md btn-success" name="<?php if(isset($_GET['edit'])){echo 'updatebtn';}else{ echo 'addbtn';};?>" id="<?php if(isset($_GET['edit'])){echo 'updatebtn';}else{ echo 'addbtn';};?>" value= "<?php if(isset($_GET['edit'])){echo 'Update Database';}else{echo 'Add Student';};?>">
      </form>
      </div>
        </div><!--closing container div-->
        <?php
    }else{
    ?>
    <div class="container-fluid">

    <!--BUTTON FOT ADDIGNG NEW STUDENT TO THE SCHOOL SYSTEM-->
    <a href="students.php?add=1" class="btn btn-primary addStudentBtn" title="Click to add new student"><i class="fas fa-user-plus"></i></a>
    <!----CODE FOR BUTTON ENDS HERE-->

    <!--BUTTON FOT PRINTING STUDENT-->
    <a href="students.php?add=1" class="btn btn-primary printStudentBtn" title="Click to print students."><i class="fas fa-print"></i></a>
    <!----CODE FOR BUTTON ENDS HERE-->

     <!--
    *******************************************************************************************
   UPPER NAVIGATION 
    ******************************************************************************************
    -->
    <div id="menuDiv">
        <ul>
            <li class="main_list"><a href="students.php"><i class="fas fa-redo-alt"></i> Reload</a></li>
            <li class="main_list"><a href="#" id="filter"><i class="fas fa-filter"></i> Filter</a></li>
            <li class="main_list"><a href="#" id="search"><i class="fas fa-search"></i> Search</a></li>
            <li class="main_list"><a href="/school/performance.php" title="Check out invidual or all performance."><i class="fas fa-book-open"></i> Performance</a></li>
            <li class="main_list"><a href="#"><i class="fas fa-school"></i> Students Actions <i class="fas fa-angle-down"></i> </a>
                <ul>
                <li class="dir"><a href="/school/admin/upgradestudents.php" title="Move students to the next level">  Move Students</a></li>
                <li class="dir"><a href="#">Former Students <i class="fas fa-angle-right float-right"></i> </a>
                    <ul>
                    <li><a href="/school/admin/formerstudents.php" title="Student that studied in the school.">  Former Students (8-4-4)</a></li>
                    <li><a href="/school/admin/former-students-CBC.php" title="Click to view all students whi studied in the school">Former Students (CBC)</a></li>
                    </ul>
                </li>
                <li><a href="/school/admin/finance.php" title="View students finance.">  Finance</a></li>
                </ul>
            </li>
            <?php if($logged_in_user_data['permissions']=='Super_Admin'){?>
            <li class="main_list"><a href="/school/admin/bulkupload.php"><i class="fas fa-file-upload"></i> Bulk upload.</a></li>
            <?php }?>
        </ul>
    </div>

  <!--*******************************************************************************************
   UPPER NAVIGATION  ends here
    ****************************************************************************************** -->




    <!--*******************************************************************************************
    SEARCH STUDENT DIV  and filter div
    ******************************************************************************************* -->
        <div id="filterDiv">
            <div class="form-group float-right">
                <button type="button" class="close" id="closeFilterDivBtn" aria-label="Close">
                <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="form-group" id="gradeFilterSubDiv">
                <label for="filterSearch">Filter by level.</label>
               <select name="gradeFilter" id="gradeFilter" class="form-control">
                    <option value="">All students</option>
                    <?php $gradeQuery = $db->query("SELECT * FROM grade");
                          while($gradeData = mysqli_fetch_array($gradeQuery)):?>
                    <option value="<?=$gradeData['grade'];?>"><?=$gradeData['grade'];?></option>
                    <?php endwhile;?>
               </select>
            </div>
            <div class="form-group" id="genderFlterSubdiv">
                    <label for="genderFlter">Filter by gender</label>
                    <div class="radio">
                        <label for="gender" class="radio-inline"><input type="radio" id="genderFilter"  name="gender" value="MALE"> Male</label>
                        <label for="gender" class="radio-inline"><input type="radio" id="genderFilter"  name="gender" value="FEMALE"> Female</label>
                        <label for="gender" class="radio-inline"><input type="radio" id="genderFilter"  name="gender" value="" <?php echo 'checked';?>> Male & Female</label>
                    </div>
            </div>            
        </div> 
  
       <div id="searchDiv" class="text-center">
               <input type="search" class="form-control" name="search_student" id="search_student" placeholder="Search student name">
       </div>  

    <!--*****************************************************************************************
        THE SEARCH STUDENT DIV and filter div ENDS HERE
    ***************************************************************************************** -->     
    
    <?php

    //THIS IS THE CODE FOR DELETING A DOCUMENT FROM SERVER USING MODAL
    if(isset($_GET['delDocument'])){
        $docId=(int)$_GET['delDocument'];
        $docQuery=$db->query("SELECT * FROM student_documents WHERE id='$docId'");
        $docQueryData=mysqli_fetch_array($docQuery);
        $docPathName=$docQueryData['document'];     
        $newDocDir=$_SERVER['DOCUMENT_ROOT'].$docPathName;//this is the root directory for the file we want to delete
        
        if(unlink($newDocDir)){//unlink() is a function for deleting file from server

            $db->query("DELETE FROM student_documents WHERE id='$docId'");
            $messages[].='<b>Success! </b>Document deleted from server.';
            if(!empty($messages)){
                displayMessages($messages);
            }

        }else{
            $errors[].='<b>Error! </b>Failed to delete document from server.';
            if(!empty($errors)){
                displayErrors($errors);
            }
        }      

    }
/*---------------DELETE FILE FROM SERVER USING  MODAL ENDS HERE-------------------*/

    if(isset($_POST['deleteStudentBtn'])){//THIS IS CODE FOR DELETING A STUDENT
        $deleteStudentId = (int)$_GET['deleteStudent'];
        $financeQuery    = mysqli_fetch_array($db->query("SELECT * FROM `fees_account` WHERE `student_id`='{$deleteStudentId}'"));
        $accountBalance  = $financeQuery['amount'];
        if($accountBalance < 0):
            $info[].='<b>Oops! </b>This student can not be deleted since they owe the school money.';
            displayinfo($info);
        else:
            $db->query("UPDATE `students` SET `deleted`=1,`delete_date`='{$todayDate}' WHERE `id`='{$deleteStudentId}'");
            $messages[].='<b>Success! </b>Student deleted successfully.';
                if(!empty($messages)){
                    displayMessages($messages);
                }
        endif;        
    }
///DELETING STUDENT FROM MODAL ENDS HERE

    
    //IF THE UPLOAD DOCUMENT BUTTON IS CLICKED FROM MODAL-->
    if(isset($_POST['upload_document'])){//if the upload document button from modal is clicked
        $filename=clean(((isset($_FILES['document']['name'])? $_FILES['document']['name']:'')));
        $documentName=strtoupper(trim(clean(((isset($_POST['docname'])?$_POST['docname']:'')))));
        $id=(int)$_GET['studentId'];
        
        if($filename=='' || $documentName==''){
            $errors[].='<b>Error! </b>Please provide both document and document name to upload.';
        }   

        if($filename !=''){
            $target_dir='/documents/students/';
            $fileDestination=BASEURL.$target_dir.$_FILES['document']['name'];
            $fileTempName =$_FILES["document"]["tmp_name"];
            $fileError=$_FILES['document']['error'];            
            $studentdocumenturl='/school/documents/students/'.$_FILES['document']['name'];
            $docFileNameExtension=strtolower(pathinfo($filename,PATHINFO_EXTENSION));        
            $extensions=array('pdf','doc','docx');
            if(!in_array($docFileNameExtension,$extensions,TRUE)){//checks if the file extension is allowed
            $errors[].='<b>Error! </b>Only PDF, DOC and DOCX file formats are allowed!';
            }            
        }
        
        if(!empty($errors)){
            displayErrors($errors);
        }else{
            if(!empty($filename)){//move the uploaded file only if its not empty
                    move_uploaded_file($fileTempName,$fileDestination);
                }
            $db->query("INSERT INTO student_documents (student_id,document,document_name) VALUES ('$id','$studentdocumenturl','$documentName')");
            $messages[].='<b>Success! </b>Document uploaded.';
                if(!empty($messages)){
                    displayMessages($messages);
                }
        }

    }
////CODE FOR UPLOADING DOCUMENT FROM MODAL ENDS HERE/////////////////

/////////////PAGINAIOTN CODE STARTS HERE//////////////////

$maxLimit      = 50;//number of rows to be displayed on each page
$totalStudents = mysqli_num_rows($db->query("SELECT * FROM students WHERE deleted=0 AND accomplished=0"));
$page          = (int)((isset($_GET['page'])? $_GET['page']: 1));//gets the age number from the url
$minLimit      = ($page - 1) * $maxLimit;
$totalPages    = ceil($totalStudents/$maxLimit);
 ?>
    <nav aria-label="Page navigation example" class="float-left">
        <ul class="pagination pagination-sm">
            <li class="page-item"><a class="page-link" href="#">Previous</a></li>
            <?php for($p = 1; $p <= $totalPages; $p++) :?>
             <li class="page-item"><a class="page-link" href="students.php?page=<?=$p;?>"><?=$p;?></a></li>
            <?php endfor;?>
            <li class="page-item"><a class="page-link" href="#">Next</a></li>
        </ul>
    </nav>
<!---------------PAGINATION CODE ENDS HERE------------------->
   

        <div id="tableContainerDiv">

        <table class="table table-hover table-sm table-bordered table-striped table-hoverable">
            <thead class="thead-light">
                <tr>
                <th scope="col">#</th>
                <th scope="col">REG. NUMBER</th>
                <th scope="col">STUDENT NAME</th>
                <th scope="col">GRADE</th>
                <th scope="col">VIEW</th>
                <th scope="col">EDIT</th>
                <th scope="col">DELETE</th>
                <th scope="col">DOCS.</th>  
                </tr>              
            </thead>
            <tbody id="tableBody"><!--The fist option of the if condition is for data that has been searched -->
            <?php
            $count = 1;
            $students = $db->query("SELECT * FROM `students` WHERE `deleted`=0 AND `accomplished`=0 ORDER BY `stdname` ASC LIMIT $minLimit,$maxLimit");
            while( $student_data=mysqli_fetch_array($students)) :?>
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
            <?php
            $count++;
            endwhile; ?>
            </tbody>
        </table>
        </div><!--closing tableContainerDiv-->

</div><!--Closing wrapper div-->
</div><!--closing row div-->
    </div><!--closing container-fluid div-->

    <?php }?><!--closing php tags for both edit and add-->    

<script> 
    jQuery('.printStudentBtn').click(function(e){//when the print  student button has been clicked
        e.preventDefault();
        window.print();
    });
    jQuery('#menuDiv #filter').click(function(e){//when the filter option is seletced thi unveils the filter popup
        e.preventDefault();
        jQuery('#searchDiv').fadeOut('fast');
        jQuery('#filterDiv').toggle('slow');
    });
    jQuery('#menuDiv #search').click(function(e){//when serach is selected this unveils the search box
        e.preventDefault();
        jQuery('#filterDiv').fadeOut('fast');
        jQuery('#searchDiv').toggle('slow');
    }); 
    jQuery('#closeFilterDivBtn').click(function(){//button for closing the filter div
        jQuery('#filterDiv').hide('slow');
    });
    jQuery("#gradeFilter").change(function(){//when the filter by level has been clicked
        var filterGrade  = jQuery('#filterDiv').find("option:selected").val();
        var filterGender = jQuery('#filterDiv').find('#genderFilter:checked').val();           
        jQuery.ajax({
            url:'/school/admin/students/fetch.php',
            method:'post',
            data:{filterGrade:filterGrade,filterGender:filterGender},
            success:function(data){
                jQuery('#tableBody').html();
                jQuery('#tableBody').html(data);
            },
            error:function(){
                alert("Something went wrong trying ro filter students by level");
            }
        });
    });
    jQuery('#filterDiv #genderFilter').click(function(){//thi sis the gender radio button cliked
        var filterGender = jQuery(this).val();//this is th gendee selected 
        var filterGrade  = jQuery("#gradeFilter option:selected").val();//thhis is the grade selected            
        jQuery.ajax({
            url:'/school/admin/students/fetch.php',
            method:'post',
            data:{filterGender:filterGender,filterGrade:filterGrade},
            success:function(data){
                jQuery('#tableBody').html();
                jQuery('#tableBody').html(data);
            },
            error:function(){
                alert("Something went wring trying ro filter students by level");
            }
        });
    });
    jQuery('.delete_student').click(function(){
        var deleteStudentId=jQuery(this).attr("id");        
        jQuery.ajax({
            url:'/school/modals/deletestudentmodal.php',
            method:'post',
            data:{deleteStudentId:deleteStudentId},
            success:function(data){
                jQuery("body").append(data);
                jQuery('#deletestudentmodal').modal({
                    backdrop:'static', keyboard:false
                });
            },
        });
    });
    function closeDeleteStudentDocModal(){//function for closing deletestudentmodal
       jQuery('#documents_modal').modal("hide");
        window.location='/school/admin/students.php';
    };
    function closeDeleteStudentModal(){
        jQuery('#deletestudentmodal').modal("hide");
        location.reload(true);
    }
    jQuery("#search_student").keyup(function(){//when a key is pressed inside the search box
        var search_student_name = btoa(jQuery(this).val());//base 64 encoding 
            jQuery.ajax({
                url:'/school/admin/students/fetch.php',
                method:'POST',
                data:{search_student_name:search_student_name},
                success:function(data){//code for the UTOCOMPLETE     
                    jQuery("#tableBody").html(data);
                },
                error:function(){
                    alert("Something went wrong trying to search student");
                }
            }); 
    });//end of keyup function
    jQuery('.view_student').click(function(event){//this is the view button clicked for the student
        event.preventDefault();
        var student_id=jQuery(this).attr("id");
            jQuery.ajax({
                url:'/school/modals/viewstudentmodal.php',
                method:'post',
                data:{student_id:student_id},
                success:function(data){
                    jQuery('body').append(data);//includes the modal in this page
                    jQuery('#viewModal').modal({
                        backdrop:'static', keyboard:false
                    });//toggles the modal
                },
                error:function(){
                    alert("Something went wrong viewing student info");
                },
            });
    });  
    jQuery('.documents').click(function(){//when the documents btn is clicked
        var student_id=jQuery(this).attr("id");    
            jQuery.ajax({
                url:"/school/modals/studentdocuments.php",
                method:"POST",
                data:{student_id:student_id},
                success:function(data){
                    jQuery('body').append(data);
                    jQuery('#documents_modal').modal({
                        backdrop:'static',keyboard:false
                    });//displays the documents modal
                },
                error:function(){
                    alert("Something went wrong");
                },
            });
    });
</script>
<?php include '../admin/footer.php';?>
</body>