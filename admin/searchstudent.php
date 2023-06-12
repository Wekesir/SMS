<?php
require_once $_SERVER['DOCUMENT_ROOT'].'/school/core/init.php';
    if(isset($_POST['query'])){
         $fetchData='';
         $data=array();
        $stdname=clean(trim(((isset($_POST['query'])? $_POST['query'] : ''))));
        $query=$db->query("SELECT * FROM students WHERE stdname LIKE '%'$stdname'%'");
        while( $student_data=mysqli_fetch_array($query)) :

            $data[]=$student_data['registration_number'];
            $data[]=$student_data['istdnamed'];
            $data[]=$student_data['stdgrade'];
           
         $fetchData='
            
                <tr>
                    <td><a href="students.php?edit=<?='.$student_data['id'].';?>" class="btn btn-xs btn-success"><i class="fas fa-pencil-alt fa-1x"></i></a>
                    </td>                   
                    <td><?='.$student_data['registration_number'].';?></td>
                    <td><?='.$student_data['stdname'].';?></td>
                    <td><?='.$student_data['stdgrade'].';?></td>
                    <td> <a href="students.php?delete=<?='.$student_data['id'].';?>" class="btn btn-xs btn-danger"><i class="fas fa-trash-alt"></i></a></td>
                </tr>

                     ';
         endwhile;
         if(isset($_POST['typehead_search'])){
             echo $fetchData;
         }else{
             $data=array_unique($data);
             echo json_encode($data);
         }
       
    }
?>