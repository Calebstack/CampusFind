<?php
session_start();
if (isset($_SESSION["useronline"])) {
    header("Location: studenthome.php");
} else {
    header("Location: ../authentication/loginstudent.php");
}
exit();
?>