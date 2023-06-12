

<div class="container-fluid">
<?php
   $count=1;  
   $userQuery = $db->query("SELECT `id`, `name` FROM `users` WHERE `id`!=1 AND `deleted`=0");
   $rowCount = mysqli_num_rows($userQuery);
?>
<form action="salaries.php?pay=1" method="POST">
    <div id="notificationsDiv"></div>
    <table class="table table-sm table-bordered table-hover">
        <thead class="thead-light">
            <th></th>
            <th></th>
            <th>NAME</th>
            <th>PAYMENTS</th>
            <th>DEDUCTIONS</th>
        </thead> 
        <tbody>
            <?php  while($userData = mysqlI_fetch_array($userQuery)): ?>
                <tr id="row<?=$count;?>">
                    <td><?=$count;?></td>
                    <td>
                        <input type="checkbox" id="select" <?='checked';?>> Select
                    </td>                        
                    <td><strong><?=$userData['name'];?></strong></td>
                    <td id="payments">
                        <input type="checkbox" id="nhif" <?='checked';?>> NHIF Amount <br>
                        <input type="checkbox" id="nssf" <?='checked';?>> NSSF Amount                        
                    </td>
                    <td id="deductions">
                        <input type="checkbox" id="advance" <?='checked';?>> Advance <br>
                        <input type="checkbox" id="damages" <?='checked';?>> Damages 
                    </td>
                    <input type="hidden" id="staffId" value="<?=(int)$userData['id'];?>"><!--holds the ID for this particular employee-->
                </tr>
            <?php $count++; endwhile;?>
        </tbody>
    </table>
    <div class="form-group">
        <button type="submit" class="btn btn-md btn-primary">
                <span class="spinner-border spinner-border-sm d-none" id="spinner" role="status" aria-hidden="true"></span>
            <span class="sr-only">Loading...</span>
            Pay Salaries
        </button>
    </div>
</form>
<!-- Modal -->
<div class="modal fade" id="paySalariesModal" data-backdrop="static" data-keyboard="false" tabindex="-1" aria-labelledby="staticBackdropLabel" aria-hidden="true">
  <div class="modal-dialog">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="staticBackdropLabel">Modal title</h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <div class="modal-body">
        ...
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
        <button type="button" class="btn btn-primary">Understood</button>
      </div>
    </div>
  </div>
</div>
</div>
<script>
jQuery("form").submit(function(e){
    e.preventDefault();
    $("#spinner").removeClass("d-none");
    $("#paySalariesModal").modal("show");
    var count = <?=$rowCount;?>; 
    for(var i=1;i<=count;i++){//this code loops as many times as the number of rows from the query
        var staffId = $("#row"+i).find("#staffId").val();
        var nssf    = $("#row"+i).find("#payments > #nhif").is(":checked");
        var nhif    = $("#row"+i).find("#payments > #nssf").is(":checked");
        var advance = $("#row"+i).find("#deductions > #advance").is(":checked");
        var damages = $("#row"+i).find("#deductions > #damages").is(":checked");   

        var selectedEmp = $("#row"+i).find("#select");   //makes sure that the employee has been selected to be paid  

        var dataObj = {
            staffId : staffId,
            nssf    : nssf,
            nhif    : nhif,
            advance : advance,
            damages : damages
        };
        if(staffId==""){
            alert("FATAL ERROR! The staff Id is empty!"); break;
        }else{
            if(selectedEmp.is(":checked")){//if the employee has been checked
              sendUserData(dataObj);
            }            
        }    
    }
    $("#spinner").addClass("d-none");
   
   function sendUserData(object){
        $.ajax({
            url:'/school/admin/salaries/execute-payment.php',
            method:'post',
            data:object,
            success:function(data){
                jQuery('#notificationsDiv').html(data);
            },
            error:function(){
                alert("Something went wrong trying to pay salaries");
            }
        });
   }
});
</script>