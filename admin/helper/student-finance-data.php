<?php
require_once $_SERVER['DOCUMENT_ROOT'].'/school/core/init.php';

if(isset($_POST['student_finance'])):
    $fetch_name =   clean($_POST['student_finance']);   
    $query      =   $db->query("SELECT * FROM `students` WHERE `stdname` LIKE '%".$fetch_name."%' LIMIT 10");
    ob_start();
    if(mysqli_num_rows($query)==0):
        $info[].="<b>Oops!</b> No records found.";
        echo displayInfo($info);
    else:
        ?>
        <table class="table table-hover table-sm">
        <thead class="thead-light">
            <tr> 
            <th scope="col"></th>
            <th scope="col">UPI NO.</th>
            <th scope="col">NAME</th>
            <th scope="col">LEVEL</th>
            </tr>
        </thead>
        <tbody>
            <?php $count=1;  while($queryData=mysqli_fetch_array($query)) : ?> 
            <tr>
            <input type="hidden" value="<?=$queryData['id']?>">
            <th scope="row"><?=$count;?></th>
            <td><?=$queryData['registration_number']?></td>
            <td><?=highlightWords($queryData['stdname'],$fetch_name)?></td>
            <td><?=$queryData['stdgrade']?></td>
            </tr>
            <?php $count++; endwhile; ?>
        </tbody>
        </table>
        <?php
    endif;
    echo ob_get_clean();
endif;
?>