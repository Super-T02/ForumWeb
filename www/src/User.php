<?php
require_once "db/db.php";
require_once "DbElement.php";

class User implements DbElement
{
    private int $id;
    private string $name;
    private string $password;

    /**
     * Loads and returns the User behind this ID.
     * Throws a exception if the user doesn't exists.
     *
     * @param int $id
     * @return User
     * @throws Exception
     */
    public static function loadByID(int $id) :User
    {
        $connection = new DB_Connection();
        $connection->connect();

        // Get Data to DB
        $res = $connection->doQuery("SELECT * FROM users WHERE ID =". $id); // Gets the last ID
        $row = $res->fetch_assoc();

        $connection->closeConnection();

        return new User($row['userName'], $row['password'], $row['ID']);
    }

    /**
     * Loads and returns the User behind this username.
     * Throws a exception if the user doesn't exists.
     *
     * @param string $username
     * @return User
     * @throws Exception
     */
    public static function loadByUsername(string $username) :User
    {
        $connection = new DB_Connection();
        $connection->connect();

        // Get Data to DB
        $res = $connection->doQuery("SELECT * FROM users WHERE userName ='". $username."'"); // Gets the last ID
        $row = $res->fetch_assoc();

        $connection->closeConnection();

        return new User($row['userName'], $row['password'], $row['ID']);
    }

    /**
     * @param string $username
     * @return bool
     * @throws Exception
     */
    public static function alreadyInDB(string $username) :bool
    {
        $connection = new DB_Connection();
        $connection->connect();

        // Get Data to DB
        try {
            $res = $connection->doQuery("SELECT * FROM users WHERE userName ='" . $username . "'"); // Gets the last ID

            $rows = $res->num_rows;

            $connection->closeConnection();

            if ($rows > 0) return true;

            return false;

        }catch (Exception $e) {
            $connection->closeConnection();
            if($e->getMessage() == "Query returned false")
            {
                return false;
            }
            else{
                throw new Exception("In the Query went something wrong");
            }
        }
    }

    /**
     * @param string $username
     * @param string $password
     * @return bool
     * @throws Exception
     */
    public static function isValid(string $username, string $password):bool
    {
        $connection = new DB_Connection();
        $connection->connect();

        // Get Data to DB
        try {
            $res = $connection->doQuery("SELECT * FROM users WHERE userName ='" . $username . "' and password ='".
                $password."'"); // Gets the last ID

            $rows = $res->num_rows;

            $connection->closeConnection();

            if ($rows > 0) return true;

            return false;

        }catch (Exception $e) {
            $connection->closeConnection();
            if($e->getMessage() == "Query returned false")
            {
                return false;
            }
            else{
                throw new Exception("In the Query went something wrong");
            }
        }
    }

    //Constructor

    /**
     * User constructor.
     * @param int $id
     * @param string $name
     * @param string $password
     * @param int $typeID
     * @throws Exception
     */
    public function __construct(string $name, string $password, int $id = 0)
    {
        $this->id = $id;
        $this->name = $name;
        $this->password = $password;
    }

    //Getters
    /**
     * @return int
     */
    public function getId(): int
    {
        return $this->id;
    }

    /**
     * @return string
     */
    public function getName(): string
    {
        return $this->name;
    }

    /**
     * @return int
     */
    public function getTypeID(): int
    {
        return $this->typeID;
    }

    //Own written functions

    /**
     * Creates a new User in the Database if the userID is 0.
     *
     * @throws Exception
     */
    public function sendToDB()
    {
        if($this->id == 0 && !self::alreadyInDB($this->name))
        {
            $connection = new DB_Connection();
            $connection->connect();

            //security for unescaped strings
            $connection->getConn()->real_escape_string($this->name);
            $connection->getConn()->real_escape_string($this->password);

            // Send Data to DB
            $connection->doQuery("INSERT INTO users (userName, password) VALUES ('" . $this->name .
                "', '" . $this->password . "')");

            $_SESSION['successMessage'] = "Ein neuer User mit dem Namen '" . $this->name . "' wurde erstellt";

            $res = $connection->doQuery("SELECT ID FROM users WHERE 1 ORDER BY ID DESC"); // Gets the last ID
            $this->id = $res->fetch_assoc()['ID'];

            $connection->closeConnection();
        }
    }

    public function __toString()
    {
        return "";// TODO: Implement __toString() method.
    }
}