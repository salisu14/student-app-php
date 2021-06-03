<?php
declare(strict_types=1);
require_once('dbconnection.php');

// get the department id
$dept_id = filter_input(INPUT_GET, 'dept_id', FILTER_VALIDATE_INT);

if($dept_id == NULL || $dept_id == FALSE) {
  $dept_id = 1;
}

// Get all departments
$dept_query = "SELECT * FROM department";
$st=$db->prepare($dept_query);
$st->execute();
$departments=$st->fetchAll();
$st->closeCursor();

// Get department name
$d_query = "SELECT *
            FROM department 
            WHERE id = :dept_id";
$st=$db->prepare($d_query);
$st->bindValue(':dept_id', $dept_id);
$st->execute();
$department=$st->fetch();
$dept_by_name=$department['name'];
$st->closeCursor();

// Get all students
$query="SELECT
         `firstname`,
         `lastname`,
         `gender`,
         `dob`
        FROM `student`
        WHERE dept = :dept_id";
$statement=$db->prepare($query);
$statement->bindValue(':dept_id', $dept_id);
$statement->execute();
$students=$statement->fetchAll();
$statement->closeCursor();
?>
<!DOCTYPE html>
<html>
<head>
<title>Student App</title>
<style>
   .flex-container {
      display: flex;
      /* height: 600px;
      align-items: flex-start; */
      flex-direction: row;
      justify-content: flex-start;
      flex-basis: 80px;
   }
   table { border: 3px solid navy; border-collapse: collapse; }
   tr, th, td { 
     border: 1px solid fuchsia;
     padding: .2em .5em .2em .5em;
     vertical-align: top;
     text-align: left;
   }
   th, td { padding: 5px;}
   ul { 
       margin-left: 0; 
       padding-left: 0; 
       list-style-type: none;
   }
   ul li { padding-bottom: .15em;}
   ul li a { 
      text-decoration: none; 
      display: inline-block; 
      padding: 2px; 
      margin-bottom: 2px;
      border: 0;
   }
</style>
</head>
<body>
  <div class="flex-container">
   <div class="">
      <h3>Departments</h3>
      <ul>
        <?php foreach($departments as $department): ?>
        <li>
           <a href="?dept_id=<?php echo $department['id']; ?>">
                <?php echo $department['name']; ?>
           </a>
        </li>
        <?php endforeach; ?>
      </ul>
   </div>
  <div id="">
  <h3><?php echo $dept_by_name; ?></h3>
  <table>
    <tr>
      <th>First Name</th>
      <th>Last Name</th>
      <th>Gender</th>
      <th>Date of birth</th>
    </tr>
    <?php if (count($students) !== 0): ?>
    <?php foreach($students as $student): ?>
    <tr>
       <td><?php echo $student['firstname']; ?></td>
       <td><?php echo $student['lastname']; ?></td>
       <td><?php echo $student['gender']; ?></td>
       <td><?php echo $student['dob']; ?></td>
    </tr>
    <?php endforeach; ?>
    <?php else : ?>
    <tr><td colspan="4"><h1>No students found!</h1></td></tr>
    <?php endif; ?>
  </table>
  <p><?php echo count($students) . ' student(s) found'; ?></p>
  <p><a href="form.php">Add new student</a></p>
  </div>
</div>
</body>
</html>