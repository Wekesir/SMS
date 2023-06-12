<?php
require dirname(__DIR__).'/core/init.php';//database connection file
require dirname(__DIR__).'/message_admin/functions.php';

if(!logged_in())://check if tje user has been logged in
    not_logged_in_page_redirect();
endif;

$contactsQuery  = $db->query("SELECT `name`,`phone` FROM `contacts` ORDER BY `name`");
$unreadMsgQuery = $db->query("SELECT * FROM `messages` WHERE `read_status`=0");
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Message Center | <?=$configurationData['school_name']?></title>
    <link rel="icon" href="<?=$configurationData['school_logo']?>">
    <!-- CSS only -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-1BmE4kWBq78iYhFldvKuhfTAU6auU8tT94WrHftjDbrCEXSU1oBoqyl2QvZ6jIW3" crossorigin="anonymous">  
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.8.1/font/bootstrap-icons.css">
    <link rel="stylesheet" href="https://use.fontawesome.com/releases/v5.15.4/css/all.css" integrity="sha384-DyZ88mC6Up2uqS4h/KRgHuoeGwBcD4Ng9SiP4dIRy0EXTlnuz47vAwmeGwVChigm" crossorigin="anonymous"/>
</head>
<body>
    <div class="container-fluid bg-dark" style="height: 100vh">
        <div class="row">
            <div class="col-md-3">
                <h3 class="text-primary"><a href="../admin/index.php"><i class="bi bi-arrow-left-circle"></i></a> MESSAGE CENTER</h3>
            </div>
            <div class="col-md-6">
                <div class="container">
                <div id="searchDiv">
                    <div class="input-group">
                        <button class="btn" type="button" id="button-addon1"> <i class="bi bi-search"></i> </button>
                        <input type="search" class="form-control" placeholder="Search message..."  aria-describedby="button-addon1">
                        <button class="btn filter" type="button" id="button-addon2" > <i class="bi bi-funnel-fill"></i> </button>
                    </div>
                </div>
                </div>
            </div>
            <div class="col-md-3">
                <label for="" class="sms_counter badge bg-danger"></label>
                <img src="<?=$logged_in_user_data['image']?>" class="float-end border border-1 border-danger" alt="Image" style="height: 45px; width: 45px;border-radius: 50%;">
            </div>
        </div>
        <div class="row pt-4">
            <div class="col-md-3">
                <button class="btn btn-info btn-lg border border-info rounded-pill" id="compose-msg-btn"> <i class="bi bi-plus-lg"></i> Compose Message</button>
                <ul id="menu">
                    <li id="sent" class="active"><i class="bi bi-send-fill"></i> &nbsp; Sent</li>
                    <li id="inbox"><i class="bi bi-envelope-open-fill"></i> &nbsp; Inbox <label id="inbox_counter" class="badge bg-danger float-end"><?=mysqli_num_rows($unreadMsgQuery)?></label> </li>
                    <li id="draft"><i class="bi bi-file-earmark-fill"></i>&nbsp; Drafts <label id="draft_counter" class="badge bg-warning float-end">0</label></li>
                    <li id="schedule"><i class="bi bi-stopwatch-fill"></i>&nbsp; Scheduled <label id="schedule_msg_counter" class="badge bg-info float-end">0</label></li>
                </ul>
                <div id="contactsDiv">
                    <h6><a href="../admin/contacts.php" class="text-info" title="Click to access the contacts.">Contacts</a>  <label class="float-end badge bg-danger"><?=mysqli_num_rows($contactsQuery)?></label></h6> <hr>
                    <ul>
                        <?php $contactCount=1; while($contactData = mysqli_fetch_array($contactsQuery)):?>
                        <li title="Send message to this contact."><?=cutstring($contactCount.' - '.$contactData['name'], 30)?> <label class="badge bg-primary float-end send-contacts-btn" data-recipientName="<?=$contactData['name']?>" id="<?=$contactData['phone']?>">Send</label> </li>
                        <?php $contactCount++; endwhile;?>
                    </ul>
                </div>
                <div id="filterDiv" class="bg-dark p-3 d-none">
                    <h5 class="text-danger">Advanced Filter<button type="button" class="btn-close float-end btn-close-white" aria-label="Close"></button></h5> <hr>
                    <form action="#" id="filterForm">
                       <div class="form-group mb-3">
                           <label for="" style="color: cyan" class="fw-bold mb-2">Recipient Name:</label>
                           <input type="text" name="recipientName" style="background:none; color:white" class="form-control">
                       </div>
                       <div class="form-group mb-3">
                            <div class="form-check form-check-inline">
                            <input class="form-check-input" type="radio" name="inlineRadioOptions" id="date" value="option1" required=required>
                            <label class="form-check-label fw-bold text-primary" for="inlineRadio1">Single Date</label>
                            </div>
                            <div class="form-check form-check-inline">
                            <input class="form-check-input" type="radio" name="inlineRadioOptions" id="range" value="option2">
                            <label class="form-check-label fw-bold text-primary" for="inlineRadio2">Date Range</label>
                            </div>   
                        </div>                       
                       <div class="form-group mb-3" id="dateDiv">
                           <label for="" style="color: cyan" class="fw-bold mb-2">Message Date:</label>
                           <input type="date" name="date" style="background:none; color:white" class="form-control">
                        </div>
                       <div class="form-group mb-3" id="dateRangeDiv">
                           <label for="" style="color: cyan" class="fw-bold mb-2">Date range:</label>
                           <input type="date" name="dateRangeFrom" style="background:none; color:white" class="form-control mb-3">                           
                           <input type="date" name="dateRangeTo" style="background:none; color:white;" class="form-control">
                        </div>
                        <div class="form-group">
                            <div class="d-grid gap-2 col-12 mx-auto">
                            <button class="btn btn-info" type="submit">
                                <span class="spinner-border spinner-border-sm" role="status" aria-hidden="true"></span>
                                Filter Messages
                            </button>
                            <button class="btn btn-danger cancelFilterBtn" type="submit">Cancel Filter</button>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
            <div class="col-md-9">
                <div id="mainMsgContentDiv">
                    <div id="leftMenuContentDiv" class="active" data-list_id="sent">
                        <div id="messageMainDiv">
                            <table class="table table-md table-borderless text-white table-hover">
                                <tbody></tbody>
                            </table>
                                <!-- Modal -->
                            <div class="modal fade" id="exampleModal" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
                                <div class="modal-dialog modal-dialog-centered modal-dialog-scrollable">
                                    <div class="modal-content">
                                    <div class="modal-header">
                                        <h5 class="modal-title" id="exampleModalLabel">Message Details</h5>
                                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                                    </div>
                                    <div class="modal-body">
                                        <div id="notificationsDiv"></div>
                                        <h6 id="recipient"></h4> <hr>
                                        <div id="message"></div> <hr>
                                        <h6 id="phone"></h6>
                                    </div>
                                    <div class="modal-footer">
                                        <button type="button" class="btn btn-sm btn-danger" id=""><i class="bi bi-trash-fill"></i> Delete Message</button>
                                    </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div id="leftMenuContentDiv" data-list_id="inbox">
                        <div id="inboxMainDiv">
                            <table class="table table-md table-borderless text-white table-hover">
                                <tbody></tbody>
                            </table>
                            <!-- Modal -->
                            <div class="modal fade" id="exampleModal" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
                                <div class="modal-dialog modal-dialog-centered modal-dialog-scrollable">
                                    <div class="modal-content">
                                    <div class="modal-header">
                                        <h5 class="modal-title" id="exampleModalLabel">Message Details</h5>
                                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                                    </div>
                                    <div class="modal-body">
                                        <div id="notificationsDiv"></div>
                                        <h6 id="sender"></h4> <hr>
                                        <div id="message"></div> <hr>
                                        <h6 id="phone"></h6>
                                    </div>
                                    <div class="modal-footer">
                                        <button type="button" class="btn btn-sm btn-danger" id=""><i class="bi bi-trash-fill"></i> Delete Message</button>
                                    </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div id="leftMenuContentDiv" data-list_id="draft">3rd Div</div>
                    <div id="leftMenuContentDiv" data-list_id="schedule">
                        <div id="scheduleMainDiv">
                            <table class="table table-md table-borderless text-white table-hover">
                                <tbody></tbody>
                            </table>
                        </div>
                    </div>
                </div>
                <div id="sendMessageDiv" class="bg-dark d-none">
                    <div id="header">
                        <h5 class="text-info">Send Message(s).  <button type="button" class="btn-close float-end btn-close-white" aria-label="Close"></button></h5>                     
                        <hr>
                    </div>
                    <div id="notificationDiv"></div>
                    <div id="msg-recipients-div" class="my-3">
                        <button type="button" id="displayRecipientsBtn" class="btn btn-primary" title="click to add or view existing message recipients.">Add/View Message Recipient(s).</button>
                    </div>
                    <div id="messageDIv">
                        <form action="<?=$_SERVER['PHP_SELF']?>" method="post">
                        <div class="form-group mb-3">
                            <label for="" class="text-white fw-bold mb-2">SUBJECT</label>
                            <input type="text" name="subject" style="background:none;color:white;text-transform:uppercase;" id="subject" class="form-control" required=required>
                        </div>
                        <div class="form-group mb-3">
                            <label for="" class="text-white fw-bold mb-2">MESSAGE</label>
                            <textarea name="msg" style="background:none; border: 1px solid blue; color:white;" class="form-control" rows="9" required=required></textarea>
                        </div>
                        <div class="form-group">
                            <!-- Example split danger button -->
                            <div class="btn-group">
                            <button type="submit" class="btn btn-md btn-info"><i class="bi bi-send"></i> Send Message</button>
                            <button type="button" class="btn btn-info dropdown-toggle dropdown-toggle-split" data-bs-toggle="dropdown" aria-expanded="false">
                                <span class="visually-hidden">Toggle Dropdown</span>
                            </button>
                            <ul class="dropdown-menu dropdown-menu-dark">
                                <li><a class="dropdown-item" href="#" id="scheduleMsgBtn"><i class="bi bi-send-slash"></i> Schedule Send</a></li>
                            </ul>
                            </div>
                        </div>
                        </form>
                    </div>
                </div>
                <div id="scheduleSendDiv" class="bg-dark d-none">
                    <h5 class="text-info">Schedule Send. <button type="button" class="btn-close float-end btn-close-white" aria-label="Close"></button></h5> <hr>
                    <div id="notificationsDiv"></div>
                    <form action="#" method="post" id="calendarForm">
                    <div class="form-group mb-3">
                        <label class="mb-2 text-light fw-bold">SELECT DATE & TIME</label>
                        <input type="datetime-local" name="scheduleDate" min="<?=date('Y-m-d H:i:s')?>" class="form-control" id="" style="background: none; color:white" required=required>
                    </div>
                    <div class="form-group mb-1">
                        <button type="submit" class="btn btn-md btn-info"><i class="bi bi-send-slash"></i> Schedule Send</button>
                    </div>
                    </form>
                </div>
                <div id="recipientDiv" class="bg-dark d-none">
                    <h5 class="text-info">Message Recipients. <button type="button" class="btn-close float-end btn-close-white" aria-label="Close"></button></h5>
                    <hr>
                    <div id="recipientList" style="height: 230px; border: 1px solid red; overflow:auto;" class="row">
                        <ul></ul>
                    </div>
                    <form action="<?=$_SERVER['PHP_SELF']?>" method="post">
                        <div class="form-group mb-3">
                            <label for="" class="text-white fw-bold mb-2">NAME</label>
                            <input type="text" class="form-control" name="name" required=required style="background: none; color:white">
                        </div>
                        <div class="form-group mb-3">
                            <label for="" class="text-white fw-bold mb-2">PHONE NUMBER</label>
                            <input type="tel" class="form-control" name="phone" required=required style="background: none; color:white">
                        </div>
                        <div class="form-group">
                            <button type="submit" class="btn btn-md btn-primary">Add recipient(s)</button>
                            <button type="button" class="btn btn-md btn-danger" id="removeRecipientBtn">Remove recipient(s)</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</body>
