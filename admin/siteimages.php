<!DOCTYPE html>
<html>
<head>
    <?php
    require_once $_SERVER['DOCUMENT_ROOT'].'/school/core/init.php';//databsae connection 
    include '../admin/header.php';//includes the header file ?>
</head>
<body>   
<?php include '../admin/navigation.php';?>
 <div class="container-fluid">
    <div class="row">
        <div class="col-md-3">
            <?php include '../admin/left.php';?>
        </div><!--Closing col-md-3 div-->
        <div class="col-md-9 bg-light" id="wrapper">   
        <div class="container">   
        <h5 class="text-left p-2 bg-light">Website Images.</h5>
            <?php
            //DECLARE VARIABLES
            $image       = "";
            $description = "";

            //WHEN THE EDIT BUTTON  HAS BEEN CLICKED
            if(isset($_REQUEST['editImage']) && $_REQUEST['editImage']>0):
                $editId    = (int)clean($_REQUEST['editImage']);//gets the id from the URL
                $editQuery = $db->query("SELECT * FROM `website_images` WHERE `id`='{$editId}'");
                if(mysqli_num_rows($editQuery)==0):
                    $errors[].='<b>Error! </b>The requested entry does not exist in database.';
                    displayErrors($errors);
                else:
                    $editData    = mysqli_fetch_array($editQuery);
                    $description = ((isset($_POST['description'])? $_POST['description']:$editData['description']));
                    $image       = $editData['image'];

                    if(isset($_POST['update']))://when the update button has been clicked
                       $description = ((isset($_POST['description'])? $_POST['description']:$editData['description']));
                       if($filename !=''){
                            $target_dir             =   '/uploads/school/';
                            $fileDestination        =   BASEURL.$target_dir.$_FILES['image']['name'];
                            $fileTempName           =   $_FILES["image"]["tmp_name"];
                            $fileError              =   $_FILES['image']['error'];
                            $fileSize               =   $_FILES['image']['size'];
                            $schoolimageurl         =   '/school/uploads/school/'.$_FILES['image']['name'];
                            $imageFileNameExtension =   strtolower(pathinfo($filename,PATHINFO_EXTENSION));
                            $check                  =   getimagesize($_FILES['image']['tmp_name']);
                            if(file_exists($fileDestination)){//check if file already exists
                            $errors[].='<b>Error! </b>File already exists!';
                            }
                            if($fileSize>1000000){//checks the file size
                            $errors[].='<b>Error! </b>The file is too large. Please select another and try again';
                            }
                            $extensions=array('jpg','jpeg','png','gif');
                            if(!in_array($imageFileNameExtension,$extensions,TRUE)){//checks if the file extension is allowed
                            $errors[].='<b>Error! </b>Only png, jpeg, jpg and png are allowed!';
                            }
                            if($check===false){//check if the file is an image
                            $errors[].='<b>Error! </b>The file you chose is not not an image.';
                            }
                            //remove the previous image from server
                            if(unlink($_SERVER['DOCUMENT_ROOT'].$editData['image'])):
                                move_uploaded_file($fileTempName,$fileDestination);
                                $image = $schoolimageurl;//the image variable takes the input value of the new file neng uploaded
                            else:
                                $errors[].='<b>Error! </b>A problem was encountered trying to remove image from server.';
                                displayErrors($errors);
                            endif;                         
                        }  
                        $db->query("UPDATE `website_images` SET `image`='{$image}',`description`='{$description}' WHERE id='{$editId}'");    
                        $messages[].='<b>Success! </b>Image Info has been updated.';
                        displayMessages($messages);           
                    endif;
                endif;//end of the update button event
            endif;

            //ADDING A NEW ENTRY
            if(isset($_POST['submit'])):
                $description = ((isset($_POST['description'])?$_POST['description']:''));
                $filename    = trim(clean($_FILES['image']['name']));
                if($filename !=''){
                    $target_dir='/uploads/school/';
                    $fileDestination=BASEURL.$target_dir.$_FILES['image']['name'];
                    $fileTempName =$_FILES["image"]["tmp_name"];
                    $fileError=$_FILES['image']['error'];
                    $fileSize=$_FILES['image']['size'];
                    $schoolimageurl='/school/uploads/school/'.$_FILES['image']['name'];
                    $imageFileNameExtension=strtolower(pathinfo($filename,PATHINFO_EXTENSION));
                    $check=getimagesize($_FILES['image']['tmp_name']);
                    if(file_exists($fileDestination)){//check if file already exists
                    $errors[].='<b>Error! </b>File already exists!';
                    }
                    if($fileSize>1000000){//checks the file size
                    $errors[].='<b>Error! </b>The file is too large. Please select another and try again';
                    }
                    $extensions=array('jpg','jpeg','png','gif');
                    if(!in_array($imageFileNameExtension,$extensions,TRUE)){//checks if the file extension is allowed
                    $errors[].='<b>Error! </b>Only png, jpeg, jpg and png are allowed!';
                    }
                    if($check===false){//check if the file is an image
                    $errors[].='<b>Error! </b>The file you chose is not not an image.';
                    }
                    move_uploaded_file($fileTempName,$fileDestination);
                }
                $db->query("INSERT INTO `website_images`(`image`, `description`, `date`) VALUES ('{$schoolimageurl}','{$description}','{$todayDate}')");
                $messages[].='<b>Success! </b>This image has been uploaded.';
                displayMessages($messages);
            endif;

            //DELETING IMAGE FROM SERVER
            if(isset($_REQUEST['delete']) && $_REQUEST['delete']>0):
                $deleteId = (int)clean($_REQUEST['delete']);
                //check if the image exists in database
                $deleteQuery = $db->query("SELECT * FROM `website_images` WHERE `id`='{$deleteId}'");
                if(mysqlI_num_rows($deleteQuery) == 0):
                    $errors[].='<b>Error! </b>The image does not exist or has been deleted already.';
                    displayErrors($errors);
                else:
                    $deleteData = mysqli_fetch_assoc($deleteQuery);
                    if(unlink($_SERVER['DOCUMENT_ROOT'].$deleteData['image'])){//removes the image from server
                        $db->query("DELETE FROM `website_images` WHERE id='{$deleteId}'");
                        $messages[].='<b>Success! </b>The image has been deleted.';
                        displayMessages($messages);
                    }else{//if the image can not be removed from  server
                        $errors[].='<b>Error! </b>The image could not be removed from server.';
                        displayErrors($errors);
                    }
                endif;
            endif;
            ?>            

            <button id="addWebImageBtn" class="btn btn-primary" title="Add Contact"><i class="fas fa-plus"></i></button>
            
            <div class="row">
                <?php
                $count = 1;
                $imageQuery = $db->query("SELECT * FROM `website_images`");
                while($queryData = mysqli_fetch_array($imageQuery)):
                ?>
                <div class="col-md-3">
                    <div class="row">
                        <dic class="col-md-12">
                            <img src="<?=$queryData['image']?>" class="img-thumbnail" style="height:200px; width: auto;" alt="...">
                        </dic>
                    </div>
                    <div class="row">
                        <div class="col-md-12 form-group">
                            <label for="" class="font-weight-bold">Description</label>
                            <div class="p-2" style="height: 100px; overflow:auto;border: 1px solid lightgrey;"><?=$queryData['description']?></div>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-md-12">
                           <button class="btn btn-outline-primary btn-sm text-primary"><a href="/school/admin/siteimages.php?editImage=<?=$queryData['id']?>"><i class="fas fa-pencil-alt"></i> edit.</a></button>
                           <button class="btn btn-outline-danger btn-sm text-danger deleteBtn" id="<?=$queryData['id'];?>"><i class="fas fa-trash-alt"></i> delete.</button>
                        </div>
                    </div>                    
                </div>
                <?php $count++; endwhile;?>
            </div>   
            <div id="gall_Images_InputDiv" class="<?=((isset($_REQUEST['editImage']))?'d-block':'d-none')?> mx-auto">
                 <h6 class="text-center bg-light p-3 font-weight-bold"><?=((isset($_GET['editImage'])?'EDIT':'ADD'))?> WEBSITE IMAGE.</h6>
                 <form action="<?=$_SERVER['PHP_SELF'].((isset($_GET['editImage'])?'?editImage='.$editId :''))?>" method="post" enctype="multipart/form-data">
                    <div class="form-group">
                        <label class="font-weight-bold">IMAGE</label>
                        <?php if(isset($_GET['editImage'])):?>
                        <div class="m-3"><img src="<?=$image?>" alt="Image" style="height: 200px;width: auto"></div>
                        <?php endif;?>
                        <input type="file" name="image" id="image" class="form-control" <?=((isset($_GET['editImage'])?"":"required=required"))?>>
                    </div>
                    <div class="form-group">
                        <label class="font-weight-bold">DESCRIPTION</label>
                        <textarea name="description" id="description" cols="20" class="form-control" rows="5" required=required value="<?=$description?>"><?=$description?></textarea>
                    </div>
                    <div class="form-group">
                        <input type="submit" name="<?=((isset($_GET['editImage'])?'update':'submit'))?>" value="<?=((isset($_GET['editImage'])?'Update':'Submit'))?>" class="btn btn-sm btn-primary">
                        <button class="btn btn-sm btn-danger cancelBtn">Cancel</button>
                    </div>
                 </form>   
            </div>    
        </div><!--!closing the container div-->    
        </div><!--Closing col-md-9 div-->
    </div><!--Closing row div-->
 </div><!--closing container div-->
<?php include '../admin/footer.php';?>
</body>
</html>

<script>
jQuery("#addWebImageBtn").click(function(){
    jQuery(this).addClass("d-none");//hide this button
    jQuery("#gall_Images_InputDiv").removeClass("d-none").addClass("d-block");
});

jQuery(".cancelBtn").click(function(e){//when the cancel button has been clicked
    e.preventDefault();
    jQuery("#gall_Images_InputDiv").removeClass("d-block").addClass("d-none");
    jQuery("#addWebImageBtn").removeClass("d-none");
    window.location= "/school/admin/siteimages.php";
});

jQuery(".deleteBtn").click(function(){//when the delete button hasn been clicked
    var deleteId = jQuery(this).attr("id");//captures the Id of the entry in database
    if(confirm("Proceed to delete Image?")){
       window.location= "/school/admin/siteimages.php?delete="+deleteId;
    }
});
</script>

