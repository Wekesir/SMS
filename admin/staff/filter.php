<?php
require_once $_SERVER['DOCUMENT_ROOT'].'/school/core/init.php';//database connection

$gender = clean(((isset($_POST['genderFilter'])?$_POST['genderFilter']:'')));
$level  = clean(((isset($_POST['accessFilter'])?$_POST['accessFilter']:'')));
$count  = 1;

if(!empty($gender)):
     $query=$db->query("SELECT * FROM `users` WHERE `gender` = '{$gender}' AND `id` != 1");
elseif(empty($gender)):
     $query=$db->query("SELECT * FROM `users` WHERE `deleted`=0 AND `id` !=1 ORDER BY `id` DESC");
endif;

ob_start();
while($empArray=mysqli_fetch_array($query)) : ?>
<tr>     
<td><?=$count;?></td>    
<td><?=$empArray['name'];?></td>
<td><?=rtrim($empArray['class_assigned'],',');?></td>       
<td class="text-center"><a  href="#" id="<?=$empArray['id'];?>" class="view_staff" title="Click to view staff information."><i class="fas fa-eye"></i> view</a>
<td class="text-center">
<a href="staff.php?edit=<?=$empArray['id'];?>"  title="Click to edit user."><i class="fas fa-pencil-alt"></i> edit</a>
</td>
<td class="text-center">
<a href="#" class="documents" id="<?=$empArray['id'];?>" title="Click to upload/view documents."><i class="fas fa-folder-open"></i> docs</a>
</td>
<td class="text-center"> <a href="#" class="deleteuserbtn text-danger" id="<?=$empArray['id'];?> " title="Click to delete user."><i class="fas fa-trash-alt"></i> delete</a></td>
</tr>
<?php $count++; endwhile; echo ob_get_clean();

if(isset($_POST['staff_name'])):
    $fetch_name = clean(trim(base64_decode($_POST['staff_name'])));      
    if(empty($fetch_name)):
       $query = $db->query("SELECT * FROM `users` WHERE `deleted`=0 AND `id`!=1 ORDER BY `id` DESC"); 
    else:
       $query = $db->query("SELECT * FROM `users` WHERE `name` LIKE '%".$fetch_name."%' AND `id` !=1");
    endif;
    ob_start();
    $count = 1; 
    while($empArray = mysqli_fetch_array($query)): ?>
    <tr>     
        <th><?=$count;?></th>    
        <td><?=$empArray['name'];?></td>
        <td><?=rtrim($empArray['class_assigned'],',');?></td>       
        <td class="text-center"><a  href="#" id="<?=$empArray['id'];?>" class="view_staff" title="Click to view staff information."><i class="fas fa-eye"></i> view</a>
        <td class="text-center">
            <a href="staff.php?edit=<?=$empArray['id'];?>"  title="Click to edit user."><i class="fas fa-pencil-alt"></i> edit</a>
        </td>
        <td class="text-center">
            <a href="#" class="documents" id="<?=$empArray['id'];?>" title="Click to upload/view documents."><i class="fas fa-folder-open"></i> docs</a>
        </td>
        <td class="text-center"> <a href="#" class="deleteuserbtn text-danger" id="<?=$empArray['id'];?> " title="Click to delete user."><i class="fas fa-trash-alt"></i> delete</a></td>
    </tr>
    <?php $count++; endwhile; 
    echo ob_get_clean();
endif;
?>