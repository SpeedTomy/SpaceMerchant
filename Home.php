<!DOCTYPE html>
<html lang="en">

    <head>
        <meta charset="UTF-8">
        <link rel="stylesheet" href="styles.css"/> <!-- Assurez-vous d'inclure votre fichier CSS ici -->
        <link href="https://fonts.googleapis.com/css2?family=Oswald:wght@400;700&display=swap" rel="stylesheet">
        <link href="https://fonts.googleapis.com/css2?family=VT323&display=swap" rel="stylesheet">
        <script src="https://kit.fontawesome.com/612c82559a.js" crossorigin="anonymous"></script>
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <title>Galactic Commerce Management System</title>
    </head>

    <body class ="Home">
        <h2 class="title"></h2>
        
            <!-- navigation bar used to navigate through the different pages of our game -->
            <div class="navbar">
                <ul>
                <li><a class="active" href="Home.php">Home</a></li>
                <li><a href="Missions.php">Missions</a></li>
                <li><a href="Storeship.php">Store ship</a></li>
                <li><a href="Crew.php">Crew recruitement</a></li>
                <li><a href="Profile.php">User profile</a></li>
                <li><a href="Logout.php">Log out</a> </li>
                </ul>
            </div>

        <?php
        session_start(); // Initialisation of the session

        // Verification if the user si connected
        if (!isset($_SESSION["Nickname"])) {
            // Redirection to the connexion page if the user is not connected
            header("Location: Connexion.php");
            exit();
        }
            // We verify if the user has been inactive for more than an hour
            if (isset($_SESSION['timeout']) && time() - $_SESSION['timeout'] > $_SESSION['inactive']) {
                // If the user has been inactive for more than an hour, he is deconnected
                session_unset();
                session_destroy();
                header("Location: Connexion.php"); // He is therefore redirected to the Connexion page
                exit();
            }
            // We update the timestamp of the last activity
            $_SESSION['timeout'] = time();

        ?>

               <!-- Welcome back message -->
            <marquee direction="left" scrollamount="15" behavior="scroll" class="marquee">
            Welcome back to the Galactic Commerce Management System, <?php echo $_SESSION["Nickname"]; ?>!
</marquee>

    </body>

</html>
