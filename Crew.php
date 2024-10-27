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
    <body class ="crew">

    <!-- navigation bar used to navigate through the different pages of our game -->
        <div class="navbar">
                <ul>
                <li><a href="Home.php">Home</a></li>
                <li><a href="Missions.php">Missions</a></li>
                <li><a href="Storeship.php">Store ship</a></li>
                <li><a class="active" href="Crew.php">Crew recruitement</a></li>
                <li><a href="Profile.php">User profile</a></li>
                <li><a href="Logout.php">Log out</a> </li>
                </ul>
        </div>

        <?php
            session_start();
        
                    // Verification if the user si connected
        if (!isset($_SESSION["Nickname"])) {
            // Redirection to the connexion page if the user is not connected
            header("Location: Connexion.php");
            exit();
        }
        
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



        <div class="container">


            <div class="form">
                <h3 class="form-title">Select a crewmate<h3>
                <?php
                // If there is an error message we display it
                if (isset($_SESSION["error_message"])) {
                    echo "<div class='error-message'>" . $_SESSION["error_message"] . "</div>";
                    unset($_SESSION["error_message"]); // Then we delete the error message from the session variable
                }
                       // If there is a sucess message we display it
                       if (isset($_SESSION['sucess_message'])) {
                        echo "<div class='sucess-message'>" . $_SESSION["sucess_message"] . "</div>";
                        unset($_SESSION['sucess_message']); // Then we delete the error message from the session variable
                    } 
                ?>
                <form action="Process_crew_purchase.php" method="post">
                    <div>
                        <select id="crewSelect" name="crewSelect">
                            <?php
                                // We display only the crew member that the player does not already have
                                foreach ($_SESSION["crews"] as $crew) {
                                    // Verification if the user does not already have the crew member
                                    $isAlreadyOwned = false;
                                    foreach ($_SESSION["crews_player"] as $ownedcrew) {
                                        // If the crew memeber is already owned by the player, we do not display it in the form
                                        if ($crew["name"] == $ownedcrew["name"]) {
                                            $isAlreadyOwned = true;
                                            break;
                                        }
                                    }

                                    // Display only the crew members that are not owned yet
                                    if (!$isAlreadyOwned) {
                                        echo "<option value='" . $crew["crew_id"] . "'>" .
                                            $crew["name"] ." ". $crew["price"]. "$".  // Afficher le nom du crew depuis crew
                                            "</option>";
                                    }
                                }
                            ?>
                        </select>
                    </div>
                    <div>
                        <button type="submit" class="action-button" name="buyCrew">Buy Crewmate</button>
                    </div>
                </form>
            </div>


            <div class="form">
                <h3 class="form-title">Crewmate identity</h3>
                <form action="Display.php" method="post">

                    <div>
                        <select id="crewSelect" name="crewSelect">
                            <?php
                                // Display of the all the crew members available in the game
                                foreach ($_SESSION["crews"] as $crew) {
                                        echo "<option value='" . $crew["crew_id"] . "'>" . $crew["name"] . "</option>";
                                }
                            ?>
                        </select>
                    </div>

                    <div class="profile_user">
                        <?php
                        if (isset($_SESSION["dispCrew"])) {?>
                        <img src="<?php echo $_SESSION['dispCrew']['photo']; ?>" alt="<?php echo $_SESSION['dispCrew']['name']; ?>"width="300" height="300">
                            <table>
                                <tr>
                                    <td><strong>Name:</strong></td>
                                    <td><?php echo $_SESSION["dispCrew"]["name"]; ?></td>
                                </tr>
                                <tr>
                                    <td><strong>Buff type:</strong></td>
                                    <td><?php echo $_SESSION["dispCrew"]["buff_type"]; ?></td>
                                </tr>
                                <tr>
                                    <td><strong>Description:</strong></td>
                                    <td><?php echo $_SESSION["dispCrew"]["description"]; ?></td>
                                </tr>
                            </table>
                        <?php } 
                        $_SESSION["dispCrew"] =null;
                        ?>
                    </div>

                    <div>
                        <button type="submit" class="action-button" name="displaycrew">Display</button>
                    </div>

                </form>
            </div>
        </div>
    </body >
</html>
