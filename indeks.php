<?php

require_once("./src/connections.php");

if (isset($_SESSION['userId']) !== TRUE) {
    header("Location: login.php");
}

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    if (strlen(trim($_POST['tweet_text'])) > 0) {
        $tweetText = $_POST['tweet_text'];
        $tweet = Tweet::CreateTweet($tweetText);
        header("Location: indeks.php");
    } else {
        echo("Nie udało się utworzyć tweeta :(");
    }

}


$userId = $_SESSION['userId'];

$userToShow = User::GetUserById($userId);

$allTweets = $userToShow->getAllFriendsAndMineTweets();
//var_dump($allTweets);

echo("<h1> Tweety Twoje oraz twoich przyjaciół </h1>");

if ($userToShow->getId() === $_SESSION['userId']):?>
    <h3>Nowy tweet</h3>
    <form action='showUser.php' method='post'>
        <label>
            <input type='text' name='tweet_text'>
        </label>
        <input type='submit'>
    </form>

<?php endif;


foreach($allTweets as $tweetToShow){

    $userId = $tweetToShow->getUserId();
    $tweetingUser = User::GetUserById($userId);

    echo("<h2>{$tweetingUser->getName()}</h2>");
    if($_SESSION['userId'] != $userId){
        echo("<a href='showUser.php?userId=$userId'>Pokaż profil'</a> <br />");
    }
    echo("{$tweetToShow->getTweetText()} <br />");
    echo("{$tweetToShow->getTweetDate()}<br>");

    $tweetToShowId = $tweetToShow->getId();
    $coms = count($tweetToShow->getAllComments());
    echo("Liczba komentarzy: $coms <br />");

    echo("<a href='showTweet.php?id={$tweetToShow->getId()}'>Pokaż </a>");
    if($_SESSION['userId'] == $userId){
        echo("<a href='editTweet.php?id=$tweetToShowId'> Edytuj</a>");
        echo("<a href='removeTweet.php?id=$tweetToShowId'> Usuń</a>");
    }
    echo("<hr />");

}



?>