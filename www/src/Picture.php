<?php
require_once "db/db.php";
require_once "DbElement.php";

define("uploadDir", "../uploads/");


class Picture implements DbElement
{
    private int $size;
    private int $height;
    private int $width;
    private int $id;
    private string $src;
    private string $name;


    //Static Funktions
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
            return new Picture($row['sizeKB'], $row['height'], $row['width'], $row['url'],$row['name'], $id);

        } catch (Exception $e) {
            $connection->closeConnection();

            throw new Exception("The Query gets the error: " . $e->getMessage());//error description

        }
    }

    /**
     * @param int $id
     * @return Picture
     * @throws Exception
     */
    public static function loadByURL(string $url): Picture
    {
        $connection = new DB_Connection();
        $connection->connect();

        // Send Data to DB
        try {
            $res = $connection->doQuery("SELECT * FROM picture WHERE url = '". $url."'"); // Gets the last ID
            $row = $res->fetch_assoc();

            $connection->closeConnection();

            return new Picture($row['sizeKB'], $row['height'], $row['width'], $row['url'], $row['name'], $row['ID']);

        } catch (Exception $e) {
            $connection->closeConnection();

            throw new Exception("The Query gets the error: " . $e->getMessage());//error description

        }
    }

    /**
     * Checks the file upload for pictures.
     * @param string $imgFileType type of the file
     * @param string $name _FILES['...']['name']
     * @param string $tmp_name _FILES['...']['tmp_name']
     * @param string $targetDir
     * @param int $size in Bytes
     * @param int $parentID
     * @param int $parentType 0 := theme, 1 := answer
     * @param string $alt alternative text
     * @return Picture
     * @throws Exception or RuntimeException
     */
    public static function checkUpLoad(string $imgFileType, string $name, string $tmp_name, string $targetDir, int $size, string $alt): Picture
    {
        // Check if image file is a actual image
        $check = getimagesize($tmp_name);

        if ($check === false) {
            throw new RuntimeException("Datei ist keine Bilddatei");
        }

        // Check already exist
        if (file_exists($targetDir.basename($name))) {
            throw new Exception("Diese Datei existiert bereits!");
        }

        // Check file size
        if ($size > 500000000) { //larger than 5 MB
            throw new RuntimeException("Datei ist zu groß. Es sind maximal 5 MB zugelassen.");
        }

        // Check file type
        if ($imgFileType != "png" && $imgFileType != "jpg" && $imgFileType != "jpeg"
            && $imgFileType != "gif") {
            throw new RuntimeException("Es sind nur JPG, JPEG, PNG & GIF Dateien erlaubt.");
        }

        $pic = new Picture($size, $check[1], $check[0], basename($name), $alt);

        $pic->sendToDB();

        return $pic;
    }


    /**
     * picture constructor.
     * @param int $size in KB
     * @param int $height in px
     * @param int $width in px
     * @param string $fileName
     * @param string $name for the alt tag
     * @param int $id std: -1 if the picture isn't in the db yet
     */
    public function __construct(int $size, int $height, int $width, string $fileName, string $name, int $id = -1)
    {
        $this->size = $size;
        $this->height = $height;
        $this->width = $width;
        $this->id = $id;
        $this->src = $fileName;
        $this->name = $name;
    }

    /**
     * @throws Exception
     */
    public function sendToDB()
    {
        if ($this->id > -1) throw new Exception("Dieses Bild ist bereits in der Datenbank");

        $conn = new DB_Connection();
        $conn->connect();

        $conn->doQuery("INSERT INTO picture (url, name, sizeKB, height, width) VALUES ('".$this->src
            ."', '".$this->name."', ".$this->size
            .", ".$this->height.", ".$this->width.")");

        $res = $conn->doQuery("SELECT ID FROM picture WHERE 1 ORDER BY ID DESC"); // Gets the last ID
        $this->id = $res->fetch_assoc()['ID'];

    }

    /**
     * @throws Exception
     */
    public function deleteFormDB()
    {
        if ($this->id == -1) throw new Exception("Dieses Bild ist nicht in der Datenbank");

        $conn = new DB_Connection();
        $conn->connect();

        $conn->doQuery("DELETE FROM picture WHERE ID = ". $this->id);

        $this->id = -1;
    }

    public function __toString()
    {
        return "<img class='content-img' src='".uploadDir.$this->src."' id='img-".$this->id."' alt='".$this->name."'>";
    }

    /**
     * @return string
     */
    public function getSrc(): string
    {
        return $this->src;
    }

    /**
     * @return int
     */
    public function getId(): int
    {
        return $this->id;
    }
}