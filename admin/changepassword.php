<!DOCTYPE html>
<html>
<head>
  <?php require_once $_SERVER['DOCUMENT_ROOT'].'/school/core/init.php';
        include '../admin/header.php';
  ?>
  <style>

  </style>
</head>
<body>
 
    <?php include '../admin/navigation.php';?>

    <div class="container-fluid">
    <div class="row">
        
    <div id="changePasswordBody">  </div><!--Closing changePasswordBody div-->

    <div id="changepasswordDiv">
        <h6 class="text-center" style="background:#f5f5f5;color:black;padding:10px;">CHANGE YOUR PASSWORD.</h6>
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
            $errors[].='<b>Error! </b>The entered passwords do not match';
        }

        if(strlen($newpassword)<6 || strlen($re_newpassword)<6){
            $errors[].='<b>Error! </b>Password must be at least 6 characters long.';
        }

       if(!password_verify($password, $userdata['password'])){
            $errors[].='<b>Error! </b>The password you entered is wrong! Please try again.';
        }

        if(!empty($errors)){
            displayErrors($errors);
        }else{
          $db->query("UPDATE users SET password='$hashedpassword' WHERE id='$id'");
          $messages[].='<b>Success! </b>Your password has been reset.';
          if(!empty($messages)){
              displayMessages($messages);
          }
        }     
      }
      ?>
      
    <form action="changepassword.php" method="post">
            <div class="form-group">
                <label for="oldpassword">Old Password:</label>
                <input type="password" class="form-control" name="oldpassword" required=required>
            </div>
            <div class="form-group">
                <label for="newpassword">New Password:</label>
                <input type="password" class="form-control" name="newpassword" id="newpassword" required=required>
                <div class="exsmall_font text-danger">Password must be at least 6 characters long</div>
            </div>
            <div class="form-group">
                <label for="re_newpassword">Re-Enter new Password:</label>
                <input type="password" class="form-control" name="re_newpassword" id="re_newpassword" required=required>
                <div class="exsmall_font text-danger">Password must be at least 6 characters long</div>
            </div>
             <input type="submit" class="btn btn-md btn-primary" value="Change Password" name="changepasswordbtn">
     </form>
    </div> 
   
    </div><!--Closing row div-->
    </div><!--Closing container-fluid div-->
    <?php include '../admin/footer.php';?>
</body>
</html>
<script>
    jQuery('#newpassword').focus(function(){
        jQuery('#password_verify').html("Password must be at least 6 characters long");
    });
    jQuery('#re_ewpassword').focus(function(){
        jQuery('#password2_verify').html("Password must be at least 6 characters long");
    });
</script>
