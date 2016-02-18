<?php

require_once("./src/connections.php");

if (isset($_SESSION['userId']) !== TRUE) {
    header("Location: login.php");
}

$userId = $_SESSION['userId'];
$userSession = User::GetUserById($userId);

if(isset($_GET['id']) && ($_GET['id'] != $userId)) {
    $friendId = $_GET['id'];

    $friendGet = User::GetUserById($friendId);

    if ($userSession->checkIfFriendshipExist($friendId)) {
        echo("Jesteście przyjaciółmi z {$friendGet->getName()} ");
        echo("Chcesz usunąć przyjaźń?");

        echo("<form method='post'><input type='submit' value='Tak'></form>");

        if ($_SERVER['REQUEST_METHOD'] == 'POST') {
            $userSession->removeFriendship($friendId);
            header("Location: showUser.php?userId={$friendId}");
        }
    } elseif ($userSession->checkIfYouAskedFS($friendId)) {
        echo("Wysłałeś już zapytanie do znajomych");
        echo("Chcesz usunąć zaproszenie?");

        echo("<form method='post'><input type='submit' value='Tak'></form>");

        if ($_SERVER['REQUEST_METHOD'] == 'POST') {
            $userSession->removeFriendship($friendId);
            header("Location: showUser.php?userId={$friendId}");
        }
    } elseif ($friendGet->checkIfYouAskedFS($userId)) {
        echo("Jesteś pewny, że chcesz potwierdzić przyjaźć? Użytkownik będzie widział wszystkie Twoje tweety na stronie głównej");

        echo("<form method='post'><input type='submit' value='Tak'></form>");

        if ($_SERVER['REQUEST_METHOD'] == 'POST') {
            $userSession->acceptFriendship($friendId);
            header("Location: showUser.php?userId={$friendId}");
        }
    } else {

        echo("Jesteś pewny, że chcesz wysłać użytkownikowi zaproszenie do znajomych? Będziesz wtedy widział jego tweety na stronie głównej.");
        echo("<form method='post'><input type='submit' value='Tak'></form>");

        if ($_SERVER['REQUEST_METHOD'] == 'POST') {
            Friend::CreateFriendship($userId, $friendId);
            header("Location: showUser.php?userId={$friendId}");
        }
    }
}
elseif(isset($_GET['idR']) && ($_GET['idR'] != $userId)) {
    $friendRemove = $_GET['idR'];
    $friendToRemove = User::GetUserById($friendRemove);
    var_dump($friendToRemove);
    var_dump($userSession);

    if ($friendToRemove->checkIfYouAskedFS($userId)) {
        echo("Chcesz usunąć zaproszenie od użytkownika {$friendToRemove->getName()}?");

        echo("<form method='post'><input type='submit' value='Tak'></form>");

        if ($_SERVER['REQUEST_METHOD'] == 'POST') {
            $friendToRemove->removeFriendship($userSession);
            header("Location: showAllFriends.php");

        }
    }
    if ($userSession->checkIfYouAskedFS($friendRemove)) {
        echo("Chcesz usunąć zaproszenie wysłane do użytkownika {$friendToRemove->getName()}?");

        echo("<form method='post'><input type='submit' value='Tak'></form>");

        if ($_SERVER['REQUEST_METHOD'] == 'POST') {
            $userSession->removeFriendship($friendRemove);
            header("Location: showAllFriends.php");

        }
    }
    else {
        header("Location: showUser.php");
    }
}
else {
    header("Location: showUser.php");
}



?>