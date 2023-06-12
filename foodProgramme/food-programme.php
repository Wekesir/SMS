<!DOCTYPE html>
<html>
<head>
    <?php
        require_once $_SERVER['DOCUMENT_ROOT'].'/school/core/init.php';
        include '../admin/header.php';

        //check if the school has access to thid food programme page
        if($configurationData['food'] == 'NO'){ header("Location:/school/admin/index.php");}
    ?>
    <link rel="stylesheet" href="/school/foodProgramme/styling.css">
</head>
<body>   
    <?php include '../admin/navigation.php';?>
 <div class="container-fluid">
    <div class="row">
        <div class="col-md-3">
            <?php include '../admin/left.php'; ?>
        </div><!--Closing col-md-3 div-->
        <div class="col-md-9" id="wrapper">
           <h5>Food Programme.</h5>
           <div class="row mx-1 bg-light mb-1">
               <div class="col-md-6">
                    <div class="form-row">
                        <?php
                        $foodChargesArray = json_decode($configurationData['food_charges'],true);
                        ?>
                        <div class="form-group col-md-4">
                            <label for="">10 A.M SNACK  </label>
                            <input type="number" class="form-control" name="" min=1 value="<?=$foodChargesArray['MORNING_SNACK']?>" readonly>
                        </div>
                        <div class="form-group col-md-4">
                            <label for=""> LUNCH </label>
                            <input type="number" class="form-control" name="" min=1 value="<?=$foodChargesArray['LUNCH']?>" readonly>
                        </div>
                        <div class="form-group col-md-4">
                            <label for="">4 P.M SNACK </label> 
                            <input type="number" class="form-control" name="" min=1 value="<?=$foodChargesArray['EVENING_SNACK']?>" readonly>
                        </div>
                    </div>
               </div>
               <div class="col-md-6">
                   <div class="form-group">
                    <label for=""><b><i class="fas fa-search"></i> SEARCH STUDENT</b></label>
                    <div class="loader float-right"></div>
                    <input type="search" name="search_student_name_food" placeholder="Student Name" id="" class="form-control">
                   </div>
               </div>
           </div>

            <?php if(!isset($_REQUEST['add-student'])) :?>
           <button class="btn btn-md btn-primary add_food_prog_btn" title="Add student to school food programme."><a href="<?=$_SERVER['PHP_SELF'].'?add-student'?>" style="color:white;"><i class="fas fa-user-plus"></i></a></button>
           <?php endif;?>

           <div id="food_programme_content_div">
                <?php
                    if(isset($_REQUEST['add-student'])):
                        include $_SERVER['DOCUMENT_ROOT'].'/school/foodProgramme/add-student.php';
                    else:
                        include $_SERVER['DOCUMENT_ROOT'].'/school/foodProgramme/home.php';
                    endif;
                ?>
            </div>
        </div><!--Closing col-md-9 div-->
    </div><!--Closing row dic-->
 </div><!--closing container div-->
    <?php include '../admin/footer.php';?>
</body>
</html>


