<?php
$year = date("Y");

/**
 **************THIS SCRIP RUNS TO CHECK THE FOLLOWING
 * if school fees for the current year has been set
 * If term dates for the new year have been set
 * If students have been upgraded to the next level
 * If the system licence is about to expire
 */

$checkFeesCount = mysqli_num_rows($db->query("SELECT * FROM `school_fees` WHERE `year`='$year'"));//checks whether the school fees for this year has been set and hides the setfees menu item

if($checkFeesCount == 0){//meaning if the school fees has not been set

}


/********CHECK DATES *******************/
$checkDates = mysqli_num_rows($db->query("SELECT * FROM `term_dates` WHERE `year`='$year'"));

if($checkDates == 0){//meaning if the dates are not set 

}

/////FECTH ALL DATA FROM CONFIGRATION TABLE IN DB

$configurationData = mysqli_fetch_array($db->query("SELECT * FROM `system_configuration`"));

if($configurationData['student_upgrade'] == 0){

}
?>