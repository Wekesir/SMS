<?php
require_once $_SERVER['DOCUMENT_ROOT'].'/school/core/init.php';
?>
<div id="innnerContainer">
<?php 
    $query=$db->query("SELECT * FROM messages ORDER BY id DESC");

    if(isset($_GET['read']) && $_GET['read']!=0){//if the mark as read button is clicked
        $read_id=(int)clean(((isset($_GET['read'])?$_GET['read']:'')));
        $db->query("UPDATE messages SET read_status=1 WHERE id='$read_id'");
    }

    if(isset($_GET['delete_message']) && $_GET['delete_message']!=0){//code for deleting for deleting medssage
        $delete_id=(int)clean(((isset($_GET['delete_message'])?$_GET['delete_message']:'')));
        $db->query("DELETE FROM messages WHERE id='$delete_id'");
        $messages[].='<b>Success</b> Message deleted successfully!';
            if(!empty($messages)){
                displayMessages($messages);
            }
    }

    while($messagesData = mysqli_fetch_array($query)) :?>
        <div id="messageDiv">
            <div id="header">
                <label for=""><b>Name: <?=$messagesData['first_name'];?></b></label>
                <label class="float-right">
                    <label for="">
                        <a href="#"><?=((isset($messagesData['read_status']) && $messagesData['read_status'] == 0 ? '<span class="badge badge-default" title="This message is unread.">Unread</span>' : '<span class="badge badge-default" title="This message ha                               s not been read.">Read</span>' ))?></a>
                        <a href="<?=$_SERVER['PHP_SELF']?>?read=<?=$messagesData['id']?>" class=" badge badge-primary" title="Mark this message as read.">Mark as read.</a>
                        <a href="<?=$_SERVER['PHP_SELF']?>?delete_message=<?=$messagesData['id']?>" class=" badge badge-danger" title="Delete message.">Delete</a>
                    </label>
                </label>
            </div>
            <div id="content">
                <label><?=$messagesData['message'];?></label>
            </div>
            <div id="footer">
                <label class="">Phone Number: <?=$messagesData['phonenumber'];?></label>
                <label class="float-right"><?=$messagesData['message_date'];?></label>
            </div>
        </div>
    <?php endwhile; ?>
</div>
