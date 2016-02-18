<?php

require_once("./src/connections.php");


if (isset($_SESSION['userId']) !== TRUE) {
    header("Location: login.php");
}
$userSessionId = $_SESSION['userId'];
$allUsers = User::GetAllUsers();

foreach($allUsers as $userToShow){
    echo("<h1>{$userToShow->getName()} </h1>");

    $friendToUser = User::GetUserById($userSessionId);
    if($friendToUser->checkIfFriendshipExist($userToShow->getId())) {
        echo("<h3>Przyjaciel :)</h3>");
    }
    elseif($userToShow->checkIfYouAskedFS($userSessionId)) {
        echo("<h4>Czeka na Twoją akceptację</h4>");
    }
    elseif($friendToUser->checkIfYouAskedFS($userToShow->getId())) {
        echo("<h4>Wysłałeś prośbę o przyjaźń</h4>");
    }


    echo($userToShow->getDescription() . "<br />");
    echo("<a href='showUser.php?userId={$userToShow->getId()}'>Pokaż</a> <br>");
    //KLAMRY !!
    echo("<hr />");
}






?>