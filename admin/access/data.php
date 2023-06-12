<?php
    require_once $_SERVER['DOCUMENT_ROOT'].'/school/core/init.php';//database connection

    if(isset($_REQUEST['permissionData'])){//requesting the persmissions data from database
        $staffQ       = $db->query("SELECT id, name, class_assigned, permissions FROM users WHERE deleted=0 AND id!=1 ORDER BY id DESC");
        $staffCount   = mysqli_num_rows($staffQ);

        if($staffCount == 0){//checks whether the query returns any data
            $info[].='<b>Oops! </b>Seems like no staff members were found in database.'; echo displayInfo($info);
        }else{
            $count=1;
            ob_start();
            while($queryData = mysqli_fetch_array($staffQ)):
                  $gradeQ    = $db->query("SELECT * FROM `grade` ORDER BY id ASC");
                  $accessQ   = $db->query("SELECT * FROM `access_levels` ORDER BY id ASC");
            ?>

                <tr id="row".<?=$count?>"">
                    <td><?=$count;?></td>
                    <td><?=$queryData['name']?></td>
                    <td>
                        <form action="#" method="POST" id="classForm<?=$count?>">
                        <ul>
                            <?php
                            $getClassArray =explode(',',rtrim($queryData['class_assigned'],','));//gets all the class of this user
                            while($gradeData = mysqli_fetch_array($gradeQ)): ?>
                                <li>
                                    <input type="checkbox" name="<?=$count;?>" value="<?=$gradeData['grade']?>" <?=((in_array($gradeData['grade'],$getClassArray))?'checked':'')?>> <?=$gradeData['grade']?>
                                </li>
                             <?php endwhile; ?>
                        </ul>                       
                        <button type="submit" class="btn btn-sm btn-primary classBtnSubmit"data-userId="<?=$queryData['id'];?>" data-btnRowId="<?=$count?>">Done</button>
                        </form>
                    </td>
                    <td>
                        <form action="#" method="post" id="accessForm<?=$count?>">
                        <ul>
                            <?php 
                             $getAccessArray =explode(',',rtrim($queryData['permissions'],','));//gets all the class of this user
                            while($accessData = mysqli_fetch_array($accessQ)): ?>
                                <li>
                                    <input type="checkbox" name="<?=$count;?>" value="<?=$accessData['access_level']?>" <?=((in_array($accessData['access_level'],$getAccessArray))?'checked':'');?>> <?=$accessData['access_level']?>
                                </li>
                            <?php endwhile; ?>
                        </ul>
                        <button type="submit" class="btn btn-sm btn-primary accessBtnSubmit"data-userId="<?=$queryData['id'];?>" data-btnRowId="<?=$count?>">Done</button>
                        </form>
                    </td>
                </tr>

                <?php 
                $count++;
            endwhile;
            echo ob_get_clean();
        }
    }
    
?>

<script>
jQuery('.accessBtnSubmit').click(function(e){
    e.preventDefault();
    var rowId = jQuery(this).attr("data-btnRowId");
    var userId = jQuery(this).attr("data-userId");
    var accessData = '';
    jQuery('#accessForm'+rowId).find("ul > li input[type=checkbox]").each(function(){
        if($(this).is(":checked")){
            accessData += $(this).val()+',';
        };
    });
    var allData = {
        action: 'access',
        employee_id : userId,
        accessData   : accessData
    }
    jQuery.ajax({
        url:'/school/admin/access/set-access.php',
        method:'post',
        data:allData,
        success:function(data){
            alert(data);
        },
        error:function(){
            alert("Something went wrong trying to set access level(s)");
        }
    });
    
});
jQuery('.classBtnSubmit').click(function(e){
    e.preventDefault();
    var rowId = jQuery(this).attr("data-btnRowId"); 
    var userId = jQuery(this).attr("data-userId");
    var classData = '';
    jQuery("#classForm"+rowId).find("ul > li input[type=checkbox]:checked").each(function(){
        if($(this).is(':checked')){
            classData += $(this).val()+',';
        };
    });
    var allData = {
        action:'class',
        employee_id : userId,
        classData   : classData
    }
   jQuery.ajax({
       url:'/school/admin/access/set-access.php',
       method:'post',
       data:allData,
       success:function(data){
        alert(data);
       },
       error:function(){
           alert("Something went wrong trying to set classes");
       }
   });
});
</script>

<style>
ul li{
    list-style:none;
}
</style>
