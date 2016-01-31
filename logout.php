<?php
require_once("./src/connections.php");

unset($_SESSION['userId']);

header("Location: login.php");
//tylko i wyłącznie jesli nie wyswietlilismy niczego na stronie!!.


//jeśli nie ma sesji to wszystkie strony powinny nas wysyłać na register czy login !!!!
?>