<?php
require_once $_SERVER['DOCUMENT_ROOT'].'/school/core/init.php';
global $currentPeriod; //current school period i.e Term 1, Term 2 & Term 3 echo 
$logged_in_user_id     = (int)$_SESSION['user'];//this is the session set when the user sucessfully logs in

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

    if(isset($_COOKIE['STUDENT_DETAILS']) && !empty($_COOKIE['STUDENT_DETAILS'])):
        $studentetailsArray = json_decode($_COOKIE['STUDENT_DETAILS'], true);
        $studentId           = (int)$studentetailsArray['STUDENT_ID'];
        $currentStudentGrade = $studentetailsArray['STUDENT_GRADE'];
        $checkQuery = $db->query("SELECT `id` FROM `students` WHERE `id`='{$studentId}' AND `stdgrade`='{$currentStudentGrade}'");
        if(mysqli_num_rows($checkQuery)==0)://if the student by the submitted credentials doesnt exist
            $errors[].='<b>Error! </b>Student Information passed is wrong. Data can not be insrted into database';
            echo displayErrors($errors);
        else:
            //check if the evaluation has already been done
            $year = date("Y");
            $evaluationCheck = $db->query("SELECT `id` FROM `student_grades` WHERE `student_id`='{$studentId}' AND `period`='{$currentPeriod}' AND `current_grade`='{$currentStudentGrade}' AND YEAR(`entry_date`)='{$year}'");
            if(mysqli_num_rows($evaluationCheck)>0):
                $errors[].='<b>Errors! </b>This student has already been evaluated';
                echo displayErrors($errors);
            else:
                $db->query("INSERT INTO `student_grades` 
                            (`grades`,`student_id`,`current_grade`,`period`,`entered_by`,`entry_date`) 
                            VALUES 
                            ('{$evaluation_encoded}','$studentId','$currentStudentGrade','$currentPeriod','$logged_in_user_id','$todayDateTime')");
                $messages[].='<b>Success! </b>Student has been evaluated and evaluation has been stored.';
                echo displayMessages($messages);
                //delete the cookie holding this student information
                setcookie("STUDENT_DETAILS", "", time() - 3600,"/");
            endif;           
        endif;
    else:
        $errors[].='<b>Error! </b>Cookie holding student data does not exist.';
        echo displayErrors($errors);
    endif;
   
endif;
?>