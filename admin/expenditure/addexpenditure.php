<div class="addexpensediv" style="padding:30px;position:absolute;left:20%;width:60%;box-shadow: 5px 5px lightgrey;">

                <h6 class="text-center" style="color:black;background:#f8f8f8;padding:10px;">                
                    <label><?=((isset($_GET['edit'])?'EDIT EXPENDITURE.' :'ENTER A NEW EXPENDITURE.'));?></label>
                </h6>

                <?php
                 $date        = date('Y-m-d');

                 $expenditure = clean(trim(((isset($_POST['expenditure'])? strtoupper($_POST['expenditure']) : ''))));
                 $amount      = clean(trim(((isset($_POST['amount'])? $_POST['amount'] : ''))));
                 

                 //if the edit button has been clicked
                 if(isset($_GET['edit'])){
                     $editId = (int)clean($_GET['edit']);//id of the expenditure to be edited
                     $query = $db->query("SELECT * FROM expenditure WHERE id='$editId'");
                     $queryData =mysqli_fetch_array($query);

                     $expenditure = clean(trim(((isset($_POST['expenditure'])? strtoupper($_POST['expenditure']) : $queryData['expenditure']))));
                     $amount      = clean(trim(((isset($_POST['amount'])? $_POST['amount'] : $queryData['amount']))));

                     //if the update button is clicked
                     if(isset($_POST['update'])){
                        $db->query("UPDATE expenditure SET expenditure='$expenditure',amount='$amount'
                                    WHERE id='$editId'");
                        $messages[].='<b>Success! </b>Expenditure updated.';
                        if(!empty($messages)){
                            displayMessages($messages);
                        }
                     }
                 }


                    if(isset($_POST['submit'])){              
                                    
                         $db->query("INSERT INTO expenditure (expenditure, amount, date_entered)
                                    VALUES ('$expenditure','$amount','$date')");
                        $messages[].='<b>Success! </b>New expenditure added.';
                        if(!empty($messages)){
                            displayMessages($messages);
                        }            

                    }
                ?>

                <form action="<?=((isset($_GET['edit'])?'expenditure.php?edit='.$queryData['id'].'':'expenditure.php?add=1'))?>" method="POST">
                        <div class="form-group">
                            <label for="expedniture">Expenditure*</label>
                            <textarea name="expenditure" id="expenditure" rows="5" class="form-control" placeholder="Description" value="<?=$expenditure;?>" required=required><?=$expenditure;?></textarea>
                        </div>
                        <div class="form-group">
                            <label for="amount">Amount*</label>
                            <input type="text" name="amount" class="form-control" value="<?=$amount;?>" required=required>
                        </div>
                        <div class=="form-group">
                            <button class="btn btn-sm btn-default"> <a href="expenditure.php" class="text-danger">Cancel</a></button>
                            <input type="submit" class="btn btn-sm btn-primary" name="<?=((isset($_GET['edit'])?'update':'submit'))?>" value="<?=((isset($_GET['edit'])?'Update Expenditure':'Submit'))?>">
                        </div>
                </form>

</div><!---CLosing col-md-5 div--->