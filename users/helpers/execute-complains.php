<?php
require_once $_SERVER['DOCUMENT_ROOT'].'/school/core/init.php';
//requesting data starts here
if(isset($_POST['request'])):
    ob_start();    
    $userid        = (int)$_SESSION['user'];//sessio of the current logged in user
    $complainQuery = $db->query("SELECT * FROM complains WHERE submitted_by='$userid' ORDER BY id DESC");
    $count         = 1;

    if(mysqli_num_rows($complainQuery)==0){//when the query finds no data in database
        $info[].="<b>Oops! </b>Seems like you have not submitted any complains yet!";
        echo displayInfo($info);
    }

    while( $complainArray = mysqli_fetch_array($complainQuery)):?>
        <tr>
            <td><?=$count;?></td>
            <td><?=$complainArray['subject'];?></td>
            <td><?=$complainArray['details'];?></td>
            <td><?=(($complainArray['status'] == 1? 'Read':'Unread'));?></td>
            <td><?=date("jS F, Y", strtotime($complainArray['submitted_on']));?></td>
            <td>
                <button class="btn text-danger deleteComplainBtn" data-complainId="<?=$complainArray['id'];?>"><i class="fas fa-trash-alt"></i> Delete</button>
            </td>
        </tr>
        <?php
        $count++;
    endwhile;
    echo ob_get_clean();
endif;
//requesting data ends here

//code for deleting a compliment from database
if(isset($_POST['delComplainId']) && !empty($_POST['delComplainId'])){
    $deleteId = (int)clean($_POST['delComplainId']);
    $db->query("DELETE FROM complains WHERE id='$deleteId'");
    $messages[].='<b>Success! </b>Complain deleted.';
        if(!empty($messages)){
            echo displayMessages($messages);
        }
}
?>