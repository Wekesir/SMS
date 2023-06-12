<div class="row">
    <div class="col-md-7">

    <div>
                <?php
                //QUERY FOR GETTING TOTAL EXPENDITURE
                    $messages = array();
                    $errors = array();
                    $year = date('Y');
                    $query = $db->query("SELECT SUM(amount) AS 'AMOUNT' FROM expenditure WHERE year='$year'");
                    $queryData =mysqli_fetch_array($query);
                    $totalExpenditure = $queryData['AMOUNT'];

                    $table_query = $db->query("SELECT * FROM expenditure ORDER BY id DESC");
                    ?>
                <label>Total Expenditure: Kshs. <span class="text-success"><b><?=$totalExpenditure;?></b></span></label>
                </div>

                <div class="scrollable">

                <table class='table-striped table-bordered table-highlight full-length'>
                    <thead>
                        <th></th>
                        <th>Details</th>
                        <th>Amount(Kshs.)</th>
                        <th>Date</th>
                    </thead>
                    <tbody id="tableBody">
                        <?php 
                        $count=1;                        
                        while ($queryData = mysqlI_fetch_array($table_query)) : 
                        ?>

                            <tr>
                                <td class="text-center"><?=$count;?></td>
                                <td><?=$queryData['expenditure'];?></td>
                                <td><?=$queryData['amount'];?></td>
                                <td><?=$queryData['date_entered'];?></td>
                            </tr>

                        <?php 
                        $count++;
                        endwhile;
                        ?>
                    </tbody>
                </table>

                  </div><!--closing scrollable div-->

    </div><!---closing col-md-7 div-->
    <div class="col-md-5">
        <div cass="form-group">
            <label for="year">Filter by Year</label>
            <select name="year" id="year" class="form-control">
                <option value=""></option>
                    <?php
                    $year = date('Y');
                    for($years=2010;$years<=$year;$years++):                   
                    ?>
                <option value="<?=$years;?>" <?php if($year==$years){echo 'selected';} ?>><?=$years;?></option>
                    <?php endfor;?>
            </select>
        </div>
    </div><!---closin g col-mg-5 div-->
</div><!---losing row div-->

<script>
jQuery('#year').change(function(){
    var value = jQuery('#year option:selected').val();
    jQuery.ajax({
        url:'/school/admin/expenditure/filter.php',
        method:'post',
        data:{value:value},
        success:function(data){
           jQuery('#tableBody').html();
        },
        error:function(){
            alert("Something went wrong trying to filter expendirure");
        }
    });
});
</script>