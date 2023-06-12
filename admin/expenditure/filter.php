<?php
require_once $_SERVER['DOCUMENT_ROOT'].'/school/core/init.php';

if(isset($_POST['value'])){
    $year = ((isset($_POST['value'])? $_POST['value'] :''));
    echo $year;
}

if(isset($_POST['fromDate']) && isset($_POST['toDate'])){
    $fromDate   =   clean($_POST['fromDate']);
    $toDate     =   clean($_POST['toDate']);

    $query  =   $db->query("SELECT * FROM expenditure WHERE date_entered BETWEEN '$fromDate' AND '$toDate' ORDER By id DESC");
    if(mysqli_num_rows($query) > 0){
        $count=1;
        ob_start(); 
        while($queryData    =   mysqli_fetch_assoc($query)) :?>
             <tr>
                <td class="text-center"><?=$count;?></td>
                <td title="<?=$queryData['expenditure']?>"><?=cutstring($queryData['expenditure'], 60);?></td>
                <td><?=$queryData['amount'];?></td>
                <td><?=date("jS F, Y", strtotime($queryData['date_entered']))?></td>
                <td>
                    <a href="expenditure.php?edit=<?=$queryData['id']?>" class="btn btn-outline-success btn-sm text-success" title="Click to edit expenditure."> <i class="fas fa-pencil-alt"></i>  Edit</a>
                        <?php if(in_array($logged_in_user_data['permissions'],$allowedAccessArray,true)){?>
                    <a class="btn btn-outline-danger btn-sm text-danger deleteExpenditure" id="<?=$queryData['id']?>" title="Click to delete expenditure."> <i class="fas fa-trash"></i> Delete</a>
                    <?php }?>
                </td>
            </tr>           
     <?php $count++; endwhile;   echo ob_get_clean(); $db->close();
    }
}
?>