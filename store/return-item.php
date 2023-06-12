<?php
require_once $_SERVER['DOCUMENT_ROOT'].'/school/core/init.php';
if(isset($_POST)){//if data has been received
    $dbId         =   (int)clean($_POST['databaseId']);//database id fom the issueitems table
    $itemId       =   (int)clean($_POST['itemId']);///iteem id from the storeitems table
    $borrowedQty  =   (int)clean($_POST['borrowedQty']);
    $returnedQty  =   (int)clean($_POST['returnedQty']);
    $dateTime     =   date('Y-m-d H:i:s');//current date and time
    $loggedInId   =   (int)$_SESSION['user'];//the id of the logged in user

    $query        = $db->query("SELECT * FROM `issueitems` WHERE `id`= '$dbId'");
    $queryData    = mysqli_fetch_array($query);
    $itemsDecoded = json_decode($queryData['items'],true);
    $recipientLevel = $queryData['recipient'];
    $recipientId  = (int)$queryData['recipient_Id']; 

    $newArray = array();//array that will hold the new array data
    $newQty   = 0;
    
    foreach($itemsDecoded as $item){//check all the items one by one

        $itemsDbId    = (int)$item['ItemId'];//dtabse id of this items fromm the storeitems table
        $itemsDbQuery = mysqlI_fetch_array($db->query("SELECT * FROM `storeitems` WHERE `id`='$itemsDbId'"));
        $itemsQty     = $itemsDbQuery['quantity'];

        if($item['ItemId'] == $itemId)://if the specific item has been found
            if($borrowedQty < $returnedQty):
                echo 'You can not return more than what was borrowed.'; 
            elseif($borrowedQty > $returnedQty)://returning less then what you borrowed
                $item = array(
                            'ItemId'          => $itemId,
                            'requestedQty'    => $borrowedQty,
                            'returnable'      => 'YES', 
                            'returned'        => 'NO',
                            'returnedQty'     => $returnedQty//this updates the amount of the item that has been returned.
                        );

                $grandQty = ($itemsQty + $returnedQty);
                $status = 'DUE';//shows that the borrower is yet to pay the fine
                $db->query("UPDATE `storeitems` SET `quantity`='$grandQty' WHERE `id`='$itemsDbId'");
                // $db->query("INSERT INTO storefines(item,quantity,debtor,level,status,fined_by,fined_on)
                //             VALUES ('$itemId','$newQty','$recipientId','$recipientLevel','$status','$loggedInId','$dateTime')");

                echo 'You are inserting less than the borrowed amount. The borrower is in debt.';
            else:
                $item = array(
                            'ItemId'          =>  $itemId,
                            'requestedQty'    =>  $borrowedQty,
                            'returnable'      =>  'YES',
                            'returned'        =>  'YES',
                            'returnedQty'     =>  $returnedQty//the returned amount of the original payment
                );

                $grandQty = ($itemsQty + $returnedQty);//total of whst is in the databse plus what is being returned
                $db->query("UPDATE `storeitems` SET `quantity`='$grandQty' WHERE `id`='$itemsDbId'");
                echo 'Item(s) have been returned successfully.';
            endif;
        endif; 
        $itemData[] = $item;
        $itemsData_encoded   =   json_encode(array_merge($itemData));
        $db->query("UPDATE `issueitems` SET `items`='{$itemsData_encoded}' WHERE `id`='$dbId'");
    }
}
$db->close();
?>