<!DOCTYPE html>
<html lang="en">

<head>
    <meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1">
    <meta charset="UTF-8">
    <link rel="stylesheet" href="styles.css">
    <link href="https://fonts.googleapis.com/css2?family=Oswald:wght@400;700&display=swap" rel="stylesheet">
    <link href="https://fonts.googleapis.com/css2?family=VT323&display=swap" rel="stylesheet">
    <script src="https://kit.fontawesome.com/612c82559a.js" crossorigin="anonymous"></script>
    <title>Space Merchant - Connexion/Inscription</title>
</head>

<body class="Connexion">

<h2 class="title">Space Merchant</h2>
    <div class="container">
        <!-- Inscription Form -->
        <div class="inscription">
            <h3 class="form-title">Inscription</h3>
            <?php    
     session_start(); // If there is an error message we display it
     if (isset($_SESSION["error_messageI"])) {
        echo "<div class='error-message'>" . $_SESSION["error_messageI"] . "</div>";
        unset($_SESSION['error_messageI']);
    }
    ?>
            <form action="Inscription.php" method="post">
                <div class="element">
                <input type="text" id="last_name" name="last_name" class="input-field" placeholder="Last name" required><br>
                </div>
                <div class="element">
                <input type="text" id="first_name" name="first_name" class="input-field" placeholder="First name" required><br>
                </div>
                <div class="element">
                <input type="text" id="Nickname" name="Nickname" class="input-field" placeholder="Nickname" required><br>
                </div>
                <div class="element">
                <span class="fas fa-user"></span>
                <input type="email" id="email" name="email" class="input-field" placeholder="Email" required><br>
                </div>
                <div class="element">
                <span class="fas fa-lock"></span>
                <input type="password" id="password" name="password" class="input-field" placeholder="Password" required><br>
                </div>
                <button type="submit" class="action-button">Sign up</button>
            </form>
        </div>

        <div class="login">
            <!-- Connexion Form -->
            <h3 class="form-title">Connexion</h3>
            <?php     // If there is an error message we display it
    if (isset($_SESSION['error_message'])) {
        echo "<div class='error-message'>" . $_SESSION["error_message"] . "</div>";
        unset($_SESSION['error_message']); // Then we delete the error message from the session variable
    } ?>
            <form action="login.php" method="post">
                <div class="element">
                <span class="fas fa-user"></span>
                <input type="email" id="email_login" name="email" class="input-field" placeholder="Email" required><br>
                </div>
                <div class="element">
                <span class="fas fa-lock"></span>
                <input type="password" id="password_login" name="password" class="input-field" placeholder="Password" required><br>
                </div>
                <button type="submit" class="action-button">Log in</button>
            </form>
        </div>
    <div>
   

    <?php

    if (isset($_SESSION['email'])) {
        // If the user is connected, he is redirected to the Home page
        header("Location: Home.php");
        exit();
    }
    ?>
</body>

</html>
