<!--
    GLOBAL VARIABLES $db, $currentPeriod
-->
<?php
require_once $_SERVER['DOCUMENT_ROOT'].'/school/core/init.php';
include $_SERVER['DOCUMENT_ROOT'].'/school/includes/header.php';

    global $currentPeriod; //current school period i.e Term 1, Term 2 & Term 3 echo 
    global $db; //current database variable that gives us access to the database
    //check if the user is logged in
    if(!logged_in()){
        header("Location: /school/login.php");
    }

    $logged_in_user_id     = (int)$_SESSION['user'];//this is the session set when the user sucessfully logs in
    $id                    = ((isset($_GET['studentId'])? (int)decodeURL($_GET['studentId']) : ''));
    $_SESSION['studentId'] = ($id);//sets a new session holding te current student ID
    $grade                 = ((isset($_SESSION['grade'])? $_SESSION['grade'] : ''));//gets the grade from the gradefilter.php
    $term                  = ((isset($_SESSION['term'])? $_SESSION['term'] : ''));//gets the term from the gradefilter.php
    $query                 = $db->query("SELECT * FROM `students` WHERE `id`='{$id}'");
    $querydata             = mysqli_fetch_array($query);
    $currentStudentGrade   = $querydata['stdgrade']; 

    //  this is the code for the next and previous buttons
    if(!isset($_GET['studentId'])):
        $studentQuery = $db->query("SELECT `id`,`stdname` FROM `students` ORDER BY `stdname`");
    else:
        $studentId    = (int)decodeURL($_GET['studentId']);
        $nextQuery    = $db->query("SELECT `id`,`stdname` FROM `students` WHERE `id`>'{$studentId}' AND `stdgrade`='{$currentStudentGrade}'");
        $nextCount    = mysqli_num_rows($nextQuery);
        $nextData     = mysqli_fetch_array($nextQuery);
        $prevQuery    = $db->query("SELECT `id`,`stdname` FROM `students` WHERE `id`<'{$studentId}' AND `stdgrade`='{$currentStudentGrade}' ORDER BY `id` DESC");
        $prevCount    = mysqli_num_rows($prevQuery);
        $prevData     = mysqli_fetch_array($prevQuery);
    endif;      
    
    function isActive($deleted,$accomplished){//this function checks to ensure the student transferred, finished school
        if($deleted==1 || $accomplished==1):
            return false;
        endif;
        return true;
    }
