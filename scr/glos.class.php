<?php
class Vote {
    private int $upVotes;
    private int $downVotes;
    private int $userID;
    private int $postId;
    private int $id;

    public function __construct(int $id, int $upVotes, int $downVotes, int $userID, int $postId) {
        $this->id = $id;
        $this->upVotes = $upVotes;
        $this->downVotes = $downVotes;
        $this->userID = $userID;
        $this->postId = $postId;
        global $db;
    }

    public function upVote() : void {
        $this->upVotes++;
        global $db;
        $query = $db->prepare("UPDATE glos SET up_votes = up_votes + 1 WHERE id = ?");
        $query->bind_param("i", $this->id);
        $query->execute();
    }
    
    public function downVote() : void {
        $this->downVotes++;
        global $db;
        $query = $db->prepare("UPDATE glos SET down_votes = down_votes + 1 WHERE id = ?");
        $query->bind_param("i", $this->id);
        $query->execute();
    }
    public static function getById(int $id) : ?Post {
        global $db;
        $query = $db->prepare("SELECT * FROM glos WHERE id = ?");
        $query->bind_param("i", $id);
        $query->execute();
        $result = $query->get_result();
        if($result->num_rows === 0) {
            return null;
        }
        $row = $result->fetch_assoc();
        return new Post($row["id"], $row["up_votes"], $row["down_votes"], $row["user_id"], $row["post_id"]);
    }
    
}
?>