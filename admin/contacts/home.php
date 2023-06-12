<?php
if(isset($_REQUEST['editContact'])){
    $editId    = (int)clean($_REQUEST['editContact']);
    $contactsQ = $db->query("SELECT * FROM contacts WHERE id='$editId'");
    $data      = mysqli_fetch_array($contactsQ); 
    $name      = $data['name'];
    $phone     = $data['phone'];
    $email     = $data['email'];
    $address   = $data['address'];
}else{
    $editId    = 0;
    $name      = "";
    $phone     = "";
    $email     = "";
    $address   = "";
}
?>
<table class="table-sm table-striped table-bordered table-hover table">
    <thead class="thead-light">
        <th>#</th>
        <th>NAME</th>
        <th>PHONE</th>
        <th>EMAIL</th>
        <th>ADDRESS</th>
        <th></th>
    </thead>
    <tbody>
        <?php
        $count=1;
        $contactsQ = $db->query("SELECT * FROM contacts ORDER BY name");
        if(mysqli_num_rows($contactsQ)==0){
            $info[].='<b>Oops! </b>No contacts have been found. Try adding a contact.';
        }
        while($row = mysqli_fetch_array($contactsQ)) : ?>
        <tr>
            <td><?=$count?></td>
            <td><?=$row['name'];?></td>
            <td><?=$row['phone'];?></td>
            <td><?=$row['email'];?></td>
            <td><?=$row['address'];?></td>
            <td>
                <a href="<?=$_SERVER['PHP_SELF'].'?editContact='.$row['id'].''?>"><i class="fas fa-pencil-alt"></i> edit</a>
                <a href="#" class="text-danger deleteContact" id="<?=$row['id'];?>"><i class="fas fa-trash-alt"></i> delete</a>
            </td>
        </tr>
        <?php $count++; endwhile;?>
    </tbody>
</table>

<button id="addContactBtn" class="btn btn-primary" title="Add Contact"><i class="fas fa-plus"></i></button>

<div id="addContactDiv" class="<?=((isset($_REQUEST['editContact']))?'d-block':'d-none')?>">
    <div class="text-center">
        <h5 for=""><?=((isset($_REQUEST['editContact']))?'EDIT':'ADD NEW')?> CONTACT</h5> <hr>
    </div>
    <div id="notificationsDiv"></div>
    <form action="<?=$_SERVER['PHP_SELF']?>" method="post" >
            <input type="hidden" name="editId" value="<?=$editId?>">
        <div class="form-group">
            <label for="">Name</label>
            <input type="text" class="form-control" name="name" value="<?=$name?>" required=required>
        </div>
        <div class="form-group">
            <label for="">Phone Number</label>
            <input type="tel" class="form-control" name="phone" value="<?=$phone?>" required=required>
        </div>
        <div class="form-group">
            <label for="">Email</label>
            <input type="email" class="form-control" name="email" value="<?=$email?>">
        </div>
        <div class="form-group">
            <label for="">Address</label>
            <input type="text" class="form-control" name="location" value="<?=$address?>">
        </div>
        <div class="form-group text-right">
            <input type="submit" value="Submit" name="submit" class="btn btn-sm btn-primary">
            <input type="button" value="Cancel" class="btn btn-sm btn-default hideDiv">
        </div>
    </form>
</div>

<script>
    var addContactDiv = $("#addContactDiv");
    //when the add contact button has been clcked
    $("#addContactBtn").click(function(){
         addContactDiv.removeClass("d-none");
         $(this).addClass("d-none");
    });
    //when the cancel button is clicked
    $(".hideDiv").click(function(){
       addContactDiv.addClass("d-none");
       $("#addContactBtn").toggleClass("d-none");
       window.location="/school/admin/contacts.php";
    });

    jQuery(".deleteContact").click(function(e){
        e.preventDefault();
        var contactId = $(this).attr("id");
        if(confirm("Are you sure you want to delete?")){
            $.ajax({
            url:"/school/admin/contacts/delete-contact.php",
            method:"post",
            data: {contactId,contactId},
            success:function(data){
                alert("Contact deleted!");
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
            url:"/school/admin/contacts/execute-contact.php",
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
</script>

<style>
#addContactBtn{
    position:fixed;
    bottom: 10%;
    right: 2%;
    border-radius: 50%;
    padding 10px;
}
#addContactDiv{
    position: absolute;
    top: 10%;
    left: 20%;
    width: 60%;
    padding: 20px;
    border: 1px solid lightgrey;
    background:white;
    box-shadow: 0 4px 8px 0 rgba(0, 0, 0, 0.2), 0 6px 20px 0 rgba(0, 0, 0, 0.19);
    max-height: 80vh;
    overflow:auto;
}
</style>