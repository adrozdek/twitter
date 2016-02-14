<?php

class Friend {
    static private $connection = null;

    static public function SetConnection(mysqli $newConnection) {
        Friend::$connection = $newConnection;
    }

    static public function CreateFriendship($friend1, $friend2) {
        $sql = "INSERT INTO Friends(friend1_id, friend2_id, accepted) VALUES($friend1, $friend2, 0)";
        $result = self::$connection->query($sql);

        if($result == true) {
            $newFriendship = new Friend(self::$connection->insert_id, $friend1, $friend2, 0);
            return $newFriendship;
        } else{
            return false;
        }

    }



    private $id;
    private $friend1;
    private $friend2;
    private $accepted;

    public function __construct($id, $friend1, $friend2, $accepted) {
        $this->id = $id;
        $this->friend1 = intval($friend1);
        $this->friend2 = intval($friend2);
        $this->accepted = $accepted;
    }

    public function getAccepted()
    {
        return $this->accepted;
    }

    public function getFriend1()
    {
        return $this->friend1;
    }

    public function getFriend2()
    {
        return $this->friend2;
    }

    public function getId()
    {
        return $this->id;
    }




}



?>