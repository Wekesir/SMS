<?php
$count=1;
$restockQ   =   $db->query("SELECT * FROM restock_inventory ORDER BY id DESC");
?>

<table class="table table-sm table-hover table-striped table-bordered">
    <thead class="thead-light">
        <th>#</th>
        <th>ITEM NAME</th>
        <th>QUANTITY</th>
        <th>AMOUNT(Kshs.)</th>
        <th>SUPPLIER</th>
        <th>DATE</th>
    </thead>
    <tbody id="tableBody">
        <?php while($data = mysqli_fetch_array($restockQ)) :?>
            <tr>
                <td><?=$count;?></td>
                <td><?=$data['item'];?></td>
                <td><?=$data['quantity'];?></td>
                <td><?=$data['amount'];?></td>
                <td><?=$data['supplier'];?></td>
                <td><?=$data['restock_date'];?></td>
            </tr>
        <?php $count++; endwhile;?>
    </tbody>
</table>

<script>
// searching restocked item from 
jQuery('#searchDiv input[type="text"]').keyup(function(event){
    event.preventDefault();
    var restockedItem =    $(this).val();
    $.ajax({
        url:'/school/store/fetch.php',
        method:'post',
        data:{restockedItem:restockedItem},
        success:function(data){
            $('#tableBody').html();
            $('#tableBody').html(data);
        },
        error:function(){
            alert("Something went wromng trying to search for item");
        }
    });
});
// code for searching item fom database ends here
</script>