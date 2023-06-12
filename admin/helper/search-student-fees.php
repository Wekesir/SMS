<div class="container">
    <div class="row">
        <div id="search-finance-Div">
            <div class="input-group">
            <div class="input-group-prepend">
                <button class="btn" type="button" id="button-addon1"><i class="fas fa-search"></i></button>
            </div>
            <input type="search" class="form-control" placeholder="Search student name..." aria-label="Example text with button addon" aria-describedby="button-addon1">
            <div class="input-group-append">
                <label><img src="<?=$configurationData['school_logo']?>" style="height: 20px; width: 20px" alt=""></label>
            </div>
            </div>
        </div>
    </div>
    <div class="row">
        <div id="resultsDiv">
        <div class="spinner-border text-info" role="status">
        <span class="sr-only">Loading...</span>
        </div>
        </div>

        <!-- Modal -->
        <div class="modal fade" id="financeStatementModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered modal-lg" role="document">
            <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="exampleModalLabel">Fees Statement</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                ...
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-primary"><i class="fas fa-print"></i> Print</button>
            </div>
            </div>
        </div>
        </div>

    </div>
</div>

<script>
jQuery('#search-finance-Div').find('input[type="search"]').keyup(function(){
    var student_finance=$(this).val();
    jQuery(".spinner-border").addClass("active");
    if(student_finance != ""){
        jQuery.ajax({
            url:'/school/admin/helper/student-finance-data.php',
            method:'POST',
            data:{student_finance:student_finance},            
            success:function(data){       
                jQuery(".spinner-border").removeClass("active");        
                jQuery('#resultsDiv').html(data);
                jQuery("#resultsDiv").find("table tr").click(function(){
                    var stdDbId = $(this).find("input[type='hidden']").val();
                    get_student_fees_statement(stdDbId);
                })
            },
            error:function(){
                alert("Something went wrong trying to search student");
            }
        }); 
    }else{
        jQuery('#resultsDiv').html();
    }

});

function get_student_fees_statement(id){
    if(id != ""){
        jQuery.ajax({
            url:'/school/admin/helper/view-fees-statement.php',
            method:'POST',
            data:{student_db_id:id},            
            success:function(data){      
                jQuery("#financeStatementModal").find(".modal-body").html(data);
                jQuery("#financeStatementModal").modal({
                    backdrop: 'static', keyboard: false
                });
            },
            error:function(){
                alert("Something went wrong trying to search student");
            }
        }); 
    }
}
</script>

<style>
    #resultsDiv{
        width: 70%;
        height: 70vh;
        overflow: auto;
        border: none;
        padding: 10px 20px 5px 20px;
        margin: auto;
    }
    #search-finance-Div{
        padding: 10px;
        border-radius: 25px;
        border: 1px solid black;
        margin: auto;
        width: 70%;
        margin-top: 10px;
    }
    #search-finance-Div input[type="search"]{
        border: none;
        outline-style: none;
        margin-left: 5px;
        margin-right: 5px;       
    }
    #search-finance-Div input[type="search"]:focus{
        border-color: none;
        box-shadow: 0 1px 1px rgba(0, 0, 0, 0.075) inset, 0 0 8px rgba(126, 239, 104, 0.6);
        outline: none;
        font-weight: bold;
    }
    #search-finance-Div input[type="search"]:focus::placeholder{
        color: transparent;
    }
</style>