<?php
require_once $_SERVER['DOCUMENT_ROOT'].'/school/core/init.php';//database connection file
?>

<h5 style="padding:10px;background-color:#f8f8f8;">UPLOAD RECIPIENTS.</h5>

<label for=""><a href="/school/documents/school/sms_recipients.csv">Download Template.</a></label>

<?php
if(isset($_POST['submit'])){
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
                    $phoneNumber     = '0'.$data[1]; echo $recipient.' '.$phoneNumber;
                     
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
}
?>

<form action="<?=$_SERVER['PHP_SELF']?>" method="post" enctype="multipart/form-data">
    <div class="form-group">
        <label for="">Choose a file to upload(.CSV format)</label>
        <input type="file" name="recipients" class="form-control" id="" required=required>
    </div>
    <div class="form-group">
        <input type="submit" name="submit" value="Submit" class="btn btn-sm btn-primary">
    </div>
</form>
