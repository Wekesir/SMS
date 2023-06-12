<?php
require_once $_SERVER['DOCUMENT_ROOT'].'/school/core/init.php';

if(isset($_POST['searchSubject']))://when a request to find a certain subject has been made
    $subject = clean(trim($_POST['searchSubject']));
    if(empty($subject))://if the request made is empty
        $subjectQuery = $db->query("SELECT * FROM `subjects` ORDER BY `subject_name`");
    else:
        $subjectQuery = $db->query("SELECT * FROM `subjects` WHERE `subject_name` LIKE '%".$subject."%' ORDER BY `subject_name`");
    endif;
    //check whether the query returns sny results from the database
    if(mysqli_num_rows($subjectQuery)>0):
        ob_start();
        $count=1;
        while($subjectData = mysqli_fetch_array($subjectQuery)) :?>
            <tr>
            <th scope="row"><?=$count?></th>
            <td><?=$subjectData['subject_name']?></td>
            <td><?='('.count(json_decode($subjectData['levels'])).') level(s).'?> <button class="btn btn-sm btn-default float-right viewLevelsBtn" data-subjectId="<?=$subjectData['id']?>" title="view levels offering this subject."><i class="fas fa-eye"></i> view.</button> </td>
            <td>
                <a class="btn btn-sm btn-outline-primary" href="/school/admin/subjects.php?edit-subject-entry=<?=$subjectData['id']?>"><i class="fas fa-pencil-alt"></i> edit.</a>
                <button class="btn btn-sm btn-danger deleteBtn" data-deleteId="<?=$subjectData['id']?>"><i class="far fa-trash-alt"></i> delete.</button>
            </td>
            </tr>
        <?php $count++; endwhile; echo ob_get_clean();
    endif;
    $db->close();
endif;
?>