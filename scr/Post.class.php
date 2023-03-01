<?php
class Post {
    static function upload(string $tempFileName) {
        $targetDir = "img/";
        //sprawdź czy mamy do czynienia z obrazem
        $imgInfo = getimagesize($tempFileName);
        if(!is_array($imgInfo)) {
            die("BŁĄD: Przekazany plik nie jest obrazem!");
        }
        $randomNumber = rand(10000, 99999) . hrtime(true);
        $hash = hash("sha256", $randomNumber);
        $newFileName = $targetDir . $hash. ".webp";
        //sprawdź czy plik przypadkiem już nie istnieje
        if(file_exists($tempFileName)) {
        die("BŁĄD: Podany plik już istnieje!");
        }
        //zaczytujemy cały obraz z folderu tymczasowego do stringa
        $imageString = file_get_contents($tempFileName);

        //generujemy obraz jako obiekt klasy GDImage
        //@ przed nazwa funkcji powoduje zignorowanie ostrzeżeń
        $gdImage = @imagecreatefromstring($imageString);

        global $db;

        $db = new mysqli('localhost', 'root', '', 'cms');
        $query = $db->prepare("INSERT INTO post VALUES(NULL, ?, ?)");
        $dbTimestamp = date("Y-m-d H:i:s");
        $query->bind_param("ss", $dbTimestamp, $hash);
        if(!$query->execute())
            die("Błąd zapisu do bazy danych");

        echo "Plik został poprawnie wgrany na serwer";
    }
        


    
}

?>