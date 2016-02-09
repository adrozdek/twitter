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





//dla kolejnch klas kolejne polaczenia

//$server_tz = date_default_timezone_get();
//echo $server_tz; //


/*
$tweet1 = Tweet::LoadTweetById(1);
var_dump($tweet1);


$tweet1 = Tweet::CreateTweet(1, 'hej hej hej helo');
var_dump($tweet1);
*/


/*
$user1 = User::LogInUser("test@test.pl", "12345");
var_dump($user1);

$user = User::GetUserById(1);
var_dump($user);

$user1->setDescription("Nowy opis Agaty asdas");

$isItWorking = $user1->saveToDB();

var_dump($user1);
var_dump($isItWorking);
/*
$user1 = User::GetAllUsers();
var_dump($user1);

$user1 = User::RegisterUser("Agata", "test@test.pl", "12345", "12345", "Opis Agaty");

var_dump($user1);
*/

?>