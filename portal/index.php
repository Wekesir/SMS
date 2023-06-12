<?php 
include '../portal/header.php';
require_once $_SERVER['DOCUMENT_ROOT'].'/school/core/init.php';
include '../portal/navigation.php';?>
<div class="container-fluid">
    <div class="row">
        <div class="col-md-3">
        <?php include '../portal/sidenav.php';?>
        </div>
        <div class="col-md-9 mainContainer">
            <h5 class="p-3 mb-2 text-primary">Student Profile.</h5>
            <div class="row m-3">
                <div class="col-md-6 text-center">
                    <img src="<?=$studentData['stdimage']?>" style="height:400px;width:400px;" class="img-thumbnail rounded mx-auto" alt="">
                </div>
                <div class="col-md-6">
                    <h4 class="text-primary">STUDENT INFORMATION</h4> <hr>
                    <table class="table table-striped">
                        <tbody>
                             <tr>
                            <th scope="row">Student ID:</th>
                            <td><?=$studentData['registration_number']?></td>
                            </tr>
                            <tr>
                            <th scope="row">Name:</th>
                            <td><?=$studentData['stdname']?></td>
                            </tr>
                            <tr>
                            <th scope="row">Current Level:</th>
                            <td><?=$studentData['stdgrade']?></td>
                            </tr>
                            <tr>
                            <th scope="row">DOB:</th>
                            <td><?=date("jS F, Y", strtotime($studentData['stddob']));?></td>
                            </tr>
                             <tr>
                            <th scope="row">Gender:</th>
                            <td><?=$studentData['stdgender'];?></td>
                            </tr>
                             <tr>
                            <th scope="row">Admission Date:</th>
                            <td><?=date("jS F, Y", strtotime($studentData['doa']));?></td>
                            </tr>
                             <?php if($studentData['accomplished'] ==1){?>   <!--if he student has completed schol then show this-->  
                                <tr>
                                <td>Accomplished Year:</td> <td> <b> <?=$studentData['accomplished_year'];?> </b> </td>
                            </tr>    
                            <?php }?>   
                            <?php if($studentData['deleted'] ==1){?>   <!--if he student has completed schol then show this-->  
                                <tr>
                                <td>Transfer Date:</td> <td> <b> <?=date("jS F, Y", strtotime($studentData['delete_date']))?> </b> </td>
                            </tr>    
                            <?php }?> 
                            <tr>
                            <th scope=row>STATUS:</th>
                            <td>
                            <?php
                            if($studentData['accomplished'] ==1):
                                    echo '<span class="badge badge-primary">Accomplished</span>';
                            elseif($studentData['deleted'] ==1):
                                echo '<span class="badge badge-info">Transferred</span>';
                            else:
                                echo '<span class="badge badge-success">In session</span>';
                            endif;
                            ?>
                            </td>
                            </tr>    
                        </tbody>
                        </table>
                </div>
            </div>
            <div class="row">
                <div class="col-md-9">
                <div><h5 class="p-3">Guardian(s) Details</h5></div>
                <table class="table table-bordered table-striped float-left">
                    <tbody>
                        <tr>
                         <th scope="row">Guardian Name:</th>
                         <td><?=$studentData['parname']?></td>
                        </tr>
                        <tr>
                         <th scope="row">2nd Guardian:</th>
                         <td><?=(($studentData['parname2']=="")? "NULL":$studentData['parname2'])?></td>
                        </tr>
                         <tr>
                         <th scope="row">Phone Number(s):</th>
                         <td><?=$studentData['contacts']?></td>
                        </tr>
                        <tr>
                         <th scope="row">ID Number:</th>
                         <td><?=$studentData['idnumber']?></td>
                        </tr>
                        <tr>
                         <th scope="row">Postal Address:</th>
                         <td><?=(($studentData['stdpostal']=="")? "NULL":$studentData['stdpostal'])?></td>
                        </tr>
                        <tr>
                         <th scope="row">Residence:</th>
                         <td><?=$studentData['paraddress']?></td>
                        </tr>                       
                    </tbody>
                </table>
                </div>
            </div>
        </div>
    </div>
</div>
<?php include '../portal/footer.php';?>