<?php 
require dirname(__DIR__)."/school/core/init.php";
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>LOGIN | <?=$configurationData['school_name']?></title>
    <link rel="icon" type="image/x-icon" href="<?=$configurationData['school_logo']?>">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-EVSTQN3/azprG1Anm3QDgpJLIm9Nao0Yz1ztcQTwFspd3yD65VohhpuuCOmLASjC" crossorigin="anonymous">
</head>
<body>
    <div class="container-fluid">
        <div class="row p-0">
        <div class="col-md-4 bg-light p-5" style="height: 100vh;">
            <div class="text-center"><img src="<?=$configurationData['school_logo']?>" id="school_logo" class="" height="100px;" width="100px;" alt=""></div>
            <div class="text-center"><h5 class="py-3" id="school_name"><?=$configurationData['school_name']?></h5></div> <hr>
            <div>               
                <form>
                <div class="form-group mb-3">
                    <label for="exampleInputEmail1" class="fw-bold mb-2">USERNAME</label>
                    <input type="text" name="user" class="form-control" id="exampleInputEmail1" aria-describedby="emailHelp" placeholder="Enter username" required>
                </div>
                <div class="form-group mb-3">
                    <label for="exampleInputPassword1" class="fw-bold mb-2">PASSWORD</label>
                    <input type="password" name="pass" class="form-control" id="exampleInputPassword1" placeholder="Password" required>
                </div>
                <div class="form-group form-check mb-3">
                    <input type="checkbox" class="form-check-input" id="exampleCheck1">
                    <label class="form-check-label" for="exampleCheck1">Show Password</label>
                </div>
                <div class="d-grid gap-2">
                    <button class="btn btn-primary" type="submit" title="Click to login!">
                    <span class="spinner-border spinner-border-sm d-none" role="status" aria-hidden="true"></span>
                    LOGIN
                    </button>
                </div>               
                </form>
                <small class="font-italic text-center">Forgotten password? <a href="forgottenpassword.php">Reset password.</a></small>
            </div>
            <!-- this is the alert for displaying the error -->
            <div class="alert alert-danger shadow-lg alert-dismissible fade show d-none" role="alert">
                <small></small>
                <button type="button" class="btn-close btn-sm" data-bs-dismiss="alert" aria-label="Close"></button>
            </div>
            <!-- end of the error display div -->
            <hr>
            <small style="botton: 0px; position:absolute;">&copy; e-ducationsystems-<?=date("Y")?> Contact: (+254)710595755</small>
        </div>
        <div class="col-md-8 bg-dark" id="login_right_side_div">
            <img style="width: 100%;height: 100vh;" src="data:image/jpeg;base64,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" alt="">
            <div style="position:absolute;background:black;width:65.5vw;height:100vh;top: 0px; opacity: 0.6;"></div>
            <div class="shadow-lg p-3 rounded" style="border: 1px solid white; height: 20vh; width: 50%;position: absolute; top: 40vh; right:  7%;">
                <h3 class="p-3 text-white align-middle">EMBRACING TECHNOLOGY IN EDUCATION</h3>
            </div>
        </div>
        </div>
    </div>
<script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.9.2/dist/umd/popper.min.js" integrity="sha384-IQsoLXl5PILFhosVNubq5LC7Qb9DXgDA9i+tQ8Zj3iwWAwPtgFTxbJ8NT4GN1R8p" crossorigin="anonymous"></script>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/js/bootstrap.min.js" integrity="sha384-cVKIPhGWiC2Al4u+LWgxfKTRIcfu0JTxR+EQDz/bgldoEyl4H0zUF0QKbrJ0EcQF" crossorigin="anonymous"></script>
<script src="https://code.jquery.com/jquery-3.6.0.min.js" integrity="sha256-/xUj+3OJU5yExlq6GSYGSHk7tPXikynS7ogEvDej/m4=" crossorigin="anonymous"></script>
<script src="https://code.jquery.com/ui/1.13.1/jquery-ui.min.js" integrity="sha256-eTyxS0rkjpLEo16uXTS0uVCS4815lc40K2iVpWDvdSY=" crossorigin="anonymous"></script>
</body>
</html>

<style>
    @media screen and (max-width:770px){/*When the screen size goes below 770px */
        #login_right_side_div{
            display:none;
        }
    }
</style>

<script>
    jQuery(document).ready(function(){//runs when the document has fully loaded
        jQuery("form").submit(function(e){//when the submit button has been clicked
            e.preventDefault();//prevent the refresh
           var form_data = {
               "USER": $("input[name='user']").val(),
               "PASS": $("input[name='pass']").val()
           }
            //display the loader on login button
            jQuery("span.spinner-border").removeClass("d-none");
            //deactivate the login button
            jQuery("button[type='submit']").addClass("disabled");
            jQuery.ajax({
                url:"/school/helpers/authenticate-user.php",
                method:"POST",
                data:(form_data),
                success:function(data){
                     //hides the spinner on login button
                    jQuery("span.spinner-border").addClass("d-none");
                    //activates the login button
                    jQuery("button[type='submit']").removeClass("disabled");
                     var data_arr = JSON.parse(data);//converts json string to array
                     //check if the returned data has an error (code==0)
                     if(data_arr["Code"]==0){
                        $(".alert > small").html(data_arr["Msg"]);//this is the error message from server
                        $(".alert").removeClass("d-none"); //display the alert message
                         setTimeout(() => {
                            $("form").trigger("reset"); //resets the form data 
                            $(".alert").addClass("d-none"); //hide the alert message
                         }, 1000);                        
                         return;
                     }else{//if the data is a success for the login then redirect to the appropriate landing page
                        window.location.href = data_arr["URL"];
                        return;
                     }
                },
                error:function(){
                    alert("Critical Error! Failed to authenticate user, contact developer.");
                }
            });
        });

        //when the school logo/school name is clicked
        jQuery("#school_logo,#school_name").click(function(){
            window.location="index.php";
        });

        //when the show password has been clicked
        jQuery("input[type='checkbox']").click(function(){
            if($("input[name='pass']").attr("type") === "password"){
                $("input[name='pass']").attr("type","text");
            }else{
                $("input[name='pass']").attr("type","password");
            }
        })
    });
</script>