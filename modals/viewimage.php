<?php
require_once $_SERVER['DOCUMENT_ROOT'].'/school/core/init.php';

$imagePath = ((isset($_POST['imageSource'])? clean($_POST['imageSource']) : ''));
$imageDetails = ((isset($_POST['imageDetails'])? clean($_POST['imageDetails']):'IMAGE'));


ob_start();
?>
<style>
#image{
    width:100%;
    height:500px;
}
</style>
<!-- Modal -->
<div class="modal fade" id="viewImagemodal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
  <div class="modal-dialog modal-md" role="document">
    <div class="modal-content">
       <div class="modal-header">
        <h5 class="modal-title" id="exampleModalLabel"><?=$imageDetails;?></h5>
        <button type="button" class="close" onclick="closeviewImageModal()">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <div class="modal-body">           
        <img src="<?=$imagePath;?>" alt="" id="image">
      </div>      
    </div>
  </div>
</div>
<?php echo ob_get_clean();?>