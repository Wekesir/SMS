<!DOCTYPE html>
<html>
<head>
    <?php
        require_once $_SERVER['DOCUMENT_ROOT'].'/school/core/init.php';
         include '../admin/header.php';?>
</head>
<body>   
    <?php include '../admin/navigation.php';?>
 <div class="container-fluid">
    <div class="row">
        <div class="col-md-3 bg-dark">
            <?php include '../admin/left.php';?>
        </div><!--Closing col-md-3 div-->
        <div class="col-md-9" id="wrapper">

           <div class="form-group">
                <h6><b><?=((isset($_GET['edit']))?'EDIT ':'ADD ')?>TERM DATES</b></h6>
            </div>
            <div id="menuDiv">
                <ul>
                    <li class="main_list"><a href="dates.php" title="Click to return to dates homepage.">Term Dates.</a></li>
                    <li class="main_list"><a href="dates.php?edit=1" title="Click to edit school term dates.">Edit term dates</a></li>
                    <li class="main_list"><a href="calendar.php" title="Click to view school calendar.">School Calendar</a></li>
                </ul>
            </div>
            <?php  
                    $year=date('Y');//current year
                    $date=date('Y-m-d H:i:s');//current date and time

                    //checks if the dates for the current year have been set
                    $checkQuery=$db->query("SELECT * FROM term_dates WHERE year='$year'");

                    if(!isset($_GET['edit'])){//makes sure the function only runs when the edit button has not been cliked
                        if(mysqli_num_rows($checkQuery)>0){?>
                            <script>
                                setTimeout(() => {
                                        alert("Term dates for this year have been set, try editing instead!");
                                        window.location='/school/admin/dates.php?edit=1';
                                }, 1000);                          
                            </script>
                   <?php }}
                    //end of checking term dates

            
                if(isset($_GET['edit'])){//if edit dates is clicked
                    $term1Opening=trim(clean(((isset($_POST['openingterm1'])?$_POST['openingterm1']:''))));
                    $term1closing=trim(clean(((isset($_POST['closingterm1'])?$_POST['closingterm1']:''))));
                    $term2opening=trim(clean(((isset($_POST['openingterm2'])?$_POST['openingterm2']:''))));
                    $term2closing=trim(clean(((isset($_POST['closingterm2'])?$_POST['closingterm2']:''))));
                    $term3opening=trim(clean(((isset($_POST['openingterm3'])?$_POST['openingterm3']:''))));
                    $term3closing=trim(clean(((isset($_POST['closingterm3'])?$_POST['closingterm3']:''))));
                    $year=date('Y');//current year
                    $date=date('Y-m-d H:i:s');//current date and time

                    $dateQuery=$db->query("SELECT * FROM term_dates WHERE year='$year'");

                    if(mysqli_num_rows($dateQuery)==0){?><!--checks if there is term data for this year and if none exists it redirects-->
                       <script>
                                setTimeout(() => {
                                        alert("Term dates for this year have not been set, try adding instead!");
                                        window.location='/school/admin/dates.php';
                                }, 500);                          
                        </script>
                        <?php
                    }else{                    
                        $dateQueryData=mysqli_fetch_array($dateQuery);
                        $term1Decoded=json_decode($dateQueryData['term1'],true);
                        $term2Decoded=json_decode($dateQueryData['term2'],true);
                        $term3Decoded=json_decode($dateQueryData['term3'],true);

                        foreach($term1Decoded as $term1){
                            $term1OpeningDate=$term1['openingDate'];
                            $term1ClosingDate=$term1['closingDate'];
                        }
                        foreach($term2Decoded as $term2){
                            $term2OpeningDate=$term2['openingDate'];
                            $term2ClosingDate=$term2['closingDate'];
                        }
                        foreach($term3Decoded as $term3){
                            $term3OpeningDate=$term3['openingDate'];
                            $term3ClosingDate=$term3['closingDate'];
                        }

                        if(isset($_POST['update'])){//the update button
                            $term1Opening=trim(clean(((isset($_POST['openingterm1'])?$_POST['openingterm1']:$term1OpeningDate))));
                            $term1closing=trim(clean(((isset($_POST['closingterm1'])?$_POST['closingterm1']:$term1ClosingDate))));
                            $term2opening=trim(clean(((isset($_POST['openingterm2'])?$_POST['openingterm2']:$term2OpeningDate))));
                            $term2closing=trim(clean(((isset($_POST['closingterm2'])?$_POST['closingterm2']:$term2ClosingDate))));
                            $term3opening=trim(clean(((isset($_POST['openingterm3'])?$_POST['openingterm3']:$term3OpeningDate))));
                            $term3closing=trim(clean(((isset($_POST['closingterm3'])?$_POST['closingterm3']:$term3ClosingDate))));
                            $date=date('Y-m-d H:i:s');//current date and time

                            $term1EditedArray[]=array(
                                'openingDate' => $term1Opening,
                                'closingDate' => $term1closing,
                            );
                            $term2EditedArray[]=array(
                                'openingDate' => $term2opening,
                                'closingDate' => $term2closing,
                            );
                            $term3EditedArray[]=array(
                                'openingDate' => $term3opening,
                                'closingDate' => $term3closing,
                            );

                            $term1EncodedEdit=json_encode($term1EditedArray);//ecnoded data for the edited term date
                            $term2EncodedEdit=json_encode($term2EditedArray);//ecnoded data for the edited term date
                            $term3EncodedEdit=json_encode($term3EditedArray);//ecnoded data for the edited term date

                            $db->query("UPDATE term_dates SET term1='{$term1EncodedEdit}',term2='{$term2EncodedEdit}',term3='{$term3EncodedEdit}',edited_on='$date' WHERE year='$year'");
                            $messages[].='<b>Success! </b>Term dates updated successfully.';
                            if(!empty($messages)){
                                displayMessages($messages);
                            }

                        }//This is the end of the update button
                    }

                }//end  edit is set function
                
                if(isset($_POST['submit'])){//if the submit button has been clicked
                    
                        $term1Opening=trim(clean(((isset($_POST['openingterm1'])?$_POST['openingterm1']:''))));
                        $term1closing=trim(clean(((isset($_POST['closingterm1'])?$_POST['closingterm1']:''))));
                        $term2opening=trim(clean(((isset($_POST['openingterm2'])?$_POST['openingterm2']:''))));
                        $term2closing=trim(clean(((isset($_POST['closingterm2'])?$_POST['closingterm2']:''))));
                        $term3opening=trim(clean(((isset($_POST['openingterm3'])?$_POST['openingterm3']:''))));
                        $term3closing=trim(clean(((isset($_POST['closingterm3'])?$_POST['closingterm3']:''))));
                   

                    $term1Array[]=array(//array containing term opening and closing dates
                        'openingDate' => $term1Opening,
                        'closingDate' => $term1closing,
                    );
                    $term2Array[]=array(//array containing term opening and closing dates
                        'openingDate' => $term2opening,
                        'closingDate' => $term2closing,
                    );
                    $term3Array[]=array(//array containing term opening and closing dates
                        'openingDate' => $term3opening,
                        'closingDate' => $term3closing,
                    );

                    $term1Encoded=json_encode($term1Array);//ecnodes asscoiative array to json string
                    $term2Encoded=json_encode($term2Array);//ecnodes asscoiative array to json string
                    $term3Encoded=json_encode($term3Array);//ecnodes asscoiative array to json string


                    $required_info=array($term1Opening,$term1closing,$term2opening,$term2closing,$term3opening,$term3closing);
                    foreach($required_info as $info){
                        if($info == ''){
                            $errors[].='<b>Error! </b>Please provide all information.';
                            break;
                        }
                    }

                    if(!empty($errors)){//check for errors ans display them
                        displayErrors($errors);
                    }else{

                        $db->query("INSERT INTO term_dates (term1,term2,term3,year,insert_on)
                                    VALUES ('{$term1Encoded}','{$term2Encoded}','{$term3Encoded}','$year','$date')");

                        $messages[].='<b>Success! </b>Dates inserted successfully.';
                        if(!empty($messages)){
                                displayMessages($messages);
                         }

                    }
                }//end of submit function
            ?>

            <form action="<?=((isset($_GET['edit'])?'dates.php?edit=1':'dates.php'));?>" method="POST">
                <table class="table table-bordered">
                    <thead class="thead-light">
                        <th>TERM</th> <th>OPENING DATE</th> <th>CLOSING DATE</th>
                    </thead>
                        <tr>
                            <td>Term 1</td>
                            <td> <input type="date" name="openingterm1" id="openingterm1" class="form-control" value="<?=$term1OpeningDate;?>" required=required> </td>
                            <td> <input type="date" name="closingterm1" id="closingterm1" class="form-control" value="<?=$term1ClosingDate;?>" required=required> </td>
                        </tr>
                        <tr>
                            <td>Term 2</td>
                            <td> <input type="date" name="openingterm2" id="openingterm2" class="form-control" value="<?=$term2OpeningDate;?>" required=required> </td>
                            <td> <input type="date" name="closingterm2" id="closingterm2" class="form-control" value="<?=$term2ClosingDate;?>" required=required> </td>
                        </tr>
                        <tr>
                            <td>Term 3</td>
                            <td> <input type="date" name="openingterm3" id="openingterm3" class="form-control" value="<?=$term3OpeningDate;?>" required=required> </td>
                            <td> <input type="date" name="closingterm3" id="closingterm3" class="form-control" value="<?=$term3ClosingDate;?>" required=required> </td>
                        </tr>
                 </table>
                 <input type="submit" class="btn btn-sm btn-primary" name="<?=((isset($_GET['edit'])?'update':'submit'));?>" value="<?=((isset($_GET['edit'])?'Update Database':'Submit'));?>">
            </form>

        </div><!--Closing col-md-9 div-->
    </div><!--Closing row dic-->
 </div><!--closing container div-->
    <?php include '../admin/footer.php';?>
</body>
</html>