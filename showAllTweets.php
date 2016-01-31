<?php

require_once("./src/connections.php");

if(isset($_SESSION['userId']) !== TRUE){
    header("Location: login.php");
}

$allTweets = Tweet::ShowAllTweets();

foreach($allTweets as $tweetToShow){
    echo("<h1>{$tweetToShow->getTweetText()}</h1>");
    echo("{$tweetToShow->getTweetDate()}<br>");
    echo("<a href='showTweet.php?id={$tweetToShow->getId()}'>Show</a> <br>");
    echo("asdasd");

}


?>