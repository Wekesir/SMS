<!DOCTYPE html>
<html>
<head>
    <?php
        require_once $_SERVER['DOCUMENT_ROOT'].'/school/core/init.php';
        include '../admin/header.php';
    ?>
</head>
<body>   
    <?php include '../admin/navigation.php';?>
 <div class="container-fluid">
    <div class="row">
        <div class="col-md-3">
            <?php include '../admin/left.php';?>
        </div><!--Closing col-md-3 div-->
        <div class="col-md-9" id="wrapper">
        <a href="schooldocuments.php?addDoc=1" class="btn btn-primary addBtn" title="Click to upload new document." style="border-radius:50%;position:absolute;bottom:5%;right:5%;">
            <i class="fas fa-plus"></i>
        </a>
         <div id="documentsContainer" style="padding:10px;width:80%;position:absolute;left:10%;top:2%;">            
            <h6 class="text-center" style="background:#f8f8f8;padding:15px;">
                <?=((isset($_GET['addDoc'])||isset($_GET['editDocument'])? '<label class="float-left"> <a href="schooldocuments.php">Back.</a> </label>' :''))?>
                <?=((isset($_GET['addDoc'])?'UPLOAD DOCUMENT' :'SCHOOL DOCUMENTS'))?>
                <a href="#" class="btn-default float-right unhideSearch text-primary" title="Click to search document."> <i class="fas fa-search"></i> search. </a>
            </h6>
            <div id="searchDiv">
                <input type="search" class="form-control" placeholder="Search document name.">
            </div>
            <?php
                if(isset($_REQUEST['addDoc']) || isset($_GET['editDocument']))://IF THE ADD BUTTON HAS BEEN CLICKED THIS CODE SHOULD EXECUTE
                    if(isset($_REQUEST['editDocument'])):
                        $docId      = (int)decodeURL($_REQUEST['editDocument']);
                        $docQuery   = $db->query("SELECT * FROM `school_documents` WHERE `id`='{$docId}'");
                        if(mysqli_num_rows($docQuery)==0):
                            $errors[].='<b>Error! </b>The document with this identity can not be found.';
                            displayErrors($errors);
                        else:
                            $editData = mysqli_fetch_array($docQuery);
                            if(isset($_POST['update'])):
                               $docName = ((isset($_POST['docName'])? strtoupper(trim($_POST['docName'])):''));
                               $db->query("UPDATE   `school_documents` SET `document_name`='{$docName}' WHERE `id`='{$docId}'");
                               $messages[].='<b>Success! </b>The document has been updated.';
                               displayMessages($messages);
                            endif;
                        endif;
                    endif;

                    if(isset($_POST['submit'])){//if the submit button has been clicked inside the add doc condition
                        $documentname = strtoupper(clean(trim(((isset($_POST['docName'])? $_POST['docName'] : '')))));
                        $filename     = trim(clean(((isset($_FILES['doc']['name'])? $_FILES['doc']['name'] : ''))));
                        if($filename !=''){
                            $target_dir='/documents/school/';
                            $fileDestination=BASEURL.$target_dir.$_FILES['doc']['name'];
                            $fileTempName =$_FILES["doc"]["tmp_name"];
                            $fileError=$_FILES['doc']['error'];            
                            $schooldocumenturl='/school/documents/school/'.$_FILES['doc']['name'];
                            $docFileNameExtension=strtolower(pathinfo($filename,PATHINFO_EXTENSION));        
                            $extensions=array('pdf','doc','docx');
                            if(!in_array($docFileNameExtension,$extensions,TRUE)){//checks if the file extension is allowed
                            $errors[].='<b>Error! </b>Only PDF, DOC and DOCX file formats are allowed!';
                            }            
                        }
                        if(!empty($filename)){//move the uploaded file only if its not empty
                                move_uploaded_file($fileTempName,$fileDestination);
                            }
                        $db->query("INSERT INTO school_documents(document_name,document_path) VALUES('$documentname','$schooldocumenturl')");
                        $messages[].='<b>Success! </b>Document uploaded.';
                        if(!empty($messages)){
                            displayMessages($messages);
                        }
                    }//SUBMIT BUTTON ENDS HERE
                    ?>

                    <form action="<?=$_SERVER['PHP_SELF'].((isset($_REQUEST['editDocument'])?'?editDocument='.encodeURL($editData['id']):'?addDoc=1'))?>" method="POST" enctype="multipart/form-data">
                        <div class="form-group">
                            <label for="docName">Document Name*</label>
                            <input type="text" name="docName" class="form-control" value="<?=((isset($_REQUEST['editDocument'])? $editData['document_name']:''))?>" required=required>
                        </div>
                        <div class="form-group"> 
                            <label for="doc">Document*</label>
                            <input type="file" name="doc" class="form-control" <?=((isset($_REQUEST['editDocument'])?'':'required=required'))?>>
                        </div>
                        <div class="form-group">
                            <input type="submit" name="<?=((isset($_REQUEST['editDocument'])?'update':'submit'))?>" class="btn btn-sm btn-primary" value="<?=((isset($_REQUEST['editDocument'])?'Update Document':'Submit'))?>">
                        </div>
                    </form>
                    <?php
                else:
                    //THIS IS THE CODE FOR DELETING A DOCUMENT FROM SERVER USING MODAL
                    if(isset($_GET['delDocument'])):
                        $docId          = (int)decodeURL($_GET['delDocument']);
                        $docQuery       = $db->query("SELECT * FROM `school_documents` WHERE `id`='{$docId}'");
                        $docQueryData   = mysqli_fetch_array($docQuery);
                        $docPathName    = $docQueryData['document_path'];     
                        $newDocDir      = $_SERVER['DOCUMENT_ROOT'].$docPathName;//this is the root directory for the file we want to delete                    
                        if(unlink($newDocDir))://unlink() is a function for deleting file from server
                            $db->query("DELETE FROM school_documents WHERE id='$docId'");
                            $messages[].='<b>Success! </b>Document deleted from server.';
                            if(!empty($messages)):
                                displayMessages($messages);
                            endif;
                        else:
                            $errors[].='<b>Error! </b>Failed to delete document from server.';
                            if(!empty($errors)):
                                displayErrors($errors);
                            endif;
                        endif;  
                    endif;
                    /*************************************************************************************************
                     *DELETE FILE FROM SERVER USING  MODAL ENDS HERE
                    ************************************************************************************************************/
                    ?>
                    <table class="table-striped table table-sm">                       
                        <thead class="thead-light">
                            <th>#</th>
                            <th>DOCUMENT</th>
                            <th>DOWNLOAD</a></th>
                            <th>ACTIONS</th>
                        </thead>
                        <tbody id="tableBody">
                            <?php 
                            $count = 1;
                            $query = $db->query("SELECT * FROM school_documents");
                            if(mysqli_num_rows($query)==0){
                                $info[].='<b>Oops! </b>No documents in the system.'; displayInfo($info);
                            }
                            while($queryData = mysqli_fetch_array($query)) :?>
                                <tr>
                                    <td class="text-center"><?=$count;?></td>
                                    <td><i class="fas fa-file-alt"></i> <?=$queryData['document_name'];?> </td>
                                    <td class="text-center"><a href="<?=$queryData['document_path'];?>" title="Click to download doc." class="btn-default"><i class="fas fa-file-download"></i> download.</a></td>
                                    <td class="text-center">   
                                        <a href="schooldocuments.php?editDocument=<?=encodeURL($queryData['id']);?>"><i class="fas fa-pencil-alt"></i> edit.</a>                              
                                        <a href="schooldocuments.php?delDocument=<?=encodeURL($queryData['id']);?>" class="text-danger" title="Click to delete document from server"><i class="fas fa-trash-alt"></i> delete.</a>                                        
                                    </td>
                                </tr>
                            <?php $count++; endwhile; ?>
                        </tbody>                        
                    </table>
                <?php endif;  ?>
         
         </div><!---CLOSING DOCUMENT CONTAINER DIV-->
          

        </div><!--Closing col-md-9 div-->
    </div><!--Closing row dic--> 
 </div><!--closing container div-->
    <?php include '../admin/footer.php';?>
</body>
</html>
<script>
jQuery('.unhideSearch').click(function(e){//this code reveals the search document div
    e.preventDefault();
    jQuery('#searchDiv').slideToggle();
    jQuery('input[type="search"]').focus();
});

jQuery('input[type="search"]').keyup(function(){
    var docName = jQuery(this).val();//gets the word typed in the serach box    
   jQuery.ajax({
        url:'/school/admin/fetch.php',
        method:'post',
        data:{docName:docName},
        success:function(data){ 
            jQuery('#tableBody').html();
            jQuery('#tableBody').html(data);
        },
        error:function(){
            alert("Something went wrong trying to search for document");
        },
   });
});

</script>

