<?php
    require_once $_SERVER['DOCUMENT_ROOT'].'/school/core/init.php'; //db connection

    if(isset($_POST['regNumberFilterFees']) && !empty($_POST['regNumberFilterFees'])):
        $regNumber = trim(clean($_POST['regNumberFilterFees']));
        $studentQuery = $db->query("SELECT `students`.`registration_number`,`students`.`stdName`,`students`.`stdgrade`,`fees_account`.`amount`
                                    FROM `students`,`fees_account`
                                    WHERE `students`.`id`=`student_id`
                                    AND `fees_account`.`amount` < 0
                                    AND `registration_number`='$regNumber'");
    elseif(isset($_POST['selectedGrade']) && ($_POST['selectedGrade'])>0):
        $gradeId = (int)clean($_POST['selectedGrade']); //this is the ID for the selected grade 
        if($gradeId=="" || $gradeId == 0)://option for all students
            $studentQuery = $db->query("SELECT students.`registration_number`,students.`stdName`,students.`stdgrade`,fees_account.`amount`
                                            FROM students,`fees_account`
                                            WHERE students.`id`=`student_id`
                                            AND fees_account.`amount` < 0");
        else:    
            $studentQuery = $db->query("SELECT students.`registration_number`,students.`stdName`,students.`stdgrade`,fees_account.`amount`
                                        FROM students,`fees_account`
                                        WHERE students.`id`=`student_id`
                                        AND fees_account.`amount` < 0
                                        AND `level`='$gradeId'");
        endif;
    else:
        $studentQuery = $db->query("SELECT `students`.`registration_number`,`students`.`stdName`,`students`.`stdgrade`,`fees_account`.`amount`
                            FROM `students`,`fees_account`
                            WHERE `students`.`id`=`student_id`
                            AND `fees_account`.`amount` < 0 ORDER BY `stdname` ASC");  
    endif;

    $debt     = $db->query("SELECT SUM(amount) FROM `fees_account` WHERE `amount` < 0"); //gets the sum of all the balances in the DB
    $debtData = mysqli_fetch_array($debt);

    //check if any of the Queries has an error
    if(mysqli_num_rows($studentQuery) == 0):
        $errors[].="<b>Error! </b> Fetch query has encountered an error.";       
    endif;

    ob_start();

    if(!empty($errors)):
        echo displayErrors($errors);
    else:
?>
 <table class="table table-sm table-hover table-striped table-bordered">
    <thead class="thead-light">
        <th>#</th>
        <th>REG. No</th>
        <th>NAME</th>
        <th>AMT.(Kshs)</th> 
        <th>LEVEL</th> 
    </thead>
    <tbody>
        <?php $count =1; while($queryData = mysqli_fetch_array($studentQuery)):?>
        <tr>
            <td class="text-center"><?=$count;?></td>
            <td><?=$queryData['registration_number'];?></td>
            <td><?=$queryData['stdName'];?></td>
            <td class="text-danger"><?=$queryData['amount'];?></td>
            <td><?=$queryData['stdgrade'];?></td>
        </tr>
        <?php $count++; endwhile; ?>
    </tbody>
</table>
<?php echo ob_get_clean();  endif; ?>