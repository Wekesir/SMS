<div class="container-fluid">
<div class="p-2 row">
    <div class="col-md-4"><h5>Food Programme.</h5></div>
    <div class="col-md-3">
        
    </div>
    <div class="col-md-5">
        <form action="#" method="post">
        <div class="input-group mb-3">
            <input type="text" class="form-control" placeholder="UPI Number" aria-label="Recipient's username" aria-describedby="button-addon2" required=required>
            <div class="input-group-append">
                <button class="btn btn-light" type="button" onclick="fetch_students()"><i class="fa fa-times" aria-hidden="true"></i></button>
                <button class="btn btn-light" type="submit" id="button-addon2"><i class="fa fa-search" aria-hidden="true"></i></button>
            </div>
        </div>
        </form>
    </div>
</div>
<div class="container-fluid">

    <button class="btn btn-md btn-primary p-2 position-absolute rounded-circle shadow" id="add_student_btn" title="Add new student to the food programme." style="right: 5%; bottom: 5%;"><i class="fa fa-user-plus" aria-hidden="true"></i></button>

    <table class="table table-bordered table-sm table-hover">
        <thead class="thead-light">
            <tr>
            <th scope="col">#</th>
            <th scope="col"></th>
            <th scope="col">UPI NUMBER</th>
            <th scope="col">NAME</th>
            <th scope="col">LEVEL</th>
            <th scope="col">AMT (Kshs.)</th>
            <th scope="col"></th>
            </tr>
        </thead>
        <tbody id="tbody">
            
        </tbody>
    </table>

    <div class="modal fade" id="addStudentModal" data-backdrop="static" data-keyboard="false" tabindex="-1" aria-labelledby="staticBackdropLabel" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered modal-lg">
            <div class="modal-content">
            <div class="modal-header">
                <button class="btn btn-sm btn-light rounded-circle" class="close" data-dismiss="modal" aria-label="Close"><i class="fa fa-arrow-left" aria-hidden="true"></i></button> &nbsp;
                <h5 class="modal-title" id="staticBackdropLabel">Add Student(s).</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <div>
                    <div class="input-group mb-3">
                    <div class="input-group-prepend mr-2">
                       <button class="btn btn-light rounded-circle" type="button" id="button-addon1"><i class="fa fa-search" aria-hidden="true"></i></button>
                    </div>
                    <input type="text" class="form-control rounded-pill px-3" placeholder="Student Name" aria-label="Recipient's username" aria-describedby="button-addon2">
                    <div class="input-group-append ml-2">
                        <button class="btn d-none" type="button" id="spinnerBtn"><span class="spinner-border spinner-border-sm text-primary" role="status" aria-hidden="true"></span></button>
                        <button class="btn btn-light rounded-circle" type="button" id="button-addon2"><i class="fa fa-times" aria-hidden="true"></i></button>
                    </div>
                    </div>
                </div>
                <div id="notificationsDiv"></div>
                <div id="contentDiv" class="d-flex align-center" style="max-height: 55vh; padding: 20px; overflow:auto">
                    <img src="https://encrypted-tbn0.gstatic.com/images?q=tbn:ANd9GcQQgDMLWKTyNQCitsfHC45bq90vKTW-oy5Wuw&usqp=CAU" style="height: 150px; width: 150px; margin-left:auto; margin-right:auto; display:block;" alt="">
                </div>
            </div>
            </div>
        </div>
    </div>

    <!-- Delete student confirmation Modal -->
    <div class="modal fade" id="deleteStudentModal" data-backdrop="static" data-keyboard="false" tabindex="-1" aria-labelledby="staticBackdropLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
        <div class="modal-header">
            <button class="btn btn-sm btn-light rounded-circle" class="close" data-dismiss="modal" aria-label="Close"><i class="fa fa-arrow-left" aria-hidden="true"></i></button> &nbsp;
            <h5 class="modal-title" id="staticBackdropLabel">Delete Student..</h5>
            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
            <span aria-hidden="true">&times;</span>
            </button>
        </div>
        <div class="modal-body">
            <input type="hidden" name="delStdID">
            <h5>Proceed to delete student?</h3>
        </div>
        <div class="modal-footer">
            <button type="button" class="btn btn-secondary btn-sm" data-dismiss="modal">Close</button>
            <button type="button" class="btn btn-danger btn-sm deleteBtn" onclick="delete_student_from_food_prog()">Delete</button>
        </div>
        </div>
    </div>
    </div>

