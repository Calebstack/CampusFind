<?php
session_start();
require_once "../../classes/Admin.php";
require_once "../../classes/Student.php";
require_once "../../classes/Mailer.php";

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
        $student = new Student;
        $details = $student->get_claim_notification_details($claim_id);
        $notified = $details && (new Mailer())->sendText(
            $details['claimant_email'],
            "Your CampusFind claim was not approved",
            "Hello " . $details['claimant_fname'] . ",\n\n"
                . "Your claim for \"" . $details['founditems_name'] . "\" was not approved.\n"
                . "If you believe this decision was made in error, please contact a CampusFind administrator.\n"
        );
        $_SESSION['feedback'] = $notified
            ? "Claim rejected. The claimant has been notified."
            : "Claim rejected, but the claimant could not be notified by email.";
    } else {
        $_SESSION['errormsg'] = "Error rejecting claim. Please try again.";
    }
} else {
    $_SESSION['errormsg'] = "Invalid claim ID.";
}

header("location:../adminclaims.php");
exit();
?>
