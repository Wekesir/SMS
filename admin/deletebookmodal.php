<?php
require_once $_SERVER['DOCUMENT_ROOT'].'/school/core/init.php';
ob_start();
?>
<!-- Modal -->
<div class="modal fade" id="deletebookmodal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
  <div class="modal-dialog" role="document">
    <div class="modal-content">
    
      <div class="modal-body">
      <p>Are you sure you want to delete?</p>
      </div>
      <div class="modal-footer">
        <button type="button" class="btn-md btn-secondary small_font" data-dismiss="modal">Close</button>
        <form action="">
            <button type="submit" class="btn-md btn-danger small_font">Delete</button>
        </form>        
      </div>
    </div>
  </div>
</div>
<?php echo ob_get_clean();?>