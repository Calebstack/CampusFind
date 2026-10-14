<?php
session_start();
require_once "../../classes/Admin.php";
if (!isset($_SESSION["adminonline"])) { header("Location: ../index.php"); exit(); }
if (!isset($_POST["add_category"])) { header("Location: ../admincategories.php"); exit(); }

$admin = new Admin();
$name = trim($_POST["category_name"] ?? "");
if (empty($name)) {
    $_SESSION["errormsg"] = "Category name cannot be empty.";
    header("Location: ../admincategories.php"); exit();
}
$result = $admin->add_category($name);
if ($result) {
    $_SESSION["feedback"] = "Category \"" . htmlspecialchars($name) . "\" added successfully!";
} else {
    $_SESSION["errormsg"] = "Failed to add category. It may already exist.";
}
header("Location: ../admincategories.php"); exit();
?>