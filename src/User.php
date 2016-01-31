<?php

/*
 CREATE TABLE Users(
    id int AUTO_INCREMENT,
    name varchar(255),
    email varchar(255) UNIQUE,
    password char(60),
    description varchar(255),
    PRIMARY KEY (id)
);
 */

class User{
    static private $connection = null;

    static public function SetConnection(mysqli $newConnection){
        User::$connection = $newConnection;
    }

    static public function RegisterUser($newName, $newEmail, $password1, $password2, $newDescription){
        if($password1 !== $password2){
            return false;
        }

        $options = [
            'cost' => 11,
            'salt' => mcrypt_create_iv(22, MCRYPT_DEV_URANDOM)
        ];
        $hashedPassword = password_hash($password1, PASSWORD_BCRYPT, $options);

        $sql = "INSERT INTO Users(name, email, password, description) VALUES ('$newName', '$newEmail', '$hashedPassword', '$newDescription')";

        $result = self::$connection->query($sql);
        if($result === TRUE){
            $newUser = new User(self::$connection->insert_id, $newName, $newEmail, $newDescription);
            return $newUser;
        }
        return false;
    }
    static public function LogInUser($email, $password){
        $sql = "SELECT * FROM Users WHERE email LIKE '$email'";
        $result = self::$connection->query($sql);

        if($result !== FALSE){
            if($result->num_rows === 1){
                $row = $result->fetch_assoc();     //wyciągnięcie pierwszego rzędu z całej zwróconej tablicy(u nas jeden rząd)
                $isPasswordOK = password_verify($password, $row['password']);

                if($isPasswordOK === TRUE){
                    $user = new User($row['id'], $row['name'], $row['email'], $row['description']);
                    return $user;
                }
            }
        }
        return false;
    }
    static public function GetUserById($idToLoad){
        $sql = "SELECT * FROM Users where id = $idToLoad";
        $result = self::$connection->query($sql);

        if($result !== FALSE){
            if($result->num_rows === 1){
                $row = $result->fetch_assoc();
                $user = new User($row['id'], $row['name'], $row['email'], $row['description']);
                return $user;

            }
        }
        return false;
    }
    static public function GetAllUsers(){
        $ret = [];
        $sql = "SELECT * FROM Users";
        $result = self::$connection->query($sql);

        if($result !== FALSE){
            if($result->num_rows > 0){
                while($row = $result->fetch_assoc()){
                    $user = new User($row['id'], $row['name'], $row['email'], $row['description']);
                    $ret[] = $user;
                }
            }
        }
        return $ret;
    }

    private $id;
    private $name;
    private $email;
    private $description;

    public function __construct($newId, $newName, $newEmail, $newDescription){
        $this->id = intval($newId);
        $this->email = $newEmail;
        $this->name = $newName;
        $this->setDescription($newDescription);
    }
    public function getId(){
        return $this->id;
    }
    public function getName(){
        return $this->name;
    }
    public function getEmail(){
        return $this->email;
    }
    public function getDescription(){
        return $this->description;
    }
    public function setDescription($newDescription){
        if(is_string($newDescription)){
            $this->description = $newDescription;
        }
    }

    public function saveToDB(){
        $sql = "UPDATE Users SET description ='$this->description' WHERE id = $this->id";
        $result = self::$connection->query($sql);
        if($result === TRUE){
            return TRUE;
        }
        return FALSE;
    }

    public function loadAllTweets(){
        $ret = [];

        if(isset($_GET["userId"])){
            $userId = $_GET["userId"];
        }
        else{
            $userId = $_SESSION["userId"];
        }

        $sql = "SELECT * FROM Tweets WHERE  user_id = $userId ORDER BY tweet_date DESC";
        $result = self::$connection->query($sql);

        if($result !== FALSE){
            if($result->num_rows > 0){
                while($row = $result->fetch_assoc()) {
                    $tweet = new Tweet($row['id'], $row['user_id'], $row['tweet_text'], $row['tweet_date']);
                    //var_dump($tweet);
                    //echo($tweet->getTweetText());
                    $ret[] = $tweet;
                }
            }
        }
        //var_dump($ret);
        return $ret;

        // TODO: Finis this function
        // TODO: It should return table of Tweets created by this user (date DESC)

    }
    public function loadAllSentMessages(){
        $ret = [];
        // TODO: Finis this function
        // TODO: It should return table of Messages sent by this user (date DESC)

        return $ret;
    }
    public function loadAllReceivedMessages(){
        $ret = [];
        // TODO: Finis this function
        // TODO: It should return table of Messages this user got(date DESC)

        return $ret;
    }

}

?>