<?php


if(!isset($_SESSION['adminonline'])){
    $_SESSION['errormsg'] = "You need to be logged in as an admin to access this page";
    header("location:index.php");
    exit;
}
?>