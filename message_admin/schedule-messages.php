<?php
require_once dirname(__DIR__).'/core/init.php';
include dirname(__DIR__).'/message_admin/functions.php';

if(isset($_POST)):
   $contactsString = ($_POST['CONTACTS']);
   $messageArray   = json_encode($_POST['MSG_DATA']);
   $schedule = clean($_POST['SCHEDULE']);

  $db->query("INSERT INTO `scheduled_messages`(`message`, `recipients`, `send_time`) VALUES ('$messageArray','$contactsString','$schedule')");
   $messages[].='Your message has been schedule..';
   echo dispMessages($messages);
endif;

$db->close();
?>