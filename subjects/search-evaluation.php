<?php
require_once $_SERVER['DOCUMENT_ROOT'].'/school/core/init.php';
if(isset($_POST)):
    $studentId = (int)base64_decode($_POST['STUDENT_ID']);
    $level     = base64_decode(trim($_POST['STUDENT_LEVEL']));
    $year      = base64_decode(trim($_POST['YEAR']));
    $term      = base64_decode(trim($_POST['TERM'])); 

    $searchQuery = "SELECT * FROM `student_grades` WHERE `student_id`='{$studentId}'";
    if(!empty($level)):
        $searchQuery.=" AND `current_grade`='{$level}'";
    endif;
    if(!empty($term)):
        $searchQuery.=" AND `period`='{$term}'";
    endif;
    if(!empty($year)):
        $searchQuery.=" AND YEAR(`entry_date`)='{$year}'";
    endif;

    $query = $db->query($searchQuery);
    $count = 1;
    ob_start(); 
    if(mysqli_num_rows($query)==0):
        $errors[].='<b>Error! </b>no data matching your search was found.';
        echo displayErrors($errors);
    else:
        $subjectData = mysqli_fetch_array($query);
        $count=1;
        ?>
        <div class="row bg-light my-1 p-2">
            <label class="float-left text-danger" onclick="reload()"><i class="fas fa-arrow-left"></i> Back.</label>
            <h6 class="mx-auto text-danger"><strong>SEARCH RESULTS.</strong></h6>
        </div>
        <div id="notificationsDiv"></div>
        <form action="<?=$_SERVER['PHP_SELF']?>" id="updateForm" method="post" class="bg-light">
        <div class="row">        
            <?php
            foreach(json_decode($subjectData['grades'],true) as $x=>$x_value):?>            
                <div class="form-group col-md-6">
                    <label for=""><strong><?=$count.'. '.getSubjectName($x_value['SUBJECT_ID']);?></strong></label>
                    <textarea name="<?=$x_value['SUBJECT_ID'];?>" id="" rows="5" class="form-control" placeholder="<?=$x_value['SUBJECT_EVALUATION']?>"><?=$x_value['SUBJECT_EVALUATION']?></textarea>
                </div>
            <?php $count++; endforeach; ?>        
        </div>
        <?php if(has_Access($_SESSION['user'],$level) || studentActive($studentId)):?>
        <div class="row">
            <button class="btn btn-success btn-sm ml-3" name="update" type="submit">
            <span class="spinner-border spinner-border-sm" role="status" aria-hidden="true"></span>
             Update Evaluation
            </button>
        </div>
        <?php endif; ?>
        </form>
        <?php
    endif;    
    echo ob_get_clean();
endif;

function studentActive($id){
    global $db;
    $studentQuery = $db->query("SELECT `deleted`,`accomplished` FROM `students` WHERE `id`='{$id}'");
    $queryData    = mysqli_fetch_array($studentQuery);
    if($queryData['deleted']==0 || $queryData['accomplished']==0):
        return true;
    endif;
    return false;
    $db->close();
}
function has_Access($id,$level){
    global $db;
    $subjectQuery = mysqli_fetch_array($db->query("SELECT `class_assigned` FROM `users` WHERE `id`='{$id}'"));
    if(in_array($level, explode(",", rtrim($subjectQuery['class_assigned'],",")))):
        return true;
    else:
        return false;
    endif;
    $db->close();
} 
function getSubjectName($id){
    global $db;
    $subjectQuery = mysqli_fetch_array($db->query("SELECT `subject_name` FROM `subjects` WHERE `id`='{$id}'"));
    $subjectName  = $subjectQuery['subject_name'];
    return $subjectName;
    $db->close();
}
?>

<script>
jQuery("#updateForm").submit(function(e){//when the submit button has been clicked
    e.preventDefault();
    var formData = jQuery(this).serialize();//this is the form data
    var evaluationId = <?=$subjectData['id']?>;
    document.cookie = "EVALUATION_ID="+JSON.stringify(evaluationId)+"; expires=Thu, 18 Dec 2050 12:00:00 UTC; path=/";
    jQuery(".spinner-border").addClass("active");
    jQuery.ajax({
        url:'/school/subjects/update-evaluation.php',
        method:'post',
        data:formData,
        success:function(data){
            jQuery(".spinner-border").removeClass("active");
            jQuery("#notificationsDiv").html(data);
        },
        error:function(){
            alert("There was an error trying to update evaluation.");
        }
    });
});

function reload(){
    location.reload(true);
}
</script>