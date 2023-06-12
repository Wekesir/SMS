<?php
require_once $_SERVER['DOCUMENT_ROOT'].'/school/core/init.php';
if(isset($_POST['resetDb']) && $_POST['resetDb']==''){
    $result = $db->query("show tables");
        while($tableObject = mysqli_fetch_array($result)){
            $tableName = $tableObject[0];
            if($tableName != "system_configuration"||$tableName != "grade"):
                if($tableName=="users"){//checking to see the users table
                    $db->query("DELETE FROM $tableName WHERE id !=1");
                    $db->query("ALTER TABLE $tableName AUTO_INCREMENT=2");
                }else{
                    $db->query("DELETE FROM $tableName");
                    $db->query("ALTER TABLE $tableName AUTO_INCREMENT=1");
                }
            endif;
        };
    $info[].='<b>Info! </b>Tables have been reset.'; echo displayinfo($info);
}
?>