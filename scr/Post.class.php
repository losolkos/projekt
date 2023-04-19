<?php
class Post {
    private int $id;
    private string $filename;
    private string $timestamp;
    private string $tytul;
    private string $autorName;
    private int $autor;

     
    function __construct(int $i, string $f, string $t, string $l, int $a )
    {
        $this->id = $i;
        $this->filename = $f;
        $this->timestamp = $t;
        $this->tytul = $l;
        $this->autor = $a;
        $this->autorName = User::getNameById($this->autor);
        global $db;
    }

    public function getId() : int {
        return $this->id;
    }

    public function getFilename() : string {
        return $this->filename;
    }

    public function getTimestamp() : string {
        return $this->timestamp;
    }

    public function getTytul() : string {
        return $this->tytul;
    }

    public function getAutorName() : string {
        return $this->autorName;
    }

    
    public static function getById(int $id) : ?Post {
        global $db;
        $query = $db->prepare("SELECT * FROM cos WHERE id = ?");
        $query->bind_param("i", $id);
        $query->execute();
        $result = $query->get_result();

        if($result->num_rows === 0) {
            return null;
        }
    }

    static function getPage(int $pageNumber = 1, int $postsPerPage = 10) : array {
        global $db;
        $query = $db->prepare("SELECT * FROM cos ORDER BY timestamp DESC LIMIT ? OFFSET ?");
        $offset = ($pageNumber-1)*$postsPerPage;
        $query->bind_param('ii', $postsPerPage, $offset);
        $query->execute();
        $result = $query->get_result();
        $postsArray = array();
        while($row = $result->fetch_assoc()) {
            $post = new Post($row['id'], $row['filename'], $row['timestamp'], $row['tytul'], $row['autor']);
            array_push($postsArray, $post);
        }
        return $postsArray;
    }


    static function getLast(): Post {
        global $db;
        $query = $db->prepare("SELECT * FROM cos ORDER BY timestamp DESC LIMIT 1");
        $query->execute();
        $result = $query->get_result();
        $row = $result->fetch_assoc();
        $p = new Post($row['id'], $row['filename'], $row['timestamp'], $row['tytul'], $row['autor']);
        return $p;
    }

    static function upload(string $tempFileName, string $tytul, string$autor) : void {
        $targetDir = "img/";
        $imgInfo = getimagesize($tempFileName);
        if(!is_array($imgInfo)) {
        die("BŁĄD: Przekazany plik nie jest obrazem!");
        }
        $randomNumber = rand(10000, 99999) . hrtime(true);
        $hash = hash("sha256", $randomNumber);
        $newFileName = $targetDir . $hash. ".webp";
        $newTytul = $tytul;
        if(file_exists($newFileName)) {
        die("BŁĄD: Podany plik już istnieje!");
        }
        $imageString = file_get_contents($tempFileName);

        $gdImage = @imagecreatefromstring($imageString);
        imagewebp($gdImage, $newFileName);
    
        global $db;
        
        $query = $db->prepare("INSERT INTO cos VALUES(NULL, ?, ?, ?, ? )");
    
        $dbTimestamp = date("Y-m-d H:i:s");
        $query->bind_param("sssi", $dbTimestamp, $newFileName, $newTytul, $autor);
    
        if(!$query->execute()) {
            die("Błąd zapisu do bazy danych");
        }
    }
    
    public static function remove(int $id) : bool {
        global $db;
        $query = $db->prepare("UPDATE cos SET removed = 1 WHERE id = ?");
        $query->bind_param("i", $id);
        return $query->execute();
    }
}


?>
