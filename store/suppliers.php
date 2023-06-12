<?php
$suppliersQ =   $db->query("SELECT * FROM suppliers ORDER BY id DESC");
if(mysqli_num_rows($suppliersQ) == 0){
    $errors[].='<b>Oops! </b>No data found to display.';
}else{ ?>

    <table class="table-bordered table-striped table table-sm table-hover">
        <thead class="thead-light">
            <th>#</th>
            <th>SUPPLIER NAME</th>
            <th>PHONE NUMBER</th>
            <th>EMAIL</th>
            <th>DATE ENTERED</th>
            <th>ACTIONS</th>
        </thead>
        <tbody id="tableBody">
            <?php while($data = mysqli_fetch_array($suppliersQ)) : ?>
            <tr>
                <td><?=$count;?></td>
                <td><?=$data['name'];?></td>
                <td><?=$data['phone'];?></td>
                <td><?=$data['email'];?></td>
                <td><?=$data['entered_on'];?></td>
                <td>
                    <label for=""> <a href="/school/store/index.php?editSupplier=<?=$data['id']?>" class="text-success" title="Edit supplier info."> <i class="fas fa-pencil-alt"></i> Edit</a> </label>
                    <label for=""> <a href="#" class="text-danger deleteSupplier" id="<?=$data['id'];?>" title="Delete supplier."><i class="fas fa-trash-alt"></i> Delete</a> </label>
                </td>
            </tr>
            <?php $count++; endwhile;?>
        </tbody>
    </table>

<?php } ?>
<script>
function closeDeleteSupplierModal(){
     $('#deleteSupplierModal').modal("hide");
     location.reload(true);
}

jQuery('.deleteSupplier').click(function(event){
    event.preventDefault();
    var supplierId =    $(this).attr("id");
    $.ajax({
        url:'/school/modals/deletesupplier.php',
        method:'post',
        data:{supplierId:supplierId},
        success:function(data){
            $('body,html').append(data);
            $('#deleteSupplierModal').modal({
                keyboard:false,
                backdrop:'static'
            });
        },
        error:function(){
            alert("There was a problem trying to delete supplier");
        }
    });
});
</script>