<!-- Modal -->
<?php
require_once $_SERVER['DOCUMENT_ROOT'].'/school/core/init.php';
$del_id=((isset($_POST['delete_id'])?$_POST['delete_id']:''));//this id is sent to this page from the ajax request on thhis page
ob_start();
?>
<div class="modal fade" id="deleteModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
  <div class="modal-dialog" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <h6 class="modal-title" id="exampleModalLabel">Delete Image</h6>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <div class="modal-body">
                <h6>Are you sure you want to delete?</h6>
      </div>
      <div class="modal-footer">
        <button type="button" class="btn-secondary small_font" onclick="closeModal()">Cancel</button>
        <form action="siteimages.php?delete=<?=$del_id?>" method="POST">
            <button type="submit" class="btn-danger small_font">Delete</button>
        </form>        
      </div>
    </div>
  </div>
</div>
<?php echo ob_get_clean();?>
<!--THE MODAL ENDS HERE-->