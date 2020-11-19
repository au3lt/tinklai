<?php



class Database
{
    private $host = "localhost";
    private $user = "root";
    private $password = "";
    private $dbName = "ITProjektas";
    private $mysqli;

    public function __construct() {
        $this->mysqli = new mysqli($this->host, $this->user, $this->password, $this->dbName) or die($this->mysqli->error);
        return $this->mysqli;
    }

    public function getLink()
    {
        return $this->mysqli;
    }

    public function query($sql) {
        $result = $this->mysqli->query($sql);
        if(!result)
            die();
    }

    public function rows($sql){
        $result = $this->mysqli->query($sql);
        return $result->num_rows;
    }
}

?>