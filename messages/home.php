<div id="sendMessageDiv" class="align-self-center mr-auto ml-auto">  
    <div class="form-group radioDiv">
        <label for="" class="float-right"><h6> <span class="badge label-pill badge-info sms_counter"></span> SMS Remaining.</h6></label>
        <div class="radio ml-auto">
        <label for="gender" class="radio-inline"><input type="radio"  name="gender" value="new" <?='checked';?>> New Number |</label>
        <label for="gender" class="radio-inline"><input type="radio"  name="gender" value="contacts"> Contacts  |</label>
        <label for="gender" class="radio-inline"><input type="radio"  name="gender" value="group"> Contact Groups |</label>
        <label for="gender" class="radio-inline"><input type="radio"  name="gender" value="upload"> Upload Contacts</label>
        </div>
        <hr>
    </div>            
    <div id="addContacts" class="active">
        <label for=""><b>RECIPIENT DETAILS</b></label>
        <div class="input-group mb-1">       
        <input type="text" id="recipient_name" aria-label="First name" class="form-control mr-1" placeholder="NAME">
        <input type="tel" aria-label="Last name" class="form-control ml-1" minlength=10 maxlength=10 placeholder="PHONE e.g 0701234567">
        <div class="input-group-append">
            <button class="btn btn-primary ml-2 addPhoneNumberBtn" type="button">Add Recipient</button>
        </div>
        </div>
    </div>

    <div id="getContacsDiv">
        <?php
            $count=1; 
            $contactsQuery = $db->query("SELECT `id`,`name`,`phone` FROM `contacts`");
            if(mysqli_num_rows($contactsQuery)==0):
                $info[].='<b>Oops! </b>There are no contacts added in the system. Go to Contacts and add contacts.';
                displayinfo($info);
            endif;
        ?>
        <table class="table table-sm table-striped table-bordered">
            <thead class="thead-dark">
                <th>#</th>
                <th>NAME</th>
                <th>NUMBER</th>
                <th></th>
            </thead>
            <tbody>               
                <?php while($contactData = mysqli_fetch_array($contactsQuery)) :?>
                <tr>
                    <td><?=$count?></td>
                    <td><?=$contactData['name'];?></td>
                    <td><?=$contactData['phone'];?></td>
                    <td><input type="radio"  name="addContact" value="<?=$contactData['name']?>" data-phoneNumber="<?=$contactData['phone']?>"> Select </td>
                </tr>
                <?php $count++; endwhile;?>              
            </tbody>
        </table>
    </div>
    <div id="getContactGroup">
        <table class="table-sm table table-striped table-bordered">
            <thead class="thead-light">
                <th>#</th>
                <th>CONTACT GROUP</th>
                <th>ADD</th>
            </thead>
            <tbody>
                <?php 
                $count=1;
                $groupQuery = $db->query("SELECT * FROM `grade`");
                if(mysqli_num_rows($groupQuery)==0):
                    $info[].='<b>Oops! </b>There are no contacts added in the system. Go to Contacts and add contacts.';
                    displayinfo($info);
                endif;
                while($groupData = mysqli_fetch_array($groupQuery)) : ?>
                    <tr>
                        <td><?=$count;?></td>
                        <td><?=$groupData['grade'];?></td>
                        <td><button class="btn btn-sm btn-default text-primary addGroupBtn"title="Add contacts from this group." data-groupId="<?=$groupData['id'];?>">Add contacts.</button></td>
                    </tr>
                <?php $count++; endwhile;?>
            </tbody>
        </table>
    </div>
    <div id="uploadContacts">
        <?php
            if(isset($_POST['submitUpload'])):
                //check the selected file format
                $file=explode('.',$_FILES['recipients']['name']);
                    if(end($file)!='csv'){
                        $errors[].='<b>Error!</b> Please select the correct file format.(.CSV)';
                    }
                    //check for errors
                    if(!empty($errors)){//check if there are errors
                        displayErrors($errors);//fucntion for displaying errors
                    }else{ 
                        $fileTemp = $_FILES['recipients']['tmp_name'];
                        $handle   = fopen($fileTemp,'r');
                        $rowCount = 0;
                        while(($data = fgetcsv($handle,0,',')) !==false):
                            if($rowCount!=0){                               
                                $recipient       = ((!empty($data[0]))?strtoupper($data[0]):'Unknown');
                                $phoneNumber     = '0'.$data[1];                                 
                                    $info[] = array(
                                        'Name' => $recipient,
                                        'Number'=> $phoneNumber
                                    );
                                    $_SESSION['CONTACT_INFO']=json_encode($info);//assign thr session value of the phone number 
                            }                
                            $rowCount++;
                        endwhile;        
                        fclose(fopen($_FILES['recipients']['tmp_name'],"r"));        
                        $messages[].='<b>Success! </b>Contacts hasve been added. Refresh page to view';
                        displayMessages($messages);                                          
                    }   
            endif; 
        ?>
        <form action="<?=$_SERVER['PHP_SELF']?>" method="post" enctype="multipart/form-data">
            <label for=""><b>Select Document(.csv)</b> <a href="/school/documents/school/sms_recipients.csv" class="float-right">Download Template.</a></label>
            <div class="input-group mb-3">        
            <input type="file" class="form-control" name="recipients" aria-label="Recipient's username" aria-describedby="basic-addon2" required=required>
            <div class="input-group-append">
                <input type="submit" class="btn btn-primary ml-3" name="submitUpload" value="Upload Recipients">
            </div>
            </div> 
        </form>
    </div>
    <?php if(isset($_SESSION['CONTACT_INFO'])) :
         $arrayDecode = json_decode($_SESSION['CONTACT_INFO'],true);
         $count = 1;    
    ?>
    <div id="addedContacts">        
        <h6 class="text-success">(<?=count($arrayDecode)?>) RECIPIENT(S). <label class="float-right text-danger removeContacts" title="Click to remove all contacts">Remove All</label></h6>    
        <?php            
            foreach($arrayDecode as $contact): ?>
                <label class="text-primary" title="<?=$contact['Name']?>">
                    <b><?=$count?></b><u><?=' Name: '.cutstring($contact['Name'], 13, $end='...').' Phone: '.$contact['Number']?> </u>
                    <button type="button" class="close ml-2 text-danger removeContactBtn" aria-label="Close" data-arrayCount="<?=$count?>" title="Remove this number.">
                        <span aria-hidden="true">&times;</span>
                    </button>
                 </label>
            <?php $count++; endforeach;
        ?>
    </div> 
    <?php endif; ?>
    <div id="body">
        <div id="notificationDiv"></div>
        <form action="#" method="post" id="messageForm">
            <div class="form-group">
                <label for=""><b>MESSAGE:</b></label>
                <textarea name="message" id="message" class="form-control" rows="5" required=required placeholder="Type your message..."></textarea>
            </div>
            <div class="form-group">
                <button type="submit" class="btn btn-success btn-sm">
                    <span class="spinner-border spinner-border-sm" role="status" aria-hidden="true"></span>
                    Send Message(s)
                </button>
                <!-- <input type="submit" value="" class="btn btn-success btn-sm"> -->
            </div>
        </form>
    </div>
