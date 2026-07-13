<?php
session_start();

require_once "../classes/Student.php";
$logout = new Student;

$logout->logout();

// Unset all session variables
$_SESSION = array();

// Destroy the session
session_destroy();

header("location:../authentication/index.php");
exit;
?>