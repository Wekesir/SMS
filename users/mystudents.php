<!DOCTYPE html>
<html>
<head>
   <?php 
   include '../users/header.php';   $count=1;
   ?>
</head>
<body>
<?php  include '../users/navigation.php';?>
<div class="container-fluid">
<div class="row">
<div class="col-md-3">
    <?php include '../users/left.php';?>
</div>
<div class="col-md-9" id="wrapper">   
    <div class="container"> 
        <?php
            if(!isset($_GET['level'])){
                $info[].='<b>Oops! </b>Go to <b>my students</b> on the sidenavigation and select a level.'; 
                displayInfo($info);
            }else{ 
        ?>
            <div class="input-group mb-3 mx-auto w-50 mt-1">
            <input type="search" name="search_student" id="search_student" class="form-control" placeholder="Search student name" aria-label="Recipient's username" aria-describedby="button-addon2">
            <div class="input-group-append">
                <button class="btn btn-primary ml-2" type="button" id="button-addon2" disabled>
                    <span class="spinner-border spinner-border-sm" role="status" aria-hidden="true"></span>
                    Search Student
                </button>
            </div>
            </div>
            
            <div class="row" >        
                <table class="table-bordered table-striped" style="width: 100%;">
                    <thead>
                        <tr>
                        <th scope="row">#</th>
                        <th scope="row">REG. NUMBER</th>
                        <th scope="row">STUDENT NAME</th>
                        <th scope="row">LEVEL</th>
                        <th scope="row">GENDER</th>             
                        <th scope="row">EVALUATE.</th>
                        <td scope="row">MARKS</td>
                        </tr>
                    </thead>
                    <tbody id="tbody"><!--The fist option of the if condition is for data that has been searched -->
                    <?php                      
                        $myclass=decodeURL($_GET['level']);
                        $students=$db->query("SELECT * FROM students WHERE deleted=0 AND stdgrade='$myclass' ORDER BY stdname ASC");
                        while( $student_data=mysqli_fetch_array($students)) :
                    ?>
                    <tr>      
                        <th scope="row"><?=$count;?></th>                              
                        <td><?=$student_data['registration_number'];?></td>
                        <td><?=$student_data['stdname'];?></td>
                        <td><?=$student_data['stdgrade'];?></td>
                        <td><?=$student_data['stdgender'];?></td>                   
                        <td class="text-center"> <a href="../gradestudent.php?studentId=<?=encodeURL($student_data['id']);?>" class="btn btn-default btn-xs text-center text-primary" id="<?=$student_data['id'];?>"> <i class="fas fa-poll"></i> evaluate</a> </td>
                        <td class="text-center"> <a href="#" class="btn btn-default btn-xs text-center marksBtn" id="<?=encodeURL($student_data['id']);?>"> <i class="fas fa-poll"></i> marks</a> </td>
                    </tr>
                    <?php $count++; endwhile; }?>
                    </tbody>
                </table>       
            </div>
</div><!--Closing wrapper div-->
</div><!--closing row div-->
    </div><!--closing container-fluid div-->
    <?php include '../users/footer.php';?>
</body>

<script>
function closegradingmodal(){
     jQuery('#gradingmodal').modal("hide");
     location.reload(true);
}

jQuery('.marksBtn').click(function(event){
    event.preventDefault();
    var studentId       =   $(this).attr("id");
    $.ajax({
        url:'/school/modals/gradingmodal.php',
        method:'post',
        data:{studentId:studentId},
        success:function(data){
            jQuery("body,html").append(data);
            jQuery('#gradingmodal').modal({
                keyboard:false,
                backdrop:'static'
            });
        },
        error:function(){
            alert("Something  went wrong trying to view student marks");
        }
    });
});

function closeGradeStudentModal(){
    jQuery('#grading_modal').modal("hide");
    location.reload(true);
}

jQuery('.grade').click(function(){//when the grade student btn is clicked
var gradeStudent_id=jQuery(this).attr("id");      alert(document_id);
    jQuery.ajax({
        url:"/school/modals/gradestudentsmodal.php",
        method:"POST",
        data:{gradeStudent_id:gradeStudent_id},
        success:function(data){
            jQuery('body').append(data);
            jQuery('#grading_modal').modal("show");//displays the gradestudent modal
        },
        error:function(){
            alert("Something went wrong");
        },
    });
});

jQuery('#search_student').keyup(function(){//when the input loses focus search box
    jQuery(".spinner-border").addClass("active");
    var student_name=$(this).val();
    var search_student_level = "<?=$_GET['level']?>";
        jQuery.ajax({
            url:'/school/admin/fetch.php',
            method:'POST',
            data:{student_name:student_name,search_student_level:search_student_level},
            success:function(data){//code for the UTOCOMPLETE
                jQuery(".spinner-border").removeClass("active");
                jQuery('#tbody').html(data);
            },
            error:function(){
                alert("Something went wrong trying to search student");
            }
        });
});//end of keyup function
</script>
