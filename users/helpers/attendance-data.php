<?php
require_once $_SERVER['DOCUMENT_ROOT'].'/school/core/init.php'; // database connection

$todayDate = date('Y-m-d');
ob_start(); 

function getUser($id){//this function echos out the name of the person that marked the register
    global $db;
    $userQuery=$db->query("SELECT name FROM users WHERE id='$id'");
    $name = mysqli_fetch_array($userQuery);
    return $name['name'];
}

$attendanceQuery = $db->query("SELECT * FROM `studentattendance` ORDER BY id DESC");
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
    </div>
    <div id="footer">
        Marked By: <?=getUser($queryData['inserted_by'])?>
    </div>
</div>

<?php
endwhile;
$db->close();
echo ob_get_clean();?>

<style>
#viewAttendanceDiv{
    width:100%;
    height:60vh;
    padding: 5px;
    margin-top:10px; 
    margin-bottom:10px;
    border:1px solid lightgrey;
    box-shadow: 0 4px 8px 0 rgba(0, 0, 0, 0.2), 0 6px 20px 0 rgba(0, 0, 0, 0.19);
}
#viewAttendanceDiv >#header{
    position:relative;
    background: #f8f8f8;
    padding: 2px;
    width: 100%;
    height: 5vh;
    border: 1px solid #f8f8f8;
}
#viewAttendanceDiv >#body{
    position:relative;
    background: white;
    padding: 2px;
    width: 100%;
    height: 48vh;
    border: none;
    overflow:auto;
}
#viewAttendanceDiv >#footer{
    position:relative;
    background: #f8f8f8;
    padding: 2px;
    width: 100%;
    height: 5vh;
    border: 1px solid #f8f8f8;
}
#viewAttendanceDiv >#body>#editAttendanceDiv{
    position:absolute;
    width: 140px;
    height: 30px;
    border-radius: 10%;
    right: 1%;
    bottom: 6%;
    background-color: #0275d8;
    color: white;
    padding: 2px;
    text-align:center;
    margin-top: auto;
    margin-bottom: auto;
    font-size: 14px;
}
#viewAttendanceDiv >#body>#editAttendanceDiv a{
    color: #ffff;
}
</style>