<?php
require_once $_SERVER['DOCUMENT_ROOT'].'/school/core/init.php';
if(isset($_POST)):
    $staffId        = (int)clean($_POST['staffId']);
    $userData       = mysqli_fetch_array($db->query("SELECT * FROM `staff_accounts` WHERE `staff_id`='$staffId'"));

    $nhifPercentage = ((isset($_POST['nhif'])&& $_POST['nhif']=="true"? ($configurationData['nhif_percentage']/100):''));//gets the NHIF percentage from db
    $nssfPercentage = ((isset($_POST['nssf']) && $_POST['nssf']=="true"? ($configurationData['nssf_percentage']/100):''));//gets the NSSF percentage from db  
    $setDamages     = ((isset($_POST['damages']) && $_POST['damages']=="true" ? $userData['damages'] : 0));
    $setAdvance     = ((isset($_POST['advance'])&& $_POST['advance']=="true"? $userData['salary_advance']:0));

     if(!empty($nhifPercentage) && empty($nssfPercentage)){
         $percentageAmount   =   ($nhifPercentage * $userData['salary']);
         $setSalary          =   clean($userData['salary'] - $percentageAmount); //returns the salary affected by the NHIF and NSSF Charges
         $expDescription     =   'Payment of NHIF.';
         addExpense($expDescription,$percentageAmount); 
    }else if(empty($nhifPercentage) && !empty($nssfPercentage)){
         $percentageAmount   = ($nssfPercentage * $userData['salary']);
         $setSalary          = clean($userData['salary'] - ($userData['salary']*$nssfPercentage)); //returns the salary affected by the NHIF and NSSF Charges
         $expDescription     = 'Payment of NSSF.';
         addExpense($expDescription,$percentageAmount);
    }else if(!empty($nhifPercentage) && !empty($nssfPercentage)){
         $percentageAmount   =  ($nhifPercentage * $userData['salary']) + ($nssfPercentage * $userData['salary']);
         $setSalary          =  clean($userData['salary'] - ($nhifPercentage*$userData['salary']) - ($userData['salary']*$nssfPercentage)); //returns the salary affected by the NHIF and NSSF Charges
         $expDescription     =  'Payment of NHIF & NSSF.';
         addExpense($expDescription,$percentageAmount);
    }else{
         $setSalary          = clean($userData['salary']); //returns the salary without any dedactions
    }
   
    $newAdvance = clean(($setSalary - $setAdvance));//gets the amount employee is supposed to be paid after taking a salary advance
    $newDamages = '';
    $newSalary  = '';

        if($newAdvance >= $setDamages){//if after subtracting salary from advance and the balance is greater than or equal to the damages then set damages equal to zero
            $newDamages = decimal(0);
            $newSalary  = clean(($newAdvance - $setDamages));//new salary is the amount payable after advance and damages have been deducted
        }else if($newAdvance < $setDamages){//if after subtrating the salary from advanvce and the remainder is less than the damages, then subtract up to the amount equal to the value of the remainder
            $newDamages = clean(($setDamages - $newAdvance));
            $newSalary  = decimal(0);//in this case the salary is less than the advance and damages combined
        }

    $details    = clean("SALARY");

    // $db->query("INSERT INTO staff_invoices(staff_id,details,amount,date) VALUES('$staffId','$details','$newSalary','$todayDate')");
    // $db->query("UPDATE staff_accounts SET damages='$newDamages',salary_advance=0.00, last_payment_date='$todayDateTime'");
    // $db->query("INSERT INTO salarypayment_dates (paymentDate) VALUES ('$todayDateTime')"); 
    
    $messages[].='<b>Success! </b>Salaries have been paid to all employees.';
    echo displayMessages($messages);
endif;
$db->close();
?> 