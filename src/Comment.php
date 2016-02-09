<?php

/*
CREATE TABLE Comments(
    id INT AUTO_INCREMENT,
    tweet_id INT NOT NULL,
    user_id INT NOT NULL,
    comment_text VARCHAR(60) NOT NULL,
    comment_date DATETIME NOT NULL,
    PRIMARY KEY (id),
    FOREIGN KEY (tweet_id) REFERENCES Tweets(id) ON DELETE CASCADE,
    FOREIGN KET (user_id) REFERENCES Users(id)
    );
*/

class Comment {
    static private $connection = null;

    static public function SetConnection(mysqli $newConnection) {
        Comment::$connection = $newConnection;
    }

    static public function CreateComment($commentText) {
        $userId = $_SESSION['userId'];
        $commentDate = date('Y-m-d H:i:s T', time());
        $tweetId = $_GET['id'];

        $sql = "INSERT INTO Comments(tweet_id, user_id, comment_text, comment_date) VALUES($tweetId, $userId, '$commentText', '$commentDate')";
        $result = self::$connection->query($sql);

        if ($result !== FALSE) {
            $newComment = new Comment(self::$connection->insert_id, $tweetId, $userId, $commentText, $commentDate);
            return $newComment;
        }
        return FALSE;
    }

    static public function LoadCommentById($id) {
        $sql = "SELECT * FROM Comments WHERE id = $id";
        $result = self::$connection->query($sql);

        if ($result !== FALSE) {
            if ($result->num_rows === 1) {
                $row = $result->fetch_assoc();
                $newComment = new Comment($row['id'], $row['tweet_id'], $row['user_id'], $row['comment_text'], $row['comment_date']);
                return $newComment;
            }
        }
        return FALSE;
    }

    private $id;
    private $tweetId;
    private $userId;
    private $commentText;
    private $commentDate;

    public function __construct($id, $tweetId, $userId, $commentText, $commentDate){
        $this->setCommentText($commentText);
        $this->setCommentDate($commentDate);
        $this->id = intval($id);
        $this->tweetId = $tweetId;
        $this->userId = $userId;
    }

    public function getCommentDate() {
        return $this->commentDate;
    }

    public function getCommentText() {
        return $this->commentText;
    }

    public function getId() {
        return $this->id;
    }

    public function getTweetId() {
        return $this->tweetId;
    }

    public function getUserId() {
        return $this->userId;
    }

    public function setCommentText($newCommentText) {
        if(strlen($newCommentText) > 0) {
            $this->commentText = $newCommentText;
        }
    }

    public function setCommentDate($newCommentDate) {
        $this->commentDate = $newCommentDate;
    }


}


?>

