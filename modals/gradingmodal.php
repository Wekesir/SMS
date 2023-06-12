<?php
require_once $_SERVER['DOCUMENT_ROOT'].'/school/core/init.php';
$studentId     = ((isset($_POST['studentId'])? (int)clean($_POST['studentId']) :''));
$studentQuery  = $db->query("SELECT * FROM students WHERE id='$studentId'");
$studentData   = mysqli_fetch_array($studentQuery);

$marksQuery    = $db->query("SELECT * FROM formerstudents_marks WHERE student_id='$studentId'");
$rowCount      = mysqli_num_rows($marksQuery);
$count         =  1;

?>
<style>
.modal-body{
  min-height: 500px;
  max-height: 500px;
  overflow:auto;
}
</style>

<!-- Modal -->
<div class="modal fade" id="gradingmodal" tabindex="-1" role="dialog" aria-labelledby="exampleModalScrollableTitle" aria-hidden="true">
  <div class="modal-dialog modal-lg modal-dialog-scrollable" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="exampleModalScrollableTitle"><?=$studentData['stdname'];?></h5>
        <button type="button" class="close" onclick="closegradingmodal()">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <div class="modal-body">
          <nav>
            <div class="nav nav-tabs" id="nav-tab" role="tablist">
              <a class="nav-item nav-link active" id="nav-home-tab" data-toggle="tab" href="#nav-home" role="tab" aria-controls="nav-home" aria-selected="true">View marks</a>
              <a class="nav-item nav-link" id="nav-addmarks-tab" data-toggle="tab" href="#nav-profile" role="tab" aria-controls="nav-profile" aria-selected="false">Enter marks</a>
            </div>
          </nav>

          <div id="notficationsDiv"></div><!--this div displays both success and error messages frm jQuery callback success functin-->

          <div class="tab-content" id="nav-tabContent">
            <div class="tab-pane fade show active" id="nav-home" role="tabpanel" aria-labelledby="nav-home-tab">

                  <?php if($rowCount== 0){$errors[].='<b>Error! </b>No data was found'; echo displayErrors($errors);;}?>

                  <table class="table-bordered full-length">
                    <thead>
                      <th>#</th>
                      <th>MATHEMATICS</th>
                      <th>ENGLISH</th>
                      <th>KISWAHILI</th>
                      <th>SCIENCE</th>
                      <th>SST & CRE</th>
                      <th>TOTAL</th>
                      <th>EXAM TYPE</th>
                      <th>TERM</th>
                      <th>YEAR</th>
                      <th></th>
                    </thead>
                    <tbody>
                        <?php while($queryData  = mysqli_fetch_assoc($marksQuery)) :   

                            $examType        = $queryData['examType'];
                            $level           = $queryData['level']; 
                            $term            = $queryData['term']; 
                            $year            = $queryData['year']; 
                            $marksEncoded    = $queryData['performance']; 
                        
                            $marksDecoded    =   json_decode($marksEncoded,true);

                            foreach($marksDecoded as $subject){
                                $mathematics    =   $subject['Mathematics'];
                                $english        =   $subject['English'];
                                $kiswahili      =   $subject['Kiswahili'];
                                $science        =   $subject['Science'];
                                $sst            =   $subject['Social Studies & CRE'];
                            }

                            $total  =   ($mathematics + $english + $kiswahili + $science + $sst);

                        ?>
                <tr>
                    <td><?=$count;?>.</td>
                   <td><?=$mathematics?></td>
                   <td><?=$english?></td>
                   <td><?=$kiswahili?></td>
                   <td><?=$science?></td>
                   <td><?=$sst?></td>
                   <td><?=$total?></td>
                   <td><?=$examType?></td>
                   <td><?=$term?></td>
                   <td><?=$year?></td>
                   <td> <a href=<?='/school/users/performance.php?editmarks='.$queryData['id'];?>> <i class="fas fa-pencil-alt"></i> Edit</a> </td>
                </tr>
            <?php $count++; endwhile; ?>
                    
                    </tbody>
                  </table>
            </div><!--closing tabpanel1-->

            <div class="tab-pane fade" id="nav-profile" role="tabpanel" aria-labelledby="nav-addmarks-tab">
                  <h6 class="text-center" style="padding:10px;background:#f8f8f8;">ENTER STUDENT MARKS</h6>
                  <form action="<?=$_SERVER['PHP_SELF']?>" method="post">
                    <div class="row">
                      <div class="col-md-6">
                        <div class="form-group">
                          <label for="">Mathematics</label>
                          <input type="number" class="form-control" name="mathematics" required=required min=0 max=100> 
                        </div>
                        <div class="form-group">
                          <label for="">English</label>
                          <input type="number" class="form-control" name="english" required=required min=0 max=100> 
                        </div>
                        <div class="form-group">
                          <label for="">Kiswahili</label>
                          <input type="number" class="form-control" name="kiswahili" required=required min=0 max=100> 
                        </div>
                        <div class="form-group">
                          <label for="">Science</label>
                          <input type="number" class="form-control" name="science" required=required min=0 max=100> 
                        </div>
                      </div>
                      <div class="col-md-6">                        
                        <div class="form-group">
                          <label for="">Social studies & CRE</label>
                          <input type="number" class="form-control" name="sst" required=required min=0 max=100> 
                        </div>
                        <div class="form-group">
                          <label for="">Exam type</label>
                          <input type="text" class="form-control" name="examType" required=required> 
                        </div>
                        <div class="form-group">
                          <label for="">Term</label>
                          <select name="term" id="term" class="form-control" required=required>
                            <option value=""></option>
                            <option value="TERM 1">Term 1</option>
                            <option value="TERM 2">Term 2</option>
                            <option value="TERM 3">Term 3</option>
                          </select>
                        </div>  
                        <div class="form-group">
                          <label for="">Total</label>
                          <input type="number" class="form-control" name="total" required=required min=0 readonly> 
                        </div>  
                        <div class="form-group">
                            <input type="hidden" name="level" value="<?=$studentData['stdgrade']?>">
                            <input type="hidden" name="studentId" value="<?=$studentData['id']?>">
                        </div>                      
                      </div>
                    </div>
                    <div class="form-group">
                      <input type="submit" class="btn btn-default" value="Submit">
                    </div>
                  </form>
            </div><!--closing tabpanel2-->
          </div>

       
      </div>
      <div class="modal-footer">
        
      </div>
    </div>
  </div>
</div>

<script>
jQuery("form").submit(function(event){
  event.preventDefault();
  var formData  = $(this).serialize();

  jQuery.ajax({
    url:'/school/admin/students/modaldata.php',
    method:'post',
    data:formData,
    success:function(data){
      $('#notficationsDiv').html(data);
    },
    error:function(){
      alert("Something went wron trying to insert marks");
    }
  });

});
</script>