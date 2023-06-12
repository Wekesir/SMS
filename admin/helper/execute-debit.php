<?php
require_once $_SERVER['DOCUMENT_ROOT'].'/school/core/init.php';
global $todayDate;

if(isset($_POST['studentId'])){//student id
    $studentId = (int)clean($_POST['studentId']);
    $amount   = clean($_POST['amount']);

    $stdAccQuery = $db->query("SELECT amount FROM fees_account WHERE student_id='{$studentId}'");
    $accData = mysqli_fetch_array($stdAccQuery);

    $accAmount = $accData['amount'];
    $newAmount = ($accAmount-$amount);
    $mode = 'ACCOUNT DEBIT';

    $db->query("UPDATE fees_account SET amount='{$newAmount}' WHERE student_id='{$studentId}'");
    $db->query("INSERT INTO `fees_invoices`(`student_id`, `amount`, `mode`, `date`) VALUES ('$studentId','$newAmount','$mode','$todayDate')");

    echo 'Account has been debited successfully!';
}

if(isset($_POST['staffId'])){
    $staffId = (int)clean($_POST['staffId']);//staff id
    $amount  = clean($_POST['debitAmount']);//amoint being debited

    $accountQuery = mysqli_fetch_array($db->query("SELECT * FROM staff_accounts WHERE staff_id='{$staffId}'"));
    $damages = $accountQuery['damages'];//amount in the staff account
    $newAmt = ($damages+$amount);
    $details = "ACCOUNT DEBIT";
    $db->query("UPDATE staff_accounts SET damages='$newAmt' WHERE staff_id='{$staffId}'");
    $db->query("INSERT INTO staff_invoices (staff_id,details,amount,date) vALUES ('$staffId','$details','$amount','$todayDate')");

    echo 'Account has been debited successfully!';
}
?>