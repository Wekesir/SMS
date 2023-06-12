<style>
    #newformerstudent{
        position:absolute;
        left: 10%;
        width: 80%;
        top: 30px;
        padding: 30px;
        box-shadow: 0 4px 8px 0 rgba(0, 0, 0, 0.2), 0 6px 20px 0 rgba(0, 0, 0, 0.19);
    }
</style> 
<div id="newformerstudent">

    
    <h6 class="text-center">
    <label class="float-left"><a href="/school/admin/formerstudents.php">Back</a></label>    
    <label for="">  <?=((isset($_GET['edit'])?'EDIT STUDENT INFORMATION':'ADD NEW STUDENT(S)'))?> </label>
    </h6>

    <?php
    $messages = array();
    $errors = array();

    $name             = ((isset($_POST['name'])? strtoupper(clean($_POST['name'])) :''));
    $phone            = ((isset($_POST['phone'])? clean($_POST['phone']) :''));
    $gender           = ((isset($_POST['gender'])? clean($_POST['gender']) :''));
    $yearAccomplished = ((isset($_POST['year'])? clean($_POST['year']) :''));
    

    /*************************************************************************************************************************************
     * IF THE EDIT HAS BEEN SET
     ************************************************************************************************************************************/
    if(isset($_GET{"edit"}) && $_GET['edit']>0){
        $editId     =   (int) clean($_GET['edit']);
        $editData   =   mysqli_fetch_assoc($db->query("SELECT * FROM former_students WHERE id='$editId'"));

        $name             = $editData['name'];
        $phone            = $editData['phone'];
        $gender           = $editData['gender'];
        $yearAccomplished = $editData['year_accomplished'];

    }

    /**************************************************************************************************************************************
     * UPLOAD BUTTON 
     *************************************************************************************************************************************/

    if(isset($_POST['upload'])){

        //check the selected file format
        $file=explode('.',$_FILES['bulkupload']['name']);
            if(end($file)!='csv'){
                $errors[].='<b>Error!</b> Please select the correct file format.(.CSV)';
            }

        //check the file format
        if($_FILES['bulkupload']['name'] == ''){
            $errors[].='<b>Error!</b> Please select a file to upload';                             
        }

         if(!empty($errors)){//check if there are errors

            displayErrors($errors);//fucntion for displaying errors

        }else{      

            $fileTemp = $_FILES['bulkupload']['tmp_name'];
            $handle = fopen($fileTemp,'r');

            $count = 0;
            while(($data = fgetcsv($handle,1000,',')) !==false){
                if($count>0){
                    $name             = strtoupper(clean($data[0]));
                    $phone            = clean($data[1]);
                    $gender           = strtoupper(clean($data[2]));
                    $yearAccomplished = clean($data[3]);

                    $db->query("INSERT INTO former_students(name, gender, phone, year_accomplished)
                                VALUES ('$name','$gender','$phone','$yearAccomplished') ");
                }
               
               $count++;
            }
       
        fclose(fopen($_FILES['bulkupload']['tmp_name'],"r"));//closes the file that we re reading from

       
        $messages[].='<b>Success! </b>Data uploaded into database.';
        displayMessages($messages);

        }


    }else if(isset($_POST['submit'])){//incase the submit button is clicked

        $name             = ((isset($_POST['name'])? strtoupper(clean($_POST['name'])) :''));
        $phone            = ((isset($_POST['phone'])? clean($_POST['phone']) :''));
        $gender           = ((isset($_POST['gender'])? clean($_POST['gender']) :''));
        $yearAccomplished = ((isset($_POST['year'])? clean($_POST['year']) :''));

        //check if the name provided already exists
        if(mysqli_num_rows($db->query("SELECT * FROM former_students WHERE name='$name'")) >0){
            $errors[].='<b>Error! </b>The name you provided already exists';
            $db->close();
        }

        //check if all the required data has been provided
        if(empty($name) || empty($yearAccomplished) || empty($gender)){
            $errors[].='<b>Error! </b> Provide all info marked *';
        }

        //check for errors
        if(!empty($errors)){
            displayErrors($errors);
        }else{
           $db->query("INSERT INTO former_students(name, gender, phone, year_accomplished)
                       VALUES ('$name','$gender','$phone','$yearAccomplished') ");

            $messages[].='<b>Success! </b>Data inserted into database.';
            displayMessages($messages);
        }
        
    }
    ?>

    <form action="<?=((isset($_GET['edit'])? $_SERVER['PHP_SELF'].'?edit='.$_GET['edit'] : $_SERVER['PHP_SELF'].'?addstudent=1'))?>" method="post" enctype="multipart/form-data">

    <div class="row">
        <div class="col-md-7">

        <div class="form-group">
            <label for="name">Student Name*</label>
            <input type="text" class="form-control" name="name"  value="<?=$name;?>">
        </div>
         <div class="form-group">
            <label for="name">Phone</label>
            <input type="number" class="form-control" name="phone" min=0 value="<?=$phone;?>">
        </div>
         <div class="form-group">
            <label for="name">Year Accomplished*</label>
            <input type="year" class="form-control" name="year" value="<?=$yearAccomplished;?>">
        </div>
         <div class="form-group">
                <Label for="gender">Gender*</Label>
                <div class="radio">
                 <label for="gender" class="radio-inline"><input type="radio"  name="gender" value="MALE" <?php if($gender=='MALE'){ echo 'checked';}?> >Male</label>
                 <label for="gender" class="radio-inline"><input type="radio"  name="gender" value="FEMALE" <?php if($gender=='FEMALE'){ echo 'checked';}?>>Female</label>
                </div>
            </div>
        <div class="form-group">
            <input type="submit" name="<?=((isset($_GET['edit'])?'update':'submit'))?>" class="btn btn-default btn-md" value="<?=((isset($_GET['edit'])?'Update':'Submit'))?>">
        </div>

        </div>

        <div class="col-md-5">
          
            <h6 class="small_font"><a href="/school/documents/school/Former Students Upload.csv">Download</a> bulk upload template.</h6>
            <div class="form-group">
                <label for="name">Select file to upload*</label>
                <input type="file" class="form-control small_font" name="bulkupload" >
            </div>
            <div class="form-group">
                <input type="submit" name="upload" class="btn btn-default small_font" value="Upload">
            </div>
        </div>

    </div>

    </form>
</div>