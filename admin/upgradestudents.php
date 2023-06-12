<!DOCTYPE html>                      
<html>
<head>
    <?php
        require_once $_SERVER['DOCUMENT_ROOT'].'/school/core/init.php';
        include '../admin/header.php';
        include '../modals/confirmpassword.php';//this is the modal that pops up for confirming password before moving students to the next level
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
            <div class="text-center" style="border:1px solid lightgrey; position:absolute; top:30%;left:20%;padding:10px;width:60%;">
                <small class="text-danger">This is a process to help move students to the next level.<br> Back up data first then start this process.</small>


            <?php 
                if(isset($_REQUEST['confirmPassBtn'])){//if the confirm button is clicked from the modal the following code should execute
                  $confPassId = (int)$_SESSION['user'];  
                  $confirmPass = trim(clean(((isset($_REQUEST['confirmpassword'])? $_REQUEST['confirmpassword']:''))));
                  $queryData = mysqli_fetch_array($db->query("SELECT * FROM `users` WHERE `id`='$confPassId'"));
                  
                  //CHECK IF THE PASSWORD IS CORRECT
                  if(!password_verify($confirmPass,$queryData['password']) || $confirmPass==''){//if the password is wrong or password is null then display Modal again
                      ?>
                       <script>
                            jQuery('#confirmpasswordmodal').modal({
                            backdrop: 'static', keyboard: false
                            });//prevents modal from closing on backdrop and keyboard clicking
                        </script>
                        <!--CODE FOR SHOWiNG MODAL IF THE PASSWORD IS WRONG-->
                          <style>
                            #confirmpasswordmodal {
                            animation: shake 0.5s;
                            animation-iteration-count:3;
                            }

                            @keyframes shake {
                            0% { transform: translate(1px, 1px) rotate(0deg); }
                            10% { transform: translate(-1px, -2px) rotate(-1deg); }
                            20% { transform: translate(-3px, 0px) rotate(1deg); }
                            30% { transform: translate(3px, 2px) rotate(0deg); }
                            40% { transform: translate(1px, -1px) rotate(1deg); }
                            50% { transform: translate(-1px, 2px) rotate(-1deg); }
                            60% { transform: translate(-3px, 1px) rotate(0deg); }
                            70% { transform: translate(3px, 1px) rotate(-1deg); }
                            80% { transform: translate(-1px, -1px) rotate(1deg); }
                            90% { transform: translate(1px, 2px) rotate(0deg); }
                            100% { transform: translate(1px, -2px) rotate(-1deg); }
                            }
                            </style>
                      <?php
                  }else{//if the password is correct then hide modal
                      ?>
                        <script>
                            jQuery('#confirmpasswordmodal').modal("hide");
                        </script>
                      <?php
                  }
                    
                }else{//This code executes when the user has not cinfirmed their password
                    ?>
                        <script>
                            jQuery('#confirmpasswordmodal').modal({
                            backdrop: 'static', keyboard: false
                            });//prevents modal from closing on backdrop and keyboard clicking                  
                        </script>
                    <?php
                }
                /*******************************************************************************************************
                 * CONFIRM BUTTON MODAL BUTTON ENDS HERE
                 ******************************************************************************************************/
            ?>
          
                <div id="showSuccessDiv"><div>
                <div class="form-group">
                    <input type="button" name="moveStudentsBtn" id="moveStudentsBtn" class="form-control theme_color" title="Click to move students from their current level to the next." value="Move Students">
                </div>                       
            </div>
        </div><!--Closing col-md-9 div-->
    </div><!--Closing row dic-->
 </div><!--closing container div-->
    <?php include '../admin/footer.php';?>
</body>
</html>

<script>
    function closeconfrimpasswordModal(){
        jQuery('#confirmpasswordmodal').modal("hide");
        window.location='../admin/students.php';
    }

    jQuery(document).ready(function(){//modal show 1 sec after the document has loaded    
        var script_url = '/school/admin/configuration.php';
        jQuery.ajax({
            url:'/school/modals/confirmpassword.php',
            method:'POST',
            data:{script_url:script_url},
            error:function(){
                alert("Something went wrong sending URL.");
            },
        });

        jQuery('#moveStudentsBtn').click(function(){//when the move students button has been clicked
            var move_students = '';
            jQuery.ajax({
                url:'/school/admin/helper/studentmovement.php',
                method:'POST',
                data:{move_students:move_students},
                success:function(data){
                    jQuery('#showSuccessDiv').html(data);
                },
                error:function(){
                    alert("Something went wrong trying to move students");
                }
            });
        });
    });   
</script>