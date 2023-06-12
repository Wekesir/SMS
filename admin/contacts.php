<!DOCTYPE html>
<html>
<head>
    <?php
        require_once $_SERVER['DOCUMENT_ROOT'].'/school/core/init.php';
        include '../admin/header.php';
    ?>
</head>
<body>   
    <?php include '../admin/navigation.php';?>
 <div class="container-fluid">
    <div class="row">
        <div class="col-md-3">
            <?php include '../admin/left.php';?>
        </div><!--Closing col-md-3 div-->
        <div class="col-md-9 bg-light" id="wrapper">
            <div class="form-group">
                <h4>Contacts Management.</h4>
            </div>
           <nav>
                <div class="nav nav-tabs" id="nav-tab" role="tablist">
                    <a class="nav-link active" id="nav-home-tab" data-toggle="tab" href="#nav-home" role="tab" aria-controls="nav-home" aria-selected="true">Home</a>
                    <a class="nav-link" id="nav-groups-tab" data-toggle="tab" href="#nav-groups" role="tab" aria-controls="nav-groups" aria-selected="false">Contact Groups</a>
                </div>
            </nav>
            <div class="tab-content" id="nav-tabContent">
                <div class="tab-pane fade show active" id="nav-home" role="tabpanel" aria-labelledby="nav-home-tab"> <?php include 'contacts/home.php';?> </div>
                <div class="tab-pane fade" id="nav-groups" role="tabpanel" aria-labelledby="nav-groups-tab"> <?php include 'contacts/contact-groups.php';?> </div>
            </div>
            <?php
            if(isset($_REQUEST['editGroup'])){?>
                <script>$('#nav-tab a[href="#nav-groups"]').tab('show') </script>
            <?php } ?>
        </div><!--Closing col-md-9 div-->
    </div><!--Closing row dic-->
 </div><!--closing container div-->
    <?php include '../admin/footer.php';?>
</body>
</html>
<script>

</script>

