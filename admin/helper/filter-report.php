<?php
require_once $_SERVER['DOCUMENT_ROOT'].'/school/core/init.php';

if(isset($_POST)){
    $year      = ((isset($_POST['year'])? $_POST['year']:''));
    $toDate    = ((isset($_POST['toDate'])? $_POST['toDate']:''));
    $fromDate  = ((isset($_POST['fromDate'])? $_POST['fromDate']:''));
    $parameter = ((isset($_POST['parameter'])? $_POST['parameter']:''));

    $totalIncome = 0;
    $totalExpenditure = 0;

    if($parameter == "year"):
      $financeQ = $db->query("SELECT amount, expenditure, date_entered FROM expenditure WHERE YEAR(date_entered)='{$year}' ORDER BY id");
      $feesQ    = $db->query("SELECT amount, mode, date FROM fees_invoices WHERE YEAR(date)='{$year}' ORDER BY id");
    elseif($parameter == "date"):
      $financeQ = $db->query("SELECT amount, expenditure, date_entered FROM expenditure WHERE date_entered BETWEEN CAST('$fromDate' AS DATE ) AND CAST('$toDate' AS DATE) ORDER BY id");
      $feesQ    = $db->query("SELECT amount, mode, date FROM fees_invoices WHERE date BETWEEN CAST('$fromDate' AS DATE ) AND CAST('$toDate' AS DATE) ORDER BY id");
    endif;   
}
ob_start();
$count=1;?>
<table class="table table-striped table-bordered table-hover table-sm small_font">
  <thead class="thead-dark">
    <th></th>   
    <th>EXPE/INCOME</th>
     <th>AMOUNT</th>
    <th>DATE</th>
</thead>
 <tbody>
    <?php while($x = mysqli_fetch_array($financeQ)) : ?>
    <tr>
        <td><?=$count;?></td>
        <td><?=$x['expenditure'];?></td>
        <td><?=$x['amount'];?></td>        
        <td><?=$x['date_entered'];?></td>
    </tr>
    <?php 
      $count++;
      $totalExpenditure += $x['amount'];
      endwhile; 
      $count=1;
    ?>
    <tr class="table-primary">
        <td></td>
        <td> <b>TOTAL EXPENDITURE</b> </td>
        <td><?=$totalExpenditure?></td>
        <td></td>
    </tr>
    <?php while($y = mysqli_fetch_array($feesQ)) : ?>
    <tr>
        <td><?=$count;?></td>       
        <td><?=$y['mode'];?></td>
         <td><?=$y['amount'];?></td>
        <td><?=$y['date'];?></td>
    </tr>
    <?php 
      $count++;
      $totalIncome += $y['amount'];
      endwhile;
    ?>
    <tr class="table-primary">
      <td></td>
      <td> <b>TOTAL INCOME</b> </td>
      <td><?=$totalIncome?></td>
      <td></td>
    </tr>
</tbody>
</table>
<?php echo ob_get_clean(); ?>