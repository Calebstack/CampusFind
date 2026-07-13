<?php

session_start();
    if(isset($_POST['loginstd'])){
        require_once "../classes/Student.php";

    #instantiate an object of Seller class 
    $stud = new Student();

        #retrieve form data
        $email = $_POST['email'];
        $password = $_POST['password'];

        $rsp = $stud->login($email, $password);

        if((int)$rsp > 0){// 
        $_SESSION['useronline'] = $rsp; // contains the id of the user
        header("location:../students/studenthome.php");
        exit;
        }else{
            $_SESSION['errormsg'] = $rsp;
            header("location:../authentication/loginstudent.php");
            exit;
        }
    }else{
        header("location:../authentication/loginstudent.php");
        $_SESSION['errormsg'] = "Kindly fill the form";
    }


?>