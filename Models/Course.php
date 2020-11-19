<?php


class Course
{
    private $tableName = "courses";
    private $categoriesTableName = "categories";
    private $timesTableName = "courses_dates";
    private $selectedCoursesTableName = "selected_courses";
    private $usersTableName = "users";
    private $teachersTableName = "teachers";
    private $conn;

    public function __construct(Database $db)
    {
        $this->conn = $db->getLink();
    }

    public function getCategories() {
        $query = $this->conn->query("SELECT * FROM $this->categoriesTableName");
        return $query;
    }

    public function addCourse($category, $description, $priceBoth, $pricePractise, $priceTheory, $slots, $closed, $day, $startTime, $endTime, $type) {
        $sql = "INSERT INTO $this->tableName (title, description, price_both, price_practic, price_theory, slots, is_closed)
                VALUES ('$category', '$description', '$priceBoth', '$pricePractise', '$priceTheory', '$slots', '$closed')";
        $this->conn->query($sql);
        $id = $this->conn->insert_id;
        for($i = 0; $i < count($day); $i++) {
            $sql = "INSERT INTO $this->timesTableName (fk_course_id, day, time_start, time_end, type)
                    VALUES ('$id', '$day[$i]', '$startTime[$i]', '$endTime[$i]', '$type[$i]')";
            $this->conn->query($sql);
        }
    }

    public function retrieveAllDates($id) {
        $sql = "SELECT * FROM $this->timesTableName WHERE fk_course_id='$id'";
        return $this->conn->query($sql);
    }

    public function retrieveAll() {
        $sql = "SELECT * FROM $this->tableName";
        return $this->conn->query($sql);
    }

    public function retrieveAllCoursantsById($id) {
        $sql = "SELECT * FROM $this->selectedCoursesTableName WHERE fk_course='$id'";
        return $this->conn->query($sql);
    }

    public function registerForCourses($userId, $courseId, $type) {
        $sql = "INSERT INTO $this->selectedCoursesTableName (type, fk_user, fk_course)
                VALUES ('$type', '$userId', '$courseId')";
        return $this->conn->query($sql);
    }

    public function checkIfUserRegistered($userId, $courseId) {
        $sql = "SELECT * FROM $this->selectedCoursesTableName WHERE fk_user='$userId' AND fk_course='$courseId'";
        $query = $this->conn->query($sql);
        $data = mysqli_num_rows($query);
        if($data > 0)
            return true;
        return false;
    }

    public function getCoursants($courseId) {
        $sql = "SELECT $this->selectedCoursesTableName.id AS courseID, $this->selectedCoursesTableName.fk_user, $this->selectedCoursesTableName.type, $this->usersTableName.id, $this->usersTableName.name, $this->usersTableName.surname, $this->usersTableName.email FROM $this->selectedCoursesTableName
                INNER JOIN $this->usersTableName ON $this->selectedCoursesTableName.fk_user=$this->usersTableName.id WHERE $this->selectedCoursesTableName.fk_course='$courseId'";
        return $this->conn->query($sql);
    }

    public function getFreeTeachers($courseId, $type) {
        if($type == "Practic")
            $sql = "SELECT $this->teachersTableName.id AS teacherID, $this->teachersTableName.type AS teacherType, $this->usersTableName.* FROM $this->teachersTableName INNER JOIN $this->usersTableName
                    ON $this->teachersTableName.fk_user=$this->usersTableName.id
                    WHERE $this->teachersTableName.fk_course='$courseId' AND ($this->teachersTableName.type='Both' or $this->teachersTableName.type='Practic')";
        else if($type == "Theory")
            $sql = "SELECT $this->teachersTableName.id AS teacherID, $this->teachersTableName.type AS teacherType, $this->usersTableName.* FROM $this->teachersTableName INNER JOIN $this->usersTableName
                    ON $this->teachersTableName.fk_user=$this->usersTableName.id
                    WHERE fk_course='$courseId' AND ($this->teachersTableName.type='Both' or $this->teachersTableName.type='Theory')";
        else {
            $sql = "SELECT $this->teachersTableName.id AS teacherID, $this->teachersTableName.type AS teacherType, $this->usersTableName.* FROM $this->teachersTableName INNER JOIN $this->usersTableName
                    ON $this->teachersTableName.fk_user=$this->usersTableName.id
                    WHERE fk_course='$courseId' AND $this->teachersTableName.type='Both'";
        }
        return $this->conn->query($sql);
    }

    public function assignTeachers($teacherID, $selectedCourseId) {
        $sql = "UPDATE $this->selectedCoursesTableName SET teacher='$teacherID' WHERE id='$selectedCourseId'";
        $this->conn->query($sql);
    }

    public function getTeacherLecturesByDay($teacherID, $day) {
        $sql = "SELECT tt.*, s.fk_user as userID, t.fk_user AS teacherID FROM $this->teachersTableName t
                INNER JOIN $this->selectedCoursesTableName s ON s.teacher=t.id
                INNER JOIN $this->timesTableName tt ON tt.fk_course_id=s.fk_course AND tt.type=s.type
                WHERE t.fk_user=$teacherID and tt.day='$day'";
        echo $sql;
        return $this->conn->query($sql);
    }

}