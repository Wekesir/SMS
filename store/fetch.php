<?php   
require_once $_SERVER['DOCUMENT_ROOT'].'/school/core/init.php';
$count=1;

if(isset($_POST['showitemsId']) && $_POST['showitemsId']>0){
    $id           = (int)clean($_POST['showitemsId']);
    $query        = $db->query("SELECT * FROM `issueitems` WHERE `id`= '$id'");
    $queryData    = mysqli_fetch_array($query);
    $itemsDecoded = json_decode($queryData['items'],true);
    ob_start(); ?>
        <table class="table table-hover table-sm table-bordered table-condensed">
            <thead class="thead-light">
                <th>#</th>
                <th>ITEM</th>
                <th>QTY</th>
                <th>Returned?</th>
                <th></th>
            </thead>
            <tbody>
                <?php foreach($itemsDecoded as $item){
                    $itemId      = (int)$item['ItemId'];
                    $borrowedQty = $item['requestedQty'];
                    $itemData    = mysqli_fetch_array($db->query("SELECT * FROM `storeitems` WHERE `id`='$itemId'"));
                    /**THE NOT RETURNED VARIABLE HAS A COUPLE OF CHECKS
                     * checks whether the item is returnable and if no then outpouts nothing, if the item is returbale:
                     * checks to see whether the returnedQty varibale has been set which is only set after an item has actually bee n returned
                     */
                    $notReturned = (($item['returnable'] == 'YES')? ($item['requestedQty'] - $item['returnedQty']) :'');
                    ?>
                    <tr>
                        <td><?=$count?></td>
                        <td>
                             <?=$itemData['item'];?>
                        </td>
                        <td>
                            <?=$borrowedQty;?>
                        </td>
                        <td>
                            <?=(($item['returnable'] == 'YES')? (($item['returned']=='NO'? ' <span class="text-danger"> ('.$notReturned.') Not Returned</span> ':' <span class="text-primary">Returned</span>')) : '<b>N/A</b>')?>
                        </td>
                        <td>
                            <?=(($item['returnable'] == 'YES')? (($item['returned']=='NO'? '<a href="#" title="Click to return borrowed items." class="btn btn-sm btn-primary returnItemsBtn" data-returnitemId='.$itemId.' data-borrowedQty='.$borrowedQty.' data-databaseId='.$id.' >Return Item(s)</a>' :'<b>N/A</b>')) : '')?>
                        </td>
                    </tr>
                <?php $count++; }?>
            </tbody> 
        </table>
        <button type="button" class="close" data-dismiss="alert" aria-label="Close" onclick=closeWindow()>
            <span aria-hidden="true">&times;</span>
        </button>
    <?php echo ob_get_clean();
}



/****************************************************************************************************************
 * VERIFY STAFF NAME BEFORE ISSUING ITEM
 ****************************************************************************************************************/
if(isset($_POST['staffVerify'])){
    $staffName  =   clean(strtoupper($_POST['staffVerify']));
    if(empty($staffName)):
        $errors[].='<b>Error! </b>Provide a name to verify';
        echo displayErrors($errors);
    elseif(!empty($staffName)):
        $query=$db->query("SELECT * FROM users WHERE deleted=0 AND id !=1 AND name LIKE '%".$staffName."%' ORDER BY id DESC");
        if(mysqli_num_rows($query) == 0){
            $info[].='<b>Oops! </b>No data matching your search was found'; 
            echo displayInfo($info);
        }else{
            ob_start(); ?>
                <table class="table-bordered" style="width: 100%;">
                    <tbody>
                        <?php  while($data = mysqli_fetch_array($query)):?>
                        <tr>
                            <td><?=$count;?></td>
                            <td><?=$data['name'];?></td>
                            <td><input type="checkbox" name="" class="selectedStaff" id="<?=$data['id'];?>"> Select</td>
                        </tr>
                        <?php $count++; endwhile;?>
                    </tbody>
                </table>                
            <?php 
            echo ob_get_clean();
        }
    endif;
}

/*****************************************************************************************************************
 * VERIFY STUDENTS REGISTRATION NUMBER BEFORE ISSUING ITEM
 *****************************************************************************************************************/
if(isset($_POST['verReg'])){
    $verReg = clean($_POST['verReg']);
    if(empty($verReg)){
        $errors[].='<b>Error! </b>Provide Reg, Number'; echo displayErrors($errors);
    }elseif(!empty($verReg)){
        $query       = $db->query("SELECT * FROM students WHERE deleted=0 AND accomplished=0 AND registration_number='$verReg'");
        if(mysqli_num_rows($query)==0):
            $errors[].='<b>Error! </b>Student not found.'; echo displayErrors($errors);
        else:
            $data        = mysqli_fetch_assoc($query);
            $studentName = $data['stdname']; echo'<label data=id="'.$data['id'].'">'.$studentName.'<b></b></label>';
            $studentId = (int)$data['id'];

            if(!isset($_COOKIE['STUDENT_ID'])):
                setCookie("STUDENT_ID", $studentId, time()+8600, '/');
            elseif(isset($_COOKIE['STUDENT_ID'])):
                setCookie("STUDENT_ID", "", time()-3600, '/');//kill the previous cookie
                setCookie("STUDENT_ID", $studentId, time()+8600, '/');//set same cookie with new value
            endif;

        endif;       
    }
}

/*******************************************************************************************************************
 * CODE FOR SEARCHING ITEM FROM STORE TO ISSUE
 *******************************************************************************************************************/