</div>

<script>
var radioBtnValue = "";

jQuery(function(){
    check_sms_balance();//check for the sms balance
});

jQuery(".removeContacts").click(function(){
    var removeContacts = "";
    jQuery.ajax({
        url:'/school/messages/helper.php',
        method:'post',
        data:{removeContacts:removeContacts},
        success:function(){
          location.reload(true);
        },            
        error:function(){
            alert("There was a problem trying to send message");
        }
    });
});

jQuery("#messageForm").submit(function(e){
    e.preventDefault(); 
    jQuery(".spinner-border").addClass("active");//makes the spinner visible
    var message = jQuery(this).find('#message').val(); 
    jQuery.ajax({
        url:'/school/messages/send-messages.php',
        method:'post',
        data:{message:message},
        success:function(data){
            jQuery(".spinner-border").removeClass("active");//makes the spinner invisible
            jQuery("#notificationDiv").html(data);
            check_sms_balance();//function for checking the sms balance
        },            
        error:function(){
            alert("There was a problem trying to send message");
        }
    }); 
});

function check_sms_balance(){
    var balance_request = "";
    jQuery.ajax({
        url:'/school/messages/sms-balance.php',
        method:'post',
        data:{balance_request:balance_request},
        success:function(data){
            var dataObject  = JSON.parse(data);//converting string to json object
            jQuery(".sms_counter").html(dataObject['balance']);
        },            
        error:function(){
            alert("There was a problem trying to send message");
        }
    }); 
}

