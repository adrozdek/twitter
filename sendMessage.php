<?php


require_once("./src/connections.php");

if (isset($_SESSION['userId']) !== TRUE) {
    header("Location: login.php");
}


$user = User::GetUserById($_GET['id']);
echo("<h2>Do: {$user->getName()}</h2>");


echo("<form method='POST'>
<textarea name='message' cols='30' rows='4'></textarea>
<input type='submit' value='Wyślij'>
</form>");


if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $newMessage = $_POST['message'];
    $sendId = $_SESSION['userId'];
    $receiveId = $_GET['id'];

    Message::CreateMessage($sendId, $receiveId, $newMessage);


    //header("Location: showUser.php?userId={$_GET['id']}");
    header("Location: showMessages.php");

}


?>