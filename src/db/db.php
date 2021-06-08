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

    /**
     * creates a connection to the database forum
     *
     * @return bool
     */
    public function connect()
    {
        // Create connection
        $this->conn = new mysqli($this->servername, $this->username, $this->password, $this->db);

        // Check connection
        if ($this->conn->connect_error) {
            die("Connection failed: " . $this->conn->connect_error);
        }
        return true;
    }

    /**
     * close connection to the Database
     */
    public function closeConnection()
    {
        $this->conn->close();
    }
}
?>
