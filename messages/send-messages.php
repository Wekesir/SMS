<?php
require_once $_SERVER['DOCUMENT_ROOT'].'/school/core/init.php';

//when the request comes from the balances page
if(isset($_POST['SEND_FEE_BALANCES'])):
    $level    =   trim(clean($_POST['SEND_FEE_BALANCES']['level']));
    $msg      =   trim(clean($_POST['SEND_FEE_BALANCES']['message']));
    $minamt   =   trim(clean($_POST['SEND_FEE_BALANCES']['minamt']));
    $maxamt   =   trim(clean($_POST['SEND_FEE_BALANCES']['maxamt']));

    $qHead = "SELECT students.`id`, students.`registration_number`, students.`parname`, students.`parname2`, students.`contacts`, fees_account.amount
              FROM `students` INNER JOIN `fees_account`ON students.id=fees_account.student_id";

    $qCondition = " ";

    if($level != 0):
        if(empty($minamt)):
            $qCondition = " WHERE students.level='{$level}' AND students.deleted=0 AND students.accomplished=0 AND fees_account.amount < 0 ";
        else:
            $minamt = -$minamt;
            $maxamt = -$maxamt;
            $qCondition = " WHERE students.level='{$level}' AND students.deleted=0 AND students.accomplished=0 AND fees_account.amount BETWEEN '{$maxamt}' AND '{$minamt}' ";
        endif;        
    else:
        if(empty($minamt)):
            $qCondition = " AND students.deleted=0 AND students.accomplished=0 AND fees_account.amount < 0 ";
        else:
            $minamt = -$minamt;
            $maxamt = -$maxamt;
            $qCondition = " AND students.deleted=0 AND students.accomplished=0 AND fees_account.amount BETWEEN '{$maxamt}' AND '{$minamt}' ";
        endif; 
    endif;

    $query = $qHead.$qCondition; //complete query
    $feesQuery = $db->query($query);

    if(mysqli_num_rows($feesQuery) > 0) : //when some data has been found from the DB
        while($queryData = mysqli_fetch_array($feesQuery)) :
            $contactsArray = explode(",", $queryData['contacts']); //gets the contacts of the parents
            $parentArray = array($queryData['parname'], $queryData['parname2']);// holds the array to the names of the guardians
            $message = $msg. ". Amount Due: ".abs($queryData['amount'])." Regards, ". $configurationData['school_name'];
            //loop through the phone number array length
            for($x=0; $x < count($contactsArray); $x++):
                sendSms(format_phone_number($contactsArray[$x]), $message, (empty($parentArray[$x]) ? "Unknown": $parentArray[$x]));  
            endfor;
        endwhile;
    endif;
    $messages[].='<b>Success! </b>Message(s) sent to recipient(s). Check outbox.';
    echo displayMessages($messages);

    $db->close();
endif;

if(isset($_POST['message']))://if the message has been posted to this page
    if(!isset($_SESSION['CONTACT_INFO']) || empty($_SESSION['CONTACT_INFO']))://if no contacts have been provided
        $info[].='<b>Oops! </b>Seems like you have not provided any recipients.'; 
        displayInfo($info);
    else:
        $contactsArray = json_decode($_SESSION['CONTACT_INFO'],true);//recepients of the message
        $message = trim(clean($_POST['message']." .Regards, ". $configurationData['school_name']));//message
        foreach($contactsArray as $recipient):
            sendSms(format_phone_number($recipient['Number']), $message, $recipient['Name']);        
        endforeach;
        $messages[].='<b>Success! </b>Message(s) sent to recipient(s). Check outbox.';
        echo displayMessages($messages);
    endif;  
    $db->close();   
endif;


?>