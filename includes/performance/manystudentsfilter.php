<style>
#assessmentDiv{
     padding: 10px;
     margin: 10px;
     background: #f8f8f8;
     border-radius: 20px;
}
#assessmentDiv:hover{
      box-shadow: 0 4px 8px 0 rgba(0, 0, 0, 0.2), 0 6px 20px 0 rgba(0, 0, 0, 0.19);
}
#assessmentDiv label{
     margin-right: 10px;
}

</style>
<?php
require_once $_SERVER['DOCUMENT_ROOT'].'/school/core/init.php';//database connection 
global $db;

$oldSystemArray      = array('CLASS 5','CLASS 6','CLASS 7','CLASS 8');
$lowerGradeArray     = array('PLAYGROUP','PP1','PP2');
$upperGradeArray     = array('GRADE 1','GRADE 2','GRADE 3','GRADE 4','GRADE 5','GRADE 6');

if(isset($_POST['studentSearchData'])){
    $level     = $_POST['studentSearchData']['level']; 
    $term      = $_POST['studentSearchData']['term'];
    $year      = $_POST['studentSearchData']['year'];

    if(empty($level) && empty($term) && empty($year)){
        $errors[].='<b>Query error! </b>Make sure atleast one of the fields is selected';
        die(displayErrors($errors));
    }else if(!empty($level) && empty($term) && empty($year)){
          $query=$db->query("SELECT * FROM filterperformance WHERE current_grade='$level' ORDER BY id DESC");
    }else if(!empty($term) && empty($level) && empty($year)){
         $query=$db->query("SELECT * FROM filterperformance WHERE period='$term' ORDER BY id DESC");
    }else if(!empty($year) && empty($level) && empty($term)){
        $query=$db->query("SELECT * FROM filterperformance WHERE year='$year' ORDER BY id DESC");
    }else if(!empty($level) && !empty($term) && empty($year)){
        $query=$db->query("SELECT * FROM filterperformance WHERE current_grade='$level' AND period='$term' ORDER BY id DESC");
    }else if(!empty($level) && empty($term) && !empty($year)){
         $query=$db->query("SELECT * FROM filterperformance WHERE current_grade='$level' AND year='$year' ORDER BY id DESC");
    }else if(empty($level) && !empty($term) && empty($year)){
         $query=$db->query("SELECT * FROM filterperformance WHERE year='$year' AND period='$term' ORDER BY id DESC");
    }else{
          $query=$db->query("SELECT * FROM filterperformance WHERE year='$year' AND period='$term' AND current_grade='$level' ORDER BY id DESC");
    }


    ob_start();

   if(mysqli_num_rows($query) == 0){
        $errors[].='<b>Sorry! </b>No data matching your search was found..';
        die(displayErrors($errors));
   }else{

    while($queryData   = mysqli_fetch_array($query)): ?>

     <div id="assessmentDiv"> 

          <label for=""><b>Name: </b> <?=$queryData['stdname']?></label>
          <label for=""><b>Period: </b> <?=$queryData['period']?></label>
          <label for=""><b>Level: </b> <?=$queryData['current_grade']?></label>
          <label for=""><b>Year: </b> <?=$queryData['year']?> </label>

          <table class="table table-striped table-bordered">
               <thead>
                    <th>SUBJECT</th> <th>ASSESSMENT</th>
               </thead>
               <tbody>
                    <?php  
                    $assessmentDecoded = json_decode($queryData['grades'],true);   

                    if(in_array($queryData['current_grade'],$oldSystemArray,true)){
                         foreach($assessmentDecoded as $assessment){?>
                              <tr>  <td>Mathematics</td> <td><?=$assessment['Mathematics']?></td> </tr>
                              <tr>  <td>English</td> <td><?=$assessment['English']?></td> </tr>
                              <tr>  <td>Kiswahili</td> <td><?=$assessment['Kiswahili']?></td> </tr>
                              <tr>  <td>Science</td> <td><?=$assessment['Science']?></td> </tr>
                              <tr>  <td>Social St. & CRE/IRE</td> <td><?=$assessment['Social Studies & CRE']?></td> </tr>
                         <?php }
                    }else if(in_array($queryData['current_grade'],$lowerGradeArray,true)){
                         foreach($assessmentDecoded as $assessment){?>
                              <tr>  <td>Mathematics</td> <td><?=$assessment['Mathematics']?></td> </tr>
                              <tr>  <td>Language Activities</td> <td><?=$assessment['Language']?></td> </tr>
                              <tr>  <td>Kiswahili</td> <td><?=$assessment['Kiswahili']?></td> </tr>
                              <tr>  <td>Environment Studies</td> <td><?=$assessment['Environment']?></td> </tr>
                              <tr>  <td>Hygiene</td> <td><?=$assessment['Hygiene']?></td> </tr>
                              <tr>  <td>Kusoma</td> <td><?=$assessment['Kusoma']?></td> </tr>
                              <tr>  <td>Reading </td> <td><?=$assessment['Reading']?></td> </tr>
                              <tr>  <td>CRE/IRE</td> <td><?=$assessment['CRE']?></td> </tr>
                         <?php }
                    }else if(in_array($queryData['current_grade'],$upperGradeArray,true)){
                         foreach($assessmentDecoded as $assessment){?>
                              <tr>  <td>Mathematics</td> <td><?=$assessment['Mathematics']?></td> </tr>
                              <tr>  <td>Language Activities</td> <td><?=$assessment['Language']?></td> </tr>
                              <tr>  <td>Environment Studies</td> <td><?=$assessment['Environment']?></td> </tr>
                              <tr>  <td>CRE/IRE</td> <td><?=$assessment['CRE']?></td> </tr>
                              <tr>  <td>Creative Studies</td> <td><?=$assessment['Creative']?></td> </tr>
                         <?php }
                    }
                    ?>
               </tbody>
          </table>
     </div>

    <?php endwhile;

   }

    echo ob_get_clean();
}
?>