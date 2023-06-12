<!DOCTYPE html>
<html>
<head>
    <?php
        require_once $_SERVER['DOCUMENT_ROOT'].'/school/core/init.php';
        include '../admin/header.php';
        //check if the school has access to thid food programme page
        if($configurationData['food'] == 'NO'){ header("Location:/school/admin/index.php");}
    ?>
    <link rel="stylesheet" href="/school/foodProgramme/styling.css">
</head>
<body>   
    <?php include '../admin/navigation.php';?>
 <div class="container-fluid">
    <div class="row">
        <div class="col-md-3">
            <?php include '../admin/left.php'; ?>
        </div><!--Closing col-md-3 div-->
        <div class="col-md-9" id="wrapper">
           <?php include dirname(__DIR__)."/foodProgramme/index.php"?>
        </div><!--Closing col-md-9 div-->
    </div><!--Closing row dic-->
 </div><!--closing container div-->
    <?php include '../admin/footer.php';?>
</body>
</html>


