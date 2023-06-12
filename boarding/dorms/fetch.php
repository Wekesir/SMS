<?php
require_once $_SERVER['DOCUMENT_ROOT'].'/school/core/init.php';
global $db;
$count=1;
$dormId = clean($_POST['dormId']);
if(isset($_POST['studentName']) && !empty($_POST['studentName'])){
    $studentName = clean($_POST['studentName']);

    ob_start();
    $students=$db->query("SELECT * FROM students WHERE deleted=0 AND accomplished=0 AND stdname LIKE '%".$studentName."%' ORDER BY stdname");

    if(mysqli_num_rows($students) > 0){

        while( $student_data=mysqli_fetch_array($students)) :
                                    ?>

                                        <tr>
                                            <td class="text-center"><?=$count;?></td>                             
                                            <td><?=$student_data['registration_number'];?></td>
                                            <td><?=$student_data['stdname'];?></td>        
                                            <td id="captainColn">
                                                <a href="dorms.php?dormId=<?=$dormId;?>&setCaptain=<?=$student_data['id']?>">
                                                    <input type="radio"> Select 
                                                </a>                                                 
                                            </td>
                                            <td id="assCaptainColn">
                                                <a href="dorms.php?dormId=<?=$dormId;?>&setassCaptain=<?=$student_data['id']?>">
                                                    <input type="radio"> Select 
                                                </a>                                                 
                                            </td>
                                        </tr>

                                    <?php
                                        $count++;
                                        endwhile;

    }else{
        echo '<label class="text-danger" style="font-size:14px;"><b>Oops!</b> No data found.</label>';
    }
                                        
                                    

}else if(isset($_POST['studentName']) && empty($_POST['studentName'])){


    $students=$db->query("SELECT * FROM students WHERE deleted=0 AND accomplished=0 ORDER BY stdname");
                                        while( $student_data=mysqli_fetch_array($students)) :
                                    ?>

                                        <tr>
                                            <td class="text-center"><?=$count;?></td>                             
                                            <td><?=$student_data['registration_number'];?></td>
                                            <td><?=$student_data['stdname'];?></td>        
                                            <td id="captainColn">
                                                <a href="dorms.php?dormId=<?=$dormId;?>&setCaptain=<?=$student_data['id']?>">
                                                    <input type="radio"> Select 
                                                </a>                                                 
                                            </td>
                                            <td id="assCaptainColn">
                                                <a href="dorms.php?dormId=<?=$dormId;?>&setassCaptain=<?=$student_data['id']?>">
                                                    <input type="radio"> Select 
                                                </a>                                                 
                                            </td>
                                        </tr>

                                    <?php
                                        $count++;
                                        endwhile;
echo ob_get_clean();

}
?>