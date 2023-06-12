<?php
require_once $_SERVER["DOCUMENT_ROOT"].'/school/core/init.php';//dabase connectino file

//filter by date range
//searching message by date
if(isset($_POST['dateRange'])){
    $date     = $_POST['dateRange'];
    $fromDate = $date['fromDate'];
    $toDate   = $date['toDate'];
    $count = 1;
    $messageQuery = $db->query("SELECT * FROM `message_outbox` WHERE DATE(`date`) BETWEEN CAST('{$fromDate}' AS DATE) AND CAST('{$toDate}' AS DATE)");
    if(mysqli_num_rows($messageQuery) == 0){
        $info[].='<b>Oops! </b>Seems like there are no messages to display.';
        displayinfo($info);
    }
    ob_start();
    while($messageData = mysqli_fetch_array($messageQuery)) : ?>
        <div id="messageBody">
        <div>
            <tr>
                <td> <?=$messageData['recipient'];?> </td>
                <td style="padding-left: 50px;"><?=$messageData['phone_number'];?></td>
            </tr>
            <label class="float-right text-primary"><b><?=date("jS F, Y", strtotime($messageData['date']));?></b></label>
        </div>
        <div style="min-height: 7vh;background-color:#f8f8f8;padding: 5px;"><?=$messageData['message'];?></div>
        <div>
            <label class="text-danger deleteMessage" id="<?=$messageData['id']?>" title="delete message"><i class="fas fa-trash-alt"></i> delete</label>
            <label class="float-right text-primary">Sender: <?=$logged_in_user_data['name'];?></label>
        </div>
    </div>
    <?php $count++; endwhile; echo ob_get_clean();
}

//searching message by date
if(isset($_POST['filterDate'])){
    $date = clean($_POST['filterDate']);
    $count = 1;
    $messageQuery = $db->query("SELECT * FROM `message_outbox` WHERE DATE(`date`)='{$date}'");
    if(mysqli_num_rows($messageQuery) == 0){
        $info[].='<b>Oops! </b>Seems like there are no messages to display.';
        displayinfo($info);
    }
    ob_start();
    while($messageData = mysqli_fetch_array($messageQuery)) : ?>
        <div id="messageBody">
        <div>
            <tr>
                <td> <?=$messageData['recipient'];?> </td>
                <td style="padding-left: 50px;"><?=$messageData['phone_number'];?></td>
            </tr>
            <label class="float-right text-primary"><b><?=date("jS F, Y", strtotime($messageData['date']));?></b></label>
        </div>
        <div style="min-height: 7vh;background-color:#f8f8f8;padding: 5px;"><?=$messageData['message'];?></div>
        <div>
            <label class="text-danger deleteMessage" id="<?=$messageData['id']?>" title="delete message"><i class="fas fa-trash-alt"></i> delete</label>
            <label class="float-right text-primary">Sender: <?=$logged_in_user_data['name'];?></label>
        </div>
    </div>
    <?php $count++; endwhile; echo ob_get_clean();
}

//searching message by recipient name
if(isset($_POST['searchName'])){
    $name = clean(strtoupper($_POST['searchName']));
    $count = 1;
    $messageQuery = $db->query("SELECT * FROm `message_outbox` WHERE `recipient` LIKE '%".$name."%'");
    if(mysqli_num_rows($messageQuery) == 0){
        $info[].='<b>Oops! </b>Seems like there are no messages sent yet.';
        displayinfo($info);
    }
    ob_start();
    while($messageData = mysqli_fetch_array($messageQuery)) : ?>
        <div id="messageBody">
        <div>
            <tr>
                <td> <?=$messageData['recipient'];?> </td>
                <td style="padding-left: 50px;"><?=$messageData['phone_number'];?></td>
            </tr>
            <label class="float-right text-primary"><b><?=date("jS F, Y", strtotime($messageData['date']));?></b></label>
        </div>
        <div style="min-height: 7vh;background-color:#f8f8f8;padding: 5px;"><?=$messageData['message'];?></div>
        <div>
            <label class="text-danger deleteMessage" id="<?=$messageData['id']?>" title="delete message"><i class="fas fa-trash-alt"></i> delete</label>
            <label class="float-right text-primary">Sender: <?=$logged_in_user_data['name'];?></label>
        </div>
    </div>
    <?php $count++; endwhile; echo ob_get_clean();
}

if(isset($_POST['deleteMessageId']) && $_POST['deleteMessageId']!=0){
    $id = (int)clean($_POST['deleteMessageId']);
    $db->query("DELETE FROM `message_outbox` WHERE `id`='{$id}'");
}

if(isset($_POST['getMessages'])){
    $count = 1;
    $messageQuery = $db->query("SELECT * FROM `message_outbox` ORDER BY `id` DESC");
    if(mysqli_num_rows($messageQuery) == 0){
        $info[].='<b>Oops! </b>Seems like there are no messages sent yet.';
        displayinfo($info);
    }
    ob_start();
    while($messageData = mysqli_fetch_array($messageQuery)) : ?>
        <div id="messageBody">
        <div>
            <tr>
                <td> <?=$messageData['recipient'];?> </td>
                <td style="padding-left: 50px;"><?=$messageData['phone_number'];?></td>
            </tr>
            <label class="float-right text-primary"><b><?=date("jS F, Y", strtotime($messageData['date']));?></b></label>
        </div>
        <div style="min-height: 7vh;background-color:#f8f8f8;padding: 5px;"><?=$messageData['message'];?></div>
        <div>
            <label class="text-danger deleteMessage" id="<?=$messageData['id']?>" title="delete message"><i class="fas fa-trash-alt"></i> delete</label>
            <label class="float-right text-primary">Sender: <?=$logged_in_user_data['name'];?></label>
        </div>
    </div>
    <?php $count++; endwhile; echo ob_get_clean();
}

