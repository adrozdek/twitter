<?php
/*
CREATE TABLE Tweets(
    id INT AUTO_INCREMENT,
    user_id INT,
    tweet_text VARCHAR(140) NOT NULL,
    post_date DATE NOT NULL,
    PRIMARY KEY(id),
    FOREIGN KEY (user_id) REFERENCES Users(id)
    ON DELETE CASCADE
    );
*/

class Tweet{
    static private $connection = null;

    static public function SetConnection(mysqli $newConnection){
        Tweet::$connection = $newConnection;
    }

    static public function CreateTweet($tweetText){
        $userId = $_SESSION["userId"];
        $tweetDate = date('Y-m-d H:i:s', time());  //!!!!!!
        $sql = "INSERT INTO Tweets(user_id, tweet_text, tweet_date) VALUES ($userId, '$tweetText', '$tweetDate')";
        $result = self::$connection->query($sql);

        if($result === TRUE){
            $newTweet = new Tweet(self::$connection->insert_id, $userId, $tweetText);
            return $newTweet;
        }
        echo("Nie udało się utworzyć tweeta :(");
        return false;
    }


    static public function LoadTweetById($id){
        $sql = "SELECT * FROM Tweets where id = $id";
        $result = self::$connection->query($sql);
        if($result !== FALSE){

            if($result->num_rows === 1){
                $row = $result->fetch_assoc();
                $newTweet = new Tweet($row['id'], $row['user_id'], $row['tweet_text'], $row['tweet_date']);
                return $newTweet;
            }


        }
        return false;
    }

    static public function ShowAllTweets(){
        $ret = [];
        $sql = "SELECT * FROM Tweets ORDER BY tweet_date DESC";
        $result = self::$connection->query($sql);

        if($result->num_rows > 0) {
            while($row = $result->fetch_assoc()) {
                $newTweet = new Tweet($row['id'], $row['user_id'], $row['tweet_text'], $row['tweet_date']);
                $ret[] = $newTweet;
            }
        }
        return $ret;
    }

    private $id;
    private $userId;
    private $tweetText;
    private $tweetDate;

    public function __construct($id, $userId, $tweetText, $tweetDate){
        $this->id = $id;
        $this->userId = $userId;
        $this->setTweetText($tweetText);
        $this->tweetDate = $tweetDate;
    }
/*
    public function setUserId($newUserId){
        $this->userId = $newUserId;
    }
*/
    public function setTweetText($newTweetText){
        if(is_string($newTweetText) && strlen(trim($newTweetText)) > 0) {
            $this->tweetText = $newTweetText;
        }
    }

    /*???
    public function setTweetDate($newTweetDate){
        $this->tweetDate = $newTweetDate;
    }
    */

    public function getId(){
        return $this->id;
    }

    public function getUserId(){
        return $this->userId;
    }

    public function getTweetText(){
        return $this->tweetText;
    }

    public function getTweetDate(){
        return $this->tweetDate;
    }

    public function updateTweetText(){
        $sql = "UPDATE Tweets SET tweet_text = '$this->tweetText' WHERE id = $this->id";
        $result = self::$connection->query($sql);
        if($result === TRUE) {
            return true;
        }
        return FALSE;
    }
/*
    public function showTweet(){

                        $newTweet = new Tweet($row['id'], $row['userId'], $row['tweetText'], $row['tweetDate']);
                return $newTweet;

    }

*/
    public function getAllComments(){
        //TODO:

    }


}



?>