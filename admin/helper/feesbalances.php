<!--THIS SCRIPT IS FOR SHOWING STUDENT BALANCES-->
<div class="row">
    <div class="col-md-8">
        <div id="tableDiv"></div>        
    </div><!--Closing col-md-8 div-->

    <div class="col-md-4">
        <div class="form-group">
            <label class="font-weight-bold">Filter By Student</label>
            <input type="search" class="form-control" id="regNumber" placeholder="UPI Number">
        </div>
        <div class="form-group">
            <button class="btn btn-md btn-primary btn-block" id="regFilterBtn"><i class="fas fa-filter"></i> Filter</button>
        </div>
        <div class="form-group">
            <label for="filter_by" class="font-weight-bold">Filter By Grade:</label>
            <select name="filter_by" id="filter_by" class="form-control">
                <option value="">All students</option>
                <?php
                $filterQuery = $db->query("SELECT * FROM `grade`");
                while($filterQueryData = mysqli_fetch_array($filterQuery)):?>
                <option value="<?=$filterQueryData['id'];?>"><?=$filterQueryData['grade'];?></option>
                <?php endwhile;?>
            </select>
        </div> 
        <div class="form-group">
            <button type="button" class="btn btn-info btn-md btn-block"><i class="fas fa-print"></i> Print Balances</button>
            <button type="button" class="btn btn-dark btn-md btn-block" data-toggle="modal" data-target="#sendMsgModal"><i class="far fa-comment-alt"></i> Send Messages</button>
        </div>

        <!-- Modal -->
        <div class="modal fade" id="sendMsgModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalCenterTitle" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered" role="document">
            <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="exampleModalCenterTitle">Send Messages</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <div id="notificationsDiv"></div>
                <form id="balancesMsgForm">
                <div class="form-group">
                    <textarea name="msg" class="form-control" id="" rows="4" required=required></textarea>
                </div>
                <div class="form-group">
                    <label for="exampleFormControlSelect2" class="font-weight-bold">Send Message to?</label>
                    <select class="form-control" id="exampleFormControlSelect2">
                    <option value="0">All Students</option>
                    <?php
                    $filterQuery = $db->query("SELECT * FROM `grade`");
                    while($filterQueryData = mysqli_fetch_array($filterQuery)):?>
                    <option value="<?=$filterQueryData['id'];?>"><?=$filterQueryData['grade'];?></option>
                    <?php endwhile;?>
                    </select> 
                </div>
                <div class="form-group">
                    <input type="checkbox" id="vehicle1" name="vehicle1" value="Bike" class="text-primary" onclick="toggleFilter()"> Advanced Filter
                </div>
                <hr>
                <div class="form-group d-none" id="advFilterDiv">
                    <div class="row">
                        <div class="col-md-6">
                            <label for="">Min Amount</label>
                            <input type="number" min=0 name="minamt" class="form-control">
                        </div>
                        <div class="col-md-6">
                            <label for="">Max Amount</label>
                            <input type="number" name="maxamt" class="form-control" min=0>
                        </div>
                    </div>
                </div>
                <div class="form-group">
                    <button type="submit" class="btn btn-primary btn-md">
                        <span class="spinner-border spinner-border-sm" role="status" aria-hidden="true"></span>
                        Send Message(s).
                    </button>
                </div>
                </form>
            </div>
            <div class="modal-footer">
                
            </div>
            </div>
        </div>
        </div>
    </div><!--Closing col-md-4 div--->
</div><!--Closing row div-->

<script>
get_balances();

jQuery("#balancesMsgForm").submit(function(e){
    e.preventDefault(); //prevents the form from submitting
    //create an object that will hold all the form data
    var formData = {
        message : $(this).find("textarea[name='msg']").val(),//gets the value frommthe message textarea
        level: $(this).find("select option:selected").val(), //gets the value of the specific level 
        minamt: $(this).find("input[name='minamt']").val(), //gets the value set as the minimum amt
        maxamt: $(this).find("input[name='maxamt']").val() //gets the va;ue of the maximum amt
    }; 

    jQuery(this).find("spinner-border").addClass("active"); //display the spinner on the button

    jQuery.ajax({
        url:"/school/messages/send-messages.php",
        method:"POST",
        data: {SEND_FEE_BALANCES: formData},
        success: function(data){
            jQuery("#sendMsgModal").find("#notificationsDiv").html(data);
            jQuery("#balancesMsgForm").trigger("reset"); //reset the form data
            jQuery("#balancesMsgForm").find("spinner-border").removeClass("active"); //remove the spinner on the button
        },
        error: function(){
            alert("Fatal error trying to send message to the server. Contact system provider");
        }
    });
});

//this function captures any cahnges inthe min value and adds the same value to the max field
jQuery("#balancesMsgForm").find("input[name='minamt']").on("change paste", function(){
    var minAmt = parseFloat(jQuery(this).val());
    var maxAmt = (minAmt + 1);
    //setting the max amt input field
    jQuery("#balancesMsgForm").find("input[name='maxamt']").prop("min", maxAmt);
});

function toggleFilter(){
    jQuery("#sendMsgModal").find("#advFilterDiv").toggleClass("d-none");
}

//this function rusns when the page as been loaded
function get_balances(){
    jQuery.ajax({ 
        url:'/school/admin/helper/fetch-fees-balances.php',
        method:'GET',
        success:function(data){
            jQuery("#tableDiv").html();
            jQuery("#tableDiv").html(data);
        },
        error:function(){
            alert('Something went wrong trying to filter student registration Number.');
        }
    }); 
};

//when the X button has been clicked 
jQuery("#regNumber").on("search", function(){
    get_balances();
});

jQuery("#regFilterBtn").click(function(){
    var regNumberFilterFees = jQuery("#regNumber").val().trim();
    if(regNumberFilterFees == ""){
        alert("Provide a reg Number to filter by");
    }else{
        jQuery.ajax({ 
            url:'/school/admin/helper/fetch-fees-balances.php',
            method:'post',
            data:{regNumberFilterFees:regNumberFilterFees},
            success:function(data){
                jQuery("#tableDiv").html();
                jQuery("#tableDiv").html(data);
            },
            error:function(){
                alert('Something went wrong trying to filter student registration Number.');
            }
        }); 
    }
});

jQuery('#filter_by').change(function(){
    var selectedGrade = jQuery('#filter_by option:selected').val();
    jQuery.ajax({
        url:'/school/admin/helper/fetch-fees-balances.php',
        method:'post',
        data:{selectedGrade:selectedGrade},
        success:function(data){
            jQuery("#tableDiv").html();
            jQuery("#tableDiv").html(data);
        },
        error:function(){
            alert('Something went wrong trying to filter students.');
        }
    });
});
</script>