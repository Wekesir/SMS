<div id="fleetDiv">
    <h6 class="text-center p-1">
    <label class="float-left"> <a href="/school/admin/fleet.php"><i class="fas fa-arrow-left"></i> Back.</a> </label>
    <label> <?=((isset($_GET['editVehicle']))?'EDIT SELECTED':'ADD NEW')?> VEHICLE </label>
    </h6> <hr>
    <?php
        $regNumber = "";
        $capacity  = "";
        $type      = "";
        $color     = "";
        $driver    = "";
        $vehicleimageurl = "";

    if(isset($_GET['editVehicle'])){//when the user selected edit vehicle
        $editId   = clean((int)$_GET['editVehicle']);
        $editQ    = $db->query("SELECT * FROM fleet WHERE id='$editId'");
        $editData = mysqli_fetch_array($editQ);

        $regNumber = ((isset($_POST['vehicle_reg'])) ? strtoupper(trim(clean($_POST['vehicle_reg']))) : $editData['reg_plates']);
        $capacity  = ((isset($_POST['vehicle_capacity'])) ? trim(clean($_POST['vehicle_capacity'])) : $editData['capacity']);
        $type      = ((isset($_POST['vehicle_type'])) ? strtoupper(trim(clean($_POST['vehicle_type']))) : $editData['type']);
        $color     = ((isset($_POST['vehicle_color'])) ? strtoupper(trim(clean($_POST['vehicle_color']))) : $editData['vehicle_color']);
        $driver    = ((isset($_POST['driver'])) ? trim(clean($_POST['driver'])) : $editData['driver']);
        $filename  = ((isset($_FILES['vehicle_image']['name'])) ? trim(clean($_FILES['vehicle_image']['name'])) : "");
        $vehicleimageurl = $editData['image'];

       if(isset($_POST['update']))://when the update button has been clicked
           if($filename !=''){
               if(unlink($_SERVER['DOCUMENT_ROOT'].$vehicleimageurl)){//if the previous image has been removed from server successfully
                    $target_dir         = '/uploads/vehicles/';
                    $fileDestination    = BASEURL.$target_dir.$_FILES['vehicle_image']['name'];
                    $fileTempName       = $_FILES["vehicle_image"]["tmp_name"];
                    $fileError          = $_FILES['vehicle_image']['error'];
                    $fileSize           = $_FILES['vehicle_image']['size'];
                    $vehicleimageurl    = '/school/uploads/vehicles/'.$_FILES['vehicle_image']['name'];
                    $imageFileNameExtension=strtolower(pathinfo($filename,PATHINFO_EXTENSION));
                    $check              = getimagesize($_FILES['vehicle_image']['tmp_name']);
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
                    $errors[].='<b>Error! </b>The file you chose is not an image.';
                    }
               }else{
                   die("Error trying to remove previous image from server");
               }                
            }
            if(!empty($errors)){
                displayErrors($errors);
            }else{
                if($filename!=""){//if a new image has bbeen provided
                    move_uploaded_file($fileTempName,$fileDestination);//upload the new file to server
                }
                $db->query("UPDATE `fleet` SET `reg_plates`='$regNumber',
                                                `capacity`='$capacity',
                                                `type`='$type',
                                                `driver`='$driver',
                                                `image`='$vehicleimageurl',
                                                `vehicle_color`='$color'
                                                WHERE id='$editId'");
                $messages[].='<b>Success! </b>Vehicle details updated successfully!';
                echo displayMessages($messages);
            }
       endif;
    }

    if(isset($_POST['submit'])){ 
        $regNumber = ((isset($_POST['vehicle_reg'])) ? strtoupper(trim(clean($_POST['vehicle_reg']))) : '');
        $capacity  = ((isset($_POST['vehicle_capacity'])) ? trim(clean($_POST['vehicle_capacity'])) : '');
        $type      = ((isset($_POST['vehicle_type'])) ? strtoupper(trim(clean($_POST['vehicle_type']))) : '');
        $color     = ((isset($_POST['vehicle_color'])) ? strtoupper(trim(clean($_POST['vehicle_color']))) : '');
        $driver    = ((isset($_POST['driver'])) ? trim(clean($_POST['driver'])) : '');
        $filename  = trim(clean($_FILES['vehicle_image']['name']));
        $vehicleimageurl = "";
        if($filename !=''){
            $target_dir         = '/uploads/vehicles/';
            $fileDestination    = BASEURL.$target_dir.$_FILES['vehicle_image']['name'];
            $fileTempName       = $_FILES["vehicle_image"]["tmp_name"];
            $fileError          = $_FILES['vehicle_image']['error'];
            $fileSize           = $_FILES['vehicle_image']['size'];
            $vehicleimageurl    = '/school/uploads/vehicles/'.$_FILES['vehicle_image']['name'];
            $imageFileNameExtension=strtolower(pathinfo($filename,PATHINFO_EXTENSION));
            $check              = getimagesize($_FILES['vehicle_image']['tmp_name']);
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
            $errors[].='<b>Error! </b>The file you chose is not an image.';
            }
        }
        
        if(!empty($errors)){
            echo displayErrors($errors);
        }else{
            if(!empty($filename)){//move the uploaded file only if its not empty
                move_uploaded_file($fileTempName,$fileDestination);
            }
            $db->query("INSERT INTO `fleet`(`reg_plates`, `capacity`, `type`, `driver`, `image`, `vehicle_color`)
                        VALUES ('$regNumber','$capacity','$type','$driver','$vehicleimageurl','$color')");
            $messages[].='<b>Success! </b>Vehicle details inserted successfully!';
            echo displayMessages($messages);
        }
    }
    ?>
    <form action="<?=$_SERVER['PHP_SELF'].((isset($_GET['editVehicle']) ? '?editVehicle='.$editId.'':'?addVehicle=1'))?>" method="post" enctype="multipart/form-data">
        <div class="form-group">
            <label for="">Vehicle Registration</label>
            <input type="text" class="form-control" name="vehicle_reg" required=required value="<?=$regNumber?>">
        </div>
        <div class="form-group">
            <label for="">Capacity</label>
            <input type="number" class="form-control" name="vehicle_capacity" min=1 required=required value="<?=$capacity?>">
        </div>
        <div class="form-group">
            <label for="">Vehicle Type</label>
            <input type="text" class="form-control" name="vehicle_type" required=required value="<?=$type?>">
        </div>
        <div class="form-group">
            <label for="">Vehicle Color</label>
            <input type="text" class="form-control" name="vehicle_color" required=required value="<?=$color?>">
        </div>
        <div class="form-group">
            <label for="">Vehicle Driver</label>
            <select name="driver" id="driver" class="form-control">
                <option value=""></option>
                <?php
                $userQuery = $db->query("SELECT id, name FROM users ORDER BY name");
                while($userData = mysqli_fetch_array($userQuery)) : ?>
                <option value="<?=$userData['id']?>" <?=(($driver==$userData['id'])?'selected':'')?>> <?=$userData['name']?> </option>
                <?php endwhile; ?>
            </select>
        </div>
        <div class="form-group">
            <label for="">Vehicle Image</label>
             <?php if(isset($_GET['editVehicle']) && $_GET['editVehicle'] !=''){echo '
                    <div class="form-group"><img src="'.$vehicleimageurl.'" style="height: 200px;" alt=""></div>
                    ';}?>
            <input type="file" class="form-control" name="vehicle_image">
        </div>
        <div class="form-group">
            <input type="submit" name="<?=((isset($_GET['editVehicle']) ? 'update' : 'submit'))?>" class="btn btn-primary btn-sm" value="Submit">
        </div>
    </form>
</div>

<style>
#fleetDiv{
    position:relative;
    left: 20%;
    width: 60%;
    padding: 20px;
    background:white;
}
</style>