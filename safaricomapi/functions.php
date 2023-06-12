<?php

function simulateC2BTransaction(){
        $amount='5000'; $mobile='254712345678';
        $url = 'https://sandbox.safaricom.co.ke/mpesa/c2b/v1/simulate';
  
        $curl = curl_init();
        curl_setopt($curl, CURLOPT_URL, $url);
        curl_setopt($curl, CURLOPT_HTTPHEADER, array('Content-Type:application/json','Authorization:Bearer '.generateToken().'')); //setting custom header
    
    
        $curl_post_data = array(
                //Fill in the request parameters with valid values
            'ShortCode' => '000000',
            'CommandID' => 'CustomerPayBillOnline',
            'Amount' => $amount,
            'Msisdn' => $mobile,
            'BillRefNumber' => 'testing'
        );
    
        $data_string = json_encode($curl_post_data);
    
        curl_setopt($curl, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($curl, CURLOPT_POST, true);
        curl_setopt($curl, CURLOPT_POSTFIELDS, $data_string);
    
        $curl_response = curl_exec($curl);
        //print_r($curl_response);
    
        return $curl_response;
}


function registerURL(){
      
    $url = 'https://sandbox.safaricom.co.ke/mpesa/c2b/v1/registerurl';
    
    $curl = curl_init();
    curl_setopt($curl, CURLOPT_URL, $url);
    curl_setopt($curl, CURLOPT_HTTPHEADER, array('Content-Type:application/json','Authorization:Bearer '. generateToken().'')); //setting custom header
    
    
    $curl_post_data = array(
        //Fill in the request parameters with valid values
        'ShortCode' => '000000',
        'ResponseType' => 'Transaction Completed',
        'ConfirmationURL' => 'http://3b8dca8a.ngrok.io/school/safaricomapi/confirmation/',
        'ValidationURL' => 'http://3b8dca8a.ngrok.io/school/safaricomapi/validation/'
    );
    
    $data_string = json_encode($curl_post_data);
    
    curl_setopt($curl, CURLOPT_RETURNTRANSFER, true);
    curl_setopt($curl, CURLOPT_POST, true);
    curl_setopt($curl, CURLOPT_POSTFIELDS, $data_string);
    
    $curl_response = curl_exec($curl);
    
    return $curl_response;
  
}

function generateToken(){
  
  $url = 'https://sandbox.safaricom.co.ke/oauth/v1/generate?grant_type=client_credentials';
  
  $curl = curl_init();
  curl_setopt($curl, CURLOPT_URL, $url);
  $credentials = base64_encode('xxxxxxxxxxxxxxxxxx');
  curl_setopt($curl, CURLOPT_HTTPHEADER, array('Authorization: Basic '.$credentials)); //setting a custom header
  curl_setopt($curl, CURLOPT_RETURNTRANSFER,true);
  curl_setopt($curl, CURLOPT_SSL_VERIFYPEER, false);
  
  $curl_response = curl_exec($curl);
  
  $json_decode = json_decode($curl_response);

  $accessToken = $json_decode->access_token;

  return $accessToken;  
  
}

?>