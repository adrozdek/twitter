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

class User
{
    static private $connection = null;

    static public function SetConnection(mysqli $newConnection)
    {
        User::$connection = $newConnection;
    }

    static public function RegisterUser($newName, $newEmail, $password1, $password2, $newDescription)
    {
        if ($password1 !== $password2) {
            return false;
        }

        $options = [
            'cost' => 11,
            'salt' => mcrypt_create_iv(22, MCRYPT_DEV_URANDOM)
        ];
        $hashedPassword = password_hash($password1, PASSWORD_BCRYPT, $options);

        $sql = "INSERT INTO Users(name, email, password, description) VALUES ('$newName', '$newEmail', '$hashedPassword', '$newDescription')";

        $result = self::$connection->query($sql);
        if ($result === TRUE) {
            $newUser = new User(self::$connection->insert_id, $newName, $newEmail, $newDescription);
            return $newUser;
        }
        return false;
    }

    static public function LogInUser($email, $password)
    {
        $sql = "SELECT * FROM Users WHERE email LIKE '$email'";
        $result = self::$connection->query($sql);

        if ($result !== FALSE) {
            if ($result->num_rows === 1) {
                $row = $result->fetch_assoc();     //wyciągnięcie pierwszego rzędu z całej zwróconej tablicy(u nas jeden rząd)
                $isPasswordOK = password_verify($password, $row['password']);

                if ($isPasswordOK === TRUE) {
                    $user = new User($row['id'], $row['name'], $row['email'], $row['description']);
                    return $user;
                }
            }
        }
        return false;
    }

    static public function GetUserById($idToLoad)
    {
        $sql = "SELECT * FROM Users where id = $idToLoad";
        $result = self::$connection->query($sql);

        if ($result !== FALSE) {
            if ($result->num_rows === 1) {
                $row = $result->fetch_assoc();
                $user = new User($row['id'], $row['name'], $row['email'], $row['description']);
                return $user;

            }
        }
        return false;
    }

