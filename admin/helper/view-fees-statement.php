<?php
require_once $_SERVER['DOCUMENT_ROOT']."/school/core/init.php";

if(isset($_POST["student_db_id"])):
$studentId=(int)clean($_REQUEST['student_db_id']); 
$invoiceQuery      = $db->query("SELECT * FROM `fees_invoices` WHERE `student_id`='$studentId' ORDER BY `id` DESC");
$studentQueryData  = mysqli_fetch_array($db->query("SELECT * FROM `students` WHERE `id`='$studentId'"));
$accountQueryArray = mysqli_fetch_array($db->query("SELECT * FROM `fees_account` WHERE `student_id`='$studentId'"));

ob_start();
?>
 
<div>
    <label class="">Acc. Status: 
        <span class="text-danger"> <b>Kshs: <?=$accountQueryArray['amount']?></b> </span>
    </label>
    <div class="float-right">
        <label class=""><b><?=$studentQueryData['stdname'];?></b></label>
        <label class=""><b><?=$studentQueryData['registration_number'];?></b></label>
    </div>
</div>
<?php
if(mysqli_num_rows($invoiceQuery) == 0 ){//if there is no result for the student

    echo '<div class="alert alert-danger alert-dismissable" role="alert"><strong>Sorry!</strong> No transactions recorded yet.</div>';

}else{?>

<table class="table-bordered table table-sm table-hover">
    <thead class="thead-light">
        <th></th>
        <th>PAID ON</th>
        <th>MODE</th>
        <th>DETAILS</th>
        <th>AMOUNT (Kshs.)</th>
    </thead>
    <tbody>
        <?php 
        $count = 1;
        while($invoiceQueryData = mysqli_fetch_array($invoiceQuery)):?>
        <tr>
            <td><?=$count;?></td>
            <td><?=date("jS F, Y", strtotime($invoiceQueryData['date']));?></td>
            <td>
                <?php 
                $modeArray = explode('-',$invoiceQueryData['mode']);
                echo $modeArray[0];?>
            </td>
            <td>
                <?php 
                $modeArray = explode('-',$invoiceQueryData['mode']);
                if($modeArray[0] == 'CASH'){
                    echo '<i>N/A.</i>';
                }else{
                    echo $modeArray[1];
                }?>
            </td>
            <td><?=decimal($invoiceQueryData['amount']);?></td>
        </tr>
        <?php 
        $count++;
        endwhile;?>
    </tbody>
</table>

<?php

}

echo ob_get_clean();
endif;
?>