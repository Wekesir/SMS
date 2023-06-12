<!DOCTYPE html>
<html>
<head>
    <?php
        require_once $_SERVER['DOCUMENT_ROOT'].'/school/core/init.php';
        include '../admin/header.php';
        include '../modals/confirmpassword.php';//this is the modal that pops up for confirming password before moving students to the next level
    ?>
</head>
<body>   
    <?php include '../admin/navigation.php';?>
 <div class="container-fluid">
    <div class="row">
        <div class="col-md-3">
            <?php include '../admin/left.php';?>
        </div><!--Closing col-md-3 div-->
        <div class="col-md-9 bg-light" id="wrapper">

            <?php 
                if(isset($_REQUEST['confirmPassBtn'])){//if the confirm button is clicked from the modal the following code should execute
                    $confPassId = (int)$_SESSION['user'];  
                    $confirmPass = trim(clean(((isset($_REQUEST['confirmpassword'])? $_REQUEST['confirmpassword']:''))));
                    $queryData = mysqli_fetch_array($db->query("SELECT * FROM users WHERE id='$confPassId'"));
                    
                    //CHECK IF THE PASSWORD IS CORRECT
                    if(!password_verify($confirmPass,$queryData['password']) || $confirmPass==''){//if the password is wrong or password is null then display Modal again
                        ?>
                        <script>
                                jQuery('#confirmpasswordmodal').modal({
                                backdrop: 'static', keyboard: false
                                });//prevents modal from closing on backdrop and keyboard clicking
                            </script>
                            <!--CODE FOR SHOWiNG MODAL IF THE PASSWORD IS WRONG-->
                            <style>
                                #confirmpasswordmodal {
                                animation: shake 0.5s;
                                animation-iteration-count:3;
                                }

                                @keyframes shake {
                                0% { transform: translate(1px, 1px) rotate(0deg); }
                                10% { transform: translate(-1px, -2px) rotate(-1deg); }
                                20% { transform: translate(-3px, 0px) rotate(1deg); }
                                30% { transform: translate(3px, 2px) rotate(0deg); }
                                40% { transform: translate(1px, -1px) rotate(1deg); }
                                50% { transform: translate(-1px, 2px) rotate(-1deg); }
                                60% { transform: translate(-3px, 1px) rotate(0deg); }
                                70% { transform: translate(3px, 1px) rotate(-1deg); }
                                80% { transform: translate(-1px, -1px) rotate(1deg); }
                                90% { transform: translate(1px, 2px) rotate(0deg); }
                                100% { transform: translate(1px, -2px) rotate(-1deg); }
                                }
                                </style>
                        <?php
                    }else{//if the password is correct is correct then hide modal
                        ?>
                        <script>
                        jQuery('#confirmpasswordmodal').modal("hide");
                        </script>
                        <?php
                    }
                        
                    }else{//This code executes when the user has not cinfirmed their password
                        ?>
                        <script>
                        jQuery('#confirmpasswordmodal').modal({
                        backdrop: 'static', keyboard: false
                        });//prevents modal from closing on backdrop and keyboard clicking                  
                        </script>
                        <?php
                    }
    /*******-----------------CONFIRM BUTTON MODAL BUTTON ENDS HERE----------------------------->****************/

            ?>

                <div id="configDiv">

                    <h6 class="text-center" style="padding:20px;background-color: #F0F8FF;">THIS INFORMATION IS SENSITIVE.</h6>
                    <?php 
                    $configQuery = $db->query("SELECT * FROM system_configuration");

                    $configData            = mysqli_fetch_array($configQuery);
                    $get_schoolName        = ((isset($configData['school_name']))?$configData['school_name']:'NULL');
                    $get_schoolMotto       = ((isset($configData['school_motto']))?$configData['school_motto']:'NULL');
                    $get_mission           = ((isset($configData['school_mission']))?$configData['school_mission']:'NULL');
                    $get_vision            = ((isset($configData['school_vision']))?$configData['school_vision']:'NULL');
                    $get_schoollogo        = ((isset($configData['school_logo']))? $configData['school_logo']:'');
                    $get_image             = ((isset($configData['headteacher_image']))? $configData['headteacher_image']:'');
                    $get_email             = ((isset($configData['school_email']))? $configData['school_email']:'');
                    $get_transport         = ((isset($configData['transport']))? $configData['transport']:'');
                    $get_transportCharges  = ((isset($configData['transportation_charges']))? $configData['transportation_charges']:'');
                    $get_food              = ((isset($configData['food']))? $configData['food']:'');
                    $get_foodcharges        = ((isset($configData['food_charges']))? $configData['food_charges']:'');
                    $get_systemType         = ((isset($configData['system_type']))? $configData['system_type']:'');
                    $get_boardingcharges    = ((isset($configData['boardingCharges']))? $configData['boardingCharges']:'');
                    $get_installDate        = ((isset($configData['installed_on']))? $configData['installed_on']:'NULL');
                    $get_amount             = ((isset($configData['agreed_amount']))? $configData['agreed_amount']:'NULL');
                    $get_licenceKey         = ((isset($configData['licence_key']))? $configData['licence_key']:'NULL'); 
                    $get_regAbr             = ((isset($configData['registrationNumber_abbreviation']))? $configData['registrationNumber_abbreviation']:'NULL'); 
                    $get_nhif               = ((isset($configData['nhif_percentage']))? $configData['nhif_percentage']:'NULL'); 
                    $get_nssf               = ((isset($configData['nssf_percentage']))? $configData['nssf_percentage']:'NULL'); 

                    $foodChargesDecoded     = json_decode($get_foodcharges,true);//decoding the string that holds food charges for the school

                    if(isset($_POST['submit'])){//when the submit button is clicked

                        $name               = clean(trim(((isset($_POST['schoolName'])    ? strtoupper($_POST['schoolName'])  : ''))));
                        $motto              = clean(trim(((isset($_POST['schoolmotto'])? $_POST['schoolmotto'] : ''))));
                        $mission            = clean(trim(((isset($_POST['mission'])? $_POST['mission'] : ''))));
                        $vision             = clean(trim(((isset($_POST['vision'])? $_POST['vision'] : ''))));
                        $systemType         = clean(trim(((isset($_POST['systemType'])? $_POST['systemType']: ''))));
                        $email              =  clean(trim(((isset($_POST['email'])? $_POST['email']: ''))));
                        $transport          =  clean(trim(((isset($_POST['transport'])? $_POST['transport']: ''))));
                        $food               =  clean(trim(((isset($_POST['food'])? $_POST['food']: ''))));
                        $boardingCharges    =  clean(trim(((isset($_POST['boardingCharges'])? $_POST['boardingCharges']: ''))));
                        $morning_snack      =  clean(trim(((isset($_POST['morning_snack'])? $_POST['morning_snack']: 0.00))));//charges for the morning snack
                        $lunch              =  clean(trim(((isset($_POST['lunch'])? $_POST['lunch']: 0.00))));//charges for lunch
                        $evening_snack      =  clean(trim(((isset($_POST['evening_snack'])? $_POST['evening_snack']: 0.00))));//charges for the evening snack
                        $transportCharges   =  clean(trim(((isset($_POST['transportCharges'])? $_POST['transportCharges']: ''))));
                        $regAbr             =  clean(trim(((isset($_POST['regAbr'])? strtoupper($_POST['regAbr']): ''))));
                        $installDate        =  clean(trim(((isset($_POST['date'])? $_POST['date']: ''))));
                        $licenceExpiry      =  date('Y-m-d', strtotime("+1 year"));
                        $amount             =  clean(trim(((isset($_POST['amount'])? $_POST['amount']: ''))));
                        $licenceKey         =  clean(trim(((isset($_POST['licenceKey'])? $_POST['licenceKey']: ''))));
                        $nhifPercentage     =  clean(trim(((isset($_POST['nhifPercentage'])? $_POST['nhifPercentage']: ''))));
                        $nssfPercentage     =  clean(trim(((isset($_POST['nssfPercentage'])? $_POST['nssfPercentage']: ''))));
                        $filename           =  trim(clean(((isset($_FILES['image']['name'])? $_FILES['image']['name']:''))));
                        $fileheadTimage     =  trim(clean(((isset($_FILES['headteacherimage']['name'])? $_FILES['headteacherimage']['name']:''))));
                        $schoollogourl='';
                        $headTeacherImageUrl = '';

                        $foodChargesArray = array(//create an array that holds all the charges concerning food
                            'MORNING_SNACK' => $morning_snack,
                            'LUNCH'         => $lunch,
                            'EVENING_SNACK' => $evening_snack
                        );

                        $foodCharges         = json_encode($foodChargesArray);

                        if($filename !=''){
                            $target_dir             = '/uploads/school/';
                            $fileDestination        = BASEURL.$target_dir.$_FILES['image']['name'];
                            $fileTempName           = $_FILES["image"]["tmp_name"];
                            $fileError              = $_FILES['image']['error'];
                            $fileSize               = $_FILES['image']['size'];
                            $schoollogourl        = '/school/uploads/school/'.$_FILES['image']['name'];
                            $imageFileNameExtension = strtolower(pathinfo($filename,PATHINFO_EXTENSION));
                            $check                  = getimagesize($_FILES['image']['tmp_name']);                   
                            if($fileSize>1000000){//checks the file size
                            $errors[].='The file is too large. Please select another and try again';
                            }
                            $extensions=array('jpg','jpeg','png','gif');
                            if(!in_array($imageFileNameExtension,$extensions,TRUE)){//checks if the file extension is allowed
                            $errors[].='Only PNG, JPEG, JPG and PNG are allowed!';
                            }
                            if($check===false){//check if the file is an image
                            $errors[].='The file you chose is not an image.';
                            }
                        }
                        if($fileheadTimage !=''){
                            $target_dir             = '/uploads/school/';
                            $headfileDestination    = BASEURL.$target_dir.$_FILES['headteacherimage']['name'];
                            $headfileTempName       = $_FILES["headteacherimage"]["tmp_name"];
                            $fileError              = $_FILES['headteacherimage']['error'];
                            $fileSize               = $_FILES['headteacherimage']['size'];
                            $headTeacherImageUrl    = '/school/uploads/school/'.$_FILES['headteacherimage']['name'];
                            $imageFileNameExtension = strtolower(pathinfo($fileheadTimage,PATHINFO_EXTENSION));
                            $check                  = getimagesize($_FILES['headteacherimage']['tmp_name']);                   
                            if($fileSize>1000000){//checks the file size
                            $errors[].='The file is too large. Please select another and try again';
                            }
                            $extensions=array('jpg','jpeg','png','gif');
                            if(!in_array($imageFileNameExtension,$extensions,TRUE)){//checks if the file extension is allowed
                            $errors[].='Only PNG, JPEG, JPG and PNG are allowed!';
                            }
                            if($check===false){//check if the file is an image
                            $errors[].='The file you chose is not an image.';
                            }
                        }

                        if(!empty($filename)){//if  a new image has been selected                          
                             move_uploaded_file($fileTempName,$fileDestination);
                        }else{
                            $schoollogourl = $get_schoollogo;//then the old image path is retained in the databse
                        }

                        if(!empty($fileheadTimage)){//if  a new image has been selected                          
                             move_uploaded_file($headfileTempName,$headfileDestination);
                        }else{
                            $headTeacherImageUrl = $get_image;//then the old image path is retained in the databse
                        }
                            
                        $db->query("UPDATE `system_configuration` SET
                                     `school_name`                     = '{$name}',
                                     `school_logo`                     = '{$schoollogourl}',
                                     `school_email`                    = '{$email}',
                                     `school_motto`                    = '{$motto}',
                                     `school_mission`                  = '{$mission}',
                                     `school_vision`                   = '{$vision}',
                                     `installed_on`                    = '{$installDate}',
                                     `licence_key`                     = '{$licenceKey}',
                                     `agreed_amount`                   = '{$amount}',
                                     `system_type`                     = '{$systemType}',
                                     `transport`                       = '{$transport}',
                                     `boardingCharges`                 = '{$boardingCharges}',
                                     `food`                            = '{$food}',
                                     `food_charges`                    = '{$foodCharges}',
                                     `registrationNumber_abbreviation` = '{$regAbr}',                                     
                                     `transportation_charges`          = '{$transportCharges}',
                                     `nssf_percentage`                 = '{$nssfPercentage}',
                                     `nhif_percentage`                 = '{$nhifPercentage}',
                                     `headteacher_image`               = '{$headTeacherImageUrl}'
                                      "); 
                        

                    }
                    /******===============================================================================
                     * ====END OF THE SUBMIT BUTTOn FUNCTION
                     =====================================================================================*/
                    ?>

                    <form action="configuration.php" method="POST" enctype="multipart/form-data">
                        <div class="form-group">
                            <label for="schoolName">School Name*</label>
                            <input type="text" name="schoolName" class="form-control" value='<?=$get_schoolName?>' required=required>
                        </div>
                        <div class="form-group">
                            <label for="schoolLogo">School Logo*</label>
                            <?php if(!empty($get_schoollogo)){?>
                                <div>
                                <img src="<?php echo $get_schoollogo;?>" alt="School logo" style="width:100px;height:100px;margin:10px;">
                                </div>
                            <?php }?>
                            <input type="file" name="image" class="form-control ">
                        </div>
                        <div class="form-group">
                            <label for="schoolLogo">School HeadTeacher's Image*</label>
                            <?php if(!empty($get_image)){?>
                                <div>
                                <img src="<?php echo $get_image;?>" alt="School headteacher Image" style="width:100px;height:100px;margin:10px;">
                                </div>
                            <?php }?>
                            <input type="file" name="headteacherimage" class="form-control ">
                        </div>
                        <div class="form-group">
                            <label for="schoolmotto">School Motto*</label>
                            <input type="text" name="schoolmotto" class="form-control " value='<?=$get_schoolMotto?>' required=required>
                        </div> 
                        <div class="form-group">
                                <label for="">School Mission</label>
                                <textarea name="mission" id="mission" class="form-control" rows="3" value="<?=$get_mission?>"><?=$get_mission;?></textarea>
                        </div>
                        <div class="form-group">
                                <label for="">School Vision</label>
                                <textarea name="vision" id="vision" class="form-control" rows="3" <?=$get_vision?>> <?=$get_vision?></textarea>
                        </div>
                        <div class="form-group">
                            <label for="email">School Email*</label>
                            <input type="email" name="email" class="form-control " value='<?=$get_email?>'>
                        </div> 
                        <div class='form-group'>
                                <label for="">Does the school provide transportation?</label>
                                <select name="transport" id="transport" class="form-control " required=required>
                                    <option value=""></option>
                                    <option value="YES" <?php if($get_transport =='YES'){echo 'selected';}?>>YES</option>
                                    <option value="NO" <?php if($get_transport =='NO'){echo 'selected';}?>>NO</option>
                                </select>
                        </div> 
                        <div class="form-group">
                            <label for="email">Transport charges (Kshs.)*</label>
                            <input type="number" name="transportCharges" class="form-control" min=0 value='<?=$get_transportCharges?>'>
                        </div> 
                        <div class='form-group'>
                                <label for="">Does the school provide food?</label>
                                <select name="food" id="food" class="form-control " required=required>
                                    <option value=""></option>
                                    <option value="YES" <?php if($get_food =='YES'){echo 'selected';}?>>YES</option>
                                    <option value="NO" <?php if($get_food =='NO'){echo 'selected';}?>>NO</option>
                                </select>
                        </div> 
                        <div class="form-row">
                            <div class="col-md-4">
                                <label for="">10 A.M SNACK</label>
                                <input type="number" name="morning_snack" id="" min=0 class="form-control" value="<?=$foodChargesDecoded['MORNING_SNACK']?>">
                            </div>
                            <div class="col-md-4">
                                <label for="">LUNCH</label>
                                <input type="number" name="lunch" id="" min=0 class="form-control" value="<?=$foodChargesDecoded['LUNCH']?>">
                            </div>
                            <div class="col-md-4">
                                <label for="">4 P.M SNACK</label>
                                <input type="number" name="evening_snack" id="" min=0 class="form-control" value="<?=$foodChargesDecoded['EVENING_SNACK']?>">
                            </div>
                        </div>                         
                        <?php if($logged_in_user_data['permissions']=='Super_Admin') {?>                       
                            <div class='form-group'>
                                <label for="">System Type</label>
                                <select name="systemType" id="systemType" class="form-control " required=required>
                                    <option value=""></option>
                                    <option value="DAY" <?php if($get_systemType =='DAY'){echo 'selected';}?>>DAY</option>
                                    <option value="BOARDING" <?php if($get_systemType =='BOARDING'){echo 'selected';}?>>DAY & BOARDING</option>
                                </select>
                            </div>
                        <?php }?>

                        <div class="form-group">
                            <label for="email">Boarding charges (Kshs.)*</label>
                            <input type="number" name="boardingCharges" class="form-control" min=0 value='<?=$get_boardingcharges?>'>
                        </div> 

                         <?php if($logged_in_user_data['permissions']=='Super_Admin') {?> 
                        <div class="form-group">
                            <label for="date">Registration Number Abbreviation</label>
                            <input type="text" name="regAbr" class="form-control " value="<?=$get_regAbr?>" required=required>
                        </div> 
                         <?php }?>

                         <div class="form-row">
                            <div class="col-md-6">
                                <label for="">NHIF payment salary percentage</label>
                                <input type="number" class="form-control" name="nhifPercentage" value="<?=$get_nhif?>" min=5 required=required>
                            </div>
                            <div class="col-md-6">
                                <label for="">NSSF payment salary percentage</label>
                                <input type="number" class="form-control" name="nssfPercentage" value="<?=$get_nssf?>" min=5 required=required>
                            </div>
                         </div>
                         <?php if($logged_in_user_data['permissions']=='Super_Admin') {?> 
                        <div class="form-group">
                            <label for="date">Installation Date</label>
                            <input type="date" name="date" class="form-control " value="<?=$get_installDate?>" required=required>
                        </div> 
                         <?php }?>

                         <?php if($logged_in_user_data['permissions']=='Super_Admin') {?> 
                        <div class="form-group">
                            <label for="date">Amount per term {Kshs}</label>
                            <input type="number" name="amount" class="form-control " value="<?=$get_amount?>" min=0 required=required>
                        </div>
                         <?php }?>

                          <?php if($logged_in_user_data['permissions']=='Super_Admin') {?> 
                        <div class="form-group">
                            <label for="licenceKey">Licence Key</label>
                            <input type="text" name="licenceKey" class="form-control " value="<?=$get_licenceKey?>" min=0>
                        </div>
                         <?php }?>

                        <?php if($logged_in_user_data['permissions']=='Super_Admin') {?> 
                        <div class='form-group'>
                            <input type="submit" class="btn btn-md btn-success " name="submit" value="Submit">
                        </div>
                        <?php } ?>
                    </form>
                </div><!--Closing condigDiv-->            
        </div><!--Closing col-md-9 div-->
    </div><!--Closing row dic-->
 </div><!--closing container div-->
    <?php include '../admin/footer.php';?>
</body>
</html>
<script>
/*this function sends the URL of this script to the modal so the form data from 
.....action from modal is dynamic
*/
jQuery(document).ready(function(){
    var script_url = '/school/admin/configuration.php';
    jQuery.ajax({
        url:'/school/modals/confirmpassword.php',
        method:'POST',
        data:{script_url:script_url},
        error:function(){
            alert("Something went wrong sending URL.");
        },
    });
});

function closeconfrimpasswordModal(){
    jQuery('#confirmpasswordmodal').modal("hide");
    window.location='../admin/students.php';
}
</script>
