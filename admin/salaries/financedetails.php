

   

        
 

<style>
#slidescontainerDiv{
    position:relative;
    top: 0px;
    left: 10%;
    width: 80%;
    padding: 0px;
    min-height: 83.4vh;
    box-shadow: 0 4px 8px 0 rgba(0, 0, 0, 0.2), 0 6px 20px 0 rgba(0, 0, 0, 0.19);    
}
#slidescontainerDiv > #slide1{
    width: 100%;
    height: 100%;
    margin-right: 30px;
    display:block;
    float:left;
    padding: 15px;
}
#slidescontainerDiv > #slide2{
    width: 100%;
    height: 100%;
    margin-right: 30px;
    display:none;
    float:left;
    padding: 15px;
}
#header{
    background: #f8f8f8;
    padding: 10px;
    text-align:center;
    color:black;
}
#slidescontainerDiv #addBtn{
    border-radius: 50%;
    position:fixed;
    right:12%;
    bottom: 5%;
    padding: 10px;
    box-shadow: 0 4px 8px 0 rgba(0, 0, 0, 0.2), 0 6px 20px 0 rgba(0, 0, 0, 0.19);
}
</style>
 <?php
        $staffId = (int)((isset($_REQUEST['searchstaff'])?$_REQUEST['searchstaff'] :''));///staff ID from the URL

        $date = date('Y-m-d');

        $accountsQuery = $db->query("SELECT * FROM staff_accounts WHERE staff_id =$staffId");
        $staffQuery    = $db->query("SELECT * FROM users WHERE id=$staffId");

        $staffData        = mysqli_fetch_array($staffQuery);
        $staffAccountData = mysqli_fetch_array($accountsQuery);

        $salary        = $staffAccountData['salary'];//gets the user set salary
        ?>

<div id="slidescontainerDiv">
    <div id="slide1">

        <h6 id="header"> <?=$staffData['name']."'s"?> FINANCIAL REPORT</h6>
        <button class="btn btn-primary" id="addBtn" ><i class="fas fa-plus"></i></button>     

        <table class="table-striped table-bordered table-highlight full-length">
            <thead>
                <th>#</th>
                <th>DATE</th>
                <th>DETAILS</th>
                <th>AMOUNT(Kshs.)</th>
            </thead>
            <tbody>
                        <?php 
                        $count=1;
                        $query= $db->query("SELECT * FROM staff_invoices WHERE staff_id='$staffId' ORDER BY id DESC");
                        while($queryData = mysqli_fetch_array($query)) :?>
                            <tr>
                                <td class="text-center"><?=$count;?></td>
                                <td><?=$queryData['date'];?></td>
                                <td><?=$queryData['details'];?></td>
                                <td><?=$queryData['amount'];?></td>
                            </tr>
                        <?php
                        $count++;
                        endwhile;
                            ?>
            </tbody>
        </table>
    </div><!--closing div 1 slide-->
    <div id="slide2">
        <h6 id="header">
        <label class="float-left dropSlide"> <a href="#">Drop</a> </label>
        <label>ENTER NEW CHARGE</label>
        </h6>

        <div id="infoDiv"></div>

        <form action="salaries.php?searchstaff=<?=$staffId;?>" method="POST">
            <div class="form-group">
                <label for="description">Choose advance or damage*.</label>
                <select name="description" id="description" class="form-control" required=required>
                    <option value=""></option>
                    <option value="SALARY ADVANCE">Salary Advance</option>
                    <option value="DAMAGES">Damages</option>
                </select>
            </div>
            <div class="form-group">
                <label for="details">Enter details for the amount</label>
                <textarea name="details" id="details" class="form-control" rows="5" requied=required></textarea>
            </div>
            <div class="form-group">
                <label for="amount">Amount(Kshs.)*</label>
                <input type="number" name="amount" min=0 class="form-control" required=required>
            </div>
            <div class="form-group">
                <input type="submit" class="btn btn-md btn-primary" name="submit">
            </div>
        </form>
    </div><!---closing div 2 slide-->
</div><!--clsoging the container holding the slidea-->


<script>
    jQuery('form').submit(function(event){
        event.preventDefault();
        var formData    =   jQuery(this).serialize();
        jQuery.ajax({
            url:'/school/admin/salaries/insert.php',
            method:'post',
            data:formData,
            success:function(data){
                jQuery('#infoDiv').html(data);
            },
            error:function(){
                alert("Something went wrong trying to submit form data");
            }
        });
    });

    jQuery('#addBtn').click(function(){
        $('#slide2').slideDown(500);
        $('#slide1').slideUp(500);   
    });
    jQuery('.dropSlide').click(function(event){
        event.preventDefault();
        $('#slide2').slideUp(500);
        $('#slide1').slideDown(500); 
    });
</script>



