<?php
$groupId = "";
$group   = "";
if(isset($_REQUEST['editGroup'])){
    $groupId = (int)$_REQUEST['editGroup'];   
    $groupQ  = $db->query("SELECT `contact_group` FROM `contact_groups` WHERE `id`='$groupId'");
     $row    = mysqli_fetch_array($groupQ); 
     $group  = $row['contact_group'];
}
?>
<table class="table table-striped table-bordered table-sm">
    <thead class="thead-light">
        <th>#</th>
        <th>GROUP NAME</th>
        <th>ACTIONS</th>
    </thead>
    <tbody>
    <?php
    $count=1;
    $groupQ = $db->query("SELECT * FROM contact_groups ORDER BY contact_group");
    while($row = mysqli_fetch_array($groupQ)) : ?>
    <tr>
        <td><?=$count;?></td>
        <td><?=$row['contact_group'];?></td>
        <td>
            <a href="#" class="text-primary editGroup"  id="<?=$row['id'];?>"><i class="fas fa-pencil-alt"></i> edit</a>
            <a href="#" class="text-danger deleteGroup" id="<?=$row['id'];?>"><i class="fas fa-trash-alt"></i> delete</a>
        </td>
    </tr>
    <?php $count++; endwhile;?>
    </tbody>
</table>

<button id="addGroupBtn" class="btn btn-primary" title="Add Contact Group"><i class="fas fa-plus"></i></button>

<div id="contactGroupDiv" class="<?=((isset($_REQUEST['editGroup']))?'d-block':'d-none')?>">
    <h6 class="text-center"><?=((isset($_REQUEST['editGroup']))?'EDIT':'ADD NEW')?> CONTACT GROUP</h6> <hr>
    <div id="notificationsDiv"></div>
    <form action="post">
        <input type="hidden" name="editGroupId" value="<?=$_REQUEST['editGroup']?>">
        <div class="form-group">
            <label for="">Group Name:</label>
            <input type="text" name="group_name" class="form-control" value="<?=$group?>" required=required>
        </div>
        <div class="form-group float-right">
            <input type="submit" value="submit" class="btn btn-sm btn-primary">
            <button class="btn btn-default btn-sm cancelBtn">Cancel</button>
        </div>
    </form>
</div>

<script>
    jQuery(".editGroup").click(function(e){
        e.preventDefault();
        var editId = $(this).attr("id");
        window.location="/school/admin/contacts.php?editGroup="+editId;
    });

    jQuery(".deleteGroup").click(function(e){
        e.preventDefault();
        var deleteId = $(this).attr("id");
        if(confirm("Are you sure you want to delete?")){
            $.ajax({
                url:"/school/admin/contacts/delete-group.php",
                method:"post",
                data: {deleteId:deleteId},
                success:function(data){
                    location.reload(true);             
                },
                error:function(){
                    alert("An error occured trying to add contact");
                }
            });
        }
    });

    jQuery("form").submit(function(e){
        e.preventDefault();
        var formData   = $(this).serialize();
        $.ajax({
            url:"/school/admin/contacts/execute-groups.php",
            method:"post",
            data: formData,
            success:function(data){
                $("#notificationsDiv").html(data);
                $(this).trigger("reset");                
            },
            error:function(){
                alert("An error occured trying to add contact");
            }
        });
    });
    jQuery(".cancelBtn").click(function(e){
        e.preventDefault();
        $("#addGroupBtn").toggleClass("d-none");
        $("#contactGroupDiv").addClass("d-none");
        window.location="/school/admin/contacts.php";
    });
    jQuery('#addGroupBtn').click(function(){
        $(this).toggleClass("d-none");
        $("#contactGroupDiv").toggleClass("d-none");
    });
</script>

<style>
#contactGroupDiv{
    position: absolute;
    top: 20%;
    left: 20%;
    width: 60%;
    padding: 20px;
    border: 1px solid lightgrey;
    background:white;
    box-shadow: 0 4px 8px 0 rgba(0, 0, 0, 0.2), 0 6px 20px 0 rgba(0, 0, 0, 0.19);
}
#addGroupBtn{
    position:fixed;
    bottom: 10%;
    right: 2%;
    border-radius: 50%;
    padding 10px;
}
</style>