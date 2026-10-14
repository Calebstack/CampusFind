<?php

require_once __DIR__ . "/../classes/Student.php";

if(!isset($_SESSION['useronline'])){
    $_SESSION['errormsg'] = "You need to be logged in to access this page";
    header("location:../authentication/loginstudent.php");
    exit;
}

if(!(new Student())->is_student_allowed($_SESSION['useronline'])){
    unset($_SESSION['useronline']);
    $_SESSION['errormsg'] = "This account is suspended or could not be verified. Please contact an administrator.";
    header("location:../authentication/loginstudent.php");
    exit;
}

?>