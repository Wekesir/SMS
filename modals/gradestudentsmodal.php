<?php
ob_start();
require_once $_SERVER['DOCUMENT_ROOT'].'/school/core/init.php';
$id=((isset($_POST['gradeStudent_id'])? (int)$_POST['gradeStudent_id'] : ''));
$query=$db->query("SELECT * FROM students WHERE id='$id'");
$querydata=mysqli_fetch_array($query);
$oldSystemArray=array('Class 5','Class 6','Class 7','Class 8');
$lowerGradeArray=array('Playgroup','PP1','PP2');
$upperGradeArray=array('Grade 1','Grade 2','Grade 3','Grade 4','Grade 5','Grade 6');
?>

<!-- Modal -->
<div class="modal fade" id="grading_modal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
  <div class="modal-dialog modal-dialog-centered modal-lg" role="document">
    <div class="modal-content">
      <div class="modal-header">
               <h6 class="modal-title" id="exampleModalLabel"> <?=$querydata['stdname'];?> </h6>
               <h6 class="modal-title text-right" id="exampleModalLabel"> <?=$querydata['registration_number'];?> </h6>       
      </div>
      <div class="modal-body">  

        <div class="container-fluid">
        <form action="students.php?studentId=<?=$id;?>" method="POST">
            
             <?php 
            if(in_array($querydata['stdgrade'],$oldSystemArray,TRUE)){
               
                ?>

                    
                        <div class="row">                            
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label for="mathematics"></label>
                                    <input type="number" name="mathematics" class="form-control" min=0>
                                </div>
                                <div class="form-group">
                                    <label for="english"></label>
                                    <input type="number" name="english" class="form-control" min=0>
                                </div>
                                <div class="form-group">
                                    <label for="kiswahili"></label>
                                    <input type="number" name="kiswahili" class="form-control" min=0>
                                </div>
                            </div><!--Closing col-md-6 div-->
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label for="science"></label>
                                    <input type="number" name="science" class="form-control" min=0>
                                </div>
                                <div class="form-group">
                                    <label for="socialstudies"></label>
                                    <input type="number" name="socialstudies" class="form-control" min=0>
                                </div>
                            </div><!--Closing col-md-6 div-->
                        </div><!--Closing row div-->
                    

                <?php

            }else if(in_array($querydata['stdgrade'],$lowerGradeArray,TRUE)){
                ?>
                
                <div class="row">
                    <div class="col-md-6">
                        <div class="form-group">
                            <label for="language">Language Activities:</label>
                            <textarea name="language" class="form-control" rows="10"></textarea>
                        </div>
                        <div class="form-group">
                            <label for="maths">Mathematics Activities:</label>
                            <textarea name="maths" class="form-control" rows="10"></textarea>
                        </div>
                        <div class="form-group">
                            <label for="creative">Psychomotor & Creative:</label>
                            <textarea name="creative" class="form-control" rows="10"></textarea>
                        </div>
                    </div><!--Closing col-md-6 div-->
                    <div class="col-md-6">
                        <div class="form-group">
                            <label for="environment">Environmental Activities:</label>
                            <textarea name="environment" class="form-control" rows="10"></textarea>
                        </div>
                        <div class="form-group">
                            <label for="CRE">Christian Religios Education:</label>
                            <textarea name="CRE" class="form-control" rows="10"></textarea>
                        </div>
                    </div><!--Closing col-md-6 div-->
                </div><!--Closing row div-->
                
                <?php
            }else{
                ?>
                
                <div class="row">
                    <div class="col-md-6">
                        <div class="form-group">
                            <label for="maths">Mathematics Activities:</label>
                            <textarea name="maths" class="form-control" rows="5"></textarea>
                        </div>
                        <div class="form-group">
                            <label for="language">Language Activities:</label>
                            <textarea name="language" class="form-control" rows="5"></textarea>
                        </div>
                        <div class="form-group">
                            <label for="kiswahili">Kiswahili:</label>
                            <textarea name="kiswahili" class="form-control" rows="5"></textarea>
                        </div>
                        <div class="form-group">
                            <label for="hygiene">Hygiene:</label>
                            <textarea name="hygiene" class="form-control" rows="5"></textarea>
                        </div>                        
                    </div><!--Closing col-md-6 div-->
                    <div class="col-md-6">                        
                        <div class="form-group">
                            <label for="environment">Environmental Activities:</label>
                            <textarea name="environment" class="form-control" rows="5"></textarea>
                        </div>
                        <div class="form-group">
                            <label for="CRE">Christian Religios Education:</label>
                            <textarea name="CRE" class="form-control" rows="5"></textarea>
                        </div>
                        <div class="form-group">
                            <label for="reading">Reading:</label>
                            <textarea name="reading" class="form-control" rows="5"></textarea>
                        </div>
                        <div class="form-group">
                            <label for="kusoma">Kusoma:</label>
                            <textarea name="kusoma" class="form-control" rows="5"></textarea>
                        </div>
                    </div><!--Closing col-md-6 div-->
                </div><!--Closing row div-->
                
                <?php
                
            }
          ?>
          
      </form>           
      </div><!--closing container-fluid div-->

      </div>
      <div class="modal-footer">
        <button type="button" class="btn-xs btn-secondary"onclick="closeGradeStudentModal()">Close</button>
      </div>
    </div>
  </div>
</div>

<?php echo ob_get_clean(); ?>