<!-- JavaScript Bundle with Popper -->
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/js/bootstrap.bundle.min.js" integrity="sha384-ka7Sk0Gln4gmtz2MlQnikT1wXgYsOg+OMhuP+IlRH9sENBO0LRn5q+8nbTov4+1p" crossorigin="anonymous"></script>
<script src="https://code.jquery.com/jquery-3.6.0.min.js" integrity="sha256-/xUj+3OJU5yExlq6GSYGSHk7tPXikynS7ogEvDej/m4=" crossorigin="anonymous"></script>
<script src="https://code.jquery.com/ui/1.13.1/jquery-ui.min.js" integrity="sha256-eTyxS0rkjpLEo16uXTS0uVCS4815lc40K2iVpWDvdSY=" crossorigin="anonymous"></script>
<script src="main.js"></script>
</html>
<script>
    jQuery(function(){
        var sendMsgDiv = jQuery("#sendMessageDiv");
        fetch_sms();
        fetch_inbox();
        fetch_schedule();
        check_sms_balance(); 
    });

    const recipientsArray = []; //this rray holds all the rcipienmts to the message
   

    //when there is a key up  event of the search input
    jQuery("#searchDiv").find("input[type='search']").keyup(function(){
        var recipientName = jQuery(this).val();
        if(recipientName!=""){
            jQuery.ajax({
                url:"/school/message_admin/search-recipient.php",
                method:"POST",
                data: {NAME:recipientName},
                success:function(data){
                    jQuery("#mainMsgContentDiv table tbody").html(data);
                },
                error:function(){
                    alert("There has been a problem trying to send msg to the executing file");
                }
            });
        };
    });

    //when the cancel button has been clicked
    jQuery('#filterDiv form').find(".cancelFilterBtn").click(function(){
        fetch_sms();
        jQuery("#filterDiv").removeClass("d-block").addClass("d-none");
    });

    //when the filter button form has submitted
    jQuery('#filterDiv form').submit(function(e){
        e.preventDefault();
        jQuery('#filterDiv form').find("button[type='submit']").prop("disabled","disabled");
        jQuery('#filterDiv form').find("button[type='submit'] .span").addClass('active');
        var advancedFilter = jQuery(this).serialize();
        jQuery.ajax({
            url:"/school/message_admin/advanced-filter-messages.php",
            method:"POST",
            data: advancedFilter,
            success:function(data){
                jQuery('#filterDiv form').find("button[type='submit']").removeAttr("disabled");
                jQuery("#mainMsgContentDiv table tbody").html(data);
                jQuery('#filterDiv form').find("button[type='submit'] .span").removeClass('active');
            },
            error:function(){
                alert("There has been a problem trying to send msg to the executing file");
            }
        });
    });

    //when the radio button is clicked
    jQuery("#filterDiv").find("input[type='radio']").click(function(){
        if(jQuery(this).attr("id") == "date"){
            jQuery("#filterDiv #dateDiv").find("input[type='date']").removeAttr("disabled");
            jQuery("#filterDiv #dateRangeDiv").find("input[type='date']").attr("disabled","disabled");
        }else if(jQuery(this).attr("id") == "range"){
            jQuery("#filterDiv #dateRangeDiv").find("input[type='date']").removeAttr("disabled");
            jQuery("#filterDiv #dateDiv").find("input[type='date']").attr("disabled","disabled");
        };
     });

    //when the filer button has been clicked
    jQuery("#searchDiv").find(".filter").click(function(){
        jQuery("#filterDiv").removeClass("d-none").addClass("d-block");
    });

    //when the filter div close button has been clicked
    jQuery('#filterDiv').find(".btn-close").click(function(){
        jQuery("#filterDiv").removeClass("d-block").addClass("d-none");
    });

    //when the add recipient form has been submitted
    jQuery("#recipientDiv").submit(function(e){
        e.preventDefault();
        var recipient_name = jQuery("#recipientDiv form").find("input[name='name']").val();
        var recipient_phone = jQuery("#recipientDiv form").find("input[name='phone']").val();
        var new_array = {
            "Recipient_name": recipient_name,
            "Phone_Number" : recipient_phone
        };
        recipientsArray.push(new_array); //appends the new array to the previous array everytime
        jQuery("#recipientDiv #recipientList ul").append("<li style='color:white'>"+recipient_name+" - "+recipient_phone+"</li>");
        jQuery("#recipientDiv form").trigger("reset");
    });

    //when the send button on the left has been clicked
    jQuery(".send-contacts-btn").click(function(){
        jQuery("#sendMessageDiv").addClass("d-block").removeClass("d-none");
        jQuery("#recipientDiv").addClass("d-block").removeClass("d-none");
        jQuery("#sendMessageDiv").find("textarea").focus();
        var recipient_name = jQuery(this).attr("data-recipientName");
        var recipient_phone = jQuery(this).attr("id");
        var new_array = {
            "Recipient_name": recipient_name,
            "Phone_Number" : recipient_phone
        };
        recipientsArray.push(new_array); //appends the new array to the previous array everytime
        jQuery("#recipientDiv #recipientList ul").append("<li style='color:white'>"+recipient_name+" - "+recipient_phone+"</li>");
        return;
    });

    //removing recipients from array
    jQuery('#recipientDiv #removeRecipientBtn').click(function(){
        jQuery("#recipientDiv #recipientList ul").html(""); 
        //make the array holding the recipients null
        recipientsArray={};
    });

    //when the close button has been clicked for the recipient div
    jQuery("#recipientDiv").find(".btn-close").click(function(){
        jQuery("#recipientDiv").removeClass("d-block").addClass("d-none");
    });

    //when the displayCOntacts Btn has been clicked
    jQuery("#sendMessageDiv").find("#displayRecipientsBtn").click(function(){
        jQuery("#recipientDiv").removeClass("d-none").addClass("d-block");
    });

    //when the schedule mesage btn has been clicked
    jQuery("#messageDIv #scheduleMsgBtn").click(function(e){
        e.preventDefault();
        jQuery("#scheduleSendDiv").toggleClass("d-none");        
    });

    //when the close button has been clicked for the schedule messages
    jQuery('#scheduleSendDiv').find(".btn-close").click(function(){
        jQuery("#scheduleSendDiv").addClass("d-none");
    });

    //when the submit schedule button has been clicked 
    jQuery('#scheduleSendDiv').find("#calendarForm").submit(function(e){
        e.preventDefault();
        if(recipientsArray.length!=0){
            var recipientString = JSON.stringify(recipientsArray);
            var message = jQuery("#sendMessageDiv form").find("textarea[name='msg']").val();
            var subject = jQuery("#sendMessageDiv form").find("input[name='subject']").val(); 
            var schedule = jQuery("#scheduleSendDiv form").find("input[type='datetime-local']").val();
            //check if the message and subject inputs are empty
            if(message != "" || subject != ""){
                var msgArray =  {
                    "Message" : message,
                    "Subject" : subject
                }; 
                jQuery.ajax({
                    url:"/school/message_admin/schedule-messages.php",
                    method:"POST",
                    data: {MSG_DATA:msgArray, CONTACTS: recipientString, SCHEDULE: schedule},
                    success:function(data){
                    jQuery("#scheduleSendDiv #notificationsDiv").html(data);
                    },
                    error:function(){
                        alert("There has been a problem trying to send msg to the executing file");
                    }
                });
            }else{
                alert("Please provide a message and a subject to proceed");
            };
        }else{
            alert("Make sure to provide recipients for this message");
        };
    });

    //when the submit mesage has been clicked
    jQuery("#sendMessageDiv").find("form").submit(function(e){
        e.preventDefault();
        var msgArray =  {
            "Message" : jQuery("#sendMessageDiv form").find("textarea[name='msg']").val(),
            "Subject" : jQuery("#sendMessageDiv form").find("input[name='subject']").val()
        };
        //check if the recipient array is empty or not
        if(recipientsArray.length!=0){
            jQuery.ajax({
                url:"/school/message_admin/send-messages.php",
                method:"POST",
                data: {MSG_DATA:msgArray, RECIPIENT_DATA:recipientsArray},
                success:function(data){
                fetch_sms();
                jQuery("#sendMessageDiv #notificationDiv").html(data);
                },
                error:function(){
                    alert("There has been a problem trying to send msg to the executing file");
                }
            });
            return;
        }else{
            alert("Make sure to provide recipients for this message");
            return;
        };
    });

    //when the close button has been clicked to close the send Mesasge Div
    jQuery("#sendMessageDiv").find(".btn-close").click(function(){
        jQuery("#sendMessageDiv").removeClass("d-block").addClass("d-none");
    });

    //when the compose message button has been clicked
    jQuery('#compose-msg-btn').click(function(){
        jQuery("#sendMessageDiv").addClass("d-block").removeClass("d-none");
        jQuery("#sendMessageDiv").find("textarea").focus();
    });

    jQuery("ul#menu li").click(function(){
       jQuery(this).addClass("active").siblings().removeClass("active");
       var list_id = jQuery(this).attr("id");//the id of the list item
       jQuery("#mainMsgContentDiv>#leftMenuContentDiv.active").removeClass("active");
       jQuery("#mainMsgContentDiv>#leftMenuContentDiv[data-list_id='"+list_id+"']").addClass("active");
    });

    function fetch_schedule(){
        jQuery.ajax({
            url:'/school/message_admin/fetch_schedule.php',
            method:'GET',
            success:function(data){
              jQuery("#scheduleMainDiv table tbody").html(data);
              //when a table row has been clicked
              jQuery("#scheduleMainDiv").find("table tbody tr").click(function(){
                //get the id for the message we have retrieved fromo DB
                var messageID = jQuery(this).find("input[type='hidden']").val();
                jQuery.ajax({
                    url:'/school/message_admin/fetch-inbox-info.php',
                    method:'POST',
                    data:{MESSAGE_ID:messageID},
                    success:function(data){
                        
                    },            
                    error:function(){
                        alert("There was a problem trying fetch message info");
                    }
                });
                return;   
              });
            },            
            error:function(){
                alert("There was a problem trying fetch messages");
            }
        });
    }

    function fetch_inbox(){
        jQuery.ajax({
            url:'/school/message_admin/fetch_inbox.php',
            method:'GET',
            success:function(data){
              jQuery("#inboxMainDiv table tbody").html(data);
              //when a table row has been clicked
              jQuery("#inboxMainDiv").find("table tbody tr").click(function(){
                //get the id for the message we have retrieved fromo DB
                var messageID = jQuery(this).find("input[type='hidden']").val();
                jQuery.ajax({
                    url:'/school/message_admin/fetch-inbox-info.php',
                    method:'POST',
                    data:{MESSAGE_ID:messageID},
                    success:function(data){
                        var msg_data = JSON.parse(atob(data));
                        jQuery("#inboxMainDiv #exampleModal").find(".modal-body #sender").html("FROM: "+msg_data.SENDER);
                        jQuery("#inboxMainDiv #exampleModal").find(".modal-body #phone").html("PHONE NUMBER: "+msg_data.PHONE_NUMBER);
                        jQuery("#inboxMainDiv #exampleModal").find(".modal-body #message").html(msg_data.MESSAGE);
                        jQuery("#inboxMainDiv #exampleModal").find(".modal-footer button").attr("id",msg_data.ID);
                        jQuery("#inboxMainDiv #exampleModal").modal("show");

                        //when the delete button has been clicked
                        jQuery("#inboxMainDiv #exampleModal").find(".modal-footer button").click(function(){
                            if(confirm("Proceed to DELETE mesage?")){
                                delete_inbox_message(jQuery(this).attr("id"));
                            }                               
                        });
                        return;
                    },            
                    error:function(){
                        alert("There was a problem trying fetch message info");
                    }
                });
                return;   
              });
            },            
            error:function(){
                alert("There was a problem trying fetch messages");
            }
        });
    }

    function fetch_sms(){
        jQuery.ajax({
            url:'/school/message_admin/fetch_messages.php',
            method:'GET',
            success:function(data){
              jQuery("#mainMsgContentDiv table tbody").html(data);
               //when a table row has been clicked
                jQuery("#messageMainDiv").find("table tbody tr").click(function(){
                    //get the id for the message we have retrieved fromo DB
                    var messageID = jQuery(this).find("input[type='hidden']").val();
                    //send the message ID and get complete message data
                    jQuery.ajax({
                        url:'/school/message_admin/fetch-message-info.php',
                        method:'POST',
                        data:{MESSAGE_ID:messageID},
                        success:function(data){
                            var msg_data = JSON.parse(atob(data)); 
                            jQuery("#messageMainDiv #exampleModal").find(".modal-body #recipient").html("TO: "+msg_data.RECIPIENT);
                            jQuery("#messageMainDiv #exampleModal").find(".modal-body #phone").html("PHONE NUMBER: "+msg_data.PHONE_NUMBER);
                            jQuery("#messageMainDiv #exampleModal").find(".modal-body #message").html(msg_data.MESSAGE);
                            jQuery("#messageMainDiv #exampleModal").find(".modal-footer button").attr("id",msg_data.ID);
                            jQuery("#messageMainDiv #exampleModal").modal("show");

                            //when the delete button has been clicked
                            jQuery("#messageMainDiv #exampleModal").find(".modal-footer button").click(function(){
                                if(confirm("Proceed to DELETE mesage?")){
                                  delete_outbox_message(jQuery(this).attr("id"));
                                }                               
                            });
                        },            
                        error:function(){
                            alert("There was a problem trying fetch message info");
                        }
                    });     
                return;           
                });
            },            
            error:function(){
                alert("There was a problem trying fetch messages");
            }
        });
    }

    function delete_inbox_message(msgID){
        jQuery.ajax({
            url:'/school/message_admin/del-inbox-msg.php',
            method:'post',
            data:{MSG:btoa(msgID)},
            success:function(data){
                fetch_inbox();  
                jQuery("#inboxMainDiv #exampleModal").find(".modal-body #notificationsDiv").html(data); 
                setTimeout(() => {
                  jQuery("#inboxMainDiv #exampleModal").find(".modal-body #notificationsDiv").html("");   
                }, 2000);                                   
            },            
            error:function(){
                alert("There was a problem trying to send sms balance enquiry");
            }
        });
    }

    function delete_outbox_message(msgID){
        jQuery.ajax({
            url:'/school/message_admin/del-outbox-msg.php',
            method:'post',
            data:{MSG:btoa(msgID)},
            success:function(data){
                fetch_sms();  
                jQuery("#messageMainDiv #exampleModal").find(".modal-body #notificationsDiv").html(data); 
                setTimeout(() => {
                  jQuery("#messageMainDiv #exampleModal").find(".modal-body #notificationsDiv").html("");   
                }, 2000);                                   
            },            
            error:function(){
                alert("There was a problem trying to send sms balance enquiry");
            }
        });
    }

    function check_sms_balance(){
        var balance_request = "";
        // jQuery.ajax({
        //     url:'/school/message_admin/sms-balance.php',
        //     method:'post',
        //     data:{balance_request:balance_request},
        //     success:function(data){
        //         var dataObject  = JSON.parse(data);//converting string to json object
        //         //jQuery(".sms_counter").html(dataObject['balance']);
        //         console.log(data);
        //     },            
        //     error:function(){
        //         alert("There was a problem trying to send sms balance enquiry");
        //     }
        // }); 
}
</script>

