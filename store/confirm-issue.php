<?php
require_once $_SERVER['DOCUMENT_ROOT'].'/school/core/init.php';//database connection

$issueTo   = clean(strtoupper($_POST['issueTo']));
$studentId = (int)((isset($_COOKIE['STUDENT_ID'])? clean($_COOKIE['STUDENT_ID']):''));
$staffId   = (int)((isset($_COOKIE['STAFF_ID'])? clean($_COOKIE['STAFF_ID']):''));
$itemsId   = (int)((isset($_COOKIE['ITEM'])? clean($_COOKIE['ITEM']):''));

$issueToId = 0; 

//check if either one of the cookies has been set
if($studentId==0 && $staffId==0){
    echo 'Error! Make sure a recipient has been provided!';
}else{
    //check if any items have been selected
    if($itemsId == 0):
        echo 'Error! Please select items to give out.';
    else:
        if($issueTo == 'STUDENT'):
            $issueToId = $studentId;
        elseif($issueTo == 'STAFF'):
            $issueToId = $staffId;
        endif;

        $query        = $db->query("SELECT * FROM issueitems WHERE id= '$itemsId'");
        $queryData    = mysqli_fetch_array($query);
        $itemsDecoded = json_decode($queryData['items'],true);

        foreach($itemsDecoded as $item){//here we need to check whether the request can be completed by comparing the requested quantity with the available quantity
            $id        = (int)$item['ItemId'];//id of the individual item from database
            $itemsData = mysqli_fetch_array($db->query("SELECT * FROM `storeitems` WHERE id='$id'"));
            $availQ    = $itemsData['quantity'];

            if($availQ < $item['requestedQty'])://if the available qty is less than what is available
                echo $itemsData["item"].' is less than what you have requested!';
                break;
            else:
                $newQty = ($itemsData['quantity'] - $item['requestedQty']);
                $db->query("UPDATE `storeitems` SET quantity='$newQty' WHERE id='$id'");
                $db->query("UPDATE `issueitems` SET recipient='$issueTo',recipient_Id='$issueToId' WHERE id='$itemsId'");
                 setcookie("ITEM","",time() - 3600,'/');//deleting the ITEMS cookie
                 setCookie("STUDENT_ID","",time()-3600,"/");//deleting the STUDENT_ID cookie
                 setCookie("STAFF_ID","",time()-3600);//deleting the STAFF_ID cookie
                 echo 'Item(s) successfully given out.';
            endif;
        }

    endif;
}
?>