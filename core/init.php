<?php
$db = mysqli_connect('localhost','root','','school');
if(mysqli_connect_errno()){
    echo 'Failed to connect to database!'.mysqli_connect_error();
    die();
}

session_start();

require_once $_SERVER['DOCUMENT_ROOT'].'/school/config.php';
require_once BASEURL.'helpers/helpers.php';
require_once BASEURL.'helpers/term-selection.php';
require_once BASEURL.'helpers/getconfigurations.php';

//define the variale that gives the path to IMge files to be added to the TCPDF document
//the K_PATH_IMAGES constant comes from the TCDPF library
define("K_PATH_IMAGES", $_SERVER['DOCUMENT_ROOT']);

//GLOBAL VARIABLES
$errors   = array();
$messages = array();
$info     = array();

$todayDate     = date('Y-m-d');
$todayDateTime = date("Y-m-d H:i:s");

//loads data for the logged inuser and makes it availabke throughout the whole project
if(isset($_SESSION['user'])){
    $id                             =   $_SESSION['user'];
    $userquery                      =   $db->query("SELECT * FROM `users` WHERE `id`='$id'");
    $logged_in_user_data            =   mysqli_fetch_array($userquery);
    $explName                       =   explode(' ',$logged_in_user_data['name']);
    $logged_in_user_data['midname'] =   $explName[1];
    $allowedAccessArray             = array('Super_Admin','Admin');//this array contains permissions for the highesr access levels in the system

}

//holidays
$holidaysArray = array("10-10","20-10","12-12","25-12","01-01","01-05","26-12","01-07");
?>
