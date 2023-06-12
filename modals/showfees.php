<?php
require_once $_SERVER['DOCUMENT_ROOT'].'/school/core/init.php';

 //THESE ARE ARRAYS THAT WILL HOLD DATA FOR EACH TERM FROM ALL LEVELS
        $term1=array();
        $term2=array();
        $term3=array();
       
        $year=date('Y');
        $query=$db->query("SELECT * FROM school_fees WHERE year='$year'");
            
        $querydata=mysqli_fetch_array($query);
        
        $term1_decode=json_decode($querydata['term1'],true);//decode the data we get from database for term one
        $term2_decode=json_decode($querydata['term2'],true);//decode the data we get from database for term two
        $term3_decode=json_decode($querydata['term3'],true);//decode the data we get from database for term three

        foreach($term1_decode as $term1){
            $term1playgroup=$term1['playgroup'];
            $term1pp1=$term1['pp1'];
            $term1pp2=$term1['pp2'];
            $term1grade1=$term1['grade1'];
            $term1grade2=$term1['grade2'];
            $term1grade3=$term1['grade3'];
            $term1grade4=$term1['grade4'];
            $term1grade5=$term1['grade5'];
            $term1grade6=$term1['grade6'];
            $term1class5=$term1['class5'];
            $term1class6=$term1['class6'];
            $term1class7=$term1['class7'];
            $term1class8=$term1['class8'];               
        }
        foreach($term2_decode as $term2){
            $term2playgroup=$term2['playgroup'];
            $term2pp1=$term2['pp1'];
            $term2pp2=$term2['pp2'];
            $term2grade1=$term2['grade1'];
            $term2grade2=$term2['grade2'];
            $term2grade3=$term2['grade3'];
            $term2grade4=$term2['grade4'];
            $term2grade5=$term2['grade5'];
            $term2grade6=$term2['grade6'];
            $term2class5=$term2['class5'];
            $term2class6=$term2['class6'];
            $term2class7=$term2['class7'];
            $term2class8=$term2['class8'];  
        }
        foreach($term3_decode as $term3){
            $term3playgroup=$term3['playgroup'];
            $term3pp1=$term3['pp1'];
            $term3pp2=$term3['pp2'];
            $term3grade1=$term3['grade1'];
            $term3grade2=$term3['grade2'];
            $term3grade3=$term3['grade3'];
            $term3grade4=$term3['grade4'];
            $term3grade5=$term3['grade5'];
            $term3grade6=$term3['grade6'];
            $term3class5=$term3['class5'];
            $term3class6=$term3['class6'];
            $term3class7=$term3['class7'];
            $term3class8=$term3['class8'];  
        }

        $playgrouptrm1=trim(clean(((isset($term1playgroup) ? $term1playgroup:'0.00'))));
        $playgrouptrm2=trim(clean(((isset($term2playgroup) ? $term2playgroup:'0.00'))));
        $playgrouptrm3=trim(clean(((isset($term3playgroup) ? $term3playgroup:'0.00'))));
            
        $pp1trm1=trim(clean(((isset($term1pp1) ? $term1pp1:'0.00'))));
        $pp1trm2=trim(clean(((isset($term2pp1) ? $term2pp1:'0.00'))));
        $pp1trm3=trim(clean(((isset($term3pp1) ? $term3pp1:'0.00'))));

        $pp2trm1=trim(clean(((isset($term1pp2) ? $term1pp2:'0.00'))));
        $pp2trm2=trim(clean(((isset($term2pp2) ? $term2pp2:'0.00'))));
        $pp2trm3=trim(clean(((isset($term3pp2) ? $term3pp2:'0.00'))));

        $grd1trm1=trim(clean(((isset($term1grade1) ? $term1grade1:'0.00'))));
        $grd1trm2=trim(clean(((isset($term2grade1) ? $term2grade1:'0.00'))));
        $grd1trm3=trim(clean(((isset($term3grade1) ? $term3grade1:'0.00'))));

        $grd2trm1=trim(clean(((isset($term1grade2) ? $term1grade2:'0.00'))));
        $grd2trm2=trim(clean(((isset($term2grade2) ? $term2grade2:'0.00'))));
        $grd2trm3=trim(clean(((isset($term3grade2) ? $term3grade2:'0.00'))));

        $grd3trm1=trim(clean(((isset($term1grade3) ? $term1grade3:'0.00'))));
        $grd3trm2=trim(clean(((isset($term2grade3) ? $term2grade3:'0.00'))));
        $grd3trm3=trim(clean(((isset($term3grade3) ? $term3grade3:'0.00'))));

        $grd4trm1=trim(clean(((isset($term1grade4) ? $term1grade4:'0.00'))));
        $grd4trm2=trim(clean(((isset($term2grade4) ? $term2grade4:'0.00'))));
        $grd4trm3=trim(clean(((isset($term3grade4) ? $term3grade4:'0.00'))));

        $grd5trm1=trim(clean(((isset($term1grade5) ? $term1grade5:'0.00'))));
        $grd5trm2=trim(clean(((isset($term2grade5) ? $term2grade5:'0.00'))));
        $grd5trm3=trim(clean(((isset($term3grade5) ? $term3grade5:'0.00'))));

        $grd6trm1=trim(clean(((isset($term1grade6) ? $term1grade6:'0.00'))));
        $grd6trm2=trim(clean(((isset($term2grade6) ? $term2grade6:'0.00'))));
        $grd6trm3=trim(clean(((isset($term3grade6) ? $term3grade6:'0.00'))));     
        
        $cls5trm1=trim(clean(((isset($term1class5) ? $term1class5:'0.00'))));
        $cls5trm2=trim(clean(((isset($term2class5) ? $term2class5:'0.00'))));
        $cls5trm3=trim(clean(((isset($term3class5) ? $term3class5:'0.00'))));

        $cls6trm1=trim(clean(((isset($term1class6) ? $term1class6:'0.00'))));
        $cls6trm2=trim(clean(((isset($term2class6) ? $term2class6:'0.00'))));
        $cls6trm3=trim(clean(((isset($term3class6) ? $term3class6:'0.00'))));

        $cls7trm1=trim(clean(((isset($term1class7) ? $term1class7:'0.00'))));
        $cls7trm2=trim(clean(((isset($term2class7) ? $term2class7:'0.00'))));
        $cls7trm3=trim(clean(((isset($term3class7) ? $term3class7:'0.00'))));

        $cls8trm1=trim(clean(((isset($term1class8) ? $term1class8:'0.00'))));
        $cls8trm2=trim(clean(((isset($term2class8) ? $term2class8:'0.00'))));
        $cls8trm3=trim(clean(((isset($term1class8) ? $term1class8:'0.00'))));
