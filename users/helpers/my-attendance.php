<?php
require_once $_SERVER['DOCUMENT_ROOT'].'/school/core/init.php'; // database connection

$todayDate = date('Y-m-d');
$userId    = (int)$_SESSION['user'];//this is the id of logged in user 

$attendanceQuery = $db->query("SELECT * FROM `studentattendance` WHERE inserted_by='$userId' ORDER BY id DESC");
if(mysqli_num_rows($attendanceQuery) == 0){//checks to see whether user data exists
    $into[].='<b>Oops! </b>No records relating to you were found.';
    echo displayInfo($info);
}
while($queryData = mysqli_fetch_array($attendanceQuery)):
$attendance_dec  = json_decode($queryData['attendance'],true);
?>

<div id="viewAttendanceDiv">
    <div id="header">
        <label>Date: <b> <?=$queryData['date'];?> <?=', '. date('D',strtotime($queryData['date']))?> </b> </label>
        <label class="float-right">Level: <b> <?=$queryData['student_level'];?> </b> </label>
    </div>
    <div id="body">
        <table class="table-striped table-bordered" style="width:100%">
            <thead>
                <th>#</th>
                <th>REG. NUMBER</th>
                <th>NAME</th>
                <th>STATUS</th>
            </thead>
            <tbody>
                <?php
                    $count = 1;
                    foreach($attendance_dec as $x){                        
                        $id=(int)$x['Id'];
                        $studentData = mysqli_fetch_array($db->query("SELECT stdname, registration_number FROM students WHERE id='$id'"));                    
                        ?>
                       <tr>
                           <td><?=$count;?></td>
                           <td><?=$studentData['registration_number'];?></td>
                           <td><?=$studentData['stdname'];?></td>
                           <td><label class="<?php if($x['Status'] == 'present'){echo 'text-success';}else{echo 'text-danger';}?>"><?=$x['Status']?></label></td>
                       </tr>    
                    <?php
                    $count++;    
                }
                ?>               
            </tbody>
        </table>
        <div id="editAttendanceDiv"><a href="#" id="editAttendanceBtn" data-entryId="<?=$queryData['id']?>"><i class="fas fa-pencil-alt"></i> edit attendance.</a></div>
    </div>
    <div id="footer">
        Marked By: YOU
    </div>
</div>

<?php endwhile; ?>