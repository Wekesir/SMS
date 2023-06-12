<?php
require_once dirname(__DIR__).'/core/init.php';
include dirname(__DIR__).'/message_admin/functions.php';

if(isset($_POST['MESSAGE_ID'])):
    $id = (int)base64_decode($_POST['MESSAGE_ID']);
    $msgQuery   = $db->query("SELECT * FROM `messages` WHERE `id`='{$id}'");
    $outboxData = mysqli_fetch_array($msgQuery);

    $messageArray = array(
        "ID"           => $id,
        "SENDER"       => $outboxData['first_name'],
        "PHONE_NUMBER" => $outboxData['phonenumber'],
        "MESSAGE"      => $outboxData['message']
    );

    echo base64_encode(json_encode($messageArray));
endif; 
?>