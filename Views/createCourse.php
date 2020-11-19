<?php

include 'loggedIn.php';
include '../Models/Course.php';

$course = new Course($database);

if($user->role != "Administratorius") {
    header("Location: main.php");
    exit;
}

if(isset($_GET['action'])) {
    $action = $_GET['action'];
}

if($action == "createCourse") {
    echo '<div class="container border border-secondary rounded bg-white text-dark mt-5" style="max-width: 700px;">
    <form method="post" id="createCourseForm" name="createCourseForm" action="../Controllers/CoursesController.php?action=createCourse" onsubmit="return validateCreateCourseForm()">
    <div class="form-group">
    <label for="exampleInputEmail1">Kategorija</label>
    <select class="form-control" name="category">';
    $categories = $course->getCategories();

    while ($row = mysqli_fetch_assoc($categories)) {
        echo'<option value="' . $row['category'] . '">' . $row['category'] . '</option>';
    }
     echo'</select>
    <span id="categoryLoc" style="color:red;"></span>
    </div>
    <div class="form-group">
        <label>Kursų aprašas</label>
        <textarea class="form-control" name="description" rows="3"></textarea>
        <span id="descriptionLoc" style="color:red;"></span>
     </div>
     <div class="form-group">
        <label>Kaina teoriniams + praktiniams užsiėmimams</label>
        <input step="0.01" type="number" class="form-control" name="priceBoth" placeholder="Įveskite kainą">
        <span id="priceBothLoc" style="color:red;"></span>
     </div>
     <div class="form-group">
        <label>Kaina teoriniams praktiniams</label>
        <input type="number" step="0.01" class="form-control" name="pricePractise" placeholder="Įveskite kainą">
        <span id="pricePractiseLoc" style="color:red;"></span>
     </div>
     <div class="form-group">
        <label>Kaina teoriniams užsiėmimams</label>
        <input type="number" step="0.01" class="form-control" name="priceTheory" placeholder="Įveskite kainą">
        <span id="priceTheoryLoc" style="color:red;"></span>
     </div>
     <div class="form-group">
        <label>Vietų skaičius</label>
        <input type="number" class="form-control" name="slots" placeholder="Įveskite vietų skaičių">
        <span id="slotsLoc" style="color:red;"></span>
     </div>
     <div class="form-check">
     <input class="form-check-input" type="checkbox" value="closed" name="closed">
     <label class="form-check-label" for="defaultCheck1">
     Ar registracija uždaryta?
     </label>
     </div><br/>
     <span id="timeLoc" style="color:red;"></span>
    
     <div id="newRow"></div>
     <button id="addRow" type="button" class="btn btn-info">Pridėti laikų</button><br/><br/>
     
     <button type="submit" class="btn btn-primary">Submit</button>
     </form>
     </div>';
}

?>

<script type="text/javascript">
    // add row
    $("#addRow").click(function () {
        var html = '';
        html += '<div id="inputFormRow" style="width: 100%;">';
        html += '<div class="input-group mb-3">';
        html += '<select name="days[]">';
        html += '<option value="Pirmadienis">Pirmadienis</option>';
        html += '<option value="Antradienis">Antradienis</option>';
        html += '<option value="Trečiadienis">Trečiadienis</option>';
        html += '<option value="Ketvirtadienis">Ketvirtadienis</option>';
        html += '<option value="Penktadienis">Penktadienis</option>';
        html += '<option value="Šeštadienis">Šeštadienis</option>';
        html += '<option value="Sekmadienis">Sekmadienis</option>';
        html += '</select>';
        html += '<select name="type[]">';
        html += '<option value="Theory">Teorija</option>';
        html += '<option value="Practic">Praktika</option>';
        html += '</select>';
        html += '<input type="time" style="max-width: 100px;" name="startTime[]" class="form-control m-input" placeholder="Pradžios laikas" autocomplete="off">';
        html += '<input type="time" style="max-width: 100px;" name="endTime[]" class="form-control m-input" placeholder="Pabaigos laikos" autocomplete="off">';
        html += '<div class="input-group-append">';
        html += '<button id="removeRow" type="button" class="btn btn-danger">Ištrinti</button>';
        html += '</div>';
        html += '</div>';

        $('#newRow').append(html);
    });

    // remove row
    $(document).on('click', '#removeRow', function () {
        $(this).closest('#inputFormRow').remove();
    });
</script>
