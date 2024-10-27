<!DOCTYPE html>
<html lang="en">

    <head>
        <meta charset="UTF-8">
        <link rel="stylesheet" href="styles.css"> <!-- Assurez-vous d'inclure votre fichier CSS ici -->
        <link href="https://fonts.googleapis.com/css2?family=Oswald:wght@400;700&display=swap" rel="stylesheet">
        <link href="https://fonts.googleapis.com/css2?family=VT323&display=swap" rel="stylesheet">
        <script src="https://kit.fontawesome.com/612c82559a.js" crossorigin="anonymous"></script>
        <title>Galactic Commerce Management System</title>
    </head>

    <h2 class="title">Space Merchant</h2>

    <body class ="profile">

        <?php
            session_start();

            // We verify if the user has been inactive for more than an hour
            if (isset($_SESSION['timeout']) && time() - $_SESSION['timeout'] > $_SESSION['inactive']) {
                // If the user has been inactive for more than an hour, he is disconnected
                session_unset();
                session_destroy();
                header("Location: Connexion.php"); // He is therefore redirected to the Connexion page
                exit();
            }

                    // Verification if the user si connected
        if (!isset($_SESSION["Nickname"])) {
            // Redirection to the connexion page if the user is not connected
            header("Location: Connexion.php");
            exit();
        }
            // We update the timestamp of the last activity
            $_SESSION['timeout'] = time();

            // Recuperate the user's data from the session variable
                $Nickname = $_SESSION['Nickname'];
                $argent = $_SESSION['money'];
                $nombreSpaceships = count($_SESSION['spaceships_player']);
                $nombreCrews = count($_SESSION['crews_player']);
                $nombreMissions = count($_SESSION['missions_player']);
        ?>

        <!-- navigation bar used to navigate through the different pages of our game -->
        <div class="navbar">
                <ul>
                <li><a href="Home.php">Home</a></li>
                <li><a href="Missions.php">Missions</a></li>
                <li><a href="Storeship.php">Store ship</a></li>
                <li><a href="Crew.php">Crew recruitement</a></li>
                <li><a class="active" href="Profile.php">User profile</a></li>
                <li><a href="Logout.php">Log out</a> </li>
                </ul>
        </div>

        <!-- Display of the User's data -->
        <div class="profile_user">
            <h2 class ="form-title">User profile</h2>
            <table>
                <tr>
                    <td><strong>Nickname :</strong></td>
                    <td><?php echo $Nickname; ?></td>
                </tr>
                <tr>
                    <td><strong>Money :</strong></td>
                    <td><?php echo $argent; ?> $</td>
                </tr>
                <tr>
                    <td><strong>Number of ships :</strong></td>
                    <td><?php echo $nombreSpaceships; ?></td>
                </tr>
                <tr>
                    <td><strong>Number of crew members :</strong></td>
                    <td><?php echo $nombreCrews; ?></td>
                </tr>
                <tr>
                    <td><strong>Number of missions being done :</strong></td>
                    <td><?php echo $nombreMissions; ?></td>
                </tr>
            </table>
        </div>

    </body>

</html>
