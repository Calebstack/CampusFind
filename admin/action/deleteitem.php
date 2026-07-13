<?php
session_start();
require_once "../../classes/Admin.php";

$admin = new Admin;

if(isset($_GET['id']) && !empty($_GET['id'])){
    $id = intval($_GET['id']);
    $result = $admin->delete_item($id);
    
    if($result){
        $_SESSION['feedback'] = "Item deleted successfully!";
    } else {
        $_SESSION['errormsg'] = "Error deleting item. Please try again.";
    }
} else {
    $_SESSION['errormsg'] = "Invalid item ID.";
}

header("location:../adminfounditems.php");
exit();
?>