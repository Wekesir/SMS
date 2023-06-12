<?php
require_once $_SERVER['DOCUMENT_ROOT'].'/school/core/init.php';
if(!isset($_SESSION['PARENT_LOGIN_STUDENT_ID'])):
    session_destroy();
    header('Location: ../login.php');
else:
    $evaluationId = (int)clean(decodeURl($_REQUEST['view']));
    $evaluationQ  = $db->query("SELECT * FROM `student_grades` WHERE `id`='{$evaluationId}'");
    //check whether the Id has been changed in the URL as this will provide no results
    if(mysqli_num_rows($evaluationQ)==0):
        $errors[].='<b>Error! </b>No result found. Try again.';
        displayErrors($errors);
    else:
        $count=1;
        $evalutionData = mysqli_fetch_array($evaluationQ);
        $evaluation    = json_decode($evalutionData['grades'],true); ?>
        <div class="mb-2 bg-light p-2">
            <label for=""><a href="<?=$_SERVER['PHP_SELF']?>"><i class="fas fa-arrow-left"></i> Back.</a></label>
            <label for="" class="float-right font-weight-bold">
                <span class="mr-3"><?=$evalutionData['period']?></span><span class="mr-2"><?=$evalutionData['current_grade']?></span>
            </label>
        </div>
        <div class="row">
            <?php foreach($evaluation as $grade): ?>
                <div class="form-group col-md-6">
                <label for=""><?=$count.'. '.getSubjectName($grade['SUBJECT_ID'])?></label>
                <textarea class="form-control" id="" rows="5"><?=$grade['SUBJECT_EVALUATION']?></textarea>
                </div>
            <?php $count++; endforeach; ?>
        </div>
        <?php
    endif;
endif;

//function for getting the subjeect name givem the ubjeect id
function getSubjectName($id){
    global $db;
    $subjectQuery = $db->query("SELECT `subject_name` FROM `subjects` WHERE `id`='{$id}'");
    $subjectData  = mysqli_fetch_array($subjectQuery);
    return $subjectData['subject_name'];
    $db->close();
}
?>