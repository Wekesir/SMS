<?php
require_once $_SERVER["DOCUMENT_ROOT"].'/school/core/init.php';
$subjectId = (int)clean($_POST['subjectId']);
$subjectQuery = $db->query("SELECT * FROM `subjects` WHERE `id`='{$subjectId}'");
$subjectData  = mysqli_fetch_array($subjectQuery);
ob_start(); ?>
<div class="modal fade" id="viewLevelsModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
  <div class="modal-dialog modal-dialog-centered modal-md" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="exampleModalLabel">Levels offering: </h5>
        <h5 clss="float-right"> <?=$subjectData['subject_name'];?> </h5>
      </div>
      <div class="modal-body">
        <table class="table table-sm table-striped table-bordered table-hoverable">
            <thead class="thead-light">
                <tr>
                    <th scope="col">#</th>
                    <th scope="col">LEVEL</th>
                </tr>
            </thead>
            <tbody>
                <?php 
                    $count=1; 
                    $levelsArray = json_decode($subjectData['levels']);
                    $levelsCount = count($levelsArray);
                    $x=0;
                    while($x<$levelsCount):?>
                    <tr>
                        <th scope="row"><?=$count;?></th>
                        <td><?=$levelsArray[$x]?></td>
                    </tr>
                <?php $x++; $count++; endwhile;?>
            </tbody>
        </table>
      </div><!--closing modal-body div-->
      <div class="modal-footer">
        <button type="button" class="btn btn-default btn-sm text-danger" onclick="closemodal()">Close</button>
      </div>
    </div>
  </div>
</div>
<?php echo ob_get_clean(); ?>
<script>
function closemodal(){
    jQuery(".viewLevelsModal").modal("hide");
    location.reload(true);
}
</script>
