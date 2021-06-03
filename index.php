<?php
include('dbconnection.php');

$query="SELECT
         `s`. `id`,
         `s`.`firstname`,
         `s`.`lastname`,
         `s`.`gender`,
         `s`.`dob`,
         `s`.`dept`,
         `d`.`name`
      FROM
        (
          `mydb`.`student` `s`
          JOIN `mydb`.`department` `d`
       )
     WHERE (`s`.`dept` = `d`.`id`)
     ORDER BY `s`.`dob`";
$statement=$db->prepare($query);
$statement->execute();
$students = $statement->fetchAll();
$statement->closeCursor();
?>
<!DOCTYPE html>
<html>
<head>
<title>Student App</title>
</head>
<body>
  <!-- <p><?php var_dump($students); ?></p> -->
  <h1>Students Records</h1>
  <table border="1" cellspacing="0" cellpadding="2">
    <tr>
      <th>First Name</th>
      <th>Last Name</th>
      <th>Gender</th>
      <th>Birth Date</th>
      <th>Department</th>
      <th colspan="2">Actions</th>
    </tr>
    <?php foreach($students as $student): ?>
    <tr>
       <td><?php echo $student['firstname']; ?></td>
       <td><?php echo $student['lastname']; ?></td>
       <td><?php echo $student['gender']; ?></td>
       <td><?php echo $student['dob']; ?></td>
       <td><?php echo $student['name']; ?></td>
       <td>
          <form method="POST" action="delete_student.php">
             <input type="hidden" name="action" value="delete">
             <input type="hidden" name="id" value="<?php echo $student['id']; ?>">
             <input type="hidden" name="dept" value="<?php echo $student['dept']; ?>">
             <input type="submit" value="Delete" name="submit">
          </form>
       </td>
       <td><a href="edit_form.php?id=<?php echo $student['id']; ?>">Edit</a></td>
    </tr>
    <?php endforeach; ?>
  </table>
  <p><a href="form.php">Add new student</a></p>
</body>
</html>
