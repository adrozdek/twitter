<?php

require_once("./src/connections.php");

if($_SERVER["REQUEST_METHOD"] === "POST"){
    //zabezpieczyć żeby rzeczy nie były puste w środku metody register user. !!
    $user = User::RegisterUser($_POST['name'], $_POST['email'], $_POST['password1'], $_POST['password2'], $_POST['description']);

    if($user !== FALSE){
        $_SESSION['userId'] = $user->getId();
        header("Location: showUser.php");
    }
    else{
        echo("Zle dane rejestracji");
    }
}

?>

<fieldset>
    <legend>Rejestracja:</legend>
    <form action="register.php" method="post">
        <p>
        <label>
            Email:
            <input type="email" name="email">
        </label>
        </p>
        <p>
        <label>
            Name:
            <input type="text" name="name">
        </label>
        </p>
        <p>
        <label>
            Password:
            <input type="password" name="password1">
        </label>
        </p>
        <p>
        <label>
            Repeat password:
            <input type="password" name="password2">
        </label>
        </p>
        <p>
        <label>
            Description:
            <input type="text" name="description">
        </label>
        </p>
        <p>
        <input type="submit" value="Zarejestruj sie">
        </p>
    </form>
</fieldset>
