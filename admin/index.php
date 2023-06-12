<!DOCTYPE html>
<html>
<head>
    <?php
        require_once $_SERVER['DOCUMENT_ROOT'].'/school/core/init.php';
        include '../admin/header.php'; ?>
</head>
<body>   
    <?php include '../admin/navigation.php';?>
 <div class="container-fluid">
    <div class="row">
        <div class="col-md-3">
            <?php include '../admin/left.php'; ?>
        </div><!--Closing col-md-3 div-->
        <div class="col-md-9 bg-light" id="wrapper">
            <div class="container" style="background:#F5F5F5">
                <section id="info" class="bg-light">
                   <div class="row">
                       <div class="col-md-6 my-auto"><h5>Admin Dashboard</h5></div>
                       <div class="col-md-6">
                            
                            <img src="<?=((isset($logged_in_user_data)&&!empty($logged_in_user_data)?$logged_in_user_data['image']:''))?>" alt="Image" class="rounded-circle img-thumbnail" style="height: 60px;position:relative;width:60px;left:85%;">
                       </div>
                   </div>                   
                </section>
                <section id="population">
                   <div class="container bg-light">
                         <?php
                                $year     = date("Y");

                                $maleStudentQ   = $db->query("SELECT id FROM students WHERE stdgender='MALE' AND accomplished=0 AND deleted=0");
                                $maleCount      = mysqli_num_rows($maleStudentQ); 
                                $femaleStudentQ = $db->query("SELECT id FROM students WHERE stdgender='FEMALE' AND accomplished=0 AND deleted=0");
                                $femaleCount    = mysqli_num_rows($femaleStudentQ); 

                                $totalStudents  = ($maleCount + $femaleCount);
                                $malePerc       = round(($maleCount/$totalStudents)*100);
                                $femalePerc     = round(($femaleCount/$totalStudents)*100);

                                $maleStaffQ          = $db->query("SELECT id FROM users WHERE gender='MALE' AND deleted=0 ");
                                $maleStaffCount      = mysqli_num_rows($maleStaffQ); 
                                $femaleStaffQ        = $db->query("SELECT id FROM users WHERE gender='FEMALE' AND deleted=0");
                                $femaleStaffCount    = mysqli_num_rows($femaleStaffQ); 

                                $totalEmployees      = ($maleStaffCount + $femaleStaffCount);
                                $maleStaffPerc       = round(($maleStaffCount/$totalEmployees)*100);
                                $femaleStaffPerc     = round(($femaleStaffCount/$totalEmployees)*100);

                                $financeQ  = $db->query("SELECT `amount`, `date_entered` FROM `expenditure` WHERE YEAR(date_entered)='{$year}'");
                                $feesQ     = $db->query("SELECT `amount`, `date` FROM `income` WHERE YEAR(`date`)='{$year}'");
                                $current   = array();
                                $feesArray = array();
                                $feesTotal = 0;
                                $currentExpTotal = 0;
                                while($x = mysqli_fetch_array($financeQ)){
                                    $month = date("m", strtotime($x['date_entered'])); //gives the month as an integer
                                    if(!array_key_exists($month,$current)) :
                                      $current[(int)$month] = $x['amount']; 
                                    else:
                                      $current[(int)$month] += $x['amount'];
                                    endif;
                                $currentExpTotal += $x['amount'];  //sums up all the expenditure for this year
                                }
                                while($f = mysqli_fetch_array($feesQ)){
                                    $month = date("m", strtotime($f['date']));
                                    if (!array_key_exists($month,$feesArray)) :
                                        $feesArray[(int)$month]  = $f['amount']; 
                                    else:
                                        $feesArray[(int)$month] += $f['amount'];
                                    endif;
                                $feesTotal += $f['amount'];//sums up all the fees paid this year
                                }
                                

                                $dataPoints = array(
                                    array("label"=> "JANUARY", "y"=> ((array_key_exists(1,$feesArray))?($feesArray[1]/1000):0)),
                                    array("label"=> "FEBRUARY", "y"=> ((array_key_exists(2,$feesArray))?($feesArray[2]/1000):0)),
                                    array("label"=> "MARCH", "y"=> ((array_key_exists(3,$feesArray))?($feesArray[3]/1000):0)),
                                    array("label"=> "APRIL", "y"=> ((array_key_exists(4,$feesArray))?($feesArray[4]/1000):0)),
                                    array("label"=> "MAY", "y"=> ((array_key_exists(5,$feesArray))?($feesArray[5]/1000):0)),
                                    array("label"=> "JUNE", "y"=> ((array_key_exists(6,$feesArray))?($feesArray[6]/1000):0)),
                                    array("label"=> "JULY", "y"=> ((array_key_exists(7,$feesArray))?($feesArray[7]/1000):0)),
                                    array("label"=> "AUGUST", "y"=> ((array_key_exists(8,$feesArray))?($feesArray[8]/1000):0)),
                                    array("label"=> "SEPTEMBER", "y"=> ((array_key_exists(9,$feesArray))?($feesArray[9]/1000):0)),
                                    array("label"=> "OCTOBER", "y"=> ((array_key_exists(10,$feesArray))?($feesArray[10]/1000):0)),
                                    array("label"=> 'NOVEMBER', "y"=> ((array_key_exists(11,$feesArray))?($feesArray[11]/1000):0)),
                                    array("label"=> "DECEMBER", "y"=> ((array_key_exists(12,$feesArray))?($feesArray[12]/1000):0))
                                ); 

                                $expenditre_datapoints = array(
                                    array("label"=> "JANUARY", "y"=> ((array_key_exists(1,$current))?($current[1]/1000):0)),
                                    array("label"=> "FEBRUARY", "y"=> ((array_key_exists(2,$current))?($current[2]/1000):0)),
                                    array("label"=> "MARCH", "y"=> ((array_key_exists(3,$current))?($current[3]/1000):0)),
                                    array("label"=> "APRIL", "y"=> ((array_key_exists(4,$current))?($current[4]/1000):0)),
                                    array("label"=> "MAY", "y"=> ((array_key_exists(5,$current))?($current[5]/1000):0)),
                                    array("label"=> "JUNE", "y"=> ((array_key_exists(6,$current))?($current[6]/1000):0)),
                                    array("label"=> "JULY", "y"=> ((array_key_exists(7,$current))?($current[7]/1000):0)),
                                    array("label"=> "AUGUST", "y"=> ((array_key_exists(8,$current))?($current[8]/1000):0)),
                                    array("label"=> "SEPTEMBER", "y"=> ((array_key_exists(9,$current))?($current[9]/1000):0)),
                                    array("label"=> "OCTOBER", "y"=> ((array_key_exists(10,$current))?($current[10]/1000):0)),
                                    array("label"=> 'NOVEMBER', "y"=> ((array_key_exists(11,$current))?($current[11]/1000):0)),
                                    array("label"=> "DECEMBER", "y"=> ((array_key_exists(12,$current))?($current[12]/1000):0))
                                );  
                                ?>
                       <div class="row">
                            <div class="col-md-6">                               
                                <script>
                                    jQuery(function(){
                                    var chart = new CanvasJS.Chart("chartContainer", {
                                        theme: "light2", // "light1", "light2", "dark1", "dark2"
                                        exportEnabled: true,
                                        animationEnabled: true,
                                        title: {
                                            text: "Male to female students population."
                                        },
                                        data: [{
                                            type: "pie",
                                            startAngle: 25,
                                            toolTipContent: "<b>{label}</b>: {y}%",
                                            showInLegend: "true",
                                            legendText: "{label}",
                                            indexLabelFontSize: 16,
                                            indexLabel: "{label} - {population}",
                                            dataPoints: [
                                                { y: <?=$malePerc?>, label: "Male", population:<?=$maleCount?> },
                                                { y: <?=$femalePerc?>, label: "Female", population:<?=$femaleCount?> }
                                            ]
                                        }]
                                    });
                                    chart.render();
                                    });
                                </script>                                   
                                <div id="chartContainer" style="height: 300px; width: 100%; position:relative; box-shadow:none;"></div>                                    
                            </div>
                            <div class="col-md-6">                   
                                <script>
                                 jQuery(function(){
                                var chart = new CanvasJS.Chart("staffChartContainer", {
                                    theme: "light2", // "light1", "light2", "dark1", "dark2"
                                    exportEnabled: true,
                                    animationEnabled: true,
                                    title: {
                                        text: "Male to female employees population."
                                    },
                                    data: [{
                                        type: "pie",
                                        startAngle: 25,
                                        toolTipContent: "<b>{label}</b>: {y}%",
                                        showInLegend: "true",
                                        legendText: "{label}",
                                        indexLabelFontSize: 16,
                                        indexLabel: "{label} - {population}",
                                        dataPoints: [
                                            { y: <?=$maleStaffPerc?>, label: "Male", population: <?=$maleStaffCount?> },
                                            { y: <?=$femaleStaffPerc?>, label: "Female", population: <?=$femaleStaffCount?> }                                           
                                        ]
                                    }]
                                });
                                chart.render();
                                    });
                                </script>
                                <div id="staffChartContainer" style="height: 300px; width: 100%;"></div>
                            </div>
                       </div>
                   </div>                                       
                </section> 

                <section>
                   <script>
                        window.onload = function () {                        
                        var chart = new CanvasJS.Chart("incomeContainer", {
                            animationEnabled: true,
                            theme: "light2",
                            title:{
                                text: "School Income "+<?=$year?>
                            },
                            axisX:{
                                crosshair: {
                                    enabled: true,
                                    snapToDataPoint: true
                                }
                            },
                            axisY:{
                                title: "In Thousands of Kshs.",
                                includeZero: false,
                                crosshair: {
                                    enabled: true,
                                    snapToDataPoint: true
                                }
                            },
                            toolTip:{
                                enabled: true
                            },
                            data: [{
                                type: "area",
                                dataPoints: <?php echo json_encode($dataPoints, JSON_NUMERIC_CHECK); ?>
                            }]
                        });
                        chart.render();                        
                        }
                    </script>
                    <div id="incomeContainer" style="height: 400px; width: 100%;padding: 20px;"></div>
                </section>

                <section style="height: 500px">
                    <div class="row">
                        <div class="col-md-12">
                            <div class="container">
                                <button class="btn btn-success btn-sm"><a href="full-report.php" style="color:white;">View full Financial Report</a></button>
                                <button class="float-right btn btn-sm btn-default">View Table</button>
                                <script>
                                    $(function(){
                                        var chart = new CanvasJS.Chart("barGraphsContainer", {
                                        animationEnabled: true,
                                        title:{
                                            text: "School Income vs Expenditure, <?=date("Y")?>"
                                        },	
                                        axisY: {
                                            title: "School Income in Thousands",
                                            titleFontColor: "#4F81BC",
                                            lineColor: "#4F81BC",
                                            labelFontColor: "#4F81BC",
                                            tickColor: "#4F81BC"
                                        },
                                        axisY2: {
                                            title: "School Expenditure in Thousands",
                                            titleFontColor: "#C0504E",
                                            lineColor: "#C0504E",
                                            labelFontColor: "#C0504E",
                                            tickColor: "#C0504E"
                                        },	
                                        toolTip: {
                                            shared: true
                                        },
                                        legend: {
                                            cursor:"pointer",
                                            itemclick: toggleDataSeries
                                        },
                                        data: [{
                                            type: "column",
                                            name: "income in Thousands",
                                            legendText: "Income",
                                            showInLegend: true, 
                                            dataPoints:[
                                                { label: "January", y: <?=((array_key_exists(1,$feesArray))?($feesArray[1]/1000):0)?>},
                                                { label: "February", y: <?=((array_key_exists(2,$feesArray))?($feesArray[2]/1000):0)?> },
                                                { label: "March", y: <?=((array_key_exists(3,$feesArray))?($feesArray[3]/1000):0)?> },
                                                { label: "April", y: <?=((array_key_exists(4,$feesArray))?($feesArray[4]/1000):0)?> },
                                                { label: "May", y: <?=((array_key_exists(5,$feesArray))?($feesArray[5]/1000):0)?> },
                                                { label: "June", y: <?=((array_key_exists(6,$feesArray))?($feesArray[6]/1000):0)?> },
                                                { label: "July", y: <?=((array_key_exists(7,$feesArray))?($feesArray[7]/1000):0)?> },
                                                { label: "August", y: <?=((array_key_exists(8,$feesArray))?($feesArray[8]/1000):0)?> },
                                                { label: "September", y: <?=((array_key_exists(9,$feesArray))?($feesArray[9]/1000):0)?> },
                                                { label: "October", y: <?=((array_key_exists(10,$feesArray))?($feesArray[10]/1000):0)?> },
                                                { label: "November", y: <?=((array_key_exists(11,$feesArray))?($feesArray[11]/1000):0)?> },
                                                { label: "December", y: <?=((array_key_exists(12,$feesArray))?($feesArray[12]/1000):0)?> }
                                            ]
                                        },
                                        {
                                            type: "column",	
                                            name: "Expenditure in Thousands",
                                            legendText: "Expenditure",
                                            axisYType: "secondary",
                                            showInLegend: true,
                                            dataPoints:[
                                                { label: "January", y: <?=((array_key_exists(1,$current))?($current[1]/1000):0)?>},
                                                { label: "February", y: <?=((array_key_exists(2,$current))?($current[2]/1000):0)?> },
                                                { label: "March", y: <?=((array_key_exists(3,$current))?($current[3]/1000):0)?> },
                                                { label: "April", y: <?=((array_key_exists(4,$current))?($current[4]/1000):0)?> },
                                                { label: "May", y: <?=((array_key_exists(5,$current))?($current[5]/1000):0)?> },
                                                { label: "June", y: <?=((array_key_exists(6,$current))?($current[6]/1000):0)?> },
                                                { label: "July", y: <?=((array_key_exists(7,$current))?($current[7]/1000):0)?> },
                                                { label: "August", y: <?=((array_key_exists(8,$current))?($current[8]/1000):0)?> },
                                                { label: "September", y: <?=((array_key_exists(9,$current))?($current[9]/1000):0)?> },
                                                { label: "October", y: <?=((array_key_exists(10,$current))?($current[10]/1000):0)?> },
                                                { label: "November", y: <?=((array_key_exists(11,$current))?($current[11]/1000):0)?> },
                                                { label: "December", y: <?=((array_key_exists(12,$current))?($current[12]/1000):0)?> }
                                            ]
                                        }]
                                    });
                                    chart.render();
                                    function toggleDataSeries(e) {
                                        if (typeof(e.dataSeries.visible) === "undefined" || e.dataSeries.visible) {
                                            e.dataSeries.visible = false;
                                        }
                                        else {
                                            e.dataSeries.visible = true;
                                        }
                                        chart.render();
                                    }
                                    });
                                </script>
                                <div id="barGraphsContainer" style="height: 400px; width: 100%;top: 100%;-ms-transform: translateY(10%);transform: translateY(10%);"></div>
                            </div>
                        </div>
                        <div class="d-none" id="tableDiv">
                            <table class="table table-hover table-striped table-sm ">
                                <thead class="thead-light">
                                    <th>MONTH</th>
                                    <th>EXPENDITURE(Kshs.)</th>
                                    <th>INCOME(Kshs.)</th>
                                </thead>
                                <tbody>
                                    <?php                                  
                                    for($i=1;$i<=12;$i++):
                                        $dt = DateTime::createFromFormat('!m',$i);
                                        ?>
                                        <tr <?=(date("m")==$i)?' class="table-info"':''?>>
                                            <td><?=$dt->format("F");?></td>
                                            <td><?=((array_key_exists($i,$current))?decimal($current[$i]):decimal(0))?></td>
                                            <td><?=((array_key_exists($i,$feesArray))?decimal($feesArray[$i]):decimal(0))?></td>
                                        </tr>
                                    <?php 
                                    endfor;?>
                                        <tr>
                                            <td><b>TOTAL</b></td>
                                            <td><?=decimal($currentExpTotal)?></td>
                                            <td><?=decimal($feesTotal)?></td>
                                        </tr>
                                </tbody>
                            </table>
                        </div>
                    </div>
                </section>

                <section>
                <div class="row py-3">
                    <div class="col-md-12">
                        <h2>School events</h2> <hr>
                        <?php
                        $eventQ        = $db->query("SELECT * FROM `events` ORDER BY `id` ASC");
                        $maxEventLimit = 10;//number of rows to be displayed on each page
                        $totalEvents   = mysqli_num_rows($eventQ);
                        $eventPage     = (int)((isset($_GET['event_page'])? $_GET['event_page']: 1));//gets the page number from the url
                        $minLimit      = ($eventPage - 1) * $maxEventLimit;
                        $totalPages    = ceil($totalEvents / $maxEventLimit);
                        ?>
                        <nav aria-label="...">
                        <ul class="pagination pagination-sm">
                            <li class="page-item disabled">
                            <span class="page-link">Previous</span>
                            </li>
                            <?php for($p = 1; $p <= $totalPages; $p++) :?>
                            <li class="page-item"><a class="page-link" href="index.php?event_page=<?=$p;?>"><?=$p;?></a></li>
                            <?php endfor;?>
                            <li class="page-item">
                            <a class="page-link" href="#">Next</a>
                            </li>
                        </ul>
                        </nav>
                        <table class="table table-sm table-hover table-striped">
                            <thead class="thead-light">
                                <th></th>
                                <th> EVENT</th>
                                <th> START EVENT</th>
                                <th> END EVENT</th>
                                <th> STATUS</th>
                            </thead>
                            <tbody style="max-height: 600px;overflow:auto;">
                                <?php
                                $count=1;                              
                                while($eventData = mysqli_fetch_array($eventQ)):
                                ?>
                                <tr <?=(($todayDateTime > $eventData['end_event']?'class="table-default"':''));?>>
                                    <th><?=$count?></th>
                                    <td><?=$eventData['title'];?></td>
                                    <td><i class="fas fa-hourglass-start text-primary"></i> <?=$eventData['start_event'];?></td>
                                    <td><i class="fas fa-hourglass-end text-danger"></i> <?=$eventData['end_event'];?></td>
                                    <td>
                                        <?php
                                        if($eventData['status']=='completed'):
                                            echo '<span class="badge badge-info">'.$eventData['status'].'</span>';
                                        elseif($eventData['status']=='progress'):
                                            echo '<span class="badge badge-success">'.$eventData['status'].'</span>';
                                        else://status 'awaiting'
                                            echo '<span class="badge badge-warning">'.$eventData['status'].'</span>';
                                        endif;
                                        ?>
                                    </td>
                                </tr>
                                <?php $count++; endwhile;?>
                            </tbody>
                        </table>
                        <button class="btn btn-sm btn-primary"><a href="/school/admin/calendar.php" style="color:white;" title="Click to view school calendar">School Calendar</a></button>
                    
                        <!-- <div class="count-up">
                            <p class="counter-count text-success">200</p>
                            <h3 class="text-shadow">ONLINE USERS</h3>                          
                        </div> -->
                    </div>
                </div>
                </section>

                <section id="schoolCalendar">
                    <h2>School calendar</h2> <hr>
                </section>
            </div>
        </div><!--Closing col-md-9 div-->
    </div><!--Closing row dic-->
 </div><!--closing container div-->
    <?php include '../admin/footer.php';?>
</body>
</html>
<script>

jQuery(function(){
    var onlineUsers = "";
    $.ajax({
        url:'/school/admin/fetch.php',
        method:'post',
        data:{onlineUsers:onlineUsers},
        success:function(data){
            $(".counter-count").html(data);
            $('.counter-count').each(function () {
            $(this).prop('Counter',0).animate({
                Counter: $(this).text()
            }, {            
            //change count up speed here
                duration: 4000,
                easing: 'swing',
                step: function (now) {
                    $(this).text(Math.ceil(now));
                }
            });
        });
        },
        error:function(){
            alert("There was an error getting the number of online users.");
        }
    });
});

</script>

<style>
section{
    margin-bottom: 80px;
    padding: 10px;
    background-color:white;
    height:auto;
}
</style>
