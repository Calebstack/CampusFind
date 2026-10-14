<?php

session_start();
require_once "../classes/Student.php";
require_once "../classes/Mailer.php";
require_once "../students/userguard.php";
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

    if(!$rsp->can_claim_item($student_id, $founditems_id)){
        $_SESSION['errormsg'] = "This item is unavailable or cannot be claimed by its reporter.";
        header("location:../students/itemdetails.php?id=".$founditems_id);
        exit();
    }

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
        $details = $rsp->get_claim_notification_details($result);
        $notified = $details && (new Mailer())->sendText(
            $details['reporter_email'],
            "A student has claimed your found item",
            "Hello " . $details['reporter_fname'] . ",\n\n"
                . "A student has submitted a claim for the found item \"" . $details['founditems_name'] . "\".\n"
                . "Please sign in to CampusFind to review the claim.\n"
        );
        $_SESSION['feedback'] = $notified
            ? "Claim submitted successfully. The student who reported the item has been notified."
            : "Claim submitted successfully, but the finder could not be notified by email.";
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