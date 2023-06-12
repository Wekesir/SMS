<!DOCTYPE html>
<html>
<head>
    <?php require_once $_SERVER['DOCUMENT_ROOT'].'/school/core/init.php'; include '../admin/header.php';?>
</head>
<body>   
    <?php include '../admin/navigation.php';?>
 <div class="container-fluid">
    <div class="row">
        <div class="col-md-3">
            <?php include '../admin/left.php';?>
        </div><!--Closing col-md-3 div-->
        <div class="col-md-9" id="wrapper">        
        <?php
        if(isset($_GET['viewmarks']) && $_GET['viewmarks']>0){
             include '../admin/students/viewperformance.php';
        }else{
        if(isset($_GET['addstudent']) && $_GET['addstudent']==1 ||isset($_GET['edit']) && isset($_GET['edit'])>0){
             include '../admin/students/addformerstudent.php';
        }else{
        if(isset($_GET['addmarks']) && $_GET['addmarks']>0 ||isset($_GET['editmarks']) && isset($_GET['editmarks'])>0){
             include '../admin/students/formerstudents.php';
        }else{
            include '../admin/students/formerstudentshome.php';
        }}}
        ?>  
        </div><!--Closing col-md-9 div-->
    </div><!--Closing row dic-->
 </div><!--closing container div-->
    <?php include '../admin/footer.php';?>
</body>
</html>


