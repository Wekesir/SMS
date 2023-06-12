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
            <div class="container-fluid">           
            <h5 class="py-2">Salaries</h5>
            <div class="row">
                <div class="col-3">
                    <div class="nav flex-column nav-pills" id="v-pills-tab" role="tablist" aria-orientation="vertical">
                    <a class="nav-link active" id="v-pills-home-tab" data-toggle="pill" href="#v-pills-home" role="tab" aria-controls="v-pills-home" aria-selected="true">Home</a>
                    <a class="nav-link" id="v-pills-pay-tab" data-toggle="pill" href="#v-pills-pay" role="tab" aria-controls="v-pills-pay" aria-selected="false">Pay Salaries</a>
                    <a class="nav-link" id="v-pills-report-tab" data-toggle="pill" href="#v-pills-report" role="tab" aria-controls="v-pills-report" aria-selected="false">Financial Report</a>
                    <a class="nav-link" id="v-pills-previous-tab" data-toggle="pill" href="#v-pills-previous" role="tab" aria-controls="v-pills-previous" aria-selected="false">Previous Payments</a>
                    </div>
                </div>
                <div class="col-9">
                    <div class="tab-content" id="v-pills-tabContent">
                    <div class="tab-pane fade show active" id="v-pills-home" role="tabpanel" aria-labelledby="v-pills-home-tab"><?php include "../admin/salaries/home.php";?></div>
                    <div class="tab-pane fade" id="v-pills-pay" role="tabpanel" aria-labelledby="v-pills-pay-tab"><?php include "../admin/salaries/paysalaries.php";?></div>
                    <div class="tab-pane fade" id="v-pills-report" role="tabpanel" aria-labelledby="v-pills-report-tab"><?php include "../admin/salaries/financialreport.php";?></div>
                    <div class="tab-pane fade" id="v-pills-previous" role="tabpanel" aria-labelledby="v-pills-previous-tab"><?php include "../admin/salaries/salary-dates.php";?></div>
                    </div>
                </div>
            </div>
            </div>
        </div><!--Closing col-md-9 div-->
    </div><!--Closing row dic-->
 </div><!--closing container div-->
    <?php include '../admin/footer.php';?>
</body>
</html>

