<div id="formerstddiv" style="position:absolute;left:10%;width:80%;top:10px;box-shadow:2px 2px 2px lightgrey; padding:20px;">


 <h6 class="text-center">
    <label class="float-left"> <a href="/school/admin/formerstudents.php">Back</a> </label>     
    <?=((isset($_GET['editmarks'])?'EDIT':'ADD'));?> FORMER STUDENT MARKS
</h6>


 <?php 

$year        = ((isset($_POST['year'])? clean($_POST['year']) : ''));
$examtype    = ((isset($_POST['examtype'])? strtoupper(clean($_POST['examtype'])) : ''));
$level       = ((isset($_POST['level'])? clean($_POST['level']) : ''));
$term        = ((isset($_POST['term'])? clean($_POST['term']) : ''));
      
$mathematics[0] = ((isset($_POST['mathematics'])? clean($_POST['mathematics']) : ''));
$mathematics[1] = ((isset($_POST['math_grade'])? clean($_POST['math_grade']) : ''));
$science[0]     = ((isset($_POST['science'])? clean($_POST['science']) : ''));
$science[1]     = ((isset($_POST['science_grade'])? clean($_POST['science_grade']) : ''));
$kiswahili[0]   = ((isset($_POST['kiswahili'])? clean($_POST['kiswahili']) : ''));
$kiswahili[1]   = ((isset($_POST['kiswahili_grade'])? clean($_POST['kiswahili_grade']) : ''));
$english[0]     = ((isset($_POST['english'])? clean($_POST['english']) : ''));
$english[1]     = ((isset($_POST['english_grade'])? clean($_POST['english_grade']) : ''));
$sst[0]         = ((isset($_POST['sst'])? clean($_POST['sst']) : ''));
$sst[1]         = ((isset($_POST['sst_grade'])? clean($_POST['sst_grade']) : ''));
$total[0]        = ((isset($_POST['total'])? clean($_POST['total']) : ''));
$total[1]        = ((isset($_POST['overall_grade'])? clean($_POST['overall_grade']) : ''));



if(isset($_GET['addmarks']) && $_GET['addmarks']>0){
    $studentId = (int)$_GET['addmarks'];
    $studentData = mysqli_fetch_assoc($db->query("SELECT * FROM former_students WHERE id='$studentId'"));
    $studentName = $studentData['name'];
    $studentId   = $studentData['id'];

    /******************************************************************************************************************************
     * SUBMIT BUTTON
     ******************************************************************************************************************************/
    if(isset($_POST['submit'])){
        $year        = ((isset($_POST['year'])? clean($_POST['year']) : ''));
        $examtype    = ((isset($_POST['examtype'])? strtoupper(clean($_POST['examtype'])) : ''));
        $level       = ((isset($_POST['level'])? clean($_POST['level']) : ''));
        $term        = ((isset($_POST['term'])? clean($_POST['term']) : ''));
            
        //MARKS
        $mathematics = ((isset($_POST['mathematics'])? clean($_POST['mathematics']) : ''));
        $science     = ((isset($_POST['science'])? clean($_POST['science']) : ''));
        $kiswahili   = ((isset($_POST['kiswahili'])? clean($_POST['kiswahili']) : ''));
        $english     = ((isset($_POST['english'])? clean($_POST['english']) : ''));
        $sst         = ((isset($_POST['sst'])? clean($_POST['sst']) : ''));
        $total       = ((isset($_POST['total'])? clean($_POST['total']) : ''));

        //GRADES
        $mathematics_grade =  ((isset($_POST['math_grade'])? strtoupper(clean($_POST['math_grade'])) : ''));
        $science_grade     =  ((isset($_POST['science_grade'])? strtoupper(clean($_POST['science_grade'])) : ''));
        $kiswahili_grade   =  ((isset($_POST['kiswahili_grade'])? strtoupper(clean($_POST['kiswahili_grade'])) : ''));
        $english_grade     =  ((isset($_POST['english_grade'])? strtoupper(clean($_POST['english_grade'])) : ''));
        $sst_grade         =  ((isset($_POST['sst_grade'])? strtoupper(clean($_POST['sst_grade'])) : ''));
        $overrall_grade    =  ((isset($_POST['overall_grade'])? strtoupper(clean($_POST['overall_grade'])) : ''));

        $performanceArray[] = array(
            'Mathematics'           =>    $mathematics.':'.$mathematics_grade,
            'Science'               =>    $science.':'.$science_grade,
            'Kiswahili'             =>    $kiswahili.':'.$kiswahili_grade,
            'English'               =>    $english.':'.$english_grade,
            'Social Studies & CRE'  =>    $sst.':'.$sst_grade,
            'Total'                 =>    $total.':'.$overrall_grade
        );

        $performanceEncoded = json_encode($performanceArray); var_dump($performanceEncoded);
        
        // $db->query("INSERT INTO formerStudents_marks(student_id, performance, examType, level, term, year)
        //             VALUES ('$studentId','{$performanceEncoded}','$examtype','$level','$term','$year')  ");
        
        $messages[].='<b>Success! </b>Marks inserted';
        displayMessages($messages);
    }
    /************************************************************************************************************
     * SUBMIT BUTTON ENDS HERE
     ************************************************************************************************************/
}

