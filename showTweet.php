<?php

require_once("./src/connections.php");

if (isset($_SESSION['userId']) !== TRUE) {
    header("Location: login.php");
}

if (isset($_GET['id'])) {
    $id = $_GET['id'];
}

$id = $_GET['id'];


$tweetToShow = Tweet::LoadTweetById($id);

$userId = (int)($tweetToShow->getUserId());
$user = User::GetUserById($userId);

echo("<h1> {$user->getName()}</h1>");
echo($tweetToShow->getTweetText() . "<br>");
echo($tweetToShow->getTweetDate());
$coms = count($tweetToShow->getAllComments());
echo("<br>Liczba komentarzy: $coms ");
echo("<hr />");


echo("
<form method='post'>
    <label>
        <input type='text' name='comment' placeholder='wpisz swój komentarz'>
     </label>
    <input type='submit'>
</form>
");


foreach ($tweetToShow->getAllComments() as $comment) {
    $idOfCommentingUser = $comment->getUserId();
    $commentingUser = User::GetUserById($idOfCommentingUser);

    echo("<h3>{$commentingUser->getName()}</h3>");
    echo($comment->getCommentText() . "<br>");
    echo($comment->getCommentDate() . "<br>");
    echo("<hr />");

}


if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    if (strlen(trim($_POST['comment'])) > 0) {
        $commentText = $_POST['comment'];
        $comment = Comment::CreateComment($commentText);
        header("Location: showTweet.php?id=$id");
        return $comment;
    }
    return false;
}


?>

