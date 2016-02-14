<?php

require_once("./src/connections.php");

if (isset($_SESSION['userId']) !== TRUE) {
    header("Location: login.php");
}

    $id = $_GET['id'];


$tweetToEdit = Tweet::LoadTweetById($id);

if($_SESSION['userId'] == $tweetToEdit->getUserId()) {

    if ($_SERVER['REQUEST_METHOD'] == 'POST') {
        $tweetToEdit->updateTweet($_POST['tweet_text']);
        header("Location: showUser.php");
    }

    echo("
    <form method='POST'>
    <p>
        <textarea name='tweet_text' cols='30' rows='4'>{$tweetToEdit->getTweetText()}</textarea>
    </p>
    <input type='submit' value='Edytuj'>

    </form>
");

}
else{
    echo("Nie masz uprawnień do edytowania tweeta!");
}


?>