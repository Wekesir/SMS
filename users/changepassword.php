<!DOCTYPE html>
<html>
<head>
  <?php require_once $_SERVER['DOCUMENT_ROOT'].'/school/core/init.php';
        include '../users/header.php';
  ?>
</head>
<body>
 
    <?php include '../users/navigation.php';
    $errors=array();
    $mesages=array();
    ?>

    <div class="container-fluid bg-light">
    <div class="row">
        <div class="col-md-3">
            <?php include '../users/left.php';?>
        </div>
        <div class="col-md-9">
    <div id="changepassworddiv">
        <h5 class="text-center">Change password</h5> <hr>
    <div class="form-group">
     <?php
      if(isset($_POST['changepasswordbtn'])){
           $id=$_SESSION['user'];
            $userquery=$db->query("SELECT * FROM users WHERE id='$id'");
            $userdata=mysqli_fetch_array($userquery);
            $password=trim(clean(((isset($_POST['oldpassword'])?$_POST['oldpassword']:''))));
            $newpassword=trim(clean(((isset($_POST['newpassword'])?$_POST['newpassword']: ''))));
            $hashedpassword=password_hash($newpassword, PASSWORD_DEFAULT);
            $re_newpassword=trim(clean(((isset($_POST['re_newpassword'])?$_POST['re_newpassword']:''))));
      
        if($newpassword != $re_newpassword){
            $errors[].='The entered passwords do not match';
        }

        if(strlen($newpassword)<6 || strlen($re_newpassword)<6){
            $errors[].='Password must be at least 6 characters long.';
        }

       if(!password_verify($password, $userdata['password'])){
            $errors[].='The password you entered is wrong! Please try again.';
        }

        $required_info=array($password, $newpassword, $re_newpassword);
            foreach($required_info as $info){
                if(empty($info)){
                    $errors[].='Please provide both old and new passwords.';        
                    break;           
                } 
            }
        if(!empty($errors)){
            displayErrors($errors);
        }else{
          $db->query("UPDATE users SET password='$hashedpassword' WHERE id='$id'");
          $messages[].='Password changes successfully';
            if(!empty($messages)){
                displayMessages($messages);
            }
        }     
      }
      ?>
      
    <form action="changepassword.php" method="post">
            <div class="form-group">
                <label for="oldpassword">Old Password:</label>
                <input type="password" class="form-control" name="oldpassword">
            </div>
            <div class="form-group">
                <label for="newpassword">New Password:</label>
                <input type="password" class="form-control" name="newpassword" id="newpassword">
                <div class="exsmall_font text-danger">Password must be at least 6 characters long</div>
            </div>
            <div class="form-group">
                <label for="re_newpassword">Re-Enter new Password:</label>
                <input type="password" class="form-control" name="re_newpassword" id="re_newpassword">
                <div class="exsmall_font text-danger">Password must be at least 6 characters long</div>
            </div>
             <input type="submit" class="btn btn-md theme_color" value="Change Password" name="changepasswordbtn">
     </form>
    </div>

    </div><!--Closing wrapper div--
    </div><!--Closing col-md-9 div-->
    </div><!--Closing row div-->
    </div><!--Closing container-fluid div-->
    <?php include '../users/footer.php';?>
</body>
</html>

