<!DOCTYPE html>
<html lang="en">
<head>
    <?php
    require_once $_SERVER['DOCUMENT_ROOT'].'/school/core/init.php';
    include '../admin/header.php';
    ?>
    <style>
        #findStaffDiv{
            border: 1px solid #B2BEB5;
            border-radius: 30px;
            padding: 5px 20px;
        }
        #findStaffDiv span{
            border: none; 
            background: none;
        }
        #findStaffDiv input[type='search']{
            border: none;
            background-color: transparent;
            outline: none;
        }
        #findStaffDiv input[type='search']:focus,  #findStaffDiv button:focus{
            border-color: rgba(126, 239, 104, 0.8);
            box-shadow: 0 1px 1px rgba(0, 0, 0, 0.075) inset, 0 0 8px rgba(126, 239, 104, 0.6);
            outline: 0 none;
        }
    </style>
</head>
<body>
<?php include '../admin/navigation.php';?>
    <div class="container-fluid">
        <div class="row">
            <div class="col-md-3">
                <?php include '../admin/left.php';?>
            </div>
            <div class="col-md-9">
                <div class="container-fluid">
                    <div class="row py-3">
                        <div class="col-md-2"><h5 class="my-auto"><i class="fas fa-users-class"></i> Staff.</h5></div>
                        <div class="col-md-7">
                            <div id="findStaffDiv">
                            <div class="input-group">
                                <div class="input-group-prepend">
                                    <span class="input-group-text px-4"><i class="fas fa-search"></i></span>
                                </div>
                                <input type="search" class="form-control" placeholder="Recipient's username" aria-label="Recipient's username" aria-describedby="button-addon2">
                                <div class="input-group-append">
                                    <div class="dropdown">
                                        <button class="btn dropdown-toggle" type="button" data-toggle="dropdown" aria-expanded="false">
                                            <i class="fas fa-filter"></i> Filter
                                        </button>
                                        <div class="dropdown-menu p-3 shadow-sm" style="width:300px !important;">
                                            <h6>Gender</h6> <hr>
                                            <div class="form-check form-check-inline">
                                                <input class="form-check-input" type="radio" name="gender" id="inlineRadio1" value="BOTH" <?="checked"?>>
                                                <label class="form-check-label" for="inlineRadio1">Both</label>
                                            </div>
                                            <div class="form-check form-check-inline">
                                                <input class="form-check-input" type="radio" name="gender" id="inlineRadio1" value="MALE">
                                                <label class="form-check-label" for="inlineRadio1">Male</label>
                                            </div>
                                            <div class="form-check form-check-inline">
                                                <input class="form-check-input" type="radio" name="gender" id="inlineRadio2" value="FEMALE">
                                                <label class="form-check-label" for="inlineRadio2">Female</label>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            </div>
                        </div>
                        <div class="col-md-3">
                            <button class="btn btn-md btn-primary float-right"><i class="fas fa-user-plus"></i> Add New</button>
                        </div>
                    </div>
                    <?php
                      $staffQuery   =   $db->query("SELECT * FROM `users` WHERE `deleted`=0 AND `id` !=1 ORDER BY `name`");  
                    ?>
                    <div id="contentDiv">
                    <table class="table table-sm table-hover table-bordered">
                        <thead class="thead-light">
                            <tr>
                            <th scope="col">#</th>
                            <th scope="col">IMAGE</th>
                            <th scope="col">NAME</th>
                            <th scope="col">TSC. NO</th>
                            <th scope="col">PHONE</th>
                            <th scope="col">GENDER</th>
                            <th>ACTIONS</th> 
                            </tr>
                        </thead>
                        <tbody>
                            <?php $count=1; while($staffData = mysqli_fetch_array($staffQuery)): ?>
                            <tr>
                            <th scope="row"><?=$count?></th>
                            <td><img src="<?=$staffData['image']?>" class="img img-thumbnail mx-auto d-block rounded-circle" style="height: 40px; width: 40px;" alt=""></td>
                            <td id="staffName"><?=$staffData['name']?></td>
                            <td><?=((!empty($staffData['tsc_number'])) ? $staffData['tsc_number'] : "<i>NULL</i>")?></td>
                            <td><?=$staffData['phone']?></td>
                            <td><?=$staffData['gender']?></td>
                            <td>
                                <div class="btn-group dropleft">
                                <button type="button" class="btn btn-default btn-sm dropdown-toggle" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                    Actions
                                </button>
                                <div class="dropdown-menu">
                                    <a class="dropdown-item text-primary viewDocs" href="#" id="<?=$staffData['id']?>"><i class="fas fa-folder-open"></i> &nbsp; documents.</a>
                                    <div class="dropdown-divider"></div>
                                    <a class="dropdown-item viewBtn" href="#" id="<?=$staffData['id']?>"><i class="fa fa-eye" aria-hidden="true"></i> &nbsp; view</a>
                                    <a class="dropdown-item text-primary" href="<?=$_SERVER['PHP_SELF']."?edit=".$staffData['id']?>"><i class="fas fa-pencil-alt"></i> &nbsp; edit</a>
                                    <a class="dropdown-item text-danger deleteuserbtn" id="<?=$staffData['id']?>" href="#"><i class="fas fa-trash-alt"></i> &nbsp; delete</a>
                                </div>
                                </div>
                            </td>
                            </tr>
                           <?php $count++; endwhile;?>
                        </tbody>
                    </table>
                    </div>
                    <!-- Modal -->
                    <div class="modal fade" id="deleteUSerDiv" data-backdrop="static" tabindex="-1" role="dialog" aria-labelledby="staticBackdropLabel" aria-hidden="true">
                        <div class="modal-dialog" role="document">
                            <div class="modal-content">
                            <div class="modal-header">
                                <h5 class="modal-title" id="staticBackdropLabel">Modal title</h5>
                                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                <span aria-hidden="true">&times;</span>
                                </button>
                            </div>
                            <div class="modal-body">
                                <h6><i class="fas fa-exclamation-triangle"></i> Proceed to delete this user?</h6>
                            </div>
                            <div class="modal-footer">
                                <button type="button" class="btn btn-danger btn-sm del">Delete</button>
                            </div>
                            </div>
                        </div>
                    </div>
                    <!-- Modal -->
                    <div class="modal fade" id="viewStaffModal" data-backdrop="static" tabindex="-1" role="dialog" aria-labelledby="staticBackdropLabel" aria-hidden="true">
                        <div class="modal-dialog modal-dialog-centered modal-lg role="document">
                            <div class="modal-content">
                            <div class="modal-header">
                                <h5 class="modal-title" id="staticBackdropLabel">Staff Details</h5>
                                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                <span aria-hidden="true">&times;</span>
                                </button>
                            </div>
                            <div class="modal-body">
                                ...
                            </div>
                            <div class="modal-footer"></div>
                            </div>
                        </div>
                    </div>
                    <!-- Modal -->
                    <div class="modal fade" id="docsModal" data-backdrop="static" data-keyboard="false" tabindex="-1" aria-labelledby="staticBackdropLabel" aria-hidden="true">
                        <div class="modal-dialog">
                            <div class="modal-content">
                            <div class="modal-header">
                                <h5 class="modal-title" id="staticBackdropLabel">Documents</h5>
                                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                <span aria-hidden="true">&times;</span>
                                </button>
                            </div>
                            <div class="modal-body">
                                ...
                            </div>
                            <div class="modal-footer"></div>
                            </div>
                        </div>
                    </div>
                    <!-- Modal -->
                    <div class="modal fade" id="editDocModal" data-backdrop="static" data-keyboard="false" tabindex="-1" aria-labelledby="staticBackdropLabel" aria-hidden="true">
                        <div class="modal-dialog">
                            <div class="modal-content">
                            <div class="modal-header">
                                <h5 class="modal-title" id="staticBackdropLabel">Edit Document</h5>
                                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                <span aria-hidden="true">&times;</span>
                                </button>
                            </div>
                            <div class="modal-body">
                                <div id="notificationsDiv"></div>
                                <form action="#" id="editDocForm" method="post" enctype="multipart/form-data">
                                    <div class="form-group">
                                        <label for="">Document Name:</label>
                                        <input type="text" name="docname" class="form-control" required=required>
                                    </div>
                                    <button type="submit" class="btn btn-primary ">
                                        <span class="spinner-border spinner-border-sm" role="status" aria-hidden="true"></span>
                                        <span class=""> Update Document Name</span>
                                    </button>
                                </form>
                            </div>
                            <div class="modal-footer">
                                <button type="button" class="btn btn-sm btn-default" data-dismiss="modal">Close</button>
                            </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
   <script src="/school/js/jquery-3.3.1.min.js" type="text/javascript"></script>
   <script src="/school/js/jquery-ui.min.js" type="text/javascript"></script>  
   <script src="https://cdn.jsdelivr.net/npm/popper.js@1.16.1/dist/umd/popper.min.js"></script>
   <!-- <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/2.9.2/umd/popper.min.js" integrity="sha512-2rNj2KJ+D8s1ceNasTIex6z4HWyOnEYLVC3FigGOmyQCZc2eBXKgOxQmo3oKLHyfcj53uz4QMsRCWNbLd32Q1g==" crossorigin="anonymous" referrerpolicy="no-referrer"></script> -->
   <script src="/school/js/bootstrap.min.js" type="text/javascript"></script>     
   <script src="https://canvasjs.com/assets/script/canvasjs.min.js"></script>
   <?php include '../admin/footer.php' ?>
   <script>
    //when the search staff input has been typed into
    jQuery('#findStaffDiv').find("input[type='search']").keyup(function(){
        var staff_name = $(this).val();
        var staff_gender = $(this).find("input[name='gender']:checked").val();
        var filter_staff_data = {
            STAFF_NAME : staff_name,
            STAFF_GENDER : staff_gender
        };
        jQuery.ajax({
            url: "/school/admin/staff/fetch-staff-details.php",
            method: "POST",
            data: filter_staff_data,
            success: function(data){

            },
            error: function(){
                alert("Problem trying to view staff ID reload and rtry again.");
            }
        });
    });

    //when the documents modal has been clicked
    jQuery(".viewDocs").click(function(e){
        e.preventDefault();
        var userid = $(this).attr("id"); //the id for the user 
        display_user_documents(userid);
    });

    //when the view button ash been clicked
    $(".viewBtn").click(function(){
        $("#viewStaffModal").modal("show");
        var staffId = $(this).attr("id");//this is the ID for the staff from the DB
        jQuery.ajax({
            url: "/school/admin/staff/view-staff-details.php",
            method: "POST",
            data: {"VIEW_ID":staffId},
            success: function(data){
                $("#viewStaffModal").find(".modal-body").html(data);
            },
            error: function(){
                alert("Problem trying to view staff ID reload and rtry again.");
            }
        });
    });

    //when the delete user button has been clicked
    jQuery('.deleteuserbtn').click(function(){
         var deleteStaffId=jQuery(this).attr("id");      
         var staffName = $(this).closest("tr").find("td#staffName").html().trim();
         $("#deleteUSerDiv").find(".modal-header h5").html(staffName);
         $("#deleteUSerDiv").modal("show"); 
         //when the dlete button in th modal has been clicked
         $("#deleteUSerDiv").find("button.del").click(function(){
            proceed_to_delete_user(deleteStaffId);
         });        
    });

    function display_user_documents(id){
        jQuery.ajax({
            url:'/school/admin/staff/staff-documents.php',
            method:'POST',
            data:{"STAFF_DOC_ID" : id},
            success:function(data){
                $("#docsModal").find(".modal-body").html(data);
                $("#docsModal").modal('show');

                //when the delete button has been deleted
                $("#docsModal").find(".delDocBtn").click(function(e){
                    e.preventDefault();
                    var docId = $(this).attr("id");
                    jQuery.ajax({
                        url: "/school/admin/staff/delete-staff-document.php",
                        method:"POST",
                        data:{"DOCUMENT_ID" : docId},
                        success: function(data){
                            $("#docsModal").find('#notificationsDiv').html(data);
                        },
                        error: function(){
                            alert("There was a problem sending the delete ID to the esecuting file");
                        }
                    });
                });

                //when the edit button has been clicked
                $("#docsModal").find('.editDocBtn').click(function(e){
                    e.preventDefault();
                    var docId = $(this).attr("id");
                    //get the name of the document
                    var docName = $(this).closest("tr").find("td#docNameTr").html();
                    $("#editDocModal").find("input[name='docname']").val(docName);
                    //close this modal and open another modal
                    $("#docsModal").modal("hide");
                    $("#editDocModal").modal("show");
                    //when the submit button has been clicked for the edit button form
                    $("#editDocForm").submit(function(e){
                        e.preventDefault();
                        var newDocName = $(this).find("#input[name='docname']").val();
                        //compare the rwo strings and determine whether they are the same
                        if(newDocName.trim() !== docName){
                            var documentData = {
                                DOCUMENT_ID : id,
                                DOCUMENT_NAME : newDocName
                            }

                            jQuery.ajax({
                                url: "/school/admin/staff/edit-staff-document.php",
                                method: "POST",
                                data: documentData,
                                success: function(data){
                                    $("#editDocModal").find("#notificationsDiv").html(data); //display message from the backend 
                                    $("#editDocForm").trigger("reset"); //reset the form data
                                },
                                error: function(){
                                    alert('There ash been an error trying to update the document name');
                                }
                            });
                        }else{
                            alert("The Document Name has not been changed.");
                            return;
                        }
                    });
                });

                //when the upload button has been clicked
                $("#uploadDocForm").submit(function(e){ 
                    e.preventDefault();
                    var formData = new FormData();
                    formData.append('file', $("#uploadDocForm").find("input[type='file']")[0].files[0]);
                    formData.append("docname", $("#uploadDocForm").find("input[name='docname']").val());
                    $.ajax({
                        url : '/school/admin/staff/upload-staff-documents.php',
                        type : 'POST',
                        data : formData,
                        processData: false,  // tell jQuery not to process the data
                        contentType: false,  // tell jQuery not to set contentType
                        beforeSend: function(){
                            const d = new Date();
                            d.setTime(d.getTime() + (1*60*1000));
                            let expires = d.toUTCString();
                            document.cookie="STAFF_DOC_ID="+id+", expires="+expires+", path=/";
                        },
                        success : function(data){
                            $("#uploadDocForm").trigger("reset");
                            $("#docsModal").find("#notificationsDiv").html(data);
                            return;
                        },
                        error: function(){
                            alert("There was a problem trying to upload docuemnt. Reload and try again");
                        }
                    });
                });
            },
            error:function(){
                alert("Something went wrong trying to fetch documents for this user.");
            },
        });
    }

    function proceed_to_delete_user(id){
        jQuery.ajax({
            url:'/school/admin/staff/delete-staff.php',
            method:'POST',
            data:{"DELETE_ID":id},
            success:function(data){
                $("#deleteUSerDiv").find(".modal-body h6").html(data);
                $('#deleteUSerDiv').on("hidden.bs.modal", function(){
                    $(this).find(".modal-body h6").html("Proceed to delete this user?");
                });
            },
            error:function(){
                alert("Something went wrong trying to delete user.");
            },
        });
    }   
   </script>
</body>
</html> 