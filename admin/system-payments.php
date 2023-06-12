<!DOCTYPE html>                      
<html>
<head>
    <?php require_once $_SERVER['DOCUMENT_ROOT'].'/school/core/init.php'; include '../admin/header.php'; ?>
</head>
<body>   
<?php include '../admin/navigation.php';?>
 <div class="container-fluid">
    <div class="row">
        <div class="col-md-3">
            <?php include '../admin/left.php';?>
        </div><!--Closing col-md-3 div-->
        <div class="col-md-9" id="wrapper">
        <h5>System Payments.</h5>
           <div class="container">
           <div class="row">
                <div class="col-md-4 p-2">
                    <div>
                        <h6>SCHOOL ACC. BALANCE</h6>
                        <label class="h3">Kshs. <?=decimal(0)?></label>
                    </div>
                    <hr>
                    <div>
                        <p>AMOUNT DUE:</p>
                        <label class="h3">Kshs. <?=decimal(0)?></label>
                    </div>
                </div>
                <div class="col-md-4"></div>
                <div class="col-md-4"></div>
           </div>
           </div>
        </div><!--Closing col-md-9 div-->
    </div><!--Closing row div-->
 </div><!--closing container div-->
<?php include '../admin/footer.php';?>
</body>
</html>

