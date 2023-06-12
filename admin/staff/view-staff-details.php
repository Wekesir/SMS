<?php
    require_once $_SERVER['DOCUMENT_ROOT'].'/school/core/init.php';

    if(isset($_POST['VIEW_ID'])):
        //check if the id is greater than zero
        $id = (int)$_POST['VIEW_ID'];
        if($id == 0):
            $errors[].="<b>Error! </b> There was a problem trying to view user details"; echo displayErrors($errors);
        else:
            $staffQuery = $db->query("SELECT * FROM `users` WHERE `id`='{$id}'");
            //check to see whether the user id exists
            if(mysqli_num_rows($staffQuery) == 0):
                $info[].="<b>Oops! </b>Staff member has not been found"; echo displayInfo($errors);
            else:
                $staffData = mysqli_fetch_array($staffQuery);
                ob_start(); ?>
                <div class="row">
                    <img src="<?=$staffData['image']?>" class="rounded-circle mx-auto d-block img-fluid img-thumbnail my-4" style="height: 150px; width: 150px;" alt="" srcset="">
                </div>
                <div class="row">
                    <div class="col-md-6">               
                        <h6>PERSONAL INFORMATION </h6> <hr>
                        <table class="table table-sm table-borderless">
                        <tbody>
                            <tr>
                            <th scope="row">NAME: </th>
                            <td><?=$staffData['name']?></td>
                            </tr>
                            <tr>
                            <th scope="row">ID. NUMBER</th>
                            <td><?=$staffData['national_id']?></td>
                            </tr>
                            <tr>
                            <th scope="row">BIRTH-DAY</th>
                            <td><?=date("jS F, Y", strtotime($staffData['birth_date']));?></td>
                            </tr>
                            <tr>
                            <th scope="row">GENDER</th>
                            <td><?=$staffData['gender']?></td>
                            </tr>
                            <tr>
                            <th scope="row">PHONE NUMBER</th>
                            <td><?=$staffData['phone']?></td>
                            </tr>
                            <tr>
                            <th scope="row">EMAIL</th>
                            <td> <a href="mailto:"><?=$staffData['email']?></a></td>
                            </tr>
                            <tr>
                            <th scope="row">RESIDENCE</th>
                            <td><?=$staffData['residence']?></td>
                            </tr>
                        </tbody>
                        </table>
                    </div>
                    <div class="col-md-6">
                        <h6>SCHOOL INFORMATION</h6> <hr>
                        <table class="table table-sm table-borderless">
                        <tbody>
                            <tr>
                            <th scope="row">LEVEL: </th>
                            <td><?=rtrim($staffData['name'],',')?></td>
                            </tr>
                            <tr>
                            <th scope="row">TSC. NUMBER</th>
                            <td><?=((!empty($staffData['tsc_number'])?$staffData['tsc_number']:'NULL'));?></td>
                            </tr>
                            <tr>
                            <th scope="row">ACCESS STATUS</th>
                            <td><?php if($staffData['access_status'] ==0){echo 'ACCESS DENIED';}else{echo 'HAS ACCESS';}?></td>
                            </tr>
                            <tr>
                            <th scope="row">CLASS</th>
                            <td><?=rtrim($staffData['class_assigned'], ',')?></td>
                            </tr>
                            <tr>
                            <th scope="row">PHONE NUMBER</th>
                            <td><?=$staffData['phone']?></td>
                            </tr>
                            <tr>
                            <th scope="row">EMAIL</th>
                            <td><?=$staffData['email']?></td>
                            </tr>
                            <tr>
                            <th scope="row">EMP. DATE: </th>
                            <td><?=date("jS F, Y", strtotime($staffData['employed_on']));?></td>
                            </tr>
                        </tbody>
                        </table>
                    </div>
                </div>
                <div class="row">
                    <div class="col-md-12">
                        <button type="button" class="btn btn-info"><i class="fas fa-folder-open"></i> &nbsp; view documents</button>
                    </div>                 
                </div>
                <?php echo ob_get_clean();
            endif;
        endif;
    endif;
?>