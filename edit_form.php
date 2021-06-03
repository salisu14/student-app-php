<?php
    require_once 'dbconnection.php';

    // Get all departments by name
    $query = 'SELECT * FROM department';
    $statement=$db->prepare($query);
    $statement->execute();
    $departments=$statement->fetchAll();
    $statement->closeCursor();

    $id = filter_input(INPUT_GET, 'id', FILTER_VALIDATE_INT);
    $dept = filter_input(INPUT_GET, 'dept', FILTER_VALIDATE_INT);
    if($id == NULL || $id == false || $dept == NULL || $dept == false) {
        echo 'Invalid student or department id';
        exit();
    }

    // Get student with the given id
    $query="SELECT
                `firstname`,
                `lastname`,
                `gender`,
                `dob`
            FROM `student`
            WHERE id = :id";
    $statement=$db->prepare($query);
    $statement->bindValue(':id', $id);
    $statement->execute();
    $student=$statement->fetch();
    $statement->closeCursor();

    $gender = $student['gender'];
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Edit Student</title>
</head>
<body>
    <h1>Edit Student</h1>
    <form name="frm_add" action="add_student.php" method="POST">
      <label for="firstname">First Name:</label>
      <input type="text" name="firstname" 
             value="<?php echo $student['firstname']; ?>"><br>

      <label for="surname">Last Name:</label>
      <input type="text" name="surname"
             value="<?php echo $student['lastname']; ?>"><br>

       <label for="gender">Gender</label>
       <input type="radio" name="gender" value="M" <?php if ($gender != "F") echo "checked"; ?>>Male
       <input type="radio" name="gender" 
              value="F" <?php if ($gender == "F") echo "checked"; ?>>Female<br>
    
       <label for="dob">Birth date:</label>
       <input type="date" name="dob"
              value="<?php echo $student['dob']; ?>"><br>

      <label for="dept">Department</label>
      <select name="dept">
        <?php foreach($departments as $dept): ?>
        <option value="<?php echo $dept['id']; ?>">
            <?php echo $dept['name']; ?>
        </option>
         <?php endforeach; ?>
      </select><br>

      <label for="submit">&nbsp;</label>
      <input type="submit" name="submit" value="Update">
    </form>
</body>
</html>