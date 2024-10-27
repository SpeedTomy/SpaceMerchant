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

<body class="flotte">
    <h2 class="title">Space Merchant</h2>
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
    // We update the timestamp of the last activity
    $_SESSION['timeout'] = time();
    ?>

    <div class="navbar">
        <ul>
            <li><a href="Home.php">Home</a></li>
            <li><a class="active" href="Missions.php">Missions (Create)</a></li>
            <li><a href="Storeship.php">Store ship</a></li>
            <li><a href="Crew.php">Crew recruitment</a></li>
            <li><a href="Profile.php">User profile</a></li>
            <li><a href="Logout.php">Log out</a></li>
        </ul>
    </div>

    <div class="container">
        <div class="form">
            <h3 class="form-title">Create Mission</h3>

            <?php
            // If there is an error message we display it
            if (isset($_SESSION["error_message"])) {
                echo "<div class='error-message'>" . $_SESSION["error_message"] . "</div>";
                unset($_SESSION["error_message"]);
            }
            // If there is a sucess message we display it
            if (isset($_SESSION['sucess_message'])) {
                echo "<div class='sucess-message'>" . $_SESSION["sucess_message"] . "</div>";
                unset($_SESSION['sucess_message']); // Then we delete the error message from the session variable
            }

            // Connexion to the database
            $bdd = new PDO("mysql:host=localhost;dbname=spacemerchant;charset=utf8", "root", "");

            // Recuperation of the all planets in game
            $queryplanet= $bdd->query("SELECT * FROM planet");
            $Planets = $queryplanet->fetchAll(PDO::FETCH_ASSOC);

            ?>

            <form action="Process_mission_creation.php" method="post">

                <h3 class ="form-title">Select a Planet:</h3>

                <div>
                    <select id="planet" name="planet">
                        <?php
                            foreach ($Planets as $planet) {
                                echo "<option value='" . $planet["planet_id"] . "'>" .
                                    $planet["planet_name"] . " - Distance: " . $planet["distance"] .
                                    "</option>";
                            }
                        ?>
                    </select>
                </div>


                <h3 class ="form-title">Select an amount of Cargo:</h3>

                <div>
                    <input type="number" id="cargo" name="cargo" min="10" max="500" required>
                </div>

                <div>
                    <button type="submit" class="action-button" name="createmission">Create Mission</button>
                </div>

            </form>
        </div>
    </div>

    <!-- button used to go to the Missions.php page -->
    <form action="Missions.php" method="post">
        <div>
            <button type="submit" class="action-button2" name="MissionSelect">Mission Select</button>
        </div>
    </form>

</body>

</html>