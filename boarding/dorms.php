
<!DOCTYPE html>
<html>
    <head>
        <?php 
        require_once $_SERVER['DOCUMENT_ROOT'].'/school/core/init.php';
        include '../boarding/header.php';?>
    <style>
     #currentDataDiv{
         margin-top: 20px;
     }
    </style>

    </head>
    <body>
     <?php   include '../admin/navigation.php';?>
    
    <div class="container-fluid">

    <?php
        if(isset($_GET['dormId']) && $_GET['dormId'] !=0 ){
            $dormId = (int)clean($_GET['dormId']); 

            $dormQuery = $db->query("SELECT * FROM dorms WHERE id='$dormId'");
            $dormData = mysqli_fetch_array($dormQuery);

            $dormMatronId = (int)$dormData['dorm_matron'];//this gives the dorm matron 
           
                if($dormMatronId !==0){//only executes is the dorm has an actual matron
                    $userQuery = $db->query("SELECT * FROM users WHERE id='$dormMatronId'");
                    $userData = mysqli_fetch_array($userQuery);
                    $matronName = $userData['name']; 
                }
            
            $dormCaptainId = (int)$dormData['dorm_captain'];

                if($dormCaptainId !==0){
                    $captainQuery = $db->query("SELECT * FROM students WHERE id='$dormCaptainId'");
                    $captainData  = mysqli_fetch_array($captainQuery);
                    $captainName  = $captainData['stdname'];
                }

            $assistantDormCapt =  (int)$dormData['ass_captain'];

                if($assistantDormCapt !==0){
                    $captainQuery = $db->query("SELECT * FROM students WHERE id='$assistantDormCapt'");
                    $captainData  = mysqli_fetch_array($captainQuery);
                    $assistantCaptainName  = $captainData['stdname'];
                }
        }
    ?>

        <div class="row">           
            <div class="col-md-4">                
                <div id="divmanagementDiv">
                    <div id="studentsDiv">
                        <div id="header">
                            <h6>CHOOSE DORM CAPTAIN/ASSISTANT</h6>
                        </div>
                        <div id="body">
                            <div class="text-center" id="studdentsearchDiv">
                                <input type="search" placeholder="Search student">
                            </div>
                            <div id="tableDiv">
                            <table class="table-striped table-bordered studentTable" style="width:100%;font-size:12px;">
                                <tbody id="studentTBody">
                                    <?php
                                    /************************code for setting dorm captain**********************//////////
                                        if(isset($_GET['removeCaptain']) && $_GET['removeCaptain']){                                
                                            $db->query("UPDATE dorms SET dorm_captain='' WHERE id='$dormId'");

                                            ?> <script> window.location="dorms.php?dormId=<?=$dormId?>";</script> <?php

                                        }
                                    /********************code for settting captain ends here**************************** */


                                    /************************code for removing dorm assistant captain**********************//////////
                                        if(isset($_GET['removeAssCaptain']) && $_GET['removeAssCaptain']){                        
                                            $db->query("UPDATE dorms SET ass_captain='' WHERE id='$dormId'");

                                            ?> <script> window.location="dorms.php?dormId=<?=$dormId?>";</script> <?php

                                        }
                                    /********************code for removing assistant captain ends here**************************** */


                                     /************************code for removing dorm matron**********************//////////
                                        if(isset($_GET['removeMatron']) && $_GET['removeMatron']){                                            
                                            $db->query("UPDATE dorms SET dorm_matron='' WHERE id='$dormId'");

                                            ?> <script> window.location="dorms.php?dormId=<?=$dormId?>";</script> <?php

                                        }
                                    /********************code for removing matron ends here**************************** */


                                    /************************code for setting dorm matron**********************//////////
                                        if(isset($_GET['setMatron']) && $_GET['setMatron']){
                                            $matronID = (int) clean($_GET['setMatron']);
                                            $db->query("UPDATE dorms SET dorm_matron='$matronID' WHERE id='$dormId'");

                                            ?> <script> window.location="dorms.php?dormId=<?=$dormId?>";</script> <?php

                                        }
                                    /********************code for settting matron ends here**************************** */


                                     /************************code for setting dorm captain**********************//////////
                                        if(isset($_GET['setassCaptain']) && $_GET['setassCaptain']){
                                            $captID = (int) clean($_GET['setassCaptain']);
                                            $db->query("UPDATE dorms SET ass_captain='$captID' WHERE id='$dormId'");

                                            ?> <script> window.location="dorms.php?dormId=<?=$dormId?>";</script> <?php

                                        }
                                    /********************code for settting captain ends here**************************** */


                                    /************************code for setting dorm captain**********************//////////
                                        if(isset($_GET['setCaptain']) && $_GET['setCaptain']){
                                            $captID = (int) clean($_GET['setCaptain']);
                                            $db->query("UPDATE dorms SET dorm_captain='$captID' WHERE id='$dormId'");

                                            ?> <script> window.location="dorms.php?dormId=<?=$dormId?>";</script> <?php

                                        }
                                    /********************code for settting captain ends here**************************** */

                                        $count = 1;
                                        $students=$db->query("SELECT * FROM students WHERE deleted=0 AND accomplished=0 ORDER BY stdname");
                                        while( $student_data=mysqli_fetch_array($students)) :
                                    ?>

                                        <tr>
                                            <td class="text-center"><?=$count;?></td>                             
                                            <td><?=$student_data['registration_number'];?></td>
                                            <td><?=$student_data['stdname'];?></td>        
                                            <td id="captainColn">
                                                <a href="dorms.php?dormId=<?=$dormId;?>&setCaptain=<?=$student_data['id']?>">
                                                    <input type="radio"> Select 
                                                </a>                                                 
                                            </td>
                                            <td id="assCaptainColn">
                                                <a href="dorms.php?dormId=<?=$dormId;?>&setassCaptain=<?=$student_data['id']?>">
                                                    <input type="radio"> Select 
                                                </a>                                                 
                                            </td>
                                        </tr>

                                    <?php $count++; endwhile;?>
                                </tbody>
                            </table>
                            </div><!--closing div that holds table-->
                        </div>
                        <div id="footer">
                            <label class="btn btn-default" onclick="reload()">Back</label>
                        </div>
                    </div>              
                    <div id="employeesDiv">
                        <div id="header">
                            <h6>SELECT DORM MATRON</h6>
                        </div>
                        <div id="body">
                            <table class="table-striped table-bordered" style="width:100%;font-size:12px;">
                                <tbody>
                                    <?php
                                        $count=1;
                                        $employeeQuery = $db->query("SELECT * FROM users WHERE id !=1");
                                        while($empdata = mysqli_fetch_array($employeeQuery)) :
                                    ?>
                                    <tr>
                                            <td> <?=$count;?> </td>
                                            <td><?=$empdata['name'];?></td>
                                            <td> 
                                                <a href="dorms.php?dormId=<?=$dormId?>&setMatron=<?=$empdata['id']?>">
                                                    <input type="radio" class="setMatronRadioBtn" title="Set as dorm matron."> Select
                                                </a>
                                            </td>
                                    </tr>
                                    <?php $count++; endwhile;?>
                                </tbody>
                            </table>
                        </div>
                        <div id="footer">
                            <label class="btn btn-default" onclick="reload()">Back</label>
                        </div>
                    </div>
                    <div id="currentDataDiv"><!--This is the div that displays once this page is loaded-->
                        <div class="text-center">
                               <a href="dorms.php?dormId=<?=$dormId?>">
                                    <label id="dormname">DORM: <?=strtoupper($dormData['dorm']);?> HOMEPAGE</label>
                               </a>
                        </div>
                        <h6> DORM MATRON </h6>
                        <label><?=((isset($matronName)) ? cutstring($matronName,25) : 'NULL')?> </label>
                        <a class="float-right btn btn-default matronBtn" title="Change dorm matron"><i class="fas fa-pencil-alt"></i> Edit</a>
                        <a href="dorms.php?dormId=<?=$dormId?>&removeMatron=1" class="float-right btn text-danger"><i class="fas fa-user-slash"></i> Remove</a>
                        <h6> DORM CAPTAIN </h6>
                        <label> <?=((isset($captainName)) ? cutstring($captainName,25) : 'NULL')?> </label>
                        <a class="float-right btn btn-default" onclick="editCaptain()" title="Change dorm captain"><i class="fas fa-pencil-alt"></i> Edit</a>
                        <a href="dorms.php?dormId=<?=$dormId?>&removeCaptain=1" class="float-right btn text-danger"><i class="fas fa-user-slash"></i> Remove</a>
                         <h6> ASSISTANT CAPTAIN </h6>
                        <label> <?=((isset($assistantCaptainName)) ? cutstring($assistantCaptainName,25) : 'NULL')?> </label>
                        <a class="float-right btn btn-default" onclick="editassCapt()" title="Change dorm assistant captain"><i class="fas fa-pencil-alt"></i> Edit</a>
                        <a href="dorms.php?dormId=<?=$dormId?>&removeAssCaptain=1" class="float-right btn text-danger"><i class="fas fa-user-slash"></i> Remove</a>
                    </div>                    

                </div><!--closing management div-->                                                   
            
            </div><!--Closing col-md-4 div-->

            <div class="col-md-8">

                 <!--button for adding students to dorm-->
            <div>
            <a href="dorms.php?dormId=<?=$dormId?>&add=1" class="btn-primary addstudentsBtn"><i class="fas fa-user-plus"></i> </a>
           </div>
                <?php
                    if(isset($_GET['add']) && $_GET['add']>0){
                         include 'dorms/addstudent.php';
                    }else{
                         include 'dorms/home.php';
                    }                   
                ?>
            </div><!--Closing col-md-6 div-->

        </div><!--closing row div-->

    </div><!---Closing container-fluid div-->
       
    </body>
