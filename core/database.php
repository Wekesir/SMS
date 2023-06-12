<!DOCTYPE html>
<html>
<head>
<?php
require_once $_SERVER['DOCUMENT_ROOT'].'/school/core/init.php';
include BASEURL.'/admin/header.php';
if($logged_in_user_data['permissions']!="Super_Admin"){//restrics the super admin only to this page
    header("Location:../admin/index.php");
}
?>
<link rel="stylesheet" type="text/css" href="../css/loading-bar.css" />
<script src="/school/js/loading-bar.js" type="text/javascript"></script>
</head>
<body style="background-color:white;">
    <div id="bodyCoverDiv"></div>
    <div id="databsseContainer">
       <div id="header" class="text-center">
        <h1>DATABASE OPERATIONS</h1>
       </div>
       <div id="body">
        <div class="container">
            <div class="row">
                <?php
                $tableCount = 1;
                $result = $db->query("show tables");
                while($tableObject = mysqli_fetch_array($result)):
                    $tableCount++;
                endwhile; 
                ?>
                <div id="cleanDataDiv">
                    <h4>Reset table(s) ID</h4>
                    <label for="">Number of tables = <?=$tableCount;?></label>
                    <div id="infoResetDiv"></div>
                    <div class="progress form-group">
                        <div class="progress-bar progress-bar-striped progress-bar-animated" role="progressbar" style="width: 25%;" aria-valuenow="25" aria-valuemin="0" aria-valuemax="100">25%</div>
                    </div>
                    <div class="form-group">
                        <button class="btn btn-primary btn-sm rstBtn">
                        <span class="spinner-border spinner-border-sm" role="status" aria-hidden="true"></span>
                        Click to reset tables in database.
                        </button>
                    </div>
                </div>
            </div>
            <div class="row">
                <div class="col-md-12">
                    <div id="backUpDbDiv">
                        <h4>Backup Database</h4>
                        <div id="backUpNotificationDiv"></div>
                        <button class="btn btn-primary createBackUpBtn" type="button">
                            <span class="spinner-border spinner-border-sm" role="status" aria-hidden="true"></span>
                            <span class="">Create Backup</span>
                        </button>
                    </div>
                </div>
            </div>
        </div>
       </div>
    </div>
</body>
</html>
<script>
    //when the create backup button has been clicked
jQuery(".createBackUpBtn").click(function(){
    //send a rewuest to the exportdb.php page 
    $.ajax((){
        url:'/school/core/exportdb.php',
        method:'post',
        data:"",
        success:function(data){
            $('#backUpNotificationDiv').html(data);
        },
        error:function(){
            alert("An error occured trying to reset tables in database.");
        }
    });
});

jQuery('.rstBtn').click(function(){//when the reset db button has been clicked
   var resetDb = '';
//    $.ajax({
//        url:'/school/core/reset-db.php',
//        method:'post',
//        data:{resetDb:resetDb},
//        success:function(data){
//         jQuery('#infoResetDiv').html(data);
//        },
//        error:function(){
//            alert("An error occured trying to reset tables in database.");
//        }
//    });
});
</script>
<style>
    #backUpDbDiv{
        border: 1px solid black;
        padding: 20px;
        position:relative;     
        left: 10%;
        width: 80%;
        margin-top: 30px;
    }
    #bodyCoverDiv{
        width: 100%;
        height: 100vh;
        background: white;
        background-color: rgba(0,0,0, 0.4); /* Black w/opacity/see-through */
        background:url("https://i2.wp.com/blog.learningdollars.com/wp-content/uploads/2019/10/cleandatabase.jpg?fit=730%2C511&ssl=1") no-repeat;
        background-size:cover;
        background-position:center;
        position:relative;
        -webkit-filter: blur(4px);
        -moz-filter: blur(4px);
        -o-filter: blur(4px);
        -ms-filter: blur(4px);
        filter: blur(4px);   
    }
    #databsseContainer{
        position:absolute;
        top:0px;
        width: 100%;
        left: 10%;
        width: 80%;
    }
    #databsseContainer #header{
        border:5px solid white;
        color:white;
        padding: 10px;
        text-align:center;
        background:none;
        width: 100%;
    }
    .row{
        background-color:white;
    }
    #cleanDataDiv{
        min-height: 200px;   
        position:relative;     
        left: 10%;
        width: 80%;
        border: 1px solid black;
        padding: 20px;
    }
</style>