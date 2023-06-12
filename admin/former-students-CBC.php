<!DOCTYPE html>
<html>
<head>
    <?php require_once $_SERVER['DOCUMENT_ROOT'].'/school/core/init.php'; include '../admin/header.php';?>
</head>
<body>   
    <?php include '../admin/navigation.php';?>
 <div class="container-fluid">
    <div class="row">
        <div class="col-md-3">
            <?php include '../admin/left.php';?>
        </div><!--Closing col-md-3 div-->
        <div class="col-md-9" id="wrapper">        
            <div style="display:block;" id="searchDiv">  
               <label class="float-left">
                    <a href="/school/admin/students.php">Back</a>
               </label>             
               <input type="search" name="search_student" placeholder="Search student name">    
            </div>
            <?php
            $students = $db->query("SELECT * FROM `students` WHERE `deleted`=1 OR `accomplished`=1 ORDER BY `stdname` ASC");
            if(mysqli_num_rows($students)==0):
                $info[].='<b>Oops! </b>No records of former students have been found.';
                displayinfo($info);
            endif;
            ?>
            <table class="table table-sm table-hoverable table-bordered table-striped">
                <thead class="thead-light">
                    <tr>
                    <th scope="col">#</th>
                    <th scope="col">UPI NUMBER</th>
                    <th scope="col">NAME</th>
                    <th scope="col">LEVEL</th>
                    <th scope="col">VIEW</th>
                    <th scope="col">DOCS</th>
                    <th scope="col">EVAL</th>
                    <th scope="col">INFO</th>
                    <th scope="col">YEAR</th>
                    </tr>
                </thead>
                <tbody id="tableBody">
                    <?php
                    $count = 1;                    
                    while($student_data=mysqli_fetch_array($students)) : ?>
                        <tr>       
                            <th scope="row"><?=$count;?></th>                             
                            <td><?=$student_data['registration_number'];?></td>
                            <td><?=$student_data['stdname'];?></td>
                            <td><?=$student_data['stdgrade'];?></td>
                            <td class="text-center"><a href="#"  id="<?=$student_data['id'];?>" class=" view_student" title="Click to view student information."><i class="fas fa-eye"></i> view</a>                            
                            <td class="text-center"> <a href='#' id="<?=$student_data['id'];?>" class="documents text-center" id="<?=$student_data['id'];?>" title="Click to view student documents."> <i class="fas fa-folder-open"></i> docs. </a> </td>
                            <td><a href="/school/gradestudent.php?studentId=<?=encodeURL($student_data['id'])?>" title="Click to view evaluation for this student.">evaluation.</a></td>
                            <td><?=(($student_data['deleted']==1) ? '<span class="badge badge-warning">Transferred.</span>' : '<span class="badge badge-info">Completed</span>')?></td>
                            <td><?=(($student_data['deleted']==1) ? date("jS F, Y", strtotime($student_data['delete_date'])): $student_data['accomplished_year'])?></td>
                        </tr>
                    <?php
                    $count++;
                    endwhile; ?>
                </tbody>
            </table>
        </div><!--Closing col-md-9 div-->
    </div><!--Closing row dic-->
 </div><!--closing container div-->
    <?php include '../admin/footer.php';?>
</body>
</html>
<script>
   jQuery("input[name='search_student']").keyup(function(e){
       e.preventDefault();
       var formerCbcNameSearch = btoa(jQuery(this).val()); 
        jQuery.ajax({
            url:"/school/admin/students/fetch.php",
            method:"POST",
            data:{formerCbcNameSearch:formerCbcNameSearch},
            success:function(data){
                jQuery("#tableBody").html(data);
            },
            error:function(){
                alert("There is a problem trying to fetch student");
            }
        });
   });
   jQuery('.view_student').click(function(event){//this is the view button clicked for the student
        event.preventDefault();
        var student_id=jQuery(this).attr("id");
            jQuery.ajax({
                url:'/school/modals/viewstudentmodal.php',
                method:'post',
                data:{student_id:student_id},
                success:function(data){
                    jQuery('body').append(data);//includes the modal in this page
                    jQuery('#viewModal').modal({
                        backdrop:'static', keyboard:false
                    });//toggles the modal
                },
                error:function(){
                    alert("Something went wrong viewing student info");
                },
            });
    });  
    jQuery('.documents').click(function(e){//when the documents btn is clicked
        e.preventDefault();
        var student_id=jQuery(this).attr("id");    
            jQuery.ajax({
                url:"/school/modals/studentdocuments.php",
                method:"POST",
                data:{student_id:student_id},
                success:function(data){
                    jQuery('body').append(data);
                    jQuery('#documents_modal').modal({
                        backdrop:'static',keyboard:false
                    });//displays the documents modal
                },
                error:function(){
                    alert("Something went wrong");
                },
            });
    });
    function closeDeleteStudentDocModal(){//function for closing deletestudentmodal
        jQuery('#documents_modal').modal("hide");
        window.location='/school/admin/former-students-CBC.php';
    };
</script>


