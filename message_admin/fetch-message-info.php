<?php
require_once dirname(__DIR__).'/core/init.php';
include dirname(__DIR__).'/message_admin/functions.php';

if(isset($_POST['MESSAGE_ID'])):
    $id = (int)base64_decode($_POST['MESSAGE_ID']);
    $msgQuery   = $db->query("SELECT * FROM `message_outbox` WHERE `id`='{$id}'");
    $outboxData = mysqli_fetch_array($msgQuery);

    $messageArray = array(
        "ID"           => $id,
        "RECIPIENT"    => $outboxData['recipient'],
        "PHONE_NUMBER" => $outboxData['phone_number'],
        "MESSAGE"      => $outboxData['message']
    );

    echo base64_encode(json_encode($messageArray));
endif; 
?>