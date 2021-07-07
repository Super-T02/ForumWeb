<?php
require_once "db/db.php";
require_once "DbElement.php";

const uploadDir = "../uploads/";

class Picture implements DbElement
{
    private int $size;
    private int $height;
    private int $width;
    private int $id;
    private int $parentID;
    private string $src;
    private string $name;
    private int $parentType; //0 := theme, 1 := answer

    /**
     * @param int $id
     * @return Picture
     * @throws Exception
     */
    public static function loadByID(int $id): Picture
    {
        $connection = new DB_Connection();
        $connection->connect();

        // Send Data to DB
        try {
            $res = $connection->doQuery("SELECT * FROM picture WHERE ID = ". $id); // Gets the last ID
            $row = $res->fetch_assoc();

            $connection->closeConnection();

            if ($row['themeID'] == null) return new Picture($row['sizeKB'], $row['height'], $row['width'], $row['articleID'], $row['url'], $row['name'], $id);
            else return new Picture($row['sizeKB'], $row['height'], $row['width'], $row['themeID'], $row['url'], $row['name'], $id);

        } catch (Exception $e) {
            $connection->closeConnection();

            throw new Exception("The Query gets the error: " . $e->getMessage());//error description

        }
    }

    /**
     * @param int $themeID
     * @return Picture
     * @throws Exception
     */
    public static function loadByThemeID(int $themeID): Picture
    {
        $connection = new DB_Connection();
        $connection->connect();

        // Send Data to DB
        try {
            $res = $connection->doQuery("SELECT * FROM picture WHERE themeID = ". $themeID); // Gets the last ID
            $row = $res->fetch_assoc();

            $connection->closeConnection();

            if ($row['themeID'] == null) return new Picture($row['sizeKB'], $row['height'], $row['width'], $row['articleID'], $row['url'], $row['name'], $themeID);
            else return new Picture($row['sizeKB'], $row['height'], $row['width'], $row['themeID'], $row['url'], $row['name'], $themeID);

        } catch (Exception $e) {
            $connection->closeConnection();

            throw new Exception("The Query gets the error: " . $e->getMessage());//error description

        }
    }

    /**
     * @param int $articleID
     * @return Picture
     * @throws Exception
     */
    public static function loadByAnswerID(int $articleID): Picture
    {
        $connection = new DB_Connection();
        $connection->connect();

        // Send Data to DB
        try {
            $res = $connection->doQuery("SELECT * FROM picture WHERE articleID = ". $articleID); // Gets the last ID
            $row = $res->fetch_assoc();

            $connection->closeConnection();

            if ($row['themeID'] == null) return new Picture($row['sizeKB'], $row['height'], $row['width'], $row['articleID'], $row['url'], $row['name'], $articleID);
            else return new Picture($row['sizeKB'], $row['height'], $row['width'], $row['themeID'], $row['url'], $row['name'], $articleID);

        } catch (Exception $e) {
            $connection->closeConnection();

            throw new Exception("The Query gets the error: " . $e->getMessage());//error description

        }
    }





    /**
     * picture constructor.
     * @param int $size in KB
     * @param int $height in px
     * @param int $width in px
     * @param int $parentID
     * @param int $parentType describes the type of the Parent 0 := theme, 1 := answer
     * @param string $fileName
     * @param string $name for the alt tag
     * @param int $id std: -1 if the picture isn't in the db yet
     */
    public function __construct(int $size, int $height, int $width, int $parentID, int $parentType, string $fileName, string $name, int $id = -1)
    {
        $this->size = $size;
        $this->height = $height;
        $this->width = $width;
        $this->id = $id;
        $this->parentID = $parentID;
        $this->src = $fileName;
        $this->name = $name;
        $this->parentType = $parentType;
    }

    /**
     * @throws Exception
     */
    public function sendToDB()
    {
        if ($this->id > -1) throw new Exception("Dieses Bild ist bereits in der Datenbank");

        $conn = new DB_Connection();
        $conn->connect();

        //Check the different parentTypes: 0 := theme, 1 := answer
        switch ($this->parentType){
            case 0:
                $query = "INSERT INTO picture (url, name, sizeKB, height, width, articleID, themeID) VALUES ('".$this->src."', '".$this->name."', ".$this->size
                    .", ".$this->height.", ".$this->width.", NULL, ".$this->parentID.")";
                break;
            case 1:
                $query = "INSERT INTO picture (url, name, sizeKB, height, width, articleID, themeID) VALUES ('".$this->src."', '".$this->name."', ".$this->size
                    .", ".$this->height.", ".$this->width.", ".$this->parentID.", NULL)";
                break;
            default:
                throw new Exception("Der angegebene Eltern-Typ ist nicht registriert.");
        }

        $conn->doQuery($query);
    }


    public function __toString()
    {
        return "<img class='content-img' src='".uploadDir.$this->src."' id='img-".$this->id."' alt='".$this->name."'>";
    }
}