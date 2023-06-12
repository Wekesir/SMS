
<!DOCTYPE html>
<html>
<head>
    <?php
        require_once $_SERVER['DOCUMENT_ROOT'].'/school/core/init.php';
        include '../admin/header.php'; ?>
</head>
<body>   
    <?php include '../admin/navigation.php';?>
 <div class="container-fluid">
    <div class="row">
        <div class="col-md-3">
            <?php include '../admin/left.php';?>
        </div><!--Closing col-md-3 div-->
        <div class="col-md-9" id="wrapper">                
            <div class="row mx-1">
                <div class="col-md-6"><h5>Subjects Management.</h5></div>
                <div class="col-md-6">
                    <div class="form-group">
                        <label for=""><b><i class="fas fa-search"></i> SEARCH SUBJECT</b></label>
                        <div class="loader float-right"></div>
                        <input type="search" name="searchSubject" placeholder="Subject Name..." id="" class="form-control">
                    </div>
                </div>
            </div>
            <button class="btn btn-primary btn-md rounded-circle position-fixed addSubjectBtn" title="Click to add a new subject"> <a href="<?=$_SERVER['PHP_SELF'].'?add-subject';?>" style="color:white;"><i class="fas fa-plus"></i></a> </button>
            <div id="subjectsDiv" class="<?=((isset($_REQUEST['add-subject']) || isset($_REQUEST['edit-subject-entry']) ?'d-block':'d-none'))?>">
                <div class="p-3 mb-1" style="background-color:#f8f8f8;"><strong><?=((isset($_REQUEST['edit-subject-entry'])?'EDIT SELECTED':'ADD NEW'))?> SUBJECT.</strong></div>
                <?php
                $count=1;
                $gradeString = array();
                $subjectQuery = $db->query("SELECT * FROM `subjects` ORDER BY `subject_name`");
                $gradeQuery = $db->query("SELECT * FROM `grade`");//query for fetching all the grade from database
                $gradeCount = mysqli_num_rows($gradeQuery);
                if($gradeCount==0){//checks whether the grades have been provided
                    $errors[].='<b>Error! </b>Make sure that all grades have been provided.';
                    displayErrors($errors);
                }

                if(isset($_REQUEST['edit-subject-entry']) && $_REQUEST['edit-subject-entry']>0)://if the edit button has been clicked
                    $editId    = (int)clean($_REQUEST['edit-subject-entry']);
                    $editQuery = $db->query("SELECT * FROM `subjects` WHERE `id`='{$editId}'");
                    $editData  = mysqli_fetch_array($editQuery);
                    //check if the requested id exists
                    if(mysqli_num_rows($editQuery)==0):
                        $errors[].='<b>Error! </b>The entry you are trying to find does not exist.';
                        displayErrors($errors);
                    else:
                        $edit_subject = $editData['subject_name'];//subject being offered
                        $edit_levels  = json_decode($editData['levels']);//array holding all the levels that offer this subject
                        //if the update button is clicked
                        if(isset($_POST['update'])):
                           $subject = trim(((isset($_POST['subject'])? strtoupper($_POST['subject']):$edit_subject)));//the name of the subject                        
                            for($x=$gradeCount;$x>=1;$x--)://loop throught all the grades
                                $levelName = ((isset($_POST['level'.$x.'']) ? $_POST['level'.$x.'']:''));
                                if(!empty($levelName))://only get the values of the levels selected
                                    $gradeString[].= $levelName;
                                endif;
                            endfor;
                            $levels_encoded = json_encode($gradeString);
                            $db->query("UPDATE `subjects` SET `subject_name`='{$subject}',`levels`='{$levels_encoded}' WHERE `id`='{$editId}'");
                            $messages[].='<b>Success! </b>Subject has been updated.';
                            displayMessages($messages);
                        endif;//end of the update button click event
                    endif;
                endif;//end of the edit button click action

                if(isset($_REQUEST['add-subject'])):
                    if(isset($_POST['submit'])):
                        $subject = trim(((isset($_POST['subject'])? strtoupper($_POST['subject']):'')));//the name of the subject                        
                        for($x=$gradeCount;$x>=1;$x--)://loop throught all the grades
                            $levelName = ((isset($_POST['level'.$x.'']) ? $_POST['level'.$x.'']:''));
                            if(!empty($levelName))://only get the values of the levels selected
                                $gradeString[].= $levelName;
                            endif;
                        endfor;
                        $levels_encoded = json_encode($gradeString);
                        //check whether the entered subject already exists
                        $checkQuery = $db->query("SELECT `id` FROM `subjects` WHERE `subject_name`='{$subject}'");
                        if(mysqli_num_rows($checkQuery)>0):
                            $errors[].='<b>Error! </b>This subject already exists';
                            displayErrors($errors);
                        else:
                            $db->query("INSERT INTO `subjects` (`subject_name`,`levels`) VALUES ('{$subject}','{$levels_encoded}')");
                            $messages[].='<b>Success! </b>Subject has been added.';
                            displayMessages($messages);
                        endif;
                    endif;//end of the submit button
                endif;//end of the $_REQUEST['add-subject']
                ?>
                <form method="post" action="<?=$_SERVER['PHP_SELF'].((isset($_REQUEST['edit-subject-entry'])?'?edit-subject-entry='.$_REQUEST['edit-subject-entry']:'?add-subject'))?>">
                    <div class="form-group">
                        <label for=""><b>SUBJECT TITLE</b></label>
                        <input type="text" name="subject" id="subject" required=required class="form-control" value="<?=((isset($_REQUEST['edit-subject-entry']) ? $edit_subject:''))?>">
                    </div>
                    <div class="form-group">
                        <h6>GRADES THAT STUDY THE SUBJECT</h6>
                        <?php while($gradeData = mysqli_fetch_array($gradeQuery)) :?>
                        <div class="form-check-inline">
                            <label class="form-check-label">
                                <input type="checkbox" class="form-check-input" name="level<?=$gradeCount?>" value="<?=$gradeData['grade']?>" <?=((isset($_REQUEST['edit-subject-entry']) ? ((in_array($gradeData['grade'],$edit_levels,true)?'checked':'')) :''))?>> <?=$gradeData['grade']?>
                            </label>
                        </div>
                        <?php $gradeCount--; endwhile;?>
                    </div>
                    <div class="form-group">
                        <button type="submit" class="btn btn-sm btn-primary" name="<?=((isset($_REQUEST['edit-subject-entry'])?'update':'submit'))?>"><?=((isset($_REQUEST['edit-subject-entry'])?'Update Subject':'Submit'))?></button>
                        <button type="button" class="btn btn-sm btn-default cancelBtn">Cancel</button>
                    </div>
                </form>
            </div>
            <div id="tableContainer">            
                <?php
                    //code for deleting a subject
                    if(isset($_REQUEST['delete-subject']) && $_REQUEST['delete-subject']>0):
                        $deleteId    = (int)clean($_REQUEST['delete-subject']);
                        $deleteQuery = $db->query("SELECT * FROM `subjects` WHERE `id`='{$deleteId}'");
                        //check if the subject exists
                        if(mysqli_num_rows($deleteQuery)==0):
                            $errors[].='<b>Error! </b>Subject doesn not exist any more or has already been deleted';
                            displayErrors($errors);
                        else:
                            $db->query("DELETE FROM `subjects` WHERE `id`='{$deleteId}'");
                            $messages[].='<b>Success! </b>Subject has been deleted';
                            displayMessages($messages);
                        endif;
                    endif;
                ?>
                <table class="table table-bordered table-sm table-hoverable table-striped">
                    <thead class="thead-light">
                        <tr>
                        <th scope="col" >#</th>
                        <th scope="col" >SUBJECT</th>
                        <th scope="col" >LEVELS OFFERING</th>
                        <th scope="col" >ACTIONS</th>
                        </tr>
                    </thead>
                    <tbody id="tbody">
                        <?php while($subjectData = mysqli_fetch_array($subjectQuery)) :?>
                        <tr>
                        <th scope="row"><?=$count?></th>
                        <td><?=$subjectData['subject_name']?></td>
                        <td><?='('.count(json_decode($subjectData['levels'])).') level(s).'?> <button class="btn btn-sm btn-default float-right viewLevelsBtn" data-subjectId="<?=$subjectData['id']?>" title="view levels offering this subject."><i class="fas fa-eye"></i> view.</button> </td>
                        <td>
                            <a class="btn btn-sm btn-outline-primary" href="<?=$_SERVER['PHP_SELF'].'?edit-subject-entry='.$subjectData['id']?>"><i class="fas fa-pencil-alt"></i> edit.</a>
                            <button class="btn btn-sm btn-danger deleteBtn" data-deleteId="<?=$subjectData['id']?>"><i class="far fa-trash-alt"></i> delete.</button>
                        </td>
                        </tr>
                        <?php $count++; endwhile;?>
                    </tbody>
                </table>
            </div>
        </div><!--Closing col-md-9 div-->
    </div><!--Closing row dic-->
 </div><!--closing container div-->
    <?php include '../admin/footer.php';?>
