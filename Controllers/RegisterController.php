<?php
session_start();

include '../Models/Database.php';
include '../Models/User.php';

$database = new Database();
$user = new User($database);

if(isset($_POST)) {
    $email = $_POST['email'];
    $name = $_POST['name'];
    $surname = $_POST['surname'];
    $password = $_POST['password'];
    $repeated_password = $_POST['password'];
    $hashed_password = password_hash($password, PASSWORD_DEFAULT);

    $error = false;

    $userExists = $user->checkIfUserExists($email);

    if(strlen($email) > 50 || !filter_var($email, FILTER_VALIDATE_EMAIL))
        $error = true;
    elseif ($password != $repeated_password)
        $error = true;
    elseif(strlen($password) < 8 || strlen($password) > 16)
        $error = true;
    elseif(strlen($name) < 1 || strlen($name) > 50)
        $error = true;
    elseif(strlen($surname) < 1 || strlen($surname) > 50)
        $error = true;
    elseif($userExists)
        $error = true;

    if($error)
        header("Location: ../Views/index.php");
    else {
        $user->createNewUser($name, $surname, $email, $hashed_password, 'Vartototojas');
        $_SESSION['email'] = $email;
        header("Location: ../Views/main.php");
    }
}
?>