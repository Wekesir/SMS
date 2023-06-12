<!DOCTYPE html>
<html>
<head>
<?php
require_once $_SERVER['DOCUMENT_ROOT'].'/school/core/init.php';
include $_SERVER['DOCUMENT_ROOT'].'/school/includes/header.php';
$year = date('Y');


?>
<style>
#allStudentsSearch{
    border:1px solid cyan;
    padding: 15px;
    margin-bottom: 10px;
    border-radius: 15px;
    /* font-size: 13px; */
    display: none;
}
#singleStudentSearch{
    border:1px solid cyan;
    padding: 15px;
    margin-top: 20px;
    border-radius: 15px;
    /* font-size: 13px; */
    display: block;
}
#allStudentsSearch::before{
    content: 'All students filter';
    position: relative;
    top: -25px;
    padding: 5px 10px 5px;
    background: #292b2c;
    color:red;
    font-size: 13px;
}
#singleStudentSearch::before{
    content: 'Single student filter';
    position: relative;
    top: -25px;
    padding: 5px 10px 5px;
    background: #292b2c;
    color:red;
    font-size: 13px;
}
#selectRadio{
    padding: 10px;
    margin-bottom: 20px;
}
#allStudentsSearch button, #singleStudentSearch button{
    color:cyan;
    outline:none;
}
</style>
</head>
<body>   
 <div class="container-fluid">
    <div class="row">
        <div class="col-md-12 bg-dark"  style="line-height:50px; color:white;">
             <label> <a href="admin/students.php"><i class="fas fa-arrow-left"></i> Back. </a> </label>
            <label class="float-right"> VIEW STUDENTS PERFORMANCE</label>
        </div>
    </div><!--Closing row dic-->
    <div class="row">




        <div class="bg-dark col-md-3" style="color:cyan; height:91.3vh">

            <div class="form-group" id="selectRadio">
                <label for="">Select to view marks for either:</label>
                <div class="radio">
                    <label for="optradio" class="radio-inline"><input type="radio"  name="optradio" id="singleDiv" value="" <?='checked';?>  >Single Student</label>
                    <label for="optradio" class="radio-inline"><input type="radio"  name="optradio" id="manydiv" value="" >Muliple Students</label>
                </div>
            </div>

            <div id="allStudentsSearch">
                    <div class="form-group">
                        <label for="">View results from which level?</label>
                        <select name="level" id="level" class="form-control">
                                <option value=""> </option>
                            <?php
                            $gradeQuery = $db->query("SELECT * FROM grade");
                            while($gradeData = mysqli_fetch_array($gradeQuery)) :?>
                                <option value="<?=$gradeData['grade']?>"> <?=$gradeData['grade']?> </option>
                            <?php endwhile;?>
                        </select>
                    </div>
                    <div class="form-group">
                        <label for="">Student results from which term?</label>
                        <select name="term" id="term" class="form-control">
                            <option value=""></option>
                            <option value="Term 1">Term 1</option>
                            <option value="Term 2">Term 2</option>
                            <option value="Term 3">Term 3</option>
                        </select>
                    </div>
                    <div class="form-group">
                        <label for="year">Select year to view results</label>
                        <select name="year" id="year" class="form-control">
                                    <option value="" placeholder="Enter year manually"></option>
                                <?php for($y=$year;$y>=($year-10);$y--) :?>
                                    <option value="<?=$y;?>" placeholder="Enter year manually"><?=$y;?></option>
                                <?php endfor;?>
                        </select>
                    </div>
                    <div class="form-group">
                        <button class="btn btn-md" id="allstudentSearchBtn"> <i class="fas fa-search"></i> Search</button>
                    </div>
            </div><!--closing allStudentsSearch div-->

            <div id="singleStudentSearch">
                    <div class="form-group">
                        <label for="">Reg. Number</label>
                        <input type="text" id="regnumber" class="form-control" placeholder="Registration Number">
                    </div>
                    <div class="form-group">
                        <label for="">Student results in which level?</label>
                        <select name="level" id="level" class="form-control">
                                <option value=""> All levels </option>
                            <?php
                            $gradeQuery = $db->query("SELECT * FROM grade");
                            while($gradeData = mysqli_fetch_array($gradeQuery)) :?>
                                <option value="<?=$gradeData['grade']?>"><?=$gradeData['grade']?></option>
                            <?php endwhile; $db->close();?>
                        </select>
                    </div>
                    <div class="form-group">
                        <label for="">Student results from which term?</label>
                        <select name="term" id="term" class="form-control">
                            <option value="">All terms</option>
                            <option value="Term 1">Term 1</option>
                            <option value="Term 2">Term 2</option>
                            <option value="Term 3">Term 3</option>
                        </select>
                    </div>
                    <div class="form-group">
                        <button class="btn btn-md" id="singleStudentSearchBtn"> <i class="fas fa-search"></i> Search</button>
                    </div>
            </div><!--closing single student div search-->


        </div><!--closing col-md-3 div-->





        <div class="col-md-9" style="background:white;height:91.3vh;overflow:auto;">
            <div class="container">
               
                    <div id="performanceContentDiv">
                        <?php
                        $info[].='<b>Info! </b>Data filtered will be shown here';
                        displayinfo($info);
                        ?>
                    </div><!--closing performnaceContentDiv-->
               
            </div>
            

        </div><!--closing col-md-9 div-->

    </div><!--closing row div-->

 </div><!--closing container div-->
</body>
</html>
<script>
    jQuery('#allstudentSearchBtn').click(function(){

        var studentSearchData = {//object containing all the filterin goptions
            level: jQuery('#allStudentsSearch #level option:selected').val(),
            term:  jQuery('#allStudentsSearch #term option:selected').val(),
            year:  jQuery('#allStudentsSearch #year option:selected').val()
        };
       
       jQuery.ajax({
           url:'/school/includes/performance/manystudentsfilter.php',
           method:'post',
           data:{studentSearchData,studentSearchData},
           success:function(data){
               jQuery('#performanceContentDiv').html();
               jQuery('#performanceContentDiv').html(data);
           },
           error:function(){
               alert("Something went wrong trying to filter student results");
           }
       });
       
    });


    jQuery('#singleStudentSearchBtn').click(function(){

        var studentSearchData = {//object containing all the filterin goptions
            regNo: jQuery('#regnumber').val(),
            level: jQuery('#singleStudentSearch #level option:selected').val(),
            term:  jQuery('#singleStudentSearch #term option:selected').val()
        };
       
       jQuery.ajax({
           url:'/school/includes/performance/filter.php',
           method:'post',
           data:{studentSearchData,studentSearchData},
           success:function(data){
               jQuery('#performanceContentDiv').html();
               jQuery('#performanceContentDiv').html(data);
           },
           error:function(){
               alert("Something went wrong trying to filter student results");
           }
       });
       
    });


    jQuery('#allstudentSearchBtn').click(function(){
       
    });
    jQuery('#singleDiv').click(function(){
        jQuery('#allStudentsSearch').hide();
        jQuery('#singleStudentSearch').fadeIn('slow');      
    });
    jQuery('#manydiv').click(function(){
        jQuery('#singleStudentSearch').hide();
        jQuery('#allStudentsSearch').fadeIn('slow');
    });
</script>
