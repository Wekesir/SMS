<!DOCTYPE html>
<html>
<?php
require_once $_SERVER['DOCUMENT_ROOT'].'/school/core/init.php';
include '../admin/header.php';

if($logged_in_user_data['permissions']!='Super_Admin'){
    header('Location: /school/admin/students.php');
}
?>
<style>
#bulkuploadDiv{
    padding: 20px;
    position: relative;
    left: 20%;
    width: 60%;
    top: 30px;
    background:white;
}
h6{
    padding: 10px;
    text-align:center;
    background: #f8f8f8;
}
</style>

<body style="background:#f8f8f8;">
    <?php include '../admin/navigation.php'; ?>

    <div id="bulkuploadDiv">
        <h6>
            <label class="float-left"><a href="/school/admin/students.php">Back.</a></label>  
            <label> BULK UPLOAD STUDENTS.</label>
            <label class="float-right"><a href="/school/documents/school/students.csv">Download template.</a></label>  
        </h6>
        <?php 

        $regAbbrev = $configurationData['registrationNumber_abbreviation'];//gets the value from the system configuration table

            if(isset($_POST['submit'])){

                  //check the selected file format
                $file=explode('.',$_FILES['bulkupload']['name']);
                    if(end($file)!='csv'){
                        $errors[].='<b>Error!</b> Please select the correct file format.(.CSV)';
                    }

                    //check for errors
                    if(!empty($errors)){//check if there are errors
                        displayErrors($errors);//fucntion for displaying errors
                    }else{ 
                        $fileTemp = $_FILES['bulkupload']['tmp_name'];
                        $handle   = fopen($fileTemp,'r');
                        
                        $rowCount = 0;
                        while(($data = fgetcsv($handle,0,',')) !==false){
                            if($rowCount!=0){                               
                                $regnumber       = strtoupper($data[0]);
                                $stdname         = strtoupper($data[1]);  
                                $stdgender       = strtoupper($data[2]); 
                                $stddob          = date($data[3]);                                  
                                $stdgrade        = strtoupper($data[4]);  
                                $parname         = strtoupper($data[5]);    
                                $parname2        = strtoupper($data[6]);  
                                $parphone        = '0'.$data[7];  
                                $parphone2       = '0'.$data[8];
                                $contacts        = $parphone.','.$parphone2;
                                $idnumber        = $data[9];
                                $paremail        = strtolower($data[10]); 
                                $food            = strtoupper($data[11]);
                                $transport       = strtoupper($data[12]);
                                $scholarType     = strtoupper($data[13]);
                                $stdpostal       = strtoupper($data[14]);
                                $paraddress      = strtoupper($data[15]);  
                                $date            =  date('Y-m-d H:i:s');                                                                                                              
                               
                                $db->query("INSERT INTO students 
                                            (stdname,stddob,registration_number,idnumber,stdgender,stdgrade,stdpostal,parname,parname2,contacts,paremail,paraddress,doa,food,transport,scholarType)
                                            VALUES
                                            ('$stdname','$stddob','$regnumber','$idnumber','$stdgender','$stdgrade','$stdpostal','$parname','$parname2','$contacts','$paremail','$paraddress','$date','$food','$transport','$scholarType')");
                            
                                $last_id = $db->insert_id;  

                                $db->query("INSERT INTO fees_account(student_id) VALUES ('$last_id')");//creates a finance account for the student 

                            }
                           
                           $rowCount++;
                        }
                   
                    fclose(fopen($_FILES['bulkupload']['tmp_name'],"r"));

                    $regQuery   =   $db->query("SELECT * FROM students WHERE registration_number=''");                  
                    while($queryData  =   mysqli_fetch_assoc($regQuery)){
                        $idArray    =   array($queryData['id']);
                         foreach($idArray as $id){ 
                                $year = date('Y');
                                $registrationNumber = $regAbbrev.'/'.$id.'/'.$year;
                                $db->query("UPDATE students SET registration_number='$registrationNumber' WHERE id='$id'");
                        }
                    }                                                        

                    $messages[].='<n>Success! </b>Data has been uploaded to server.';
                    displayMessages($messages);
                      
                    }
                
            }

            $db->close();
        ?>

        <form action="<?=$_SERVER['PHP_SELF']?>" enctype="multipart/form-data" method="POST">
            <div class="form-group">
                <label for="">Select .csv file format</label>
                <input type="file" name="bulkupload" class="form-control" required=required>
            </div>
            <div class="form-group">
                <input type="submit" class="btn" name="submit" value="Submit">
            </div>
        </form>

        <!---------------------------------------------------------------------------------------------------------------------------------
            THE STUDENTS BULK UPLOAD ENDS HERE
        ---------------------------------------------------------------------------------------------------------------------------------->



        <?php
        if(isset($_POST['bulkuploadStn'])){
              //check the selected file format
                $file=explode('.',$_FILES['bulkuploadstaff']['name']);
                    if(end($file)!='csv'){
                        $errors[].='<b>Error!</b> Please select the correct file format.(.CSV)';
                    }

                    //check for errors
                    if(!empty($errors)){//check if there are errors
                        displayErrors($errors);//fucntion for displaying errors
                    }else{ 
                        $fileTemp = $_FILES['bulkuploadstaff']['tmp_name'];
                        $handle = fopen($fileTemp,'r');
                        
                        $rowCount = 0;
                        while(($data = fgetcsv($handle,0,',')) !==false){
                            if($rowCount!=0){
                                $name           = strtoupper(clean($data[0]));
                                $username_array = explode(' ', strtolower($data[0]));//explode the username 
                                $username       = ($username_array[1].'.'.$username_array[0]);//the username becomes the secode name dot the first name
                                $idnumber       = trim(clean($data[1]));
                                $email          = trim(clean($data[2]));
                                $dob            = trim(clean($data[3]));
                                $gender         = strtoupper(trim(clean($data[4])));
                                $phonenumber    = '0'.trim(clean($data[5]));                             
                                $nhif           = trim(clean($data[6]));
                                $nssf           = trim(clean($data[7]));
                                $residence      = strtoupper(trim(clean($data[8])));
                                $accesslevel    = trim(clean($data[9]));
                                $employmenttype = trim(clean($data[10]));  
                                $pass           = $configurationData['school_name'].date('Y');
                                $passwordhashed = password_hash($pass,PASSWORD_DEFAULT);                             
                                $date           = date('Y-m-d H:i:s');  
                                
                                    $db->query("INSERT INTO users (name,username,email,password,permissions,employed_on,birth_date,gender,phone,employment_type,national_id,residence,nhif,nssf)
                                                VALUES ('$name','$username','$email','$passwordhashed','$accesslevel','$date','$dob','$gender','$phonenumber','$employmenttype','$idnumber','$residence','$nhif','$nssf',)");

                                    $insertId = $db->insert_id;//the id of the last inserted column

                                    $db->query("INSERT INTO staff_accounts (staff_id,activation_date) VALUES('$insertId',$date)");
                            }
                           
                        $rowCount++;
                        }
                   
                    fclose(fopen($_FILES['bulkuploadstaff']['tmp_name'],"r"));  
                    
                    $db->close();

                    $messages[].='<n>Success! </b>Data has been uploaded to server.';
                    displayMessages($messages);
                      
                    }  
        }
        ?>
         <h6>
            <label class="float-left"><a href="/school/admin/staff.php">Back.</a></label>  
            <label> BULK UPLOAD STAFF.</label>
            <label class="float-right"><a href="/school/documents/school/uploadstaff.csv">Download template.</a></label>  
        </h6>

        <form action="<?=$_SERVER['PHP_SELF']?>" enctype="multipart/form-data" method="POST">
            <div class="form-group">
                <label for="">Select .csv file format</label>
                <input type="file" name="bulkuploadstaff" class="form-control" required=required>
            </div>
            <div class="form-group">
                <input type="submit" class="btn" name="bulkuploadStn" value="Submit">
            </div>
        </form>



        <h6>
            <label class="float-left"><a href="/school/admin/formerstudents.php">Back.</a></label>  
            <label> BULK UPLOAD FORMER STUDENTS.</label>
            <label class="float-right"><a href="/school/documents/school/formerstudents_upload.csv">Download template.</a></label>  
        </h6>

        <?php
        if(isset($_REQUEST['bulkuploadFormer'])){
           //check the selected file format
                $file=explode('.',$_FILES['bulkuploadformer']['name']);
                    if(end($file)!='csv'){
                        $errors[].='<b>Error!</b> Please select the correct file format.(.CSV)';
                    }

                    //check for errors
                    if(!empty($errors)){//check if there are errors
                        displayErrors($errors);//fucntion for displaying errors
                    }else{ 
                        $fileTemp = $_FILES['bulkuploadformer']['tmp_name'];
                        $handle = fopen($fileTemp,'r');
                        
                        $rowCount = 0;
                        while(($data = fgetcsv($handle,0,',')) !==false){
                            if($rowCount!=0){
                                $name               = strtoupper(trim(clean($data[0])));
                                $gender             = strtoupper(trim(clean($data[1])));
                                $phone              = '0'.trim(clean($data[2]));                             
                                $yearAccomplished   = trim(clean($data[3]));
                                
                                $db->query("INSERT INTO former_students(name, gender, phone, year_accomplished)
                                            VALUES ('$name','$gender','$phone','$yearAccomplished') ");
                            }
                           
                        $rowCount++;
                        }
                   
                    fclose(fopen($_FILES['bulkuploadformer']['tmp_name'],"r"));  
                    
                    $db->close();

                    $messages[].='<n>Success! </b>Data has been uploaded to server.';
                    displayMessages($messages);
                      
                    }   
        }
        ?>

        <form action="<?=$_SERVER['PHP_SELF']?>" enctype="multipart/form-data" method="POST">
            <div class="form-group">
                <label for="">Select .csv file format</label>
                <input type="file" name="bulkuploadformer" class="form-control" required=required>
            </div>
            <div class="form-group">
                <input type="submit" class="btn" name="bulkuploadFormer" value="Submit">
            </div>
        </form>
       
    </div>
</body>
</html>

