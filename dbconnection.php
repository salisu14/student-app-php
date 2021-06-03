<?php
$dsn = 'mysql:host=localhost;dbname=mydb;port=3307';
$user = 'root';
$password = '';

try {
    $db = new PDO($dsn, $user, $password);
   # echo "Connection successful";
} catch(PDOException $e) {
   $error_msg = $e->getMessage();
}
