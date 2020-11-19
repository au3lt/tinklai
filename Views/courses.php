<?php

include 'loggedIn.php';
include '../Models/Course.php';

$course = new Course($database);

if($user->role != "Administratorius") {
    header("Location: main.php");
    exit;
}

?>

<html>
<body>
<div class="container border border-secondary rounded bg-white text-dark mt-5" style="max-width: 800px;">
    <div class="p-3 mb-2 bg-primary text-white rounded-top" style="margin-left: -15px;margin-right: -15px;">Rengiami kursai</div>
    <div class="panel-group" id="accordion" role="tablist" aria-multiselectable="true">
    <?php

    $allCourses = $course->retrieveAll();
    $i = 1;

    if(mysqli_num_rows($allCourses) < 1)
        echo"Šiuo metu rengiamų kursų nėra";

    while($row = mysqli_fetch_assoc($allCourses)) {
        $thisCourseId = $row['id'];
        ?>
        <div class="panel panel-default" >
            <div class="panel-heading" role="tab" id="heading<?php echo $i ?>">
                <h4 class="panel-title">
                    <a role="button" data-toggle="collapse" data-parent="#accordion" href="#collapse<?php echo $i; ?>" aria-expanded="false""><?php echo $row['title']; echo "<span style='font-size: 13px;'>kat. "; echo $row['description']; echo"</span>"; ?></a>
                    <a class="ml-auto" href="assignTeachers.php?courseId=<?php echo $thisCourseId ?>">Priskirti dėstytojus</a>
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
                    echo"</tr>";
                    ?>
                    </table>

                    <?php

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

                    <div class="accordion" id="accordionExample">
                        <div class="card">
                            <div class="card-header" id="headingOne">
                                <h2 class="mb-0">
                                    <button class="btn btn-link" type="button" data-toggle="collapse" data-target="#collapseOne" aria-expanded="true" aria-controls="collapseOne">
                                        Kursantų sąrašas
                                    </button>
                                </h2>
                            </div>

                            <div id="collapseOne" class="collapse" aria-labelledby="headingOne" data-parent="#accordionExample">
                                <div class="card-body">
                                    <table class="table">
                                        <thead class="thead-dark">
                                        <tr>
                                            <th scope="col">Vardas</th>
                                            <th scope="col">Pavardė</th>
                                            <th scope="col">El. paštas</th>
                                            <th scope="col">Paskaitų tipas</th>
                                        </tr>
                                        </thead>
                                    <?php
        $coursants = $course->getCoursants($row['id']);
                                    while($row3 = mysqli_fetch_assoc($coursants)) {
                                        echo"<tr>";
                                        echo"<th>" . $row3['name'] . "</th>";
                                        echo"<th>" . $row3['surname'] . "</th>";
                                        echo"<th>" . $row3['email'] . "</th>";
                                        if($row3['type'] == "Both")
                                            echo"<th>Teorija + praktika</th>";
                                        else if($row3['type'] == "Theory")
                                            echo"<th>Teorija</th>";
                                        else
                                            echo"<th>Praktika</th>";
                                        
                                        echo"</tr>";
                                    }
                                    ?>
                                    </table>
                                </div>
                            </div>
                        </div>
                    </div>


                </div>
            </div>
        </div>
        <br/>
        <?php
        $i++;
    }


    ?>
    </div>
</div>
</body>
</html>