?>
<div id="gradingWrapper" style="background-color:white;height:100vh;">
    <div class="container-fluid">          
        <div class="row text-center">
            <div class="col-md-12 bg-dark" style="line-height:50px; color:white;">
                <label class="float-left"> <a href="users/mystudents.php"><i class="fas fa-arrow-left"></i> Back. </a> </label>
                <label class="">STUDENT ASSESSMENT DASHBOARD</label>
                <div class="float-right mr-10">
                     <label><img src="<?=((isset($querydata['stdimage'])&& $querydata['stdimage'] !='' ? $querydata['stdimage']:$configurationData['school_logo']))?>" style="height: 30px; border-radius:50%;"alt=" <?=$logged_in_user_data['midname'];?>"></label>
                     <label><?=$querydata['stdname'];?></label> 
                </div>                
            </div><!--Closing col-md-12-->
        </div><!--Closing row div-->        
        <div class="row"> 
            <div class="col-md-3 bg-dark">
               <div class="sidenav px-2" style="color:cyan;height: 91.25vh;">
                    <div class="form-group <?=((isActive($querydata['deleted'],$querydata['accomplished']))?'':'d-none')?>">
                        <button class="btn btn-md btn-default <?=((!isset($_GET['studentId'])||empty($_GET['studentId'])?'d-none':''))?>" style="background-none;border: 1px solid cyan;color:cyan;" title="Click to generate data for the previous student in your class."><a href="<?=$_SERVER['PHP_SELF'].'?studentId='.encodeURL($prevData['id'])?>" <?=(($prevCount==0)?'disabled':'')?> style="color:cyan;"> <i class="fas fa-angle-double-left"></i> prev </a></button>
                        <button class="btn btn-md btn-default float-right <?=((!isset($_GET['studentId'])||empty($_GET['studentId'])?'d-none':''))?>" style="background-none;border: 1px solid cyan;color:cyan;" title="Click to generate data for the next student in your class."><a href="<?=$_SERVER['PHP_SELF'].'?studentId='.encodeURL($nextData['id'])?>" <?=(($nextCount==0)?'disabled':'')?> style="color:cyan;"> next <i class="fas fa-angle-double-right"></i> </a></button>
                    </div>  
                    <div class="form-group">
                        <label for="">UPI NUMBER</label>
                        <input type="text" name="" id="" class="form-control" value="<?=$querydata['registration_number']?>" readonly>
                    </div>             
                    <div class="form-group">
                        <label for="gradeFilter">GRADE</label>
                        <select name="gradeFilter" id="gradeFilter" class="form-control">
                            <?php $gradeQuery = $db->query("SELECT * FROM `grade`");//fetches akk the grades the school has from databse
                                  while($gradeData = mysqli_fetch_array($gradeQuery)) : 
                            ?>
                            <option value="<?=$gradeData['grade'];?>" <?php if($currentStudentGrade==$gradeData['grade']){echo 'selected';}?>><?=$gradeData['grade'];?></option>
                            <?php endwhile; ?>
                        </select>
                    </div>
                    <div class="form-group">
                        <label for="termFilter">TERM</label>
                        <select name="termFilter" id="termFilter" class="form-control">
                            <option value="Term 1" <?php if($currentPeriod == "Term 1"){echo 'selected';}?>>Term 1</option>
                            <option value="Term 2" <?php if($currentPeriod == "Term 2"){echo 'selected';}?>>Term 2</option>
                            <option value="Term 3" <?php if($currentPeriod == "Term 3"){echo 'selected';}?>>Term 3</option>
                        </select>
                    </div>
                    <div class="form-group">
                        <label for="">YEAR</label>
                        <input type="number" name="" id="yearFilter" class="form-control" value="<?=date("Y")?>">
                    </div>
                    <div class="form-group">
                        <button type="button" id="filterBtn" class="btn btn-md btn-default" title="Click to search." style="color:cyan;border:1px solid cyan;background:none;"><i class="fas fa-search"></i> Search.</button>
                        <button class="btn btn-default btn-md searchingSpinnerBtn d-none" type="button" style="color:cyan;none;background:none;outline:none;">
                            <span class="spinner-grow spinner-grow-sm" role="status" aria-hidden="true"></span>
                            Searching...
                        </button>
                    </div>
                </div><!--Closing sidenav div-->
            </div><!--Closing col-md-3 div-->
            <div class="col-md-9 contentDiv" style="background-color:white;height: 91.25vh;overflow:auto;">  
            <?php
            //check if the user is trying to enter marks for a student who is not in their class
            $classesArray  = explode(",", rtrim($logged_in_user_data['class_assigned'],",")); 
            if(!in_array($currentStudentGrade,$classesArray)):
                $errors[].='<b>FATAL ERROR! </b>You are trying to compromise the system integrity, since this student doesnt belong to your class. Press on the back sign.';
                displayErrors($errors);
            else:            
            ?>
                <div id="resultDiv"></div>          
                <form action="<?=$_SERVER['PHP_SELF']?>" method="post">
                <div class="row">
                    <?php 
                        $allSubjectsQuery = $db->query("SELECT * FROM `subjects` ORDER BY `subject_name`");
                        $count = 1;
                        while($allsubData = mysqli_fetch_array($allSubjectsQuery)):
                            $level = $currentStudentGrade;
                            $levelsArray = json_decode($allsubData['levels']);
                            if(in_array($level,$levelsArray,true)):?>
                            <div class="form-group col-md-6">
                                <label for=""><strong><?=$count.'. '.$allsubData['subject_name'];?></strong></label>
                                <textarea name="<?=$allsubData['id'];?>" id="" rows="5" class="form-control" placeholder="<?=$allsubData['subject_name']?>"></textarea>
                            </div>
                            <?php $count++; endif;
                        endwhile;
                    ?>
                </div>
                <?php if(isActive($querydata['deleted'],$querydata['accomplished'])) :?>
                <div class="row">
                    <div class="col-md-12">
                        <input type="submit" value="Submit Evaluation" class="btn btn-primary btn-sm">
                    </div>      
                </div>
                <?php endif;?>
                </form>
            <?php endif; ?>
            </div><!--Closing col-md-9 div-->
        </div><!--Closing row div-->
    </div><!--Closing container-fluid div--->
</div><!--Closing gradingWrapper div-->

<script>
    jQuery("#filterBtn").click(function(){
        var grade      = $("#gradeFilter").val();
        var term       = $("#termFilter").val();
        var year       = $("#yearFilter").val();
        var student_id = <?=$id?>;

        var search_parameters = {//creating an object that contains parameters for which we need to fetch data for
            STUDENT_ID    : btoa(student_id),
            STUDENT_LEVEL : btoa(grade),
            TERM          : btoa(term),
            YEAR          : btoa(year)
        };
        jQuery(".searchingSpinnerBtn").removeClass("d-none").addClass("d-inline-block");
        jQuery.ajax({
            url:'/school/subjects/search-evaluation.php',
            method:'post',
            data:search_parameters,
            success:function(data){ 
                jQuery(".searchingSpinnerBtn").removeClass("d-inline-block").addClass("d-none");
                jQuery(".contentDiv").html(data);
            },
            error:function(){
                alert("There was a problem trying to search for student evaluation.");
            }
        });
    });

    jQuery("form").submit(function(e){
        e.preventDefault();
        var formData = $(this).serialize();
        var studentDetails_Array = {
            STUDENT_ID    : <?=$id?>,
            STUDENT_GRADE : "<?=$currentStudentGrade?>"
        };
        document.cookie = "STUDENT_DETAILS="+JSON.stringify(studentDetails_Array)+"; expires=Thu, 18 Dec 2050 12:00:00 UTC; path=/";
        jQuery.ajax({
            url:'/school/subjects/evaluation.php',
            method:'post',
            data:formData,
            success:function(data){
                jQuery("#resultDiv").html(data);
            },
            error:function(){
                alert("Student could not be graded. Contact system administrator.");
            }
        });
    });

</script>