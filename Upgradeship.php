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
            <li><a href="Missions.php">Missions</a></li>
            <li><a class="active" href="Storeship.php">Store ship (Upgrade)</a></li>
            <li><a href="Crew.php">Crew recruitment</a></li>
            <li><a href="Profile.php">User profile</a></li>
            <li><a href="Logout.php">Log out</a></li>
        </ul>
    </div>

    <div class="container">

        <div class="form">
            <h3 class="form-title">Your spaceships</h3>
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
                
            ?>
            <form action="Process_upgrade_ship.php" method="post">

                <div>
                    <select id="playerShipSelect" name="playerShipSelect">
                        <?php
                            // Display all the spaceships that the user owns with their level
                            foreach ($_SESSION["spaceships_player"] as $playerSpaceship) {
                                // Connexion to the database
                                $bdd = new PDO("mysql:host=localhost;dbname=spacemerchant;charset=utf8", "root", "");

                                // Recuperates the upgrade price for this next level of this spaceship
                                $upgradePriceQuery = $bdd->prepare("SELECT price FROM spaceship WHERE spaceship_id = ?");
                                $upgradePriceQuery->execute([$playerSpaceship["spaceship_id"]+1]);
                                $upgradePrice = $upgradePriceQuery->fetchColumn();

                                // Displays the name and level of the spaceship with the upgrade price when under level 5
                                if ($playerSpaceship["level"] < 5) {
                                    echo "<option value='" . $playerSpaceship["spaceship_id"] . "'>" .
                                         $playerSpaceship["name"] . " (Level " . $playerSpaceship["level"] . ") - Upgrade Price: $" . $upgradePrice .
                                        "</option>";
                                }
                                // When the spaceship is of level 5 it does not isplay the upgrade price as it is already at max level (level 5)
                                if ($playerSpaceship["level"] == 5) {
                                    echo "<option value='" . $playerSpaceship["spaceship_id"] . "'>" .
                                         $playerSpaceship["name"] . " (Level " . $playerSpaceship["level"] . ")" .
                                        "</option>";
                                }
                            }
                        ?>
                    </select>
                </div>

                <div>
                    <button type="submit" class="action-button" name="upgradeShip">Upgrade Spaceship</button>
                </div>

            </form>
        </div>


        <div class="form">
            <h3 class="form-title">Spaceship identity</h3>

            <?php
            // If there is an error message we display it
            if (isset($_SESSION["error_message"])) {
                echo "<div class='error-message'>" . $_SESSION["error_message"] . "</div>";
                unset($_SESSION["error_message"]);
            }
            ?>

            <!-- form used to choose which spaceship to display its info -->
            <form action="Display.php" method="post">

                <div>
                    <select id="playerShipSelect" name="playerShipSelect">
                        <?php
                        // Displays all the spaceships of the user
                        foreach ($_SESSION["spaceships_player"] as $playerspaceship) {
                                echo "<option value='" . $playerspaceship["spaceship_id"] . "'>" .
                                    $playerspaceship["name"] . " (Level " . $playerspaceship["level"] . ")" .
                                    "</option>";
                        }
                        ?>
                    </select>
                </div>

                <div class="profile_user">
                    <!-- Table that displays all the info about the selected ship -->
                    <?php
                    if (isset($_SESSION["dispShip"]) && $_SESSION["dispShip"]["level"]==5){
                        ?>
                        <img src="<?php echo $_SESSION['dispShip']['ship_photo']; ?>" alt="<?php echo $_SESSION['dispShip']['ship_name']; ?>" width="300" height="300">
                        <table>
                            <tr>
                                <td><strong>Name:</strong></td>
                                <td><?php echo $_SESSION["dispShip"]["ship_name"]; ?></td>
                            </tr>
                            <tr>
                                <td><strong>Level:</strong></td>
                                <td><?php echo $_SESSION["dispShip"]["level"]; ?></td>
                            </tr>
                            <tr>
                                <td><strong>Cargo Capacity:</strong></td>
                                <td><?php echo $_SESSION["dispShip"]["cargo_capacity"]; ?></td>
                            </tr>
                            <tr>
                                <td><strong>Fuel Efficiency:</strong></td>
                                <td><?php echo $_SESSION["dispShip"]["fuel_efficiency"]; ?></td>
                            </tr>
                            <tr>
                                <td><strong>Speed:</strong></td>
                                <td><?php echo $_SESSION["dispShip"]["speed"]; ?></td>
                            </tr>
                            <tr>
                                <td><strong>Range:</strong></td>
                                <td><?php echo $_SESSION["dispShip"]["range"]; ?></td>
                            </tr>
                        </table>
                    <?php } ?>

                    <!-- Table that displays info about the selected ship and info about it's next level -->
                    <?php
                    if (isset($_SESSION["dispShip"]) && isset($_SESSION["dispShipUpg"]) && $_SESSION["dispShip"]["level"]<5) {
                        ?>
                        <img src="<?php echo $_SESSION['dispShip']['ship_photo']; ?>" alt="<?php echo $_SESSION['dispShip']['ship_name']; ?>" width="300" height="300">
                        <table>
                            <tr>
                                <td><strong>Name:</strong></td>
                                <td><?php echo $_SESSION["dispShip"]["ship_name"]; ?></td>
                            </tr>
                            <tr>
                                <td><strong>Level:</strong></td>
                                <td><?php echo $_SESSION["dispShip"]["level"]; ?></td>
                                <td><span class="fa-solid fa-arrow-right"></span></td>
                                <td><?php echo $_SESSION["dispShipUpg"]["level"]; ?></td>
                            </tr>
                            <tr>
                                <td><strong>Cargo Capacity:</strong></td>
                                <td><?php echo $_SESSION["dispShip"]["cargo_capacity"]; ?></td>
                                <td><span class="fa-solid fa-arrow-right"></span></td>
                                <td><div class='sucess-message'><?php echo $_SESSION["dispShipUpg"]["cargo_capacity"]; ?></div></td>
                            </tr>
                            <tr>
                                <td><strong>Fuel Efficiency:</strong></td>
                                <td><?php echo $_SESSION["dispShip"]["fuel_efficiency"]; ?></td>
                                <td><span class="fa-solid fa-arrow-right"></span></td>
                                <td><div class='sucess-message'><?php echo $_SESSION["dispShipUpg"]["fuel_efficiency"]; ?></div></td>
                            </tr>
                            <tr>
                                <td><strong>Speed:</strong></td>
                                <td><?php echo $_SESSION["dispShip"]["speed"]; ?></td>
                                <td><span class="fa-solid fa-arrow-right"></span></td>
                                <td><div class='sucess-message'><?php echo $_SESSION["dispShipUpg"]["speed"]; ?></div></td>
                            </tr>
                            <tr>
                                <td><strong>Range:</strong></td>
                                <td><?php echo $_SESSION["dispShip"]["range"]; ?></td>
                                <td><span class="fa-solid fa-arrow-right"></span></td>
                                <td><div class='sucess-message'><?php echo $_SESSION["dispShipUpg"]["range"]; ?></div></td>
                            </tr>
                        </table>
                    <?php }
                    // we change the value to null for the table to disappear when the page is refreshed
                    $_SESSION["dispShip"] =null;
                    $_SESSION["dispShipUpg"] =null;
                    ?>
                </div>
                <div>
                    <button type="submit" class="action-button" name="displayship">Display</button>
                </div>
            </form>
        </div>

    <!-- button used to go to the Upgradeship.php page -->
    </div>
        <form action="Storeship.php" method="post">
            <div>
                <button type="submit" class="action-button2" name="UpgradeShip">Store spaceship</button>
            </div>
    </form>
</body>

</html>
