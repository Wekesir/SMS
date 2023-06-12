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
        <div class="col-md-9 bg-light" id="wrapper">
            <?php
            if(isset($_REQUEST['editVehicle']) || isset($_REQUEST['addVehicle']))://if the edit button has been clicked
                include 'fleet/fleet-helper.php';
            else:
            
            function getName($id){//gets the name of the user
                global $db;
                $userData = mysqli_fetch_array($db->query("SELECT `name` FROM `users` WHERE `id`='$id'"));
                return $userData['name'];
            }
            
            ?>
            <h4>Fleet Management</h4>
            <table class="table table-hover table-sm table-striped table-bordered">
                <thead class="thead-light">
                    <th>#</th>
                    <th>VEHICLE</th>
                    <th>DRIVER</th>
                    <th>CAPACITY</th>
                    <th>TYPE</th>
                    <th>COLOR</th>
                    <th>IMAGE</th>
                    <th>ACTIONS</th>
                </thead>
                <tbody>
                    <?php
                        $count=1;
                        $vehicleQ = $db->query("SELECT * FROM `fleet` ORDER BY id");
                        while($row=mysqli_fetch_array($vehicleQ)) : 
                    ?>
                    <tr>
                        <td><?=$count;?></td>
                        <td><?=$row['reg_plates'];?></td>
                        <td><?=getName($row['driver']);?></td>
                        <td><?=$row['capacity'];?></td>
                        <td><?=$row['type'];?></td>
                        <td><?=$row['vehicle_color'];?></td>
                        <td> <a href="#" class="showImage" id="<?=$row['image'];?>"><i class="far fa-image"></i> image</a></td>
                        <td>
                            <a href="<?=$_SERVER['PHP_SELF'].'?editVehicle='.$row['id'].''?>" class="text-success"> <i class="fas fa-pencil-alt"></i> edit. </a>
                            <a href="#" class="text-danger deleteVehicle" id="<?=$row['id']?>"> <i class="fas fa-trash-alt"></i> delete. </a>
                        </td>
                    </tr>
                    <?php $count++; endwhile;?>
                </tbody>
            </table>

            <a href="/school/admin/fleet.php?addVehicle=1" class="btn btn-primary btn-md p-10 rounded-circle position-fixed" style="bottom: 5%;right: 3%;" title="Click to add fleet."> <i class="fas fa-plus"></i> </a>

            <?php endif;?>

        </div><!--Closing col-md-9 div-->
    </div><!--Closing row dic-->
 </div><!--closing container div-->
    <?php include '../admin/footer.php';?>
</body>
</html>

<script>
jQuery(".deleteVehicle").click(function(e){//when the delete button has been clicked
    e.preventDefault();
    var delId = $(this).attr("id");
   if(confirm('Are you sure you want to delete this vehicle?')){
       $.ajax({
           url:"/school/admin/fleet/delete-fleet.php",
           method:"POST",
           data:{delId:delId},
           success:function(data){
            alert(data);
            location.reload(true);
           },
           error:function(){
               alert("An error has occured trying to delete vehicle!");
           }
       });
   }
});

function closeviewImageModal(){
    $("#viewImagemodal").modal("hide");
    location.reload(true);
}

jQuery(".showImage").click(function(e){
    e.preventDefault();
    var imageSource = $(this).attr("id");
    $.ajax({
        url:"/school/modals/viewimage.php",
        method:"POST",
        data:{imageSource,imageSource},
        success:function(data){
            $("body").append(data);
            $("#viewImagemodal").modal({
                keyboard:false,
                backdrop:"static"
            });
        },
        error:function(){
            alert("There was an error tryint to view image!");
        }
    });
});
</script>

