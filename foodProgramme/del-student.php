<?php
require_once $_SERVER["DOCUMENT_ROOT"].'/school/core/init.php';//database connecion file

if(isset($_POST['DELETE_ID']) && !empty($_POST['DELETE_ID'])):
    $studentID = (int)clean($_POST['DELETE_ID']);
    //check if the id exists in the food programme forst
    $stdQuery = $db->query("SELECT `id` FROM `food_programme` WHERE `student_id`='{$studentID}'");
    if(mysqli_num_rows($stdQuery) == 1): //if the record has been found
        $db->query("DELETE FROM `food_programme` WHERE `student_id`='{$studentID}'");
        $messages[].="<b>Success! </b>Student has been removed from food programme";
        echo displayMessages($messages);
    else:
        $errors[].="<b>Fatal Error!</b> The student was not found in the food programme";
        echo displayErrors($errors);
    endif;
endif;

?>