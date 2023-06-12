<div class="text-center bg-light" style="padding: 10px;">
<label class="float-left"> <a href="/school/admin/formerstudents.php">Back</a> </label>
<b>STUDENT"S PERFORMANCE</b>
</div>

<?php
$count      = 1;
//deleting marks
if(isset($_GET['deleteMarks'])&& $_GET['deleteMarks']>0){
    $deleteId = (int)clean($_GET['deleteMarks']);
    $db->query("DELETE FROM `formerstudents_marks` WHERE id='$deleteId'");
    $messages[].='<b>Success! </b>Marks deleted.';
    displayMessages($messages);
}
if(isset($_GET['viewmarks']) && $_GET['viewmarks'] > 0){
    $viewId     = (int) clean($_GET['viewmarks']);    
    $marksQuery = $db->query("SELECT * FROM formerstudents_marks WHERE student_id='$viewId'");
    if(mysqli_num_rows($marksQuery) == 0){
         $errors[].='<b>Error! </b>No marks exist for this student.';
         displayErrors($errors);
    }else{
?>

        <table class="table table-sm table-striped table-bordered">
            <thead class="thead-light">
                <th>#</th>
                <th>MATHS</th>
                <th>ENGLISH</th>
                <th>KISWAHILI</th>
                <th>SCIENCE</th>
                <th>SST & CRE</th>
                <th>TOTAL</th>
                <th>EXAM TYPE</th>
                <th>TERM</th>
                <th>YEAR</th>
                <th></th>
            </thead>
             <tbody>
            <?php while($queryData  = mysqli_fetch_assoc($marksQuery)) :   

                    $examType        = $queryData['examType'];
                    $level           = $queryData['level']; 
                    $term            = $queryData['term']; 
                    $year            = $queryData['year']; 
                    $marksEncoded    = $queryData['performance']; 
                
                    $marksDecoded    =   json_decode($marksEncoded,true);

                    foreach($marksDecoded as $subject){//we explode to get the grade and the mark. index 0 is the mark and index 1 is the grade
                        $mathematics    =   explode(':',$subject['Mathematics']);
                        $english        =   explode(':',$subject['English']);
                        $kiswahili      =   explode(':',$subject['Kiswahili']);
                        $science        =   explode(':',$subject['Science']);
                        $sst            =   explode(':',$subject['Social Studies & CRE']);
                        $total          =   explode(':',$subject['Total']);
                    }

                    // $total  =   ($mathematics + $english + $kiswahili + $science + $sst);

                ?>
                <tr>
                    <td><?=$count;?>.</td>
                   <td><?=$mathematics[0]?></td>
                   <td><?=$english[0]?></td>
                   <td><?=$kiswahili[0]?></td>
                   <td><?=$science[0]?></td>
                   <td><?=$sst[0]?></td>
                   <td><?=$total[0]?></td>
                   <td><?=$examType?></td>
                   <td><?=$term?></td>
                   <td><?=$year?></td>
                   <td> 
                        <a href="<?=$_SERVER['PHP_SELF'].'?editmarks='.$queryData['id'];?>"> <i class="fas fa-pencil-alt"></i> Edit</a>
                        <a href="#" class="text-danger deleteMarks" id="<?=$queryData['id']?>"> <i class="fas fa-trash-alt"></i> delete </a>    
                    </td>
                </tr>
            <?php $count++; endwhile; ?>
        </tbody>
        </table>     


   <?php }
   
}
?>
<script>
//deleting marks
jQuery(".deleteMarks").click(function(e){
    e.preventDefault();
    var deleteid = jQuery(this).attr("id");
    if(confirm('Proceed to delete marks?')){
        window.location="/school/admin/formerstudents.php?viewmarks="+<?=$_GET['viewmarks']?>+"&deleteMarks="+deleteid;
    }    
});
</script>