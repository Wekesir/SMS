<?php
$editId =   (int)clean($_REQUEST['editmarks']);   

$marksQuery    = $db->query("SELECT * FROM formerstudents_marks WHERE id='$editId'");

while($queryData  = mysqli_fetch_assoc($marksQuery)){

    $examType        = $queryData['examType'];
    $level           = $queryData['level']; 
    $term            = $queryData['term']; 
    $year            = $queryData['year']; 
    $marksEncoded    = $queryData['performance']; 

    $marksDecoded    =   json_decode($marksEncoded,true);

    foreach($marksDecoded as $subject){
        $mathematics    =   $subject['Mathematics'];
        $english        =   $subject['English'];
        $kiswahili      =   $subject['Kiswahili'];
        $science        =   $subject['Science'];
        $sst            =   $subject['Social Studies & CRE'];
    }

    $total  =   ($mathematics + $english + $kiswahili + $science + $sst);

}
?>

<h6 class="text-center" style="background:#f8f8f8;padding:20px;">
  <label class="float-left"> <a href="/school/users/mystudents.php">Back.</a> </label>
  <label>EDIT MARKS</label>
</h6>


<?php
if(isset($_POST['submit'])){
    $year        = date('Y');
    $examtype    = ((isset($_POST['examType'])? strtoupper(clean($_POST['examType'])) : ''));
    $level       = ((isset($_POST['level'])? clean($_POST['level']) : ''));
    $term        = ((isset($_POST['term'])? clean($_POST['term']) : ''));
        
    $mathematics = ((isset($_POST['mathematics'])? clean($_POST['mathematics']) : ''));
    $science     = ((isset($_POST['science'])? clean($_POST['science']) : ''));
    $kiswahili   = ((isset($_POST['kiswahili'])? clean($_POST['kiswahili']) : ''));
    $english     = ((isset($_POST['english'])? clean($_POST['english']) : ''));
    $sst         = ((isset($_POST['sst'])? clean($_POST['sst']) : ''));

    $performanceArray[] = array(
        'Mathematics'           =>    $mathematics,
        'Science'               =>    $science,
        'Kiswahili'             =>    $kiswahili,
        'English'               =>    $english,
        'Social Studies & CRE'  =>     $sst
    );

    $performanceEncoded = json_encode($performanceArray);

    $db->query("UPDATE formerstudents_marks SET 
                  performance='$performanceEncoded',
                  examType='$examtype',
                  level='$level',
                  term='$term',
                  year='$year'
                WHERE id='$editId'");

    $messages[].='<b>Success! </b>Marks updated.';
    displayMessages($messages);
  }
?>

<div id="editmarksDiv">
                <form action="<?=$_SERVER['PHP_SELF'].'?editmarks='.$editId?>" method="post">
                    <div class="row">
                      <div class="col-md-6">
                        <div class="form-group">
                          <label for="">Mathematics</label>
                          <input type="number" class="form-control" name="mathematics" required=required min=0 max=100 value="<?=$mathematics?>"> 
                        </div>
                        <div class="form-group">
                          <label for="">English</label>
                          <input type="number" class="form-control" name="english" required=required min=0 max=100 value="<?=$english?>"> 
                        </div>
                        <div class="form-group">
                          <label for="">Kiswahili</label>
                          <input type="number" class="form-control" name="kiswahili" required=required min=0 max=100 value="<?=$kiswahili?>"> 
                        </div>
                        <div class="form-group">
                          <label for="">Science</label>
                          <input type="number" class="form-control" name="science" required=required min=0 max=100 value="<?=$science?>"> 
                        </div>
                      </div>
                      <div class="col-md-6">                        
                        <div class="form-group">
                          <label for="">Social studies & CRE</label>
                          <input type="number" class="form-control" name="sst" required=required min=0 max=100 value="<?=$sst?>"> 
                        </div>
                        <div class="form-group">
                          <label for="">Exam type</label>
                          <input type="text" class="form-control" name="examType" required=required value="<?=$examType?>"> 
                        </div>
                        <div class="form-group">
                          <label for="">Term</label>
                          <select name="term" id="term" class="form-control" required=required>
                            <option value=""></option>
                            <option value="TERM 1" <?php if($term=='TERM 1'){echo 'selected';}?>>Term 1</option>
                            <option value="TERM 2" <?php if($term=='TERM 2'){echo 'selected';}?>>Term 2</option>
                            <option value="TERM 3" <?php if($term=='TERM 3'){echo 'selected';}?>>Term 3</option>
                          </select>
                        </div>  
                        <div class="form-group">
                          <label for="">Total</label>
                          <input type="number" class="form-control" name="total" required=required min=0 value="<?=$total?>" readonly> 
                        </div>                        
                      </div>
                    </div>
                    <div class="form-group">
                      <input type="submit" class="btn" name="submit" value="Submit">
                    </div>
                </form>
</div><!--closing editmarksDiv-->
