<?php
require_once $_SERVER['DOCUMENT_ROOT'].'/school/core/init.php'; //db connection

if(isset($_POST)):
    $documentId     = (int)clean($_POST['DOCUMENT_ID']);
    $documentName   = clean($_POST["DOCUMENT_NAME"]);

    $db->query("UPDATE `staff_documents` SET `document_name`='{$documentName}' WHERE `id`='{$documentId}'");
    $messages[].="<b>Success! </b>The document has been updated."; echo displayMessages($messages);
endif;
?>