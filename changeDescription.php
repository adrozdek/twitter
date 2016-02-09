<?php

require_once("./src/connections.php");

if (isset($_SESSION['userId']) !== TRUE) {
    header("Location: login.php");
}

?>

<form method='POST'>

    <p>
        <label>
            Zmień opis:
            <input type='text' name='description'>
        </label>
    </p>

        <input type='submit' value='Zmień opis'>


</form>


<?php

if($_SERVER['REQUEST_METHOD'] == 'POST'){
    $newDescription = $_POST['description'];

    User::SetDescription($newDescription);

}

?>



