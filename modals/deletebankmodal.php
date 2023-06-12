<?php
require_once $_SERVER['DOCUMENT_ROOT'].'/school/core/init.php';
$deleteBankId=(int)clean(((isset($_POST['deleteId'])?$_POST['deleteId']:'')));
$query=$db->query("SELECT * FROM banks WHERE id='$deleteBankId'");
$querydata=mysqli_fetch_array($query);
ob_start();
?>
<!-- Modal -->
<div class="modal fade" id="deletebankmodal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
  <div class="modal-dialog" role="document">
    <div class="modal-content">
        <div class="modal-header">
            <h6 class="modal-title" id="exampleModalLabel"> <?=$querydata['bank'];?> </h6>       
      </div>
      <div class="modal-body">      
      <p>Are you sure you want to delete this bank?</p>
      </div>
      <div class="modal-footer">
        <button type="button" class="btn-md btn-secondary small_font" onclick="closeDeleteBankModal()">Close</button>
        <form action="banks.php?deleteBank=<?=$deleteBankId?>" method="POST">
            <button type="submit" name="deleteBankBtn" class="btn-md btn-danger small_font">Delete</button>
        </form>        
      </div>
    </div>
  </div>
</div>
<?php echo ob_get_clean();?>