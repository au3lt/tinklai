<?php

session_start();

include '../Models/Database.php';
include '../Models/User.php';
$database = new Database;
$user = new User($database);
$user->getUserDataByEmail($_SESSION['email']);

if($_SESSION['email'] == "") {
    header("Location: index.php");
    exit;
}

?>
<!DOCTYPE html>
<html lang="en">
<head>
    <title>Vairavimo kursai</title>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <link rel="stylesheet" href="../Resources/bootstrap.css">
    <script src="../Resources/js.js"></script>
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.16.0/umd/popper.min.js"></script>
    <script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>
</head>
<body>
<nav class="navbar navbar-expand-lg navbar-light bg-light">
    <div class="collapse navbar-collapse" id="navbarSupportedContent">
        <ul class="navbar-nav mr-auto">
            <li class="nav-item">
                  <span class="navbar-text text-dark">
                    Sveiki, <?php echo $user->name; ?><span class="sr-only">(current)
                      </span>
            </li>
            <li class="nav-item">
                <a class="nav-link" href="main.php">Pagrindinis puslapis</a>
            </li>
        </ul>
        <ul class="nav navbar-nav ml-auto">
            <?php

            if ($user->role == "Dėstytojas") {
                echo '<li class="nav-item dropdown">
                        <a class="nav-link dropdown-toggle" href="#" id="navbarDropdown" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                            Dėstytojo meniu
                       </a>
                        <div class="dropdown-menu" aria-labelledby="navbarDropdown">
                            <a class="dropdown-item" href="teacher.php">Peržiūrėti užsiėmimus</a>
                            
                        </div>
                        </li>';
            }

            if ($user->role == "Administratorius") {
                echo '<li class="nav-item dropdown">
                        <a class="nav-link dropdown-toggle" href="#" id="navbarDropdown" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                            Administratoriaus meniu
                       </a>
                        <div class="dropdown-menu" aria-labelledby="navbarDropdown">
                            <a class="dropdown-item" href="courses.php">Kursai</a>
                            <a class="dropdown-item" href="createCourse.php?action=createCourse">Sukurti kursą</a>
                            
                        </div>
                        </li>';
            }

            ?>
            <li class="nav-item">
                <a class="nav-link text-danger" href="../Controllers/UserController.php?action=logOff">Atsijungti</a>
            </li>
        </ul>
    </div>
</nav>
</body>
</html>