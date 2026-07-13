<?php
session_start();
require_once "../../classes/Admin.php";

if(!isset($_SESSION['adminonline'])){
    $_SESSION['errormsg'] = "You need to be logged in as an admin to perform this action.";
    header("location:../loginadmin.php");
    exit();
}

$admin = new Admin;

if(isset($_GET['id']) && !empty($_GET['id'])){
    $claim_id = intval($_GET['id']);
    $admin_id = $_SESSION['adminonline'];
    
    $result = $admin->reject_claim($claim_id, $admin_id);
    
    if($result){
        $_SESSION['feedback'] = "Claim rejected successfully.";
    } else {
        $_SESSION['errormsg'] = "Error rejecting claim. Please try again.";
    }
} else {
    $_SESSION['errormsg'] = "Invalid claim ID.";
}

header("location:../adminclaims.php");
exit();
?>
