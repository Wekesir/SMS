<?php
require_once $_SERVER["DOCUMENT_ROOT"].'/school/core/init.php';

if(isset($_POST['REG_NUMBER'])):
    $regNumber = clean(trim($_POST['REG_NUMBER']));

    //search to see whether the student already exists in the food program
    $searchQuery = $db->query("SELECT * FROM `food_programme_view` WHERE `registration_number`='{$regNumber}'");
    
    if(mysqli_num_rows($searchQuery) == 0):
        //get the db student id from the student table
        $stdQuery = $db->query("SELECT `id` FROM `students` WHERE `registration_number`='{$regNumber}'");
        if(mysqli_num_rows($stdQuery)==1)://when the student id has been found
            $stdData     = mysqli_fetch_array($stdQuery);
            $studentDbId = (int)$stdData['id']; //this is the database id and not the student IP Number
            $db->query("INSERT INTO `food_programme`(`student_id`) VALUES ('{$studentDbId}')");
            $messages[].="<b>Success! </b>Student has been added to the food programme";
            echo displayMessages($messages);
        else:
            //when the student id has not bee found in the students DB
            $errors[].="<b>Error! </b>The student has not been found in the student data";
            echo displayErrors($errors);
        endif;       
    else:
        //when the student already exists then display this error
        $errors[].="<b>Error! </b> The student already exists in the food programme";
        echo displayErrors($errors);
    endif;
endif;
?>