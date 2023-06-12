<?php
require_once $_SERVER['DOCUMENT_ROOT'].'/school/core/init.php';//database connection file
$database_entry_id = 0; //this variable holds the id for items currently being added to database

if(isset($_POST)){//is data has been sent here
   $itemId          =   (int)clean($_POST['itemId']);
   $itemQuantity    =   clean($_POST['itemQty']);
   $requestedQty    =   clean($_POST['reqstdQty']);
   $returnable      =   clean(strtoupper($_POST['itemRtrn']));//says whether the item is returnable or not
   $returned        =   (($returnable == 'NO')?'YES':'NO');//if the item is not returnable then mark it as returned else mark it as not returned.
   $returnedQty     =   (($returnable == 'NO')?'NULL':0);//quannity of the borrowed item that has been returned
   $issueDate       =   date('Y-m-d');

   $itemData[] = array(
       'ItemId'          =>  $itemId,
       'requestedQty'    =>  $requestedQty,
       'returnable'      =>  $returnable,
       'returned'        =>  $returned,
       'returnedQty'     =>  $returnedQty 
   );

   $itemsData_encoded   =   json_encode($itemData); 

   if(isset($_COOKIE['ITEM']) && $_COOKIE['ITEM'] > 0){ //makes sure that the cookie has actually been set and has a value greater than 0
       $getId       =   (int)clean($_COOKIE['ITEM']);   
       $queryData   =   mysqli_fetch_array($db->query("SELECT * FROM issueitems WHERE id='$getId'"));
       $itemArray   =   json_decode($queryData['items'], true);//array for the item already in database

       $mergeArray   =   array_merge($itemArray, $itemData);//emreged the array from databsw to the new items arrat
       $json_encoded =   json_encode($mergeArray); //encodes both new items array

       $db->query("UPDATE `issueitems` SET `items` ='$json_encoded' WHERE `id`= '$getId'");//updates the items column for the given id
   }else{
       $db->query("INSERT INTO `issueitems` (items, recipient, recipient_Id, returnable, issueDate)
                   VALUES ('{$itemsData_encoded}','','','$returnable','$issueDate') ");

       $database_entry_id = $db->insert_id; 

       setcookie("ITEM", $database_entry_id, time() + (8600), '/');//8600= 1 day
   }   

}
?>