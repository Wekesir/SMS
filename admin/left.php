
<div id="dash_wrapper" class="small_font" style="width:100%;">
<ul class="nav flex-column">
  <li class="nav-item">
    <a class="nav-link active" href="index.php">
      <i class="fas fa-home"></i> &nbsp; Admin Dashboard
    </a>
  </li>
  <li class="nav-item">
    <a class="nav-link" href="../admin/students.php">
      <i class="fas fa-user-graduate"></i> &nbsp; Students
    </a>
  </li>
  <li class="nav-item">
    <a class="nav-link" href="../admin/staff.php">
      <i class="fas fa-users"></i> &nbsp; Staff
    </a>
  </li>
  <li class="nav-item">
    <a class="nav-link" href="/school/admin/finance.php">
      <i class="fas fa-coins"></i> &nbsp; Student Fees Management
    </a>
  </li>
  <li class="nav-item">
    <a class="nav-link" href="/school/admin/salaries.php">
      <i class="fas fa-coins"></i> &nbsp; Salaries
    </a>
  </li>
   <li class="nav-item">
    <a class="nav-link" href="/school/admin/emails.php">
      <i class="fas fa-coins"></i> &nbsp; Emails
    </a>
  </li>
   <li class="nav-item">
    <a class="nav-link" href="/school/admin/expenditure.php">
      <i class="fas fa-coins"></i> &nbsp;  Expenditure
    </a> 
  </li>
   <li class="nav-item">
    <a class="nav-link" href="/school/admin/subjects.php">
      <i class="fas fa-book-reader"></i> &nbsp;  Subjects Management
    </a> 
  </li>
  <li class="nav-item">
    <a class="nav-link" href="/school/admin/timetable.php">
      <i class="fas fa-calendar"></i> &nbsp;  Timetable Management
    </a> 
  </li>
   <?php if($configurationData['food'] == 'YES'){?>
  <li class="nav-item">
    <a class="nav-link" href="/school/admin/food-prog.php">
      <i class="fas fa-utensils"></i> &nbsp; Food Programme
    </a>
  </li>
   <?php }?>
  <li class="nav-item">
    <a class="nav-link" href="/school/admin/contacts.php">
      <i class="fas fa-address-book"></i> &nbsp;  Contacts Management
    </a>
  </li>
   <?php if($configurationData['transport'] == 'YES'){?>
  <li class="nav-item">
    <a class="nav-link" href="/school/admin/fleet.php">
      <i class="fas fa-bus"></i> &nbsp; Fleet Management
    </a>
  </li>
   <?php }?>
  <li class="nav-item">
    <a class="nav-link" href="/school/admin/banks.php">
      <i class="fas fa-coins"></i> &nbsp;  Banks
    </a>
  </li>
  <li class="nav-item">
    <a class="nav-link" href="/school/admin/dates.php">
      <i class="far fa-calendar-alt"></i> &nbsp; Term Dates
    </a>
  </li>
  <li class="nav-item">
    <a class="nav-link" href="../admin/books.php">
      <i class="fas fa-book"></i> &nbsp; Books
    </a>
  </li>
  <li class="nav-item">
    <a class="nav-link" href="../admin/schooldocuments.php">
      <i class="fas fa-file-alt"></i> &nbsp;   School Documents
    </a>
  </li> 
  <li class="nav-item">
    <a class="nav-link" href="../admin/applications.php">
      <i class="fas fa-file-alt"></i> &nbsp;  Online Applications
      <span class="badge label-pill badge-success notifications_count"></span>
    </a>
  </li>  
  <li class="nav-item">
    <a class="nav-link" href="/school/message_admin/index.php">
      <i class="fas fa-comment-dots"></i> &nbsp;  Messages
    </a>
  </li> 
   <li class="nav-item">
    <a class="nav-link" href="complains.php">
      <i class="fas fa-comment-dots"></i> &nbsp;  Complains
      <span class="badge label-pill badge-success complains_count"></span>
    </a>
  </li> 
  <li class="nav-item">
    <a class="nav-link" href="gallery.php">
      <i class="far fa-images"></i></i> &nbsp; Gallery Images
    </a>
  </li> 
  <li class="nav-item">
    <a class="nav-link" href="siteimages.php">
      <i class="far fa-images"></i></i> &nbsp;  Website Images
    </a>
  </li> 
   <li class="nav-item">
    <a class="nav-link" href="events.php">
      <i class="far fa-calendar-alt"></i> &nbsp; News & Events
    </a>
  </li> 
   <li class="nav-item"> 
    <a class="nav-link" href="access.php">
      <i class="fas fa-shield-alt"></i> &nbsp; Permissions & Access Levels
    </a>
  </li> 
  <li class="nav-item">
    <a class="nav-link" href="/school/admin/configuration.php">
      <i class="fas fa-cog"></i> &nbsp; System Configuration
    </a>
  </li> 
  <li class="nav-item">
    <a class="nav-link" href="/school/admin/system-payments.php">
      <i class="fas fa-cog"></i> &nbsp; System Payments
    </a>
  </li>
  <?php if($logged_in_user_data['permissions'] == 'Super_Admin'){?>
  <li class="nav-item">
    <a class="nav-link" href="/school/core/database.php">
      <i class="fas fa-server"></i> &nbsp; Database Operations
    </a>
  </li>
  <?php }?>
</ul>
</div> 

<!-- <script>
  //when the sidenav has been clicked
  var sidenav = jQuery("#dash_wrapper");//this is the sidenav container
  //sidenav LI
  sidenav.find(".nav-item").click(function(e){
    e.preventDefault(); //prevents the sidenav from reloading the new page
    var tabURL = $(this).find(".nav-link").attr("href");// finds the URL of the limk
    window.history.pushState('', '', tabURL); //push this to the URL
  });
</script> -->