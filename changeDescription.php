<?php

require_once("./src/connections.php");

if (isset($_SESSION['userId']) !== TRUE) {
    header("Location: login.php");
}

$userId = $_SESSION['userId'];
$user = User::GetUserById($userId);

?>

<form method='POST'>
    Zmień opis:
    <p>
        <label>
            <textarea name='description' cols="30" rows="4"><?php echo($user->getDescription()) ?></textarea>
        </label>

    </p>

    <input type='submit' value='Zmień opis'>


</form>


<?php

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $newDescription = $_POST['description'];

    User::ChangeDescription($newDescription);
    header("Location: showUser.php");

}

?>



