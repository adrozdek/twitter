<?php

require_once("./src/connections.php");

if(isset($_SESSION['userId']) !== TRUE){
    header("Location: login.php");
}

if(isset($_GET['id'])){
    $id = $_GET['id'];
}
$id = $_GET['id'];


$tweetToShow = Tweet::LoadTweetById($id);


//var_dump($tweetToShow);
//$tweetToShow->getUserId();
  //  echo($tweetToShow);
$userId = (int)($tweetToShow->getUserId());
$user = User::GetUserById($userId);
//var_dump($userId);
//var_dump($user);
//$cos = $tweetToShow->getTweetText();
//var_dump($cos);

echo("<h3> {$user->getName()}</h3>") ;
echo($tweetToShow->getTweetText() . "<br>");
echo($tweetToShow->getTweetDate());


echo("
<form method='post'>
    <label>
        <input type='text' name='comment' placeholder='wpisz swój komentarz'>
     </label>
    <input type='submit'>
</form>
");



if($_SERVER['REQUEST_METHOD'] === 'POST'){
    if(strlen(trim($_POST['comment'])) > 0){
        $commentText = $_POST['comment'];
        $comment = Comment::CreateComment($commentText);
        return $comment;
    }
    return false;
}




?>










?>