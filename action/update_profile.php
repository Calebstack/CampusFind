<?php
session_start();
require_once "../students/userguard.php";
require_once "../classes/Student.php";

if (!isset($_SESSION["useronline"])) {
    header("Location: ../authentication/loginstudent.php");
    exit();
}

if (!isset($_POST["update_profile"])) {
    header("Location: ../students/studentprofile.php");
    exit();
}

$student = new Student();
$student_id = $_SESSION["useronline"];

$fname  = trim($_POST["fname"] ?? "");
$lname  = trim($_POST["lname"] ?? "");
$dept   = intval($_POST["department"] ?? 0);
$phone  = trim($_POST["phone"] ?? "");

if (empty($fname) || empty($lname) || $dept <= 0) {
    $_SESSION["errormsg"] = "First name, last name and department are required.";
    header("Location: ../students/studentprofile.php");
    exit();
}

$img = null;
if (!empty($_FILES["profile_pic"]["name"])) {
    $photo = $_FILES["profile_pic"];
    $ext   = strtolower(pathinfo($photo["name"], PATHINFO_EXTENSION));
    $allowed = ["jpg", "jpeg", "png", "webp"];
    if (!in_array($ext, $allowed)) {
        $_SESSION["errormsg"] = "Only JPG, PNG, or WEBP images are allowed.";
        header("Location: ../students/studentprofile.php");
        exit();
    }
    if ($photo["size"] > 5 * 1024 * 1024) {
        $_SESSION["errormsg"] = "Profile photo must not exceed 5MB.";
        header("Location: ../students/studentprofile.php");
        exit();
    }
    $img = $student->upload_profile_pic($photo["tmp_name"], $ext);
    if (!$img) {
        $_SESSION["errormsg"] = "Error uploading profile photo. Please try again.";
        header("Location: ../students/studentprofile.php");
        exit();
    }
}

$result = $student->update_profile($student_id, $fname, $lname, $dept, $phone, $img);
if ($result === true) {
    $_SESSION["feedback"] = "Profile updated successfully!";
} else {
    $_SESSION["errormsg"] = "Failed to update profile. Please try again.";
}
header("Location: ../students/studentprofile.php");
exit();
?>