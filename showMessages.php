<?php

require_once("./src/connections.php");

if (isset($_SESSION['userId']) !== TRUE) {
    header("Location: login.php");
}

$userId = $_SESSION['userId'];

echo("<h1>Wiadomości</h1>");

echo("<h2>Odebrane:</h2>");

$user = User::GetUserById($userId);

foreach(User::LoadAllReceivedMessages() as $message) {
    $u = $message->getSendId();

    $sendingUser = User::GetUserById($u);


    echo("<h3>Nadawca: {$sendingUser->getName()}</h3>");
    $beginning = substr($message->getMessageText(), 0, 30); //pierwsze 30 znaków wiadomości

    if(strlen($message->getMessageText()) <= 30) {    //jeśli wiadomość jest dłuższa niż 30 znaków pokaż dodatkowo(...)
        echo("$beginning <br />");
    }
    else{
        echo($beginning . "(...) <br />");
    }

    echo("{$message->getMessageDate()} <br />");

    if($message->getOpened() == 1){              //sprawdzenie statusu odczytania
        echo("Status: Nieodczytana <br />");
    }
    else{
        echo("<strong>Status: </strong>Odczytana <br />");
    }

    echo("<a href='showMessage.php?id={$message->getId()}'>Pokaż wiadomość</a>");  //przekierowanie do strony konkretnej wiadomości

}



    echo("<h2>Wysłane:</h2>");

foreach(User::LoadAllSentMessages() as $message){
    $u = $message->getReceiveId();

    $receivingUser = User::GetUserById($u);
    $beginning = substr($message->getMessageText(), 0, 30);

    echo("<h3>Odbiorca: {$receivingUser->getName()}</h3>");

    if(strlen($message->getMessageText()) < 30) {
        echo("$beginning <br />");
    }
    else{
        echo($beginning . "(...) <br />");
    }

    echo("{$message->getMessageDate()} <br />");

    if($message->getOpened() == 1){
        echo("Status: Nieodczytana <br />");
    }
    else{
        echo("<strong>Status: </strong>Odczytana <br />");
    }

    echo("<a href='showMessage.php?id={$message->getId()}'>Pokaż wiadomość</a>");
}









?>