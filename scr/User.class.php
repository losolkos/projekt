<?php
class User {
    private $emeil;

    public function _construct($emeil ){
        $this->emeil = $emeil;

    }

    public function getName() : string{
        return $this->emeil;
    }

    public static function register(string $emeil, string $password): bool {
        global $db;
        $query = $db->prepare("INSERT INTO user VALUES (NULL, ?, ?)");
        $passwordHash = password_hash($password, PASSWORD_ARGON2I);
        $query->bind_param("ss", $emeil, $password);
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
            $u = new User($emeil);
            $_SESSION['user'] = $u;

        }

    }
}

?>