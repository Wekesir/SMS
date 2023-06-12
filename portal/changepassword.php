<?php 
include '../portal/header.php';
require_once $_SERVER['DOCUMENT_ROOT'].'/school/core/init.php';
include '../portal/navigation.php';?>
        <style>
        
        </style>
    <div id="changePasswordBody">  </div><!--Closing changePasswordBody div-->

    <div id="changepasswordDiv">
        <h6 class="text-center" style="background:#f5f5f5;color:black;padding:10px;">CHANGE YOUR PASSWORD.</h6>
    <div class="form-group">
     
      
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
             <input type="submit" class="btn btn-sm btn-primary" value="Change Password" name="changepasswordbtn">
     </form>
    </div> 

    <?php include '../portal/footer.php';?>   
   
<script>
    jQuery('#newpassword').focus(function(){
        jQuery('#password_verify').html("Password must be at least 6 characters long");
    });
    jQuery('#re_ewpassword').focus(function(){
        jQuery('#password2_verify').html("Password must be at least 6 characters long");
    });
</script>
