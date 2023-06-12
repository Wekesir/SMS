<?php
require_once $_SERVER['DOCUMENT_ROOT'].'/school/core/init.php';

if(isset($_POST['balance_request'])){//checking the sms balance for this user
   echo check_account_balance();//display the return value of the function
}

function check_account_balance(){
    $api_key   = '601a8365e0a07';
    $username  = 'hillstop';
    $baseurl   = "http://bulksms.mobitechtechnologies.com/api/account_balance"; 

    $ch      = curl_init($baseurl);  
    $data    = array(
        'api_key'  => $api_key,
        'username' => $username
    );
    $payload =json_encode($data);
    curl_setopt($ch,CURLOPT_POSTFIELDS,$payload);
    curl_setopt($ch,CURLOPT_HTTPHEADER,array("Content-Type:application/json","Accept:application/json"));
    curl_setopt($ch,CURLOPT_RETURNTRANSFER,true);
    $result = curl_exec($ch);
    return $result;
}
?>