</html>


<script>

//button for refreshing page
jQuery('#refresh').click(function(){
    reload();
});


jQuery('.matronBtn').click(function(){//this function hides the displayed dic and displays a list of all the staff in the school
    jQuery('#currentDataDiv').hide();
    jQuery('#employeesDiv').fadeIn();
});

function editCaptain(){
     jQuery('#currentDataDiv').hide();
     jQuery('#studentsDiv').fadeIn();
     jQuery('#assCaptainColn').hide();//hides the assistant captain column
}

function editassCapt(){
     jQuery('#currentDataDiv').hide();
     jQuery('#studentsDiv').fadeIn();
     jQuery('#captainColn').hide();//hides the captain column
}

function reload(){
    location.reload(true);
}

jQuery('#addstudentsBtn').mouseenter(function(){
    jQuery('#addstudentsBtn label').slideToggle();
    jQuery(this).css("box-shadow", "0 4px 8px 0 rgba(0, 0, 0, 0.2), 0 6px 20px 0 rgba(0, 0, 0, 0.19)");
});
jQuery('#addstudentsBtn').mouseleave(function(){
    jQuery('#addstudentsBtn label').fadeOut();
});

jQuery('#refresh').mouseenter(function(){
    jQuery('#refresh label').slideToggle();
    jQuery(this).css("box-shadow", "0 4px 8px 0 rgba(0, 0, 0, 0.2), 0 6px 20px 0 rgba(0, 0, 0, 0.19)");
});
jQuery('#refresh').mouseleave(function(){
    jQuery('#refresh label').fadeOut();
});

jQuery('#studdentsearchDiv input[type="search"]').keyup(function(){
    var studentName = jQuery(this).val();
    var dormId = <?=$dormId?>;
    jQuery.ajax({
        url:'/school/boarding/dorms/fetch.php',
        method:'post',
        data:{studentName:studentName,dormId:dormId},
        success:function(data){
            jQuery('#studentTBody').html();
            jQuery('#studentTBody').html(data);
        },
        error:function(){
            alert("Something went wrong trying to search student");
        }
    });
});

</script>