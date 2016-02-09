<?php

require_once("./src/connections.php");


if (isset($_SESSION['userId']) !== TRUE) {
    header("Location: login.php");
}

$allUsers = User::GetAllUsers();

foreach($allUsers as $userToShow){
    echo("<h1>{$userToShow->getName()}</h1>");
    echo($userToShow->getDescription() . "<br />");
    echo("<a href='showUser.php?userId={$userToShow->getId()}'>Show</a> <br>");
    //KLAMRY !!!
}






?>