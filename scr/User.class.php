<?php
class User {
    private $id;
    private $emeil;

    public function _construct($emeil, $id ){
        $this->emeil = $emeil;
        $this->id = $id;

    }
    public function getID() : string{
        return $this->id;
    }

    public function getName() : string{
        return $this->emeil;
    }
    public static function getNameById(int $id){
        global $db;
        $query = $db->prepare("SELECT emeil FROM user WHERE id = ? LIMIT 1");
        $query->bind_param('i', $id);
        $query->execute();
        $result = $query->get_result();
        $row = $result->fetch_assoc();
        return $row['emeil'];

    }

    public static function register(string $emeil, string $password): bool {
        global $db;
        $query = $db->prepare("INSERT INTO user VALUES (NULL, ?, ?)");
        $passwordHash = password_hash($password, PASSWORD_ARGON2I);
        $query->bind_param("ss", $emeil, $passwordHash);
        return $query->execute();
    }

    public static function login(string $emeil, string $password) {
        global $db;
        $query = $db->prepare("SELECT * FROM user WHERE emeil = ? LIMIT 1");
        $query->bind_param("s", $emeil);
        $query->execute();
        $result = $query->get_result();
        $row = $result->fetch_assoc();
        $passwordHash = $row['password'];
        if(password_verify($password, $passwordHash)){
            $u = new User($row['id'],$emeil);
            $_SESSION['user'] = $u;

        }

    }
    public static function isAuth() : bool {
        //funkcja zwraca true jeśli użytkownik jest zalogowany
        if(isset($_SESSION['user'])) {
            if($_SESSION['user'] instanceof User) {
                return true;
            } else {
                return false;
            }
        } else {
            return false;
        }
    }
}

?>