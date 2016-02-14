<?php

require_once("./src/connections.php");

if (isset($_SESSION['userId']) !== TRUE) {
    header("Location: login.php");
}

if (isset($_GET["userId"])) {
    $userId = $_GET["userId"];

} else {
    $userId = $_SESSION["userId"];
}

$userToShow = User::GetUserById($userId);

if ($userToShow !== FALSE) {
    echo("<h2>{$userToShow->getName()}</h2>");   //nawiasy klamrowe wymagane
    echo("O mnie: {$userToShow->getDescription()} <br />");
    if($_SESSION['userId'] != $userId) {
        echo("<a href='sendMessage.php?id={$userId}'>Wyślij wiadomość <br/> </a>");

        $friendToUser = User::GetUserById($_SESSION['userId']);

        if($friendToUser->checkIfFriendshipExist($userId)) {
            echo("Przyjaciel");
        }
        elseif($friendToUser->checkIfYouAskedFS($userId)) {
            echo("<a href='addFriend.php?id={$userId}'>Usuń zaproszenie do znajomych</a>");
        }
        elseif($userToShow->checkIfYouAskedFS($_SESSION['userId'])){
            echo("<a href='addFriend.php?id={$userId}'>Potwierdź zaproszenie do znajomych</a>");

        } else{
            echo("<a href='addFriend.php?id={$userId}'>Wyślij zaproszenie do znajomych</a>");

        }
    }


    if ($userToShow->getId() === $_SESSION['userId']):?>
        <h3>Nowy tweet</h3>
        <form action='showUser.php' method='post'>
            <label>
                <input type='text' name='tweet_text'>
            </label>
            <input type='submit'>
        </form>

    <?php endif;
    foreach ($userToShow->loadAllTweets() as $tweet) {
        echo("<h2>{$userToShow->getName()}</h2>");
        echo("{$tweet->getTweetText()} <br>");
        echo("{$tweet->getTweetDate()}<br>");
        $tweetId = $tweet->getId();
        $coms = count($tweet->getAllComments());
        echo("Liczba komentarzy: $coms <br />");
        echo("<a href='showTweet.php?id={$tweetId}'>Pokaż tweeta </a>");
        if($_SESSION['userId'] == $userId){
            echo("<a href='editTweet.php?id=$tweetId'> Edytuj</a>");
            echo("<a href='removeTweet.php?id=$tweetId'> Usuń</a>");
        }

        echo("<hr />");
    }
} else {
    echo("Nie ma takiego uzytkownika");
}

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    if (strlen(trim($_POST['tweet_text'])) > 0) {
        $tweetText = $_POST['tweet_text'];
        $tweet = Tweet::CreateTweet($tweetText);
        header("Location: showUser.php");
    } else {
        echo("Nie udało się utworzyć tweeta :(");
    }

}


?>