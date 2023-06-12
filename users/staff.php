<!DOCTYPE html>
<html>
<head>
<?php
require_once $_SERVER['DOCUMENT_ROOT'].'/school/core/init.php';
include '../users/header.php';?>

</head>
<body>
    <?php include '../users/navigation.php';?>
        <div class="container-fluid">
            <div class="row">
                <div class="col-md-3">
                    <?php include '../users/left.php';?>    
                </div><!--Closing col-md-3 div-->
                <div class="col-md-9"id="wrapper">
                <div class="input-group my-3 w-50 mx-auto">
                    <input type="search" class="form-control" placeholder="Name.." aria-label="Recipient's username" aria-describedby="button-addon2">
                    <div class="input-group-append">
                       <button class="btn btn-primary ml-1" type="button" disabled>
                            <span class="spinner-border spinner-border-sm" role="status" aria-hidden="true"></span>
                            Search
                        </button>
                    </div>
                </div>              
                <table class="table table-bordered table-striped table-sm">
                    <thead>    
                        <tr>
                        <th role="col">#</th>      
                        <th role="col">NAME</th>
                        <th role="col">EMAIL</th>
                        <th role="col">LEVEL</th>
                        </tr>
                    </thead>
                    <tbody id="tbody">
                    <?php 
                        $query=$db->query("SELECT * FROM users WHERE deleted=0 AND id !=1 ORDER BY id DESC"); 
                        $count=1; 
                        while($empArray=mysqli_fetch_array($query)):?>
                        <tr>   
                            <th role="row"><?=$count;?></th>     
                            <td><?=$empArray['name'];?></td>
                            <td><?=$empArray['email'];?></td>
                            <td><?=rtrim($empArray['class_assigned'],",");?></td>              
                        </tr>
                        <?php $count++; endwhile; ?>    
                    </tbody>
                </table>
                </div><!--Closing col-md-9 div-->
            </div><!--Closing row div-->
        </div><!--Closing container-fluid div-->
     <?php include '../users/footer.php';?>
</body>
</html>

<script>
    jQuery("input[type='search']").keyup(function(){//when a key is pressed inside the search box
    var staff_name = jQuery(this).val();
    jQuery('.spinner-border').addClass("active")
        jQuery.ajax({
            url:'/school/admin/fetch.php',
            method:'POST',
            data:{staff_name:staff_name},
            success:function(data){//code for the UTOCOMPLETE
                jQuery(".spinner-border").removeClass("active");
                jQuery('#tbody').html(data);
            },
            error:function(){
                alert("Something went wrong trying to search staff");
            }
        });
    });
</script>