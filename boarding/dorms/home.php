
<div id="homeTableContainer">
                <?php
                 //**************code for removing student from dorm*****************///////////////////
                        if(isset($_GET['removeStudent']) && $_GET['removeStudent'] >0){
                            $studentId = (int)clean($_GET['removeStudent']);
                            $db->query("UPDATE students SET dorm='' WHERE id='$studentId'");
                            ?><script>window.location='/school/boarding/dorms.php?dormId=<?=$dormId?>'</script>;<?php
                        }
                /////////******************code for removing student ends here***************/////////////////// */
                ?>



                <h5 style="padding: 10px;background:#f8f8f8;" class="text-center">
                <label class="float-left"> <a href="/school/boarding/index.php">Back</a> </label>
                <label >STUDENTS IN THE DORM.</label>
                </h6>
                <table class="table table-sm table-striped table-bordered table-hover">
                    <thead class="thead-light">
                        <th>#</th>
                        <th>REG. NUMBER</th>
                        <th>STUDENT NAME</th>
                        <th>LEVEl</th>
                        <th></th>
                    </thead>
                    <tbody>
                        <?php
                        $count = 1;                       
                        $studentQuery = $db->query("SELECT * FROM students WHERE dorm='$dormId'");
                        while($student = mysqli_fetch_array($studentQuery)) :?>
                        <tr>
                            <td><?=$count;?></td>
                            <td><?=$student['registration_number'];?></td>
                            <td><?=$student['stdname'];?></td>
                            <td><?=$student['stdgrade'];?></td>
                            <td> <a href="dorms.php?dormId=<?=$dormId?>&removeStudent=<?=$student['id']?>" class="text-danger" title="Remove this student from this dorm"><i class="fas fa-user-minus"></i> remove.</a> </td>
                        </tr>
                        <?php $count++; endwhile;?>
                    </tbody>
                </table>
</div>