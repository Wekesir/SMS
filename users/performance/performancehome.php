<?php
$count  =   1;

$performanceQuery   =   $db->query("SELECT * FROM students,formerstudents_marks 
                                    WHERE students.id=formerstudents_marks.student_id ORDER BY formerstudents_marks.total DESC");
?>

<h6 class="text-center" style="background:#f8f8f8;padding:10px;">
    <label id="filterIcon" class="float-left btn-default" title="Filter marks."><i class="fas fa-filter"></i>Filter</label>
    <label>ALL STUDENT MARKS</label>
    <label id="searchIcon" class="float-right btn-default" title="Search student by name."><i class="fas fa-search"></i>Search</label>
</h6>

<div id="searchDiv" class="form-inline" style="display:none;">
    <input type="search" class="form-control"><a href=# id="slideUpBtn" class="btn-default btn"><i class="fas fa-arrow-up"></i></a>
</div>
<div id="filterDiv">
   <label class="text-center">FILTER MARKS</label> <hr>
   <form action="#">
   <div class="form-group">
       <label for="">LEVEL</label>
       <select name="" class="form-control" id="levelFilter">
           <option value="">ALL</option>
           <?php for($x=1;$x<=8;$x++):?>
           <option value="CLASS <?=$x?>"><?='CLASS '.$x;?></option>
           <?php endfor; ?>
       </select>
   </div>
   <div class="form-group">
       <label for="">TERM</label>
       <select class="form-control" id="term">
           <option value="">ALL</option>
           <?php for($x=1;$x<=3;$x++):?>
            <option value="TERM <?=$x?>"><?='TERM '.$x;?></option>
           <?php endfor;?>
       </select>
   </div>
   <div class="form-group">
       <label for="">YEAR</label>
       <input type="number" class="form-control" id="year" value="<?=date("Y");?>" required=required>
   </div>
   <div class="form-group">
       <button class="btn btn-sm btn-primary">Filter</button>
   </div>
   </form>
</div>


<table class="table-striped table-bordered table-hoverable table table-sm">
    <thead>
        <tr>
        <th role="col">#</th>
        <th role="col">NAME</th>
        <th role="col">MATHS</th>
        <th role="col">ENG</th>
        <th role="col">KISW</th>
        <th role="col">SCI</th>
        <th role="col">SST/CRE</th>
        <th role="col">TOTAL</th>
        <th role="col">EXAM TYPE</th>
        <th role="col">TERM</th>
        <th role="col">YEAR</th>
        </tr>
    </thead>
    <tbody id="tableBody">
        <?php while($queryData  = mysqli_fetch_assoc($performanceQuery)) :   
        $examType        = $queryData['examType'];
        $level           = $queryData['level']; 
        $term            = $queryData['term']; 
        $year            = $queryData['year']; 
        $marksEncoded    = $queryData['performance']; 

        $marksDecoded    =   json_decode($marksEncoded,true);
        foreach($marksDecoded as $subject){
            $mathematics    =   (double)$subject['Mathematics'];
            $english        =   (double)$subject['English'];
            $kiswahili      =   (double)$subject['Kiswahili'];
            $science        =   (double)$subject['Science'];
            $sst            =   (double)$subject['Social Studies & CRE'];
        }
        $total  =   ($mathematics + $english + $kiswahili + $science + $sst);
        ?>
        <tr>
        <th role="row"><?=$count?></th>
        <td><?=$queryData['stdname']?></td>
        <td><?=$mathematics?></td>
        <td><?=$english?></td>
        <td><?=$kiswahili?></td>
        <td><?=$science?></td>
        <td><?=$sst?></td>
        <td><?=$total?></td>
        <td><?=$examType?></td>
        <td><?=$term?></td>
        <td><?=$year?></td>
        </tr>
        <?php $count++; endwhile; ?>                    
    </tbody>
</table>

<script>
var filterDiv = jQuery("#filterDiv");
filterDiv.find("button").click(function(e){
        e.preventDefault();
        var termFilter =  filterDiv.find("#term option:selected").val();
        var levelFilter =  filterDiv.find("#levelFilter option:selected").val();
        var year = filterDiv.find("#year").val();
        var filterData = {
            termFilter : termFilter,
            levelFilter : levelFilter,
            yearFilter : year
        };

    $.ajax({
        url:'/school/users/performance/fetch.php',
        method:'post',
        data:filterData,
        success:function(data){
            jQuery('#filterDiv').removeClass("active");
            jQuery('#tableBody').html();
            jQuery('#tableBody').html(data);
        },
        error:function(){
            alert("Something went wrong trying to search student name!");
        }
    });
});

jQuery('#filterIcon').click(function(){
    jQuery('#filterDiv').toggleClass("active");
});

jQuery('#searchIcon').click(function(){
   jQuery('#searchDiv').slideToggle("slow");
   jQuery("input[type='search']").focus();
});

jQuery('#slideUpBtn').click(function(event){
    event.preventDefault();
    jQuery('#searchDiv').slideUp("slow");
});

jQuery("input[type='search']").keyup(function(){
    var searchname  =   jQuery(this).val();
    $.ajax({
        url:'/school/users/performance/name-filter.php',
        method:'post',
        data:{searchname:searchname},
        success:function(data){
            jQuery('#tableBody').html();
            jQuery('#tableBody').html(data);
        },
        error:function(){
            alert("Something went wrong trying to search student name!");
        }
    });
});
</script>

<style>
#filterDiv.active{
    position: absolute;
    left: 2%;
    top: 15%;
    width: 30%;
    display:block;
    background: white;
    padding: 15px;
}
#filterDiv{
    display:none;
}
</style>