<?php
session_start();
require_once "../../classes/Admin.php";

if(!isset($_SESSION['adminonline'])){
    $_SESSION['errormsg'] = "You need to be logged in as an admin to perform this action.";
    header("location:../index.php");
    exit;
}

if($_SERVER['REQUEST_METHOD'] !== 'POST'){
    $_SESSION['errormsg'] = "Invalid request.";
    header("location:../adminstudents.php");
    exit;
}

$studentId = filter_input(INPUT_POST, 'student_id', FILTER_VALIDATE_INT);
$isBanned = filter_input(INPUT_POST, 'is_banned', FILTER_VALIDATE_INT);
if(!$studentId || !in_array($isBanned, [0, 1], true)){
    $_SESSION['errormsg'] = "Invalid student account update.";
    header("location:../adminstudents.php");
    exit;
}

$admin = new Admin;
if($admin->set_student_banned($studentId, $isBanned)){
    $_SESSION['feedback'] = $isBanned ? "Student account banned." : "Student account unbanned.";
}else{
    $_SESSION['errormsg'] = "The student account could not be updated.";
}
header("location:../adminstudents.php");
exit;
