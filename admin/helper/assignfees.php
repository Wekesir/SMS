<div id="assignfeesdiv" style="position:absolute;top:20%;left:15%;width:70%;padding:10px;background-color:#dcdcdc;box-shadow:5px 5px lightgrey;">

    <div id="note">
        <p class="small_font">
            By clicking this button, the system will automatically subtract the set amount for each student for this term.
            i.e If the student is in grade 1, the system:
            <ul class="exsmall_font">
                <li>Reads the amount supposed to be paid in grade 1 from database</li>
                <li>The system checks the students current financial status from the database. </li>
                <li>The system computes the new amount resulting into either an overpay, balance or clears account.</li>
            </ul>
        </p>
    </div>
    <div style="padding:30px;">         
<?php   
$currentFeesEncoded='';//will hold an array of encoded fees for the current term
$transportCharges   = ((isset($configurationData['transport']) && $configurationData['transport'] == 'YES' ? $configurationData['transportation_charges'] :'0.00'));
$year               = date("Y");

$feesQuery     = $db->query("SELECT * FROM `school_fees` WHERE `year`='{$year}'");//Selects all school fees for the current year
$feesQueryData = mysqli_fetch_array($feesQuery);

$feesSet = mysqli_num_rows($feesQuery);//checks whether the fees for the current year has been set

if($feesSet != 0){//if the fees fot this year has been set then let the condition executes
        if($currentPeriod == 'Term 1'){
            $currentFeesEncoded =$feesQueryData['term1'];//captures this specific term's data from the database
        }else if($currentPeriod == 'Term 2'){
            $currentFeesEncoded =$feesQueryData['term2'];//captures this specific term's data from the database
        }else if($currentPeriod == 'Term 3'){
            $currentFeesEncoded =$feesQueryData['term1'];//captures this specific term's data from the database
        }else{
            $currentFeesEncoded = '';
        }
    $feesDecoded=json_decode($currentFeesEncoded,TRUE);//decodes the specific term data that we needed
    if($currentFeesEncoded !=''):
        foreach($feesDecoded as $fees){
            $playgroup = $fees['playgroup'];//gets school fees from the decoded json string from database
            $pp1       = $fees['pp1'];//gets school fees from the decoded json string from database
            $pp2       = $fees['pp2'];//gets school fees from the decoded json string from database
            $grade1    = $fees['grade1'];//gets school fees from the decoded json string from database
            $grade2    = $fees['grade2'];//gets school fees from the decoded json string from database
            $grade3    = $fees['grade3'];//gets school fees from the decoded json string from database
            $grade4    = $fees['grade4'];//gets school fees from the decoded json string from database
            $grade5    = $fees['grade5'];//gets school fees from the decoded json string from database
            $grade6    = $fees['grade6'];//gets school fees from the decoded json string from database
            $class5    = $fees['class5'];//gets school fees from the decoded json string from database
            $class6    = $fees['class6'];//gets school fees from the decoded json string from database
            $class7    = $fees['class7'];//gets school fees from the decoded json string from database
            $class8    = $fees['class8'];//gets school fees from the decoded json string from database
        }
    endif;
}
        

