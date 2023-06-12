
        
        <!--================================================================================
            ADD  STUDENT BUTTON-
        ==================================================================================== -->
       
      <a href="formerstudents.php?addstudent=1"class="btn btn-primary" style="color:white;position:fixed;right:1%;bottom:5%; padding:10px;border-radius:50%" title="Click to add former student"> <i class="fas fa-plus"></i> </a> 
    
      <div style="display:block;" id="searchDiv">  
               <label class="float-left">
                <a href="/school/admin/students.php">Back</a>
               </label>             
               <input type="search" name="search_student" id="search_student" placeholder="Search student name">    
       </div>
       <?php
       
       /************************************************************************************************************
        * DELETING FORMER STUDENT
        ***********************************************************************************************************/
       if(isset($_GET['deleteStudent'])){
           $deleteId    =    (int)clean($_GET['deleteStudent']);
           $db->query("DELETE FROM former_students WHERE id='$deleteId'");
           $messages[].='<b>Success! </b>Student has been deleted.';
           displayMessages($messages);
       }
       $studentQuery = $db->query("SELECT * FROM former_students");
       $count=1;
       ?>

       <table class="table-striped table-bordered table-hover table table-sm">
           <thead class="thead-light">
               <th></th>
               <th>STUDENT NAME</th>
               <th>GENDER</th>
               <th>PHONE</th>
               <th>YEAR ACCOMPLISHED</th>
               <th>ADD MARKS</th>
               <th>PERFORMANCE</th>
               <th>ACTIONS</th>
           </thead>
           <tbody id="tbody">
               <?php while( $student = mysqli_fetch_array($studentQuery)) :?>
                    <tr>
                        <td><?=$count;?></td>   
                        <td><?=$student['name'];?></td>
                        <td><?=$student['gender'];?></td>
                        <td><?=$student['phone'];?></td>
                        <td><?=$student['year_accomplished'];?></td>
                        <td><a href="/school/admin/formerstudents.php?addmarks=<?=$student['id']?>"> <i class="fas fa-plus"></i> Add</a></td>
                        <td><a href="/school/admin/formerstudents.php?viewmarks=<?=$student['id']?>"> <i class="far fa-eye"></i> View</a></td>
                        <td>
                            <a href="/school/admin/formerstudents.php?edit=<?=$student['id']?>"> <i class="fas fa-pencil-alt"></i> edit </a>
                            <a href="#" class="text-danger deleteStudent" id="<?=$student['id']?>"> <i class="fas fa-trash-alt"></i> delete </a>
                        </td>
                    </tr>
               <?php $count++; endwhile;?>
           </tbody>
       </table>

       <script>     

        function closeDeleteFormerStudentModal(){
            jQuery('#deletestudentmodal').modal("hide");
            location.reload(true);
        }

        jQuery('.deleteStudent').click(function(event){
            event.preventDefault();
            var deleteId    =   jQuery(this).attr("id");

            jQuery.ajax({
                url:'/school/modals/deleteformerstudent.php',
                method:'POST',
                data:{deleteId:deleteId},
                //dataType:'json',
                success:function(data){//code for the UTOCOMPLETE                
                    jQuery("body,html").append(data);
                    jQuery('#deletestudentmodal').modal({
                        keyboard:false,
                        backdrop:'static'
                    });
                },
                error:function(){
                    alert("Something went wrong trying to delete student");
                }
            });

        });

       jQuery('#search_student').keyup(function(){
           var searchFormerStudent  =   jQuery(this).val(); 
          jQuery.ajax({
                url:'/school/admin/students/fetch.php',
                method:'POST',
                data:{searchFormerStudent:searchFormerStudent},
                success:function(data){//code for the UTOCOMPLETE                
                    jQuery("#tbody").html(data);
                },
                error:function(){
                    alert("Something went wrong trying to search student");
                }
            });             
       });
       </script>