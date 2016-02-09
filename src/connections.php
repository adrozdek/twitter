<?php

session_start();

require_once(dirname(__FILE__) . "/config.php");
require_once(dirname(__FILE__) . "/User.php");
require_once(dirname(__FILE__) . "/Tweet.php");
require_once(dirname(__FILE__) . "/Comment.php");
require_once(dirname(__FILE__) . "/Message.php");

$conn = new mysqli($dbHost, $dbUser, $dbPassword, $dbName);

if($conn->connect_errno){   //error number
    die("Db connection not initialized properly " . $conn->connect_error);
}

User::SetConnection($conn); //żeby klasa user potrafila polaczyc sie z baza danych
Tweet::SetConnection($conn);
Comment::SetConnection($conn);
Message::SetConnection($conn);


//pasek nawigacji:
$userToUse = $_SESSION['userId'];

if(isset($_SESSION['userId'])): ?>

<div class="nav">

    <ul>

        <li><a id="main" href='../twitter/showUser.php'>Profil</a></li>
        <li><a id="messages" href='../twitter/showMessages.php'>Wiadomości</a></li>
        <li><a id="users" href='../twitter/showAllUsers.php'>Użytkownicy</a></li>
        <li><a id="tweets" href='../twitter/showAllTweets.php'>Tweety</a></li>
        <li><a id="changeDescription" href='../twitter/changeDescription.php'>Zmień opis</a></li>
        <li><a id="changePassword" href='../twitter/changePassword.php'>Zmień hasło</a></li>
        <li><a id="logout" href='../twitter/logout.php'>Wyloguj</a></li>
    </ul>

</div>

<?php endif; ?>