?>


<!-- Modal -->
<div class="modal fade" id="feesmodal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
  <div class="modal-dialog modal-dialog-centered modal-lg" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="exampleModalLabel"> <?=date('Y');?> Fees</h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <div class="modal-body">     
        <table class="table table-bordered table-condenced table-striped table-sm" >
            <thead class="thead-light">
                <th>LEVEL</th>  <th>TERM !(Kshs.)</th> <th>TERM 2(Kshs.)</th>   <th>TERM 3(Kshs.)</th>
            </thead>
                <tr> <td>Playgroup</td> <td> <?=decimal($playgrouptrm1)?> </td> <td> <?=decimal($playgrouptrm2)?> </td> <td> <?=decimal($playgrouptrm3);?> </td> </tr>
                <tr> <td>PP1</td> <td> <?=decimal($pp1trm1)?> </td> <td> <?=decimal($pp1trm2)?> </td> <td> <?=decimal($pp1trm3);?> </td> </tr>
                <tr>  <td>PP2</td> <td> <?=decimal($pp2trm1)?> </td> <td> <?=decimal($pp2trm2)?> </td> <td> <?=decimal($pp2trm3);?> </td> </tr>
                <tr> <td>Grade 1</td> <td> <?=decimal($grd1trm1)?> </td> <td> <?=decimal($grd1trm2)?> </td> <td> <?=decimal($grd1trm3);?> </td> </tr>
                <tr>  <td>Grade 2</td> <td> <?=decimal($grd2trm1)?> </td> <td> <?=decimal($grd2trm2)?> </td> <td> <?=decimal($grd2trm3);?> </td> </tr>
                <tr> <td>Grade 3</td> <td> <?=decimal($grd3trm1)?> </td> <td> <?=decimal($grd3trm2)?> </td> <td> <?=decimal($grd3trm3);?> </td>  </tr>
                <tr>  <td>Grade 4</td> <td> <?=decimal($grd4trm1)?> </td> <td> <?=decimal($grd4trm2)?> </td> <td> <?=decimal($grd4trm3);?> </td> </tr>
                <tr>  <td>Grade 5</td> <td> <?=decimal($grd5trm1)?> </td> <td> <?=decimal($grd5trm2)?> </td> <td> <?=decimal($grd5trm3);?> </td> </tr>
                <tr>  <td>Grade 6</td> <td> <?=decimal($grd6trm1)?> </td> <td> <?=decimal($grd6trm2)?> </td> <td> <?=decimal($grd6trm3);?> </td> </tr>
                <tr>  <td>Class 6</td> <td> <?=decimal($cls6trm1)?> </td> <td> <?=decimal($cls6trm2)?> </td> <td> <?=decimal($cls6trm3);?> </td> </tr>
                <tr>  <td>Class 7</td> <td> <?=decimal($cls7trm1)?> </td> <td> <?=decimal($cls7trm2)?> </td> <td> <?=decimal($cls7trm3);?> </td> </tr>
                <tr>  <td>Class 8</td> <td> <?=decimal($cls8trm1)?> </td> <td> <?=decimal($cls8trm2)?> </td> <td> <?=decimal($cls8trm3);?> </td> </tr>
        </table>


      </div>
    </div>
  </div>
</div>