if(isset($_POST['itemName']) && !empty($_POST['itemName'])){
    $itemName = strtoupper(trim(clean($_POST['itemName'])));
    ob_start();
    $itemQuery  =   $db->query("SELECT * FROM storeitems WHERE item LIKE '%".$itemName."%'");
    if(mysqli_num_rows($itemQuery) == 0):
        $errors[].='<b>Oops! </b>No item matching your search was found.'; echo displayErrors($errors);
    else: ?>
       <table class="table-bordered table-striped" style="font-size: 12px;width: 100%;"> 
           <thead>
               <th>#</th>
               <th>ITEM</th>
               <th>AVAIL.QTY</th>
               <th>REQ. QTY</th>
               <th>Returnable?</th>
               <th>ADD</th>
           </thead>
           <tbody>
                <?php while($data = mysqli_fetch_array($itemQuery)): ?>
                        <tr id="rowCount<?=$count?>">
                            <td><?=$count;?></td>
                            <td>
                                <?=$data['item'];?>
                                <input type="hidden" id="ItemId" value="<?=$data['id'];?>">
                            </td>
                            <td><label id="qty"><?=$data['quantity'];?></label></td>
                            <td><input type="number" id="slctQty" min=1 title="What quantity is being requested?" style="width:70px;padding-top: 3px;padding-bottom:3px;"></td>
                            <td>
                                <div class="radio">
                                <label class="radio-inline" for="returnable"><input type="radio" name="<?='radio'.$count?>" value="Yes" title="This item is to be returned."> Yes</label>
                                <label class="radio-inline" for="returnable"><input type="radio" name="<?='radio'.$count?>" value="No" <?='checked';?> title="This item is not to be returned."> No</label> 
                                </div>
                            </td>
                            <td><a href="#" class="btn btn-sm btn-primary addItemBtn" title="Add item to borrowed items?" data-btnCount="<?=$count?>">Add.</a></td>
                        </tr>
                <?php $count++; endwhile; ?>
           </tbody>
       </table>
        <?php 
    endif;
    echo ob_get_clean();
}

/********************************************************************************************************************
 * CODE FOR SEARCHIGN ITEM STARTS HERE
 *******************************************************************************************************************/
if(isset($_POST['searchItem'])){
    $searchItem =   trim(clean(strtoupper($_POST['searchItem'])));
    ob_start();

    if(!empty($searchItem)){
        $itemQuery  =   $db->query("SELECT * FROM storeitems WHERE item LIKE '%".$searchItem."%'");
    }else if(empty($searchItem)){
        $itemQuery  =   $db->query("SELECT * FROM storeitems");
    }

    if(mysqli_num_rows($itemQuery) == 0){
        $errors[].='<b>Sorry! </b>No item matching your search was found ';
        echo displayErrors($errors);
    }else{

        while($data = mysqli_fetch_assoc($itemQuery)) : ?>

            <tr>
                <td><?=$count;?></td>
                <td><?=$data['item'];?></td>
                <td class="<?=(($data['quantity']<$data['threshold'])?'bg-warning':'')?>"><?=$data['quantity'];?></td>
                <td><?=((isset($data['uom']) && $data['uom']!=0 ? $data['uom']:'N/A'));?></td>
                <td><?=$data['threshold'];?></td>
                <td><?=$data['supplier'];?></td>
                <td>
                    <label> <a href="#" class="text-info restock" id="<?=$data['id'];?>" title="Restock Item."> <i class="fa fa-plus" aria-hidden="true"></i> Restock </a> </label>
                    <label> <a href="/school/store/index.php?editItem=<?=$data['id'];?>" class="text-primary" title="Edit Item."> <i class="fas fa-pencil-alt"></i> Edit </a> </label>
                    <label> <a href="/school/store/index.php" class="text-danger deleteItem" id="<?=$data['id'];?>" title="Delete Item."> <i class="fas fa-trash"></i> Delete. </a> </label>
                </td>
            </tr>

    <?php  $count++;  endwhile;

    }
    echo ob_get_clean();
}
/********************************************************************************************************************
 * CODE FOT SEARCHING ITEM ENDS HERE
 ********************************************************************************************************************/


 /********************************************************************************************************************
 * CODE FOR SEARCHING RESTOCKED ITEM STARTS HERE
 *******************************************************************************************************************/
if(isset($_POST['restockedItem'])){
    $restockedItem =   trim(clean(strtoupper($_POST['restockedItem'])));
    ob_start();

    if(!empty($restockedItem)){
        $itemQuery  =   $db->query("SELECT * FROM restock_inventory WHERE item LIKE '%".$restockedItem."%'");
    }else if(empty($restockedItem)){
        $itemQuery  =   $db->query("SELECT * FROM restock_inventory");
    }

    if(mysqli_num_rows($itemQuery) == 0){
        $errors[].='<b>Sorry! </b>No item matching your search was found ';
        echo displayErrors($errors);
    }else{

        while($data = mysqli_fetch_assoc($itemQuery)) : ?>

            <tr>
                <td><?=$count;?></td>
                <td><?=$data['item'];?></td>
                <td><?=$data['quantity'];?></td>
                <td><?='Kshs. '.$data['amount'];?></td>
                <td><?=$data['supplier'];?></td>
                <td><?=$data['restock_date'];?></td>
            </tr>

    <?php  $count++;  endwhile;

    }
    echo ob_get_clean();
}
/********************************************************************************************************************
 * CODE FOT SEARCHING RESTOCKED ITEM ENDS HERE
 ********************************************************************************************************************/

 $db->close();
?>