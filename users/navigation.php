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
  <a class="navbar-brand" href="../users/staffhomepage.php"><?=$configurationData['school_name'];?></a>

  <div class="collapse navbar-collapse" id="navbarTogglerDemo03">
      
    <ul class="navbar-nav ml-auto">

     <?php  // this label only appeRS WHEN SOMEONE IS LOGGED IN AS A SUPER ADMIN
          if($logged_in_user_data['permissions']=='Admin' || $logged_in_user_data['permissions']=='Super_Admin'){
            ?>       
            <li class="nav-item">
              <a style="color:white;" class="nav-link" href="../admin/index.php"><i class="fas fa-user-shield"></i>View as Admin.</a>
          </li>
        <?php 
        }
        ?>
        <li class="nav-item dropdown">
          <a class="nav-link dropdown-toggle" style="color:white;" href="#" id="navbarDropdownMenuLink" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
            Views
          </a>
          <div class="dropdown-menu bg-light" aria-labelledby="navbarDropdownMenuLink">
           <?php if($configurationData['system_type'] =='BOARDING' && $logged_in_user_data['permissions']!='General User'){?>
            <a class="dropdown-item" href="../boarding/index.php">View boarding department </a>
            <?php }?>
            <?php if($logged_in_user_data['permissions']=='Super_Admin' || $logged_in_user_data['permissions']=='Admin') {?>
                 <a class="dropdown-item" href="../admin/index.php"> <i class="fas fa-user-shield"></i> View as Admin </a>
            <?php }?>
          </div>
      </li>

       <li class="nav-item dropdown">
                  <div class="form-inline">                
                  
                <a class="nav-link dropdown-toggle" href="#" id="navbarDropdown" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                Hello <?=$logged_in_user_data['midname'];?>
                </a>
                <div class="dropdown-menu bg-light" aria-labelledby="navbarDropdown">
                  <a class="dropdown-item" href="../users/changepassword.php"><i class="fas fa-key"></i> Change Password</a>
                  <a href="updateprofile.php" class="dropdown-item"><i class="fas fa-user-edit"></i> Update profile.</a>
                  <a href="../users/logout.php" class="dropdown-item"><i class="fa fa-sign-out-alt fa-1x"></i>  Log Out</a>
                </div>              
                </div>
           </li>
    </ul>
  </div>
  </div>
</nav>
