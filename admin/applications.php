<!DOCTYPE html>
<html>
<head>
        <?php
        require_once $_SERVER['DOCUMENT_ROOT'].'/school/core/init.php';
         if(!logged_in()){
            not_logged_in_page_redirect();
        }
        include '../admin/header.php';
        $errors=array();
        $messages=array();
        ?>
</head>
<body>
<?php  include '../admin/navigation.php';?>
<div class="container-fluid">

            <div class="row">

                <div class="col-md-3">
                    <?php include '../admin/left.php';?>
                </div><!--closing col-sm 3 div-->

                    <div class="col-sm-9" id="wrapper">
        <?php
        //CODE FOT DELETING APPLICATION WHEN DELETE IS CLICKED FROM MODAL
        if(isset($_GET['deleteApplication'])){

            $deleteApplicationId = (int)$_GET['deleteApplication'];
            $applicationQuery = $db->query("SELECT * FROM applications WHERE id='$deleteApplicationId'");
            $applicationQueryData = mysqli_fetch_array($applicationQuery);
            $imageDir = $_SERVER['DOCUMENT_ROOT'].$applicationQueryData['stdimage'];

            if(unlink($imageDir)){
                $db->query("DELETE FROM applications WHERE id='$deleteApplicationId'");
                $messages[].='<b>Success! </b>Application deleted.';
                if(!empty($messages)){
                    displayMessages($messages);
                }
            }else{
                $errors[].='<b>Error! </b>Failed ti delete application.';
                if(!empty($errors)){
                    displayErrors($errors);
                }
            }

        }


        $query=$db->query("SELECT * FROM applications ORDER BY id DESC");
        //checks if the number of rows is zero
                if(mysqli_num_rows($query) == 0){
                    echo '<div class="alert alert-danger alert-dismissable" role="alert"><strong>Sorry!</strong> No applications submitted yet.</div>';
                }

        if(isset($_GET['delete'])){//when the delete button is clicked
            $deleteid=(int)$_GET['delete'];
            delete_application($deleteid);
        }
        if(isset($_GET['approve'])){//when the approve button is clicked
            $approveId=(int)$_GET['approve'];
            approve_application($approveId);
        }


                while($queryData=mysqli_fetch_array($query)) :
            ?>
                <div class="bg-light applicationsdiv" style="margin-botton:2px; padding:10px;font-size:11px;">
                    <div class="row">
                        <div class="col-sm-5" >
                            <img src="<?=$queryData['stdimage'];?>" style="width:85px;height:90px; padding-left:20px;" alt="<?=$queryData['stdname'];?>">
                        </div><!--closing col-sm-5 div-->
                        <div class="col-sm-7 form-group" >
                        
                                <p>NAME:  <b><?=$queryData['stdname'];?></b></p>
                                <p>GRADE: <b><?=$queryData['stdgrade'];?></b></p>

                                <a href="applications.php?approve=<?=$queryData['id'];?>"><button class="btn-success btn-xs"><?php if($queryData['status']==0){echo 'Approve';}else{echo 'Approved';}?></button></a>
                                <a class="deleteApplication" id="<?=$queryData['id'];?>"><button class="btn-danger btn-xs " >Delete</button></a> 
                                
                            
                        </div><!---closing col-sm 7 div-->               
                    </div><!--closing row div-->
                </div><!--closing applications div-->
                <hr style="line-weight:10px;">
                <?php endwhile; ?>
            <?php include '../admin/footer.php';?>
      </div><!--closing col-sm-9 div-->
      </div><!--closing row div-->
 </div><!--Closing container-fluid div-->
</body>
</html>

<script>
function closeDeleteApplicationModal(){
     jQuery("#deleteapplicationmodal").modal("hide");
     window.location='/school/admin/applications.php';
}

jQuery('.deleteApplication').click(function(){
    var applicationId=jQuery(this).attr("id"); 

    jQuery.ajax({
        url:'/school/modals/deleteapplication.php',
        method:'post',
        data:{applicationId:applicationId},
        success:function(data){
            jQuery("body").append(data);
            jQuery("#deleteapplicationmodal").modal("show");
        },
        error:function(){
            alert("Something went wrong");
        },
    });

});
</script>