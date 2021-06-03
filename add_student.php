<?php
require_once 'dbconnection.php';

if(isset($_POST['submit'])) {
    $firstname = filter_input(INPUT_POST, 'firstname');
    $lastname = filter_input(INPUT_POST, 'surname');
    $gender = filter_input(INPUT_POST, 'gender');
    $birthdate = filter_input(INPUT_POST, 'dob');

    $dept = filter_input(INPUT_POST, 'dept', FILTER_VALIDATE_INT);
    if($dept === null || $dept === false) {
        $dept = 1;
    }

    $insertQuery = 'INSERT INTO student(id, firstname, lastname, gender, dob, dept)
                VALUES(null, :firstname, :lastname,:gender, :dob, :dept)';

    $statement=$db->prepare($insertQuery);
    $statement->bindValue(':firstname', $firstname);
    $statement->bindValue(':lastname', $lastname);
    $statement->bindValue(':gender',$gender);
    $statement->bindValue(':dob',$birthdate);
    $statement->bindValue(':dept',$dept);
    $statement->execute();
    $statement->closeCursor();

    header("Location: index.php");
 }