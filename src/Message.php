<?php

/*CREATE TABLE Messages(
    id INT AUTO_INCREMENT,
    send_id INT NOT NULL,
    receive_id INT NOT NULL,
    message_text VARCHAR(200) NOT NULL,
    message_date DATETIME NOT NULL,
    PRIMARY KEY(id),
    FOREIGN KEY (send_id) REFERENCES Users(id),
    FOREIGN KEY (recieve_id) REFERENCES Users(id)
    );
*/

class Message {
    static private $connection = null;

    static public function SetConnection(mysqli $newConnection) {
        Message::$connection = $newConnection;
    }

    static public function CreateMessage($sendId, $receiveId, $messageText) {
        $messageDate = date('Y-m-d H:i:s', time());
        $opened = 1;
        $sql = "INSERT INTO Messages(send_id, receive_id, message_text, message_date, opened) VALUES ('$sendId', '$receiveId', '$messageText', '$messageDate', '$opened')";
        $result = self::$connection->query($sql);

        if ($result === TRUE) {
            $newMessage = new Message(self::$connection->insert_id, $sendId, $receiveId, $messageText, $messageDate, $opened);
            return $newMessage;
        }
        return FALSE;
    }

    static public function LoadMessageById($id) {

        $sql = "SELECT * FROM Messages where id = $id";
        $result = self::$connection->query($sql);
        if ($result !== FALSE) {
            if ($result->num_rows === 1) {
                $row = $result->fetch_assoc();
                $newMessage = new Message($row['id'], $row['send_id'], $row['receive_id'], $row['message_text'], $row['message_date'], $row['opened']);
                return $newMessage;
            }
        }
        return false;

    }

    private $id;
    private $sendId;
    private $receiveId;
    private $messageText;
    private $messageDate;
    private $opened;

    public function __construct($id, $sendId, $receiveId, $messageText, $messageDate, $opened) {
        $this->id = intval($id);
        $this->sendId = $sendId;
        $this->receiveId = $receiveId;
        $this->setMessageDate($messageDate);
        $this->setMessageText($messageText);
        $this->setOpened($opened);
    }


    public function getId() {
        return $this->id;
    }

    public function getSendId() {
        return $this->sendId;
    }

    public function setSendId($sendId) {
        if(is_int($sendId)) {
            $this->sendId = $sendId;
        }
    }

    public function getReceiveId() {
        return $this->receiveId;
    }

    public function setReceiveId($receiveId) {
        if(is_int($receiveId)) {
            $this->receiveId = $receiveId;
        }
    }

    public function getOpened() {
        return $this->opened;
    }

    public function setOpened($opened) {
        if($opened == 1 || $opened == 0) {
            $this->opened = $opened;
        }
    }

    public function getMessageText() {
        return $this->messageText;
    }

    public function setMessageText($messageText) {
        if(strlen($messageText) > 0) {
            return($this->messageText = $messageText);
        }
        return false;
    }

    public function getMessageDate() {
        return $this->messageDate;
    }

    public function setMessageDate($messageDate) {
        return($this->messageDate = $messageDate);
    }

    public function updateOpened() {
        $sql = "UPDATE Messages SET opened=0 WHERE id=$this->id";
        $result = self::$connection->query($sql);
        if ($result == TRUE) {
            return true;
        } else {
            return false;
        }
    }

}

?>

