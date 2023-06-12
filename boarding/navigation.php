<?php require_once $_SERVER['DOCUMENT_ROOT'].'/school/core/init.php';

   if(!logged_in()){
            not_logged_in_page_redirect();
        }
?>
<nav class="navbar navbar-expand-lg navbar-static">
<div class="container">
  <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarTogglerDemo03" aria-controls="navbarTogglerDemo03" aria-expanded="false" aria-label="Toggle navigation">
    <span class="navbar-toggler-icon"></span>
  </button>
  <a class="navbar-brand" href="index.php">Hillstop Academy Mirera</a>

  <div class="collapse navbar-collapse" id="navbarTogglerDemo03">
      
    <ul class="navbar-nav ml-auto" >
    <li class="nav-item expiryMessage">
         <a style="color:red;" class="nav-link" href="../users/staffhomepage.php"><i class="fas fa-exclamation-triangle"></i> Licence Expiry.</a>
       </li>
        <?php  // this label only appeRS WHEN SOMEONE IS LOGGED IN AS A SUPER ADMIN
          if($logged_in_user_data['permissions']=='Super_Admin'){
            ?>       
        <li class="nav-item">
        <a style="color:white;" class="nav-link" href="../users/staffhomepage.php"><i class="fas fa-chalkboard-teacher"></i>View Teacher's Portal.</a>
       </li>
        <?php 
        }
        ?>

        <li class="nav-item dropdown">
          <a class="nav-link dropdown-toggle" style="color:white;" href="#" id="navbarDropdownMenuLink" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
            Views
          </a>
          <div class="dropdown-menu" aria-labelledby="navbarDropdownMenuLink">
            <a class="dropdown-item" href="../users/staffhomepage.php">View as Teacher</a>
            <a class="dropdown-item" href="#">View as boarding master </a>
           
          </div>
      </li>
        
       <li class="nav-item dropdown">
                  <div class="form-inline"><!--what if th user does not have an image?-->
                  <img src="<?=((isset($logged_in_user_data['image'])&& $logged_in_user_data['image'] !='' ? $logged_in_user_data['image']:'../school_images/hillstoplogo.png'))?>" style="height: 30px; border-radius:50%;"alt=" <?=$logged_in_user_data['midname'];?>">
                  
                <a class="nav-link dropdown-toggle" href="#" id="navbarDropdown" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false" style="color:white;">
                    Hello <?=$logged_in_user_data['midname'];?>
                </a>
                <div class="dropdown-menu" aria-labelledby="navbarDropdown">
                  <a class="dropdown-item" href="../admin/changepassword.php"><i class="fas fa-key"></i></i> Change Password</a>
                  <a href="../admin/updateprofile.php" class="dropdown-item"><i class="fas fa-user-edit"></i> Update profile.</a>
                  <a href="../admin/logout.php" class="dropdown-item"><i class="fa fa-sign-out-alt fa-1x"></i> Log Out</a>
                </div>              
                </div>
           </li>
    </ul>    

  </div>
  </div>
</nav>


<?php
$permissions=array('Admin',"Secretary",'Boarding');//permissions allowed
$userPermission = $logged_in_user_data['permissions'];//current user permission
if(!in_array($userPermission,$permissions,true)){
  header("Location:../login.php");
}
?>


<script>
setInterval(() => {
  setTimeout(() => {
    jQuery('.expiryMessage').fadeOut();
  }, 3000);
jQuery('.expiryMessage').fadeIn();
}, 4000);

</script>