/*****************************************************************************************************************
 * CODE FOR EDITING MARKS
 *****************************************************************************************************************/

if(isset($_GET['editmarks']) && $_GET['editmarks']>0){
    $editId     =   (int) clean($_GET['editmarks']);
    $marksQuery =   $db->query("SELECT * FROM formerstudents_marks WHERE id='$editId'");
    $queryData  =   mysqli_fetch_array($marksQuery);

    $studentId   = $queryData['student_id'];
    $studentData = mysqli_fetch_assoc($db->query("SELECT * FROM former_students WHERE id='$studentId'"));
    $studentName = $studentData['name'];

    $examtype        = $queryData['examType'];

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

    if(isset($_POST['update'])){

        $year        = ((isset($_POST['year'])? clean($_POST['year']) : $year));
        $examtype    = ((isset($_POST['examtype'])? strtoupper(clean($_POST['examtype'])) : $examtype));
        $level       = ((isset($_POST['level'])? clean($_POST['level']) : $level));
        $term        = ((isset($_POST['term'])? clean($_POST['term']) : $term));

        //MARKS    
        $mathematics = ((isset($_POST['mathematics'])? clean($_POST['mathematics']) : $mathematics[0]));
        $science     = ((isset($_POST['science'])? clean($_POST['science']) : $science[0]));
        $kiswahili   = ((isset($_POST['kiswahili'])? clean($_POST['kiswahili']) : $kiswahili[0]));
        $english     = ((isset($_POST['english'])? clean($_POST['english']) : $english[0]));
        $sst         = ((isset($_POST['sst'])? clean($_POST['sst']) : $sst[0]));
        $total       = ((isset($_POST['total'])? clean($_POST['total']) : $total[0]));

       //GRADES
        $mathematics_grade =  ((isset($_POST['math_grade'])? strtoupper(clean($_POST['math_grade'])) : ''));
        $science_grade     =  ((isset($_POST['science_grade'])? strtoupper(clean($_POST['science_grade'])) : ''));
        $kiswahili_grade   =  ((isset($_POST['kiswahili_grade'])? strtoupper(clean($_POST['kiswahili_grade'])) : ''));
        $english_grade     =  ((isset($_POST['english_grade'])? strtoupper(clean($_POST['english_grade'])) : ''));
        $sst_grade         =  ((isset($_POST['sst_grade'])? strtoupper(clean($_POST['sst_grade'])) : ''));
        $overrall_grade    =  ((isset($_POST['overall_grade'])? strtoupper(clean($_POST['overall_grade'])) : ''));

        $performanceArray[] = array(
            'Mathematics'           =>    $mathematics.':'.$mathematics_grade,
            'Science'               =>    $science.':'.$science_grade,
            'Kiswahili'             =>    $kiswahili.':'.$kiswahili_grade,
            'English'               =>    $english.':'.$english_grade,
            'Social Studies & CRE'  =>    $sst.':'.$sst_grade,
            'Total'                 =>    $total.':'.$overrall_grade
        );

        $performanceEncoded = json_encode($performanceArray);
        $total              = ($mathematics + $english + $kiswahili + $science + $sst);

        $db->query("UPDATE formerstudents_marks
                    SET performance='$performanceEncoded',examType='$examtype',level='$level',term=$term,year='$term' WHERE id='$editId'");
        $messages[].='<b>Success! </b>Marks updated.';
        displayMessages($messages);
    } 
}
/******************************************************************************************************************
 * CODE FOR EDITING MARKS ENDS HERE
 ******************************************************************************************************************/

?>

<form action="<?=((isset($_GET['editmarks'])?'formerstudents.php?editmarks='.$editId.'':'formerstudents.php?addmarks='.$studentId.''))?>" method="post">
    <div class="">
        <label for="name">STUDENT NAME*</label>
        <input type="text" name="name" class="form-control" value="<?=$studentName;?>" readonly>
    </div>
    <div class="row">
        <div class="col-md-7">     
            <table class="table">
                <tbody>
                    <tr>
                        <div class="row">
                            <div class="col-md-6">
                                <label for="">Mathematics.</label>
                                <input type="number" class="form-control" name="mathematics" min=0 max=100 value="<?=$mathematics[0]?>" required=required>
                            </div>
                            <div class="col-md-6">
                                <label for="">Math Grade.</label>
                                <input type="text" name="math_grade" value="<?=$mathematics[1]?>" class="form-control">
                            </div>
                        </div>
                    </tr>
                    <tr>
                        <div class="row">
                            <div class="col-md-6">
                                <label for="">Science</label>
                                <input type="number" class="form-control" name="science" min=0 max=100 value="<?=$science[0]?>" required=required>
                            </div>
                            <div class="col-md-6">
                                <label for="">Science Grade.</label>
                                <input type="text" name="science_grade" value="<?=$science[1]?>" class="form-control">
                            </div>
                        </div>
                    </tr>
                    <tr>
                        <div class="row">
                            <div class="col-md-6">
                                <label for="">kiswahili</label>
                                <input type="number" class="form-control" name="kiswahili" min=0 max=100 value="<?=$kiswahili[0]?>" required=required">
                            </div>
                            <div class="col-md-6">
                                <label for="">Kiswahili Grade</label>
                                <input type="text" name="kiswahili_grade" value="<?=$kiswahili[1]?>" class="form-control">
                            </div>
                        </div>
                    </tr>
                    <tr>
                        <div class="row">
                            <div class="col-md-6">
                                <label for="">English</label>
                                <input type="number" class="form-control" name="english" min=0 max=100 value="<?=$english[0]?>" required=required>
                            </div>
                            <div class="col-md-6">
                                <label for="">English Grade</label>
                                 <input type="text" name="english_grade" value="<?=$english[1]?>" class="form-control">
                            </div>
                        </div>    
                    </tr>
                    <tr>
                        <div class="row">
                            <div class="col-md-6">
                                <label for="">SST & CRE/IRE</label>
                                <input type="number" class="form-control" name="sst" min=0 max=100 value="<?=$sst[0]?>" required=required>
                            </div>
                            <div class="col-md-6">
                                <label for="">SST Grade</label>
                                <input type="text" name="sst_grade" value="<?=$sst[1]?>" class="form-control">
                            </div>
                        </div>                       
                    </tr>
                    <tr>
                        <div class="row">
                            <div class="col-md-6">
                                <label for=""><strong>TOTAL MARKS</strong></label>
                                <input type="number" class="form-control" name="total" value="" min=0 max=500 value="" required=required readonly>
                            </div>
                            <div class="col-md-6">
                                <label for=""><strong>OVERALL GRADE</strong></label>
                                <input type="text" name="overall_grade" value="<?=$total[1]?>" class="form-control">
                            </div>
                        </div>                       
                    </tr>
                </tbody>
            </table>
        </div>
        <div class="col-md-5">
            <div class="form-group">
                <label for="">Exam type</label>
                <input type="text" class="form-control" name="examtype" value="<?=$examtype?>" required=required>
            </div>
            <div class="form-group">
                <label for="">Level student was</label>
                <input type="text" class="form-control" name="level" value="<?=$level?>" required=required>
            </div>
            <div class="form-group">
                <label for="">Term for examination</label>
               <select name="term" id="term" class="form-control">
                    <option value=""></option>
                    <option value="TERM 1" <?php if($term=='TERM 1'){ echo 'selected';;}?>>TERM 1</option>
                    <option value="TERM 2" <?php if($term=='TERM 2'){ echo 'selected';;}?>>TERM 2</option>
                    <option value="TERM 3" <?php if($term=='TERM 3'){ echo 'selected';;}?>>TERM 3</option>
               </select>
            </div>
             <div class="form-group">
                <label for="">Year of examination</label>
                <input type="year" class="form-control" name="year" value="<?=$year?>">
            </div>
        </div>
    </div>   
    <div class="form-group">
        <input type="submit" name="calculate" id="calculatebtn" value="Calculate Total" class="btn btn-sm btn-primary">
        <input type="submit" name="<?=((isset($_GET['editmarks'])?'update':'submit'))?>" value="<?=((isset($_GET['editmarks'])?'Update':'Submit'))?>" class="btn btn-sm btn-success">
    </div>        
</form>
</div>

<script>
jQuery('#calculatebtn').click(function(e){
    e.preventDefault();
    //parseInt mathod converts the inputs into integers which jQuery was reading as strings
    var mathematics = parseInt($("form").find("input[name='mathematics']").val());
    var science     = parseInt($("form").find("input[name='science']").val());
    var kiswahili   = parseInt($("form").find("input[name='kiswahili']").val());
    var english     = parseInt($("form").find("input[name='english']").val());
    var sst         = parseInt($("form").find("input[name='sst']").val());

    var total = (mathematics + science + kiswahili + english + sst);

    jQuery("form").find("input[name='total']").val(total);
});
</script>