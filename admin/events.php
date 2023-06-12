<!DOCTYPE html>
<html>
    <head>
        <?php 
        require_once $_SERVER['DOCUMENT_ROOT'].'/school/core/init.php';
        include '../admin/header.php';
        include '../admin/navigation.php'; ?>
    </head>
    <body>
        <div class="container-fluid">

            <div class="row">

                <div class="col-md-3">
                    <?php include '../admin/left.php';?>
                </div><!--Closing col-md-3 div-->

                <div class="col-md-9" id="wrapper">                                                       

                                    <div class="container-fluid">
                                        <div class="form-group">

                                        <?php if(isset($_GET['add']) || isset($_GET['edit'])){//the back button only display when the add button has been clicked
                                                ?>
                                                <div class="text-left">
                                                 <a href="events.php"><label class="badge bade-pill badge-info"> <i class="fas fa-arrow-circle-left"></i> Back</label></a>
                                                </div>
                                                <?php
                                                 }
                                            ?>
                                            
                                            <div class="text-left">
                                                 <h5><b><?php if(isset($_GET['edit'])){echo 'Edit Selected School News/Event';}else{echo 'School News & Events';}?>.</b></h5>
                                            </div>
                                            
                                         </div>                          
                                       
                                    <?php   
                                                                    

                          if(isset($_GET['add']) || isset($_GET['edit'])){//when the add news buttonn is clicked or the edit button is clciked                                   
                               
                                $headline=strtoupper(clean(((isset($_POST['headline'])? $_POST['headline']:''))));
                                $event=clean(((isset($_POST['event'])? $_POST['event'] : '')));
                                $date_event=clean(((isset($_POST['date'])? $_POST['date'] :'')));
                                
                                if(isset($_GET['edit'])){

                                        $edit_id=(int)((isset($_GET['edit'])?$_GET['edit']:''));
                                        $editQuery=$db->query("SELECT * FROM news WHERE id='$edit_id'");
                                        $editQueryData=mysqli_fetch_array($editQuery);

                                         $headline=strtoupper(clean(((isset($_POST['headline'])? $_POST['headline']:$editQueryData['headline']))));
                                         $event=clean(((isset($_POST['event'])? $_POST['event'] : $editQueryData['news'])));
                                         $date_event=clean(((isset($_POST['date'])? $_POST['date'] :$editQueryData['event_date'])));

                                         
                                    }

                                    if(isset($_POST['updatebtn'])){//when the update button is clicked                                        
                                        
                                        $db->query("UPDATE news SET
                                                     headline='$headline',news='$event', event_date='$date_event' 
                                                     WHERE id='$edit_id'
                                                     ");

                                        $messages[].='<b>Success! </b>Event updated successfully!';
                                            if(!empty($messages)){
                                                displayMessages($messages);
                                            }

                                    }//closing update button

                                        if(isset($_POST['submitnews'])){
                                            
                                            $headline=strtoupper(trim(clean(((isset($_POST['headline'])? $_POST['headline']:'')))));
                                            $event=trim(clean(((isset($_POST['event'])? $_POST['event'] : ''))));
                                            $date_event=trim(clean(((isset($_POST['date'])? $_POST['date'] :''))));
                                            $date= trim(date('Y-m-d H:i:s'));

                                                if(empty($headline) || $news='' || $event_date=''){
                                                    $errors[].='<b>Error! </b>All fields have to be filled.';
                                                }

                                                if(!empty($errors)){
                                                    displayErrors($errors);
                                                }else{   
                                                                                                  
                                                    $db->query("INSERT INTO news 
                                                               (headline,news,date_created,event_date)
                                                                VALUES
                                                               ('$headline','$event','$date','$date_event')");
                                                    $messages[].='<b>Success! </b>School news or event added.';
                                                    
                                                        if(!empty($messages)){
                                                            displayMessages($messages);
                                                        }
                                                
                                                }

                                        }

                                    ?>
                                         

                                        <form action="<?=((isset($_GET['edit'])?'events.php?edit='.$_GET['edit'].'':'events.php?add=1'));?>" method="POST">
                                            
                                            <div class="form-group">                                
                                                <input type="text" placeholder="Enter the news headline here" name="headline" value="<?=$headline;?>" class="form-control">
                                            </div>                                            
                                            <div class="form-group">
                                                <label for="date">Choose date*:</label>
                                                <input type="date" name="date" class="form-control" value="<?=$date_event;?>">
                                            </div>
                                            <div class="form-group">     
                                                <label for="event">Enter details of the news or event:</label>                                          
                                               <textarea name="event" id="event" class="form-control" rows="8" placeholder="Enter the description of the news here" value="<?=$event;?>" > <?=$event;?> </textarea>
                                            </div>
                                            <div class='form-group'>
                                                <input type="submit" class="btn-primary" name="<?php if(isset($_GET['edit'])){echo 'updatebtn';}else{echo 'submitnews';}?>" value="<?php if(isset($_GET['edit'])){echo 'Update Event';}else{echo 'Submit';}?>">
                                            </div>

                                        </form>
                                    </div><!--Closing container-fluid div-->

                                <?php
                            }else{//THIS CONDITTION APPLIES WHEN THE ADD NEW BUTTON OR EDIT BUTTONS HAVE NOT BEEN CLICKED
                        ?>

                        <div><!--Div for adding a new evrnt/news-->
                              <a href="events.php?add=1">
                                  <label class="small_font" title="Click to add new school news/event." style="background-color:#dcdcdc;color:black;"> 
                                    Create new event/news. 
                                    </label>
                                </a>
                         </div>    

                         <!--CODE FOR DELETING EVENTS USING MODAL-->
                         <?php
                            if(isset($_GET['deleteEvent'])){

                                $deleteEventId=(int)$_GET['deleteEvent'];
                                $db->query("DELETE FROM news WHERE id='$deleteEventId'");
                                $messages[].='<b>Success! </b>Event deleted from database.';
                                if(!empty($messages)){
                                    displayMessages($messages);
                                }

                            }
                         ?>                   

                            

                        <table class="table table-bordered table-highlight table-sm">
                            <thead class="thead-light">
                                <th>#</th>                                
                                <th>HEADLINE</th>
                                <th>NEWS/EVENT</th>
                                <th>EDIT</th>
                                <th>DELETE</th>     
                            </thead>
                            <tbody>
                                 <?php
                                     $counter=1;
                                     $newsQuery=$db->query("SELECT * FROM news ORDER BY id DESC");
                                     while($newsdata=mysqli_fetch_array($newsQuery)) :
                                 ?>
                                <tr>
                                    <td><?=$counter;?></td>
                                    <td><?=$newsdata['headline']?></td>
                                    <td><?=$newsdata['news'];?></td>                    
                                    <td><a href="events.php?edit=<?=$newsdata['id'];?>" class="text-primary"><i class="fas fa-pencil-alt"></i> edit</a></td>
                                    <td><a class="deleteEvent text-danger" id="<?=$newsdata['id'];?>"><i class="fas fa-trash"></i> Delete</a></td>
                                </tr>
                                     <?php
                                      $counter++;
                                      endwhile;?>
                            </tbody>
                        </table>                                 
                                 
                </div><!--Closing col-md-9 div-->
            </div><!--Closing row div-->
        </div><!--closing container-fluid div-->
    </body>
        <?php } include '../admin/footer.php';?>
</html>
<script>
jQuery(document).ready(function(){

    jQuery('.deleteEvent').click(function(){

        var delete_id=jQuery(this).attr("id");

        jQuery.ajax({
            url:'/school/modals/deleteschoolevent.php',
            method:'post',
            data:{delete_id,delete_id},
            success:function(data){
                jQuery("body").append(data);
                jQuery('#deleteeventModal').modal("show");
            },
            error:function(){
                alert("Something went wrong trying delete event");
            },
        });
        
    });    

});//end of the document ready function

    function closeModal(){
        jQuery('#deleteeventModal').modal("hide");
        window.location='/school/admin/events.php';
    }
</script>



