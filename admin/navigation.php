<?php require_once dirname(__DIR__).'/core/init.php';

   if(!logged_in()){
            not_logged_in_page_redirect();
        }
?>
<nav class="navbar navbar-expand-lg navbar-static theme_color">
  <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarTogglerDemo03" aria-controls="navbarTogglerDemo03" aria-expanded="false" aria-label="Toggle navigation">
    <span class="navbar-toggler-icon"></span>
  </button>
  <a class="navbar-brand" href="index.php"><?=$configurationData['school_name'];?></a>
  <div class="collapse navbar-collapse" id="navbarTogglerDemo03">      
    <ul class="navbar-nav ml-auto" >   
        <?php  // this label only appeRS WHEN SOMEONE IS LOGGED IN AS A SUPER ADMIN
          if($logged_in_user_data['permissions']=='Super_Admin'){
            ?>       
        <li class="nav-item">
        <a style="color:white;" class="nav-link" href="/school/users/mystudents.php"><i class="fas fa-chalkboard-teacher"></i>View Teacher's Portal.</a>
       </li>
        <?php 
        }
        ?>  
       <li class="nav-item dropdown">
          <a class="nav-link dropdown-toggle" style="color:white;" href="#" id="navbarDropdown" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
            Tools
          </a>
          <div class="dropdown-menu" aria-labelledby="navbarDropdown">
            <a class="dropdown-item" href="/school/admin/calendar.php"><i class="far fa-calendar-alt"></i> Calendar</a>
            <a class="dropdown-item" href="#" id="navweather"><i class="fas fa-cloud-sun"></i> Weather</a>
            <a class="dropdown-item" href="http://nemis.education.go.ke/Login.aspx" ><i class="fas fa-flag"></i> NEMIS</a>
        </li>     
        <li class="nav-item dropdown">
          <a class="nav-link dropdown-toggle" style="color:white;" href="#" id="navbarDropdownMenuLink" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
            Views
          </a>
          <div class="dropdown-menu" aria-labelledby="navbarDropdownMenuLink">
            <a class="dropdown-item" href="/school/users/mystudents.php">View as Teacher</a>
            <?php if($configurationData['system_type'] =='BOARDING'){?>
            <a class="dropdown-item" href="/school/boarding/index.php"> View boarding department </a>
            <?php }?>

             <a class="dropdown-item" href="/school/store/index.php">View Store. </a>

            <?php if($logged_in_user_data['permissions']=='Super_Admin' || $logged_in_user_data['permissions']=='Admin') {?>
                 <a class="dropdown-item" href="../admin/index.php">View as Admin </a>
            <?php }?>
          </div>
      </li>        
       <li class="nav-item dropdown mr-4">
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
</nav>
