<?php
require_once dirname(__DIR__).'/core/init.php';
include dirname(__DIR__).'/message_admin/functions.php';

if(isset($_POST)):
    $recipient      = clean($_POST['NAME']);
    $outboxQuery    = $db->query("SELECT * FROM `message_outbox` WHERE `recipient` LIKE '%".$recipient."%' ORDER BY `id`");

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