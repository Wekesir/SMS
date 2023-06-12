<?php
  require_once $_SERVER['DOCUMENT_ROOT'].'/school/core/init.php'; //db connection

  if(isset($_POST["DOCUMENT_ID"])):
    $docId = (int) $_POST['DOCUMENT_ID'];
    $docQuery = $db->query("SELECT * FROM `staff_documents` WHERE `id`='{$docId}'");

    if(mysqli_num_rows($docQuery) == 0):
        $errors[].="<b>Error! </b>This document does not exist or has already been deleted"; echo displayErrors($errors);
    else:
        //unlink the document from server
        if(unlink($_SERVER['DOCUMENT_ROOT'].$docData['document'])):
            $db->query("DELETE FROM `staff_documents` WHERE `id` = '{$docId}'");
            $messages[].="<b>Success! </b>Document has been deleted."; echo displayMessages($messages);
        else:
            $errors[].="<b>Error! </b>There was an error deleting this document"; echo displayErrors($errors);
        endif;
    endif;
  endif;