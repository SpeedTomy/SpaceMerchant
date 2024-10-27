<?php
    session_start();
    session_destroy(); // Deletes all the data of session

    header("Location: Connexion.php"); // Redirects the user to the Home page
    exit();
?>