//when the add conatcts from group button has been clicked
jQuery(".addGroupBtn").click(function(){
    var groupId = jQuery(this).attr("data-groupId"); 
    jQuery.ajax({
        url:'/school/messages/helper.php',
        method:'post',
        data:{groupId:groupId},
        success:function(data){
            location.reload(true); 
        },            
        error:function(){
            alert("There was a problem trying to add number");
        }
    }); 
});

jQuery("input[name='addContact']").click(function(){//when  the select radio btn has been clicked
    var radioBtn = jQuery(this);
    var phoneNumber = jQuery(this).attr("data-phoneNumber");
    var name        = jQuery(this).val();
    var contactInfo = {//object holding the contact Information
        Name:name,
        Number:phoneNumber
    }
    jQuery.ajax({
        url:'/school/messages/helper.php',
        method:'post',
        data:{contactInfo:contactInfo},
        success:function(){
            //location.reload(true);
            radioBtn.hide();    
        },            
        error:function(){
            alert("There was a problem trying to add number");
        }
    }); 
});

jQuery(".removeContactBtn").click(function(){//when the remove btn has benn clickeon a button
    var removeNumberArrayIndex = jQuery(this).attr("data-arrayCount");
    jQuery.ajax({
        url:'/school/messages/helper.php',
        method:'post',
        data:{removeNumberArrayIndex:removeNumberArrayIndex},
        success:function(){
            location.reload();              
        },            
        error:function(){
            alert("There was a problem trying to add number");
        }
    });        
});

jQuery(".addPhoneNumberBtn").click(function(){//when the add phone number btn has been clicked
    var phoneNumber = $("input[type='tel']").val();
    var name        = $("#addContacts").find("#recipient_name").val();

    if(phoneNumber == "" || name == ""){//if a phone number or name has not been provided
        $("input[type='tel']").focus();//request focus for phone Number input
        alert("Provide a phone number to add.");
    }else{//else if we have a phone number
        jQuery.ajax({
            url:'/school/messages/helper.php',
            method:'post',
            data:{phoneNumber:btoa(phoneNumber),name:btoa(name)},
            success:function(){
               location.reload();
               $("input[type='tel']").val("").focus(); 
            },            
            error:function(){
                alert("There was a problem trying to add number");
            }
        });
    }
});

jQuery(".radioDiv input[type='radio']").click(function(){//when any of the radio butin have been clicked
    radioBtnValue = $(this).val();
    if(radioBtnValue == 'group'){
        $("#uploadContacts").removeClass("active");
        $("#addContacts").removeClass("active");
        $("#getContacsDiv").removeClass("active");
       $("#getContactGroup").addClass("active");
        return;
    }else if(radioBtnValue == 'contacts'){
        $("#uploadContacts").removeClass("active");
        $("#getContactGroup").removeClass("active");
        $("#addContacts").removeClass("active");
        $("#getContacsDiv").addClass("active");
        return;
    }else if(radioBtnValue=='upload'){//new
        $("#getContactGroup").removeClass("active");
        $("#addContacts").removeClass("active");
        $("#getContacsDiv").removeClass("active");
        $("#uploadContacts").addClass("active");
        return
    }else{
        $("#uploadContacts").removeClass("active");
        $("#getContactGroup").removeClass("active");
        $("#getContacsDiv").removeClass("active");
        $("#addContacts").addClass("active");
    }
});
</script>

<style>
#uploadContacts.active{
    display:block;
}
#uploadContacts{
    display:none
}
#getContactGroup.active{
    display:block;
    max-height: 63vh;
    overflow:auto; 
}
#getContactGroup{
    display:none;
}
#addContacts.active{
    display:block;
}
#addContacts{
    display:none;
}
#addedContacts.active{
    padding: 5px;
    border: 1px solid black;
    width: 100%;
    min-height: 17vh;
    overflow:auto;
    display:block;
}
#sendMessageDiv{
    padding: 20px;
    height: 78.5vh;
    width: 80%;
    border: 1px solid lightgrey;
    overflow:auto;
}
#getContacsDiv{
    display:none;
}
#getContacsDiv.active{
    display:block;
    max-height: 63vh;
    overflow:auto; 
}
</style>