</body>
</html>
<script>
var subjectDiv = $("#subjectsDiv");
var loader = $(".loader");

jQuery("input[name='searchSubject']").keyup(function(){
    loader.addClass("active");
    var searchSubject = jQuery(this).val();
    jQuery.ajax({
        url:'/school/subjects/search.php',
        method:'post',
        data:{searchSubject:searchSubject},
        success:function(data){
            loader.removeClass("active");
            jQuery("#tbody").html(data);
            jQuery(".deleteBtn").click(function(){
                var deleteId = jQuery(this).attr('data-deleteId');
                if(confirm("Proceed to dowload this subject?")){
                    window.location = "/school/admin/subjects.php?delete-subject="+deleteId;
                }
            });
            jQuery('.viewLevelsBtn').click(function(){
            var subjectId = jQuery(this).attr("data-subjectId");
            jQuery.ajax({
                url:'/school/modals/view-subject-levels.php',
                method:'post',
                data:{subjectId:subjectId},
                success:function(data){
                    jQuery("body").append(data);
                    jQuery("#viewLevelsModal").modal({
                        keyboard: false, backdrop:'static'
                    });
                },
                error:function(){
                    alert("There was a problem trying to search for subject. Contact system provider.");
                }
            });
        });
        },
        error:function(){
            alert("There was a problem trying to search for subject. Contact system provider.");
        }
    });
});

