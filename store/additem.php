<div id="addItemDiv">

    <div class="bg-light text-center" style="padding: 5px;">   
        <label for=""> <h5><?=((isset($_REQUEST['editItem'])? 'EDIT':'ADD NEW'))?> ITEM</h5> </label>
    </div>

    <?php

        $itemName       =    ((isset($_POST['item'])?strtoupper(clean(trim($_POST['item']))):'')); 
        $itemQuantity   =    ((isset($_POST['quantity'])?clean(trim($_POST['quantity'])):'')); 
        $itemUOM        =    ((isset($_POST['uom'])?clean(trim($_POST['uom'])):'')); 
        $itemThreshold  =    ((isset($_POST['threshold'])?clean(trim($_POST['threshold'])):'')); 
        $itemSupplier   =    ((isset($_POST['supplier'])?clean(trim($_POST['supplier'])):'')); 

        if(isset($_REQUEST['editItem']) && $_REQUEST['editItem'] !=0){
            $editId     =   (int) clean($_REQUEST['editItem']);
            $itemQuery  =   $db->query("SELECT * FROM storeitems WHERE id='$editId'");
            $itemData   =   mysqli_fetch_array($itemQuery);

            $itemName       =    ((isset($_POST['item'])?strtoupper(clean(trim($_POST['item']))):$itemData['item']));
            $itemQuantity   =    ((isset($_POST['quantity'])?clean(trim($_POST['quantity'])):$itemData['quantity']));
            $itemUOM        =    ((isset($_POST['uom'])?clean(trim($_POST['uom'])):$itemData['uom']));
            $itemThreshold  =    ((isset($_POST['threshold'])?clean(trim($_POST['threshold'])):$itemData['threshold']));
            $itemSupplier   =    ((isset($_POST['supplier'])?clean(trim($_POST['supplier'])):$itemData['supplier'])); 

            if(isset($_POST['update'])){
                $totalQ         =    0;
                if(empty($itemUOM)){
                    $totalQ =   $itemQuantity;
                }else{
                    $totalQ =   ($itemQuantity * $itemUOM);
                }
                $db->query("UPDATE storeitems SET 
                                item      =' $itemName',
                                quantity  = '$totalQ',
                                uom       = '$itemUOM',
                                threshold =  $itemThreshold,
                                supplier  = '$itemSupplier'
                            WHERE id='$editId'");
                $messages[].='<b>Success! </b>Your data has been updated.';
                displayMessages($messages);
            }

        }

        if(isset($_POST['submit'])){
            $itemName       =    ((isset($_POST['item'])?strtoupper(clean(trim($_POST['item']))):'')); 
            $itemQuantity   =    ((isset($_POST['quantity'])?clean(trim($_POST['quantity'])):'')); 
            $itemUOM        =    ((isset($_POST['uom'])?clean(trim($_POST['uom'])):'')); 
            $itemThreshold  =    ((isset($_POST['threshold'])?clean(trim($_POST['threshold'])):'')); 
            $itemSupplier   =    ((isset($_POST['supplier'])?clean(trim($_POST['supplier'])):'')); 
            $totalQ         =    0;

            if(empty($itemUOM)){
                $totalQ =   $itemQuantity;
            }else{
                $totalQ =   ($itemQuantity * $itemUOM);
            }

            $db->query("INSERT INTO storeitems (item, quantity, uom, threshold, supplier) 
                        VALUES ('$itemName','$totalQ','$itemUOM','$itemThreshold','$itemSupplier')");

            $messages[].='<b>Success! </b>Item added to database.';
            if(!empty($messages)){
                displayMessages($messages);
            }
        }
    ?>

    <form action="<?=((isset($_REQUEST['editItem'])?'/school/store/index.php?editItem='.$_REQUEST['editItem'].'':'/school/store/index.php?add=1'))?>" method="POST">
        <div class="form-group">
            <label for="">Item Name</label>
            <input type="text" name="item" class="form-control" required=required value="<?=$itemName?>">
        </div>
        <div class="form-group">
            <label for="">Item Quantity</label>
            <input type="number" name="quantity" class="form-control" min=0 required=required value="<?=$itemQuantity?>">
        </div>
        <div class="form-group">
            <label for="">Item UOM e.g How many pens are in a box?</label>
            <input type="number" name="uom" class="form-control" min=0 placeholder="Not applicable to all" value="<?=$itemUOM?>">
        </div>
        <div class="form-group">
            <label for="">Item Threshold</label>
            <input type="number" name="threshold" class="form-control" min=1 required=required value="<?=$itemThreshold?>">
        </div>
        <div class="form-group">
            <label for="">Item Supplier</label>
            <select name="supplier" id="supplier" class="form-control" placeholder="Optional">
                <option value=""></option>
                <?php $supplierQuery = $db->query("SELECT * FROM suppliers"); while($supplierData = mysqli_fetch_array($supplierQuery)) :?>
                    <option value="<?=$supplierData['name'];?>" <?php if($itemSupplier == $supplierData['name']){ echo 'selected';}?>> <?=$supplierData['name'];?></option>
                <?php endwhile;?>
            </select>
        </div>
        <div class="form-group">
            <input type="submit" class="btn btn-md" name="<?=((isset($_REQUEST['editItem'])?'update':'submit'))?>" value="<?=((isset($_REQUEST['editItem'])?'Update Item':'Submit'))?>">
        </div>
    </form>
</div>
<style>
#addItemDiv{
    position:relative;
    margin-left: 20%;
    width: 60%;
    padding: 25px;
    /* box-shadow: 5px 5px lightgrey; */
    border: 1px solid lightgrey;
    background: white;
}
</style>