<?php
require_once $_SERVER['DOCUMENT_ROOT'].'/school/core/init.php';
include '../admin/header.php';
include '../admin/navigation.php';
include '../admin/deletebookmodal.php';

$errors=array();
$messages=array();
$gradeQuery=$db->query("SELECT * FROM grade");//select the grade from the database
$gradeData=mysqli_fetch_array($gradeQuery);
$gradeId=$gradeData['id'];
?>
<div class="container-fluid">

<div class="row">

<div class="col-md-3">
<?php include '../admin/left.php';?>
</div><!--clossing col-sm 3 div-->

<div class="col-sm-9" id="wrapper">

<h5 class="text-center"><b>BOOKS</b></h5>

    <div class="row">
        <div class="col-md-7">
            <table class="table-bordered table-striped table-highlight full-length">
                <thead>
                    <th>#</th>
                    <th>Grade</th>
                    <th>View</th>
                </thead>
                <tbody>
                    <?php 
                    $count=1;
                    while($gradeData=mysqli_fetch_array($gradeQuery)) :?>
                    <tr>
                        <td class="text-center"><?=$count;?></td>
                         <td><?=$gradeData['grade'];?></td>
                         <td>
                             <button class="btn-xs btn-primary view exsmall_font" id="<?=$gradeData['id'];?>">View</button>
                         </td>
                    </tr>
                    <?php
                    $count++;
                    endwhile;?>
                </tbody>
            </table>
        </div><!--closing col-md-7 div-->

        <div class="col-md-5">

            <ul class="nav nav-tabs" id="myTab" role="tablist">
                <li class="nav-item">
                    <a class="nav-link active" id="home-tab" data-toggle="tab" href="#home" role="tab" aria-controls="home" aria-selected="true">All Available Books</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link" id="profile-tab" data-toggle="tab" href="#profile" role="tab" aria-controls="profile" aria-selected="false">Add New Book</a>
                </li>               
        </ul>

        <div class="tab-content" id="myTabContent">

                <div class="tab-pane fade show active" id="home" role="tabpanel" aria-labelledby="home-tab">

                    <div class="container-fluid display_books text-center">
                        <!--GETS DATA IN THE FORM OF AN AJAX REQUEST FROM THE EST.PHP FILE-->

                                <?php
                                    if(!isset($_GET['editbook'])){//if the editbook id is not provided thd div should appear else not
                                        ?>

                                                <div class="alert alert-danger text-left" role="alert"><!--appears when user has not clicked on a grdae ro view books-->
                                                    <strong>Oops!</strong> Click on view button to view books.
                                                </div>

                                        <?php
                                    }//end if condition

                                    if(isset($_GET['editbook'])){//if the edit book is clicked

                                        $editid=(int)clean(((isset($_GET['editbook'])?$_GET['editbook'] : '')));
                                        $editbookQuery=$db->query("SELECT * FROM books WHERE id='$editid'");
                                        $editbookdata=mysqli_fetch_array($editbookQuery);
                                        $bookname=((isset($_POST['bookname'])? $_POST['bookname'] : $editbookdata['book_name']));                                        

                                        ?>

                                            <form action="books.php?editbook=<?=$_GET['editbook'];?>" method="post">
                                
                                                    <h6 class="text-center">Edit Book Name</h6>                                                  
                                                     <hr>     
                                                        <?php
                                                          //when the edit button is clicked
                                                            if(isset($_POST['editbookbtn'])){

                                                                //check if the submitted name is the same as the previous name
                                                                if($_POST['bookname'] == $editbookdata['book_name']){
                                                                    $errors[].='No changes made.';
                                                                }

                                                                //check if the book name is null
                                                                if(empty($_POST['bookname'])){
                                                                    $errors[].='Name can not be blank';
                                                                }

                                                                //check if there are errors
                                                                    if(!empty($errors)){
                                                                        displayErrors($errors);
                                                                    }else{//update database
                                                                        $db->query("UPDATE books SET book_name='$bookname' WHERE id='$editid");
                                                                        $messages[].='Book updated sucessfully';

                                                                            if(!empty($messages)){
                                                                                displayMessages($messages);
                                                                            }
                                                                    }

                                                               } 
                                                        ?>                                                         

                                                <div class="form-group">
                                                    <input type="text" class="form-control" name="bookname" value="<?=$bookname;?>">
                                                </div>
                                                <div class="form-group">
                                                    <input type="submit" name="editbookbtn" class="form-control">
                                                </div>

                                            </form>

                                        <?php
                                    }
                                    
                                ?>                       
                       
                    </div><!--closing display_books div-->

                </div>

                <div class="tab-pane fade" id="profile" role="tabpanel" aria-labelledby="profile-tab">
                    <div class="container">
                                        
                        <hr><p class="text-center"style="background-color:black;color:white;"> ADD A NEW BOOK </p><hr>

                        <?php 
                        if(isset($_POST['add_book'])){//when th e add book button is clicked the following should happen

                            $bookname=clean(((isset($_POST['book'])? $_POST['book'] : '')));
                            $getgradeid=clean(((isset($_POST['grade'])? $_POST['grade'] : '')));

                              //check if the book already exists
                            $checkbooksQuery=$db->query("SELECT * FROM books WHERE grade_id='$getgradeid'");
                            $checkbookdata=mysqli_fetch_array($checkbooksQuery);
                            $checkbook=$checkbookdata['book_name'];
                                if(strtolower($checkbook) == strtolower($bookname)){
                                    $errors[].='Book already exists';
                                }

                                //check if all the fi3elds have been filled
                            if(empty($_POST['book']) || empty($_POST['grade'])){
                                $errors[].='Provide all info';
                            }         

                            //display any available err0rs
                            if(!empty($errors)){
                                displayErrors($errors);
                            }else{
                                $db->query("INSERT INTO books (book_name, grade_id) VALUES ('$bookname','$getgradeid')");
                               $messages[].='Book inserted successfully!';
                                if(!empty($messages)){
                                    displayMessages($messages);//DISPLAYS THE SUCCESS MESSAGE IN THE SCRIPT
                                }
                            }

                        }//closing isset function
                        ?>

                        <form action="books.php" method="POST">

                            <div class="form-group">
                              <label for="grade">Select a grade:</label>
                              <select name="grade" id="grade" class="form-control">
                                    <option value=""> <i>select a grade</i> </option>
                                    <?php 
                                    $gradeQuery=$db->query("SELECT * FROM grade");
                                    while($gradeData=mysqli_fetch_array($gradeQuery)) : ?>
                                    <option value="<?=$gradeData['id'];?>"><?=$gradeData['grade'];?></option>
                                      <?php endwhile; ?>
                              </select>
                            </div>
                            <div class="form-group">
                                <label for="book">Type a book name:</label>
                                <input type="text" name="book" class="form-control">
                            </div>
                            <div class="form-group">
                                <input type="submit" name="add_book" id="add_book" class="form-control theme_color">
                            </div>

                        </form>
                    </div><!--closing container div-->
                </div>       
        </div>

        </div><!--Closing col-md 5 div-->
    </div><!--closing row div-->

    </div><!--closing col-sm-9 div-->
    </div><!--closing main row div-->

<?php //include '../admin/footer.php'; ?>
</div><!--closing container-fluid div-->


<script>
    jQuery('.view').click(function(){
        var grade_id=jQuery(this).attr("id");
          jQuery('.display_books').val();

            jQuery.ajax({
                url:"/school/admin/fetch.php",
                method:'post',
                data:{grade_id:grade_id},
                success:function(data){                   
                    jQuery('.display_books').html(data);
                },
                error:function(){
                    alert("Something went wrong.");
                },
            });
    });

    jQuery('.displaydeletemodalbtn').click(function(){
        alert("Button clickeed");
    });
</script>
























































































































































































































































