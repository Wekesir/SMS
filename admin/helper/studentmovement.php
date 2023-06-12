<?php
require_once $_SERVER['DOCUMENT_ROOT'].'/school/core/init.php';//database connection
global $db; //variable that connects with the database

if(isset($_REQUEST['move_students'])){//if data has been posted to this page
    $accomplishedYear = (date("Y")-1);
    $gradeQuery   = $db->query("SELECT * FROM `grade` ORDER BY `id`");
    $studentQuery = $db->query("SELECT `id`, `stdgrade`, `level` FROM `students` WHERE `accomplished`=0 AND `deleted`=0");
    $gradeArray   = array();

    while($grade= mysqli_fetch_array($gradeQuery)):
        $gradeArray[].= $grade['grade'];//all the levels offered in the school
    endwhile;

    $loopCount = count($gradeArray);//total number of the levels in the school
    while($x=mysqli_fetch_array($studentQuery))://looping through the total number of students in the school
        $studentId = $x['id'];
        $nextLevel = 1;
        for($y=0;$y<$loopCount;$y++):
            if($x['stdgrade'] == $gradeArray[$y]):
                if($nextLevel == ($loopCount))://if the student is in the highest level in the school
                    $db->query("UPDATE `students` SET `accomplished`=1, `accomplished_year`='{$accomplishedYear}' WHERE `id`='{$studentId}'");
                elseif($nextLevel < ($loopCount)):
                    $db->query("UPDATE `students` SET `stdgrade`='%".$gradeArray[$nextLevel]."%' WHERE `id`='{$studentId}'");
                endif;
                break;
            endif;
            $nextLevel++;
        endfor;
    endwhile;
    $db->close();
    $messages[].='<b>Success! </b>Students have all been upgraded to next levels.';
    echo displayMessages($messages);
}

?>