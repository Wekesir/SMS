<!DOCTYPE html>
<html>
<head>
    <?php include 'includes/header.php';?>
</head>
<body>
    <?php require_once $_SERVER['DOCUMENT_ROOT'].'/school/core/init.php'; include 'includes/navigation.php'; ?>
    <div class="container" style="padding: 10px;">
        <div id="header_wrapper">
            <div class="text-center"><img src="school_images/hillstoplogo.png" height="100px;" width="100px;"
                    alt="Schoollogo"></div>
            <h5 class="text-center">Online Application Form</h5>
        </div>
        <p id="small_font" class="text-danger"> All fields marked * must be filled.</p>
        <?php
        if(isset($_POST['submit'])){
            $studentimageurl='';
            $stdname=strtoupper(trim(clean(((isset($_POST['name'])? $_POST['name']:'')))));  
            $stddob=trim(clean(((isset($_POST['dob'])? $_POST['dob']:''))));  
            $stdgender=trim(clean(((isset($_POST['gender'])? $_POST['gender']:''))));  
            $stdgrade=trim(clean(((isset($_POST['grade'])? $_POST['grade']:''))));  
            $stdpostal=trim(clean(((isset($_POST['postal'])? $_POST['postal']:''))));  
            $filename=$_FILES['image']['name'];
            if($filename !=''){
                $target_dir='/uploads/applicants/';
                $fileDestination=BASEURL.$target_dir.$_FILES['image']['name'];
                $fileTempName =$_FILES["image"]["tmp_name"];
                $fileError=$_FILES['image']['error'];
                $fileSize=$_FILES['image']['size'];
                $studentimageurl='/school/uploads/applicants/'.$_FILES['image']['name'];
                $imageFileNameExtension=strtolower(pathinfo($filename,PATHINFO_EXTENSION));
                $check=getimagesize($_FILES['image']['tmp_name']);
                if(file_exists($fileDestination)){//check if file already exists
                $errors[].='File already exists!';
                }
                if($fileSize>1000000){//checks the file size
                $errors[].='The file is too large. Please select another and try again';
                }
                $extensions=array('jpg','jpeg','png','gif');
                if(!in_array($imageFileNameExtension,$extensions,TRUE)){//checks if the file extension is allowed
                $errors[].='Only png, jpeg, jpg and png are allowed!';
                }
                if($check===false){//check if the file is an image
                $errors[].='The file you chose is not not an image.';
                }
            }
            $parname=trim(clean(((isset($_POST['pname'])? $_POST['pname']:''))));  
            $parname2=trim(clean(((isset($_POST['pname2'])? $_POST['pname2']:''))));  
            $parphone=trim(clean(((isset($_POST['phone'])? $_POST['phone']:'')))); 
            $parphone2=trim(clean(((isset($_POST['phone2'])? $_POST['phone2']:'')))); 
            $contacts=$parphone.','.$parphone2;
            $paremail=trim(clean(((isset($_POST['email'])? $_POST['email']:'')))); 
            $paraddress=trim(clean(((isset($_POST['address'])? $_POST['address']:'')))); 
            $idnumber=trim(clean(((isset($_POST['id_number'])? $_POST['id_number']:'')))); 
            $fschool1=trim(clean(((isset($_POST['fschool1'])? $_POST['fschool1']:''))));
            $fschool2=trim(clean(((isset($_POST['fschool2'])? $_POST['fschool2']:''))));
            $fschool3=trim(clean(((isset($_POST['fschool3'])? $_POST['fschool3']:''))));
            $formerschools= $fschool1.','.$fschool2.','.$fschool3;

            $namecheck=$db->query("SELECT * FROM students WHERE stdname='$stdname'");
            if(mysqli_num_rows($namecheck) > 0){
                $errors[].='<b>Error! </b>A student by the same name already exists.';
            }

            $required_info=array($stdname,$stddob,$stdgender,$stdgrade,$parname,$parphone,$idnumber);
            foreach($required_info as $info):
                if(empty($info)):
                    $errors[].='<b>Error! </b>Please provide all information marked *'; break;
                endif;
            endforeach;  

            if(!empty($errors)):
                displayErrors($errors);
            else://insert student data into the database
                if(!empty($filename)):
                    move_uploaded_file($fileTempName,$fileDestination);
                endif;
                $date=date('Y-m-d H:i:s');
                $db->query("INSERT INTO `applications` (`stdname`,`stddob`,`stdgender`,`stdgrade`,`stdpostal`,`stdimage`,`parname`,`parname2`,`contacts`,`paremail`,`paraddress`,`application_date`,`former_schools`)
                            VALUES
                            ('$stdname','$stddob','$stdgender','$stdgrade','$stdpostal','$studentimageurl','$parname','$parname2','$contacts','$paremail','$paraddress','$date','$formerschools')");
                            $messages[].='<b>Success! </b>Your application has been submitted.';

                if(!empty($messages)):
                    displayMessages($messages);
                endif;
            endif;
        }        
      ?>

        <form action="applicationform.php" method="POST" enctype="multipart/form-data">
            <div class="row">
                <div class="col-md-6">
                    <h6 class="text-center">Student Details Section</h6>
                    <div class="form-group">
                        <Label for="name">Full Name*</Label>
                        <input type="text" class="form-control" name="name" value="">
                    </div>
                    <div class="form-group">
                        <Label for="dob">Date of birth*</Label>
                        <input type="date" class="form-control" name="dob" value="">
                    </div>
                    <div class="form-group">
                        <Label for="gender">Gender*</Label>
                        <div class="radio">
                            <label for="gender" class="radio-inline"><input type="radio" name="gender" value="Male">
                                Male</label>
                            <label for="gender" class="radio-inline"><input type="radio" name="gender" value="Female">
                                Female</label>
                        </div>
                    </div>
                    <div class="form-group">
                        <label for="grade">Select grade you apply to join*</label>
                        <select name="grade" id="grade" class="form-control">
                            <option value="" name="grade" id="grade"></option>
                            <?php $query=$db->query("SELECT * FROM grade");
                            while($queryData=mysqli_fetch_array($query)):?>
                            <option value="<?=$queryData['grade'];?>" name="grade" id="grade"><?=$queryData['grade'];?>
                            </option>
                            <?php endwhile;?>
                        </select>
                    </div>
                    <div class="form-group">
                        <label for="postal">Postal Address</label>
                        <input type="text" name="postal" class="form-control" placeholder="(Optional)">
                    </div>
                    <div class="form-group">
                        <label for="image">Student image</label>
                        <input type="file" name="image" class="form-control">
                    </div>
                    <div class="form-group">
                        <Label for="regno">Former schools</Label>
                        <div class="form-group">
                            <input type="text" class="form-control" name="fschool1" value=""
                                placeholder="Enter school name...">
                        </div>
                        <div class="form-group">
                            <input type="text" class="form-control" name="fschool2" value=""
                                placeholder="Enter school name...">
                        </div>
                        <div class="form-group">
                            <input type="text" class="form-control" name="fschool3" value=""
                                placeholder="Enter school name...">
                        </div>
                    </div>
                </div>
                <!--closing col-md-6 div-->
                <div class="col-md-6">
                    <h6 class="text-center">Guardian Details section</h6>
                    <div class="form-group">
                        <label for="pname">Guardian's name*</label>
                        <input type="text" class="form-control" name="pname">
                    </div>
                    <div class="form-group">
                        <label for="pname2">Second Guardian's name</label>
                        <input type="text" name="pname2" class="form-control" placeholder="(Optional)">
                    </div>
                    <div class="form-group">
                        <label for="phone">Phone Number(s)*</label>
                        <div>
                            <input type="number" name="phone" id="phone" style="width: 45%;" placeholder="(Compulsory)"
                                min=0>
                            <input type="number" name="phone2" id="phone2" style="width: 45%;" placeholder="(Optional)"
                                min=0>
                        </div>
                        <div class="text-danger extra_small" id="phone_verify"></div>
                    </div>
                    <div class="form-group">
                        <label for="id">ID Number*:</label>
                        <input type="number" name="id_number" class="form-control" id="id_number">
                    </div>
                    <div class="form-group">
                        <label for="email">Parent Email</label>
                        <input type="email" name="email" class="form-control" placeholder="(Optional)">
                    </div>
                    <div class="form-group">
                        <label for="address">Residence*</label>
                        <input type="text" name="address" class="form-control">
                    </div>
                </div>
                <!--closing col-md-6 div-->
            </div>
            <!--closing row div-->
            <input type="submit" name="submit" id="submit" value="Submit" class="btn btn-md">
        </form>
    </div>
</body>

</html>
<script>
jQuery('#phone').blur(function() {
    var phone_length = jQuery('#phone').val(); //gets the value of the input

    jQuery.ajax({
        url: "/school/admin/fetch.php",
        method: "POST",
        data: {
            phone_length: phone_length
        },
        success: function(data) {
            jQuery('#phone_verify').html(data);
        },
        error: function() {
            alert("Something went wrong trying to send phone number");
        },
    });


});

jQuery('#phone2').blur(function() {
    var phone2_length = jQuery('#phone2').val(); //gets the value of the input

    jQuery.ajax({
        url: "/school/admin/fetch.php",
        method: "POST",
        data: {
            phone2_length: phone2_length
        },
        success: function(data) {
            jQuery('#phone_verify').html(data);
        },
        error: function() {
            alert("Something went wrong trying to send phone number");
        },
    });


});
</script>