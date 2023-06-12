<?php
$count=1;
$query = $db->query("SELECT users.name,staff_invoices.id,staff_invoices.details,staff_invoices.amount,staff_invoices.date
                    FROM users,staff_invoices
                    WHERE users.id=staff_id
                    AND users.id !=1
                    ORDER BY staff_invoices.id DESC");        
?>
<h6 class="text-center" style="color:black;background:#f8f8f8;padding:10px;">FINANCIAL REPORT.</h6>
<div class="container-scrollable">
    <table class="table table-striped table-bordered table-sm table-hover">
        <thead class="thead-dark">
            <th></th>
            <th>NAME</th>
            <th>DETAILS</th>
            <th>AMOUNT(Kshs.)</th>
            <th>DATE</th>
        </thead>
        <tbody>
            <?php while($queryData = mysqli_fetch_array($query)) :?>
                <tr>
                    <td class="text-center"><?=$count;?></td>
                    <td><?=$queryData['name'];?></td>
                    <td title="<?=$queryData['details']?>"><?=cutstring($queryData['details'], 15, $end='...');?></td>
                    <td><?=decimal($queryData['amount']);?></td>
                    <td><?=$queryData['date'];?></td>
                </tr>
            <?php $count++; endwhile; ?>
        </tbody>
    </table>            
</div><!--Closing container scrollable class-->
                        