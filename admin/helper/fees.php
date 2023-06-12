<div class="setfeesdiv">
    <div class="form-group">
    <h5 class="text-danger exsmall_font"><b>Caution! </b>Information provided here is used by the system to compute all financial reports
                and statements concerning the school and fees paid by students. Therefore the details provided here should be 
                accurate as possible to avoid mistakes.
   </h5>
</div>


    <?php
if(isset($_GET['setfees'])){//this condion omly checks for setfees button being clicked
    if($checkFeesCount == 1){//reads from yhr helpers/getconfigurations.php file
        ?>
        <script>
            alert("School fees for the whole yaer has been set already, try editing instead!");
            window.location='../admin/finance.php?editfees=1';
        </script>
        <?php
    }
}

   

        $playgrouptrm1=trim(clean(((isset($_POST['plygrp_term1'])?$_POST['plygrp_term1']:''))));
        $playgrouptrm2=trim(clean(((isset($_POST['plygrp_term2'])?$_POST['plygrp_term2']:''))));
        $playgrouptrm3=trim(clean(((isset($_POST['plygrp_term3'])?$_POST['plygrp_term3']:''))));
            
        $pp1trm1=trim(clean(((isset($_POST['pp1_term1'])?$_POST['pp1_term1']:''))));
        $pp1trm2=trim(clean(((isset($_POST['pp1_term2'])?$_POST['pp1_term2']:''))));
        $pp1trm3=trim(clean(((isset($_POST['pp1_term3'])?$_POST['pp1_term3']:''))));

        $pp2trm1=trim(clean(((isset($_POST['pp2_term1'])?$_POST['pp2_term1']:''))));
        $pp2trm2=trim(clean(((isset($_POST['pp2_term2'])?$_POST['pp2_term2']:''))));
        $pp2trm3=trim(clean(((isset($_POST['pp2_term3'])?$_POST['pp2_term3']:''))));

        $grd1trm1=trim(clean(((isset($_POST['gr1_term1'])?$_POST['gr1_term1']:''))));
        $grd1trm2=trim(clean(((isset($_POST['gr1_term2'])?$_POST['gr1_term2']:''))));
        $grd1trm3=trim(clean(((isset($_POST['gr1_term3'])?$_POST['gr1_term3']:''))));

        $grd2trm1=trim(clean(((isset($_POST['gr2_term1'])?$_POST['gr2_term1']:''))));
        $grd2trm2=trim(clean(((isset($_POST['gr2_term2'])?$_POST['gr2_term2']:''))));
        $grd2trm3=trim(clean(((isset($_POST['gr2_term3'])?$_POST['gr2_term3']:''))));

        $grd3trm1=trim(clean(((isset($_POST['gr3_term1'])?$_POST['gr3_term1']:''))));
        $grd3trm2=trim(clean(((isset($_POST['gr3_term2'])?$_POST['gr3_term2']:''))));
        $grd3trm3=trim(clean(((isset($_POST['gr3_term3'])?$_POST['gr3_term3']:''))));

        $grd4trm1=trim(clean(((isset($_POST['gr4_term1'])?$_POST['gr4_term1']:''))));
        $grd4trm2=trim(clean(((isset($_POST['gr4_term2'])?$_POST['gr4_term2']:''))));
        $grd4trm3=trim(clean(((isset($_POST['gr4_term3'])?$_POST['gr4_term3']:''))));

        $grd5trm1=trim(clean(((isset($_POST['gr5_term1'])?$_POST['gr5_term1']:''))));
        $grd5trm2=trim(clean(((isset($_POST['gr5_term2'])?$_POST['gr5_term2']:''))));
        $grd5trm3=trim(clean(((isset($_POST['gr5_term3'])?$_POST['gr5_term3']:''))));

        $grd6trm1=trim(clean(((isset($_POST['gr6_term1'])?$_POST['gr6_term1']:''))));
        $grd6trm2=trim(clean(((isset($_POST['gr6_term2'])?$_POST['gr6_term2']:''))));
        $grd6trm3=trim(clean(((isset($_POST['gr6_term3'])?$_POST['gr6_term3']:''))));                
        
        $cls5trm1=trim(clean(((isset($_POST['cls5_term1'])?$_POST['cls5_term1']:''))));
        $cls5trm2=trim(clean(((isset($_POST['cls5_term2'])?$_POST['cls5_term2']:''))));
        $cls5trm3=trim(clean(((isset($_POST['cls5_term3'])?$_POST['cls5_term3']:''))));

        $cls6trm1=trim(clean(((isset($_POST['cls6_term1'])?$_POST['cls6_term1']:''))));
        $cls6trm2=trim(clean(((isset($_POST['cls6_term2'])?$_POST['cls6_term2']:''))));
        $cls6trm3=trim(clean(((isset($_POST['cls6_term3'])?$_POST['cls6_term3']:''))));

        $cls7trm1=trim(clean(((isset($_POST['cls7_term1'])?$_POST['cls7_term1']:''))));
        $cls7trm2=trim(clean(((isset($_POST['cls7_term2'])?$_POST['cls7_term2']:''))));
        $cls7trm3=trim(clean(((isset($_POST['cls7_term3'])?$_POST['cls7_term3']:''))));

        $cls8trm1=trim(clean(((isset($_POST['cls8_term1'])?$_POST['cls8_term1']:''))));
        $cls8trm2=trim(clean(((isset($_POST['cls8_term2'])?$_POST['cls8_term2']:''))));
        $cls8trm3=trim(clean(((isset($_POST['cls8_term3'])?$_POST['cls8_term3']:''))));

    if(isset($_GET['editfees'])){//if the user chooses to edit fees

        //THESE ARE ARRAYS THAT WILL HOLD DATA FOR EACH TERM FROM ALL LEVELS
        $term1=array();
        $term2=array();
        $term3=array();
       
        $year=date('Y');
        $query=$db->query("SELECT * FROM school_fees WHERE year='$year'");
        
        if(mysqli_num_rows($query) == 0){//if there is not data for this year then it redirects to the setfees page
           ?>
           <script>window.location='../admin/finance.php?setfees=1';</script>
           <?php
        }
            
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
        $playgrouptrm1=trim(clean(((isset($_POST['plygrp_term1'])?$_POST['plygrp_term1']:$term1playgroup))));
        $playgrouptrm2=trim(clean(((isset($_POST['plygrp_term2'])?$_POST['plygrp_term2']:$term2playgroup))));
        $playgrouptrm3=trim(clean(((isset($_POST['plygrp_term3'])?$_POST['plygrp_term3']:$term3playgroup))));
            
        $pp1trm1=trim(clean(((isset($_POST['pp1_term1'])?$_POST['pp1_term1']:$term1pp1))));
        $pp1trm2=trim(clean(((isset($_POST['pp1_term2'])?$_POST['pp1_term2']:$term2pp1))));
        $pp1trm3=trim(clean(((isset($_POST['pp1_term3'])?$_POST['pp1_term3']:$term3pp1))));

        $pp2trm1=trim(clean(((isset($_POST['pp2_term1'])?$_POST['pp2_term1']:$term1pp2))));
        $pp2trm2=trim(clean(((isset($_POST['pp2_term2'])?$_POST['pp2_term2']:$term2pp2))));
        $pp2trm3=trim(clean(((isset($_POST['pp2_term3'])?$_POST['pp2_term3']:$term3pp2))));

        $grd1trm1=trim(clean(((isset($_POST['gr1_term1'])?$_POST['gr1_term1']:$term1grade1))));
        $grd1trm2=trim(clean(((isset($_POST['gr1_term2'])?$_POST['gr1_term2']:$term2grade1))));
        $grd1trm3=trim(clean(((isset($_POST['gr1_term3'])?$_POST['gr1_term3']:$term3grade1))));

        $grd2trm1=trim(clean(((isset($_POST['gr2_term1'])?$_POST['gr2_term1']:$term1grade2))));
        $grd2trm2=trim(clean(((isset($_POST['gr2_term2'])?$_POST['gr2_term2']:$term2grade2))));
        $grd2trm3=trim(clean(((isset($_POST['gr2_term3'])?$_POST['gr2_term3']:$term3grade2))));

        $grd3trm1=trim(clean(((isset($_POST['gr3_term1'])?$_POST['gr3_term1']:$term1grade3))));
        $grd3trm2=trim(clean(((isset($_POST['gr3_term2'])?$_POST['gr3_term2']:$term2grade3))));
        $grd3trm3=trim(clean(((isset($_POST['gr3_term3'])?$_POST['gr3_term3']:$term3grade3))));

        $grd4trm1=trim(clean(((isset($_POST['gr4_term1'])?$_POST['gr4_term1']:$term1grade4))));
        $grd4trm2=trim(clean(((isset($_POST['gr4_term2'])?$_POST['gr4_term2']:$term2grade4))));
        $grd4trm3=trim(clean(((isset($_POST['gr4_term3'])?$_POST['gr4_term3']:$term3grade4))));

        $grd5trm1=trim(clean(((isset($_POST['gr5_term1'])?$_POST['gr5_term1']:$term1grade5))));
        $grd5trm2=trim(clean(((isset($_POST['gr5_term2'])?$_POST['gr5_term2']:$term2grade5))));
        $grd5trm3=trim(clean(((isset($_POST['gr5_term3'])?$_POST['gr5_term3']:$term3grade5))));

        $grd6trm1=trim(clean(((isset($_POST['gr6_term1'])?$_POST['gr6_term1']:$term1grade6))));
        $grd6trm2=trim(clean(((isset($_POST['gr6_term2'])?$_POST['gr6_term2']:$term2grade6))));
        $grd6trm3=trim(clean(((isset($_POST['gr6_term3'])?$_POST['gr6_term3']:$term3grade6))));     
        
        $cls5trm1=trim(clean(((isset($_POST['cls5_term1'])?$_POST['cls5_term1']:$term1class5))));
        $cls5trm2=trim(clean(((isset($_POST['cls5_term2'])?$_POST['cls5_term2']:$term2class5))));
        $cls5trm3=trim(clean(((isset($_POST['cls5_term3'])?$_POST['cls5_term3']:$term3class5))));

        $cls6trm1=trim(clean(((isset($_POST['cls6_term1'])?$_POST['cls6_term1']:$term1class6))));
        $cls6trm2=trim(clean(((isset($_POST['cls6_term2'])?$_POST['cls6_term2']:$term2class6))));
        $cls6trm3=trim(clean(((isset($_POST['cls6_term3'])?$_POST['cls6_term3']:$term3class6))));

        $cls7trm1=trim(clean(((isset($_POST['cls7_term1'])?$_POST['cls7_term1']:$term1class7))));
        $cls7trm2=trim(clean(((isset($_POST['cls7_term2'])?$_POST['cls7_term2']:$term2class7))));
        $cls7trm3=trim(clean(((isset($_POST['cls7_term3'])?$_POST['cls7_term3']:$term3class7))));

        $cls8trm1=trim(clean(((isset($_POST['cls8_term1'])?$_POST['cls8_term1']:$term1class8))));
        $cls8trm2=trim(clean(((isset($_POST['cls8_term2'])?$_POST['cls8_term2']:$term2class8))));
        $cls8trm3=trim(clean(((isset($_POST['cls8_term3'])?$_POST['cls8_term3']:$term1class8))));

        $term1[]=array(
            'playgroup'=> $playgrouptrm1,
            'pp1'      => $pp1trm1,
            'pp2'      => $pp2trm1,
            'grade1'   => $grd1trm1,
            'grade2'   => $grd2trm1,
            'grade3'   => $grd3trm1,
            'grade4'   => $grd4trm1,
            'grade5'   => $grd5trm1,
            'grade6'   => $grd6trm1,            
            'class5'   => $cls5trm1,
            'class6'   => $cls6trm1,
            'class7'   => $cls7trm1,
            'class8'   => $cls8trm1,
          );

        $term2[]=array(
            'playgroup'=> $playgrouptrm2,
            'pp1'      => $pp1trm2,
            'pp2'      => $pp2trm2,
            'grade1'   => $grd1trm2,
            'grade2'   => $grd2trm2,
            'grade3'   => $grd3trm2,
            'grade4'   => $grd4trm2,
            'grade5'   => $grd5trm2,
            'grade6'   => $grd6trm2,
            'class5'   => $cls5trm2,
            'class6'   => $cls6trm2,
            'class7'   => $cls7trm2,
            'class8'   => $cls8trm2,
        );

        $term3[]=array(
            'playgroup'=> $playgrouptrm3,
            'pp1'      => $pp1trm3,
            'pp2'      => $pp2trm3,
            'grade1'   => $grd1trm3,
            'grade2'   => $grd2trm3,
            'grade3'   => $grd3trm3,
            'grade4'   => $grd4trm3,
            'grade5'   => $grd5trm3,
            'grade6'   => $grd6trm3,
            'class5'   => $cls5trm3,
            'class6'   => $cls6trm3,
            'class7'   => $cls7trm3,
            'class8'   => $cls8trm3,
        );       

        $term1_encoded=json_encode($term1);//encodes all term one data into one array to upload into database
        $term2_encoded=json_encode($term2);//encodes all term two data into one array to upload into database
        $term3_encoded=json_encode($term3);//encodes all term three data into one array to upload into database
    
        $edited_date=date('Y-m-d H:i:s');

    }//END OF THE ISSET EDIT FUNCTION

        if(isset($_POST['updatefees'])){//IF THE UPDATE FEES BUTTON IS CLICKED
            $db->query("UPDATE school_fees SET term1='{$term1_encoded}',term2='{$term2_encoded}',term3='{$term3_encoded}',edited_on='$edited_date' 
                        WHERE year='$year'");
            $messages[].='<b>Success! </b>School fees updated successfully.';
            if(!empty($messages)){
                displaymessages($messages);
            }
        }
    
    if(isset($_POST['submitfeesbtn'])){//This code executes if the submit button is clicked        
        
        $playgrouptrm1=trim(clean(((isset($_POST['plygrp_term1'])?$_POST['plygrp_term1']:''))));
        $playgrouptrm2=trim(clean(((isset($_POST['plygrp_term2'])?$_POST['plygrp_term2']:''))));
        $playgrouptrm3=trim(clean(((isset($_POST['plygrp_term3'])?$_POST['plygrp_term3']:''))));        

        $pp1trm1=trim(clean(((isset($_POST['pp1_term1'])?$_POST['pp1_term1']:''))));
        $pp1trm2=trim(clean(((isset($_POST['pp1_term2'])?$_POST['pp1_term2']:''))));
        $pp1trm3=trim(clean(((isset($_POST['pp1_term3'])?$_POST['pp1_term3']:''))));

        $pp2trm1=trim(clean(((isset($_POST['pp2_term1'])?$_POST['pp2_term1']:''))));
        $pp2trm2=trim(clean(((isset($_POST['pp2_term2'])?$_POST['pp2_term2']:''))));
        $pp2trm3=trim(clean(((isset($_POST['pp2_term3'])?$_POST['pp2_term3']:''))));

        $grd1trm1=trim(clean(((isset($_POST['gr1_term1'])?$_POST['gr1_term1']:''))));
        $grd1trm2=trim(clean(((isset($_POST['gr1_term2'])?$_POST['gr1_term2']:''))));
        $grd1trm3=trim(clean(((isset($_POST['gr1_term3'])?$_POST['gr1_term3']:''))));

        $grd2trm1=trim(clean(((isset($_POST['gr2_term1'])?$_POST['gr2_term1']:''))));
        $grd2trm2=trim(clean(((isset($_POST['gr2_term2'])?$_POST['gr2_term2']:''))));
        $grd2trm3=trim(clean(((isset($_POST['gr2_term3'])?$_POST['gr2_term3']:''))));

        $grd3trm1=trim(clean(((isset($_POST['gr3_term1'])?$_POST['gr3_term1']:''))));
        $grd3trm2=trim(clean(((isset($_POST['gr3_term2'])?$_POST['gr3_term2']:''))));
        $grd3trm3=trim(clean(((isset($_POST['gr3_term3'])?$_POST['gr3_term3']:''))));

        $grd4trm1=trim(clean(((isset($_POST['gr4_term1'])?$_POST['gr4_term1']:''))));
        $grd4trm2=trim(clean(((isset($_POST['gr4_term2'])?$_POST['gr4_term2']:''))));
        $grd4trm3=trim(clean(((isset($_POST['gr4_term3'])?$_POST['gr4_term3']:''))));

        $grd5trm1=trim(clean(((isset($_POST['gr5_term1'])?$_POST['gr5_term1']:''))));
        $grd5trm2=trim(clean(((isset($_POST['gr5_term2'])?$_POST['gr5_term2']:''))));
        $grd5trm3=trim(clean(((isset($_POST['gr5_term3'])?$_POST['gr5_term3']:''))));

        $grd6trm1=trim(clean(((isset($_POST['gr6_term1'])?$_POST['gr6_term1']:''))));
        $grd6trm2=trim(clean(((isset($_POST['gr6_term2'])?$_POST['gr6_term2']:''))));
        $grd6trm3=trim(clean(((isset($_POST['gr6_term3'])?$_POST['gr6_term3']:''))));     
        
        $cls5trm1=trim(clean(((isset($_POST['cls5_term1'])?$_POST['cls5_term1']:''))));
        $cls5trm2=trim(clean(((isset($_POST['cls5_term2'])?$_POST['cls5_term2']:''))));
        $cls5trm3=trim(clean(((isset($_POST['cls5_term3'])?$_POST['cls5_term3']:''))));

        $cls6trm1=trim(clean(((isset($_POST['cls6_term1'])?$_POST['cls6_term1']:''))));
        $cls6trm2=trim(clean(((isset($_POST['cls6_term2'])?$_POST['cls6_term2']:''))));
        $cls6trm3=trim(clean(((isset($_POST['cls6_term3'])?$_POST['cls6_term3']:''))));

        $cls7trm1=trim(clean(((isset($_POST['cls7_term1'])?$_POST['cls7_term1']:''))));
        $cls7trm2=trim(clean(((isset($_POST['cls7_term2'])?$_POST['cls7_term2']:''))));
        $cls7trm3=trim(clean(((isset($_POST['cls7_term3'])?$_POST['cls7_term3']:''))));

        $cls8trm1=trim(clean(((isset($_POST['cls8_term1'])?$_POST['cls8_term1']:''))));
        $cls8trm2=trim(clean(((isset($_POST['cls8_term2'])?$_POST['cls8_term2']:''))));
        $cls8trm3=trim(clean(((isset($_POST['cls8_term3'])?$_POST['cls8_term3']:''))));

        //THESE ARE ARRAYS THAT WILL HOLD DATA FOR EACH TERM FROM ALL LEVELS
        $term1=array();
        $term2=array();
        $term3=array();

        $term1[]=array(
            'playgroup'=> $playgrouptrm1,
            'pp1'      => $pp1trm1,
            'pp2'      => $pp2trm1,
            'grade1'   => $grd1trm1,
            'grade2'   => $grd2trm1,
            'grade3'   => $grd3trm1,
            'grade4'   => $grd4trm1,
            'grade5'   => $grd5trm1,
            'grade6'   => $grd6trm1,
            'class5'   => $cls5trm1,
            'class6'   => $cls6trm1,
            'class7'   => $cls7trm1,
            'class8'   => $cls8trm1,
          );

        $term2[]=array(
            'playgroup'=> $playgrouptrm2,
            'pp1'      => $pp1trm2,
            'pp2'      => $pp2trm2,
            'grade1'   => $grd1trm2,
            'grade2'   => $grd2trm2,
            'grade3'   => $grd3trm2,
            'grade4'   => $grd4trm2,
            'grade5'   => $grd5trm2,
            'grade6'   => $grd6trm2,
            'class5'   => $cls5trm2,
            'class6'   => $cls6trm2,
            'class7'   => $cls7trm2,
            'class8'   => $cls8trm2,
        );

        $term3[]=array(
            'playgroup'=> $playgrouptrm3,
            'pp1'      => $pp1trm3,
            'pp2'      => $pp2trm3,
            'grade1'   => $grd1trm3,
            'grade2'   => $grd2trm3,
            'grade3'   => $grd3trm3,
            'grade4'   => $grd4trm3,
            'grade5'   => $grd5trm3,
            'grade6'   => $grd6trm3,
            'class5'   => $cls5trm3,
            'class6'   => $cls6trm3,
            'class7'   => $cls7trm3,
            'class8'   => $cls8trm3,
        );       

        $term1_encoded=json_encode($term1);//encodes all term one data into one array to upload into database
        $term2_encoded=json_encode($term2);//encodes all term two data into one array to upload into database
        $term3_encoded=json_encode($term3);//encodes all term three data into one array to upload into database
        $year=date('Y');
        $inserted_date=date('Y-m-d H:i:s');

        if(!empty($errors)){//check if there are any errors
            displayErrors($errors);
        }else{
            $db->query("INSERT INTO school_fees (term1,term2,term3,year,insert_date) VALUES('{$term1_encoded}','{$term2_encoded}','{$term3_encoded}','$year','$inserted_date')");
            $messages[].='<b>Success! </b>School fees inserted successfully!.';
            if(!empty($messages)){
                displayMessages($messages);
            }
        }

        }?>

      <form action="<?=((isset($_GET['editfees'])?'finance.php?editfees=1':'finance.php?setfees=1'));?>" method="POST">
    <table class="table-bordered table-hover table table-sm" style="height:400px; margin-bottom:20px;">
        <thead class="thead-light">
            <th>LEVEL</th>
            <th>TERM 1</th>
            <th>TERM 2</th>
            <th>TERM 3</th>
        </thead>
        <tbody>
         
                <tr>
                    <td>PLAYGROUP</td>
                    <td><input type="number" id="" name="plygrp_term1" class="form-control" min=0 required=required value="<?=$term1playgroup;?>"></td>
                    <td><input type="number" id="" name="plygrp_term2" class="form-control" min=0 required=required value="<?=$term2playgroup;?>"></td>
                    <td><input type="number" id="" name="plygrp_term3" class="form-control" min=0 required=required value="<?=$term3playgroup;?>"></td>
                </tr>
                <tr>
                    <td>PP1</td>
                    <td><input type="number" id="" name="pp1_term1" class="form-control" min=0 required=required value="<?=$term1pp1;?>"></td>
                    <td><input type="number" id="" name="pp1_term2" class="form-control" min=0 required=required value="<?=$term2pp1;?>"></td>
                    <td><input type="number" id="" name="pp1_term3" class="form-control" min=0 required=required value="<?=$term3pp1;?>"></td>
                </tr>
                <tr>
                    <td>PP2</td>
                    <td><input type="number" id="" name="pp2_term1" class="form-control" min=0 required=required value="<?=$term1pp2;?>"></td>
                    <td><input type="number" id="" name="pp2_term2" class="form-control" min=0 required=required value="<?=$term2pp2;?>"></td>
                    <td><input type="number" id="" name="pp2_term3" class="form-control" min=0 required=required value="<?=$term3pp2;?>"></td>
                </tr>
                <tr>
                    <td>GRADE 1</td>
                    <td><input type="number" id="" name="gr1_term1" class="form-control" min=0 required=required value="<?=$term1grade1;?>"></td>
                    <td><input type="number" id="" name="gr1_term2" class="form-control" min=0 required=required value="<?=$term2grade1;?>"></td>
                    <td><input type="number" id="" name="gr1_term3" class="form-control" min=0 required=required value="<?=$term3grade1;?>"></td>
                </tr>
                 <tr>
                    <td>GRADE 2</td>
                    <td><input type="number" id="" name="gr2_term1" class="form-control" min=0 required=required value="<?=$term1grade2;?>"></td>
                    <td><input type="number" id="" name="gr2_term2" class="form-control" min=0 required=required value="<?=$term2grade2;?>"></td>
                    <td><input type="number" id="" name="gr2_term3" class="form-control" min=0 required=required value="<?=$term3grade2;?>"></td>
                </tr>
                <tr>
                    <td>GRADE 3</td>
                    <td><input type="number" id="" name="gr3_term1" class="form-control" min=0 required=required value="<?=$term1grade3;?>"></td>
                    <td><input type="number" id="" name="gr3_term2" class="form-control" min=0 required=required value="<?=$term2grade3;?>"></td>
                    <td><input type="number" id="" name="gr3_term3" class="form-control" min=0 required=required value="<?=$term3grade3;?>"></td>
                </tr>
                 <tr>
                    <td>GRADE 4</td>
                    <td><input type="number" id="" name="gr4_term1" class="form-control" min=0 required=required value="<?=$term1grade4;?>"></td>
                    <td><input type="number" id="" name="gr4_term2" class="form-control" min=0 required=required value="<?=$term2grade4;?>"></td>
                    <td><input type="number" id="" name="gr4_term3" class="form-control" min=0 required=required value="<?=$term3grade4;?>"></td>
                </tr>
                 <tr>
                    <td>GRADE 5</td>
                    <td><input type="number" id="" name="gr5_term1" class="form-control" min=0 required=required value="<?=$term1grade5;?>"></td>
                    <td><input type="number" id="" name="gr5_term2" class="form-control" min=0 required=required value="<?=$term2grade5;?>"></td>
                    <td><input type="number" id="" name="gr5_term3" class="form-control" min=0 required=required value="<?=$term3grade5;?>"></td>
                </tr>
                 <tr>
                    <td>GRADE 6</td>
                    <td><input type="number" id="" name="gr6_term1" class="form-control" min=0 required=required value="<?=$term1grade6;?>"></td>
                    <td><input type="number" id="" name="gr6_term2" class="form-control" min=0 required=required value="<?=$term2grade6;?>"></td>
                    <td><input type="number" id="" name="gr6_term3" class="form-control" min=0 required=required value="<?=$term2grade6;?>"></td>
                </tr>       
                 <tr>
                    <td>CLASS 5</td>
                    <td><input type="number" id="" name="cls5_term1" class="form-control" min=0 required=required value="<?=$cls5trm1;?>"></td>
                    <td><input type="number" id="" name="cls5_term2" class="form-control" min=0 required=required value="<?=$cls5trm2;?>"></td>
                    <td><input type="number" id="" name="cls5_term3" class="form-control" min=0 required=required value="<?=$cls5trm3;?>"></td>
                </tr> 
                 <tr>
                    <td>CLASS 6</td>
                    <td><input type="number" id="" name="cls6_term1" class="form-control" min=0 required=required value="<?=$cls6trm1;?>"></td>
                    <td><input type="number" id="" name="cls6_term2" class="form-control" min=0 required=required value="<?=$cls6trm2;?>"></td>
                    <td><input type="number" id="" name="cls6_term3" class="form-control" min=0 required=required value="<?=$cls6trm3;?>"></td>
                </tr> 
                 <tr>
                    <td>CLASS 7</td>
                    <td><input type="number" id="" name="cls7_term1" class="form-control" min=0 required=required value="<?=$cls7trm1;?>"></td>
                    <td><input type="number" id="" name="cls7_term2" class="form-control" min=0 required=required value="<?=$cls7trm2;?>"></td>
                    <td><input type="number" id="" name="cls7_term3" class="form-control" min=0 required=required value="<?=$cls7trm3;?>"></td>
                </tr> 
                 <tr>
                    <td>CLASS 8</td>
                    <td><input type="number" id="" name="cls8_term1" class="form-control" min=0 required=required value="<?=$cls8trm1;?>"></td>
                    <td><input type="number" id="" name="cls8_term2" class="form-control" min=0 required=required value="<?=$cls8trm2;?>"></td>
                    <td><input type="number" id="" name="cls8_term3" class="form-control" min=0 required=required value="<?=$cls8trm3;?>"></td>
                </tr>                 
           </form>
        </tbody>
       
    </table>
 <div class="form-group">
     
          <input type="submit" class="btn btn-sm btn-primary" name="submitfeesbtn" id="submitfeesbtn" value="<?=((isset($_GET['editfees'])?'Update fees':'Submit'));?>">
    
 </div>
  </form>
</div>