<?php
session_start();    
include("config.php");

if(isset($_POST["registerButton"])){

    $email = $_POST['email'];
    $password = $_POST['password'];
    $repassword = $_POST['repassword'];
    $fname = $_POST['fname'];
    $mname = isset($_POST['mname']) ? $_POST['mname'] : '' ;
    $lname = $_POST['lname'];

    $check_email_query = "SELECT * FROM `user` WHERE `email` = '$email'";
    $email_result = mysqli_query($con,$check_email_query);
    $email_count = mysqli_fetch_array($email_result)[0];

    if($email_count > 0){
        $_SESSION['status'] = "Email address already taken";
        $_SESSION['status_code'] = "error";
        header("Location: register.php");
        exit();
    }

    if ($password !== $repassword){
        $_SESSION['status'] = "Password does not match";
        $_SESSION['status_code'] = "error";
        header("Location: register.php");
        exit();
    }


    $query = "INSERT INTO `user`(`email`, `password`, `fname`, `mname`, `lname`) VALUES ('$email','$password','$fname','$mname','$lname')";
    $query_result = mysqli_query( $con, $query );

    if($query_result){
        $_SESSION['status'] = "Registration Sucess!";
        $_SESSION['status_code'] = "success";
        header("Location: login.php");
        exit();
    }
}


if(isset($_POST["loginButton"])){

    $email = $_POST['email'];
    $password = $_POST['password'];

    $login_query = "SELECT `id`, `email`, `password`, `fname`, `mname`, `lname` FROM `user` WHERE `email` = '$email' AND `password` = '$password' LIMIT 1 ";
    $login_result = mysqli_query($con, $login_query);

    if(mysqli_num_rows($login_result) == 1){
            $_SESSION['status'] = "Welcome!";
            $_SESSION['status_code'] = "success";
            header("Location: index.php");
            exit();
    }else{
        $_SESSION['status'] = "Invalid Username/Password";
        $_SESSION['status_code'] = "error";
        header("Location: login.php");
        exit();
    }
}

if(isset($_POST["submitButton"])){

    $student_id = $_POST['student_id'];
    $fname = $_POST['fname'];
    $mname = $_POST['mname'];
    $lname = $_POST['lname'];
    $birthday = $_POST['birthday'];
    $email = $_POST['email'];

    $query = "INSERT INTO `student_information`(`student_id`, `fname`, `mname`, `lname`, `birthday`, `email`) 
    VALUES ('$student_id','$fname','$mname','$lname','$birthday', '$email')";
    $query_result = mysqli_query( $con, $query );

    if($query_result){
        $_SESSION['status'] = "Data is Added!";
        $_SESSION['status_code'] = "success";
        header("Location: index.php");
        exit();
    }
}


if(isset($_POST["update"])){

    $id = $_POST['id'];
    $student_id = $_POST['student_id'];
    $fname = $_POST['fname'];
    $mname = $_POST['$mname'];
    $lname = $_POST['lname'];
    $birthday = $_POST['birthday'];
    $email = $_POST['email'];
    $number = $_POST['number'];


    $query = "UPDATE `student_information` SET `student_id`='$student_id',`fname`='$fname',`mname`='$mname',`lname`='$lname',`birthday`='$birthday',`email`='$email',`date_Created`='$date_Created' WHERE `id` ='$id'";
    
    $query_result = mysqli_query( $con, $query );

    if($query_result){
        $_SESSION['status'] = "Data is Updated!";
        $_SESSION['status_code'] = "success";
        header("Location: index.php");
        exit();
    }else{
        $_SESSION['status'] = "Update Failed";
        $_SESSION['status_code'] = "error";
        header("Location: index.php");
        exit();
    }
}

if(isset($_POST["delete"])){

    $id = $_POST['id'];

    $query = "DELETE FROM `student_information` WHERE id = $id";
    
    $query_result = mysqli_query( $con, $query );

    if($query_result){
        $_SESSION['status'] = "Deleted";
        $_SESSION['status_code'] = "success";
        header("Location: index.php");
        exit();
    }else{
        $_SESSION['status'] = "Delete Failed";
        $_SESSION['status_code'] = "error";
        header("Location: index.php");
        exit();
    }
}
?>