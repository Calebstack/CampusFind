<?php
session_start();
require_once "../classes/Student.php";
require_once "../students/userguard.php";

if(!isset($_SESSION['useronline'])){
    $_SESSION['errormsg'] = "Please sign in to confirm item receipt.";
    header("location:../authentication/loginstudent.php");
    exit;
}

if($_SERVER['REQUEST_METHOD'] !== 'POST'){
    $_SESSION['errormsg'] = "Invalid request.";
    header("location:../students/claims.php");
    exit;
}

$claimId = filter_input(INPUT_POST, 'claim_id', FILTER_VALIDATE_INT);
$student = new Student;
if($claimId && $student->confirm_claim_received($_SESSION['useronline'], $claimId)){
    $_SESSION['feedback'] = "Item receipt confirmed. Thank you for closing the claim.";
}else{
    $_SESSION['errormsg'] = "Receipt could not be confirmed. The claim may no longer be awaiting confirmation.";
}
header("location:../students/claims.php");
exit;
