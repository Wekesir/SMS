<?php
require_once $_SERVER['DOCUMENT_ROOT'].'/school/core/init.php';

function highlightWords($text, $word){
    $text = preg_replace('#'. preg_quote($word) .'#i', '<span style="background-color: #F9F902;">\\0</span>', $text);
    return $text;
}

function getBrowser() { 
  $u_agent  = $_SERVER['HTTP_USER_AGENT'];
  $bname    = 'Unknown';
  $platform = 'Unknown';
  $version  = "";

  //First get the platform?
  if (preg_match('/linux/i', $u_agent)) {
    $platform = 'linux';
  }elseif (preg_match('/macintosh|mac os x/i', $u_agent)) {
    $platform = 'mac';
  }elseif (preg_match('/windows|win32/i', $u_agent)) {
    $platform = 'windows';
  }

  // Next get the name of the useragent yes seperately and for good reason
  if(preg_match('/MSIE/i',$u_agent) && !preg_match('/Opera/i',$u_agent)){
    $bname = 'Internet Explorer';
    $ub = "MSIE";
  }elseif(preg_match('/Firefox/i',$u_agent)){
    $bname = 'Mozilla Firefox';
    $ub = "Firefox";
  }elseif(preg_match('/OPR/i',$u_agent)){
    $bname = 'Opera';
    $ub = "Opera";
  }elseif(preg_match('/Chrome/i',$u_agent) && !preg_match('/Edge/i',$u_agent)){
    $bname = 'Google Chrome';
    $ub = "Chrome";
  }elseif(preg_match('/Safari/i',$u_agent) && !preg_match('/Edge/i',$u_agent)){
    $bname = 'Apple Safari';
    $ub = "Safari";
  }elseif(preg_match('/Netscape/i',$u_agent)){
    $bname = 'Netscape';
    $ub = "Netscape";
  }elseif(preg_match('/Edge/i',$u_agent)){
    $bname = 'Edge';
    $ub = "Edge";
  }elseif(preg_match('/Trident/i',$u_agent)){
    $bname = 'Internet Explorer';
    $ub = "MSIE";
  }

  // finally get the correct version number
  $known = array('Version', $ub, 'other');
  $pattern = '#(?<browser>' . join('|', $known) .
')[/ ]+(?<version>[0-9.|a-zA-Z.]*)#';
  if (!preg_match_all($pattern, $u_agent, $matches)) {
    // we have no matching number just continue
  }
  // see how many we have
  $i = count($matches['browser']);
  if ($i != 1) {
    //we will have two since we are not using 'other' argument yet
    //see if version is before or after the name
    if (strripos($u_agent,"Version") < strripos($u_agent,$ub)){
        $version= $matches['version'][0];
    }else {
        $version= $matches['version'][1];
    }
  }else {
    $version= $matches['version'][0];
  }

  // check if we have a number
  if ($version==null || $version=="") {$version="?";}

  return array(
    'userAgent' => $u_agent,
    'name'      => $bname,
    'version'   => $version,
    'platform'  => $platform,
    'pattern'   => $pattern
  );
}

function isMobileDevice() {//checks whether the browser in mobile
    return preg_match("/(android|avantgo|blackberry|bolt|boost|cricket|docomo
|fone|hiptop|mini|mobi|palm|phone|pie|tablet|up\.browser|up\.link|webos|wos)/i"
, $_SERVER["HTTP_USER_AGENT"]);
}

function decodeURl($input){
   return base64_decode(strtr($input, '-_,', '+/='));
}

function encodeURL($input){//base64 encryption
   return strtr(base64_encode($input), '+/=', '-_,');
}

function sendSms($phone,$message,$recipient){
    global $db;
    $api_key   = 'aba0e6437e398494d8f66c19196799f710b0050e6eba7c1ced942dbdf846a9d0';
    $username  = 'kenwekesir@gmail.com';
    $sender_id = '23107';//default sender id
    $baseurl   = "http://bulksms.mobitechtechnologies.com/api/sendsms"; 

    $ch      = curl_init($baseurl);  
    $data    = array(
        'api_key'  => $api_key,
        'username' => $username,
        'sender_id'=> $sender_id,
        'message'  => $message,
        'phone'    => $phone
    );
    $payload =json_encode($data);
    curl_setopt($ch,CURLOPT_POSTFIELDS,$payload);
    curl_setopt($ch,CURLOPT_HTTPHEADER,array("Content-Type:application/json","Accept:application/json"));
    curl_setopt($ch,CURLOPT_RETURNTRANSFER,true);
    $result = curl_exec($ch);
    $date   = date('Y-m-d H:i:s'); 
    $array  = json_decode($result, true);
    $userId = (int)$_SESSION['user'];       
    foreach($array as $x):
        $provider_message_id = $x['message_id'];//this is the message id from the bulk SMS provider
    endforeach;
     //insert into the db
     $db->query("INSERT INTO `message_outbox`(`message_id`, `phone_number`, `message`, `recipient`, `sender`, `date`) VALUES ('{$provider_message_id}','{$phone}','{$message}','{$recipient}','{$userId}','{$date}')");

}

