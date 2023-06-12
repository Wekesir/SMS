<?php
require_once $_SERVER['DOCUMENT_ROOT'].'/school/core/init.php';//database connection file

$dataQuery = $db->query("SELECT * FROM `salarypayment_dates` ORDER BY id DESC");
?> 

<table class="table table-striped table-bordered" style="width: 100%">
    <thead>
        <th>#</th>
        <th>DATE</th>
    </thead>
    <tbody>
        <?php $count=1; while($data=mysqli_fetch_array($dataQuery)): ?>
            <tr>
                <td><?=$count;?></td>
                <td><?=date("jS F, Y", strtotime($data['paymentDate']));?></td>
            </tr>
        <?php $count++; endwhile;?>
    </tbody>
</table>