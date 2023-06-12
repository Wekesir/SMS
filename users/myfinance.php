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
                <div class="col-md-9"id='wrapper'>
                <h6 class="text-center bg-light p-3">MY FINANCIAL STATEMENT.</h6>
                
                   <table class="table-striped table-bordered table table-sm">
                    <thead>
                        <tr>
                        <th role="col">#</th>
                        <th role="col">DATE</th>
                        <th role="col">DETAILS</th>
                        <th role="col">AMOUNT(Kshs.)</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php 
                        $count=1;
                        $staffId = (int)$_SESSION['user'];
                        $query= $db->query("SELECT * FROM staff_invoices WHERE staff_id='$staffId' ORDER BY id DESC");
                        while($queryData = mysqli_fetch_array($query)) :?>
                            <tr>
                                <th role="row" class="text-center"><?=$count;?></th>
                                <td><?=date("jS F, Y", strtotime($queryData['date']))?></td>
                                <td><?=$queryData['details'];?></td>
                                <td><?=decimal($queryData['amount'])?></td>
                            </tr>
                        <?php
                        $count++;
                        endwhile;
                            ?>
                    </tbody>
                   </table>
                
                </div><!--Closing col-md-9 div-->
            </div><!--Closing row div-->
        </div><!--Closing container-fluid t\div-->

     <?php include '../users/footer.php';?>
</body>
</html>