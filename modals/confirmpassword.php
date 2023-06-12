<?php
require_once $_SERVER['DOCUMENT_ROOT'].'/school/core/init.php';

$script_URL = clean(((isset($_POST['script_url'])?$_POST['script_url'] :'')));//this is the URL of the page requesting passwprd confirmation

$confirmpassword=(int)$_SESSION['user'];
$query=$db->query("SELECT * FROM users WHERE id='$confirmpassword'");
$querydata=mysqli_fetch_array($query);
ob_start();
?>
<!-- Modal -->
<div class="modal fade" id="confirmpasswordmodal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
  <div class="modal-dialog modal-dialog-centered modal-md" role="document">
    <div class="modal-content">
        <div class="modal-header">
            <h6 class="modal-title" id="exampleModalLabel"> <?=$querydata['username'];?> </h6>                 
      </div>
      <div class="modal-body">  

        <form action="<?=$script_URL;?>" method="POST">
            <div class="form-group">
                <label for="confirmpassword" class="text-danger small_font"> <b> <i class="fas fa-exclamation-triangle"></i> Confirm your password to proceed. </b> </label>
                <input type="password" name="confirmpassword" id="confirmpassword" placeholder="Password..." class="form-control">
            </div>

     </div>
    <div class="modal-footer">
            <button type="button" class="btn-md btn-secondary small_font" onclick="closeconfrimpasswordModal()">Close</button>            
            <button type="submit" name="confirmPassBtn" class="btn-md btn-primary small_font">Confrim</button>               
    </div>
      </form>
    </div>
  </div>
</div>
<?php echo ob_get_clean();?>
