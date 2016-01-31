<?php

require_once("./src/connections.php");

$allUsers = User::GetAllUsers();

foreach($allUsers as $userToShow){
    echo("<h1>{$userToShow->getName()}</h1>");
    echo("<a href='showUser.php?userId={$userToShow->getId()}'>Show</a> <br>");
    //KLAMRY !!!
}






?>