function check_sms_delivery($message_id){    
    $baseurl = "http://bulksms.mobitechtechnologies.com/api/sms_delivery_status";
    $api_key   = '601a8365e0a07';
    $username  = 'hillstop';
    $ch      = curl_init($baseurl);  
    $data    = array(
        'api_key'  => $api_key,
        'username' => $username,
        'message_id'=> $message_id
    );
    $payload =json_encode($data);
    curl_setopt($ch,CURLOPT_POSTFIELDS,$payload);
    curl_setopt($ch,CURLOPT_HTTPHEADER,array("Content-Type:application/json","Accept:application/json"));
    curl_setopt($ch,CURLOPT_RETURNTRANSFER,true);
    $result = curl_exec($ch);
    $array = json_decode($result,true);
    return $array['network_name'];
}

function format_phone_number($number){
    $trimmed_Number = ltrim($number,$number[0]);//trim the first letter which in this case is zero
    $new_format = '254'.$trimmed_Number;//appends the 254 prefix to this number
    return $new_format;
}

function cutstring($text, $maxchar, $end='...') {
    if (strlen($text) > $maxchar || $text == '') {
        $words = preg_split('/\s/', $text);      
        $output = '';
        $i      = 0;
        while (1) {
            $length = strlen($output)+strlen($words[$i]);
            if ($length > $maxchar) {
                break;
            }else{
                $output .= " " . $words[$i];
                ++$i;
            }
        }
        $output .= $end;
    }else{
        $output = $text;
    }
    return $output;
}

/**
 * FUNCTION FOR ADDING AN EXPENSE TO DATABASE
 */
function addExpense($expenditure, $amount){
 global $db;
 $date   =   date('Y-m-d');
 $db->query("INSERT INTO `expenditure` (`expenditure`, `amount`, `date_entered`) VALUES ('$expenditure','$amount','$date')");
}

function getItemName($id){//function for getting the item name 
    global $db;
    $itemName = mysqli_fetch_array($db->query("SELECT `item` FROM `storeitems` WHERE `id`='$id'"));
    return $itemName['item']; 
}

function assignRegNumber($id,$abbrev){
    global $db;
    $year = date('Y');
    $registrationNumber = $abbrev.'/'.$id.'/'.$year;

    $db->query("UPDATE `students` SET `registration_number`='$registrationNumber' WHERE `id`='$id'");//updating Query
   
}
function displayinfo($info){
    $display='<ul>';
       foreach($info as $i):
           $display='<li class="text-info text-left alert alert-info alert-dismissible fade show" role="alert" style="list-style:none;">'.$i
           .'
           <button type="button" class="close" data-dismiss="alert" aria-label="Close">
            <span aria-hidden="true">&times;</span>
            </button>
           </li>';
       endforeach;
     $display.='</ul>';
     echo $display;
}

function displayErrors($errors){
    $display='<ul>';
       foreach($errors as $error):
           $display='<li class="text-danger text-left alert alert-danger alert-dismissible fade show" role="alert" style="list-style:none;">'.$error
           .'
           <button type="button" class="close" data-dismiss="alert" aria-label="Close">
            <span aria-hidden="true">&times;</span>
            </button>
           </li>';
       endforeach;
     $display.='</ul>';
     echo $display;
}

function displayMessages($messages){
    $display='<ul>';
        foreach($messages as $message):
            $display='<li class="text-success text-left alert alert-success alert-dismissible fade show" role="alert" style="list-style:none;">'.$message.'
                <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                <span aria-hidden="true">&times;</span>
                </button>
            </li>';
        endforeach;
    $display.='</ul>';
    echo $display;
}

function clean($unknown){
    return htmlentities($unknown, ENT_QUOTES, 'UTF-8');
}

function decimal($moneyDecimal){
    return number_format($moneyDecimal,2);
} 

function logged_in(){
    if(isset($_SESSION['user']) && $_SESSION['user'] > 0){
        return true;
    }return false;
}

function not_logged_in_page_redirect(){
    header('Location: http://'.$_SERVER['HTTP_HOST'].'/school/login.php', true, 303);
    exit;
}

function has_permission($permission='Admin'){
    global $db;
    $id=$_SESSION['user'];
    $query=$db->query("SELECT * FROM `users` WHERE `id`='$id'");
    $logged_in_user_data=mysqli_fetch_array($query);
    $user_perm=$logged_in_user_data['permissions']; 
    $perm=explode(',', $user_perm);
    if(in_array($permission,$perm,true)){return true;}return false;
}

function teachers_page_redirect(){
    header('Location: http://'.$_SERVER['HTTP_HOST'].'/school/users/staffhomepage.php', true, 303);
    exit;
}

function store_page_redirect(){
    header('Location: http://'.$_SERVER['HTTP_HOST'].'/school/store/index.php', true, 303);
    exit;
}

function approve_application($id){
    global $db;
    $applicant_id=$id;
    $db->query("UPDATE `applications` SET `status`=1 WHERE `id`='$id'");
}

function delete_application($id){
    $applicant_id=$id;
    if($applicant_id !=0 && $applicant_id>0){
         global $db;
         $db->query("DELETE FROM `applications` WHERE `id`='$applicant_id'");
    }else{
        echo 'There was a problem in getting the student id. Reload page and try again!';die();
    }  
}

function generatepassword(){
    $password = "";
    $charset = "abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ0123456789"; 
    for($i = 0; $i < 8; $i++)
    {
        $random_int = mt_rand();
        $password .= $charset[$random_int % strlen($charset)];
    } 
    return $password;
}

?>