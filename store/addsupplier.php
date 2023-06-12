<style>
#addSupplierDiv{
    position: relative;
    padding: 20px;
    margin-left: 20%;
    width: 60%;
    border: 1px solid lightgrey;

}
#addSupplierDiv .title{
    padding: 20px;
}
</style>


<div id="addSupplierDiv">

<?php
     $date   =   date("Y-m-d");

     $name   =   "";
     $phone  =   "";
     $email  =   "";

     if(isset($_REQUEST['editSupplier'])){
        $supplierId     =   (int)clean($_REQUEST['editSupplier']);
        $supplierQuery  =   $db->query("SELECT * FROM suppliers WHERE id='$supplierId'");
        $data           =   mysqli_fetch_array($supplierQuery);

        $name           =   clean(trim(((isset($_POST['name'])?strtoupper($_POST['name']):$data['name']))));
        $phone          =   clean(trim(((isset($_POST['phone'])?$_POST['phone']:$data['phone']))));
        $email          =   clean(trim(((isset($_POST['email'])?strtolower($_POST['email']):$data['email']))));

        if(isset($_POST['update'])){
            $db->query("UPDATE `suppliers` SET name='$name',phone='$phone',email='$email' WHERE id='$supplierId'");
             $messages[].='<b>Success! </b>Supplier information has been updated.';
            if(!empty($messages)){
                displayMessages($messages);
            }
        }
     }

    if(isset($_POST['submit'])){
        $name   =   ((clean($_POST['name'])?strtoupper(clean(trim($_POST['name']))):''));
        $phone  =   ((clean($_POST['phone'])?clean(trim($_POST['phone'])):''));
        $email  =   ((clean($_POST['email'])?strtolower(clean(trim($_POST['email']))):''));

      

        $db->query("INSERT INTO `suppliers`(name, phone, email, entered_on) 
                    VALUES ('$name','$phone','$email','$date')");

        $messages[].='<b>Success! </b>Supplier added to database.';
        if(!empty($messages)){
            displayMessages($messages);
        }
    }
?>

<div class="text-center bg-light"> <h5 class="title"><?=((isset($_REQUEST['editSupplier'])?'EDIT':'ADD'))?> SUPPLIER</h5> </div>
    <form action="<?=((isset($_REQUEST['editSupplier'])?'/school/store/index.php?editSupplier='.$supplierId.'':'/school/store/index.php?addSupplier=1'))?>" method="POST">
        <div class="form-group">
            <label for="">Supplier Name/ Company Name:</label>
            <input type="text" name="name" class="form-control" value="<?=$name?>" required=required>
        </div>
        <div class="form-group">
            <label for="">Phone Number</label>
            <input type="number" name="phone" class="form-control" value="<?=$phone?>" min=1 required=required>
        </div>
        <div class="form-group">
            <label for="">Email</label>
            <input type="email" name="email" class="form-control" value="<?=$email?>">
        </div>
        <div class="form-group">
            <input type="submit" class="btn btn-default" name="<?=((isset($_REQUEST['editSupplier']) ? 'update' : 'submit'))?>" value="<?=((isset($_REQUEST['editSupplier']) ? 'Update' : 'Submit'))?>">
        </div>
    </form>
</div>