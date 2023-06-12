<?php
require_once $_SERVER['DOCUMENT_ROOT'].'/school/core/init.php';
$removeItemId = (int)clean($_POST['itemId']); 
$dbId         = (int)clean($_COOKIE['ITEM']);

$queryData    = mysqli_fetch_array($db->query("SELECT * FROM `issueitems` WHERE id='$dbId'"));
$itemsDecoded = json_decode($queryData['items'],true);

$newArray   = array();//array holding the new items to be added

foreach($itemsDecoded as $item){
    if($item['ItemId'] != $removeItemId){    
            $newArray[] = $item;
    }
}
$newArrayEncode = json_encode(array_merge($newArray));
$db->query("UPDATE issueitems SET items='{$newArrayEncode}' WHERE id='$dbId'");
?>