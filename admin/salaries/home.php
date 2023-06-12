<div class="container-fluid">
    <div id="search-employee-div" class="shadow">
        <div class="input-group px-5">
            <div class="input-group-prepend">
                <span class="input-group-text px-3 bg-transparent"> <i class="fas fa-search"></i></span>
            </div>
            <input type="search" class="form-control" aria-label="Dollar amount (with dot and two decimal places)" placeholder="Search employee name...">
            <div class="input-group-append">
                <span class="input-group-text px-3 bg-transparent"><img src="<?=$configurationData['school_logo'];?>" alt="School logo" style="height:20px; width:20px;"></span>
            </div>
        </div>
    </div>
    <div id="emp-salaries-searchResults">
        <div class="spinner-border" role="status">
        <span class="sr-only">Loading...</span>
        </div>
    </div>
</div>

<!-- Modal -->
<div class="modal fade" id="view_payments_modal" data-backdrop="static" data-keyboard="false" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
  <div class="modal-dialog modal-dialog-centered modal-lg">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="exampleModalLabel">Individual Payments.</h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <div class="modal-body"></div>
      <div class="modal-footer">
        <a href="../print/print-individual-salary-payments.php"><button type="button" class="btn btn-primary"><i class="fas fa-print"></i> Print</button></a>
      </div>
    </div>
  </div>
</div>

<script>
jQuery('input[type="search"]').on("search", function(){
    $("#emp-salaries-searchResults").html(); //remove all the data fro the Div
});

jQuery('input[type="search"]').keyup(function(){
    var staff_name_finance = jQuery(this).val();
    if(staff_name_finance == ""){
        $("#emp-salaries-searchResults").html();
        return;
    }else{
        jQuery.ajax({
            url:'/school/admin/salaries/fetch.php',
            method:'POST',
            data:{staff_name_finance:staff_name_finance},            
            success:function(data){//code for the UTOCOMPLETE                  
                $("#emp-salaries-searchResults").html(data);
                $("#emp-salaries-searchResults").find(".userId").click(function(){
                    var userId = $(this).attr("id");
                    view_user_payments(userId);
                })
                return;
            },
            error:function(){
                alert("Something went wrong trying to search student");
            }
        }); 
    }
   
});

function view_user_payments(id){
   $("#view_payments_modal").modal("show");
   jQuery.ajax({
        url:'/school/admin/salaries/fetch.php',
        method:'POST',
        data:{"SPECIFIC_USER_ID":id},            
        success:function(data){         
            $("#view_payments_modal").find(".modal-body").html(data);     
            $("#view_payments_modal").modal("show");
        },
        error:function(){
            alert("Something went wrong trying to search student");
        }
    }); 
}
</script>
