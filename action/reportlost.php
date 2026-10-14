<?php
session_start();
require_once "../classes/Student.php";
require_once "../students/userguard.php";

if(!isset($_SESSION['useronline'])){
    $_SESSION['errormsg'] = "You need to be logged in to report a lost item.";
    header("location:../authentication/loginstudent.php");
    exit;
}

if($_SERVER['REQUEST_METHOD'] !== 'POST' || !isset($_POST['report_lost'])){
    $_SESSION['errormsg'] = "Invalid request.";
    header("location:../students/reportlost.php");
    exit;
}

$name = trim($_POST['name'] ?? '');
$category = filter_input(INPUT_POST, 'category', FILTER_VALIDATE_INT);
$date = trim($_POST['date_lost'] ?? '');
$location = trim($_POST['location'] ?? '');
$description = trim($_POST['description'] ?? '');
$contact = trim($_POST['contact'] ?? '');
$validDate = DateTime::createFromFormat('Y-m-d', $date);
$dateIsValid = $validDate && $validDate->format('Y-m-d') === $date && $date <= date('Y-m-d');

if($name === '' || strlen($name) > 150 || !$category || !$dateIsValid ||
   $location === '' || strlen($location) > 255 || $description === '' ||
   strlen($description) > 2000 || strlen($contact) > 255){
    $_SESSION['errormsg'] = "Complete all required fields with valid values.";
    header("location:../students/reportlost.php");
    exit;
}

$student = new Student;
$result = $student->report_lost_item(
    $_SESSION['useronline'],
    $name,
    $date,
    $location,
    $category,
    $description,
    $contact === '' ? null : $contact
);

if($result){
    $_SESSION['feedback'] = "Your lost item notice has been posted.";
    header("location:../students/wanted.php");
}else{
    $_SESSION['errormsg'] = "The notice could not be saved. Please try again.";
    header("location:../students/reportlost.php");
}
exit;