</div>
</div>

<script>
    jQuery(document).ready(function(){
        fetch_students();
    });

    jQuery("#addStudentModal").find("input[type='text']").keyup(function(){
        var std_name = $(this).val();
        jQuery("#addStudentModal").find("#spinnerBtn").removeClass("d-none").addClass("d-inline-block");
        jQuery("#addStudentModal").find(".spinner-border").addClass("active");
        if(std_name != ""){
            jQuery.ajax({
                url:'/school/foodProgramme/search.php',
                method:'POST',
                data:{SEARCH_NAME:std_name},
                success:function(data){
                jQuery("#contentDiv").html(data);
                jQuery("#addStudentModal").find("input[type='checkbox']:not(:checked)").click(function(){//only gets the value of the unchecked checkbox
                    var reg_number = $(this).val();
                    send_reg_number(reg_number);//send the registration numbe to the executing file
                    fetch_students();
                    return;
                });
                },
                error:function(){
                    alert("There has been a problem trying to search student name.");
                }
            });
        }
    })

    jQuery("#add_student_btn").click(function(){//whe the add student button has been clicked
        jQuery("#addStudentModal").modal("toggle");
    });

    jQuery("form").submit(function(e){
        e.preventDefault();
        var UPI = jQuery(this).find("input[type='text']").val();//gets the value typed into the search field
        jQuery.ajax({
            url:'/school/foodProgramme/search.php',
            method:'POST',
            data:{UPI:UPI},
            success:function(data){
              jQuery("tbody").html(data);
            },
            error:function(){
                alert("There has been a problem trying to search student name.");
            }
        });
    });

    function send_reg_number(number){
        jQuery.ajax({
            url: "/school/foodProgramme/add-student.php",
            method: "POST",
            data:{REG_NUMBER:number},
            success: function(data){
                //display feedback from the server
                jQuery("#addStudentModal").find("#notificationsDiv").html(data);
                jQuery("#addStudentModal").find("#spinnerBtn").addClass("d-none").removeClass("d-inline-block");//hides the button holding the spinner
                jQuery("#addStudentModal").find(".spinner-border").removeClass("active");//hidees the spinner
            },
            error: function(){
                alert("There was an error trying to get the student data");
            }
        });
    }

    function fetch_students(){
        var students = "";
        jQuery.ajax({
            url: "/school/foodProgramme/search.php",
            method: "POST",
            data:{students:students},
            success: function(data){
              jQuery("tbody").html(data);
               //when the delete button has been clicked
                jQuery("#tbody").find(".deleteStudent").click(function(){
                    var studentId = jQuery(this).attr("data-studentId");
                    trigger_delete_modal(studentId); //sends the studeent id to the server tp\ be deleted
                });
            },
            error: function(){
                alert("There was an error trying to get the student data");
            }
        });
    }

    function trigger_delete_modal(id){
        //toggle the delete modal
        jQuery('#deleteStudentModal').modal("toggle");
        jQuery("#deleteStudentModal").find("input[name='delStdID']").val(id); //send the student ID to the confirmation delete modal
    }

    function delete_student_from_food_prog(){
        var id =  jQuery("#deleteStudentModal").find("input[name='delStdID']").val();
        jQuery.ajax({
            url: "/school/foodProgramme/del-student.php",
            method: "POST",
            data:{DELETE_ID:id},
            success: function(data){
                jQuery("#deleteStudentModal").find(".modal-body").html(data);
                fetch_students();
                return;
            },
            error: function(){
                alert("There was an error trying to get the student data");
            }
        });
    }
</script>