<?php
session_start();

require_once "../classes/Admin.php";
$logout = new Admin;

$logout->logout();

// Unset all session variables
$_SESSION = array();

// Destroy the session
session_destroy();

header("location:index.php");
exit;
?>