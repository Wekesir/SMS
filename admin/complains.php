<!DOCTYPE html>
<html>
<head>
    <?php
        require_once $_SERVER['DOCUMENT_ROOT'].'/school/core/init.php';
        include '../admin/header.php';?>
</head>
<body>   
    <?php include '../admin/navigation.php';?>
 <div class="container-fluid">
    <div class="row">
        <div class="col-md-3">
            <?php include '../admin/left.php';?>
        </div><!--Closing col-md-3 div-->
        <div class="col-md-9" id="wrapper">         
          <?php
          $count = 1;
          $complainQuery = $db->query("SELECT users.name,complains.id AS 'complain_id',complains.details,complains.status,complains.submitted_on
                                       FROM users, complains 
                                       WHERE users.id=submitted_by");    


        /****************MARKING AS READ ************************8********/      
        if(isset($_GET['read'])){
            $readId = (int)$_GET['read'];
            $db->query("UPDATE complains SET status=1 
                        WHERE id='$readId'");
            $messages[].='<b>Success!</b>Complain marked as read.';
            if(!empty($messages)){
                displayMessages($messages);
            }
        }
        /***************CODE FOR MARKING AS READ ENDS HERE***************/

         /****************DELETING COMPLAIN ************************8********/   
            if(isset($_GET['delete'])){
                $deleteId =(int)$_GET['delete'];
                $db->query("DELETE FROM complains WHERE id='$deleteId'");
                $messages[].='<b>Success! </b>Complain deleted.';
                if(!empty($messages)){
                    displayMessages($messages);
                }
            }
          /***************CODE FOR DELETIN G COMPLAIN ENDS HERE***************/   
          ?>

          <table class="table-striped table-bordered small_font table-highlight full-length">
            <thead>
                <th>#</th>
                <th>Complain</th>
                <th>Submitted By:</th>
                <th>Submitted On</th>
                <th>Status</th>
                <th>Actions</th>
            </thead>
            <tbody>
            <?php while($complainArray = mysqli_fetch_array($complainQuery)) :?>
                <tr>
                    <td class="text-center"><?=$count;?></td>
                    <td><?=$complainArray['details'];?></td>
                    <td><?=$complainArray['name'];?></td>
                    <td><?=$complainArray['submitted_on'];?></td>
                    <td>
                        <?php if($complainArray['status'] == 0){
                            echo '<label class="text-success">Unread</label>';
                        }else{
                            echo '<label class="text-defaults">Read.</label>';
                        }
                            ?>
                    </td>
                    <td>
                    <a href="complains.php?read=<?=$complainArray['complain_id'];?>"><button class="bg-primary" style="color:white;">Mark as read</button></a>
                    <a href="complains.php?delete=<?=$complainArray['complain_id'];?>"><button class="bg-danger" style="color:white;">Delete</button></a>
                    </td>
                </tr>
             <?php 
            $count++;
            endwhile;?>
            </tbody>
          </table>
          
        </div><!--Closing col-md-9 div-->
    </div><!--Closing row dic-->
 </div><!--closing container div-->
    <?php include '../admin/footer.php';?>
</body>
</html>
