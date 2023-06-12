<!DOCTYPE html>
<html>
<head>
  <?php require_once $_SERVER['DOCUMENT_ROOT'].'/school/core/init.php';
        include '../users/header.php';  ?>
</head>
<body>
 
    <?php include '../users/navigation.php'; ?>

    <div class="container-fluid bg-light">
    <div class="row">
        <div class="col-md-3">
            <?php include '../users/left.php';?>
        </div>
        <div class="col-md-9">
    <div id="updateprofilediv">
        <h5 class="text-center">UPDATE YOUR PROFILE.</h5> <hr>
    <div class="form-group">

     <?php
     $employee_Id=(int)$_SESSION['user'];
     $query=$db->query("SELECT * FROM users WHERE id='$employee_Id'");
     $queryData=mysqli_fetch_array($query);

     $name     = $queryData['name'];
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

        $getUsername = clean(((isset($_POST['username']) && $_POST['username'] !='' ? trim($_POST['username']) : $username)));
        $getphone    = clean(((isset($_POST['phone']) && $_POST['phone'] !='' ? trim($_POST['phone']) : $phone)));
        $getemail    = clean(((isset($_POST['email']) && $_POST['email'] !='' ?trim( $_POST['email']) : $email)));
        $getgender   = clean(((isset($_POST['gender']) && $_POST['gender'] !='' ? trim($_POST['gender']) : $gender)));
        $getimage    = clean(((isset($filename) && $filename !='' ? $staffimageurl : $image)));

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
      
    <form action="<?=$_SERVER['PHP_SELF']?>" method="post" enctype="multipart/form-data">
            <div class="form-group">
                <label for="username">Name:</label>
                <input type="text" class="form-control" name="name" value=<?=$name;?> readonly>
            </div>
            <div class="form-group">
                <label for="username">Username:</label>
                <input type="text" class="form-control" name="username" value=<?=$username;?>>
            </div>
            <div class="form-group">
                <label for="phone">Phone number:</label>
                <input type="number" class="form-control" name="phone" id="phone" value=<?=$phone;?>>                
            </div>
            <div class="form-group">
                <label for="email">Email:</label>
                <input type="email" class="form-control" name="email" id="email" value=<?=$email;?>>                
            </div>
            <div class="form-group">
            <Label for="gender">Gender:</Label>
                    <label for="gender" class="radio-inline">Male: <input type="radio" name="gender" id="male" value="MALE" <?=(($gender=="MALE")?"checked":"")?>></label>
                    <label for="gender" class="radio-inline">Female: <input type="radio" name="gender" id="female" value="FEMALE" <?=(($gender=="FEMALE")?"checked":"")?> ></label>
            </div>
            <div class="form-group">
                <label for="image">Change Image:</label>
                <input type="file" class="form-control" name="image" id="image">                
            </div>
            <div class="form-group">
                <input type="submit" class="btn btn-sm btn-primary" value="Update profile" name="updateprofilebtn">
            </div>
          
     </form>
    </div>

    </div><!--Closing wrapper div--
    </div><!--Closing col-md-9 div-->
    </div><!--Closing row div-->
    </div><!--Closing container-fluid div-->
    <?php include '../users/footer.php';?>
</body>
</html>

