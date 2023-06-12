<?php
require_once $_SERVER['DOCUMENT_ROOT'].'/school/core/init.php';
//check if the user has logged in
if(!isset($_SESSION['PARENT_LOGIN_STUDENT_ID'])):
    session_destroy();//destroy any sesions that might have been created
    header('Location: ../login.php');//redirect to the login page
else:
//if the user has logged in
$studentId = (int)decodeURl($_SESSION['PARENT_LOGIN_STUDENT_ID']);
//select all the student transactiond for this student
$statementQuery = $db->query("SELECT * FROM `fees_invoices` WHERE `student_id`='{$studentId}' ORDER BY `id`");
//if there is no result then display this message
if(mysqli_num_rows($statementQuery) == 0):
    $info[].='<b>Oops! </b>There are no financial transactions recorded for this student.';
    displayInfo($info);
endif;
//get the account balance for this student
$accountBalQuery = $db->query("SELECT * FROM `fees_account` WHERE `student_id`='{$studentId}'");
$accountBalData  = mysqli_fetch_array($accountBalQuery);
//if there is data found then display On thr table
$rowCount=1;
?>
    <div class="mb-2"><label class="font-weight-bold float-right <?=(($accountBalData['amount']>=0 ? 'text-success' : 'text-danger'))?>">Account Bal. <?=decimal($accountBalData['amount'])?></label></div>
    <table class="table table-md table-bordered table-hover table-responsive{-sm}">
        <thead class="thead-dark">
            <tr>
            <th scope="col">#</th>
            <th scope="col">MODE</th>
            <th scope="col">AMOUNT(Kshs.)</th>
            <th scope="col">DATE</th>
            </tr>
        </thead>
        <tbody>
            <?php while($queryData = mysqli_fetch_array($statementQuery)):?>
            <tr>
            <th scope="row"><?=$rowCount?></th>
            <td><?=$queryData['mode']?></td>
            <td><?=decimal($queryData['amount'])?></td>
            <td><?=date("jS F, Y", strtotime($queryData['date']))?></td>
            </tr>
            <?php $rowCount++; endwhile;?>
        </tbody>
    </table>
<?php
endif;
// $db->close();
?>