<?php


require_once("./src/connections.php");

if (isset($_SESSION['userId']) !== TRUE) {
    header("Location: login.php");
}

echo("<form method='POST'>
<input type='text' name='message'>
<input type='submit' value='Wyślij'>
</form>");


if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $newMessage = $_POST['message'];
    $sendingUser = $_SESSION['userId'];

    Message::CreateMessage($newMessage);


    //header("Location: showUser.php?userId={$_GET['id']}");
    header("Location: showMessages.php");

}


?>