<?php
require_once $_SERVER['DOCUMENT_ROOT'].'/school/core/init.php';

if(isset($_COOKIE['editRegisterId']) && $_COOKIE['editRegisterId']>0){  
   ?>
   <div id="updNotificationsDiv"></div>
   <form action="<?=$_SERVER['PHP_SELF']?>" method="POST" id="updateRegisterForm">   
        <table class="table table-striped table-bordered" style="width: 100%;">
            <thead>
              <th>#</th>
              <th>REG. NO</th>
              <th>STUDENT NAME</th>
              <th>ATTENDANCE</th>
              <th>DATE</th>
            </thead>
             <tbody>
                <?php
                    $count = 1;
                    $attendanceQuery = $db->query("SELECT * FROM `studentattendance` WHERE inserted_by='$userId' ORDER BY id DESC");
                    $queryData       = mysqli_fetch_array($attendanceQuery);
                    $attendance_dec  = json_decode($queryData['attendance'],true);
                    $students        = $db->query("SELECT * FROM students WHERE deleted=0 AND accomplished=0 AND stdgrade='$myclass' ORDER BY stdname ASC");
                    foreach($attendance_dec as $x){                        
                        $id=(int)$x['Id'];
                        $studentData = mysqli_fetch_array($db->query("SELECT id, stdname, registration_number FROM students WHERE id='$id'"));                    
                        ?>
                       <tr>
                           <td><?=$count;?></td>
                           <td><?=$studentData['registration_number'];?></td>
                           <td><?=$studentData['stdname'];?></td>
                           <td>
                                <div class="radio">
                                <label class="radio-inline" for="attendance"><input type="radio" name="<?=$studentData['id']?>" value="present" <?php if($x['Status']=='present'){echo 'checked';;}?>> Present</label>
                                <label class="radio-inline" for="attendance"><input type="radio" name="<?=$studentData['id']?>" value="absent" <?php if($x['Status']=='absent'){echo 'checked';;}?>> Absent</label> 
                                </div>
                           </td>
                           <td><?=date("jS F, Y", strtotime($queryData['date']))?></td>
                       </tr>    
                    <?php
                    $count++;    
                }
                ?>               
            </tbody>
        </table>
            <div class="form-group">
                <input type="submit" name="submit" class="btn btn-sm btn-primary" value="Update Register">
            </div>
    </form> 
   <?php
}else{
   //this runs when the cookie has not been set
   $info[].='<b>Oops! </b>You have not selected any data to be edited. Please do so then try again.';
   echo displayInfo($info);
}
?>

<script>
    jQuery('#updateRegisterForm').submit(function(e){
        e.preventDefault();
        var formData = $(this).serialize(); 
        $.ajax({
            url:'/school/users/helpers/update-register.php',
            method:'post',
            data: formData,
            success:function(data){
                jQuery('#updNotificationsDiv').html(data);
            },
            error:function(){
                alert("A problem occured trying to edit register");
            }
        });
    });
</script>