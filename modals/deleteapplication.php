<?php
require_once $_SERVER['DOCUMENT_ROOT'].'/school/core/init.php';
$deleteApplicationId=(int)clean(((isset($_POST['applicationId'])?$_POST['applicationId']:'')));
$query=$db->query("SELECT * FROM applications WHERE id='$deleteApplicationId'");
$querydata=mysqli_fetch_array($query);
ob_start();
?>
<!-- Modal -->
<div class="modal fade" id="deleteapplicationmodal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
  <div class="modal-dialog" role="document">
    <div class="modal-content">
        <div class="modal-header">
            <h6 class="modal-title" id="exampleModalLabel"> <?=$querydata['stdname'];?> </h6>       
      </div>
      <div class="modal-body">      
      <p>Are you sure you want to delete this application?</p>
      </div>
      <div class="modal-footer">
        <button type="button" class="btn-md btn-secondary small_font" onclick="closeDeleteApplicationModal()">Close</button>
        <form action="applications.php?deleteApplication=<?=$deleteApplicationId?>" method="POST">
            <button type="submit" name="deleteStudentBtn" class="btn-md btn-danger small_font">Delete</button>
        </form>        
      </div>
    </div>
  </div>
</div>
<?php echo ob_get_clean();?>