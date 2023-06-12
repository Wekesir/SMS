<?php
//db connection
require_once $_SERVER['DOCUMENT_ROOT'].'/school/core/init.php';

//form data that has been received from the form
if(isset($_POST)):
    $amount       = trim(clean(((isset($_POST['amount']) ? $_POST['amount'] : 0))));
    $food         = trim(clean(((isset($_POST['food']) ? $_POST['food'] : ''))));
    $regno        = trim(clean(((isset($_POST['regno']) ? $_POST['regno'] : ''))));
    $payment      = trim(clean(((isset($_POST['paymentmode']) ? $_POST['paymentmode'] : ''))));  
    $chequenumber = strtoupper(trim(clean(((isset($_POST['chequenumber']) ? $_POST['chequenumber'] : ''))))); 
    $bankname     = trim(clean(((isset($_POST['bankname']) ? $_POST['bankname'] : '')))); 
    $mpesacode    = strtoupper(trim(clean(((isset($_POST['mpesacode']) ?  $_POST['mpesacode'] : ''))))); 
    $date         = date('Y-m-d');  

    if($payment=='BANK'){                        
       $mode = $payment.'-'.$bankname.'('.$chequenumber.')';
    }else if($payment=='MPESA'){
       $mode = $payment.'-'.$mpesacode;
    }else{
       $mode=$payment; 
    }

    $query      = $db->query("SELECT `id` FROM students WHERE `registration_number`='$regno' AND `deleted`=0 AND `accomplished`=0");
    $queryData  = mysqli_fetch_array($query);
    $student_id = (int)$queryData['id'];

     //check if the registration number provided exists
     if(mysqli_num_rows($query)==0){
        $errors[].='<b>Fatal Error! </b>You are trying to make payment for an unknown UPI Number or is no longer a student in the school';
    }
    
    $stdAccountQuery = mysqli_fetch_array($db->query("SELECT * FROM fees_account WHERE id='$student_id'"));//fetched the amount of money the student has in the school account
    $availableAmount = $stdAccountQuery['amount'];//currentt amount in the students school account
    $newBalance      = ($availableAmount + $amount);//new Balance is the balance from school wallet plus the paid amount

    $description    = "SCHOOL FEES.";

    $output_arr = array();

    if(!empty($errors)){      
        $output_arr = array(
            "status" => 0,
            "output" => $errors
        ); 
    }else{ 
        $db->query("INSERT INTO `fees_invoices` (`student_id`,`amount`,`mode`,date)
                    VALUES('$student_id','$amount','$mode','$date')"); 
        $_SESSION["PAYMENT_ID"] = $db->insert_id;
        $db->query("INSERT INTO `income` (`description`,`amount`,`date`)
                    VALUES ('{$description}','{$amount}','{$todayDate}')");
        $db->query("UPDATE `fees_account` 
                    SET `amount`='$newBalance' 
                    WHERE `id`='$student_id'");
        $messages[].='<b>Success! </b>Fees paid successfully.';
        if(!empty($messages)){        
            $output_arr = array(
                "status" => 1,
                "output" => $messages
            );
        }       
    }
    echo json_encode($output_arr);
endif;