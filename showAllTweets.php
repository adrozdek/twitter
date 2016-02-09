<?php

require_once("./src/connections.php");

if(isset($_SESSION['userId']) !== TRUE){
    header("Location: login.php");
}



$allTweets = Tweet::ShowAllTweets();

echo("<h1>Najnowsze tweety:</h1>");

foreach($allTweets as $tweetToShow){

    $userId = $tweetToShow->getUserId();
    $tweetingUser = User::GetUserById($userId);

    echo("<h2>{$tweetingUser->getName()}</h2>");
    if($_SESSION['userId'] != $userId){
        echo("<a href='showUser.php?userId=$userId'>Pokaż profil'</a> <br />");
    }
    echo("{$tweetToShow->getTweetText()} <br />");
    echo("{$tweetToShow->getTweetDate()}<br>");
    echo("<a href='showTweet.php?id={$tweetToShow->getId()}'>Show</a> <br>");
    echo("<hr />");

}


?>