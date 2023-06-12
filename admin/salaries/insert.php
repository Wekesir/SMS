<?php
require_once $_SERVER['DOCUMENT_ROOT'].'/school/core/init.php';
                $staffId = (int)((isset($_REQUEST['searchstaff'])?$_REQUEST['searchstaff'] :''));///staff ID from the URL

                $date = date('Y-m-d');

                $accountsQuery = $db->query("SELECT * FROM staff_accounts WHERE staff_id =$staffId");
                $staffQuery    = $db->query("SELECT * FROM users WHERE id=$staffId");

                $staffData        = mysqli_fetch_array($staffQuery);
                $staffAccountData = mysqli_fetch_array($accountsQuery);

                $cashInAccount    = $staffAccountData['amount'];//gets the vurrent amount in the staff aschool account

                $details     = clean(((isset($_POST['details'])? $_POST['details'] : '')));
                $amount      = clean(((isset($_POST['amount'])? $_POST['amount'] : '')));


                if(empty($details) || empty($amount)){
                    $errors[].='<b>Error! </b>Provide info marked *';
                }

                if(!empty($errors)){
                   echo displayErrors($errors);
                }else{
                    $newAmount = ($cashInAccount - $amount);//gets the amount already in the account and subtracts the new amount
                    $db->query("INSERT INTO staff_invoices(staff_id,details,amount,date) VALUES('$staffId','$details','$amount','$date')");
                    $db->query("UPDATE staff_accounts SET amount='$newAmount' WHERE staff_id='$staffId'");

                    $messages[].='<b>Success! </b>Data updated successfully.';
                    if(!empty($messages)){
                        echo displayMessages($messages);
                    }

                }
?>