<style>

</style>
<?php
$dormId = (int)$_GET['dormId'];
$studentQuery = $db->query("SELECT * FROM students WHERE deleted=0 AND accomplished=0 ORDER BY stdname ASC");
?>
<div class="text-center">
    <label class="float-left">  <a href="dorms.php?dormId=<?=$dormId;?>"> <i class="fas fa-arrow-alt-circle-left"></i> Back</a> </label>
    <input type="search" style="width:60%;padding:5px;margin:10px;" placeholder="Search student name...">
</div>

<div id="tableContainer">



        <?php
        ///*****************************CODE FOR ADDING A STYDENT TO THIS DORM******************/////////////////////////////////
            if(isset($_GET['selectStudent']) && $_GET['selectStudent']>0){
                $studentId = (int)clean($_GET['selectStudent']); 
                $db->query("UPDATE students SET dorm='$dormId' WHERE id='$studentId'"); ?>
                <script>
                    window.location="dorms.php?dormId=<?=$dormId?>&add=1";
                </script>
           <?php }
        /////*******************************END FOR INSERTING INTO DORM*********************///////////// */
        ?>



<table class="table-striped table-bordered" style="width: 100%;font-size:14px;">
        <thead>
            <th class="text-center"></th>
            <th>REG. NUMBER</th>
            <th>STUDENT NAME</th>
            <th>LEVEL</th>
            <th>SELECT</th>
        </thead>
        <tbody>
            <?php
            $count=1;
            while($student = mysqli_fetch_array($studentQuery)) : ?>

                <tr>
                    <td><?=$count;?></td>
                    <td><?=$student['registration_number'];?></td>
                    <td><?=$student['stdname'];?></td>
                    <td><?=$student['stdgrade'];?></td>
                    <td>
                     <a href="dorms.php?dormId=<?=$dormId?>&add=1&selectStudent=<?=$student['id']?>">
                         <input type="radio" <?php if($student['dorm']!=''&& $student['dorm']==$dormId){echo 'checked';}?>>
                          <?php if($student['dorm']!=''&& $student['dorm']==$dormId){echo 'Member';}else{echo 'Select';}?>
                     </a>
                     
                    </td>
                </tr>

            <?php 
                $count++;
                endwhile;
                ?>
        </tbody>
    </table>
 </div>

 <script>
 jQuery('.addstudentsBtn').fadeOut();//hides the add student button

//assigning the studentthis dorm
jQuery('.selectStudentBtn').click(function(){
    var studentId = jQuery(this).attr("id");
    var dormId    = <?=$dormId?>;
    alert(studentId);
});

 //code for fetching student name
     jQuery('input[type="search"]').keyup(function(){//when a key is pressed inside the search box
        var student_name = jQuery(this).val();  //gets the value typed into the serch input
        var dormId    = <?=$dormId;?>//this is the id for the current dorm

            jQuery.ajax({
                url:'/school/boarding/helper/db.php',
                method:'POST',
                data:{student_name:student_name,dormId:dormId},
                success:function(data){//code for the UTOCOMPLETE                  
                 jQuery('#tableContainer').html();
                 jQuery('#tableContainer').html(data);                
                },
                error:function(){
                    alert("Something went wrong trying to search student");
                }
            }); 
            

    });//end of keyup function
 </script>