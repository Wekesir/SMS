<!DOCTYPE html>
<html>
<head>
    <?php
        require_once $_SERVER['DOCUMENT_ROOT'].'/school/core/init.php';
        include '../admin/header.php';
    ?>
</head>
<body>   
    <?php include '../admin/navigation.php';?>
 <div class="container-fluid">
    <div class="row">
        <div class="col-md-3">
            <?php include '../admin/left.php';?>
        </div><!--Closing col-md-3 div-->
        <div class="col-md-9" id="wrapper">

         <button style="position:absolute;right:5%;bottom:5%;border-radius:50%;outline:none;"> <a href="gallery.php?add=1">Add</a> </button>
         <h6 class="text-center"><?=((isset($_GET['edit'])?'EDIT IMAGE ':'ADD NEW IMAGE TO SCHOOL GALLERY'));?></h6>
        
        <?php
        if(isset($_GET['add']) || isset($_GET['edit'])){//if the add or edit button is clicked the followng code should execute
            
               $description     = strtoupper(trim(clean(((isset($_POST['description'])? $_POST['description']:'')))));
               $galleryimageurl = '';

            if(isset($_GET['edit'])){
                $editId           = (int)$_GET['edit'];
                $galleryQuery     = $db->query("SELECT * FROM school_gallery WHERE id='$editId'");
                $galleryQueryData = mysqli_fetch_array($galleryQuery);
                $galleryimageurl  = '';
                $filename         = trim(clean(((isset($_FILES['image']['name'])? $_FILES['image']['name']:''))));
                    if($filename !=''){
                        $target_dir             = '/uploads/gallery/';
                        $fileDestination        = BASEURL.$target_dir.$_FILES['image']['name'];
                        $fileTempName           = $_FILES["image"]["tmp_name"];
                        $fileError              = $_FILES['image']['error'];
                        $fileSize               = $_FILES['image']['size'];
                        $galleryimageurl        = '/school/uploads/gallery/'.$_FILES['image']['name'];
                        $imageFileNameExtension = strtolower(pathinfo($filename,PATHINFO_EXTENSION));
                        $check                  = getimagesize($_FILES['image']['tmp_name']);                   
                        if($fileSize>1000000){//checks the file size
                        $errors[].='The file is too large. Please select another and try again';
                        }
                        $extensions=array('jpg','jpeg','png','gif');
                        if(!in_array($imageFileNameExtension,$extensions,TRUE)){//checks if the file extension is allowed
                        $errors[].='Only PNG, JPEG, JPG and PNG are allowed!';
                        }
                        if($check===false){//check if the file is an image
                        $errors[].='The file you chose is not an image.';
                        }
                    }
                $image            = trim(clean(((isset($filename) && $filename !=''? $galleryimageurl:$galleryQueryData['image']))));
                $description      = strtoupper(trim(clean(((isset($_POST['description'])? $_POST['description']: $galleryQueryData['description'])))));
                
            if(isset($_POST['update'])){
                    if(!empty($filename)){//move the uploaded file only if its not empty
                         move_uploaded_file($fileTempName,$fileDestination);
                         }

                    if($image != $galleryQueryData['image']){//check if the image is the same or not and if not then remove the previous image from server
                        if(unlink($_SERVER['DOCUMENT_ROOT'].$galleryQueryData['image'])){
                            $db->query("UPDATE school_gallery SET image='$image',description='$description' WHERE id='$editId'");
                        }else{//if there is aproblem deleting file from server
                            $errors[].='<b>Error! </b>Problem removing file from server.';
                            displayErrors($errors);
                        }
                    }else{
                        $db->query("UPDATE school_gallery SET image='$image',description='$description' WHERE id='$editId'");
                    }

                    $messages[].='<b>Success! </b>Gallery updated.';
                            if(!empty($messages)){
                                displayMessages($messages);
                            }
                    
                }
           
            }                    

            if(isset($_REQUEST['submit'])){
               $filename        = trim(clean(((isset($_FILES['image']['name'])? $_FILES['image']['name']:''))));
               $description     = strtoupper(trim(clean(((isset($_POST['description'])? $_POST['description']:'')))));
               $galleryimageurl = '';
               $date            = date('Y-m-d');

                    if($filename !=''){
                        $target_dir             = '/uploads/gallery/';
                        $fileDestination        = BASEURL.$target_dir.$_FILES['image']['name'];
                        $fileTempName           = $_FILES["image"]["tmp_name"];
                        $fileError              = $_FILES['image']['error'];
                        $fileSize               = $_FILES['image']['size'];
                        $galleryimageurl        = '/school/uploads/gallery/'.$_FILES['image']['name'];
                        $imageFileNameExtension = strtolower(pathinfo($filename,PATHINFO_EXTENSION));
                        $check                  = getimagesize($_FILES['image']['tmp_name']);                   
                        if($fileSize>1000000){//checks the file size
                        $errors[].='The file is too large. Please select another and try again';
                        }
                        $extensions=array('jpg','jpeg','png','gif');
                        if(!in_array($imageFileNameExtension,$extensions,TRUE)){//checks if the file extension is allowed
                        $errors[].='Only PNG, JPEG, JPG and PNG are allowed!';
                        }
                        if($check===false){//check if the file is an image
                        $errors[].='The file you chose is not an image.';
                        }
                    }

               //check if all info is provided
               if($filename == '' || $description == ''){
                   $errors[].='<b>Error! </b>Provide all the information.';
               }

               if(!empty($errors)){//if there are errors then display them
                   displayErrors($errors);
               }else{//else insert into database

                        if($filename != ''){//move the uploaded file only if its not empty
                            move_uploaded_file($fileTempName,$fileDestination);
                            }
                            $db->query("INSERT INTO school_gallery (image,description,insert_date)
                                        VALUES ('$galleryimageurl','$description','$date')");

                            $messages[].='<b>Success! </b>Image uploaded.';
                            if(!empty($messages)){
                                displayMessages($messages);
                            }
               }

            }

            ?>
            <form action="<?=((isset($_GET['edit'])?'gallery.php?edit='.$editId:'gallery.php?add=1'));?>" method="POST" enctype="multipart/form-data">               

                <div class="row">
                    <div class="col-md-6">
                        <div class="form-group">
                            <label for="image">Image*</label>
                            <?php
                            if(isset($_GET['edit']) && $_GET['edit'] != ''){
                                echo '<div class="form-group"><img src="'.$image.'" style="height: 200px;width: 170px;" alt="Image"></div>';
                            }
                            ?>
                            <input type="file" name="image" class="form-control">
                        </div>
                    </div><!--Closing col-md-6 div-->
                    <div class="col-md-6">
                        <div class="form-group">
                            <label for="description">Decription*</label>
                            <input type="text" name="description" class="form-control" value="<?=$description;?>">
                        </div>
                    </div><!--Closing col-md-6 div-->
                </div><!--Closing row div-->
                <div class="form-group">
                    <input type="submit" name="<?=((isset($_GET['edit'])?'update':'submit'));?>" value="<?=((isset($_GET['edit'])?'Update':'Submit'));?>">
                </div>
            </form>
            <?php          
        }else{

            if(isset($_GET['delete'])){//IF THE USER CLICKS DELETE ON THE MODAL
                    $delete_id=(int)$_GET['delete'];
                    $db->query("DELETE FROM `website_images` WHERE `id`='$delete_id'"); 

                    $messages[].='<b>Success! </b>Deleted from database.';
                    if(!empty($messages)){
                        displayMessages($messages);
                    }
                }

            ?>

             <table class="table-bordered table-highlight table-sm">
                    <thead>
                        <th>#</th>
                        <th>Image</th>
                        <th>Description</th>
                        <th>Insert Date</th>
                        <th></th>    
                        <th></th>                        
                    </thead>
                    <tbody>                        
                            <?php
                                $count = 1;
                                $query = $db->query("SELECT * FROM school_gallery ORDER BY id DESC");
                                while($queryData=mysqli_fetch_array($query)) :                                
                            ?>
                        <tr>
                            <td><?=$count;?></td>
                            <td><?='.<img src="'.$queryData['image'].'" style="height: 50px;width: 40px;" alt="Image">.';?></td>
                            <td><?=$queryData['description'];?></td>
                            <td><?=$queryData['insert_date'];?></td>
                            <td class="text-center">
                                <a href="gallery.php?edit=<?=$queryData['id'];?>"><button class="btn-primary small_font">Edit</button></a>
                            </td>
                            <td class="text-center">
                                <button class="btn-danger deleteBtn small_font" id="<?=$queryData['id'];?>">Delete</button>
                            </td>
                         </tr>
                            <?php
                            $count++;
                            endwhile;?>                        
                    </tbody>
                </table>

            <?php
        }
        ?>  

        </div><!--Closing col-md-9 div-->
    </div><!--Closing row dic-->
 </div><!--closing container div-->
    <?php include '../admin/footer.php';?>
</body>
</html>
<script>
jQuery(document).ready(function(){

    jQuery('.deleteBtn').click(function(){

        var delete_id=jQuery(this).attr("id");

        jQuery.ajax({
            url:'/school/modals/siteimagesdeletemodal.php',
            method:'post',
            data:{delete_id,delete_id},
            success:function(data){
                jQuery("body").append(data);
                jQuery('#deleteModal').modal("show");
            },
            error:function(){
                alert("Something went wrong trying to get id");
            },
        });
        
    });    

});//end of the document ready function

    function closeModal(){
        jQuery('#deleteModal').modal("hide");
        location.reload(true);
    }
</script>
