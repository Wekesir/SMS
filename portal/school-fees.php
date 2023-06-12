<?php
require_once $_SERVER['DOCUMENT_ROOT'].'/school/core/init.php';
 $installationYear = date("Y",strtotime($configurationData['installed_on']));
 $rowCount=1;
 $year = date("Y");
 $feesQuery = $db->query("SELECT * FROM `school_fees` ORDER BY `id` DESC");
 //if thre is no record of the school fees
 if(mysqli_num_rows($feesQuery) == 0):
    $info[].='<b>Oops! </b>There is no school fees information provided by school administration.';
    displayInfo($info);
 endif;
?>

<div id="feesLandingPage">
    <?php
    if(isset($_REQUEST['year'])):
       $urlYear = $_REQUEST['year'];
       //ensure the year is between current year and the year the system was installed
       if($urlYear>$year || $urlYear<$installationYear):
            $error[].='<b>Warning!</b> You are interferring with the system integrity';
            displayErrors($errors);
       else:
            $specificYearQuery = $db->query("SELECT * FROM `school_fees` WHERE `year`='{$urlYear}'");
            $data = mysqli_fetch_array($specificYearQuery);
            $term1Array = json_decode($data['term1'],true);
            $term2Array = json_decode($data['term2'],true);
            $term3Array = json_decode($data['term3'],true); 
            foreach($term1Array as $x):
              print_r($x[1]);
            endforeach;
            ?>
                <table class="table table-sm table-responsive{-sm} table-hover table-bordered">
                    <thead class="thead-dark">
                        <tr>
                        <th scope="col">#</th>
                        <th scope="col">LEVEL</th>
                        <th scope="col">TERM 1</th>
                        <th scope="col">TERM 2</th>
                        <th scope="col">TERM 3</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php
                        $gradeArray = array();
                        $gradeQuery = ($db->query("SELECT `grade` FROM `grade`"));
                        while($grade = mysqli_fetch_array($gradeQuery)):
                            $gradeArray[]=$grade['grade'];                       
                        ?>
                        <tr>
                        <th scope="row"><?=$rowCount?></th>
                        <td><?=$gradeArray[(int)($rowCount-1)]?></td>
                        <td>Mark</td>
                        <td>Otto</td>
                        <td>@mdo</td>
                        </tr>
                        <?php $rowCount++; endwhile;?>
                    </tbody>
                </table>
            <?php
       endif;
    else:    
    ?>
    <table class="table table-hover table-responsive{-sm} table-bordered">
        <thead class="thead-dark">
            <tr>
            <th scope="col">#</th>
            <th scope="col">SCHOOL FEES</th>
            <th scope="col">YEAR</th>
            <th scope="col">VIEW</th>
            </tr>
        </thead>
        <tbody>
            <?php while($feesData = mysqli_fetch_array($feesQuery)):?>
            <tr>
            <th scope="row"><?=$rowCount;?></th>
            <td>FEES</td>
            <td><?=$feesData['year']?></td>
            <td> <a href="<?=$_SERVER['PHP_SELF'].'?year='.$feesData['year']?>" title="View fees for <?=$feesData['year']?>" class="btn btn-md btn-outline-primary px-5"><i class="fas fa-arrow-right"></i></a> </td>
            </tr>
            <?php $rowCount++; endwhile;?>
            <tr>
        </tbody>
    </table>
    <?php endif;?>
</div>
<style>
#feesLandingPage{
    padding: 20px;
    width: 100%;
    border: 2px solid #dcdcdc;
    height: 86vh;
    overflow:auto;
}
</style>