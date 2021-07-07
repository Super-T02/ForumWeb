<?php
require_once "db/db.php";
require_once "DbElement.php";

class User implements DbElement
{
    private $id;
    private $name;
    private $password;
    private $typeID;

    /**
     * Loads and returns the User behind this ID.
     * Throws a exception if the user doesn't exists.
     *
     * @param int $id
     * @return User
     * @throws Exception
     */
    public static function getUserByID(int $id) :User
    {
        $connection = new DB_Connection();
        $connection->connect();

        // Get Data to DB
        $res = $connection->doQuery("SELECT * FROM users WHERE ID =". $id); // Gets the last ID
        $row = $res->fetch_assoc();

        $connection->closeConnection();

        return new User($row['userName'], $row['password'], $row['ID'], $row['typeID']);
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
    public function __construct(string $name, string $password, int $id = 0, int $typeID = 0)
    {
        $this->id = $id;
        $this->name = $name;
        $this->password = $password;
        $this->typeID = $typeID;

        if ($id == 0)
        {
            $this->sendToDB();
        }
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
        if($this->id == 0)
        {
            $connection = new DB_Connection();
            $connection->connect();

            //security for unescaped strings
            $connection->getConn()->real_escape_string($this->name);
            $connection->getConn()->real_escape_string($this->password);

            // Send Data to DB
            $connection->doQuery("INSERT INTO users (userName, password, typeID) VALUES ('" . $this->name . "', '" . $this->password . "', " . $this->typeID . ")");
            $_SESSION['successMessage'] = "Ein neuer User mit dem Namen '" . $this->name . "' wurde erstellt";
            $res = $connection->doQuery("SELECT ID FROM users WHERE 1 ORDER BY ID DESC"); // Gets the last ID
            $this->id = $res->fetch_assoc()['ID'];

            $connection->closeConnection();
        }
    }

    /**
     * @param int $id
     * @return User
     */
    public static function loadByID(int $id): User
    {
        return new User();// TODO: Implement loadByID() method.
    }

    public function __toString()
    {
        return "";// TODO: Implement __toString() method.
    }
}