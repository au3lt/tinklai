<?php

if(isset($_GET['action'])) {
    $action = $_GET['action'];
}

if($action == "logOff") {
    session_start();
    session_destroy();
    header("Location: ../Views/index.php?successMessage=Sėkmingai atsijungta");
}

?>
