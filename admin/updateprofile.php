<!DOCTYPE html>
<html>
<head>
  <?php require_once $_SERVER['DOCUMENT_ROOT'].'/school/core/init.php';
        include '../admin/header.php';
  ?>
</head>
<body>
 
    <?php include '../admin/navigation.php';?>

    <div class="container-fluid">
    <div class="row">
        
        <div class="col-md-12" id="wrapper" style="background:url('https://cdn.hipwallpaper.com/i/85/24/4UDdHy.jpg')">
    <div id="updateprofilediv">
        <h6 class="text-center" style="background:#f5f5f5;color:black;padding:10px;">UPDATE YOUR PROFILE.</h6>
    <div class="form-group">

     <?php
     $employee_Id=(int)$_SESSION['user'];
     $query=$db->query("SELECT * FROM users WHERE id='$employee_Id'");
     $queryData=mysqli_fetch_array($query);

     $username = $queryData['username'];
     $phone    = $queryData['phone'];
     $email    = $queryData['email'];
     $gender   = $queryData['gender'];
     $image    = $queryData['image'];

     if(isset($_POST['updateprofilebtn'])){

        $staffimageurl='';
        $filename    = trim(clean(((isset($_FILES['name']['image']) && $_FILES['name']['image'] !='' ? $_FILES['name']['image'] : ''))));
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

        $getUsername = trim(clean(((isset($_POST['username']) && $_POST['username'] !='' ? $_POST['username'] : $username))));
        $getphone    = trim(clean(((isset($_POST['phone']) && $_POST['phone'] !='' ? $_POST['phone'] : $phone))));
        $getemail    = trim(clean(((isset($_POST['email']) && $_POST['email'] !='' ? $_POST['email'] : $employee_Id))));
        $getgender   = trim(clean(((isset($_POST['gender']) && $_POST['gender'] !='' ? $_POST['gender'] : $gender))));
        $getimage    = trim(clean(((isset($filename) && $filename !='' ? $staffimageurl : $image))));

        if($filename !=''){
            move_uploaded_file($fileTempName,$fileDestination);
        }

        $db->query("UPDATE users set 
                    username='$getUsername',email='$getemail',phone='$getphone',gender='$getgender',image='$getimage'
                    WHERE id='$employee_Id'");
        $messages[].='<b>Success </b>Your profile has been updated';
        if(!empty($messages)){
            displayMessages($messages);
        }
     }
     ?>
      
    <form action="updateprofile.php" method="post" enctype="multipart/form-data">
            <div class="form-group">
                <label for="username">Your Name:</label>
                <input type="text" class="form-control" name="name" value="<?=$logged_in_user_data['name'];?>" readonly>
            </div>
            <div class="form-group">
                <label for="username">Username:</label>
                <input type="text" class="form-control" name="username" value="<?=$logged_in_user_data['username'];?>">
            </div>
            <div class="form-group">
                <label for="phone">Phone number:</label>
                <input type="number" class="form-control" name="phone" id="phone" value="<?=$logged_in_user_data['phone'];?>">                
            </div>
            <div class="form-group">
                <label for="email">Provide your email:</label>
                <input type="email" class="form-control" name="email" id="email" value="<?=$logged_in_user_data['email'];?>">                
            </div>
            <div class="form-group">
            <Label for="gender">Gender:</Label>
                    <label for="gender" class="radio-inline">Male: <input type="radio" name="gender" id="male" value="Male" <?php if($logged_in_user_data['gender'] == "MALE"){echo 'checked';}?>></label>
                    <label for="gender" class="radio-inline">Female: <input type="radio" name="gender" id="female" value="Female" <?php if($logged_in_user_data['gender'] == "FEMALE"){echo 'checked';}?> ></label>
            </div>
            <div class="form-group">
                <label for="image">Change Image:</label>
                <input type="file" class="form-control" name="image" id="image">                
            </div>
             <input type="submit" class="btn btn-md theme_color" value="Update profile" name="updateprofilebtn">
     </form>
    </div>

    </div><!--Closing wrapper div--
    </div><!--Closing col-md-9 div-->
    </div><!--Closing row div-->
    </div><!--Closing container-fluid div-->
    <?php include '../admin/footer.php';?>
</body>
</html>

