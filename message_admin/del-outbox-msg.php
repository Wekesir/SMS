<?php
require_once dirname(__DIR__).'/core/init.php';
include dirname(__DIR__).'/message_admin/functions.php';

if(isset($_POST['MSG']) && !empty($_POST['MSG'])):
    $id = (int)base64_decode($_POST['MSG']);
    $msgQuery   = $db->query("SELECT * FROM `message_outbox` WHERE `id`='{$id}'");
    if(mysqli_num_rows($msgQuery) > 0):
        $db->query("DELETE FROM `message_outbox` WHERE `id`='{$id}'");
        $messages[].="Message has been deleted";
        echo dispMessages($messages);
    else:
        $errors[].="This message does not exist.";
        echo dispError($errors);
    endif;
endif;
?>