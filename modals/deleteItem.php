<!--MODAL FOR CONFIRMING MODAL DELETE-->
<?php
require_once $_SERVER['DOCUMENT_ROOT'].'/school/core/init.php';
$deleteId=(int)clean($_POST['deleteId']);
ob_start();
?>
     <div class="modal fade" id="deleteItemModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
        <div class="modal-dialog" role="document">
             <div class="modal-content">
                 <div class="modal-header">
                     <h5 class="modal-title" id="exampleModalLabel"></h5>
                        <button type="button" class="close" onclick="closeDeleteItemModal()" aria-label="Close">
                          <span aria-hidden="true">&times;</span>
                        </button>
                 </div>
                 <div class="modal-body">                                           
                    <h6>Are you sure you want to delete this Item permanently?</h6>                                                                 
                 </div>
                 <div class="modal-footer">
                       
                            <form action="index.php?deleteItem=<?=$deleteId;?>" method="POST">
                                <button type="button" class="btn btn-sm btn-default small_font" onclick="closeDeleteItemModal()">Cancel</button>
                                <button type="submit" class="btn btn-sm btn-danger small_font">Delete</button>
                            </form>       
                </div>
             </div>
         </div>
</div>
<?php echo ob_get_clean();?>
<!--DELETING EVENT MODAL ENDS HERE-->  