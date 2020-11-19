<?php

include '../Models/Course.php';
include '../Models/Database.php';
include '../Models/User.php';

session_start();

$database = new Database;
$course = new Course($database);
$user = new User($database);
$user->getUserDataByEmail($_SESSION['email']);

if(isset($_GET['action'])) {
    $action = $_GET['action'];
}

if(isset($_GET['course'])) {
    $courseId = $_GET['course'];
}

if($action == "assignTeachers") {
    if($user->role != "Administratorius") {
        header("Location: main.php");
        exit;
    }
    $selectedCoursesIds = $_POST['id'];
    $teachers = $_POST['teachers'];
    $success_message = "Operacija atlikta";

    for($i = 0; $i < count($selectedCoursesIds); $i++) {
        $course->assignTeachers($teachers[$i], $selectedCoursesIds[$i]);
    }
    header("Location: ../Views/assignTeachers.php?courseId=$courseId&amp;success=$success_message");
}

if($action == "registerBoth") {
    if($course->checkIfUserRegistered($user->id, $courseId)) {
        $error_message = "Jūs jau užsiregistravote į šiuos kursus";
        header("Location: ../Views/main.php?error=$error_message");
    }
    else {
        $course->registerForCourses($user->id, $courseId, 'Both');
        $success_message = "Registracija sėkminga";
        header("Location: ../Views/main.php?success=$success_message");
    }
}

if($action == "registerPractic") {
    if($course->checkIfUserRegistered($user->id, $courseId)) {
        $error_message = "Jūs jau užsiregistravote į šiuos kursus";
        header("Location: ../Views/main.php?error=$error_message");
    }
    else {
        $course->registerForCourses($user->id, $courseId, 'Practic');
        $success_message = "Registracija sėkminga";
        header("Location: ../Views/main.php?success=$success_message");
    }
}

if($action == "registerTheory") {
    if($course->checkIfUserRegistered($user->id, $courseId)) {
        $error_message = "Jūs jau užsiregistravote į šiuos kursus";
        header("Location: ../Views/main.php?error=$error_message");
    }
    else {
        $course->registerForCourses($user->id, $courseId, 'Theory');
        $success_message = "Registracija sėkminga";
        header("Location: ../Views/main.php?success=$success_message");
    }
}

if($action == "createCourse") {
    if($user->role != "Administratorius") {
        header("Location: main.php");
        exit;
    }
    if (isset($_POST)) {
        $category = $_POST['category'];
        $description = $_POST['description'];
        $priceBoth = $_POST['priceBoth'];
        $pricePractise = $_POST['pricePractise'];
        $priceTheory = $_POST['priceTheory'];
        $slots = $_POST['slots'];
        $closed = $_POST['closed'];

        $error = false;

        if(!empty($_POST['days']))
            $days = $_POST['days'];
        if(!empty($_POST['startTime']))
            $startTime = $_POST['startTime'];
        if(!empty($_POST['endTime']))
            $endTime = $_POST['endTime'];
        if(!empty($_POST['type']))
            $type = $_POST['type'];

        if ($category == "")
            $error = true;
        elseif (strlen($description)< 10 || strlen($description) > 300)
            $error = true;
        elseif (!is_numeric($priceBoth))
            $error = true;
        elseif (!is_numeric($pricePractise))
            $error = true;
        elseif (!is_numeric($priceTheory))
            $error = true;
        elseif (!is_numeric($slots))
            $error = true;

        if($closed != "closed")
            $closed = "";

        if ($error)
            header("Location: ../Views/createCourse.php?action=createCourse");
        else {
            $course->addCourse($category, $description, $priceBoth, $pricePractise, $priceTheory, $slots, $closed, $days, $startTime, $endTime, $type);
            header("Location: ../Views/courses.php");
        }
    }

}

?>