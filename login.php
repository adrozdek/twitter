<?php

require_once("./src/connections.php");

if($_SERVER["REQUEST_METHOD"] === "POST"){
    $user = User::LogInUser($_POST['email'], $_POST['password']);
    if($user !== FALSE){
        $_SESSION['userId'] = $user->getId();
        header("Location: showUser.php");
    }
    else{
        echo("Zle dane logowania");
    }
}
?>

<fieldset>
    <legend>Logowanie:</legend>
    <form action="login.php" method="post">
        <p>
            <label>
                Email:
                <input type="email" name="email">
            </label>
        </p>
        <p>
            <label>
                Hasło:
                <input type="password" name="password">
            </label>
        </p>
        <p>
            <input type="submit" value="Zaloguj sie">
        </p>
    </form>
</fieldset>