if(isset($_POST['removeContacts']))://removing contacts already
    unset($_SESSION['CONTACT_INFO']);
endif;

if(isset($_POST['groupId']) && $_POST['groupId']>0){
    $groupId      = (int)trim($_POST['groupId']);
    $gradeResult  = mysqli_fetch_array($db->query("SELECT `grade` FROM `grade` WHERE `id`='{$groupId}'"));
    $grade        = $gradeResult['grade'];
    $studentQuery = $db->query("SELECT `parname`,`parname2`,`contacts` FROM `students` WHERE `stdgrade`='{$grade}'");
  ; //var_dump($studentData);
    while($studentData  = mysqli_fetch_array($studentQuery)):
        $firstParentName  = $studentData['parname'];//first parent name
        $secondParentName = $studentData['parname2'];//second parent name
        $parentsArray     = ((empty($secondParentName))?array($firstParentName):array($firstParentName,$secondParentName));//this array holds values for both the guardians names
        $contacts         = explode(',',$studentData['contacts']);
        $contactString    = "";
        //check how many guardians are in the system and loop throuhg them
        for($x=0;$x<count($parentsArray);$x++):
            $info[] = array(
                'Name'  => $parentsArray[$x],
                'Number'=> $contacts[$x]
            );
            if($x>0){
                $decodedString = json_decode($contactString,true);
                $contactString = json_encode(array_merge($decodedString, $info));
            }else{
                $contactString  = json_encode($info);
            }           
        endfor;        
    endwhile; 
     //check if the session has been set
    if(isset($_SESSION['CONTACT_INFO']))://if the session already exists
        $sessionArray  =  json_decode($_SESSION['CONTACT_INFO'],true);
        $contactArray  =  json_decode($contactString,true);
        $_SESSION['CONTACT_INFO'] = json_encode(array_merge($contactArray, $sessionArray));
    else://if the sesion has not been set
        $_SESSION['CONTACT_INFO'] = $contactString;//assign thr session value of the phone number 
    endif;
}

if(isset($_POST['contactInfo'])){
    $name        = trim($_POST['contactInfo']['Name']);
    $phoneNumber = trim($_POST['contactInfo']['Number']);
    //check if the session has been set
    if(isset($_SESSION['CONTACT_INFO']))://if the session already exists
        $info[] = array(
            'Name'  => $name,
            'Number'=> $phoneNumber
        );
        $newArray =  json_decode($_SESSION['CONTACT_INFO'],true);
        $_SESSION['CONTACT_INFO'] = json_encode(array_merge($newArray, $info));
    else://if the sesion has not been set
        $info[] = array(
            'Name' => $name,
            'Number'=> $phoneNumber
        );
        $_SESSION['CONTACT_INFO']=json_encode($info);//assign thr session value of the phone number 
    endif;
}

//removing a number from the list to receive message
if(isset($_POST['removeNumberArrayIndex']) && !empty($_POST['removeNumberArrayIndex'])){
    $arrayIndex  = ((int)$_POST['removeNumberArrayIndex'] - 1);//index of the array in the json string
    $arrayDecode = json_decode($_SESSION['CONTACT_INFO'],true);
    $newArray    = array();
    for($i=0;$i<count($arrayDecode);$i++):
        //check the array length
        if(count($arrayDecode)==1)://if there is only one item in the array
            unset($_SESSION['CONTACT_INFO']);//delete this session
        else:
            if($arrayIndex!=$i):
                $newArray[] = $arrayDecode[$i];
            endif;
        endif;        
    endfor;
    $_SESSION['CONTACT_INFO']=json_encode(array_merge($newArray));
}

if(isset($_POST['phoneNumber']) && !empty($_POST['phoneNumber'])){//if the phone Number has been set
    $phoneNumber = base64_decode(clean($_REQUEST['phoneNumber']));
    $name        = strtoupper(base64_decode(clean($_REQUEST['name'])));
    //check if the session has been set
    if(isset($_SESSION['CONTACT_INFO']))://if the sesion already exists
        $info[] = array(
            'Name'  => $name,
            'Number'=> $phoneNumber
        );
        $newArray =  json_decode($_SESSION['CONTACT_INFO'],true);
        $_SESSION['CONTACT_INFO'] = json_encode(array_merge($newArray, $info));
    else://if the sesion has not been set
        $info[] = array(
            'Name' => $name,
            'Number'=> $phoneNumber
        );
        $_SESSION['CONTACT_INFO']=json_encode($info);//assign thr session value of the phone number 
    endif;
}

if(isset($_POST['outbox_count'])){//when the request has been sent to check the messages in the outbox
    $outboxQuery = $db->query("SELECT * FROM `message_outbox`");
    echo mysqli_num_rows($outboxQuery);
}
?>