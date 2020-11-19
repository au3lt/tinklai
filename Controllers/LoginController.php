<?php

include '../Models/Database.php';
include '../Models/User.php';

$database = new Database;
$user = new User($database);

if(isset($_POST)) {
    $email = $_POST['email'];
    $password = $_POST['password'];
    $hashed_password = password_hash($password, PASSWORD_DEFAULT);

    $error = false;

    $passwordFromDb = $user->getHashedPassword($email);

    if(password_verify($password, $passwordFromDb)) {
        session_start();
        $_SESSION['email'] = $email;
        header("Location: ../Views/main.php");
    }
    else {
        header("Location: ../Views/index.php");
    }
}
?>

?>