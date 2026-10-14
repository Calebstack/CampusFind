<?php

session_start();
require_once "../students/userguard.php";
require_once "../classes/Student.php";
$rsp = new Student;

if(isset($_POST['report'])){
    
    $name = $_POST['name'];
    $category = $_POST['category'];
    $date_found = $_POST['date_found'];
    $location = $_POST['location'];
    $photo = $_FILES['photo'];
    $reported_to = $_POST['report_option'];

    if($reported_to == "security"){
        $reported_to = "Campus Security Desk";
    }else{
        $reported_to = $_POST['reported_to'];
    }
    
    if(empty($name) || empty($category) || empty($date_found) || empty($location)){
        $_SESSION['errormsg'] = "All the field must be complete";
        header("location:../students/reportfound.php");
        exit;
    }

    if(empty($photo['name'])){
        $_SESSION['errormsg'] = "Please submit a picture";
        header("location:../students/reportfound.php");
        exit;
    }

    $ext = pathinfo($photo['name'], PATHINFO_EXTENSION);
    $allowed = ['jpg', 'jpeg', 'png', ];
    if(!in_array(strtolower($ext), $allowed)){
        $_SESSION['errormsg'] ="Format not accepted";
        header("location:../students/reportfound.php");
        exit;
    }
    $size = $photo['size'];
    if($size > (5 * 1024 * 1024)){
        $_SESSION['errormsg'] ="The image must not be more than 5mb";
        header("location:../students/reportfound.php");
        exit;
    }

    $uploaded = $rsp->upload($photo['tmp_name'],$ext);
    if(!$uploaded){
        $_SESSION['errormsg'] = "Error uploading file";
        header("location:../students/reportfound.php");
        exit;
    }
    $files = $rsp->report_item($_SESSION['useronline'], $name, $date_found, $location, $category, $uploaded, $reported_to);
        if($files){
            $_SESSION['feedback'] = "Item reported successfully";
            header("location:../students/studenthome.php");
        }else{
            $_SESSION['errormsg'] = "Error reporting item";
            header("location:../students/reportfound.php");
        }
        exit;   
}else{
    $_SESSION['errormsg'] = "complete the form";
    header("location:../students/reportfound.php");
}

?>