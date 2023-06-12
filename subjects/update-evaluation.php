<?php
require_once $_SERVER['DOCUMENT_ROOT'].'/school/core/init.php';//database connection
if(isset($_POST)):
    $subjectEvaluationArray = array();     
    foreach ($_POST as $subject=>$subject_evaluation)://loops through all the subjects that haave been provided
        if(empty($subject_evaluation)){$subject_evaluation='NIL';}//when the subject has not been evaluated
        $newArray = array(
            'SUBJECT_ID'         => $subject,
            'SUBJECT_EVALUATION' => $subject_evaluation 
        );
        $subjectEvaluationArray[]=$newArray;
    endforeach;
    $evaluation_encoded = json_encode($subjectEvaluationArray);

    if(isset($_COOKIE['EVALUATION_ID']) && $_COOKIE['EVALUATION_ID']>0):
        $evaluationId = (int)$_COOKIE['EVALUATION_ID'];//this is the database ID for this evaluation
        //check if there us data matching the id
        $checkQuery = $db->query("SELECT `id` FROM `student_grades` WHERE `id`='{$evaluationId}'");
        if(mysqli_num_rows($checkQuery)==0):
            $errors[].='<b>Error! </b>The entry you are trying to update does not exist';
            echo displayErrors($errors);
        else:
            $db->query("UPDATE `student_grades` SET `grades`='{$evaluation_encoded}' WHERE `id`='{$evaluationId}'");
            $messages[].="<b>Success! </b>Student Evaluation has been updated.";
            echo displayMessages($messages);
            //delete the cookie holding this evaluation id
            setcookie("EVALUATION_ID", "", time() - 3600,"/");
        endif;
    else:
        $errors[].='<b>Error! </b>The evaluation identity has been lost or not set. Repeat this operation';
        echo displayErrors($errors);
    endif;
endif;
?>