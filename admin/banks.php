<!DOCTYPE html>
<html>
<head>
    <?php
        require_once $_SERVER['DOCUMENT_ROOT'].'/school/core/init.php';
        include '../admin/header.php';
        $messages=array();
        $errors=array();
    ?>
</head>
<body>   
    <?php include '../admin/navigation.php';?>
 <div class="container-fluid">
    <div class="row">
        <div class="col-md-3">
            <?php include '../admin/left.php';?>
        </div><!--Closing col-md-3 div-->
        <div class="col-md-9" id="wrapper"> 

        <!--CODE FOR DELETING BANK USING MODAL-->
        <?php
        if(isset($_REQUEST['deleteBank']) && $_REQUEST['deleteBank'] >0){
            $deleteBankId = (int)clean($_GET['deleteBank']);
            $db->query("DELETE FROM banks WHERE id='$deleteBankId'");
            $messages[].='<b>Success! </b>Bank deleted.';
            if(!empty($messages)){
                displayMessages($messages);
            }
        }
                    
        ?>        
          
          <div class="row">
                <div class="col-md-7">
                        <table class="table table-striped">
                            <thead>
                                <th>#</th>
                                <th>Bank</th>
                                <th>Acc. Number</th>
                                <th>Edit</th>
                                <th>Delete</th>
                            </thead>
                            <tbody>
                                <?php $bankQuery=$db->query("SELECT * FROM banks");
                                      $count=1;
                                      while($bankQueryArray=mysqli_fetch_array($bankQuery)) :
                                ?>
                                <tr>
                                        <td><?=$count;?></td>
                                        <td><?=$bankQueryArray['bank'];?></td>
                                        <td><?=$bankQueryArray['account_number'];?></td>
                                        <td>
                                            <a href="banks.php?editBank=<?=$bankQueryArray['id']?>" class="exsmall_font" title="Click to edit bank details."><button class="btn-primary">Edit</button></a>
                                        </td>
                                        <td>
                                            <a class="exsmall_font deleteBank" id="<?=$bankQueryArray['id'];?>" title="Click to delete bank details."><button class="btn-danger">Delete</button></a>
                                        </td>
                                </tr>
                                <?php 
                                        $count++;
                                        endwhile;
                                ?>
                            </tbody>
                        </table>
                </div><!--CLosing col-md-7 div-->

                <div class="col-md-5">
                    <h6 class="text-center">ADD NEW BANK</h6>

                    <?php

                $bank          = '';
                $accountNumber = '';
                    //////CODE FOR EDITING BANK DETAILS
                if(isset($_REQUEST['editBank'])){

                    $bankId             = (int)clean($_GET['editBank']);
                    $editBankQuery      = $db->query("SELECT * FROM banks WHERE id='$bankId'");
                    $editBankQueryArray = mysqli_fetch_array($editBankQuery);

                    $bank               = ((isset($_GET['editBank'])? $editBankQueryArray['bank']:''));
                    $accountNumber      = ((isset($_GET['editBank'])? $editBankQueryArray['account_number'] :''));

                    if(isset($_REQUEST['update'])){

                        $bank               = ((isset($_GET['editBank'])? strtoupper($_POST['bank']):$editBankQueryArray['bank']));
                        $accountNumber      = ((isset($_GET['editBank'])? $_POST['account'] : $editBankQueryArray['account_number']));
                        
                        $db->query("UPDATE banks SET bank='$bank', account_number='$accountNumber' WHERE id='$bankId'");
                        $messages[].='<b>Success! </b>Bank updated.';
                        if(!empty($messages)){
                            displayMessages($messages);
                        }

                    }
               
                }//closing $_REQUEST['editBank']
                    //*********8CODE FOR EDITING BANK END HERE */

                    if(isset($_REQUEST['submit'])){
                       $bank          = strtoupper(trim(clean(((isset($_POST['bank'])? $_POST['bank'] : '')))));
                       $accountNumber = trim(clean(((isset($_POST['account'])? $_POST['account'] : ''))));

                       //check if the data is empty or not
                       if($bank == '' || $accountNumber = ''){
                           $errors[].='<b>Error! </b>Please provide all info.';
                       }

                       if(!empty($errors)){
                            displayErrors($errors);
                       }else{
                            $db->query("INSERT INTO banks (bank, account_number) VALUES ('$bank','$accountNumber')");
                            $messages[].='<b>Success!</b>Bank details added.';
                            if(!empty($messages)){
                                displayMessages($messages);
                            }
                       }

                       
                    }
                    ?>

                    <form action="<?=((isset($_GET['editBank'])?'banks.php?editBank='.$_GET['editBank'].'':'banks.php'))?>" method="POST">
                        <div class="form-group">
                            <label for="bank">Enter bank name:</label>
                            <input type="text" name="bank" class="form-control" value="<?=$bank;?>">
                        </div>
                        <div class="form-group">
                            <label for="account">Enter account number:</label>
                            <input type="text" name="account" class="form-control" value="<?=$accountNumber;?>">
                        </div>
                        <div class="form-group">
                            <input type="submit" name="<?=((isset($_GET['editBank'])?'update':'submit'))?>" class="form-control" title="Click to add bank." value="<?=((isset($_GET['editBank'])?'Update':'Submit'))?>">
                        </div>
                    </form>
                </div><!--CLosing col-md-5 div-->
          </div><!--Closing row div-->

        </div><!--Closing col-md-9 div-->
    </div><!--Closing row dic-->
 </div><!--closing container div-->
    <?php include '../admin/footer.php';?>
</body>
</html>
<script>
function closeDeleteBankModal(){
    jQuery('#deletebankmodal').modal("hide");
    window.location='../admin/banks.php';
}

jQuery('.deleteBank').click(function(){
    var deleteId = jQuery(this).attr("id"); 

    jQuery.ajax({
        url:'/school/modals/deletebankmodal.php',
        method:'POST',
        data:{deleteId:deleteId},
        success:function(data){
            jQuery("body").append(data);
            jQuery('#deletebankmodal').modal({backdrop:'static',keyboard:false});
        },
        error:function(){
            alert("Something went wrong!");
        }
    });
});
</script>