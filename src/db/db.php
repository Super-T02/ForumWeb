<?php
class dbConnection
{
    private $servername;
    private $username;
    private $password;
    private $db;
    private $conn;

    public function __construct()
    {
        $this->servername = "localhost";
        $this->username = "root";
        $this->password = "";
        $this->db = "forum";
    }

    public function connect()
    {
        // Create connection
        $this->conn = new mysqli($this->servername, $this->username, $this->password, $this->db);

        // Check connection
        if ($this->conn->connect_error) {
            die("Connection failed: " . $this->conn->connect_error);
        }
        echo 'open';
        return true;
    }

    public function closeConnection()
    {
        echo 'closed';
        $this->conn->close();
    }
}
?>
