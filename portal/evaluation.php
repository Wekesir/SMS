<?php 
include '../portal/header.php';
require_once $_SERVER['DOCUMENT_ROOT'].'/school/core/init.php';
include '../portal/navigation.php';?>
<div class="container-fluid">
    <div class="row">
        <div class="col-md-3">
        <?php include '../portal/sidenav.php';?>
        </div>
        <div class="col-md-9 mainContainer">
            <h5>Student Evaluation.</h5>
            <?php
                //decrypt the session to get the student ID
                $decryptedId  = (int)base64_decode($_SESSION['PARENT_LOGIN_STUDENT_ID']);
                $gradeQuery   = $db->query("SELECT * FROM `student_grades` WHERE `student_id`='$decryptedId' ORDER BY `id`");
                //check if there are any results from the equery
                if(mysqlI_num_rows($gradeQuery) == 0):
                    $info[].='<b>Oops!</b> No student evaluation has been found for this student';
                    displayInfo($info);
                else:
                    //check if the view button has been clicked
                    if(isset($_REQUEST['view'])):
                        include 'view-evaluation.php';
                    else:
                        $rowCount=1;
                ?>
                       
                        <table class="table table-bordered">
                            <thead class="thead-light">
                                <tr>
                                <th scope="col">#</th>
                                <th scope="col">LEVEL</th>
                                <th scope="col">PERIOD</th>
                                <th scope="col">TEACHER</th>
                                <th scope="col">DATE</th>
                                <th></th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php while($evaluationData = mysqli_fetch_array($gradeQuery)) :?>
                                <tr>
                                <th scope="row"><?=$rowCount?></th>
                                <td><?=$evaluationData['current_grade']?></td>
                                <td><?=$evaluationData['period']?></td>
                                <td><?=getTeacherName($evaluationData['entered_by'])?></td>
                                <td><?=$evaluationData['entry_date']?></td>
                                <td> <a href="<?=$_SERVER['PHP_SELF'].'?view='.encodeURL($evaluationData['id'])?>">view  <i class="fas fa-arrow-right"></i></a> </td>
                                </tr>
                            <?php $rowCount++; endwhile;?>
                            </tbody>
                        </table>
                <?php
                    endif;
                endif;
                //function for getting the techer name 
                function getTeacherName($id){
                    global $db;
                    $teacherQuery = $db->query("SELECT `name` FROM `users` WHERE `id`='{$id}'");
                    $teacherData  = mysqli_fetch_array($teacherQuery);
                    return $teacherData['name'];
                    $db->close();
                }
            ?>
        </div>
    </div>
</div>
<?php include '../portal/footer.php';?>