<?php require_once $_SERVER['DOCUMENT_ROOT'].'/school/core/init.php';
     include 'includes/header.php';
?>

<!--NAVBAR-->
<nav class="navbar navbar-expand-lg navbar-fixed-top">
  <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarTogglerDemo03" aria-controls="navbarTogglerDemo03" aria-expanded="false" aria-label="Toggle navigation">
    <span class="navbar-toggler-icon"></span>
  </button>
  <a class="navbar-brand" href="index.php">HILLSTOP ACADEMY</a>

  <div class="collapse navbar-collapse" id="navbarTogglerDemo03">
    <ul class="navbar-nav mr-auto mt-2 mt-lg-0">
      <li class="nav-item active" id="list">
        <a class="nav-link homeNav" href="index.php">Home</a>
      </li>
      <li class="nav-item" id="list">
        <a class="nav-link scroll" href="index.php#about_us">About us</a>
      </li>
      <li class="nav-item" id="list">
        <a class="nav-link scroll" href="index.php#contact_us" >Contact us</a>
      </li>
      <li class="nav-item dropdown" id="list_dropdown">
        <a class="nav-link dropdown-toggle" href="#" id="navbarDropdownMenuLink" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
         Fees
        </a>
        <div class="dropdown-menu" aria-labelledby="navbarDropdownMenuLink">
          <a class="dropdown-item" id="dropdown_item" onclick="showfees()" href='#'>View Fees</a>
          <a class="dropdown-item" id="dropdown_item" href="/school/documents/school/Admission Form.pdf">Download fees structure</a>
        </div>
        </li>
       <li class="nav-item dropdown" id="list_dropdown">
        <a class="nav-link dropdown-toggle" href="#" id="navbarDropdownMenuLink" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
          Admissions
        </a>
        <div class="dropdown-menu" aria-labelledby="navbarDropdownMenuLink">
          <a class="dropdown-item" id="dropdown_item" href="applicationform.php">Online application</a>
          <a class="dropdown-item" id="dropdown_item" href="/school/documents/school/Admission Form.pdf">Download application form</a>
        </div>
        </li>
        <li class="nav-item" id="list">
          <a class="nav-link scroll" href="index.php#gallery" >Our Gallery</a>
        </li>
    </ul>    
  </div><!--CLosing tag for the navbarTogglerDemo03 div -->
    <ul class="navbar-nav ml-auto mt-2 mt-lg-0">       
        <li class="nav-item">
            <a class="nav-link" href="#" >
                <button id="loginBtn" onclick="openLogin()">
                    <i class="far fa-user"></i> Login
                </button>
            </a>
         </li>
      </ul>
</nav>