jQuery('.viewLevelsBtn').click(function(){
    var subjectId = jQuery(this).attr("data-subjectId");
    jQuery.ajax({
        url:'/school/modals/view-subject-levels.php',
        method:'post',
        data:{subjectId:subjectId},
        success:function(data){
            jQuery("body").append(data);
            jQuery("#viewLevelsModal").modal({
                keyboard: false, backdrop:'static'
            });
        },
        error:function(){
            alert("There was a problem trying to search for subject. Contact system provider.");
        }
    });
});

jQuery(".deleteBtn").click(function(){
    var deleteId = jQuery(this).attr('data-deleteId');
    if(confirm("Proceed to delete this subject?")){
        window.location = "/school/admin/subjects.php?delete-subject="+deleteId;
    }
});

jQuery(".addSubjectBtn").click(function(e){
    e.preventDefault();
    window.location="/school/admin/subjects.php?add-subject";
});

subjectDiv.find(".cancelBtn").click(function(){//when the cancel buttn has been clicked
    subjectDiv.removeClass("d-block").addClass("d-none");
    window.location = "/school/admin/subjects.php";
});
</script>
<style>
#tableContainer{
    background-color:#ffff;
    padding: 5px;
    border: 1px solid #f0f0f0;
    max-height: 75.5vh;
    overflow:auto;
}
#subjectsDiv{
    border: 1px solid #dcdcdc;
    position:absolute;
    background-color:white;
    width: 50%;
    margin-left:25%;
    padding: 20px;
    box-shadow: 0 4px 8px 0 rgba(0, 0, 0, 0.2), 0 6px 20px 0 rgba(0, 0, 0, 0.19);
}
.addSubjectBtn{
    right: 30px;
    bottom: 30px;
    padding:15px;    
}
</style>

