<?php
if(isset($_POST['submit'])){
    $id = filter_input(INPUT_POST, 'id', FILTER_VALIDATE_INT);
    $dept = filter_input(INPUT_POST, 'dept', FILTER_VALIDATE_INT);

   if($id === false || $id === NULL || $dept === NULL || $dept === false) {
       echo 'Invalid stud_id or dept_id';
       exit();
   } else {
       require_once('dbconnection.php');

       $query = 'DELETE FROM student WHERE id =:id AND dept =:dept';
       $statement=$db->prepare($query);
       $statement->bindValue(':id', $id);
       $statement->bindValue(':dept', $dept);
       $statement->execute();
       $statement->closeCursor();
       header('Location: index.php');
   }
}