if(isset($_POST['submitBtn'])){//when the submit button is clicked                   
    if($feesSet !=0){ //check if the fees for this year has been set
        $newFeesBalance = 0;
        $query          = $db->query("SELECT * FROM `students` WHERE `deleted`=0 AND `accomplished`=0");
        $queryData=mysqli_fetch_array($query);
        if($currentFeesEncoded != ''){//ensures the school is not on holiday
            while($queryData=mysqli_fetch_array($query)):
                switch($queryData['stdgrade']){
                    case 'PLAYGROUP':
                        $stdId = (int)$queryData['id'];
                        $accountBalQuery = $db->query("SELECT * FROM fees_account WHERE student_id='$stdId'");
                        $accountBalQueryData = mysqli_fetch_array($accountBalQuery);
                        $accountBal = $accountBalQueryData['amount'];
                        $foodCharges = get_food_charges($stdId);
                        $termAmount = $playgroup + $foodCharges + $transportCharges;
                        $newBal = ($accountBal - $termAmount);
                        $db->query("UPDATE fees_account SET amount='$newBal' WHERE student_id='$stdId'");
                    break;
                    case 'PP1':
                    $stdId = (int)$queryData['id'];
                        $accountBalQuery = $db->query("SELECT * FROM fees_account WHERE student_id='$stdId'");
                        $accountBalQueryData = mysqli_fetch_array($accountBalQuery);
                        $accountBal = $accountBalQueryData['amount'];
                        $foodCharges = get_food_charges($stdId);
                        $termAmount = $pp1 + $foodCharges + $transportCharges;
                        $newBal = ($accountBal - $termAmount);
                        $db->query("UPDATE fees_account SET amount='$newBal' WHERE student_id='$stdId'");
                    break;
                    case 'PP2';
                    $stdId = (int)$queryData['id'];
                        $accountBalQuery = $db->query("SELECT * FROM fees_account WHERE student_id='$stdId'");
                        $accountBalQueryData = mysqli_fetch_array($accountBalQuery);
                        $accountBal = $accountBalQueryData['amount'];
                        $foodCharges = get_food_charges($stdId);
                        $termAmount = $pp2 + $foodCharges + $transportCharges;
                        $newBal = ($accountBal - $termAmount);
                        $db->query("UPDATE fees_account SET amount='$newBal' WHERE student_id='$stdId'");
                    break;
                    case 'GRADE 1':
                    $stdId = (int)$queryData['id'];
                        $accountBalQuery = $db->query("SELECT * FROM fees_account WHERE student_id='$stdId'");
                        $accountBalQueryData = mysqli_fetch_array($accountBalQuery);
                        $accountBal = $accountBalQueryData['amount'];
                        $foodCharges = get_food_charges($stdId);
                        $termAmount = $grade1 + $foodCharges + $transportCharges;
                        $newBal = ($accountBal - $termAmount);
                        $db->query("UPDATE fees_account SET amount='$newBal' WHERE student_id='$stdId'");
                    break;
                    case 'GRADE 2':
                    $stdId = (int)$queryData['id'];
                        $accountBalQuery = $db->query("SELECT * FROM fees_account WHERE student_id='$stdId'");
                        $accountBalQueryData = mysqli_fetch_array($accountBalQuery);
                        $accountBal = $accountBalQueryData['amount'];
                        $foodCharges = get_food_charges($stdId);
                        $termAmount = $grade2 + $foodCharges + $transportCharges;
                        $newBal = ($accountBal - $termAmount);
                        $db->query("UPDATE fees_account SET amount='$newBal' WHERE student_id='$stdId'");
                    break;
                    case 'GRADE 3':
                    $stdId = (int)$queryData['id'];
                        $accountBalQuery = $db->query("SELECT * FROM fees_account WHERE student_id='$stdId'");
                        $accountBalQueryData = mysqli_fetch_array($accountBalQuery);
                        $accountBal = $accountBalQueryData['amount'];
                        $foodCharges = get_food_charges($stdId);
                        $termAmount = $grade3 + $foodCharges + $transportCharges;
                        $newBal = ($accountBal - $termAmount);
                        $db->query("UPDATE fees_account SET amount='$newBal' WHERE student_id='$stdId'");
                    break;
                    case 'GRADE 4':
                    $stdId = (int)$queryData['id'];
                        $accountBalQuery     = $db->query("SELECT * FROM fees_account WHERE student_id='$stdId'");
                        $accountBalQueryData = mysqli_fetch_array($accountBalQuery);
                        $accountBal          = $accountBalQueryData['amount'];
                        $foodCharges = get_food_charges($stdId);
                        $termAmount          = $grade4 + $foodCharges + $transportCharges;
                        $newBal              = ($accountBal - $termAmount);
                        $db->query("UPDATE fees_account SET amount='$newBal' WHERE student_id='$stdId'");
                    break;
                    case 'GRADE 5':
                    $stdId = (int)$queryData['id'];
                        $accountBalQuery = $db->query("SELECT * FROM fees_account WHERE student_id='$stdId'");
                        $accountBalQueryData = mysqli_fetch_array($accountBalQuery);
                        $accountBal = $accountBalQueryData['amount'];
                        $foodCharges = get_food_charges($stdId);
                        $termAmount = $grade5 + $foodCharges + $transportCharges;
                        $newBal = ($accountBal - $termAmount);
                        $db->query("UPDATE fees_account SET amount='$newBal' WHERE student_id='$stdId'");
                    break;
                    case 'GRADE 6':
                    $stdId = (int)$queryData['id'];
                        $accountBalQuery = $db->query("SELECT * FROM fees_account WHERE student_id='$stdId'");
                        $accountBalQueryData = mysqli_fetch_array($accountBalQuery);
                        $accountBal = $accountBalQueryData['amount'];
                        $foodCharges = get_food_charges($stdId);
                        $termAmount = $grade6 + $foodCharges + $transportCharges;
                        $newBal = ($accountBal - $termAmount);
                        $db->query("UPDATE fees_account SET amount='$newBal' WHERE student_id='$stdId'");
                    break;
                    case 'CLASS 5':
                    $stdId = (int)$queryData['id'];
                        $accountBalQuery = $db->query("SELECT * FROM fees_account WHERE student_id='$stdId'");
                        $accountBalQueryData = mysqli_fetch_array($accountBalQuery);
                        $accountBal = $accountBalQueryData['amount'];
                        $foodCharges = get_food_charges($stdId);
                        $termAmount = $class5 + $foodCharges + $transportCharges;
                        $newBal = ($accountBal - $termAmount);
                        $db->query("UPDATE fees_account SET amount='$newBal' WHERE student_id='$stdId'");
                    break;
                    case 'CLASS 6':
                    $stdId = (int)$queryData['id'];
                        $accountBalQuery = $db->query("SELECT * FROM fees_account WHERE student_id='$stdId'");
                        $accountBalQueryData = mysqli_fetch_array($accountBalQuery);
                        $accountBal = $accountBalQueryData['amount'];
                        $foodCharges = get_food_charges($stdId);
                        $termAmount = $class6 + $foodCharges + $transportCharges;
                        $newBal = ($accountBal - $termAmount);
                        $db->query("UPDATE fees_account SET amount='$newBal' WHERE student_id='$stdId'");
                    break;
                    case 'CLASS 7':
                    $stdId = (int)$queryData['id'];
                        $accountBalQuery = $db->query("SELECT * FROM fees_account WHERE student_id='$stdId'");
                        $accountBalQueryData = mysqli_fetch_array($accountBalQuery);
                        $accountBal = $accountBalQueryData['amount'];
                        $foodCharges = get_food_charges($stdId);
                        $termAmount = $class7 + $foodCharges + $transportCharges;
                        $newBal = ($accountBal - $termAmount);
                        $db->query("UPDATE fees_account SET amount='$newBal' WHERE student_id='$stdId'");
                    break;
                    case 'CLASS 8':
                    $stdId = (int)$queryData['id'];
                        $accountBalQuery = $db->query("SELECT * FROM fees_account WHERE student_id='$stdId'");
                        $accountBalQueryData = mysqli_fetch_array($accountBalQuery);
                        $accountBal = $accountBalQueryData['amount'];
                        $foodCharges = get_food_charges($stdId);
                        $termAmount = $class8 + $foodCharges + $transportCharges;
                        $newBal = ($accountBal - $termAmount);
                        $db->query("UPDATE fees_account SET amount='$newBal' WHERE student_id='$stdId'");
                    break;
                    default:
                    $errors[].= '<b>Error! </b>Something went wrong trying to compute student finance.'; displayErrors($errors);
                }                        
            endwhile;
            $messages[].='<b>Success! </b>Student accounts have been credited.'; displayMessages($messages);
        }else{
            $errors[].='<b>Error!</b> This action can only be performed when school is in session.Check term dates to ensure the school is not on holiday';
            displayErrors($errors);
        }
    }else if($feesSet ==0){
        $errors[].='<b>Critial Error!</b> Fees for this year has not been set';
        displayErrors($errors);
    }                   
}//closing submit button

