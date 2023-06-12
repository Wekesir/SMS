<?php
require_once $_SERVER['DOCUMENT_ROOT'].'/school/core/init.php';
$deleteStudentId=(int)clean(((isset($_POST['deleteId'])?$_POST['deleteId']:'')));
$query=$db->query("SELECT * FROM former_students WHERE id='$deleteStudentId'");
$querydata=mysqli_fetch_array($query);
ob_start();
?>
<!-- Modal -->
<div class="modal fade" id="deletestudentmodal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
  <div class="modal-dialog" role="document">
    <div class="modal-content">
        <div class="modal-header">
            <h6 class="modal-title" id="exampleModalLabel"> <?=$querydata['name'];?> </h6>
            <h6 class="modal-title text-right" id="exampleModalLabel"> <?=$querydata['gender'];?> </h6>       
      </div>
      <div class="modal-body">      
      <p>Are you sure you want to delete?</p>
      </div>
      <div class="modal-footer">
        <button type="button" class="btn-md btn-secondary small_font" onclick="closeDeleteFormerStudentModal()">Close</button>
        <form action="/school/admin/formerstudents.php?deleteStudent=<?=$deleteStudentId?>" method="POST">
            <button type="submit" name="deleteStudentBtn" class="btn-md btn-danger small_font">Delete</button>
        </form>        
      </div>
    </div>
  </div>
</div>
<?php echo ob_get_clean();?>