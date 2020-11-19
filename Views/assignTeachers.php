<?php

include 'loggedIn.php';
include '../Models/Course.php';

$course = new Course($database);
$thisCourseId = $_GET['courseId'];

if($user->role != "Administratorius") {
    header("Location: main.php");
    exit;
}

?>

<html>
<body>
<div class="container border border-secondary rounded bg-white text-dark mt-5" style="max-width: 800px;">
    <div class="p-3 mb-2 bg-primary text-white rounded-top" style="margin-left: -15px;margin-right: -15px;">Priskirti kursantams dėstytojus</div>
            <form method="post" action="../Controllers/CoursesController.php?action=assignTeachers&amp;course=<?php echo $thisCourseId ?>">
            <table class="table">
                <thead class="thead-dark">
                <tr>
                    <th scope="col">Vardas</th>
                    <th scope="col">Pavardė</th>
                    <th scope="col">El. paštas</th>
                    <th scope="col">Paskaitų tipas</th>
                    <th scope="col">Priskirti dėstytoją</th>
                </tr>
                </thead>
                <?php
                $coursants = $course->getCoursants($thisCourseId);
                while($row3 = mysqli_fetch_assoc($coursants)) {
                    $idOfSelection = $row3['courseID'];
                    echo"<input type='hidden' name='id[]' value='$idOfSelection'>";

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

                    $teachers = $course->getFreeTeachers($thisCourseId, $row3['type']);

                    echo'<th><div class="form-group">
                         <select class="form-control" name="teachers[]">';
                    echo"<option value='0' selected='selected'>Pasirinkite</option>";
                    while($row4 = mysqli_fetch_assoc($teachers)) {
                        $teacherName = $row4['name'];
                        $teacherSurname = $row4['surname'];
                        $teacherID = $row4['teacherID'];

                        if($row4['teacherType'] == "Both")
                            $teacherType = "Teorija + praktika";
                        if($row4['teacherType'] == "Theory")
                            $teacherType = "Teorija";
                        if($row4['teacherType'] == "Practic")
                            $teacherType = "Praktika";

                        echo"<option value='$teacherID'>$teacherName $teacherSurname($teacherType)</option>";
                    }
                    echo'</select></div></th>';
                    echo"</tr>";
                }
                ?>
            </table>
                <button type="submit" class="btn btn-primary">Priskirti</button>
            </form>
    <br/>
</div>
</body>
</html>
