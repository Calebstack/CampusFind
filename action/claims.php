<?php

session_start();
require_once "../classes/Student.php";
$rsp = new Student;

// Check if user is logged in
if(!isset($_SESSION['useronline'])){
    $_SESSION['errormsg'] = "You need to be logged in to claim an item.";
    header("location:../authentication/loginstudent.php");
    exit();
}

if(isset($_POST['claim']) && !empty($_POST['claim'])){
    $student_id = $_SESSION['useronline'];
    $founditems_id = intval($_POST['claim']);

    // Check if already claimed
    $check = $rsp->checkClaim($student_id, $founditems_id);

    if($check){
        $_SESSION['errormsg'] = "You have already claimed this item.";
        header("location:../students/itemdetails.php?id=".$founditems_id);
        exit();
    }

    // Insert claim
    $result = $rsp->insert_claim($student_id, $founditems_id);
    
    if($result){
        $_SESSION['feedback'] = "Claim submitted successfully!";
        header("location:../students/claims.php");
    } else {
        $_SESSION['errormsg'] = "Error submitting claim. Please try again.";
        header("location:../students/itemdetails.php?id=".$founditems_id);
    }
} else {
    $_SESSION['errormsg'] = "Invalid request.";
    header("location:../students/categories.php");
}

?>