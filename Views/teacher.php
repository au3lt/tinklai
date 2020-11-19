<?php

include 'loggedIn.php';

include '../Models/Course.php';

$course = new Course($database);
$newUser = new User($database);

if($user->role != "Dėstytojas") {
    header("Location: main.php");
    exit;
}

?>


<html>
<body>
<div class="container border border-secondary rounded bg-white text-dark mt-5">
    <?php

    $row_count = 1;
    $days_array = ["Pirmadienis", "Antradienis", "Trečiadienis", "Ketvirtadienis", "Penktadienis", "Šeštadienis", "Sekmadienis"];

    echo'<div class="panel-group" id="accordion" role="tablist" aria-multiselectable="true">';

    foreach($days_array as $day) {
        $teacherLectures = $course->getTeacherLecturesByDay($user->id, $day);
        if(mysqli_num_rows($teacherLectures) > 0) {
            ?>

            <div class="panel panel-default" >
                <div class="panel-heading" role="tab" id="heading<?php echo $row_count ?>">
                    <h4 class="panel-title">
                        <a role="button" data-toggle="collapse" data-parent="#accordion" href="#collapse<?php echo $row_count; ?>" aria-expanded="false""><?php echo $day ?></a>
                    </h4>
                </div>
                <div id="collapse<?php echo $row_count; ?>" class="panel-collapse collapse " role="tabpanel" aria-labelledby="heading<?php echo $row_count; ?>">
                    <div class="panel-body">

                        <table class="table">
                            <thead class="thead-dark">
                            <tr>
                                <th scope="col">Vardas</th>
                                <th scope="col">Pavardė</th>
                                <th scope="col">El. paštas</th>
                                <th scope="col">Paskaitų tipas</th>
                                <th scope="col">Pradžia</th>
                                <th scope="col">Pabaiga</th>
                            </tr>
                            </thead>
            <?php

            while($data = mysqli_fetch_assoc($teacherLectures)) {
                    $userData = $newUser->getUserDataByID($data['userID']);

                    echo"<tr>";
                    echo"<th>" . $userData->name . "</th>";
                    echo"<th>" . $userData->surname . "</th>";
                    echo"<th>" . $userData->email . "</th>";
                    if($data['type'] == "Both")
                        echo"<th>Teorija + praktika</th>";
                    else if($data['type'] == "Theory")
                        echo"<th>Teorija</th>";
                    else
                        echo"<th>Praktika</th>";
                    echo"<th>" . $data['time_start'] . "</th>";
                    echo"<th>" . $data['time_end'] . "</th>";
                    echo"</tr>";
                    ?>
                <?php
            }
            echo "                </table></div>
                </div></div>";
        }
        $row_count++;
    }
    ?>
</div>
</div>
</body>
</html>
