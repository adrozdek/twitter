<?php

require_once("./src/connections.php");

if (isset($_SESSION['userId']) !== TRUE) {
    header("Location: login.php");
}

$messageId = $_GET['id'];
//var_dump(Message::LoadMessageById($messageId));
$messageToShow = Message::LoadMessageById($messageId);

if ($messageToShow->getSendId() == $_SESSION['userId'] || $messageToShow->getReceiveId() == $_SESSION['userId']) {
    //zagwarantowanie, że wiadomość może zobaczyć tylko wysyłający, bądź odbiorca

    $sendingUser = User::GetUserById($messageToShow->getSendId());
    $receiveingUser = User::GetUserById($messageToShow->getReceiveId());

//var_dump($receiveingUser);

    if ($_SESSION['userId'] == $messageToShow->getReceiveId()) {
        $messageToShow->updateOpened();
    }

//var_dump($sendingUser);

    echo("<strong> Odbiorca:</strong> {$receiveingUser->getName()} <br />
    <strong>Nadawca:</strong> {$sendingUser->getName()} <br />
    <strong>Treść: </strong> {$messageToShow->getMessageText()} <br />
    {$messageToShow->getMessageDate()} <br />");

    if ($_SESSION['userId'] != $messageToShow->getReceiveId()) {  //wysłanie kolejnej wiadomości do tego samego użytkownika
        echo("<a href='sendMessage.php?id={$receiveingUser->getId()}'>Wyślij kolejną wiadomość do {$receiveingUser->getName()}</a> <br />");
    }

    if ($_SESSION['userId'] != $messageToShow->getSendId()) {  //wysłanie odpowiedzi na wiadomość użytkownika
        echo("<a href='sendMessage.php?id={$sendingUser->getId()}'>Odpowiedz użytkownikowi {$sendingUser->getName()}</a> <br />");
    }

    echo("<a href='showMessages.php'>Wróć do wszystkich wiadomości</a>
    ");

//var_dump($_SESSION['userId']);      //int
//var_dump($receiveingUser->getId());  //int
//było 1 i 6, ale if działał na odwrót
//var_dump($messageToShow->getReceiveId()); //string


}


?>