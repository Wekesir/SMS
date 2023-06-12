<?php
require_once dirname(__DIR__).'/core/init.php';
include dirname(__DIR__).'/message_admin/functions.php';

if(isset($_POST)):
    $subject    = $_POST['MSG_DATA']['Subject']; 
    $msg        = $subject.' - '.$_POST['MSG_DATA']['Message'].'. Regards, '.$configurationData['school_name'];

    $contactsArray = $_POST['RECIPIENT_DATA'];
    foreach($contactsArray as $contact => $x):
        $name = $x['Recipient_name'];
        $phone = $x['Phone_Number'];
        mobitech_send_sms($phone, $msg, $name);        
    endforeach;
    $messages[].='Your message has been sent.';
    echo dispMessages($messages);
endif;

$db->close(); 
?>