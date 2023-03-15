<?php
class Post {
    private int $id;
    private string $filename;
    private string $timestamp;
    private string $tytul;
     
    function __construct(int $i, string $f, string $t, string $l)
    {
        $this->id = $i;
        $this->filename = $f;
        $this->timestamp =$t;
        $this->tytul =$l;
    }

    public function getFilename() : string{
        return $this->filename;
    }

    public function getTimestamp() : string{
        return $this->timestamp;
    }
    public function getTytul() : string{
        return $this->tytul;
    }


    static function getPage(int $pageNumber = 1, int $postsPerPage = 10) : array {
        global $db;
        $query = $db->prepare("SELECT * FROM coś ORDER BY timestamp DESC LIMIT ? OFFSET ?");
        $offset = ($pageNumber-1)*$postsPerPage;
        $query->bind_param('ii', $postsPerPage, $offset);
        $query->execute();
        $result = $query->get_result();
        $postsArray = array();
        while($row = $result->fetch_assoc()) {
            $post = new Post($row['id'],$row['filename'],$row['timestamp'],$row['tytul']);
            array_push($postsArray, $post);
        }
        return $postsArray;
    }


    static function getLast(): Post {
        global $db;
        $query = $db->prepare("SELECT * FROM coś ORDER BY timestamp DESC LIMIT 1");
        $query->execute();
        $result = $query->get_result();
        $row =$result->fetch_assoc();
        $p = new Post($row['id'], $row['filename'], $row['timestamp'],$row['tytul']);
        return $p;


    }

    static function upload(string $tempFileName) {
        $targetDir = "img/";

        $imgInfo = getimagesize($tempFileName);
        if(!is_array($imgInfo)) {
            die("BŁĄD: Przekazany plik nie jest obrazem!");
        }
        $randomNumber = rand(10000, 99999) . hrtime(true);
        $hash = hash("sha256", $randomNumber);
        $newFileName = $targetDir . $hash. ".webp";
        $newTytul = "1";
        if(file_exists($newFileName)) {
        die("BŁĄD: Podany plik już istnieje!");
        }

        $imageString = file_get_contents($tempFileName);

        $gdImage = @imagecreatefromstring($imageString);
        imagewebp($gdImage, $newFileName);

        global $db;
        
        
        $query = $db->prepare("INSERT INTO coś VALUES(NULL, ?, ?, ?)");

        $dbTimestamp = date("Y-m-d H:i:s");
        $query->bind_param("sss", $dbTimestamp, $newFileName,$newTytul);

        if(!$query->execute())

            die("Błąd zapisu do bazy danych");

    }
        


    
}

?>