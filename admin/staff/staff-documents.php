<?php
  require_once $_SERVER['DOCUMENT_ROOT'].'/school/core/init.php'; //db connection

  if(isset($_POST['STAFF_DOC_ID'])):
    $staff_id = $_POST['STAFF_DOC_ID']; //this is the user id 
    //check if any documents matching the user id exist in the db
    $docQuery = $db->query("SELECT * FROM `staff_documents` WHERE `staff_id`='{$staff_id}'");
    ob_start(); ?>
    <h6>New Document(s).</h6>
    <div id="notificationsDiv"></div>
    <div class="my-2">
        <form action="#" id="uploadDocForm" method="post" enctype="multipart/form-data">
            <div class="form-group">
                <label for="">DOCUMENT NAME</label> 
                <input type="text" class="form-control" name="docname" required=required>
            </div>
            <div class="form-group">
                <label for="">Select document</label>
                <input type="file" class="form-control" name="file" accept=".pdf, .doc, .docx" required=required>
            </div>
            <button type="submit" class="btn btn-sm btn-primary"><i class="fas fa-folder-upload"></i> Upload Document</button>
        </form>
    </div>  
    <hr>
    <?php
        if(mysqli_num_rows($docQuery) == 0):
        $info[].="<b>Oops! </b>No documents have been found..."; echo displayinfo($info);
        else:            
    ?>
    <h6 class="my-3">Existing Document(s)</h6>
    <table class="table table-sm table-hover table-bordered">
    <tbody>
        <?php $count=1; while($docData = mysqli_fetch_assoc($docQuery)) :?>
        <tr>
        <th scope="row"><?=$count?></th>
        <td id="docNameTr"><?=$docData["document_name"]?></td>
        <td> <a href="<?=$docData["document"]?>"><i class="fas fa-folder-download"></i> &nbsp; download</a></td>
        <td>
            <div class="btn-group dropleft">
            <button type="button" class="btn btn-sm btn-default dropdown-toggle" data-toggle="dropdown" aria-expanded="false">
                Actions
            </button>
            <div class="dropdown-menu">
                <a class="dropdown-item editDocBtn" id="<?=$docData["id"]?>" href="#"><i class="fas fa-file-edit"></i>&nbsp; edit</a>
                <a class="dropdown-item delDocBtn" id="<?=$docData["id"]?>" href="#"><i class="fas fa-file-times"></i> &nbsp; delete</a>
            </div>
            </div>
        </td>
        </tr>
        <?php $count++; endwhile;?>
    </tbody>
    </table>
    <?php endif; echo ob_get_clean();
  endif;
?>