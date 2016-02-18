<?php

require_once("./src/connections.php");

if (isset($_SESSION['userId']) !== TRUE) {
    header("Location: login.php");
}

$userId = $_SESSION['userId'];

$user = User::GetUserById($userId);

$allFriends = $user->getAllFriends();

echo("<h1>Przyjaciele: </h1>");

foreach($allFriends as $userToShow){
    //var_dump($userToShow);
    echo("<h2>{$userToShow->getName()} </h2>");

    echo($userToShow->getDescription() . "<br />");
    echo("<a href='showUser.php?userId={$userToShow->getId()}'>Pokaż</a> <br>");
    echo("<a href='addFriend.php?id={$userToShow->getId()}'>Usuń przyjaciela</a><br/>");

    echo("<hr /><br>");
}

echo("<h1>Zaakceptuj lub odrzuć zaproszenia: </h1>");

$usersToAccept = $user->getAllInvitation();

foreach($usersToAccept as $userToShow){
    //var_dump($userToShow);
    echo("<h2>{$userToShow->getName()} </h2>");

    echo($userToShow->getDescription() . "<br />");
    echo("<a href='showUser.php?userId={$userToShow->getId()}'>Pokaż profil</a> <br>");
    echo("<a href='addFriend.php?id={$userToShow->getId()}'>Potwierdź zaproszenie</a><br/>");
    echo("<a href='addFriend.php?idR={$userToShow->getId()}'>Usuń zaproszenie</a>");

    echo("<hr /><br>");
}

echo("<h1>Anuluj zaproszenia: </h1>");

$usersToCancel = $user->getAllSentInvitation();

foreach($usersToCancel as $userToShow){
    //var_dump($userToShow);
    echo("<h2>{$userToShow->getName()} </h2>");

    echo($userToShow->getDescription() . "<br />");
    echo("<a href='showUser.php?userId={$userToShow->getId()}'>Pokaż profil</a> <br>");
    echo("<a href='addFriend.php?id={$userToShow->getId()}'>Potwierdź zaproszenie</a><br/>");
    echo("<a href='addFriend.php?idR={$userToShow->getId()}'>Usuń zaproszenie</a>");

    echo("<hr />");
}





?>