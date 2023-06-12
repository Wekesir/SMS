 <?php require_once $_SERVER['DOCUMENT_ROOT'].'/school/core/init.php'; ?>
<style>
#debitAccount{
    position:absolute;
    left: 10%;
    width: 80%;
    padding: 20px;
    border: 1px solid lightgray;
}
</style>
<div id="debitAccount">    
    <h5 class="text-danger">Account Action</h5>   <hr>
    <div class="input-group mb-3 mt-1">
        <input type="search" name="search_std" id="search_std" class="form-control" placeholder="UPI Number" aria-label="Recipient's username" aria-describedby="button-addon2">
        <div class="input-group-append">
            <button class="btn btn-primary ml-2 searchStdBtn" type="button" id="button-addon2">
                <span class="spinner-border spinner-border-sm" role="status" aria-hidden="true"></span>
                Search Student
            </button>
        </div>
    </div>
    <div id="errorDiv" class="text-danger"></div>
    <form action="#form" method="post"></form>     
</div>

<script>
jQuery("#form").submit(function(e){
    e.preventDefault();//prebvents the form from submitting 
    var formData = $(this).serialize();//this is the post data being submitted by the form
    jQuery(".formSubmitBtn.spinner-border").addClass("d-inline-block");
    // $.ajax({
    //     url:"/school/admin/helper/debit-credit-execute.php",
    //     method:"POST",
    //     data: formData,
    //     success:function(data){
    //        jQuery("#notificationsDiv").html(data);
    //        jQuery(".formSubmitBtn.spinner-border").removeClass("d-inline-block").addClass("d-none");
    //     },
    //     error:function(){
    //         alert("There was an error trying to send for data");
    //     }
    // });
});

jQuery(".searchStdBtn").click(function(){
    var UPINumber = jQuery("input[type='search']").val();
    if(UPINumber==""){
        $("#errorDiv").html("Provide the student UPI Number!");
        return;
    }else{
        jQuery(".searchStdBtn > .spinner-border").addClass("d-inline-block");//adds the spinner in the button
        $.ajax({
            url:"/school/admin/fetch.php",
            method:"post",
            data:{UPINumber:btoa(UPINumber)},///encrypts using the base64 encryption
            success:function(data){
               $("form").html(data);
               jQuery(".searchStdBtn > .spinner-border").removeClass("d-inline-block").addClass("d-none");//hides the spinner in the button
            },
            error:function(){
                alert("There has been an error trying to fetch student.");
            }
        });
    }
});
</script>