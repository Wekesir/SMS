<?php
require_once $_SERVER['DOCUMENT_ROOT'].'/school/core/init.php';
//check wheter the user has logged iin
if(isset($_SESSION['PARENT_LOGIN_STUDENT_ID'])):
  //decrypt the session to get the student ID
  $decryptedId  = (int)base64_decode($_SESSION['PARENT_LOGIN_STUDENT_ID']);
  $studentQuery = $db->query("SELECT * FROM `students` WHERE `id`='{$decryptedId}'");
  //check if the id still exists or has changed
  if(mysqli_num_rows($studentQuery)==0):
    header('Location: ../login.php');
  else:
    $studentData = mysqli_fetch_array($studentQuery);
  endif;
else:
//if the user has not been logged in then redirect them to the login page
header('Location: ../login.php');
endif;
?>
<!--NAVBAR-->
<nav class="navbar navbar-expand-lg themeColor">
  <button class="navbar-toggler" style="color:white;border-color:white;" type="button" data-toggle="collapse" data-target="#navbarTogglerDemo03" aria-controls="navbarTogglerDemo03" aria-expanded="false" aria-label="Toggle navigation">
   <i class="fas fa-bars" style="color:#fff; font-size:20px;"></i>
  </button>
  
  <a class="navbar-brand" style="color:white;" href="../portal/index.php"><?=cutstring($configurationData['school_name'],20);?> Portal.</a>

  <div class="collapse navbar-collapse" id="navbarTogglerDemo03">
    <ul class="navbar-nav mr-auto mt-2 mt-lg-0">
      <li class="nav-item active">
        <a class="nav-link" href="#">Home <span class="sr-only">(current)</span></a>
      </li>
      <li class="nav-item">
        <a class="nav-link" href="#">Link</a>
      </li>
      <li class="nav-item">
        <a class="nav-link disabled" href="#" tabindex="-1" aria-disabled="true">Disabled</a>
      </li>
    </ul>
  </div>
  <ul class="navbar-nav ml-auto mt-2 mt-lg-0">
      <li class="nav-item dropdown mr-5">
        <a class="nav-link dropdown-toggle" href="#" id="navbarDropdownMenuLink" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
          Welcome
        </a>
        <div class="dropdown-menu" style="position:absolute;" aria-labelledby="navbarDropdownMenuLink">
          <a class="dropdown-item" href="../portal/changepassword.php"><i class="fas fa-key"></i></i> Change Password</a>
          <a href="../admin/updateprofile.php" class="dropdown-item"><i class="fas fa-user-edit"></i> Update profile.</a>
          <a href="../admin/logout.php" class="dropdown-item"><i class="fa fa-sign-out-alt fa-1x"></i> Log Out</a>
        </div>
        </li>
    </ul>
</nav>