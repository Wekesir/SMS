<!--MODAL FOR CONFIRMING MODAL DELETE-->
<?php
require_once $_SERVER['DOCUMENT_ROOT'].'/school/core/init.php';
$restockId=(int)clean($_POST['restockId']);

$itemQuery      =    $db->query("SELECT * FROM storeitems WHERE id='$restockId'");
$itemData       =    mysqli_fetch_array($itemQuery);
$itemName       =    ((isset($_POST['item'])?strtoupper(clean(trim($_POST['item']))):$itemData['item']));
$itemQuantity   =    ((isset($_POST['quantity'])?clean(trim($_POST['quantity'])):$itemData['quantity']));
$itemUOM        =    ((isset($_POST['uom'])?clean(trim($_POST['uom'])): $itemData['uom'] ));
$itemSupplier   =    ((isset($_POST['supplier'])?clean(trim($_POST['supplier'])):$itemData['supplier']));

ob_start();
?>
     <div class="modal fade" id="restockmModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered modal-dialog-scrollable" role="document">
             <div class="modal-content">
                 <div class="modal-header">
                     <h5 class="modal-title" id="exampleModalLabel">RE-STOCK ITEM </h5>
                        <button type="button" class="close" onclick="closeRestockModal()" aria-label="Close">
                          <span aria-hidden="true">&times;</span>
                        </button>
                 </div>
                  <form action="#" method="POST" enctype="multipart/form-data">
                    <div class="modal-body">     
                        <div class="form-group">
                            <div id="callbackMessageDiv"></div>
                            <input type="hidden" class="form-group" name="restockId" value="<?=$restockId?>">
                            <input type="hidden" class="form-control" name="availQuantity" value="<?=$itemQuantity?>">
                             <input type="hidden" class="form-control" name="itemName" value="<?=$itemName?>">
                        </div>                                      
                        <div class="form-group">
                            <label for="">Item</label>
                            <input type="text" class="form-control" value="<?=$itemName?>" readonly>
                        </div>                 
                        <div class="form-group">
                            <label for="">Individual Item Quantity</label>
                            <input type="number" min=1 class="form-control" name="quantity" required=required>
                        </div>    
                        <div class="form-group">
                            <label for="">Collective Item Quantity (e.g How many packets of chalk?)</label>
                            <input type="number" min=1 class="form-control" name="groupquantity">
                        </div>                                            
                        <div class="form-group">
                            <label for="">Item UOM (e.g How many chalks are in a packet?)</label>
                            <input type="number" min=0 name="uom" class="form-control" value="<?=$itemUOM?>" readonly>
                        </div>
                        <div class="form-group">
                            <label for="">Item Supplier</label>
                            <select name="supplier" id="supplier" class="form-control">
                                <option value=""></option>
                            <?php $supplierQuery = $db->query("SELECT * FROM suppliers"); while($supplierData = mysqli_fetch_array($supplierQuery)) :?>
                                <option value="<?=$supplierData['name'];?>" <?php if($itemSupplier == $supplierData['name']){ echo 'selected';}?>> <?=$supplierData['name'];?></option>
                            <?php endwhile;?>
                            </select>
                        </div>
                        <div class="form-group">
                            <label for="">Invoice/Receipt Number</label>
                            <input type="text" name="receipt" class="form-control">
                        </div>
                        <div class="form-group">
                                <label for="">Amount Spent {Kshs.}</label>
                                <input type="number" min=0 class="form-control" name="amount">
                        </div>
                    </div>
                    <div class="modal-footer">                       
                        <button type="button" class="btn btn-sm btn-default small_font" onclick="closeRestockModal()">Cancel</button>
                        <button type="submit" class="btn btn-sm btn-primary small_font">Submit</button>
                    </div>
                 </form>       
             </div>
         </div>
</div>
<?php echo ob_get_clean();?>

<script>
jQuery("form").submit(function(event){
    event.preventDefault();
    var formData    =   $(this).serialize();
    $.ajax({
        url:'/school/store/updateitem.php',
        method:'post',
        data: formData,
        success:function(data){
            $('#callbackMessageDiv').html();
            $('#callbackMessageDiv').html(data);
            $('form').trigger("reset");//resets form data
        },
        error:function(){
            alert("Error submitting form data to restockitem.php script");
        }
    });
});
</script>