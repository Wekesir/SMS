<!DOCTYPE html>
<html>
<head>
   <?php 
   include '../users/header.php';
   $errors=array();
   $messages=array();
   ?>
</head>
<body>
<?php  include '../users/navigation.php';?>

<div class="container-fluid">

<div class="row">

<div class="col-md-3">
    <?php include '../users/left.php';?>
</div>

<div class="col-md-9" id="wrapper">
    <div class="container-fluid">
        <div class="col-md-12">
            <?php
                if(isset($_REQUEST['editmarks']) && $_REQUEST['editmarks'] > 0){
                    include 'performance/editmarks.php';
                }else{
                    include 'performance/performancehome.php';
                }
            ?>
        </div>
    </div>

     

</div><!--Closing wrapper div-->
</div><!--closing row div-->
    </div><!--closing container-fluid div-->
    
    <?php include '../users/footer.php';?>
</body>

