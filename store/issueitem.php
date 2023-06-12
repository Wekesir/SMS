
<div class="container-fluid" style="padding-top: 10px;">
    <form action="">
    <div class="row" >
        <div class="col-md-4 form-group" style="" >
                <input type="text" id="searchItem" class="form-control" placeholder="Search item(s) here...">
            <div id="searchResult" style="border: 0.5px solid lightgrey; height:70vh;margin-top: 10px;padding: 5px;overlow:auto;">
                <h5 style="color:lightblue;">...items you search will appear here...</h5>
            </div>
        </div>
        <div class="col-md-4">
            <div style="border: 1px solid lightblue;position:relative;top:20%; height:40vh;overflow:auto;padding: 10px;">
                <div class="form-group">
                    <h5 for="">Select recipient...</h5>
                    <div class="radio">
                        <label class="radio-inline" for=""><input type="radio" name="issueTo" value="Student" <?='checked';?>> Student</label>
                        <label class="radio-inline" for=""><input type="radio" name="issueTo" value="Staff"> Staff</label> 
                    </div>
                    <div class="form-group form-inline verify-student-div">
                        <label for="">Provide student registration number.</label>
                        <input type="text" class="form-control" name="verify-student" placeholder="Registration Number" style="width: 80%;margin-right: 10px;">
                        <input type="submit" class="btn btn-md btn-primary" value="Verify">
                    </div>
                     <div class="form-group form-inline verify-staff-div" style="display:none;">
                        <label for="">Search staff name.</label><br>
                        <input type="text" class="form-control" name="verify-student" placeholder="Staff Name" style="width: 80%;margin-right: 10px;">
                        <input type="submit" class="btn btn-md btn-primary" value="Verify">
                    </div>
                    <div class="form-group">
                       <div id="infoDiv"></div><!--this div displays info whether the verification process was successful or not-->
                    </div>
                </div>
            </div>
        </div>
        <div class="col-md-4">
            <div style="border:1px solid lightblue;padding: 10px;height: 78vh;overflow:auto" id="displaySelectedItemsDiv">
                                
            </div>
            <button class="btn btn-danger btn-sm cancelBtn" style="position:absolute;left:5%;bottom:3vh;" title="Cancel giving out item(s).">Cancel</button>
            <button class="btn btn-success btn-sm confirmBtn" style="position:absolute;right:5%;bottom:3vh;" title="Confirm you want to give item(s).">Confirm</button>
        </div>
    </div>
    </form>
</div>


<script>
var issueToRadio = jQuery('input[name="issueTo"]');

getSelectedItems();

jQuery('.cancelBtn').click(function(event){//cancel button for canceliing the items to be given
    event.preventDefault();
    if(confirm("Are you sure you want to cancel process?")){
        var cancelProcess = '';
        $.ajax({
            url:'/school/store/get-selected-items.php',
            method:'post',
            data:{cancelProcess:cancelProcess},
            success:function(){
                getSelectedItems();
            },
            error:function(){
                alert("SOmething went wrong trying to cancel process!");
            }
        });
    }    
});


function getSelectedItems(){//this function constantly checks if any items have been created 
    var itemsRequest    =   '';
    $.ajax({
        url:'/school/store/get-selected-items.php',
        method:'post',
        data:{itemsRequest:itemsRequest},
        success:function(data){
            $('#displaySelectedItemsDiv').html(data);
        },
        error:function(){
            alert("Error checking if any items have been added!");
        }
    });
}


jQuery('.confirmBtn').click(function(event){//this is the button for confirming to give out items
    event.preventDefault();
    var issueTo = jQuery('input[name="issueTo"]:checked').val(); 
        $.ajax({
            url:'/school/store/confirm-issue.php',
            method:'post',
            data:{issueTo:issueTo},
            success:function(data){
                if(confirm(data)){
                     location.reload(true);
                }               
            },
            error:function(){
                alert("An error occured trying to confirm issuing of the item(s)!");
            }
        });
    
});



$('.verify-staff-div > input[type="submit"]').click(function(event){
    event.preventDefault();
    var staffVerify = $('.verify-staff-div > input[type="text"]').val();
    $.ajax({
        url:'/school/store/fetch.php',
        method:'post',
        data:{staffVerify,staffVerify},
        success:function(data){
            $('#infoDiv').html();
            $('#infoDiv').html(data);  
            $('.selectedStaff').click(function(){//once a staff is selected, the id is used to set a cookie called STAFF_ID
                var selectedId = $('.selectedStaff:checked').attr("id");
                document.cookie = "STAFF_ID = "+selectedId;
            });          
        },
        error:function(){
            alert("Something went wrong trying to verify student");
        }
    });
});

$('.verify-student-div > input[type="submit"]').click(function(event){//when the verify button has been clicked to verify student
    event.preventDefault(); 
    var verReg = $('.verify-student-div > input[type="text"]').val(); 
    $.ajax({
        url:'/school/store/fetch.php',
        method:'post',
        data:{verReg,verReg},
        success:function(data){
            $('#infoDiv').html();
            $('#infoDiv').html(data);
        },
        error:function(){
            alert("Something went wrong trying to verify student");
        }
    });
});

issueToRadio.click(function(){
    var issueTo = $(this).val();
    if(issueTo == 'Student'){
        $('.verify-student-div').fadeIn(1000);
        $('.verify-staff-div').hide();
    }else if(issueTo == 'Staff'){
        $('.verify-student-div').hide();
        $('.verify-staff-div').fadeIn(1000);
    }
});

jQuery("#searchItem").focus();

jQuery("#searchItem").keyup(function(){
    var itemName = $(this).val();
     $.ajax({
        url:'/school/store/fetch.php', 
        method:'post',
        data:{itemName:itemName},
        success:function(data){
            $('#searchResult').html();
            $('#searchResult').html(data);

            jQuery('#searchResult .addItemBtn').click(function(event){//when the add button has been clicked
              event.preventDefault();
              var btnCount     = $(this).attr("data-btnCount");//gets the exact number on the button
              var row          = $('#rowCount'+btnCount);
              var availableQty = row.find("#qty").html(); //gets the quantity of the selected item
              var dbId         = row.find('#ItemId').val();    //gets the id of the item selected
              var enteredQty   = row.find("#slctQty").val(); //gets the quanity entered by user
              var itemretrn    = row.find("input[type='radio']:checked").val(); //gets to know whether the item is returnable or not
            
              //check if a quanity has been provided when add btn is clicked
              if(enteredQty == ''){
                  alert("You have to provide a quantity to proceed");
                  return;
              }else if((enteredQty - availableQty) > 0 && (enteredQty - availableQty) != 0){//checks if the requested amount is more than what is in store.
                  alert(enteredQty+" is more than what is available ("+availableQty+"). ");
                  return;
              }else if(itemretrn == 'undefined'){
                  alert("Specify whether the item is to be returned or not.");
                  return;                 
              }else{//adding file to database after passing all checks

                 var itemData = {
                     itemId    :  dbId,//this is the item id from database
                     itemQty   :  availableQty,//quanity available in databse
                     reqstdQty :  enteredQty,//quantity being requested
                     itemRtrn  :  itemretrn,//is the item returnable or not
                 }; 

                  $.ajax({
                      url:'/school/store/issue-database.php',
                      method:'post',
                      data:itemData,
                      success:function(){
                        getSelectedItems();
                      },
                      error:function(){
                          alert("An error occured trying to insert item to database!");
                      }
                  });
              }
            });

        },
        error:function(){
            alert("Something went wrong trying to search for item");
        }
    });
});
</script>