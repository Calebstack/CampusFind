<?php

require_once "../classes/Student.php";

$student = new Student;
$email = $_GET['email'];
$chk = $student->check_email($email);
if($chk === false){
    echo "Database Error";
}
else{
    echo $chk;
}

?>