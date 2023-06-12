<?php
require_once $_SERVER['DOCUMENT_ROOT'].'/school/core/init.php';

if(isset($_POST)){
    $restockId   =    (int)clean($_POST['restockId']);
    $quantity    =    clean($_POST['quantity']);
    $groupQ      =    clean(((isset($_POST['groupquantity']) && !empty($_POST['groupquantity']) ? $_POST['groupquantity']:0)));
    $availQ      =    clean($_POST['availQuantity']);
    $itemName    =    clean($_POST['itemName']);
    $uom         =    clean($_POST['uom']);
    $supplier    =    clean($_POST['supplier']);
    $receipt     =    clean($_POST['receipt']);
    $amount      =    decimal(clean($_POST['amount']));//decimal is a function that ensures to dp on the value enntered
    $totalQ      =    0;
    $newQ        =    0;
    $date        =    date('Y-m-d');

    if($quantity != 0){
        if($uom==0 && $groupQ !=0){
            $errors[].='<b>Fatal Error! </b>This product item does not have a UOM set. Try entering Individual quanity or editing item and continue.';
        }else{
            $newQ   =   ($quantity + ($groupQ * $uom));
            $totalQ =   ($newQ + $availQ);
        }
    }else if($quantity == 0){
        if($uom==0 && $groupQ !=0){
            $errors[].='<b>fatal Error! </b>This product item does not have a UOM set. Try entering Individual quanity or editing item and continue.';
        }else{
             $newQ   =   ($groupQ * $uom);
             $totalQ =   ($newQ + $availQ);
        }
    }

    if(!empty($errors)){
        echo displayErrors($errors);
    }else{

         $expenditure='PURCHASE OF '.$totalQ.' '.$itemName.'';

         $db->query("UPDATE storeitems SET quantity = '$totalQ' WHERE id='$restockId' ");

         $db->query("INSERT INTO expenditure (expenditure, amount, date_entered)
                                    VALUES ('$expenditure','$amount','$date')");
        
         $db->query("INSERT INTO restock_inventory (item, quantity, amount, supplier, restock_date) 
                                        VALUES ('$itemName','$newQ','$amount','$supplier','$date')");
    }
    
}

$db->close();
?>