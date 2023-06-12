<?php
require_once $_SERVER['DOCUMENT_ROOT'].'/school/core/init.php';

if(isset($_POST['SPECIFIC_USER_ID']) && !empty($_POST['SPECIFIC_USER_ID'])):
    $staffId = (int)clean($_POST['SPECIFIC_USER_ID']);
    //eet the user name from db
    $staffQ = $db->query("SELECT `name` FROM `users` WHERE `id`='{$staffId}'");
    $qdata = mysqli_fetch_assoc($staffQ);

    $staffQuery = $db->query("SELECT * FROM `staff_invoices` WHERE `staff_id`='{$staffId}' ORDER BY `id` DESC");
    if(mysqli_num_rows($staffQuery) == 0):
        $info[].="<b>Oops! </b>No data has been found for this staff member!"; echo displayinfo($info);
    else:
        setcookie("PRINT_USER_PAYMENT_COOKIE", base64_encode($staffId), time() + (3600), "/"); //cookie lasts for 1 hour
        ob_start();
        ?>
        <h6 class="py-2"><?=$qdata['name']?></h6>
        <table class="table table-sm table-bordered table-hover">
        <tbody>
            <?php $count=1; while($staffData = mysqli_fetch_assoc($staffQuery)) :?>
            <tr>
            <th scope="row"><?=$count;?></th>
            <td><?=$staffData['details']?></td>
            <td><?=decimal($staffData['amount'])?></td>
            <td class="text--primary"><?=date("jS F, Y", strtotime($staffData['date']))?></td>
            </tr>
            <?php $count++; endwhile;?>
        </tbody>
        </table>  
        <?php
        echo ob_get_clean(); 
    endif;
endif;

if(isset($_POST['staff_name_finance'])):
    $staffName = $_POST['staff_name_finance'];
    $staffQuery = $db->query('SELECT `id`,`name` FROM `users` WHERE `name` LIKE "%'.$staffName.'%"');
    //check if the name has been found
    if(mysqli_num_rows($staffQuery) == 0):
        $errors[].="<b>Error! </b> This name has not been found."; echo displayErrors($errors);
    else:
        ob_start();
    ?>
        <table class="table table-sm table-bordered table-hover">
        <tbody>
            <?php $count=1; while($userData = mysqli_fetch_assoc($staffQuery)) :?>
            <tr>
            <th scope="row"><?=$count;?></th>
            <td><?=highlightWords($userData['name'], $staffName)?></td>
            <td><a href="#" id="<?=$userData['id']?>" class="btn btn-sm btn-default userId"><i class="fas fa-eye"></i> view</a></td>
            </tr>
            <?php $count++; endwhile;?>
        </tbody>
        </table>    
    <?php
    echo ob_get_clean();
    endif;
endif;

?>