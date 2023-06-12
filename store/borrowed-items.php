<?php
$query = $db->query("SELECT * FROM `issueitems` ORDER BY id DESC");
$count = 1;

if(mysqli_num_rows($query) == 0):
    $info[].='<b>Info!</b>  Borrowed items will appear here.';
    echo displayInfo($info);
else:
?>

    <table class="table-bordered table table-sm table-hover">
        <thead class="thead-light">
            <th>#</th>
            <th>ITEMS</th>
            <th>VIEW iTEM(S)</th>
            <th>ISSUE TO.</th>
            <th>TYPE</th>
            <th>RETURNABLE?</th>
            <th>DATE</th>
        </thead>
        <tbody>
            <?php while($data = mysqli_fetch_array($query)) :?>                
            <tr>
                <td><?=$count?></td>
                <td><?= count(json_decode($data['items']),true).' item(s).';?></td>
                <td><a href="#" class="btn btn-info btn-sm viewBtn" id="<?=$data['id'];?>">View</a></td>
                <td id="receipientName">
                    <?php
                        if($data['recipient'] == 'STUDENT'){
                            $studentId  = (int)$data['recipient_Id'];
                            $recipientQ = mysqli_fetch_array($db->query("SELECT * FROM students WHERE id='$studentId'"));
                            $name       = $recipientQ['stdname'];
                        }else if($data['recipient'] == 'STAFF'){
                            $staffId    = (int)$data['recipient_Id'];
                            $recipientQ = mysqli_fetch_array($db->query("SELECT * FROM users WHERE id='$staffId'"));
                            $name       = $recipientQ['name'];
                        }
                        echo $name;
                    ?>
                </td>
                <td><?=$data['recipient'];?></td>
                <td><?=$data['returnable'];?></td>
                <td><?=date("jS F, Y", strtotime($data['issueDate']));?></td>
            </tr>
            <?php $count++; endwhile;?>
        </tbody>
    </table>

<?php endif;?>

<style>
#showitemsDiv{
    padding: 20px;
    border-radius: 20px;
    position:absolute;
    top: 20vh;
    left: 30%;
    width:40%;
    background:white; 
    min-height:50vh;
    max-height: 70vh;
    overflow-y:auto;
    box-shadow: 0 4px 8px 0 rgba(0, 0, 0, 0.2), 0 6px 20px 0 rgba(0, 0, 0, 0.19);
    display:none;
    cursor:pointer;
}

#returnItemsDiv{
    padding: 20px;
    border-radius: 20px;
    position:absolute;
    top: 20vh;
    right: 5%;
    width:20%;
    background:white; 
    min-height:30vh;
    max-height: 40vh;
    box-shadow: 0 4px 8px 0 rgba(0, 0, 0, 0.2), 0 6px 20px 0 rgba(0, 0, 0, 0.19);
    display:none;
    cursor:pointer;
}

</style>

<div id="showitemsDiv"></div>

<div id="returnItemsDiv">
    <form action="#" method="post">
        <div class="form-group">
            <label for="">Total quantity borrowed</label>
            <input type="number" class="form-control" id="borrowedQty" readonly>
        </div>
        <div class="form-group">
            <label for="">How many returned?</label>
            <input type="number" min=1 class="form-control" id="returnedQty" required=required>
        </div>
        <div class="form-group">
            <input type="submit" class="btn btn-primary btn-sm" value="Submit">
        </div>
    </form>
</div>

<script>
var returnItemsDiv = $('#returnItemsDiv');
var showItemsDiv   = $('#showitemsDiv');

function closeWindow(){   
    showItemsDiv.fadeOut("slow");
    returnItemsDiv.fadeOut('slow');
}


jQuery('.viewBtn').click(function(event){
    event.preventDefault();
    var showitemsId = $(this).attr("id");
    $.ajax({
        url:'/school/store/fetch.php',
        method:'post',
        data:{showitemsId:showitemsId},
        success:function(data){
             showItemsDiv.html(data);
             showItemsDiv.fadeIn("slow");
             $('#showitemsDiv .close').css({//styles the button close button in the popup
                "position":"absolute",
                "top":"5%",
                "right":"5%",
                "box-shadow": "0 4px 8px 0 rgba(0, 0, 0, 0.2), 0 6px 20px 0 rgba(0, 0, 0, 0.19)"
             });

             $('.returnItemsBtn').click(function(e){//the return itms button for returning borrowed items
                e.preventDefault();
                returnItemsDiv.fadeIn('slow');
                var returnItemId = $(this).attr("data-returnitemId"); //item id of the borrowed id
                var borrowedQty  = $(this).attr("data-borrowedQty");//total quantity that was borrowed
                var databaseId   = $(this).attr("data-databaseId");//database id for that entry

                returnItemsDiv.find("#borrowedQty").val(borrowedQty);//inserts the value of the borrowed qty in the filed                

                returnItemsDiv.find("form").submit(function(e){//when the submit button has been clicked
                    e.preventDefault();
                    var returnedQty = returnItemsDiv.find("#returnedQty").val();//how much of the borrowed item is being returned

                    var itemData = {//object holding item data
                        databaseId  : databaseId,
                        itemId      : returnItemId,
                        borrowedQty : borrowedQty,
                        returnedQty : returnedQty
                    };
                     
                    $.ajax({
                        url:'/school/store/return-item.php',
                        method:'post',
                        data:itemData,
                        success:function(data){
                           alert(data);
                           //location.reload(true);
                        },
                        error:function(){
                            alert("Error occured trying to return item(s).");
                        }
                    });
                    
                });
            });

        },
        error:function(){
            alert('Something went wrong trying to show items');
        }
    });
    $('#showitemsDiv').fadeIn("slow");
});
</script>