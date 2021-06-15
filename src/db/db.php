<?php
class DB_Connection
{
    private $servername;
    private $username;
    private $password;
    private $db;
    private $conn;
    private $result;

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
     * @throws Exception
     */
    public function doQuery($query)
    {
        if(!is_string($query))
        {
            die("Error: Query failed -> no String");
        }

        $this->result = $this->conn->query($query);
        if($this->result === false)
        {
            $this->result = "";
            throw new Exception("Query returned false");
        }
        return $this->result;
    }

    /**
     * @return string
     */
    public function getResult()
    {
        return $this->result;
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
