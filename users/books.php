<?php
require_once $_SERVER['DOCUMENT_ROOT'].'/school/core/init.php';
include '../users/header.php';
include '../users/navigation.php';

$gradeQuery=$db->query("SELECT * FROM grade");//select the grade from the database
$gradeData=mysqli_fetch_array($gradeQuery);
$gradeId=$gradeData['id'];
?>
<div class="container-fluid">

<div class="row">

<div class="col-md-3">
<?php include '../users/left.php';?>
</div><!--clossing col-sm 3 div-->

<div class="col-sm-9" id="wrapper">

<h5 class="text-center"><b>BOOKS</b></h5>

    <div class="row">
        <div class="col-md-7">
            <table class="table table-bordered table-striped table-highlight" >
                <thead>
                    <th>#</th>
                    <th>GRADE</th>
                    <th>VIEW BOOKS</th>                    
                </thead>
                <tbody>
                    <?php 
                    $count=1;
                    while($gradeData=mysqli_fetch_array($gradeQuery)) :?>

                    <tr id="rowId<?=$count;?>">
                        <td><?=$count;?></td>
                         <td><?=$gradeData['grade'];?></td>
                         <td>
                             <button class="btn-xs btn-info view exsmall_font" id="<?=$gradeData['id'];?>">View</button>
                         </td>                        
                    </tr>
                    <?php
                    $count++;
                    endwhile;?>
                </tbody>
            </table>

          

        </div><!--closing col-md-7 div-->

        <div class="col-md-5">

            <div class="display_books"></div>

       

        </div><!--Closing col-md 5 div-->
    </div><!--closing row div-->

    </div><!--closing col-sm-9 div-->
    </div><!--closing main row div-->

<?php //include '../admin/footer.php'; ?>
</div><!--closing container-fluid div-->


<script>

    jQuery('.view').click(function(){
        var grade_id=jQuery(this).attr("id");
          jQuery('.display_books').val();

            jQuery.ajax({
                url:"/school/admin/fetch.php",
                method:'post',
                data:{grade_id:grade_id},
                success:function(data){                   
                    jQuery('.display_books').html(data);
                },
                error:function(){
                    alert("Something went wrong.");
                },
            });
    });

    jQuery('.displaydeletemodalbtn').click(function(){
        alert("Button clickeed");
    });
</script>
























































































































































































































































