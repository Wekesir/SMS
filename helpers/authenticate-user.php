<?php
require_once $_SERVER['DOCUMENT_ROOT'].'/school/core/init.php';

/**
 * THE RESPONSD ARRAY IS AN ARRAY RETURNED TO THE REWUESTING FILE WITH THE RELEVANT DATA
 *  cODE - 0(The result has an error) 1( The response was a success)
 *  MSG - Incase the response has an error, then this is the message to be displayed
 *  REDIRECT - This states whether on not the repsonse needs to redirect
 *  URL - This is the URL for the landing page based on the user permission 
 */

//when data has been sent to this file
if(isset($_POST)):
    $username  = trim(clean($_POST["USER"])); // the username of this user
    $password  = trim(clean($_POST["PASS"])); // the user password
    //$loginType = trim(clean($_POST['LOG_TYPE'])); //the ttype of the user this is PARENT/STAFF
    $loginType = "STAFF";
    $reponse_array = array();
    $err = array();

    //check whtehr the person loggin in is a staff or parent
    if($loginType == 'STAFF'):
        $userQuery = $db->query("SELECT * FROM `users` WHERE `username`='$username'");
        $userArray = mysqli_fetch_array($userQuery);

            //check if the username exists
            if(mysqli_num_rows($userQuery) < 1):
                $err[].="The username does not exist.";
            else:
                //check whether the correct password has been entered
                if(!password_verify($password,$userArray['password'])):
                $err[].= "Wrong password! Please try again.";
                endif;
                //check if the user has access to this site
                if($userArray['access_status'] == 0):
                    $err[].="Your access has been restricted. Contact system admin.";
                endif;
                if($userArray['deleted'] ==1):
                    $err[].='You no longer have permission to access this portal.';
                endif;
            endif;

            if(!empty($err)){
               $response_array = array(
                    "Code"      => 0,
                    "Msg"       => $err,
                    "Redirect"  => FALSE,
                    "URL"       => ""
               );
            }else{                  
                $_SESSION['user']       =   $userArray["id"]; 
                $user                   =   $userArray['username'];
                $user_perm              =   $userArray['permissions']; //checks the login level for the given username from databse
                $perm                   =   explode(',', $user_perm);

                if(isMobileDevice())://if the browser trying to login is a phone
                    $response_array = array(
                        "Code" => 1,
                        "Msg"  => "",
                        "Redirect" => TRUE,
                        "URL" => "/school/helpers/mobile-browser-error.php"
                   );
                   exit;
                else:
                    $date = date('Y-m-d H:i:s');

                    if($id !=1)://when the user accessing is not the system admin
                        $browser     = getBrowser();
                        $yourbrowser = $browser['platform'].' ('.$browser['name'].' '.$browser['version'].')';
                        $db->query("INSERT INTO `logs` (`userId`, `log_in`, `browser_info`) VALUES ('{$id}','{$date}','{$yourbrowser}')");//inserting login data in log table
                        $_SESSION['activelogin'] = $db->insert_id;
                    endif;    

                    foreach($perm as $p):
                        switch($p):
                            case "Admin":
                                $response_array = array(
                                    "Code"     => 1,
                                    "Msg"      => "",
                                    "Redirect" => TRUE,
                                    "URL"      => "/school/admin/index.php"
                                );
                                break;
                            case "Store Keeper":
                                $response_array = array(
                                    "Code"     => 1,
                                    "Msg"      => "",
                                    "Redirect" => TRUE,
                                    "URL"      => "/school/store/index.php"
                                );
                                break;
                            case "Super_Admin":
                                $response_array = array(
                                    "Code"     => 1,
                                    "Msg"      => "",
                                    "Redirect" => TRUE,
                                    "URL"      => "/school/admin/index.php"
                                );
                                break;
                            case "Secretary":
                                $response_array = array(
                                    "Code"     => 1,
                                    "Msg"      => "",
                                    "Redirect" => TRUE,
                                    "URL"      => "/school/admin/index.php"
                                );
                                break;
                            case "General user":
                                $response_array = array(
                                    "Code"     => 1,
                                    "Msg"      => "",
                                    "Redirect" => TRUE,
                                    "URL"      => "/school/users/staffhomepage.php"
                                );
                                break;
                            default;                                
                        endswitch;
                    endforeach;
                endif;       
            }
    elseif($loginType == 'PARENT'):
        //get the studenet Id for the registration Number provided
        $studentIDQuery = $db->query("SELECT `id` FROM `students` WHERE `registration_number`='{$username}'");
        $queryData = mysqli_fetch_array($studentIDQuery);
        $getStdID  = (int)$queryData['id'];
        //check if the registration number provided exists
        if(mysqli_num_rows($studentIDQuery)==0):
            $err[].="The username does not exist.";
        else:
            //check the password of the student with that ID from the parent login table
            $parentLoginQuery = $db->query("SELECT * FROM `parentlogin` WHERE `studentID`='{$getStdID}'");
            $parentLoginData  = mysqli_fetch_array($parentLoginQuery);
            $getPassword      = $parentLoginData['password'];
            //check whether this is the correct password
            if(!password_verify($password,$getPassword)):
                $err[].="Wrong password! Please try again.";
            endif;
        endif;
        //check if there are any errors
        if(!empty($errors)):
            $response_array = array(
                "Code"     => 0,
                "Msg"      => $err,
                "Redirect" => FALSE,
                "URL"      => ""
            );
        else:
            //create a session that holds the student Id 
            $_SESSION['PARENT_LOGIN_STUDENT_ID'] = base64_encode($getStdID);
            $response_array = array(
                "Code"     => 1,
                "Msg"      => "",
                "Redirect" => TRUE,
                "URL"      => "/school/portal/index.php"
            );
        endif;
    endif; 
    echo json_encode($response_array); 
endif; 
?>