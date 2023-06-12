<div class="dashboard_wrapper small_font">

  <div class="imageDiv text-center">
  <img src="<?=((isset($logged_in_user_data['image'])&& $logged_in_user_data['image'] !='' ? $logged_in_user_data['image']:'../school_images/hillstoplogo.png'))?>" style="height: 80px;width: 80px; border-radius:50%;border:2px solid white;"alt=" <?=$logged_in_user_data['midname'];?>">
  <h6 style="color:white;padding: 10px;"><?=$logged_in_user_data['username'];?>   <a href="updateprofile.php" style="color:white;"><i class="fas fa-pencil-alt"></i></a></h6>
  </div>


<ul class="nav flex-column">
  <li class="nav-item">
    <a class="nav-link active" href="#">
      <i class="fas fa-home"></i> Teachers Portal Dashboard
    </a>
  </li>
  <li class="nav-item dropdown">
     <a class="nav-link dropdown-toggle dropdown-toggle1" data-toggle="dropdown" href="#" role="button" aria-haspopup="true" aria-expanded="false">  <i class="fas fa-user-graduate"></i>  My Students</a>
    <div class="dropdown-menu" id="sidenavdropdown1">
      <?php 
      $levelsArray = explode(',',rtrim($logged_in_user_data['class_assigned'],','));
      $arrayLen = count($levelsArray);
      for($x=0;$x<$arrayLen;$x++):?>
      <a class="dropdown-item" href="/school/users/mystudents.php?level=<?=encodeURL($levelsArray[$x]);?>"> <?=$levelsArray[$x];?> </a>
      <?php endfor;?>
    </div>
  </li>
  <li class="nav-item dropdown">
     <a class="nav-link dropdown-toggle dropdown-toggle2" data-toggle="dropdown" href="#" role="button" aria-haspopup="true" aria-expanded="false">  <i class="fas fa-user-graduate"></i> Daily Register</a>
    <div class="dropdown-menu" id="sidenavdropdown2">
      <?php 
      $levelsArray = explode(',',rtrim($logged_in_user_data['class_assigned'],','));
      $arrayLen = count($levelsArray);
      for($x=0;$x<$arrayLen;$x++):?>
      <a class="dropdown-item" href="/school/users/register.php?level=<?=$levelsArray[$x];?>"> <?=$levelsArray[$x];?> </a>
      <?php endfor;?>
    </div>
  </li>
   <li class="nav-item">
    <a class="nav-link" href="../users/students.php">
      <i class="fas fa-user-graduate"></i>  All Students
    </a>
  </li>
  <li class="nav-item">
    <a class="nav-link" href="../users/staff.php">
      <i class="fas fa-users"></i> Staff
    </a>
  </li>
   <li class="nav-item">
    <a class="nav-link" href="../users/performance.php">
      <i class="fas fa-poll"></i> Performance
    </a>
  </li>
  <li class="nav-item">
    <a class="nav-link" href="../users/myfinance.php">
      <i class="fas fa-coins"></i> My Finance
    </a>
  </li>
  <li class="nav-item">
    <a class="nav-link" href="../users/books.php">
      <i class="fas fa-book"></i> Books
    </a>
  </li>
   <li class="nav-item">
    <a class="nav-link" href="../users/trial.php">
      <i class="fas fa-users"></i> Trial
    </a>
  </li>
  <li class="nav-item">
    <a class="nav-link" href="../users/complains.php">
      <i class="fas fa-users"></i> Complaints
    </a>
  </li>
   <li class="nav-item">
    <a class="nav-link" href="#">
      <i class="far fa-calendar-alt"></i> News & Events
    </a>
  </li> 
</ul>
<label style="position:absolute;bottom: 1px;color:white;text-align:center;font-size: 10px;">&copy; Wekesir system(s) <?=date('Y');?> All rights reserved.</label>
</div>
<style>
  #sidenavdropdown1{
  position:absolute;
  display:none;
  background:#f7f7f7;
}
#sidenavdropdown1.active{
  display:block;
  background-color:#f7f7f7;
}
 #sidenavdropdown1 a{
  color:black;
  font-size: 12px;
}
#sidenavdropdown1 a:hover{
  background-color:#0275d8;
  color:white;
}
#sidenavdropdown2{
  position:absolute;
  display:none;
  background:#f7f7f7;
}
#sidenavdropdown2.active{
  display:block;
  background-color:#f7f7f7;
}
 #sidenavdropdown2 a{
  color:black;
  font-size: 12px;
}
#sidenavdropdown2 a:hover{
  background-color:#0275d8;
  color:white;
}
</style>
<script>
$('.dropdown-toggle1').click(function(e){
  e.preventDefault();
  jQuery('#sidenavdropdown1').toggleClass('active');
});
$('.dropdown-toggle2').click(function(e){
  e.preventDefault();
  jQuery('#sidenavdropdown2').toggleClass('active');
});
</script>

