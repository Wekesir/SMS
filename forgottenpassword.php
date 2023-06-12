<?php
    require_once $_SERVER['DOCUMENT_ROOT'].'/school/core/init.php';
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Reset Password</title>
    <link rel="icon" type="image/x-icon" href="<?=$configurationData['school_logo']?>">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-EVSTQN3/azprG1Anm3QDgpJLIm9Nao0Yz1ztcQTwFspd3yD65VohhpuuCOmLASjC" crossorigin="anonymous">
</head>
<body>
    <div id="contentDiv" class="shadow-lg rounded">
        <div class="container-fluid">
            <div class="row">
                <div class="col-md-6 d-none d-lg-block">
                    <img src="https://media.istockphoto.com/vectors/privacy-software-firewall-vector-illustration-vector-id1145160386?k=20&m=1145160386&s=612x612&w=0&h=rmjUAjx_Xh310Jr27gWdn5TGhAY_9TbDuy6zPfAz51k=" alt="">
                </div>
                <div class="col-md-6 p-5">
                    <h2>Forgot your password?</h2> <hr>
                    <?php
                    if(isset($_POST['submit'])):
                        $username = trim($_POST['user']);
                        $phone = trim($_POST['phone']);

                        $resetQuery = $db->query("SELECT `id`,`name` FROM `users` WHERE `username`='{$username}' AND `phone`='{$phone}'");
                        //check if the query has any resultss
                        if(mysqli_num_rows($resetQuery)==0):
                            echo '<div class="alert alert-danger" role="alert">
                                        The username or phone number does not exist.
                                    </div>';
                        else:
                            $queryData = mysqli_fetch_array($resetQuery);
                            $id = $queryData['id'];
                            $name = $queryData['name']; //name of the employee as is in the DB
                            $newPassword = generatepassword();
                            $hashedPass = password_hash($newPassword, PASSWORD_DEFAULT);
                            $message = "Your OTP is: ".$newPassword;
                            sendSms(format_phone_number($phone), $message, $name);
                            $db->query("UPDATE `users` SET `password`='{$hashedPass}' WHERE `id`='{$id}'");
                            echo '<div class="alert alert-success" role="alert">
                                        Your password has been sent to your phone.
                                    </div>';
                        endif;
                    endif;
                    ?>

                    <form action="<?=$_SERVER["PHP_SELF"]?>" method="post">
                    <div class="my-4">
                        <label for="exampleFormControlInput1" class="form-label mb-2"><b>USERNAME</b></label>
                        <input type="tel" name="user" class="form-control" id="exampleFormControlInput1" placeholder="Username" required>
                    </div>
                    <div class="mb-4">
                        <label for="exampleFormControlInput1" class="form-label mb-2"><b>PHONE NUMBER</b></label>
                        <input type="tel" name="phone" class="form-control" id="exampleFormControlInput1" placeholder="07XXXXXXXX" required>
                    </div>
                    <div class="d-grid gap-2 my-5">
                        <button class="btn rounded text-white font-weight-bold" name="submit" type="submit">Send Password</button>
                    </div>
                    <small>Back to <a href="login.php">Login.</a></small>
                    </form>
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
    #contentDiv{
        width: 70%;
        height: 80vh;
        border: none;
        margin: 9vh auto;
        background: white;
    }
    body, button[type='submit'] {
        background-image: linear-gradient(to right, #8360c3, #2ebf91);
    }
</style>