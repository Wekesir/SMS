<!DOCTYPE html>
<html>
<head>
   <?php 
   require_once $_SERVER['DOCUMENT_ROOT'].'/school/core/init.php';
   include '../users/header.php';
   $count=1;
   ?>
   <style>
   #registerDiv{
       position:relative;
       /* left: 5%; */
       width: 100%;
       padding: 10px;
       height: 90vh;
       overflow:auto;
       background: white;
   }
   </style>
</head>
<body>
<?php  include '../users/navigation.php';?>

<div class="container-fluid">

<div class="row">

<div class="col-md-3">
    <?php include '../users/left.php';?>
</div> <!--closing col-md-3 div-->

<div class="col-md-9 bg-light" id="wrapper">
    <div id="registerDiv">
        <nav>
            <div class="nav nav-tabs" id="nav-tab" role="tablist">
              <a class="nav-item nav-link active" id="nav-home-tab" data-toggle="tab" href="#nav-home" role="tab" aria-controls="nav-home" aria-selected="true">Mark Register</a>
              <a class="nav-item nav-link" id="nav-addmarks-tab" data-toggle="tab" href="#nav-view" role="tab" aria-controls="nav-profile" aria-selected="false">View All Attendance</a>
              <a class="nav-item nav-link" id="nav-addmarks-tab" data-toggle="tab" href="#nav-viewmy" role="tab" aria-controls="nav-profile" aria-selected="false">View my Register</a>
              <a class="nav-item nav-link" id="nav-addmarks-tab" data-toggle="tab" href="#nav-edit" role="tab" aria-controls="nav-profile" aria-selected="false">Edit Register</a>
            </div>
        </nav>
          <div class="tab-content" id="nav-tabContent">
            <div class="tab-pane fade show active" id="nav-home" role="tabpanel" aria-labelledby="nav-home-tab">
                <div id="notificationsDiv"></div>
                <form action="<?=$_SERVER['PHP_SELF']?>" method="POST">
                    <table class="table table-striped table-bordered" style="width: 100%;">
                        <thead>
                            <th>#</th>
                            <th>REG. NO</th>
                            <th>STUDENT NAME</th>
                            <th>ATTENDANCE</th>
                        </thead>
                        <tbody>
                            <?php 
                            $myclass  = clean($_GET['level']);
                            $students = $db->query("SELECT * FROM students WHERE deleted=0 AND accomplished=0 AND stdgrade='$myclass' ORDER BY stdname ASC");
                            while( $student_data=mysqli_fetch_array($students)) :?>
                                <tr>      
                                    <td><?=$count;?></td>                              
                                    <td><?=$student_data['registration_number'];?></td>
                                    <td><?=$student_data['stdname'];?></td>
                                    <td> 
                                        <div class="radio">
                                        <label class="radio-inline" for="attendance"><input type="radio" name="<?=$student_data['id'];?>" value="present" <?='checked';?>> Present</label>
                                        <label class="radio-inline" for="attendance"><input type="radio" name="<?=$student_data['id'];?>" value="absent"> Absent</label> 
                                        </div>
                                    </td>
                                </tr>
                            <?php $count++; endwhile; ?>
                             <input type="hidden" name="level" value="<?=$myclass?>">
                        </tbody>
                    </table>
                    <div class="form-group">
                        <input type="submit" name="submit" class="btn btn-md btn-primary" value="Submit">
                    </div>
                </form>                 
            </div><!--closing tabpanel1-->

            <div class="tab-pane fade" id="nav-view" role="tabpanel" aria-labelledby="nav-addmarks-tab">
                <div id="attendanceStatusDiv"></div>
            </div><!--closing tabpanel2-->
            <div class="tab-pane fade" id="nav-viewmy" role="tabpanel" aria-labelledby="nav-addmarks-tab">
                <?php include BASEURL.'/users/helpers/my-attendance.php';?> 
            </div><!--closing tabpanel3-->
            <div class="tab-pane fade" id="nav-edit" role="tabpanel" aria-labelledby="nav-addmarks-tab">
                <?php include BASEURL.'/users/helpers/edit-register.php';?> 
            </div><!--closing tabpanel4-->
          </div>
        
    </div>
</div><!--Closing wrapper div-->
</div><!--closing row div-->
    </div><!--closing container-fluid div-->    
    <?php include '../users/footer.php';?>
</body>
</html>
<script>
jQuery(function(){//when this page is loaded fetch attendace data from another page
   getStudentAttendance();
});

function getStudentAttendance(){
     var attendanceData = '';
    $.ajax({      
        url:'/school/users/helpers/attendance-data.php',
        method:'post',
        data:{attendanceData:attendanceData},
        success:function(data){
          $('#attendanceStatusDiv').html(data);
        },
        error:function(){
            alert("A problem occured trying to mark register");
        }
    }); 
}

jQuery("form").submit(function(event){
    event.preventDefault();   
    var formData = $(this).serialize();
    $.ajax({
        url:'/school/users/helpers/execute-register.php',
        method:'post',
        data: formData,
        success:function(data){
            $('#notificationsDiv').html();
            $('#notificationsDiv').html(data);
            getStudentAttendance();
        },
        error:function(){
            alert("A problem occured trying to mark register");
        }
    });
});

jQuery('#editAttendanceDiv a').click(function(e){//this adds the active class to the edit attendanvce tab
    e.preventDefault();   
    var editId =    $(this).attr("data-entryId");
    document.cookie = "editRegisterId="+editId;
    location.reload(true);
    //  $('#nav-tab a[href="#nav-edit"]').tab('show') // Select tab by name 
     alert("Click on the EDIT REGISTAR tab to edit registar.");
});

</script>

