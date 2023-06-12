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
        </div>
        <div class="col-md-9" id="wrapper">           
            <nav> 
                <div class="nav nav-tabs" id="nav-tab" role="tablist">
                    <a class="nav-link active" id="nav-home-tab" data-toggle="tab" href="#nav-home" role="tab" aria-controls="nav-home" aria-selected="true">HOME</a>
                    <a class="nav-link" id="nav-groups-tab" data-toggle="tab" href="#nav-groups" role="tab" aria-controls="nav-groups" aria-selected="false">NEW PAYMENT</a>
                    <a class="nav-link" id="nav-actions-tab" data-toggle="tab" href="#nav-actions" role="tab" aria-controls="nav-actions" aria-selected="false">ACCOUNT ACTIONS</a>
                    <a class="nav-link" id="nav-records-tab" data-toggle="tab" href="#nav-records" role="tab" aria-controls="nav-records" aria-selected="false">FEES RECORDS</a>
                    <a class="nav-link" id="nav-balances-tab" data-toggle="tab" href="#nav-balances" role="tab" aria-controls="nav-balances" aria-selected="false">FEES BALANCES</a>
                    <a class="nav-link" id="nav-yearly-tab" data-toggle="tab" href="#nav-yearly" role="tab" aria-controls="nav-yearly" aria-selected="false">YEARLY FEES</a>
                    <a class="nav-link" id="nav-all-tab" data-toggle="tab" href="#nav-all" role="tab" aria-controls="nav-all" aria-selected="false">DEBIT ALL ACC.</a>
                </div> 
            </nav>
            <div class="tab-content" id="nav-tabContent">
                <div class="tab-pane fade show active" id="nav-home" role="tabpanel" aria-labelledby="nav-home-tab"> <?php include dirname(__DIR__).'/admin/helper/search-student-fees.php';?> </div>
                <div class="tab-pane fade" id="nav-groups" role="tabpanel" aria-labelledby="nav-groups-tab"> <?php include dirname(__DIR__).'/admin/helper/makepayment.php';?> </div>
                <div class="tab-pane fade" id="nav-actions" role="tabpanel" aria-labelledby="nav-actions-tab"> <?php include dirname(__DIR__).'/admin/helper/account-action.php';?> </div>
                <div class="tab-pane fade" id="nav-records" role="tabpanel" aria-labelledby="nav-records-tab"> <?php include dirname(__DIR__).'/admin/helper/fees-record.php';?> </div>
                <div class="tab-pane fade" id="nav-balances" role="tabpanel" aria-labelledby="nav-balances-tab"> <?php include dirname(__DIR__).'/admin/helper/feesbalances.php';?> </div>
                <div class="tab-pane fade" id="nav-yearly" role="tabpanel" aria-labelledby="nav-yearly-tab">  <?php include dirname(__DIR__).'/admin/helper/fees.php';?> </div>
                <div class="tab-pane fade" id="nav-all" role="tabpanel" aria-labelledby="nav-all-tab">  </div>
            </div>
        </div>
    </div>  
 </div> 
    <?php include '../admin/footer.php';?>
</body>
</html>
<script>
   
 jQuery('#financesearch').blur(function(){//when the input loses focus search box
    var student_finance=jQuery(this).val();       
    jQuery.ajax({
        url:'/school/admin/fetch.php',
        method:'POST',
        data:{student_finance:student_finance},
        success:function(data){//code for the UTOCOMPLETE
            jQuery('#financesearchdata').fadeIn().html(data);
            jQuery('#financesearchdiv').css({
                "border-radius":"25px", "box-shadow":"none"
            });
        },
        error:function(){
            alert("Something went wrong trying to search student");
        }
    });
    });//end of keyup function

 jQuery('#financesearch').keyup(function(){//when a key is pressed inside the search box
    var student_finance=$(this).val();
    jQuery.ajax({
        url:'/school/admin/fetch.php',
        method:'POST',
        data:{student_finance:student_finance},            
        success:function(data){//code for the UTOCOMPLETE                  
            jQuery('#financesearchdiv').css("border-radius","0px");
            jQuery('#financesearchdata').css('display','block');
            jQuery('#financesearchdata').html(data);
        },
        error:function(){
            alert("Something went wrong trying to search student");
        }
    }); 
});//end of keyup function
</script>