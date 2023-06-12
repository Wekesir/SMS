<!DOCTYPE html>
<html>
<head>
  <?php
  require_once $_SERVER['DOCUMENT_ROOT'].'/school/core/init.php';
  include '../admin/header.php';?>
</head>
<body>
  <?php include '../admin/navigation.php';?>
   <div class="container-fluid">
  <div class="row">
    <div class="col-md-3">
        <?php include '../admin/left.php';?>
    </div><!--Closing col-md-3-->
  <div class="col-md-9" id="wrapper">   
    <?php 
    if(isset($_GET['add']) || isset($_GET['edit'])){//this code just ensures that the columns are seen
      $name=trim(clean(((isset($_POST['name']) && $_POST['name'] !=''? $_POST['name']:''))));
      $idnumber=trim(clean(((isset($_POST['id']) && $_POST['id'] !='' ? $_POST['id']:''))));
      $email=trim(clean(((isset($_POST['email']) && $_POST['email'] !='' ? $_POST['email']:''))));
      $dob=trim(clean(((isset($_POST['birth']) && $_POST['birth'] !='' ? $_POST['birth']:''))));
      $residence=strtoupper(trim(clean(((isset($_POST['residence']) && $_POST['residence'] !='' ? $_POST['residence']:'')))));
      $gender=trim(clean(((isset($_POST['gender']) && $_POST['gender'] !='' ? $_POST['gender']:''))));
      $phonenumber=trim(clean(((isset($_POST['phone']) && $_POST['phone'] !='' ? $_POST['phone']:''))));
      $tsc=trim(clean(((isset($_POST['tsc']) && $_POST['tsc'] !='' ? $_POST['tsc']:''))));
      $nhif=trim(clean(((isset($_POST['nhif']) && $_POST['nhif'] !='' ? $_POST['nhif']:''))));
      $nssf=trim(clean(((isset($_POST['nssf']) && $_POST['nssf'] !='' ? $_POST['nssf']:''))));
      $account=trim(clean(((isset($_POST['account']) && $_POST['account'] !='' ? $_POST['account']:''))));
      $accesslevel=trim(clean(((isset($_POST['access']) && $_POST['access'] !='' ? $_POST['access']:''))));
      $classassigned=trim(clean(((isset($_POST['assigncl']) && $_POST['assigncl'] !='' ? $_POST['assigncl']:''))));
      $employmenttype=trim(clean(((isset($_POST['emptype']) && $_POST['emptype'] !='' ? $_POST['emptype']:''))));
      $stafftype=trim(clean(((isset($_POST['staff_type']) && $_POST['staff_type'] !='' ? $_POST['staff_type']:''))));
      $backgroundinfo=trim(clean(((isset($_POST['background']) && $_POST['background'] !='' ? $_POST['background']:''))));
      $staffimage=trim(clean(((isset($_POST['image']) && $_POST['image'] !='' ? $_POST['image']:''))));
      $filename=trim(clean(isset($_FILES['staffimage']['name'])?$_FILES['staffimage']['name']:''));       

      if(isset($_GET['edit'])){  
          $edit_id= (int)$_GET['edit'];
          $staffquery=$db->query("SELECT * FROM users WHERE id='$edit_id'");
          $userdata=mysqli_fetch_array($staffquery);
          $filename=trim(clean(((isset($_FILES['staffimage']['name'])?$_FILES['staffimage']['name']:''))));   

          if($filename != ''){
            $target_dir='/uploads/staff/';
            $fileDestination=BASEURL.$target_dir.$_FILES['staffimage']['name'];
            $fileTempName =$_FILES["staffimage"]["tmp_name"];
            $fileError=$_FILES['staffimage']['error'];
            $fileSize=$_FILES['staffimage']['size'];
            $staffimageurl='/school/uploads/staff/'.$_FILES['staffimage']['name'];
            $imageFileNameExtension=strtolower(pathinfo($filename,PATHINFO_EXTENSION));
            $check=getimagesize($_FILES['staffimage']['tmp_name']);
            if($fileSize>800000){//checks the file size
              $errors[].='<b>Error! </b>The file is too large. Please select another and try again.';
            }
            $extensions=array('jpg','jpeg','png','gif');
            if(!in_array($imageFileNameExtension,$extensions,TRUE)){//checks if the file extension is allowed
              $errors[].='<b>Error! </b>Only PNG, JPEG, JPG and PNG are allowed.';
            }
            if($check===false){//check if the file is an image
              $errors[].='<b>Error! </b>The file you chose is not not an image.';
            }
          }
          
          $name=strtoupper(trim(clean(((isset($_POST['name']) && $_POST['name'] !=''? $_POST['name']:$userdata['name'])))));
          $idnumber=trim(clean(((isset($_POST['id']) && $_POST['id'] !='' ? $_POST['id']:$userdata['national_id']))));
          $email=trim(clean(((isset($_POST['email']) && $_POST['email'] !='' ? $_POST['email']:$userdata['email']))));
          $dob=trim(clean(((isset($_POST['birth']) && $_POST['birth'] !='' ? $_POST['birth']:$userdata['birth_date']))));
          $residence=strtoupper(trim(clean(((isset($_POST['residence']) && $_POST['residence'] !='' ? $_POST['residence']:$userdata['residence'])))));
          $gender=trim(clean(((isset($_POST['gender']) && $_POST['gender'] !='' ? $_POST['gender']:$userdata['gender']))));
          $phonenumber=trim(clean(((isset($_POST['phone']) && $_POST['phone'] !='' ? $_POST['phone']:$userdata['phone']))));
          $tsc=trim(clean(((isset($_POST['tsc']) && $_POST['tsc'] !='' ? $_POST['tsc']:$userdata['tsc_number']))));
          $nhif=trim(clean(((isset($_POST['nhif']) && $_POST['nhif'] !='' ? $_POST['nhif']:$userdata['nhif']))));
          $nssf=trim(clean(((isset($_POST['nssf']) && $_POST['nssf'] !='' ? $_POST['nssf']:$userdata['nssf']))));
          $account=trim(clean(((isset($_POST['account']) && $_POST['account'] !='' ? $_POST['account']:$userdata['nssf']))));
          $accesslevel=trim(clean(((isset($_POST['access']) && $_POST['access'] !='' ? $_POST['access']:$userdata['permissions']))));
          $classassigned=trim(clean(((isset($_POST['assigncl']) ? $_POST['assigncl']:$userdata['class_assigned']))));//this has a difference since it allows a null input
          $employmenttype=trim(clean(((isset($_POST['emptype']) && $_POST['emptype'] !='' ? $_POST['emptype']:$userdata['employment_type']))));
          $stafftype=trim(clean(((isset($_POST['staff_type']) && $_POST['staff_type'] !='' ? $_POST['staff_type']:$userdata['staff_type']))));
          $backgroundinfo=trim(clean(((isset($_POST['background']) && $_POST['background'] !='' ? $_POST['background']:$userdata['background_info']))));
          $staffimage=trim(clean(((isset($filename) && $filename !='' ? $staffimageurl:$userdata['image'])))); 
      }

    if(isset($_POST['update'])){     
      if($filename !=''){
          move_uploaded_file($fileTempName,$fileDestination);
      }
      $db->query("UPDATE `users` SET
                  `name`='{$name}',
                  `email`='{$email}', 
                  `permissions`='{$accesslevel}', 
                  `class_assigned`='{$classassigned}',
                  `birth_date`='{$dob}',
                  `gender`='{$gender}',
                  `phone`='{$phonenumber}',
                  `tsc_number`='{$tsc}',
                  `background_info`='{$backgroundinfo}',
                  `image`='{$staffimage}',
                  `employment_type`='{$employmenttype}',
                  `staff_type`='{$stafftype}',
                  `national_id`='{$idnumber}',
                  `residence`='{$residence}',
                  `nhif`='{$nhif}',
                  `nssf`='{$nssf}',
                  `account`='{$account}'
                  WHERE `id`='{$edit_id}'");
      $messages[].='<b>Success!</b> Updated successfully.';
        if(!empty($messages)){
          displayMessages($messages);
        }   
    }

  if(isset($_POST['save'])){//if the save button is clicked the following code shoild execute
      $name = strtoupper(trim(clean(((isset($_POST['name'])?strtoupper($_POST['name']):'')))));
      $username_array = explode(' ', strtolower($name));//explode the username 
      $username = ($username_array[1].'.'.$username_array[0]);//the username becomes the secode name dot the first name
      $idnumber=trim(clean(((isset($_POST['id'])?$_POST['id']:''))));
      $email=trim(clean(((isset($_POST['email'])?$_POST['email']:''))));
      $dob=trim(clean(((isset($_POST['birth'])?$_POST['birth']:''))));
      $residence=strtoupper(trim(clean(((isset($_POST['residence'])?$_POST['residence']:'')))));
      $gender=trim(clean(((isset($_POST['gender'])?$_POST['gender']:''))));
      $phonenumber=trim(clean(((isset($_POST['phone'])?$_POST['phone']:''))));
      $tscNumber=trim(clean(((isset($_POST['tsc'])?$_POST['tsc']:''))));
      $nhif=trim(clean(((isset($_POST['nhif'])?$_POST['nhif']:''))));
      $nssf=trim(clean(((isset($_POST['nssf'])?$_POST['nssf']:''))));
      $account=trim(clean(((isset($_POST['account'])?$_POST['account']:''))));
      $accesslevel=trim(clean(((isset($_POST['access'])?$_POST['access']:''))));
      $classassigned=trim(clean(((isset($_POST['assigncl'])?$_POST['assigncl']:''))));
      $employmenttype=trim(clean(((isset($_POST['emptype'])?$_POST['emptype']:''))));
      $stafftype=trim(clean(((isset($_POST['staff_type'])?$_POST['staff_type']:''))));
      $backgroundinfo=trim(clean(((isset($_POST['background'])?$_POST['background']:''))));
      $pass=$configurationData['school_name'].date('Y');
      $passwordhashed=password_hash($pass,PASSWORD_DEFAULT);
      $staffimageurl='';
      $filename=trim(clean($_FILES['staffimage']['name']));
      if($filename != ''){
          $target_dir='/uploads/staff/';
          $fileDestination=BASEURL.$target_dir.$_FILES['staffimage']['name'];
          $fileTempName =$_FILES["staffimage"]["tmp_name"];
          $fileError=$_FILES['staffimage']['error'];
          $fileSize=$_FILES['staffimage']['size'];
          $staffimageurl='/school/uploads/staff/'.$_FILES['staffimage']['name'];
          $imageFileNameExtension=strtolower(pathinfo($filename,PATHINFO_EXTENSION));
          $check=getimagesize($_FILES['staffimage']['tmp_name']);       
          if($fileSize>800000){//checks the file size
            $errors[].='<b>Error! </b>The file is too large. Please select another and try again.';
          }
          $extensions=array('jpg','jpeg','png','gif');
          if(!in_array($imageFileNameExtension,$extensions,TRUE)){//checks if the file extension is allowed
            $errors[].='<b>Error! </b>Only PNG, JPEG, JPG and PNG are allowed.';
          }
          if($check===false){//check if the file is an image
            $errors[].='<b>Error! </b>The file you chose is not not an image.';
          }
      }
      
      //check if the employee already existas in database
      $namecheck=$db->query("SELECT * FROM `users` WHERE `name`='$name' AND `deleted`=0");
      if(mysqli_num_rows($namecheck) > 0){
        $errors[].='<b>Error! </b>A user by this name already exists.';
      }
      //check if necessary inof has been provided
      $requiredinfo=array($name,$idnumber,$dob,$gender,$phonenumber,$accesslevel,$employmenttype);
      foreach($requiredinfo as $info){
          if(empty($info)){
            $errors[].='<b>Error! </b>Please provide all information in areas with a *';
              break;
          }
      }
      if(!empty($errors)){
          displayErrors($errors);
      }else{
          //code or inserting data into database
          if($filename!=''){
            move_uploaded_file($fileTempName,$fileDestination);
          }    
          $date=date('Y-m-d H:i:s');
          $db->query("INSERT INTO `users` (`name`,`username`,`email`,`password`,`permissions`,`employed_on`,`class_assigned`,`birth_date`,`gender`,`phone`,`tsc_number`,`background_info`,`image`,`employment_type`,`staff_type`,`national_id`,`residence`,`nhif`,`nssf`,`account`)
          VALUES ('{$name}','{$username}','{$email}','{$passwordhashed}','{$accesslevel}','{$date}','{$classassigned}','{$dob}','{$gender}','{$phonenumber}','{$tscNumber}','{$backgroundinfo}','{$staffimageurl}','{$employmenttype}','{$stafftype}','{$idnumber}','{$residence}','{$nhif}','{$nssf}','{$account}')");

          $insertId = $db->insert_id;//the id of the last inserted column
          $db->query("INSERT INTO `staff_accounts` (`staff_id`,`activation_date`) VALUES('{$insertId}','{$date}')");      
          $messages[].='<b>Success! </b>New staff has been added successfully.';
          if(!empty($messages)){
            displayMessages($messages);
          }
      } 
  }
    ?>    
    <div class="text-center bg-light p-3">
        <label class="float-left"> <a href="/school/admin/staff.php"> <i class="fas fa-long-arrow-left"></i> Back. </a> </label>
        <h5> <?php if(isset($_GET['edit']) && $_GET['edit'] !=''){echo 'EDIT USER DATA';}else{echo 'ADD NEW USER';};?></h5>
    </div>
    <hr>
    <form action="<?php if(isset($_GET['edit']) && $_GET['edit'] !=''){echo 'staff.php?edit='.$_GET['edit'].'';}else{echo 'staff.php?add=1';};?>" method="POST" enctype="multipart/form-data">
        <div class="row">
          <div class="form-group col-md-6">
              <label for="name">Full Name:</label>
              <input type="text" name="name" class="form-control" id="name" value="<?=$name?>" required=required>
          </div>
          <div class="form-group col-md-6">
              <label for="id">ID Number*:</label>
              <input type="number" name="id" class="form-control" id="id" min="00000000" value="<?=$idnumber?>">
          </div>
          <div class="form-group col-md-6">
              <label for="email">Email address:</label>
              <input type="email" name="email" class="form-control" id="email" value="<?=$email?>">
          </div>
          <div class="form-group col-md-6">
              <label for="birth">DOB*:</label>
              <input type="date" name="birth" class="form-control" id="birth" value="<?=$dob?>" required=required>
          </div>
          <div class="form-group col-md-6">
            <Label for="gender">Gender*:</Label>
                <label for="gender" class="radio-inline">Male: <input type="radio" name="gender" id="male" value="MALE" <?php if($gender=='MALE'){echo 'checked';}?>></label>
                <label for="gender" class="radio-inline">Female: <input type="radio" name="gender" id="female" value="FEMALE" <?php if($gender=='FEMALE'){ echo 'checked';}?>></label>
          </div>
          <div class="form-group col-md-6">
            <label for="phone">TSC Number:</label>
            <input type="text" name="tsc" class="form-control" id="tsc" value="<?=$tsc?>">
          </div>
            <div class="form-group col-md-6">
              <label for="phone">Phone Number:</label>
              <input type="tel" name="phone" maxlength=10 minlength=10 placeholder="e.g 0710XXXXXX" class="form-control" id="phone" value="<?=$phonenumber?>" required=required>
          </div>
          <div class="form-group col-md-6">
              <label for="phone">NHIF Number:</label>
              <input type="text" name="nhif" class="form-control" id="nhif" value="<?=$nhif?>">
          </div>
          <div class="form-group col-md-6">
              <label for="phone">NSSF Number:</label>
              <input type="text" name="nssf" class="form-control" id="nssf" value="<?=$nssf?>">
          </div>
          <div class="form-group col-md-6">
              <label for="phone">Residence*:</label>
              <input type="text" name="residence" class="form-control" id="residence" value="<?=$residence;?>" required=required>
          </div>
          <div class="form-group col-md-6">
            <label for="access">System access level*:</label>
              <select name="access" id="access" class="form-control" required=required>
              <option value="" name="access"></option>
              <option value="General user" name="access" id="access" <?php if($accesslevel=='General user'){echo 'selected';};?>>General user</option>
              <option value="Boarding" name="access" id="access" <?php if($accesslevel=='Boarding'){echo 'selected';};?> >Boarding Master</option>
              <option value="Secretary" name="access" id="access" <?php if($accesslevel=='Secretary'){echo 'selected';};?> >Secretary</option>
              <option value="Admin" name="access" id="access" <?php if($accesslevel=='Admin'){echo 'selected';};?> >Admin</option>
              <option value="Store Keeper" name="access" id="access" <?php if($accesslevel=='Store Keeper'){echo 'selected';};?> >Store Keeper</option>
              <option value="Driver" name="access" id="access" <?php if($accesslevel=='Driver'){echo 'selected';};?> >Driver</option>
              <option value="Cook" name="access" id="access" <?php if($accesslevel=='Cook'){echo 'selected';};?> >Cook</option>
              <option value="Janitor" name="access" id="access" <?php if($accesslevel=='Janitor'){echo 'selected';};?> >Janitor</option>
            </select>
          </div>
          <div class="form-group col-md-6">
            <label for="assigncl">Assign Grade:</label>
              <select name="assigncl" id="assigncl" class="form-control">                
              <option value="" name="assigncl" id="assigncl"></option>
              <?php $gradeQuery=$db->query("SELECT * FROM grade");
                    while($gradeQueryData=mysqli_fetch_array($gradeQuery)):?>
              <option value="<?=$gradeQueryData['grade'];?>" name="assigncl" id="assigncl" <?php if($classassigned==$gradeQueryData['grade']){echo 'selected';}?>> <?=$gradeQueryData['grade'];?></option>
                <?php endwhile;?> 
            </select>
        </div>
          <div class="form-group col-md-6">
            <label for="emptype">Employment type*:</label>
            <select name="emptype" id="emptype" class="form-control"placeholder="" required=required>
              <option name="emptype" value="" ></option>
              <option value="Temporary" name="emptype" id="emptype" <?php if($employmenttype=='Temporary'){echo 'selected';};?>>Temporary</option>
              <option value="Permanent" name="emptype" id="emptype" <?php if($employmenttype=='Permanent'){echo 'selected';};?>>Permanent</option>
            </select>
          </div>
          <div class="form-group col-md-6">
              <label for="account">Account Number:</label>
              <input type="text" name="account" class="form-control" id="account" value="<?=$account;?>">
          </div>
          <div class="form-group col-md-6">
              <label for="account">Staff Type:</label>
              <select name="staff_type" id="type" class="form-control" required=required>
              <option value=""></option>
              <option value="TEACHING" name="staff_type" <?=(($stafftype=="TEACHING")?'selected':"")?>>TEACHING STAFF</option>
              <option value="NON-TEACHING" name="staff_type" <?=(($stafftype=="NON-TEACHING")?'selected':"")?>>NON-TEACHING STAFF</option>
              </select>
          </div>
          <div class="form-group col-md-6">
            <label for="staffimage"><?php if(isset($_GET['edit']) && $_GET['edit']){echo 'Staff Image:';}else{echo 'Choose Image:';};?></label>
              <?php
                if(isset($_GET['edit']) && $_GET['edit'] != ''){
                  echo '<div class="form-group"><img src="'.$staffimage.'" style="height: 200px;width: 170px;" alt="'.$name.'"></div>
                  ';
                }
              ?>
              <input type="file" name="staffimage" id="staffimage" class="form-control">                  
          </div>
          <div class="form-group col-md-6">
              <label for="background">Background Information:</label>
              <textarea name="background" id="background" class="form-control" cols="50" value="<?=$backgroundinfo?>"><?=$backgroundinfo?></textarea>
          </div>
        </div><!--closing row div-->
        <input type="submit" class="btn btn-success" name="<?php if(isset($_GET['edit']) && $_GET['edit']!=''){echo 'update';}else{echo 'save';};?>" id="<?php if(isset($_GET['edit']) && $_GET['edit']!=''){echo 'update';}else{echo 'save';};?>" class="btn-md" value="<?php if(isset($_GET['edit']) && $_GET['edit']!=''){echo 'Update Database';}else{echo 'Add user';};?>">
    </form>
</div>
  <?php
  }else{
  if(isset($_GET['edit'])){
    require '../admin/edituser.php';
  }else{
  $query=$db->query("SELECT * FROM `users` WHERE `deleted`=0 AND `id` !=1 ORDER BY `id` DESC");  
  ?>
  <a href="staff.php?add=1" class="btn btn-primary addStaffBtn" title="Click to add new staff"><i class="fas fa-user-plus"></i></a>
  <div id="menuDiv">
    <ul>
        <li class="main_list"><a href="<?php $_SERVER['PHP_SELF']?>"><i class="fas fa-redo-alt"></i> Reload</a></li>
        <li class="main_list"><a href="#" id="filter"><i class="fas fa-filter"></i> Filter</a></li>
        <li class="main_list"><a href="#" id="search"><i class="fas fa-search"></i> Search</a></li>
        <?php if($logged_in_user_data['permissions']=='Super_Admin'){?>
        <li class="main_list"><a href="/school/admin/bulkupload.php"><i class="fas fa-file-upload"></i> Bulk upload.</a></li>
        <?php }?>
    </ul>
  </div>
  <div id="filterDiv">
    <div class="form-group float-right">
        <button type="button" class="close" id="closeFilterDivBtn" aria-label="Close">
        <span aria-hidden="true">&times;</span>
        </button>
    </div>
    <div class="form-group" id="gradeFilterSubDiv">
        <label for="access">System access level*:</label>
          <select name="access" id="access" class="form-control">
        <option value="" name="access"></option>
        <option value="General user" name="access" id="access" >General user</option>
          <option value="Boardiing" name="access" id="access" >Boarding Master</option>
          <option value="Secretary" name="access" id="access" >Secretary</option>
        <option value="Admin" name="access" id="access" >Admin</option>
        </select>              
    </div>
    <div class="form-group" id="genderFlterSubdiv">
        <label for="genderFlter">Filter by gender</label>
        <div class="radio">
            <label for="gender" class="radio-inline"><input type="radio" id="genderFilter"  name="gender" value="MALE"> Male |</label>
            <label for="gender" class="radio-inline"><input type="radio" id="genderFilter"  name="gender" value="FEMALE"> Female |</label>
            <label for="gender" class="radio-inline"><input type="radio" id="genderFilter"  name="gender" value="" <?php echo 'checked';?>> Male & Female</label>
        </div>
    </div>            
  </div> 
  <!--*********************************************************************************************************
  ADD BUTTON ENDS HERE
  *********************************************************************************************************-->
<div id="searchDiv" class="">
  <input type="search" name="search_staff" id="search_staff" placeholder="Search staff name">
  <div id="staff_search_data"></div>
</div>
 <!--CODE FOR UPLOADNING STAFF DOCUMENT USING MODAL-->
 <?php
 if(isset($_POST['upload_document'])){//if the upload document button from modal is clicked
        $filename=clean(((isset($_FILES['document']['name'])? $_FILES['document']['name']:'')));
        $documentName=strtoupper(trim(clean(((isset($_POST['docname'])?$_POST['docname']:'')))));
        $id=(int)$_GET['staffId'];        
        if($filename=='' || $documentName==''){
            $errors[].='<b>Error! </b>Please provide both document and document name to upload.';
        }   
        if($filename !=''){
            $target_dir='/documents/staff/';
            $fileDestination=BASEURL.$target_dir.$_FILES['document']['name'];
            $fileTempName =$_FILES["document"]["tmp_name"];
            $fileError=$_FILES['document']['error'];            
            $staffdocumenturl='/school/documents/staff/'.$_FILES['document']['name'];
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
                move_uploaded_file($fileTempName, $fileDestination);
              }
            $db->query("INSERT INTO staff_documents (staff_id,document,document_name) VALUES ('$id','$staffdocumenturl','$documentName')");
            $messages[].='<b>Success! </b>Document uploaded.';
              if(!empty($messages)){
                  displayMessages($messages);
              }
        }
    }
    ////CODE FOR UPLOADING DOCUMENT FROM MODAL ENDS HERE

     //THIS IS THE CODE FOR DELETING A DOCUMENT FROM SERVER USING MODAL
    if(isset($_GET['delDocument'])){
        $docId        = (int)$_GET['delDocument'];
        $docQuery     = $db->query("SELECT * FROM staff_documents WHERE id='$docId'");
        $docQueryData = mysqli_fetch_array($docQuery);
        $docPathName  = $docQueryData['document'];     
        $newDocDir    = $_SERVER['DOCUMENT_ROOT'].$docPathName;//this is the root directory for the file we want to delete
        
        if(unlink($newDocDir)){//unlink() is a function for deleting file from server
            $db->query("DELETE FROM `staff_documents` WHERE `id`='$docId'");
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
//DELETE FILE FROM SERVER USING  MODAL ENDS HERE  


  //////CODE FOR DELETING USER////
  if(isset($_POST['deleteStaffBtn'])){
    $deleteStaffId=(int)clean($_GET['deleteStaff']);
    $db->query("UPDATE `users` SET `deleted`=1 WHERE `id`='$deleteStaffId'");
    $messages[].='<b>Success! </b>User deleted from system.';
    if(!empty($messages)){
      displayMessages($messages);
    }
  }
  ?>


  <table class="table table-sm table-bordered table-striped table-hover">
      <thead class="thead-light">     
          <th></th>     
          <th>NAME</th>
          <th>CLASS ASSIGNED</th>       
          <th>VIEW</th>
          <th>EDIT</th>
          <th>DOCS.</th>
          <th>DEL</th>
      </thead>
      <tbody id="staffTableBody">
       <?php
       $count=1;
          while($empArray=mysqli_fetch_array($query)):?>
          <tr>     
              <td><?=$count;?></td>    
              <td><?=$empArray['name'];?></td>
              <td><?=rtrim($empArray['class_assigned'],',');?></td>       
              <td class="text-center"><a  href="#" id="<?=$empArray['id'];?>" class="view_staff" title="Click to view staff information."><i class="fas fa-eye"></i> view</a>
              <td class="text-center">
                  <a href="staff.php?edit=<?=$empArray['id'];?>"  title="Click to edit user."><i class="fas fa-pencil-alt"></i> edit</a>
              </td>
              <td class="text-center">
                  <a href="#" class="documents" id="<?=$empArray['id'];?>" title="Click to upload/view documents."><i class="fas fa-folder-open"></i> docs</a>
              </td>
             <td class="text-center"> <a href="#" class="deleteuserbtn text-danger" id="<?=$empArray['id'];?> " title="Click to delete user."><i class="fas fa-trash-alt"></i> delete</a></td>
          </tr>
        <?php $count++; endwhile;?>   
      </tbody>
  </table>

  </div><!--Closing col-md-9 div-->

   </div><!--Closing row div tag-->
   </div><!--closing container-fluid div-->
   <?php  }}
    include '../admin/footer.php';
   ?>
</body>
</html>
<script>
var staffNav = jQuery('#menuDiv');

jQuery('#filterDiv #access').change(function(){
  var accessFilter = jQuery(this).val();
  var genderFilter = jQuery('#filterDiv #genderFilter:checked').val();
  jQuery.ajax({
    url:'/school/admin/staff/filter.php',
    method:'POST',
    data:{accessFilter:accessFilter,genderFilter:genderFilter},
    success:function(data){
      jQuery('#staffTableBody').html();
      jQuery('#staffTableBody').html(data);
    },
    error:function(){
      alert("Something went wrong trying to filter staff by gender");
    }
  });
});

jQuery('#filterDiv #genderFilter').click(function(){
  var genderFilter = jQuery(this).val();
  var accessFilter = jQuery('#filterDiv option:selected').val();
  jQuery.ajax({
    url:'/school/admin/staff/filter.php',
    method:'post',
    data:{genderFilter:genderFilter,accessFilter:accessFilter},
    success:function(data){
      jQuery('#staffTableBody').html();
      jQuery('#staffTableBody').html(data);
    },
    error:function(){
      alert("Somethign went wrong trying to filter staff by gender");
    }
  });
});

staffNav.find('#search').click(function(e){
  e.preventDefault();
  jQuery('#filterDiv').hide('fast');
  jQuery('#searchDiv').toggle('slow');
});

staffNav.find('#filter').click(function(e){
  e.preventDefault();
  jQuery('#searchDiv').hide('fast');
  jQuery('#filterDiv').toggle('slow');
});

jQuery('#closeFilterDivBtn').click(function(){//button for closing the filter div
    jQuery('#filterDiv').hide('slow');
});
jQuery('#staff_search_data').css("display","none");

jQuery(document).click(function(){
  jQuery('#staff_search_data').css("display","none");
});

jQuery('.view_staff').click(function(event){//this is the view button clicked for the student
  event.preventDefault();
  var staff_id=jQuery(this).attr("id");
      jQuery.ajax({
          url:'/school/modals/viewstaffmodal.php',
          method:'post',
          data:{staff_id:staff_id},
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
jQuery('.resetpassbtn').click(function(){
  var userid=jQuery(this).attr("id");
  jQuery.ajax({
    url:'/school/admin/resetpassword.php',
    method:'POST',
    data:{userid:userid},
    success:function(){
      alert("Password reset successfully!");
    },
    error:function(){
      alert("Something went wrong");
    },
  });

});

jQuery('.documents').click(function(e){
  e.preventDefault();
  var staffId = jQuery(this).attr("id");
  jQuery.ajax({
    url:'/school/modals/staffdocuments.php',
    method:'POST',
    data:{staffId:staffId},
    success:function(data){
      jQuery("body").append(data);
      jQuery('#documents_modal').modal({
        backdrop:'static',
        keyboard:false
      });
    },
    error:function(){
      alert("Something went wrong trying to get staff documents");
    },
  });

});

function closeDeleteStaffDocModal(){
  jQuery('#documents_modal').modal("hide");
  window.location='/school/admin/staff.php';
}


jQuery('#search_staff').keyup(function(){//when a key is pressed inside the search box
  var staff_name = btoa(jQuery(this).val());
  jQuery.ajax({
    url:'/school/admin/staff/filter.php',
    method:'POST',
    data:{staff_name:staff_name},
    success:function(data){//code for the UTOCOMPLETE
      jQuery('#staffTableBody').html(data);
      jQuery('#staffTableBody').html(data);
    },
    error:function(){
        alert("Something went wrong trying to search staff");
    }
  });
});//end of keyup function

function closeDeleteStaffModal(){
  jQuery("#deletestaffmodal").modal("hide");
  window.location='/school/admin/staff.php';
}  
 jQuery('.deleteuserbtn').click(function(){
  var deleteStaffId=jQuery(this).attr("id");       
    jQuery.ajax({
      url:'/school/modals/deleteuser.php',
      method:'post',
      data:{deleteStaffId:deleteStaffId},
      success:function(data){
        jQuery("body").append(data);
        jQuery("#deletestaffmodal").modal("show");
      },
      error:function(){
        alert("Something went wrong trying to delete user.");
      },
    });
});

</script>

