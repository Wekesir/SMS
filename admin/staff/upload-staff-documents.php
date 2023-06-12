<?php
  require_once $_SERVER['DOCUMENT_ROOT'].'/school/core/init.php'; //db connection

  if(isset($_POST)):
    $doc = ($_FILES["file"]["name"]); //stores the original filename from the client
    $tmp = $_FILES["file"]["tmp_name"]; //stores the name of the designated temporary file
    $docname = strtoupper(clean($_POST['docname']));

    $target_dir         =   '/documents/staff/';
    $fileDestination    =   BASEURL.$target_dir.$_FILES['file']['name'];
    $fileTempName       =   $_FILES["file"]["tmp_name"];
    $fileError          =   $_FILES['file']['error'];            
    $staffdocumenturl   =   '/school/documents/staff/'.$_FILES['file']['name']; 

    //checkmif the staff id cookie haad been set
    if(isset($_COOKIE['STAFF_DOC_ID']) && $_COOKIE['STAFF_DOC_ID'] > 0):
        $id = (int)$_COOKIE['STAFF_DOC_ID'];
        move_uploaded_file($fileTempName, $fileDestination);
        $db->query("INSERT INTO staff_documents (`staff_id`,`document`, `document_name`) VALUES ('$id','$staffdocumenturl','$docname')");
        $messages[].='<b>Success! </b>Document uploaded.';
        echo displayMessages($messages);
        //unset the cookie value
        setcookie("STAFF_DOC_ID", "", time()-3600);
    else:
        $errors[].="<b>Error! </b>A cookie value has not been set or has been deleted"; echo displayErrors($errors);
    endif;  
  endif;
?>