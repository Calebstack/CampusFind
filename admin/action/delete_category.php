<?php
session_start();
require_once "../../classes/Admin.php";
if (!isset($_SESSION["adminonline"])) { header("Location: ../index.php"); exit(); }

$admin = new Admin();
$id = intval($_GET["id"] ?? 0);
if ($id <= 0) {
    $_SESSION["errormsg"] = "Invalid category ID.";
    header("Location: ../admincategories.php"); exit();
}
$result = $admin->delete_category($id);
if ($result === true) {
    $_SESSION["feedback"] = "Category deleted successfully!";
} elseif ($result === "has_items") {
    $_SESSION["errormsg"] = "Cannot delete this category because it has items associated with it.";
} else {
    $_SESSION["errormsg"] = "Failed to delete category.";
}
header("Location: ../admincategories.php"); exit();
?>