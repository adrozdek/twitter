<?php

require_once("./src/connections.php");

if (isset($_SESSION['userId']) !== TRUE) {
    header("Location: login.php");
}

$userId = $_SESSION['userId'];
$friendId = $_GET['id'];

$userSession = User::GetUserById($userId);
$friendGet = User::GetUserById($friendId);

if($userSession->checkIfFriendshipExist($friendId)) {
    echo("Jesteście już przyjaciółmi");
    echo("Chcesz usunąć przyjaźń?");

    echo("<form method='post'><input type='submit' value='Tak'></form>");

    if ($_SERVER['REQUEST_METHOD'] == 'POST') {
        $userSession->removeFriendship($friendId);
        header("Location: showUser.php");
    }
}
elseif($userSession->checkIfYouAskedFS($friendId)) {
    echo("Wysłałeś już zapytanie do znajomych");
    echo("Chcesz usunąć zaproszenie?");

    echo("<form method='post'><input type='submit' value='Tak'></form>");

    if ($_SERVER['REQUEST_METHOD'] == 'POST') {
        $userSession->removeFriendship($friendId);
        header("Location: showUser.php");
    }
}
elseif($friendGet->checkIfYouAskedFS($userId)){
    echo("Jesteś pewny, że chcesz potwierdzić przyjaźć? Użytkownik będzie widział wszystkie Twoje tweety na stronie głównej");

    echo("<form method='post'><input type='submit' value='Tak'></form>");

    if ($_SERVER['REQUEST_METHOD'] == 'POST') {
        $userSession->acceptFriendship($friendId);
        header("Location: showUser.php");
    }
}
else {

    echo("Jesteś pewny, że chcesz wysłać użytkownikowi zaproszenie do znajomych? Będziesz wtedy widział jego tweety na stronie głównej.");
    echo("<form method='post'><input type='submit' value='Tak'></form>");

    if ($_SERVER['REQUEST_METHOD'] == 'POST') {
        Friend::CreateFriendship($userId, $friendId);
        header("Location: showUser.php");
    }
}


?>