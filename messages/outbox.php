<?php
    require_once $_SERVER['DOCUMENT_ROOT'].'/school/core/init.php';
?>

<div id="messages-searchMenu">
    <label id="searchNameMenu">Search</label>
    <label id="dateFilterMenu">Date</label>
    <label id="displayRangeMenu">Date Range</label>
</div>
<div id="nameearchInput">
    <div class="input-group"> 
    <input type="search" name="nameSearchInput" placeholder="Recipient name here..." id="" class="form-control"  aria-describedby="basic-addon2">
    <div class="input-group-append">
        <button class="btn btn-default btn-sm text-danger ml-2 cancelsearchBtn" type="button">Cancel</button>
    </div>
    </div>
</div>
<div id="dateFilter">
    <div class="input-group">
        <input type="date" name="dateFilter" class="form-control" id="">
        <div class="input-group-append">
            <button class="btn btn-default btn-sm text-success ml-2 filterDatechBtn" type="button">Filter</button>
            <button class="btn btn-default btn-sm text-danger ml-2 cancelDateBtn" type="button">Cancel</button>
        </div>
    </div>
</div>
<div id="dateRangeFilter">
    <div class="row ">
        <div class="col-md-6">
            <label for="">From:</label>
            <input type="date" name="fromDate" id="" class="form-control"></div>
        <div class="col-md-6">
            <label for="">To:</label>
            <input type="date" name="toDate" id="" class="form-control"></div>
    </div>
    <div class="">
        <button class="btn btn-default btn-sm text-success ml-2 filterRangeBtn" type="button">Filter</button>
        <button class="btn btn-default btn-sm text-danger ml-2 cancelDaterangeBtn" type="button">Cancel</button>
    </div>
</div>
<div id="outbox-body"></div>

<script>
jQuery(function(){
    getMessages();
});

jQuery(".filterRangeBtn").click(function(){
    var fromDate = jQuery("input[name='fromDate']").val();
    var toDate   = jQuery("input[name='toDate']").val();
    if(fromDate == "" || toDate ==""){
        alert("Make sure both date inputs are filled.");
        return;
    }else{
        if(new Date(fromDate) > new Date(toDate)){
            alert("From date should be atleast a day before toDate.");
            return;
        }else{
            var dateRange = {
                fromDate: fromDate,
                toDate  : toDate
            };
            jQuery.ajax({//after the message has been deleted, get the messages again
                url:'/school/messages/helper.php',
                method:'post',
                data:{dateRange:dateRange},
                success:function(data){
                jQuery('#outbox-body').html(data);
                },
                error:function(){
                    alert("There was a problem trying to filter by date range");
                }
            });
        }
    }
});

jQuery(".filterDatechBtn").click(function(){
    var filterDate = jQuery("input[name='dateFilter']").val();
    jQuery.ajax({//after the message has been deleted, get the messages again
        url:'/school/messages/helper.php',
        method:'post',
        data:{filterDate:filterDate},
        success:function(data){
        jQuery('#outbox-body').html(data);
        },
        error:function(){
            alert("There was a problem trying to get messages");
        }
    });
});

jQuery("#displayRangeMenu").click(function(){
    jQuery("#dateRangeFilter").fadeIn();
});

jQuery(".cancelDaterangeBtn").click(function(){
    jQuery("#dateRangeFilter").fadeOut();
});

jQuery("#dateFilterMenu").click(function(){
    jQuery("#dateFilter").fadeIn("slow");
});

jQuery(".cancelDateBtn").click(function(){
    jQuery("#dateFilter").fadeOut("slow");
});

jQuery("#searchNameMenu").click(function(){
    jQuery("#nameearchInput").fadeIn("slow");
});

jQuery(".cancelsearchBtn").click(function(){//when the cancel btn has brn clicked
   jQuery("#nameearchInput").fadeOut("slow");
});

jQuery("input[name='nameSearchInput']").keyup(function(){
    var searchName = jQuery(this).val();
    if(searchName==""){
        getMessages();
    }else{
        jQuery.ajax({//after the message has been deleted, get the messages again
            url:'/school/messages/helper.php',
            method:'post',
            data:{searchName:searchName},
            success:function(data){
            jQuery('#outbox-body').html(data);
            },
            error:function(){
                alert("There was a problem trying to get messages");
            }
        });
    }
});


function getMessages(){
    var getMessages = '';
    jQuery.ajax({
        url:'/school/messages/helper.php',
        method:'post',
        data:{getMessages:getMessages},
        success:function(data){
            jQuery('#outbox-body').html(data);
            //when the delete message has been clicked
            jQuery(".deleteMessage").click(function(){
                if(confirm("Proceed to delete message?")){
                var deleteMessageId = jQuery(this).attr("id");
                    jQuery.ajax({
                        url:'/school/messages/helper.php',
                        method:'post',
                        data:{deleteMessageId:deleteMessageId},
                        success:function(){
                            alert("Message has been deleted!");
                            jQuery.ajax({//after the message has been deleted, get the messages again
                                url:'/school/messages/helper.php',
                                method:'post',
                                data:{getMessages:getMessages},
                                success:function(data){
                                   location.reload(true);
                                },
                                error:function(){
                                    alert("There was a problem trying to get messages");
                                }
                            });
                        },
                        error:function(){
                            alert("there was a problem trying to display messages.");
                        }
                    }); 
                }
            });
                    },
        error:function(){
            alert("there was a problem trying to display messages.");
        }
    });
}
</script>

<style>
#dateRangeFilter{
    padding: 3px;
    border: 1px solid lightgrey;
    margin: 0px;
    position: absolute;
    right: 3%;
    top: 13%;
    width: 40%;
    background-color:#f8f8f8;
    box-shadow: 0 4px 8px 0 rgba(0, 0, 0, 0.2), 0 6px 20px 0 rgba(0, 0, 0, 0.19); 
    display:none;
}
#dateFilter{
    padding: 3px;
    border: 1px solid lightgrey;
    margin: 0px;
    position: absolute;
    right: 3%;
    top: 13%;
    width: 40%;
    background-color:#f8f8f8;
    box-shadow: 0 4px 8px 0 rgba(0, 0, 0, 0.2), 0 6px 20px 0 rgba(0, 0, 0, 0.19); 
    display:none;
}
#nameearchInput{
    padding: 3px;
    border: 1px solid lightgrey;
    margin: 0px;
    position: absolute;
    right: 3%;
    top: 13%;
    width: 40%;
    background-color:#f8f8f8;
    box-shadow: 0 4px 8px 0 rgba(0, 0, 0, 0.2), 0 6px 20px 0 rgba(0, 0, 0, 0.19);
    display:none;
}
#messageBody{
    border: 1px solid lightgrey;
    min-height: 17vh;
    max-height: 25vh;
    margin: 10px;
    width: 100%;
    padding: 10px;
    background-color:white;
    border-radius: 20px;
}
#outbox-body{
    border: 1px solid lightgrey;
    width: 100%;
    min-height: 72.3vh;
    max-height: 72.3vh;
    overflow:auto;
    padding: 10px;
    background-color:#f8f8f8;
}
#messages-searchMenu label{
    border-bottom: 1px solid #f8f8f8;
}
#messages-searchMenu label:hover{
    color:#0275d8;
    border-bottom:1px solid #0275d8;
}
#messages-searchMenu{
    background-color: #f8f8f8;
    border-bottom: 1px solid blue;
}
</style>