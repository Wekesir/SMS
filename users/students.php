<!DOCTYPE html>
<html>
<head>
   <?php 
   include '../users/header.php';?>
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
                    <?php
                    $count = 1;        
                    /////////////PAGINAIOTN CODE STARTS HERE//////////////////
                    $maxLimit = 100;//number of rows to be displayed on aech page
                    $totalStudents = mysqli_num_rows($db->query("SELECT * FROM students WHERE deleted=0 AND accomplished=0"));
                    $page = (int)((isset($_GET['page'])? $_GET['page']: 1));//gets the age number from the url
                    $minLimit = ($page - 1) * $maxLimit;
                    $totalPages = ceil($totalStudents/$maxLimit);
                    ?>
                    <nav aria-label="Page navigation example">
                        <ul class="pagination pagination-sm">
                            <li class="page-item"><a class="page-link" href="#">Previous</a></li>
                            <?php for($p = 1; $p <= $totalPages; $p++) :?>
                            <li class="page-item"><a class="page-link" href="students.php?page=<?=$p;?>"><?=$p;?></a></li>
                            <?php endfor;?>
                            <li class="page-item"><a class="page-link" href="#">Next</a></li>
                        </ul>
                    </nav>
                    <!---------------PAGINATION CODE ENDS HERE------------------->    
                    <div id="table-container" style="height: 75.5vh;overflow:auto;width: 100%;padding: 10px;">    
                    <table class="table table-sm table-bordered table-striped table-hoverable">
                        <thead class="thead-light">
                            <tr>
                            <th scope="col">#</th>
                            <th scope="col">REG. NUMBER</th>
                            <th scope="col">STUDENT NAME</th>
                            <th scope="col">LEVEL</th>
                            <th scope="col">GENDER</th>   
                            </tr>        
                        </thead>
                        <tbody id="tbody"><!--The fist option of the if condition is for data that has been searched -->
                        <?php             
                            $students=$db->query("SELECT * FROM students WHERE deleted=0 ORDER BY stdname ASC");
                            while( $student_data=mysqli_fetch_array($students)) :?>
                            <tr>       
                            <th scope="row"><?=$count;?></th>                              
                            <td><?=$student_data['registration_number'];?></td>
                            <td><?=$student_data['stdname'];?></td>
                            <td><?=$student_data['stdgrade'];?></td>
                            <td><?=$student_data['stdgender'];?></td>                   
                            </tr>
                        <?php $count++; endwhile; ?>
                        </tbody>
                    </table>
                    </div>
                </div>
        </div><!--Closing col-md-6 div-->
    </div><!--closing row div-->
</div><!--closing container-fluid div-->    
    <?php include '../users/footer.php';?>
</body>

<script>

jQuery('#search_student').keyup(function(){//when a key is pressed inside the search box
var searchStudent=$(this).val();
jQuery(".spinner-border").addClass("active");
    jQuery.ajax({
        url:'/school/users/fetch.php',
        method:'POST',
        data:{searchStudent:searchStudent},
        //dataType:'json',
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
