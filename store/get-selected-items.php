<?php
require_once $_SERVER['DOCUMENT_ROOT'].'/school/core/init.php';
$count = 1;

$getItemsId =   (int) ((isset($_COOKIE['ITEM'])? clean($_COOKIE['ITEM']) : ''));

if(isset($_POST['itemsRequest'])){  

    if($getItemsId == 0):
        echo '<h5 style="color:lightblue">...selected items will appear here...</h5>';
    else:
        $query        = $db->query("SELECT * FROM issueitems WHERE id= '$getItemsId'");
        $queryData    = mysqli_fetch_array($query);
        $itemsDecoded = json_decode($queryData['items'],true);
        
            ob_start(); ?> 
           
            <table class="table-striped table-bordered" style="width: 100%;">
                <thead>
                    <th>#</th>                    
                    <th>ITEM</th>
                    <th>QTY</th>
                    <th>Returnable?</th>
                    <th>Remove</th>
                </thead>
                <tbody>
                    <?php foreach($itemsDecoded as $item){ 
                        $itemId   = (int) $item['ItemId'];
                        $itemQ    = mysqli_fetch_array($db->query("SELECT * FROM storeitems WHERE id='$itemId'")); 
                        $itemName = $itemQ['item'];
                        ?>
                    <tr>
                        <td><?=$count;?></td>                        
                        <td><?=$itemName;?></td>
                        <td><?=$item['requestedQty'];?></td>
                        <td><?=$item['returnable'];?></td>
                        <td><a class="btn btn-sm btn-default text-danger removeItemBtn" data-itemId="<?=$item['ItemId']?>" title="Click to remove this item."><i class="fa fa-minus" aria-hidden="true"></i></a></td>
                    </tr>
                    <?php $count++; } ?>
                </tbody>
            </table>

        <?php  echo ob_get_clean();         
       
    endif;
}

if(isset($_POST['cancelProcess'])){//code for cancelling the diving items process
    if($getItemsId > 0)://if the items cookie has been set
        $db->query("DELETE FROM `issueitems` WHERE id='$getItemsId'");
    endif;
    setcookie("ITEM","",time() - 3600,'/');//deleting the ITEMS cookie

    if(isset($_COOKIE['STUDENT_ID'])):
        setCookie("STUDENT_ID","",time()-3600,"/");//deleting the STUDENT_ID cookie
    endif;

    if(isset($_COOKIE['STAFF_ID'])):
        setCookie("STAFF_ID","",time()-3600);//deleting the STAFF_ID cookie
    endif;
}
?>

<script>
    jQuery('.removeItemBtn').click(function(){//function for removing an item from database
        var itemId = $(this).attr('data-itemId'); 
        $.ajax({
            url:'/school/store/remove-item.php',
            method:'post',
            data:{itemId:itemId},
            success:function(){location.reload(true);},
            error:function(){alert("Something went wrong trying to remove item");}
        });
    });
</script>