function get_food_charges($studentId){
    global $db;
    global $configurationData;
    $charges      = 0;
    $studentQuery = $db->query("SELECT `id`,`food` FROM `students` WHERE `id`='{$studentId}'");
    $studentData  = mysqli_fetch_array($studentQuery);
    //check if the student is eligible for food from the school
    if($studentData['food']=="YES"):
        $foodQuery        = $db->query("SELECT * FROM `food_programme` WHERE `student_id`='{$studentId}'");
        $foodData         = mysqli_fetch_array($foodQuery);
        $foodChargesArray = json_decode($configurationData['food_charges'],true);//gets the charges for several meals within the school
        $paymentArray     = json_decode($foodData['payment_for'],true);//gets an array of the meals the student has subscibed for
        $morning_snack    = (($paymentArray['MORNING_SNACK']=="TRUE")?$foodChargesArray['MORNING_SNACK']:0);
        $lunch            = (($paymentArray['LUNCH']=="TRUE") ? $foodChargesArray['LUNCH'] : 0);
        $evening_snack    = (($paymentArray['EVENING_SNACK']=="TRUE")? $foodChargesArray['EVENING_SNACK'] : 0);
        $charges          = ($morning_snack + $lunch + $evening_snack);
    endif;
    return $charges;
}
?>
        
        <div vlass="form-group">
            <form action="finance.php?assignfees=1" method="POST">
                <div class="form-group">
                    <button type="submit" class="form-control btn-primary" name="submitBtn">Click to compute fees.</button>
                </div>
            </form>
        </div>

    </div><!--Closing div hosting the button--> 

</div><!--cLOSING ASSIGNFEESDIV-->