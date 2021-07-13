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
        $this->servername = "db";
        $this->username = "root";
        $this->password = "test";
        $this->db = "mainBase";
    }

    /**
     * creates a connection to the database forum
     *
     * @return mysqli
     */
    public function connect()
    {
        // Create connection
        $this->conn = new mysqli($this->servername, $this->username, $this->password, $this->db);

        // Check connection
        if ($this->conn->connect_error) {
            die("Connection failed: " . $this->conn->connect_error);
        }
        return $this->conn;
    }

    /**
     * @param $query
     * @return mixed
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
            throw new Exception("Query returned false");
        }

        return $this->result;
    }

    /**
     * @return mysqli
     */
    public function getConn(): mysqli
    {
        return $this->conn;
    }



    /**
     * @return string
     */
    public function getResult(): string
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
