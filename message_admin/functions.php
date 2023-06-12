
<?php
    function mobitech_send_sms($phoneNumber, $message, $recipient){//function for sending sms from Mobitech Technologies
        $apiKey = "aba0e6437e398494d8f66c19196799f710b0050e6eba7c1ced942dbdf846a9d0";
        $senderName = "23107";
    
        $bodyRequest =array(
            "mobile" =>$phoneNumber,
            "response_type"=>"json",
            "sender_name"=>$senderName,
            "service_id"=>0,
            "message"=>$message
        );
        $payload = json_encode($bodyRequest);
        $curl = curl_init();
        curl_setopt_array($curl, array(
        CURLOPT_URL => 'https://api.mobitechtechnologies.com/sms/sendsms',
        CURLOPT_RETURNTRANSFER => true,
        CURLOPT_ENCODING => '',
        CURLOPT_MAXREDIRS => 10,
        CURLOPT_TIMEOUT => 15,
        CURLOPT_FOLLOWLOCATION => true,
        CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
        CURLOPT_CUSTOMREQUEST => 'POST',
        CURLOPT_POSTFIELDS =>$payload,
        CURLOPT_HTTPHEADER => array(
            'h_api_key: '.$apiKey,
            'Content-Type: application/json'
        ),
        ));
    
        $response = curl_exec($curl);
        curl_close($curl);
    
        global $db;
        $userId = (int)$_SESSION['user'];  
        $date = date('Y-m-d');

        $array = json_decode($response, true);       
        foreach($array as $x):
            $provider_message_id = $x['message_id'];//this is the message id from the bulk SMS provider
        endforeach;

        //insert into the db
        $db->query("INSERT INTO `message_outbox`(`message_id`, `phone_number`, `message`, `recipient`, `sender`, `date`) VALUES ('{$provider_message_id}','{$phoneNumber}','{$message}','{$recipient}','{$userId}','{$date}')");
     
    }

    function mobitech_validate_phone($phoneNumber){
        $api_key = "aba0e6437e398494d8f66c19196799f710b0050e6eba7c1ced942dbdf846a9d0";
        $curl = curl_init();
        curl_setopt_array($curl, array(
        CURLOPT_URL => 'https://api.mobitechtechnologies.com/sms/mobile?return=json&mobile='.$phoneNumber.'',
        CURLOPT_RETURNTRANSFER => true,
        CURLOPT_ENCODING => '',
        CURLOPT_MAXREDIRS => 10,
        CURLOPT_TIMEOUT => 15,
        CURLOPT_FOLLOWLOCATION => true,
        CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
        CURLOPT_CUSTOMREQUEST => 'GET',
        CURLOPT_HTTPHEADER => array(
            'h_api_key: '.$api_key.''
        ),
        ));

        $response = curl_exec($curl);

        curl_close($curl);
        echo $response;
    }
    function dispMessages($messages){
        $display='';
            foreach($messages as $message):
               $display = ' <div class="alert alert-success alert-dismissible fade show" role="alert">
                                <strong>Success! </strong>'.$message.'
                                <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                            </div>';
            endforeach;
        $display.='</ul>';
        echo $display;
    }
    function dispError($error){
        $display='';
            foreach($error as $er):
               $display = ' <div class="alert alert-danger alert-dismissible fade show" role="alert">
                                <strong>Error! </strong>'.$er.'
                                <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                            </div>';
            endforeach;
        $display.='</ul>';
        echo $display;
    }
?>