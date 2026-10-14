<?php
session_start();
require_once "../../classes/Admin.php";
if (!isset($_SESSION["adminonline"])) { header("Location: ../index.php"); exit(); }
if (!isset($_POST["edit_category"])) { header("Location: ../admincategories.php"); exit(); }

$admin = new Admin();
$id   = intval($_POST["category_id"] ?? 0);
$name = trim($_POST["category_name"] ?? "");
if ($id <= 0 || empty($name)) {
    $_SESSION["errormsg"] = "Invalid category data.";
    header("Location: ../admincategories.php"); exit();
}
$result = $admin->update_category($id, $name);
if ($result) {
    $_SESSION["feedback"] = "Category updated successfully!";
} else {
    $_SESSION["errormsg"] = "Failed to update category.";
}
header("Location: ../admincategories.php"); exit();
?>