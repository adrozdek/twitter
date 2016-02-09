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

    public static function ChangePassword($oldpassword, $newPassword1, $newPassword2){

        $userId = $_SESSION['userId'];
        $sql = "SELECT * FROM Users WHERE id=$userId";
        $result = self::$connection->query($sql);

        if($result !== FALSE) {
            if ($result->num_rows === 1) {
                $row = $result->fetch_assoc();     //wyciągnięcie pierwszego rzędu z całej zwróconej tablicy(u nas jeden rząd)
                $isPasswordOK = password_verify($oldpassword, $row['password']);

                if ($isPasswordOK === TRUE) {

                    if($newPassword1 !== $newPassword2){
                        echo("Nieprawidłowe dane");
                        return false;
                    }

                    $options = [
                        'cost' => 11,
                        'salt' => mcrypt_create_iv(22, MCRYPT_DEV_URANDOM)
                    ];

                    $hashedPassword = password_hash($newPassword1, PASSWORD_BCRYPT, $options);


                    $sql2 = "UPDATE Users SET password='$hashedPassword' WHERE id=$userId";
                    $result = self::$connection->query($sql2);

                    if($result == true){
                        echo("Hasło zostało zmienione <br />");
                        return true;
                    }
                    else{
                        echo("Nieprawidłowe dane");
                        return false;
                    }
                }
                echo("Nieprawidłowe dane");
                return false;
            }
        }
        else{
            echo("Nieprawidłowe dane");
            return false;
        }
        echo("Nieprawidłowe dane");
        return false;
    }

    public static function ChangeDescription($newDescription){
        if(is_string($newDescription)){
            $userId = $_SESSION['userId'];
            $sql = "UPDATE Users SET description ='$newDescription' WHERE id =$userId";
            $result = self::$connection->query($sql);
            if($result === TRUE){
                echo("Opis został zmieniony");
                return TRUE;
            }
            echo("Nie udało się zmienić opisu.");
            return false;
        }
        echo("Nie udało się zmienić opisu.");
        return false;
    }

    public static function LoadAllSentMessages(){
        $ret = [];
        $sentId = $_SESSION['userId'];

        $sql = "SELECT * FROM Messages WHERE send_id='$sentId' ORDER BY message_date DESC";
        $result = self::$connection->query($sql);

        if ($result !== FALSE) {
            if ($result->num_rows > 0) {
                while ($row = $result->fetch_assoc()) {
                    $message = new Message($row['id'], $row['send_id'], $row['receive_id'], $row['message_text'], $row['message_date'], $row['opened']);

                    $ret[] = $message;

                }
                //var_dump($ret);

                return $ret;
            }
        }
        return false;
    }

    public static function LoadAllReceivedMessages(){
        $ret = [];
        $receiveId = $_SESSION['userId'];

        $sql = "SELECT * FROM Messages WHERE receive_id= $receiveId ORDER BY message_date DESC";
        $result = self::$connection->query($sql);

        if ($result !== FALSE) {
            if ($result->num_rows > 0) {
                while ($row = $result->fetch_assoc()) {
                    $message = new Message($row['id'], $row['send_id'], $row['receive_id'], $row['message_text'], $row['message_date'], $row['opened']);

                    $ret[] = $message;

                }
                //var_dump($ret);

                return $ret;
            }
        }
        return false;
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
        if(strlen($newDescription) > 0){
            return $this->description = $newDescription;
        }
        else{
            echo("Nie udało się ustawić opisu");
        }
        return false;
    }


    public function loadAllTweets(){
        $ret = [];

        if(isset($_GET["userId"])){
            $userId = $_GET["userId"];
        }
        else{
            $userId = $_SESSION["userId"];
        }

        $sql = "SELECT * FROM Tweets WHERE user_id = $userId ORDER BY tweet_date DESC";
        $result = self::$connection->query($sql);

        if($result !== FALSE){
            if($result->num_rows > 0){
                while($row = $result->fetch_assoc()) {
                    $tweet = new Tweet($row['id'], $row['user_id'], $row['tweet_text'], $row['tweet_date']);    //zamiast id użytkownika mamy jego imię, można tak?
                    //var_dump($tweet);
                    //echo($tweet->getTweetText());
                    $ret[] = $tweet;
                }
            }
        }
        //var_dump($ret);
        return $ret;


    }




}

?>