<?php
require_once $_SERVER['DOCUMENT_ROOT'].'/school/core/init.php';//connection to the database

/*THIS SCRIPT READS DATES FROM term_dates IN THE SCHOOL DATABASE AND CHECKS FOR THE FOLLOWING
* Checks whether term dates have been set in the database and if yes...
* Checks whether the current date is between opening and closing dates of terms 1, 2 & 3
* If the above is true, then the current term is echod out and if not..
*/


global $db;
$currentPeriod='';
$year=date('Y');
$currentDate=date('Y-m-d');
$dateQuery=$db->query("SELECT * FROM term_dates WHERE year='$year'");

if(mysqli_num_rows($dateQuery) == 0){//if there is not any data for this year's school dates

}else if(mysqli_num_rows($dateQuery) > 0){//if we have actually found data for this year's school dates

    $dateQueryData=mysqli_fetch_array($dateQuery);

    $term1Decoded=json_decode($dateQueryData['term1'],true);//decodes the associative array for data from database
    $term2Decoded=json_decode($dateQueryData['term2'],true);//decodes the associative array for data from database
    $term3Decoded=json_decode($dateQueryData['term3'],true);//decodes the associative array for data from database

    foreach($term1Decoded as $date){
        $term1opening = $date['openingDate'];//assigns the value frm the associative array into defined variables.
        $term1closing = $date['closingDate'];//assigns the value frm the associative array into defined variables.
    }
    foreach($term2Decoded as $date){
        $term2opening = $date['openingDate'];//assigns the value frm the associative array into defined variables.
        $term2closing = $date['closingDate'];//assigns the value frm the associative array into defined variables.
    }
    foreach($term3Decoded as $date){
        $term3opening = $date['openingDate'];//assigns the value frm the associative array into defined variables.
        $term3closing = $date['closingDate'];//assigns the value frm the associative array into defined variables.
    }

    //THE FOLLOWING CODE GIVES THE CURRENT TERM BASED ON THE TERM DATES SET IN THE DATABASE
    if($currentDate >= $term1opening && $currentDate <=$term1closing){//checks for the current date abd does a comparison with term 1 opening and closing dates
        $currentPeriod='Term 1';
    }else if($currentDate >= $term2opening && $currentDate <=$term2closing){//checks for the current date abd does a comparison with term 2 opening and closing dates
        $currentPeriod='Term 2';
    }else if($currentDate >= $term3opening && $currentDate <=$term3closing){//checks for the current date abd does a comparison with term 3 opening and closing dates
        $currentPeriod='Term 3';
    }else{
        $currentPeriod='Holiday';
    }

    

}
?>