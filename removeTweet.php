<?php

require_once("./src/connections.php");

if (isset($_SESSION['userId']) !== TRUE) {
    header("Location: login.php");
}

    $id = $_GET['id'];

$tweetToRemove = Tweet::LoadTweetById($id);

if ($_SESSION['userId'] == $tweetToRemove->getUserId()) {

    if ($_SERVER['REQUEST_METHOD'] == 'POST') {
        $tweetToRemove->removeTweet();
        header("Location: showUser.php");
    }

    echo("
    <form method='POST'>
    <p>
    Jesteś pewny, że chcesz usunąć Tweeta?
    </p>
    <input type='submit' value='Usuń'>

    </form>
    ");
}
else{
    echo("Nie masz uprawnień!");
}
?>