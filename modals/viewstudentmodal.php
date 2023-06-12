<?php
require_once $_SERVER['DOCUMENT_ROOT'].'/school/core/init.php';
ob_start();
$student_id=(int)clean(((isset($_POST['student_id'])? $_POST['student_id']:'')));
$query=$db->query("SELECT * FROM students WHERE id='$student_id'");
while($queryData=mysqli_fetch_array($query)):
?>
<div class="modal fade" id="viewModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
  <div class="modal-dialog modal-dialog-centered modal-lg" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="exampleModalLabel">Student Details</h5>
        <h5 clss="float-right"> <?=$configurationData['school_name'];?> </h5>
      </div>
      <div class="modal-body">
        <div class="row">
          <div class="col-md-6">
              <div vlass="form-group text-center">         
              <img src="<?=$queryData['stdimage'];?>" style="width:300px; height: 320px;border-radius:10px;" alt="Student Image">
              </div>
          </div><!--Closing col-md-6 div-->

          <div class="col-md-6">

              <table>
                <tbody class="small_font">
                  <tr>
                    <td>Name:</td> <td><b><?=$queryData['stdname'];?></b></td>
                  </tr>
                  <tr>
                    <td>Reg No:</td> <td><b><?=$queryData['registration_number'];?></b></td>
                  </tr>
                  <tr>
                    <td>DOB:</td> <td><b><?=date("jS F, Y", strtotime($queryData['stddob']));?></b></td>
                  </tr>
                  <tr>
                    <td>Gender:</td> <td><b><?=$queryData['stdgender'];?></b></td> 
                  </tr>
                  <tr>
                    <td>Level:</td> <td><b><?=$queryData['stdgrade'];?></b></td>
                  </tr>
                  <?php if($configurationData['food'] == 'YES'){?>
                  <tr>
                    <td>School Food:</td> <td> <b> <?=$queryData['food'];?> </b> </td>
                  </tr> 
                  <?php }
                   if($configurationData['transport'] == 'YES'){
                  ?>
                  <tr>
                    <td>School Transport:</td> <td> <b> <?=$queryData['transport'];?> </b> </td>
                  </tr> 
                   <?php }?>
                  <tr>
                    <td>Scholar Type:</td> <td> <b> <?=$queryData['scholarType'];?> </b> </td>
                  </tr> 
                  <tr>
                    <td>Guardian:</td> <td><b><?=$queryData['parname'];?></b></td>
                  </tr>
                      <?php if(!empty($queryData['parname2'])){?>
                  <tr>
                    <td>Sec. Guardian:</td> <td><b><?=$queryData['parname2'];?></b></td>
                  </tr>
                      <?php } ?>
                  <tr>
                    <td>Guardian's ID. Number:</td> <td> <b> <?=$queryData['idnumber'];?> </b> </td>
                  </tr> 
                  <tr>
                    <td>Email:</td> <td> <b> <?php if($queryData['paremail']){echo $queryData['paremail'];}else{echo '<i>NULL</i>';}?> </b> </td>
                  </tr>   
                  <tr>
                    <td>Postal Address:</td> <td> <b> <?=$queryData['stdpostal'];?> </b> </td>
                  </tr> 
                  <tr>
                    <td>Residence:</td> <td> <b> <?=$queryData['paraddress'];?> </b> </td>
                  </tr> 
                  <tr>
                    <td>Admission Date:</td> <td> <b><?=date("jS F, Y", strtotime($queryData['doa']));?> </b> </td>
                  </tr>    
                  <?php if($queryData['accomplished'] ==1){?>   <!--if he student has completed schol then show this-->  
                    <tr>
                    <td>Accomplished Year:</td> <td> <b> <?=$queryData['accomplished_year'];?> </b> </td>
                  </tr>    
                  <?php }?>   
                  <?php if($queryData['deleted'] ==1){?>   <!--if he student has completed schol then show this-->  
                    <tr>
                    <td>Transfer Date:</td> <td> <b> <?=date("jS F, Y", strtotime($queryData['delete_date']))?> </b> </td>
                  </tr>    
                  <?php }?>      
                </tbody>
              </table>            
          
         </div><!--Closing col-md-6 div-->

        </div><!--closing row div-->
      </div><!--closing modal-body div-->
      <div class="modal-footer">
        <button type="button" class="small_font btn-secondary" onclick="closemodal()">Close</button>
      </div>
    </div>
  </div>
</div>
<?php 
endwhile;
echo ob_get_clean();?>

<script>

function closemodal(){
    jQuery('#viewModal').modal("hide");//this function closes the modal
    location.reload(true);//refreshes the modal content
}
</script>