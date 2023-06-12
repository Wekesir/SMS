<!DOCTYpE html>
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
            <div class="col-md-9" id="wrapper">       
                <h5>Messages.</h5>                    
                <nav>
                <div class="nav nav-tabs" id="nav-tab" role="tablist">
                    <a class="nav-item nav-link active" id="nav-home-tab" data-toggle="tab" href="#nav-home" role="tab" aria-controls="nav-home" aria-selected="true">Home</a>
                    <a class="nav-item nav-link" id="nav-profile-tab" data-toggle="tab" href="#nav-profile" role="tab" aria-controls="nav-profile" aria-selected="false">Outbox <span class="badge label-pill badge-success outbox_count"></span></a>
                    <a class="nav-item nav-link" id="nav-contact-tab" data-toggle="tab" href="#nav-contact" role="tab" aria-controls="nav-contact" aria-selected="false">Message Counter</a>
                    <a class="nav-item nav-link" id="nav-inbox-tab" data-toggle="tab" href="#nav-inbox" role="tab" aria-controls="nav-inbox" aria-selected="false">Website Messages <span class="badge label-pill badge-danger message_count"></span></a>
                </div>
                </nav>
                <div class="tab-content" id="nav-tabContent">
                <div class="tab-pane fade show active" id="nav-home" role="tabpanel" aria-labelledby="nav-home-tab"> <?php include $_SERVER['DOCUMENT_ROOT'].'/school/messages/home.php';?> </div>
                <div class="tab-pane fade" id="nav-profile" role="tabpanel" aria-labelledby="nav-profile-tab"> <?php include $_SERVER['DOCUMENT_ROOT'].'/school/messages/outbox.php';?> </div>
                <div class="tab-pane fade" id="nav-contact" role="tabpanel" aria-labelledby="nav-contact-tab">...</div>
                <div class="tab-pane fade" id="nav-inbox" role="tabpanel" aria-labelledby="nav-inbox-tab"> <?php include $_SERVER['DOCUMENT_ROOT'].'/school/messages/site-messages.php';?> </div>
                </div>
            </div><!--Closing col-md-9 div-->
        </div><!--Closing row div-->
    </div><!--Closing container-fluid div-->
    <?php include '../admin/footer.php';?>
</body>
</html>