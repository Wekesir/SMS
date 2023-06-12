<?php
require_once $_SERVER['DOCUMENT_ROOT'].'/school/core/init.php';
$count = 1;
$feesQ = $db->query("SELECT * FROM `fees_invoices` INNER JOIN `students` WHERE `fees_invoices`.`student_id`=`students`.`id` ORDER BY `fees_invoices`.`id` DESC");
?>
<button class="btn btn-sm btn-info" id="filBtn"> <i class="fas fa-filter"></i> Filter Results</button>
<table class="table table-striped table-bordered table-sm table-hover">
    <thead class="thead-light">
        <th></th>
        <th>STUDENT</th>
        <th>MODE</th>
        <th>AMOUNT(Kshs.)</th>
        <th>PAY. DATE</th>
    </thead>
    <tbody id="tbody">
    <?php while($result = mysqli_fetch_array($feesQ)):?>
        <tr>
            <td><?=$count;?></td>
            <td><?=$result['stdname'];?></td>
            <td><?=$result['mode'];?></td>
            <td><?=decimal($result['amount']);?></td>
            <td><?=date("jS F, Y", strtotime($result['date']));?></td>
        </tr>
     <?php $count++; endwhile;?>
    </tbody>
</table>

<style>
#filBtn{
    padding: 5px;
    position:absolute;
    right:1%;
    top:7%;
    border:none;
    outline:none;
    box-shadow: 0 4px 8px 0 rgba(0, 0, 0, 0.2), 0 6px 20px 0 rgba(0, 0, 0, 0.19);
}
#feesFilterDiv{
    position:absolute;
    right: 1%;
    top: 10%;
    width: 32%;
    background: white;
    padding: 10px;
    box-shadow: 0 4px 8px 0 rgba(0, 0, 0, 0.2), 0 6px 20px 0 rgba(0, 0, 0, 0.19);
}
</style>

<div id="feesFilterDiv" class="d-none">
    <button type="button" class="close" data-dismiss="modal" aria-label="Close" onclick="closeDiv()">
        <span aria-hidden="true">&times;</span>
    </button>
    <div class="text-center"><h6>FILTER RESULTS</h6> <hr></div>       
    <div class="form-group">
        <label for="">Registration Number</label>
        <input type="text" class="form-control" id="regNoInput">
    </div>
    <div class="form-group">
        <label for="">Date Filter</label>
        <div class="radio">
            <label for="date" class="radio-inline"><input type="radio"  name="date" value="single" > Single Date</label>
            <label for="date" class="radio-inline"><input type="radio"  name="date" value="range" > Date Range</label>
            <label for="date" class="radio-inline"><input type="radio"  name="date" value="none" <?="checked";?>> None</label>
        </div>
    </div>
    <div class="form-group d-none" id="singleDiv">
        <label for="">Select Date:</label>
        <input type="date" class="form-control" id="singleDate">
    </div>
    <div class="form-row d-none" id="rangeDiv">
        <div class="form-group col-md-6">
            <label for="date">From Date:</label><br>
            <input type="date" name="" id="fromDate" max="<?=date("Y-m-d",strtotime(date("Y-m-d").'-1 day'));?>" class="form-control">
        </div>
        <div class="form-group col-md-6">
            <label for="date">To Date:</label><br>
            <input type="date" name="" id="toDate" class="form-control">
        </div>
    </div>   
    <div class="form-group">
        <button class="btn btn-sm btn-primary" id="filterBtn">Filter</button>
    </div> 
</div>

<script>
var filterDiv  = $("#feesFilterDiv");

jQuery("#filBtn").click(function(){
    filterDiv.toggleClass("d-none");
    $(this).hide();
});

filterDiv.find("input[type='radio']").click(function(){//search for a click event on a radio button
    var filterType = $(this).val();
    if(filterType=="single"){
        filterDiv.find("#singleDiv").toggleClass("d-none");
        filterDiv.find("#rangeDiv").addClass("d-none");
    }else if(filterType=="range"){
        filterDiv.find("#rangeDiv").toggleClass("d-none");
        filterDiv.find("#singleDiv").addClass("d-none");
    }
});

filterDiv.find("#filterBtn").click(function(e){//when the filter button has been clicked
    e.preventDefault();
    var filter =  $("input[type='radio']:checked").val();
    var fromDate   = filterDiv.find("#fromDate").val();
    var toDate     = filterDiv.find("#toDate").val();
    var singleDate = filterDiv.find("#singleDate").val();
    var regNo      = filterDiv.find("#regNoInput").val();
   
    var filterParam = {
        filter :filter,
        from   : fromDate,
        to     : toDate,
        dateF  : singleDate,
        regNo  : regNo
    };

    if(filter == "range"&&(fromDate==""||toDate=="")){
        alert("If you are filtering using a date range. Provide BOTH from date and to Date.");
        return
    }else if(new Date(fromDate) > new Date(toDate)){//checks to make sure to date comes after from date
        alert("From date can not be greater than to Date");
        return;
    }else{
        jQuery.ajax({
            url:'/school/admin/fetch.php',
            method:"post",
            data:{filterParam:filterParam},
            success:function(data){
                jQuery('#tbody').html(data);
            },
            error:function(){
                alert("Something went wrong trying to filter results");
            }
        });
    }    
});

function closeDiv(){
    $("#feesFilterDiv").toggleClass("d-none");
    jQuery("#filBtn").show();
}
</script>