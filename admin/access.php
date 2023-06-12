
<!DOCTYPE html>
<html>
<head>
    <?php
        require_once $_SERVER['DOCUMENT_ROOT'].'/school/core/init.php';
        include '../admin/header.php'; ?>
</head>
<body>   
    <?php include '../admin/navigation.php';?>
 <div class="container-fluid">
    <div class="row">
        <div class="col-md-3">
            <?php include '../admin/left.php';?>
        </div><!--Closing col-md-3 div-->
        <div class="col-md-9" id="wrapper">    
            <div class="titleHeader text-center">
                <h6>PERMISSIONS & ACCESS LEVELS</h6>
            </div>   
            <div id="permissionsDiv">
                <table class="table table-bordered" style="width:100%;">
                    <thead>
                        <th>#</th>
                        <th>NAME</th>
                        <th>CLASS(ES) ASSIGNED</th>
                        <th>ACCESS LEVEL(S)</th>
                    </thead>
                    <tbody id="tbody">
                    </tbody>
                </table>
            </div>
        </div><!--Closing col-md-9 div-->
    </div><!--Closing row dic-->
 </div><!--closing container div-->
    <?php include '../admin/footer.php';?>
</body>
</html>

<script>
jQuery(document).ready(function(){
   getPermissionData();
});

function getPermissionData(){
    var permissionData = ''; 
    jQuery.ajax({
        url:'/school/admin/access/data.php',
        method:'post',
        data:{permissionData:permissionData},
        success:function(data){
            jQuery('#permissionsDiv #tbody').html(data);
        },
        error:function(){
            alert("Something went wrong trying to get permissions data.");
        }
    });
}
</script>

<style>
#permissionsDiv{
    height: 83vh;
    padding: 10px;
    border: 1px solid lightgrey;
    overflow-y:auto;
}

</style>