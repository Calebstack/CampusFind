<?php

session_start();
require_once "../classes/Student.php";
$student = new Student;

if(isset($_POST['signupstd'])){
    $firstname = $_POST['firstname'];
    $lastname=  $_POST['lastname'];
    $department = $_POST['department'];
    $email = $_POST['email'];
    $pass1 = $_POST['pass1'];
    $pass2 = $_POST['pass2'];

    if(empty($firstname) || empty($lastname) || empty($email) || empty($department)){
        $_SESSION['errormsg'] = "All fields are required";
        header("location:../authentication/signupstudent.php");
        exit;
            
    }elseif($pass1 != $pass2){
        $_SESSION['errormsg'] = "The 2 passwords must match";
        header("location:../authentication/signupstudent.php");
        exit;
    }

    $rsp = $student->signup($firstname, $lastname, $email, $pass1, $department);
    if($rsp){
        $_SESSION['feedback'] = "Account creation successful";
        header("location:../authentication/loginstudent.php");
        exit;
    }else{
        $_SESSION['errormsg'] = "Please try again, account creation failed";
        header("location:../authentication/loginstudent.php");
    }

}else{
        $_SESSION['errormsg'] = "Please complete the form";
        header("location:../authentication/signupstudent.php");
        exit;

    }

// echo "<pre>";
//     print_r($_POST);
// echo  "<pre>";

?>