<?php

include 'main.html';

?>
<html>
<body>
<nav class="navbar navbar-expand-lg navbar-light bg-light">
    <div class="collapse navbar-collapse" id="navbarSupportedContent">
        <ul class="nav navbar-nav ml-auto">
        <form class="form-inline" action="../Controllers/LoginController.php" method="post">
            <div class="input-group">
                <div class="input-group-prepend">
                    <span class="input-group-text" id="basic-addon1">@</span>
                </div>
                <input type="text" name="email" class="form-control mr-2" placeholder="El.paštas" aria-label="Username" aria-describedby="basic-addon1">
                <input type="password" name="password" class="form-control mr-2" placeholder="Slaptažodis" aria-label="Username" aria-describedby="basic-addon1">
                <button type="submit" class="btn btn-primary">Prisijungti</button>
            </div>
        </form>
            <li class="nav-item">
                <button type="button" class="btn btn-primary ml-2" data-toggle="modal" data-target="#register">
                    Registruotis
                </button>
            </li>
    </div>
</nav>
<!-- Registracija -->
<div class="modal" id="register">
    <div class="modal-dialog">
        <div class="modal-content">

            <!-- Modal Header -->
            <div class="modal-header">
                <h4 class="modal-title">Registruotis</h4>
                <button type="button" class="close" data-dismiss="modal">&times;</button>
            </div>

            <!-- Modal body -->
            <div class="modal-body">
                <form action="../Controllers/RegisterController.php" method="post" name="f1" action="#" onsubmit="return validate()">
                    <div class="form-group">
                        <label for="exampleInputEmail1">Vardas</label>
                        <input type="text" class="form-control" name="name" placeholder="Įveskite vardą">
                        <span id="nameLoc" style="color:red;"></span>
                    </div>
                    <div class="form-group">
                        <label for="exampleInputEmail1">Pavardė</label>
                        <input type="text" class="form-control" name="surname" placeholder="Įveskite pavardę">
                        <span id="surnameLoc" style="color:red;"></span>
                    </div>
                    <div class="form-group">
                        <label for="exampleInputEmail1">El. paštas</label>
                        <input type="text" class="form-control" name="email" placeholder="Įveskite el. paštą">
                        <span id="emailLoc" style="color:red;"></span>
                    </div>
                    <div class="form-group">
                        <label for="exampleInputPassword1">Slaptažodis</label>
                        <input type="password" class="form-control" name="password" placeholder="Įveskite slaptažodį" >
                        <small class="form-text text-muted">Slaptažodį turi sudaryti nuo 8 iki 16 simbolių</small>
                        <span id="passwordloc" style="color:red;"></span>
                    </div>
                    <div class="form-group">
                        <label for="exampleInputPassword1">Pakartokite slaptažodį</label>
                        <input type="password" class="form-control" name="password2" placeholder="Pakartokite slaptažodį">
                        <span id="password2Loc" style="color:red;"></span>
                    </div>
                    <input type="submit" class="btn btn-primary" value="Registruotis">
                </form>
            </div>
        </div>
    </div>
</div>

<div class="container border border-secondary rounded bg-white text-dark mt-5" style="max-width: 800px;">
    <div class="p-3 mb-2 bg-primary text-white rounded-top" style="margin-left: -15px;margin-right: -15px;">Rengiami kursai</div>
    <div class="panel-group" id="accordion" role="tablist" aria-multiselectable="true">
        <?php

        include '../Models/Database.php';
        include '../Models/Course.php';

        $database = new Database;
        $course = new Course($database);

        $allCourses = $course->retrieveAll();
        $i = 1;

        if(mysqli_num_rows($allCourses) < 1)
            echo"Šiuo metu rengiamų kursų nėra";

        while($row = mysqli_fetch_assoc($allCourses)) {
            ?>
            <div class="panel panel-default" >
                <div class="panel-heading" role="tab" id="heading<?php echo $i ?>">
                    <h4 class="panel-title">
                        <a role="button" data-toggle="collapse" data-parent="#accordion" href="#collapse<?php echo $i; ?>" aria-expanded="false""><?php echo $row['title']; echo "<span style='font-size: 13px;'>"; echo $row['description']; echo"</span>"; ?></a>
                    </h4>
                </div>
                <div id="collapse<?php echo $i; ?>" class="panel-collapse collapse " role="tabpanel" aria-labelledby="heading<?php echo $i; ?>">
                    <div class="panel-body">
                        <table class="table">
                            <?php

                            echo"<tr>";
                            echo"<th>Kategorija</th>";
                            echo"<th>" . $row['title'] . "</th>";
                            echo"</tr>";
                            echo"<tr>";
                            echo"<th>Aprašymas</th>";
                            echo"<th>" . $row['description'] . "</th>";
                            echo"</tr>";
                            echo"<tr>";
                            echo"<th>Kaina praktiniams + teoriniams užsiėmimams</th>";
                            echo"<th>" . $row['price_both'] . "</th>";
                            echo"</tr>";
                            echo"<tr>";
                            echo"<th>Kaina praktiniams užsiėmimams</th>";
                            echo"<th>" . $row['price_practic'] . "</th>";
                            echo"</tr>";
                            echo"<tr>";
                            echo"<th>Kaina teoriniams užsiėmimams</th>";
                            echo"<th>" . $row['price_theory'] . "</th>";
                            echo"</tr>";
                            echo"<tr>";
                            echo"<th>Vietų skaičius</th>";
                            echo"<th>" . $row['slots'] . "</th>";
                            echo"</tr>";
                            echo"<tr>";
                            echo"<th>Ar uždaryta registracija?</th>";
                            if($row['is_closed'] == 0)
                                echo"<th>Ne</th>";
                            else
                                echo"<th>Taip</th>";
                            echo"</tr></table>";
                            $courseDates = $course->retrieveAllDates($row['id']);

                            echo"Kursų laikai:<br />";
                            echo'<table class="table">';
                            echo'  <thead class="thead-dark">
    <tr>
      <th scope="col">Diena</th>
      <th scope="col">Pradžia</th>
      <th scope="col">Pabaiga</th>
      <th scope="col">Paskaitos tipas</th>
    </tr>
  </thead>';
                            while($row2 = mysqli_fetch_assoc($courseDates)) {
                                echo'<tr>';
                                echo"<th>" . $row2['day'] . "</th>";
                                echo"<th>" . $row2['time_start'] . "</th>";
                                echo"<th>" . $row2['time_end'] . "</th>";
                                if($row2['type'] == "Theory")
                                    echo"<th>Teorija</th>";
                                else
                                    echo"<th>Praktika</th>";
                                echo'</tr>';
                            }
                            echo'</table>';
                            ?>
                    </div>
                </div>
            </div>
            <?php
            $i++;
        }


        ?>
    </div>
</div>

</body>
</html>