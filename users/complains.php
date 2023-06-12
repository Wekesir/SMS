<!DOCTYPE html>
<html>
<head>
<?php
require_once $_SERVER['DOCUMENT_ROOT'].'/school/core/init.php';
include '../users/header.php';?>
</head>
<body>
    <?php include '../users/navigation.php';?>

        <div class="container-fluid">
            <div class="row">
                <div class="col-md-3">
                    <?php include '../users/left.php';?>    
                </div><!--Closing col-md-3 div-->
                <div class="col-md-9"id='wrapper'>  
                    <div id="notificationsDiv"></div>          
                    <table class="table-striped table-bordered" style="width:100%;">
                        <thead>
                            <th>#</th>
                            <th>SUBJECT</th>
                            <th>COMPLAIN</th>
                            <th>STATUS</th>
                            <th>SUBMITTED ON</th>
                            <th>ACTIONS</th>
                        </thead>
                        <tbody id="mainTBody">   
                            <!--GETS DATA FROM THE HELPERS EXECUTE-COMPLAINS PAGE-->                                                           
                        </tbody>
                    </table>

                    <button class="btn btn-primary active" id="addComplainbtn" title="Add new complain."><i class="fas fa-plus"></i></button>

                    <div id="insertComplainDiv" class="">
                         <label class="text-center bg-light" style="width:100%;padding:10px;">SUBMIT A COMPLAIN TO MANAGEMENT.</label>
                         <div id="notificationsDiv"></div>
                        <form action=<?=$_SERVER['PHP_SELF']?> method="POST">
                            <divv class="form-group">
                                <label for="">SUBJECT</label>
                                <input type="text" name="subject" class="form-control" required=required>
                            </divv>
                            <div class="form-group">
                                <label for="complain">COMPLAIN</label>
                                <textarea name="complain" id="complain" rows="6" class="form-control" placeholder="Your Message..." required=required></textarea>
                            </div>
                            <div class="form-inline">
                               <button type="submit" class="btn btn-sm btn-primary">Submit</button>
                               <button class="btn btn-sm btn-default cancelBtn">Cancel</button>
                            </div>
                        </form>
                    </div>
    
                    <style>
                    
                    </style>                  
                </div><!--Closing col-md-9 div-->
            </div><!--Closing row div-->
        </div><!--Closing container-fluid t\div-->

     <?php include '../users/footer.php';?>
</body>
</html>

<script>
    jQuery(document).ready(function(){
       fetchComplains();

        var complainDiv = jQuery("#insertComplainDiv");

       jQuery('#addComplainbtn').click(function(){
           jQuery(this).hide();
           complainDiv.fadeIn("slow");

       });      

       complainDiv.find(".cancelBtn").click(function(e){//when the ccancel button is clicked the popup should dissapear
           e.preventDefault();
           complainDiv.fadeOut("slow");
           jQuery("#addComplainbtn").fadeIn();
       });

       jQuery("form").submit(function(e){
           e.preventDefault();
           var data = jQuery(this).serialize();
           jQuery.ajax({
                url:'/school/users/helpers/insert-complain.php',
                method:'post',
                data:data,
                success:function(data){
                   complainDiv.find("#notificationsDiv").html(data);
                   fetchComplains();//updates the data bbeing displayed in the table
                   jQuery("form").trigger("reset");//resets form data
                },
                error:function(){
                    alert("Something went wrong trying to fetch complains");
                }
            });
       });

       
    });

    //this function fetches all data about complains from database
    function fetchComplains(){
        var request = '';
        jQuery.ajax({
            url:'/school/users/helpers/execute-complains.php',
            method:'post',
            data:{request:request},
            success:function(data){
                jQuery("#mainTBody").html(data);
                //when the delete button has been clicked 
                jQuery(".deleteComplainBtn").click(function(){
                        var delComplainId = jQuery(this).attr("data-complainId");//id for the complain we want to delete
                        alert(delComplainId);
                        jQuery.ajax({
                            url:'/school/users/helpers/execute-complains.php',
                            method:'post',
                            data:{delComplainId:delComplainId},
                            success:function(data){
                               jQuery("#notificationsDiv").html(data);
                               location.reload(true);
                            },
                            error:function(){
                                alert("Something went wrong trying to fetch complains");
                            }
                        });
                });
                //code for delete button ends here
            },
            error:function(){
                alert("Something went wrong trying to fetch complains");
            }
        });
    }
</script>