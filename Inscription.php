<?php
session_start();
    $bdd = new PDO("mysql:host=localhost;dbname=spacemerchant;charset=utf8", "root", "");

    // the info typed in by the user into the Inscription form the "Connexion.php" page is recuperated in variables
        $last_name = $_POST['first_name'];
        $first_name = $_POST['last_name'];
        $Nickname = $_POST['Nickname'];
        $email = $_POST['email'];
        $password = password_hash($_POST['password'], PASSWORD_DEFAULT);

    // Verification if the email is already used
        $checkEmail = $bdd->prepare("SELECT * FROM user WHERE email = ?");
        $checkEmail->execute([$email]);
        if ($checkEmail->rowCount() > 0) {
            // In the case if the email already exists
            $_SESSION['error_messageI']= 'The email is already used for an account !';
            header("Location: Connexion.php");
        }

    // The user's info is inserted into the database
        $insertUser = $bdd->prepare("INSERT INTO user (f_name, l_name, email, pseudo, password) VALUES (?, ?, ?, ?, ?)");
        $insertUser->execute([$first_name, $last_name, $email, $Nickname, $password]);

    header("Location: Connexion.php");
    exit();
?>
