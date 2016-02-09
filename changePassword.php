<?php

require_once("./src/connections.php");


if (isset($_SESSION['userId']) !== TRUE) {
    header("Location: login.php");
}

?>

    <form method='POST'>

        <fieldset>
            <legend>Zmień hasło</legend>

            <p>
                <label>Stare hasło:
                    <input type='password' name='oldpassword'>
                </label>
            </p>
            <p>
                <label>Nowe hasło:
                    <input type='password' name='password1'>
                </label>
            </p>
            <p>
                <label>Powtórz hasło:
                    <input type='password' name='password2'>
                </label>
            <p>
                <input type='submit' value='Zmień hasło'>
            </p>

        </fieldset>
    </form>


<?php

if ($_SERVER['REQUEST_METHOD'] == 'POST') {

    User::ChangePassword($_POST['oldpassword'], $_POST['password1'], $_POST['password2']);

}


?>