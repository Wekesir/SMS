<!DOCTYPE html>
<html>
    <head>
        <?php include '../admin/header.php';
              include '../admin/navigation.php'; ?>
    </head>
    <body>
        <div class="container-fluid">
            <div class="row">
                <div class="col-md-3">
                    <?php include '../admin/left.php';?>
                </div>
                <div class="col-md-9">
                    <div CLASS="titleHeader text-center">
                        <label for="" class="float-left"><a href="index.php">Back.</a></label>
                        <h6>FULL FINANCIAL REPORT</h6>
                    </div>
                    <div class="row">
                        <div class="col-md-3">
                            <h6 class="text-left">FILTER RESULTS</h6>
                            <div class="form-group">
                                <label for="">Provide Year</label>
                                <input type="number" name="" id="yearInput" value="<?=date("Y")?>"min="2000" max="<?=date("Y")?>" class=form-control>
                            </div>
                            <div class="form-group">
                                <label for="">From Date</label>
                                <input type="date" name="" id="fromDate" max="<?=date("Y-m-d",strtotime(date("Y-m-d").'- 1day'))?>" class=form-control>
                            </div>
                            <div class="form-group">
                                <label for="">To Date</label>
                                <input type="date" name="" id="toDate" class=form-control>
                            </div>
                            <div class="form-group">
                                <Label for="gender">Filter Parameters</Label>
                                <div class="radio">
                                <label for="select" class="radio-inline"><input type="radio"  name="filter" value="year" <?='checked'?>> Year</label>
                                <label for="select" class="radio-inline"><input type="radio"  name="filter" value="date"> Full Date</label>
                                </div>
                            </div>
                            <div class="form-group">
                               <button class="btn btn-sm btn-primary filterBtn"><i class="fas fa-filter"></i> Filter</button>
                            </div>
                        </div>
                        <div class="col-md-9">
                            <div id="dataDiv" style="height: 84vh;overflow:auto;">
                                <h4 class="text-center" style="color:#6682ca;padding-top: 20px;">...data you filter will appear here...</h4>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </body>
</html>

<script>
    jQuery(".filterBtn").click(function(){//when the flter button has been clicked
        var selectedFilter = $("input[type='radio']:checked").val(); 
        var year           = $("#yearInput").val();
        var toDate         = $("#toDate").val();
        var fromDate       = $("#fromDate").val();

        var d1 = new Date(toDate);
        var d2 = new Date(fromDate);

        var filterData     = {
            year : year,
            toDate : toDate,
            fromDate : fromDate,
            parameter : selectedFilter
        }

        if(selectedFilter == "date"){
            if(toDate == "" || fromDate == ""){
                alert("Provide both toDate and fromDate!");
                return;
            }else if(d2 > d1){
                alert("From Date has to be BEFORE To Date");
                return;
            }else{
                $.ajax({
                    url:'/school/admin/helper/filter-report.php',
                    method:'post',
                    data:filterData,
                    success:function(data){
                        $("#dataDiv").html(data);
                    },
                    error:function(){
                        alert("There was an error trying to filter reports");
                    }
                });
            }
        }else{
           if(year == ""){
                alert("Provide the year!");
            }else{
                $.ajax({
                    url:'/school/admin/helper/filter-report.php',
                    method:'post',
                    data:filterData,
                    success:function(data){
                        $("#dataDiv").html(data);
                    },
                    error:function(){
                        alert("There was an error trying to filter reports");
                    }
                });
            } 
        }
    });
</script>