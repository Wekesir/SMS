<?php
require_once dirname(__DIR__).'/core/init.php';
include dirname(__DIR__).'/message_admin/functions.php';

if(isset($_POST)):
    $stmt = "SELECT * FROM `message_outbox`";

    $recipient  = ((isset($_POST['recipientName']) ? $_POST['recipientName']:''));
    $singleDate = ((isset($_POST['date']) ? $_POST['date']:''));
    $fromDate   = ((isset($_POST['dateRangeFrom']) ? $_POST['dateRangeFrom']:''));
    $toDate     = ((isset($_POST['dateRangeTo']) ? $_POST['dateRangeTo']:''));

    if(!empty($singleDate)):
        //check whther the name has been provided too
        if(empty($recipient)):
            $stmt .= " WHERE `date`='{$singleDate}'";
        else://if a name has been provided as well
            $stmt .= " WHERE `date`='{$singleDate}' AND `recipient` LIKE '%".$recipient."%'";
        endif;      
    elseif(empty($singleDate)):
         //check whther the name has been provided too
         if(empty($recipient)):
            $stmt .= " WHERE DATE(`date`) BETWEEN CAST('{$fromDate}' AS DATE) AND CAST('{$toDate}' AS DATE ";
        else://if a name has been provided as well
            $stmt .= " WHERE DATE(`date`) BETWEEN CAST('{$fromDate}' AS DATE) AND CAST('{$toDate}' AS DATE AND `recipient` LIKE '%".$recipient."%'";
        endif;    
    endif;

    $outboxQuery    = $db->query($stmt);
    ob_start();

    while($outboxData = mysqli_fetch_array($outboxQuery)):?>
    <tr>
    <input type="hidden" name="" value="<?=base64_encode($outboxData['id'])?>">
    <td class="text-warning" title="<?=$outboxData['recipient']?>"><b><?=cutstring($outboxData['recipient'], 10)?></b></td>
    <td class="text-info"><?=$outboxData['phone_number']?></td>
    <td><?=cutstring($outboxData['message'], 90)?></td>
    </tr>
    <?php endwhile;

    echo ob_get_clean();
endif;
?>