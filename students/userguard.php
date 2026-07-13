<?php

if(!isset($_SESSION['useronline'])){
    $_SESSION['errormsg'] = "You need to be logged in to access this page";
    header("location:../authentication/loginstudent.php");
    exit;
}

?>