<?php

session_start();
    if(isset($_POST['login'])){
        require_once "../../classes/Admin.php";

    #instantiate an object of Seller class 
    $admin = new Admin();

        #retrieve form data
        $email = $_POST['email'];
        $password = $_POST['password'];

        $rsp = $admin->login($email, $password);

        if((int)$rsp > 0){// 
        $_SESSION['adminonline'] = $rsp; // contains the id of the admin
        header("location:../admindashboard.php");
        exit;
        }else{
            $_SESSION['errormsg'] = $rsp;
            header("location:../index.php");
            exit;
        }
    }else{
        $_SESSION['errormsg'] = "Kindly fill the form";
        header("location:../index.php");
        exit;
    }

?>