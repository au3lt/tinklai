<?php


class User
{
    public $id;
    public $email;
    public $password;
    public $name;
    public $surname;
    public $role;
    private $tableName = "users";
    private $conn;

    public function __construct(Database $db)
    {
        $this->conn = $db->getLink();
    }

    public function getUserDataByEmail($email) {
        $sql = "SELECT * FROM $this->tableName WHERE email='$email'";
        $query = mysqli_query($this->conn, $sql);
        $data = mysqli_fetch_assoc($query);
        $this->email = $data['email'];
        $this->name = $data['name'];
        $this->surname = $data['surname'];
        $this->role = $data['role'];
        $this->id = $data['id'];
        return $this;
    }

    public function getUserDataByID($userID) {
        $sql = "SELECT * FROM $this->tableName WHERE id='$userID'";
        $query = mysqli_query($this->conn, $sql);
        $data = mysqli_fetch_assoc($query);
        $this->name = $data['name'];
        $this->surname = $data['surname'];
        $this->email = $data['email'];
        return $this;
    }

    public function getHashedPassword($email) {
        $query = $this->conn->query("SELECT password FROM $this->tableName WHERE email='$email'");
        return $query->fetch_row()[0];
    }

    public function checkIfUserExists($email) {
        $query = $this->conn->query("SELECT * FROM $this->tableName WHERE email='$email'");
        $rows = mysqli_num_rows($query);
        if($rows > 0)
            return true;
        return false;
    }

    public function createNewUser($name, $surname, $email, $password, $role) {
        $query = $this->conn->query("INSERT INTO $this->tableName (name, surname, email, password, role) 
                                          VALUES ('$name', '$surname', '$email', '$password', 'Vartotojas')");
    }

}

?>