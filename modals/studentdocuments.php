<?php
ob_start();
require_once $_SERVER['DOCUMENT_ROOT'].'/school/core/init.php';
$id=((isset($_POST['student_id'])? (int)$_POST['student_id'] : ''));
$query=$db->query("SELECT * FROM students WHERE id='$id'");
$query2=$db->query("SELECT * FROM student_documents WHERE student_id='$id'");
$querydata=mysqli_fetch_array($query);
?>

<!-- Modal -->
<div class="modal fade" id="documents_modal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
  <div class="modal-dialog modal-dialog-centered" role="document">
    <div class="modal-content">
      <div class="modal-header">
               <h6 class="modal-title" id="exampleModalLabel"> <?=$querydata['stdname'];?> </h6>
               <h6 class="modal-title text-right" id="exampleModalLabel"> <?=$querydata['registration_number'];?> </h6>       
      </div>
      <div class="modal-body">
        <form action="students.php?studentId=<?=$id;?>" method="POST" enctype="multipart/form-data">
            <div class="row"> 
              <div class="col-md-12">   
                    <input type="file" class="small_font" name="document" id="document" style="width:340px;max-width:340px;" required=required>                           
                    <button type="submit" class="small_font btn btn-primary btn-sm" name="upload_document" style="border-radius:25px;">
                        <i class="fas fa-file-upload"></i> Upload Doc.
                    </button>
                </div>
            </div>
            <label class="text-danger exsmall_font"><b>Only PDF, DOC and DOCX formats are allowed!</b></label> 
            <div class="row">
              <div class="col-md-12">
                <label for="docname" class="">Document Name:</label>
                <input type="text" name="docname" class="form-control" required=required>
              </div>
            </div>             
      </form>     
      <hr>
            <table class="table-bordered table-hover table table-sm">
                <thead class="thead-light">
                    <th>#</th>
                    <th>Document</th>
                    <th class="text-center">Downl.</th>
                    <th class="text-center">Del.</th>
                </thead>
                <tbody>                   
                      <?php
                      $count=1;
                      while($querydata2=mysqli_fetch_array($query2)) :
                      ?>
                             <tr>
                                <td> <?=$count?> </td>
                                <td> <?=$querydata2['document_name'];?> </td>
                                <td class="text-center"> <a href="<?=$querydata2['document'];?>" class="btn-default small_font" title="Click to download document."><i class="fas fa-file-download"></i> Downl.</button> </td>
                                <td class="text-center">                                 
                                     <a href="students.php?delDocument=<?=$querydata2['id'];?>" class="text-danger small_font" title="Click to delete document from server"><i class="fas fa-trash-alt"></i> Del.</a>                                
                                  </td>
                             </tr>                             
                      <?php $count+=1; endwhile; ?>
                </tbody>
            </table>        
      </div>
      <div class="modal-footer">
        <button type="button" class="btn-xs btn-secondary"onclick="closeDeleteStudentDocModal()">Close</button>
      </div>
    </div>
  </div>
</div>

<?php echo ob_get_clean(); ?>