    static public function GetAllUsers()
    {
        $ret = [];
        $sql = "SELECT * FROM Users";
        $result = self::$connection->query($sql);

        if ($result !== FALSE) {
            if ($result->num_rows > 0) {
                while ($row = $result->fetch_assoc()) {
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

    public function __construct($newId, $newName, $newEmail, $newDescription)
    {
        $this->id = intval($newId);
        $this->email = $newEmail;
        $this->name = $newName;
        $this->setDescription($newDescription);
    }

    public function getId()
    {
        return $this->id;
    }

    public function getName()
    {
        return $this->name;
    }

    public function getEmail()
    {
        return $this->email;
    }

    public function getDescription()
    {
        return $this->description;
    }

    public function setDescription($newDescription)
    {
        if (strlen($newDescription) > 0) {
            return ($this->description = $newDescription);
        } else {
            return false;
        }
    }

    public function changePassword($oldpassword, $newPassword1, $newPassword2)
    {

        $sql = "SELECT * FROM Users WHERE id=$this->id";
        $result = self::$connection->query($sql);

        if ($result !== FALSE) {
            if ($result->num_rows === 1) {
                $row = $result->fetch_assoc();     //wyciągnięcie pierwszego rzędu z całej zwróconej tablicy(u nas jeden rząd)
                $isPasswordOK = password_verify($oldpassword, $row['password']);

                if ($isPasswordOK === TRUE) {

                    if ($newPassword1 !== $newPassword2) {
                        echo("Nieprawidłowe dane");
                        return false;
                    }

                    $options = [
                        'cost' => 11,
                        'salt' => mcrypt_create_iv(22, MCRYPT_DEV_URANDOM)
                    ];

                    $hashedPassword = password_hash($newPassword1, PASSWORD_BCRYPT, $options);

                    $sql2 = "UPDATE Users SET password='$hashedPassword' WHERE id=$this->id";
                    $result = self::$connection->query($sql2);

                    if ($result == true) {
                        return true;
                    } else {
                        return false;
                    }
                }
                return false;
            }
        } else {
            return false;
        }
        return false;
    }

    public function changeDescription($newDescription)
    {
        $this->setDescription($newDescription);

        $sql = "UPDATE Users SET description ='$this->description' WHERE id=$this->id";
        $result = self::$connection->query($sql);
        if ($result === TRUE) {
            return TRUE;
        }
        return false;
    }

    public function loadAllTweets()
    {
        $ret = [];

        $sql = "SELECT * FROM Tweets WHERE user_id = $this->id ORDER BY tweet_date DESC";
        $result = self::$connection->query($sql);

        if ($result !== FALSE) {
            if ($result->num_rows > 0) {
                while ($row = $result->fetch_assoc()) {
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

    public function loadAllSentMessages()
    {
        $ret = [];

        $sql = "SELECT * FROM Messages WHERE send_id=$this->id ORDER BY message_date DESC";
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

    public function loadAllReceivedMessages()
    {
        $ret = [];

        $sql = "SELECT * FROM Messages WHERE receive_id=$this->id ORDER BY message_date DESC";
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

    public function checkIfYouAskedFS($friend2)
    {
        $sql = "SELECT * FROM Friends WHERE friend1_id = $this->id AND friend2_id = $friend2";
        $result = self::$connection->query($sql);

        if ($result == true) {
            if ($result->num_rows != 0) {
                return true;
            } else {
                return false;
            }
        } else {
            return false;
        }

    }

    public function checkIfFriendshipExist($friend2)
    {
        //do zmiany w jedno zapytanie:
        $sql = "SELECT * FROM Friends WHERE (friend1_id = $this->id AND friend2_id = $friend2 AND accepted = 1) OR (friend2_id = $this->id AND friend1_id = $friend2 AND accepted = 1)";
        $result = self::$connection->query($sql);

        if ($result == true) {
            if ($result->num_rows != 0) {
                return true;
            } else {
                return false;
            }
        } else {
            return false;
        }
    }

    public function acceptFriendship($friendAsking)
    {
        $sql = "UPDATE Friends SET accepted = 1 WHERE friend2_id = $this->id AND friend1_id = $friendAsking";
        $result = self::$connection->query($sql);

        if ($result == true) {
            return true;
        } else {
            return false;
        }
    }

    public function removeFriendship($friendAsking)
    {
        $sql = "DELETE FROM Friends WHERE (friend1_id = $this->id AND friend2_id = $friendAsking) OR (friend1_id = $friendAsking AND friend2_id = $this->id) ";
        $result = self::$connection->query($sql);

        if ($result == true) {
            return true;
        } else {
            return false;
        }

    }

    public function getAllFriends()
    {
        $sql = "SELECT * FROM Users JOIN Friends ON Friends.friend2_id = Users.id WHERE Friends.friend1_id = $this->id AND Friends.accepted = 1 ORDER BY Users.name ASC";
        //ważne, że accepted = 1. chcemy tylko potwierdzonych przyjaciół.
        $result = self::$connection->query($sql);

        if ($result == true) {
            $ret = [];
            if ($result->num_rows > 0) {
                while ($row = $result->fetch_assoc()) {
                    //var_dump($row);
                    $user = new User($row['friend2_id'], $row['name'], $row['email'], $row['description']);
                    //friend2_id, bo chcemy id usera, który jest przyjacielem, a nie id z Friends !! (var_dump($row)
                    $ret[] = $user;
                    //var_dump($user);
                }
                return $ret;
            }
        } else {
            return false;
        }

    }

    public function getAllFriendsAndMineTweets()
    {
        $sql = "SELECT * FROM Tweets JOIN Friends ON Tweets.user_id = Friends.friend2_id OR Tweets.user_id = $this->id WHERE Friends.friend1_id = $this->id AND Friends.accepted = 1 ORDER BY Tweets.tweet_date DESC";
        $result = self::$connection->query($sql);

        if ($result == true) {
            $ret = [];
            if ($result->num_rows > 0) {
                while ($row = $result->fetch_assoc()) {
                    //var_dump($row);
                    $tweet = new Tweet($row['id'], $row['user_id'], $row['tweet_text'], $row['tweet_date']);
                    $ret[] = $tweet;
                    //var_dump($tweet);
                }
                return $ret;
            }
        } else {
            return false;
        }

    }

    public function getAllInvitation()
    {
        $sql = "SELECT * FROM Users JOIN Friends ON Friends.friend1_id = Users.id WHERE Friends.friend2_id = $this->id AND Friends.accepted = 0";
        $result = self::$connection->query($sql);

        if ($result == true) {
            $ret = [];
            if ($result->num_rows > 0) {
                while ($row = $result->fetch_assoc()) {
                    //var_dump($row);
                    $user = new User($row['friend1_id'], $row['name'], $row['email'], $row['description']);
                    //friend2_id, bo chcemy id usera, który jest przyjacielem, a nie id z Friends !! (var_dump($row)
                    $ret[] = $user;
                    //var_dump($user);
                }
                return $ret;
            }
        } else {
            return false;
        }


    }

    public function getAllSentInvitation()
    {
        $sql = "SELECT * FROM Users JOIN Friends ON Friends.friend2_id = Users.id WHERE Friends.friend1_id = $this->id AND Friends.accepted = 0";
        $result = self::$connection->query($sql);

        if ($result == true) {
            $ret = [];
            if ($result->num_rows > 0) {
                while ($row = $result->fetch_assoc()) {
                    //var_dump($row);
                    $user = new User($row['friend2_id'], $row['name'], $row['email'], $row['description']);
                    //friend2_id, bo chcemy id usera, który jest przyjacielem, a nie id z Friends !! (var_dump($row)
                    $ret[] = $user;
                    //var_dump($user);
                }
                return $ret;
            }
        } else {
            return false;
        }


    }


}


?>