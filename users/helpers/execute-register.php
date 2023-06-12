<?php
require_once $_SERVER['DOCUMENT_ROOT'].'/school/core/init.php';//database connection file

$level       = "";
if(isset($_POST)){
   $array[] = $_POST;
   foreach($_POST as $x=>$x_value){
      if($x=="level"){
         $level = $x_value;
      }else{ 
         $newArray[] = array(
            'Id'     => $x,
            'Status' => $x_value
         );
      }      
   }
   $date        = date('Y-m-d');  
   $count       = mysqli_num_rows($db->query("SELECT * FROM `studentattendance` WHERE `student_level`='$level' AND `date`='$date'"));
   $inserted_by = (int)$_SESSION['user'];//session of the logged in user

   $attendance = json_encode($newArray);
   $today      = date('D',strtotime(date('Y-m-d')));//returns todays day

   if($today == 'Sun'||$today=='Sat'):
      $info[].='<b>Oops! </b>Student register can not be marked on Saturday or Sunday.';
      echo displayInfo($info);
   else:
      if(in_array(date("d-m"),$holidaysArray,true)):
         $errors[].='<b>Error! </b>School calendar can not be marked during hoidays.';
         echo displayErrors($errors);
      else:
         if($count>0):
            $errors[].='<b>Error! </b>Todays register has already been marked';
            echo displayErrors($errors);
         else:
            $db->query("INSERT INTO studentattendance(attendance, student_level, inserted_by, date) VALUES ('{$attendance}','$level', '$inserted_by' ,'$date')");
            $messages[].='<b>Success! </b>You have marked todays student register.';
            echo displayMessages($messages);
         endif;      
      endif;
   endif;
 
}
?>