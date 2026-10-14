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
    $student = new Student;
    $pendingClaimIds = $student->get_pending_claim_ids_for_claim($claim_id);
    if($pendingClaimIds === false){
        $_SESSION['errormsg'] = "Unable to load the claim notification recipients.";
        header("location:../adminclaims.php");
        exit;
    }
    $result = $admin->approve_claim($claim_id, $admin_id);
    
    if($result){
        $details = $student->get_claim_notification_details($claim_id);
        $mailer = new Mailer;
        $notified = $details && $mailer->sendText(
            $details['claimant_email'],
            "Your CampusFind claim has been approved",
            "Hello " . $details['claimant_fname'] . ",\n\n"
                . "Your claim for \"" . $details['founditems_name'] . "\" has been approved.\n"
                . "Collection instructions: " . ($details['reported_to'] ?: 'Contact the item reporter through CampusFind.') . "\n"
                . "After collecting the item, sign in to CampusFind and confirm receipt in My Claims.\n"
        );

        foreach($pendingClaimIds ?: [] as $otherClaimId){
            if((int)$otherClaimId === $claim_id){
                continue;
            }
            $otherDetails = $student->get_claim_notification_details($otherClaimId);
            $otherNotified = $otherDetails && $mailer->sendText(
                $otherDetails['claimant_email'],
                "Your CampusFind claim was not approved",
                "Hello " . $otherDetails['claimant_fname'] . ",\n\n"
                    . "Your claim for \"" . $otherDetails['founditems_name'] . "\" was not approved because another claim for this item was approved.\n"
                    . "If you believe this decision was made in error, please contact a CampusFind administrator.\n"
            );
            $notified = $notified && $otherNotified;
        }
        $_SESSION['feedback'] = $notified
            ? "Claim approved. The claimant has been emailed the collection instructions."
            : "Claim approved, but the claimant could not be notified by email.";
    } else {
        $_SESSION['errormsg'] = "Error approving claim. Please try again.";
    }
} else {
    $_SESSION['errormsg'] = "Invalid claim ID.";
}

header("location:../adminclaims.php");
exit();
?>
