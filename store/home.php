<?php
$count      =   1;
$itemQuery  =   $db->query("SELECT * FROM storeitems ORDER BY item ASC");
$itemCount  =   mysqli_num_rows($itemQuery);


/**********************************************************************************************************
  *DELETING ITEM FROM STORE
  *********************************************************************************************************/
  if(isset($_REQUEST['deleteItem']) && $_REQUEST['deleteItem'] > 0){
    $deleteId   =   (int) clean($_REQUEST['deleteItem']);
    $db->query("DELETE FROM storeitems WHERE id='$deleteId'");
    $messages[].='<b>Success! </b>Item deleted from store.';
    displayMessages($messages);
  }

if($itemCount == 0){
    $info[].='<b>Oops! </b>No items found in store';
}else{ ?>


<table class="table table-hover table-striped table-bordered">
    <thead class="thead-light">
        <th>#</th>
        <th>ITEM</th>
        <th>QUANTITY</th>
        <th>UOM</th>
        <th>THRESHOLD</th>
        <th>SUPPLIER</th>
        <th>ACTIONS </th>
    </thead>
    <tbody id="tableBody">
        <?php while($data = mysqli_fetch_assoc($itemQuery)) :?>
            <tr>
                <td><?=$count;?></td>
                <td><?=$data['item'];?></td>
                <td class="<?=(($data['quantity']<$data['threshold'])?'table-warning':'')?>"><?=$data['quantity'];?></td>
                <td><?=((isset($data['uom']) && $data['uom']!=0 ? $data['uom']:'N/A'));?></td>
                <td><?=$data['threshold'];?></td>
                <td><?=$data['supplier'];?></td>
                <td>
                    <label> <a href="#" class="text-info restock" id="<?=$data['id'];?>" title="Restock Item."> <i class="fa fa-plus" aria-hidden="true"></i> Restock </a> </label>
                    <label> <a href="/school/store/index.php?editItem=<?=$data['id'];?>" class="text-primary" title="Edit Item."> <i class="fas fa-pencil-alt"></i> Edit </a> </label>
                    <label> <a href="/school/store/index.php" class="text-danger deleteItem" id="<?=$data['id'];?>" title="Delete Item."> <i class="fas fa-trash"></i> Delete. </a> </label>
                </td>
            </tr>
        <?php $count++; endwhile;?>
    </tbody>    
</table>


<?php } ?>

<script>
// searching item from 
jQuery('#searchDiv input[type="text"]').keyup(function(event){
    event.preventDefault();
    var searchItem =    $(this).val();
    $.ajax({
        url:'/school/store/fetch.php',
        method:'post',
        data:{searchItem:searchItem},
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

function closeRestockModal(){
     $('#restockmModal').modal("hide");
     location.reload(true);
}

jQuery('.restock').click(function(event){
    event.preventDefault();
    var restockId   =   $(this).attr("id");
    $.ajax({
        url:'/school/modals/restockitem.php',
        method:'post',
        data:{restockId,restockId},
        success:function(data){
            $('body').append(data);
            $('#restockmModal').modal({
                keyboard:false,
                backdrop:'static'
            });
        },
        error:function(){
            alert("An error occured trying to restock item");
        }
    });
});

function closeDeleteItemModal(){
      $('#deleteItemModal').modal("hide");
      location.reload(true);
}

jQuery('.deleteItem').click(function(event){
    event.preventDefault();
    var deleteId    =   jQuery(this).attr("id"); 
    $.ajax({
        url:'/school/modals/deleteItem.php',
        method:'post',
        data:{deleteId,deleteId},
        success:function(data){
            $('body').append(data);
            $('#deleteItemModal').modal({
                keyboard:false,
                backdrop:'static'
            });
        },
        error:function(){
            alert("Something went wrong trying to delete Item.");
        }
    });
});
</script>