<style>
    .spinner-border.active{
        display:inline-block;
    }
    .spinner-border{
        display:none;
    }
    #filterDiv{
        position:absolute;
        left: 0px;
        top: 10%;
        border: none;
        width: 26%;
        height: 87vh;
        color:cyan;
        overflow:auto;
    }
    #scheduleSendDiv{
        position:absolute;
        width: 40%;
        left: 30%;
        top: 30%;
        padding: 20px;
        border: 1px solid red;
    }
    #recipientDiv{
        padding: 25px;
        width: 40%;
        position:absolute;
        right: 9%;
        min-height: 30px;
        top: 10%;
        border: 1px solid goldenrod;
        min-height: 10%;
    }
    #sendMessageDiv{
        padding: 20px;
        width: 50%;
        position:absolute;
        right: 1%;
        bottom: 1%;
        height: 90%;
        overflow:auto;
    }
   #mainMsgContentDiv>#leftMenuContentDiv.active{
       display: block;
   }
   #mainMsgContentDiv>#leftMenuContentDiv{
       display: none;
   }
    #mainMsgContentDiv{
        background-color:#696969;
        width: 100%;
        height: 88vh;
        padding: 10px;
        overflow:auto;
        -ms-overflow-style: none;  /* IE and Edge */
        scrollbar-width: none;  /* Firefox */
    }
    #mainMsgContentDiv::-webkit-scrollbar {
        display: none;
    }
    #contactsDiv ul{
        padding: 0px;
        color:#C0C0C0;
        list-style:none;
        padding: 5px 10px 5px 10px;
        line-height: 30px;
        max-height: 36.5vh;
        overflow:auto;
    }
    #contactsDiv ul li:hover{
       color:white;
       cursor: pointer;
    }
    #contactsDiv ul li{
        font-size: 14px;
    }

    ul#menu{
        padding: 0px;
        margin-top: 5px;
        height: 30vh;
        overflow: auto;
    }
    ul#menu li.active{
        background-color:#696969;
        border-top-right-radius: 20px;
        border-bottom-right-radius: 20px; 
    }
    ul#menu li{
        color:white;
        list-style:none;
        padding: 5px 10px 5px 10px;
        line-height: 30px;
    }
    ul#menu li:hover{
        background-color:#808080;
        border-top-right-radius: 20px;
        border-bottom-right-radius: 20px; 
    }
    #searchDiv{
        padding: 5px;
        background: #696969;
        border-radius: 10px;
    }
    #searchDiv button{
        padding: 0px 25px 0px 25px;
        color:white;
    }
    #searchDiv input[type='search']{
        background:none;
        outline:none;
        color: white;
        border: none;
    }
    table tbody tr{
        cursor: pointer;       
    }
</style>