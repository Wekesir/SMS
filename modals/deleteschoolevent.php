<!--MODAL FOR CONFIRMING MODAL DELETE-->
<?php
$deleteEventId=(int)clean($_POST['delete_id']);
?>
     <div class="modal fade" id="deleteeventModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
        <div class="modal-dialog" role="document">
             <div class="modal-content">
                 <div class="modal-header">
                     <h5 class="modal-title" id="exampleModalLabel"></h5>
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                          <span aria-hidden="true">&times;</span>
                        </button>
                 </div>
                 <div class="modal-body">                                           
                    <h6>Are you sure you want to delete?</h6>                                                                 
                 </div>
                 <div class="modal-footer">
                        <button type="button" class="btn-md btn-primary small_font" data-dismiss="modal">Cancel</button>
                            <form action="events.php?deleteEvent=<?=$deleteEventId;?>" method="POST">
                                <button type="submit" name="delete_event_btn" class="btn-md btn-danger small_font">Delete</button>
                            </form>       
                </div>
             </div>
         </div>
</div>
<!--DELETING EVENT MODAL ENDS HERE-->  