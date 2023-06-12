<!DOCTYPE html>
<html>
<head>
    <?php
        require_once $_SERVER['DOCUMENT_ROOT'].'/school/core/init.php';
        include '../admin/header.php'; ?>
<style>
#expenditureFilterDiv{
    position:absolute;
    right: 2%;
    top: 40px;
    box-shadow: 0 4px 8px 0 rgba(0, 0, 0, 0.2), 0 6px 20px 0 rgba(0, 0, 0, 0.19);
    padding: 5px;
    padding-bottom: 15px;
    background:white;
    display:none;
}
</style>
</head>
<body>   
    <?php include '../admin/navigation.php';?>
 <div class="container-fluid">
    <div class="row">
        <div class="col-md-3">
            <?php include '../admin/left.php';?>
        </div><!--Closing col-md-3 div-->
        <div class="col-md-9 px-2" id="wrapper">
         <div class="row">      
             <div class="col-md-12">
                <div id="menuDiv">
                    <ul>
                        <li class="main_list"><a href="expenditure.php" title="Click to return to expenditures homepage.">Expenditure Homepage</a></li>
                        <li class="main_list"><a href="expenditure.php?add=1" title="Click to add a new school expenditure.">Add new expenditure.</a></li>
                        <li class="main_list"><a href="expenditure.php?filter=1" id="filterBtn" title="Click to view all school financial report.">Filter expenditures</a></li>
                    </ul>
                </div>
                
                <?php
                if(isset($_GET['filter'])){
                    include '../admin/expenditure/filterexpenditure.php';
                }else{
                if(isset($_GET['add']) || isset($_GET['edit'])){
                    include '../admin/expenditure/addexpenditure.php';
                }else{
                    //QUERY FOR GETTING TOTAL EXPENDITURE
                    $year = date('Y');
                    $query = $db->query("SELECT SUM(amount) AS 'AMOUNT' FROM expenditure WHERE YEAR(date_entered)='{$year}'");
                    $queryData =mysqli_fetch_array($query);
                    $totalExpenditure = decimal($queryData['AMOUNT']);
                ?>

                <div>
                    <label class="float-right"> <a href="<?=$_SERVER['PHP_SELF']?>">Reload.</a> </label>
                    <label>Total Expenditure: Kshs. <span class="text-success"><b><?=$totalExpenditure;?></b></span></label>
                </div>
                <div class="scrollable">
                    <?php
                        if(isset($_GET['deleteExpenditure'])){//when the delete button is clicked from the deleteexpenditure modal
                            $id = (int)clean($_GET['deleteExpenditure']);//id of the expenditure to be deleted
                            $db->query("DELETE FROM expenditure WHERE id='$id'");
                            $messages[].='<b>Success! </b>Expenditure deleted.';
                            if(!empty($messages)){
                                displayMessages($messages);
                            }
                        }
                    ?>
                <div id="expenditureFilterDiv">                   
                        <button type="button" class="close float-right" aria-label="Close" onclick="closesearchDiv()">
                        <span aria-hidden="true">&times;</span>
                        </button>       
                        <form action="<?=$_SERVER['PHP_SELF']?>" method="post" id="dateFilterForm">           
                            <div class=row>
                                <div class="col-md-5">
                                    <label for="">From</label>
                                    <input type="date" id="fromDate" class="form-control" required=required>
                                </div>
                                <div class="col-md-5">
                                    <label for="">To:</label>
                                    <input type="date" id="toDate" class="form-control" required=required>
                                </div>
                                <div class="col-md-2">
                                    <input type="submit" id="dateFilterBtn" class="btn btn-default" value="Filter">
                                </div>
                            </div>
                        </form>                             
                </div>

                <table class='table-bordered table table-sm table-hover table-striped'>
                    <thead class="thead-dark">
                        <th></th>
                        <th>DETAILS</th>
                        <th>AMOUNT(Kshs.)</th>
                        <th>DATE</th>
                        <th>ACTIONS</th>
                    </thead>
                    <tbody id="tableBody">
                        <?php 
                        $count=1;
                        $query = $db->query("SELECT * FROM `expenditure` ORDER BY `id` DESC");
                        while ($queryData = mysqlI_fetch_array($query)) : ?>
                            <tr>
                                <td class="text-center"><?=$count;?></td>
                                <td title="<?=$queryData['expenditure']?>"><?=cutstring($queryData['expenditure'], 60);?></td>
                                <td><?=$queryData['amount'];?></td>
                                <td><?=date("jS F, Y", strtotime($queryData['date_entered']))?></td>
                                <td>
                                    <a href="expenditure.php?edit=<?=$queryData['id']?>" class="btn btn-outline-success btn-sm text-success" title="Click to edit expenditure."> <i class="fas fa-pencil-alt"></i>  Edit</a>
                                     <?php if(in_array($logged_in_user_data['permissions'],$allowedAccessArray,true)){?>
                                    <a class="btn btn-outline-danger btn-sm text-danger deleteExpenditure" id="<?=$queryData['id']?>" title="Click to delete expenditure."> <i class="fas fa-trash"></i> Delete</a>
                                    <?php }?>
                                </td>
                            </tr>
                        <?php $count++; endwhile; ?>
                    </tbody>
                </table>
                </div><!--closing scrollable div-->
                    <?php }} ?>
             </div><!--clossing col-md-12 div--->        
         </div><!--closing row div-->         
        </div><!--Closing col-md-9 div-->
    </div><!--Closing row dic-->
 </div><!--closing container div-->
    <?php include '../admin/footer.php';?>
</body>
</html>
<script>
jQuery('#filterBtn').click(function(event){
    event.preventDefault();
    jQuery('#expenditureFilterDiv').fadeIn(1000);
});

jQuery('#dateFilterForm').submit(function(event){
    event.preventDefault();
    var fromDate  =   jQuery('#dateFilterForm #fromDate').val();
    var toDate  =   jQuery('#dateFilterForm #toDate').val(); 
    jQuery.ajax({
        url:'/school/admin/expenditure/filter.php',
        method:'POST',
        data:{fromDate:fromDate,toDate:toDate},
        success:function(data){
            jQuery('#tableBody').html();
            jQuery('#tableBody').html(data);
        },
        error:function(){
                alert("Something went wrong trying to fillter expenditure by date");
        },           
    });
});

function closesearchDiv(){
    jQuery('#expenditureFilterDiv').fadeOut(1000);
}

jQuery('.deleteExpenditure').click(function(){
    var delete_id = jQuery(this).attr("id");//gets the id of the expenditure
        jQuery.ajax({
            url:'/school/modals/deleteexpenditure.php',
            method:'post',
            data:{delete_id:delete_id},
            success:function(data){
                jQuery("body").append(data);//appends the modal to this page
                jQuery('#deleteexpenditureModal').modal({
                    keyboard:false,
                    backdrop:'static'
                });
            },
            error:function(){
                 alert("Something went wrong trying to delete expenditure");
            },           
        });
});   
   
</script>
