 <?php
    require_once $_SERVER['DOCUMENT_ROOT'].'/school/core/init.php';
    //check if data has been sent to this page 
    if(isset($_POST)):
        $UPINumber   = trim(clean($_POST['UPINumber']));
        $action      = trim(clean($_POST['action_type']));
        $amt         = trim(clean($_POST['amount']));
        $desc        = trim(clean(strtoupper($_POST['description'])));
        $description = "";
        $date        = date("Y-m-d");
        //fetch the student ID based on the UPI Number
        $idQuery    =   mysqli_fetch_array($db->query("SELECT `id` FROM `students` WHERE `registration_number`='{$UPINumber}' AND deleted=0"));
        $studentID  =   $idQuery['id'];
        //check whhether the action is credit or debit
        if($action=="credit"):
            $amt            =   (-1 * $amt);//coverts the number into a negative number
            $description    = "CREDIT";
        elseif($action=="debit"):
            $amt            =   $amt;
            $description    = "DEBIT";
        else:
            //if the option are neithre credit nor debit, throw an error
            $errors[].="<b>Fatal Error! </b>System Integrity compromised.";
        endif;

        $description = $description.'-'.$desc;

        $stdAccountQuery = mysqli_fetch_array($db->query("SELECT * FROM `fees_account` WHERE `id`='$studentID'"));//fetched the amount of money the student has in the school account
        $availableAmount = $stdAccountQuery['amount'];//currentt amount in the students school account
        $newBalance      = ($availableAmount + $amt);//new Balance is the balance from school wallet plus the paid amount

        //chck if ther are any errors
        if(!empty($errors)):
            echo displayErrors($errors);
        else:
            $db->query("INSERT INTO `fees_invoices` (`student_id`,`amount`,`mode`,`date`)
                        VALUES('$studentID','$amt','$description','$date')");
            $db->query("UPDATE `fees_account` 
                        SET `amount`='$newBalance' 
                        WHERE `id`='$studentID'");

            $messages[].="<b>Success! </b>Acoount action has been performed, check student statement.";
            echo displayMessages($messages);
        endif;        
    endif;
 ?>