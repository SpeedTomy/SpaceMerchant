<!DOCTYPE html>
<html lang="en">

    <head>
        <meta charset="UTF-8">
        <link rel="stylesheet" href="styles.css">
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

                    // Verification if the user si connected
        if (!isset($_SESSION["Nickname"])) {
            // Redirection to the connexion page if the user is not connected
            header("Location: Connexion.php");
            exit();
        }
        ?>

        <!-- navigation bar used to navigate through the different pages of our game -->
        <div class="navbar">
            <ul>
                <li><a href="Home.php">Home</a></li>
                <li><a href="Missions.php">Missions</a></li>
                <li><a class="active" href="Storeship.php">Store ship</a></li>
                <li><a href="Crew.php">Crew recruitment</a></li>
                <li><a href="Profile.php">User profile</a></li>
                <li><a href="Logout.php">Log out</a></li>
            </ul>
        </div>

        <div class="container">
            <div class="form">
                <h3 class="form-title">Spaceships in stock</h3>
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

                <form action="Process_ship_purchase.php" method="post">
                    <div>
                        <select id="shipSelect" name="shipSelect">
                            <?php
                                // Display only the spaceships of level 1 and that the user does not already own
                                foreach ($_SESSION["spaceships"] as $spaceship) {
                                    $isAlreadyOwned = false;
                                    foreach ($_SESSION["spaceships_player"] as $ownedSpaceship) {
                                        // If the spaceship is owned by the player, it is not displayed in the form
                                        if ($spaceship["ship_name"] == $ownedSpaceship["name"]) {
                                            $isAlreadyOwned = true;
                                            break;
                                        }
                                    }

                                    // Displays the spaceship only if it is of level 1 and is not already owned
                                    if ($spaceship["level"] == 1 && !$isAlreadyOwned) {
                                        echo "<option value='" . $spaceship["spaceship_id"] . "'>" .
                                        $spaceship["ship_name"] ." ". $spaceship["price"]. "$".
                                        "</option>";
                                    }
                                }
                            ?>
                        </select>
                    </div>
                    <div>
                        <button type="submit" class="action-button" name="buyShip">Buy Spaceship</button>
                    </div>
                </form>
            </div>

            <div class="form">
                <h3 class="form-title">Spaceship identity</h3>
                <form action="Display.php" method="post">

                    <div>
                        <select id="shipSelect" name="shipSelect">
                            <?php
                            // Display the spaceships of level 1 only
                            foreach ($_SESSION["spaceships"] as $spaceship) {
                                // Verifies if the spaceship is of level 1
                                if ($spaceship["level"] == 1) {
                                    echo "<option value='" . $spaceship["spaceship_id"] . "'>" .
                                    $spaceship["ship_name"] .
                                    "</option>";
                                }
                            }
                            ?>
                        </select>
                    </div>

                    <!-- Table that displays all the info about the selected ship -->
                    <div class="profile_user">
                        <?php
                        if (isset($_SESSION["dispShip"])) {?>
                            <img src="<?php echo $_SESSION['dispShip']['ship_photo']; ?>" alt="<?php echo $_SESSION['dispShip']['ship_name']; ?>" width="300" height="300">
                            <table>
                            <tr>
                                <td><strong>Name:</strong></td>
                                <td><?php echo $_SESSION["dispShip"]["ship_name"]; ?></td>
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
                            <tr>
                                <td><strong>Description:</strong></td>
                                <td><?php echo $_SESSION["dispShip"]["ship_description"]; ?></td>
                            </tr>
                        </table>
                        <?php }
                         $_SESSION["dispShip"] =null;
                        ?>
                    </div>

                    <div>
                        <button type="submit" class="action-button" name="displayship">Display</button>
                    </div>

                </form>
            </div>
        </div>

        <!-- button used to go to the Upgradeship.php page -->
        <form action="Upgradeship.php" method="post">
                <div>
                    <button type="submit" class="action-button2" name="UpgradeShip">Upgrade spaceship</button>
                </div>
        </form>

    </body>

</html>
