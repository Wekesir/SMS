<?php
require_once $_SERVER['DOCUMENT_ROOT'].'/school/core/init.php';
global $db;
$count = 1;

//assigning student dorm
if(isset($_POST['insertStudentId']) && $_POST['insertStudentId'] >0){
    $studentId = (int)clean($_POST['insertStudentId']);
    //check if the dorm id has been set as well
    if(isset($_POST['dormId']) && $_POST['dormId'] >0){
        $dormId = (int)clean($_POST['dormId']);
       
    }
}

//autocomplete student names
if(isset($_POST['student_name']) && $_POST['student_name'] != ''){
    $fetch_name=clean($_POST['student_name']);   
    $dormId = (int)$_POST['dormId'];
    $query=$db->query("SELECT * FROM students WHERE stdname LIKE '%".$fetch_name."%'");
            ob_start();?>
            <table class="table-striped table-bordered studentTable" style="width:100%; padding:5px;font-size:14px;">
                <thead>
                    <th></th>
                    <th>REG. NUMBER</th>
                    <th>STUDENT NAME</th>
                    <th>LEVEL</th>
                    <th>SELECT</th>
                </thead>
                </tbody>
                    <?php  while($queryData=mysqli_fetch_array($query)) :  ?>      
                         <tr>
                            <td class="text-center"><?=$count;?></td>                             
                            <td><?=$queryData['registration_number'];?></td>
                            <td><?=$queryData['stdname'];?></td>
                            <td><?=$queryData['stdgrade'];?></td>
                            <td>
                                <a href="dorms.php?dormId=<?=$dormId?>&add=1&selectStudent=<?=$queryData['id']?>">
                                    <input type="radio" <?php if($queryData['dorm']!=''&& $queryData['dorm']==$dormId){echo 'checked';}?>>
                                    <?php if($queryData['dorm']!=''&& $queryData['dorm']==$dormId){echo 'Member';}else{echo 'Select';}?>
                                </a>
                            </td>
                        </tr>
                    <?php  
                    $count++;
                endwhile; ?>
                </tbody>
            </table>
            <?php echo ob_get_clean();

}else if(isset($_POST['student_name']) && $_POST['student_name'] == ''){

    $count=1;
    $dormId = (int)$_POST['dormId'];
    $query=$db->query("SELECT * FROM students WHERE deleted=0 AND accomplished=0 ORDER BY stdname");
    ob_start(); ?>

    <table class="table-striped table-bordered" style="width:100%; padding:5px;font-size:14px;">
        <thead>
            <th></th>
            <th>REG. NUMBER</th>
            <th>STUDENT NAME</th>
            <th>LEVEL</th>
            <th>SELECT</th>
        </thead>
        </tbody>
            <?php  while($queryData=mysqli_fetch_array($query)) :  ?>      
                <tr>
                    <td class="text-center"><?=$count;?></td>                             
                    <td><?=$queryData['registration_number'];?></td>
                    <td><?=$queryData['stdname'];?></td>
                    <td><?=$queryData['stdgrade'];?></td>
                    <td>
                        <a href="dorms.php?dormId=<?=$dormId?>&add=1&selectStudent=<?=$queryData['id']?>">
                            <input type="radio" <?php if($queryData['dorm']!=''&& $queryData['dorm']==$dormId){echo 'checked';}?>>
                            <?php if($queryData['dorm']!=''&& $queryData['dorm']==$dormId){echo 'Member';}else{echo 'Select';}?>
                        </a>
                    </td>
                </tr>
            <?php  
                    $count++;
                endwhile; ?>
        </tbody>
    </table>

    <?php
    echo ob_get_clean();
}



if(isset($_POST['asscaptainstudentId']) && $_POST['asscaptainstudentId'] >0){

    $asscaptainstudentId = (int)$_POST['asscaptainstudentId'];

        if(isset($_POST['dormId']) && $_POST['dormId'] >0){

            $dormId = (int)$_POST['dormId'];
            
            $db->query("UPDATE dorms SET dorm_captain='$asscaptainstudentId' WHERE id='$dormId'");//sets the dorm assiatnt captain
           
        }

}

if(isset($_POST['studentId']) && $_POST['studentId'] >0){

    $studentId = (int)$_POST['studentId'];

        if(isset($_POST['dormId']) && $_POST['dormId'] >0){

            $dormId = (int)$_POST['dormId'];
            
            $db->query("UPDATE dorms SET dorm_captain='$studentId' WHERE id='$dormId'");//sets the dorm matron
           
        }

}


if(isset($_POST['staffId']) && $_POST['staffId'] >0){

    $staffId = (int)$_POST['staffId'];

        if(isset($_POST['dormId']) && $_POST['dormId'] >0){

            $dormId = (int)$_POST['dormId'];
            
            $db->query("UPDATE dorms SET dorm_matron='$staffId' WHERE id='$dormId'");//sets the dorm matron
           
        }

}
?>