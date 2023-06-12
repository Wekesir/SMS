
<style>
#paymentDiv{
    position:relative;
    padding: 30px;
    width: 70%;
    left:  15%;
}
.header{
    font-weight:normal;
    background: #f8f8f8;
    padding: 20px;
}
#studentDetailsDiv{
    width: 100%; 
    background: #f8f8f8;
    padding: 20px;
}
</style>

<div id="paymentDiv">
    <h6 class="text-center header"><b>MAKE A NEW PAYMENT</b></h6>
    <div id="notificationsDiv" class="alert alert-warning alert-dismissible fade show d-none" role="alert">
        <strong>Error!</strong> <span id="msg"></span>
        <button type="button" class="close" data-dismiss="alert" aria-label="Close">
        <span aria-hidden="true">&times;</span>
        </button>
    </div>
    <form action="finance.php" method="POST" id="makePaymentForm">
        <div class="row">
            <div class="col-md-12">
                <div class="form-group">                       
                    <label for=""><b>UPI NUMBER</b></label>
                    <div class="input-group mb-3">        
                    <input type="text" name="regno" id="regno" class="form-control" aria-label="Recipient's username" aria-describedby="basic-addon2" required=required>
                    <div class="input-group-append">
                        <input type="submit" class="btn btn-primary ml-2" id="findStudentBtn" title="Click to make sure you have the correct student." type="button" value="Find Student">
                    </div>
                    </div>                         
                </div>
            </div><!--Closing col-md-12 div--->
        </div><!--Closing row div--->
        <div class="row">
            <div class="col-sm-6">
                <div class="form-group">
                    <label for="amount">Fees Amount{Kshs}.</label> <br>
                    <input type="number" class="form-control" id="amount" name="amount" min=0 required=required>
                </div>
            </div><!---Closing col-sm-6 div-->
            <div class="col-sm-6">
                <div class="form-group">
                    <label for="paymentmode">Select mode of payment.</label>
                    <select name="paymentmode" class="form-control" id="paymentmode" required=required>
                        <option value=""></option>
                        <option value="CASH">CASH</option>
                        <option value="MPESA">MPESA</option>
                        <option value="BANK">BANK</option>
                    </select> 
                </div>
            </div><!--Closing col-sm-6 div--->
            <div class="col-md-12 form-group" id="bankdetailsdiv">
                <label for="chequenumber">Cheque Number</label>
                <input type="text" name="chequenumber" class="form-control">
            </div><!--closing col-md 12 div-->
            <div class="col-md-12 form-group" id="banknamediv">
                <label for="bankname">Select Bank</label>
                <select name="bankname" id="bankname" class="form-control">
                    <option value=""></option>
                    <?php $query = $db->query("SELECT * FROM banks"); while($bankQuery = mysqli_fetch_array($query)) :?>
                    <option value="<?=$bankQuery['bank'];?>"><?=$bankQuery['bank'].' - '.$bankQuery['account_number'];?></option>
                    <?php endwhile;?>
                </select>
            </div><!--closing col-md 12 div-->
            <div class="col-md-12">
                <div class="form-group" id="mpesacode">
                    <label for="mpesacode">M-PESA Code:</label>
                    <input type="text" name="mpesacode" class="form-control">
                </div>
            </div><!---Closing col-md 12 div-->
            <div class="" id="studentDetailsDiv"></div>
            <div class="form-group col-md-12">
                <button class="btn btn-primary d-none" type="submit">
                    <span class="spinner-border spinner-border-sm" role="status" aria-hidden="true"></span>
                    Submit
                </button>
            </div>
        </div>
    </form>
</div>  
     

<script>

jQuery(document).ready(function(){
    jQuery('#bankdetailsdiv').css('display','none');//hides the bankdetails div until mpesa is selected as mode of payment
    jQuery('#banknamediv').css('display','none');//hides the bank name details div 
    jQuery('#mpesacode').css('display','none');//hides the mpesacode div until Bank is selected as mode of payment
    
    jQuery("#findStudentBtn").click(function(e){
        e.preventDefault(); 
        var findstudent = jQuery('#regno').val(); 
        if(findstudent==""){
            alert("Provide a student UPI Number");
        }else{
            jQuery.ajax({
                url:'/school/admin/fetch.php',
                method:'POST',
                data:{findstudent:findstudent},
                success:function(data){//code for the UTOCOMPLETE
                    jQuery('#studentDetailsDiv').html(data);//indert value to the studentDetailsDiv
                    $("#submitBtn").removeClass("d-none");
                    $("#makePaymentForm").find("button[type='submit']").removeClass("d-none").addClass("d-block");
                    $("#makePaymentForm").submit(function(e){
                        e.preventDefault();
                        var formData = $(this).serialize(); 
                        $(this).find(".spinner-border").addClass("active");
                        $.ajax({
                            url:"/school/admin/helper/execute-payment.php",
                            method:"POST",
                            data: formData,
                            success: function(data){                             
                                $("#makePaymentForm").find(".spinner-border").removeClass("active");                               
                                var output_arr = JSON.parse(data);
                                if(output_arr.status == 1){ // success
                                    window.location="/school/print/fees-receipt.php?amt="+$("#makePaymentForm").find("input[name='amount']").val(); //get the amount 
                                    $("#makePaymentForm").trigger("reset");//reset the form data 
                                }else{ //error
                                    $("#paymentDiv").find("#notificationsDiv").removeClass("d-none"); //makes this div visible 
                                    $("#paymentDiv").find("#notificationsDiv span#msg").html(output_arr.output); //the error message displayes in the span input
                                }                              
                            },
                            error: function(){
                                alert("There was a problem making new payment! Try agin");
                            }
                        });
                    });
                },
                error:function(){
                    alert("Something went wrong trying to search student");
                }
            });
        }
        
    });
    
    jQuery('#paymentmode').change(function(){
        var mode=jQuery(this).val();      
      if(mode=='MPESA'){
        jQuery('#mpesacode').css('display','block');
      }else{
        jQuery('#mpesacode').css('display','none');
      }
    });

    //when the payment modal has been changed 
    jQuery('#paymentmode').change(function(){
      var mode = jQuery(this).val();      
      if(mode=='BANK'){
         jQuery('#bankdetailsdiv').css('display','block');
         jQuery('#banknamediv').css('display','block')
      }else{
        jQuery('#bankdetailsdiv').css('display','none');
        jQuery('#banknamediv').css('display','none')
      }
    });

});

</script>