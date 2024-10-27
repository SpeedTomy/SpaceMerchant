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

    <style>
@keyframes fillAnimation {
    from { width: 0%; }
    to { width: 100%; }
}

.ProgressBarContainer {
    width: 100%;
    background-color: #ddd;
    margin: 5px 0;
}

.ProgressBar {
    height: 20px;
    background-color: #a20fe6c7;;
}
</style>




    <body class ="missions">
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
                <li><a class="active" href="Missions.php">Missions</a></li>
                <li><a href="Storeship.php">Store ship</a></li>
                <li><a href="Crew.php">Crew recruitement</a></li>
                <li><a href="Profile.php">User profile</a></li>
                <li><a href="Logout.php">Log out</a> </li>
                </ul>
        </div>

        <div class ="container">
            <form action="Process_mission_selection.php" method="post">
                <div class="form">

                    <div>

                        <h3 class ="form-title">Select a Mission:</h3>

                            <?php
                            // If there is an error message we display it
                            if (isset($_SESSION["error_message"])) {
                                echo "<div class='error-message'>" . $_SESSION["error_message"] . "</div>";
                                unset($_SESSION["error_message"]); // Then we delete the error message from the session variable
                            }
                            if (isset($_SESSION["sucess_message"])) {
                                echo "<div class='sucess-message'>" . $_SESSION["sucess_message"] . "</div>";
                                unset($_SESSION["sucess_message"]); // Then we delete the error message from the session variable
                            }
                            ?>
  
                        <div class="navbar">
                        <ul>
                        <li><a class="active">Sort By : </a></li>
                            <li><a href="Missions.php?sort=cargo">  Cargo</a></li>
                            <li><a href="Missions.php?sort=reward"> Reward</a></li>
                            <li><a href="Missions.php?sort=range">  Range</a></li>
                        </ul>
                        </div>



                            <!-- box to select a mission -->
                            <select id="MissionSelect" name="MissionSelect">
                                <?php
                                
                                // Tri des missions
                                if (isset($_GET['sort'])) {
                                    $sort = $_GET['sort'];
                                    usort($_SESSION["missions"], function($a, $b) use ($sort) {
                                        switch ($sort) {
                                            case 'cargo':
                                                return $a['cargo'] - $b['cargo'];
                                            case 'reward':
                                                return $a['reward'] - $b['reward'];
                                            case 'range':
                                                // Supposons que vous ayez une clé 'range' dans vos données de mission
                                                return $a['distance'] - $b['distance'];
                                            default:
                                                return 0; // Pas de tri
                                        }
                                    });
                                }
                                
                                
                                    // Verification if the user is not already doing the mission
                                    foreach ($_SESSION["missions"] as $mission) {
                                        $isAlreadyBeingDone = false;
                                        foreach ($_SESSION["missions_player"] as $ownedmission) {
                                            if ($mission["mission_id"] == $ownedmission["mission_id"]) {
                                                $isAlreadyBeingDone = true;
                                                break;
                                            }
                                        }

                                        // If the mission is already being done by the player, we do not display it in the form
                                        // Else we display the mission, with its id, cargo, distance and reward
                                        if (!$isAlreadyBeingDone) {
                                            echo "<option value=" . $mission["mission_id"] . ">" .
                                                " Planet: " .       $mission["planet_name"] .
                                                " - Cargo: " .       $mission["cargo"] .
                                                " - Range: " .  $mission["distance"] .
                                                " - Reward: " .    $mission["reward"] . "$" .
                                                " </option>";
                                        }
                                    }
                                ?>
                            </select>

                        <h3 class ="form-title">Select a spaceship:</h3>
                            <!-- box to select an owned spaceship for the mission -->
                            <select id="ShipSelect" name="ShipSelect">
                                <?php

                                    foreach ($_SESSION["spaceships_player"] as $playerspaceship) {

                                        // we want to verify that the ship is not already used for another mission
                                        $SpaceshipAlreadyUsed = false;
                                        foreach ($_SESSION["missions_player"] as $playermission){
                                            if ($playermission["user_spaceship_id"] == $playerspaceship["user_spaceship_id"]){
                                                $SpaceshipAlreadyUsed = true;
                                            }
                                        }

                                        // Display all the spaceships that the player owns and that are not already used in another mission, being done by the player.
                                        // with useful information about the spaceship such as the cargo capacity, it's range and it's speed
                                        if (!$SpaceshipAlreadyUsed){ // test if the value is false
                                            echo "<option value='" . $playerspaceship["spaceship_id"] . "'>" .
                                                $playerspaceship["name"] .
                                                "(Lvl " . $playerspaceship["level"] . ")" .
                                                " Cargo: " . $playerspaceship["cargo_capacity"] .
                                                " - Range: " . $playerspaceship["range"] .
                                                " - Speed: " . $playerspaceship["speed"] .
                                                "</option>";
                                        }

                                    }
                                ?>
                            </select>


                        <h3 class ="form-title">Select a crew member: (optional)</h3>
                            <!-- box to select an owned crew member for the mission (optional) -->
                            <select id="CrewSelect" name="CrewSelect">
                                <?php

                                    foreach ($_SESSION["crews_player"] as $playercrew) {

                                        // we want to verify that the crew member is not already used for another mission
                                        $CrewAlreadyUsed = false;
                                        foreach ($_SESSION["missions_player"] as $playermission){
                                            if ($playermission["user_crew_id"] == $playercrew["user_crew_id"]){
                                                $CrewAlreadyUsed = True;
                                            }
                                        }

                                        // Display all the crew that the player owns and that are not already used in another mission, being done by the player.
                                        if (!$CrewAlreadyUsed){ // test if the value is false
                                            echo "<option value='" . $playercrew["crew_id"] . "'>" .
                                                $playercrew["name"] . " - buff type: " . $playercrew["buff_type"] .
                                                "</option>";
                                        }

                                    }
                                    echo "<option value='null'>". "No crew". "</option>";
                                ?>
                            </select>

                    </div>

                    <div>
                        <button type="submit" class="action-button" name="selectMission">Select Mission</button>
                    </div>

                </div>
            </form>

            <div class="form">
                <h3 class ="form-title">Your Missions:</h3>

                <?php
                if (isset($_SESSION["error_message2"])) {
                echo "<div class='error-message'>" . $_SESSION["error_message2"] . "</div>";
                unset($_SESSION["error_message2"]); // Then we delete the error message from the session variable
                }
                // If there is a sucess message we display it
                if (isset($_SESSION['sucess_message2'])) {
                echo "<div class='sucess-message'>" . $_SESSION["sucess_message2"] . "</div>";
                unset($_SESSION['sucess_message2']); // Then we delete the error message from the session variable
                }
                ?>

                <ul>
                    <?php

                        // Use of the session variables to get the list of missions being done by the player
                        // We display the info of each of the user's missions in a html table
                        // the first line is just used to know what information is showed in this column
                        echo "<table>";

                            echo "<tr>" .
                                "<td>" .  "Planet" .   "</td>" .
                                "<td>" .  " Reward" .      "</td>" .
                                "<td>" .  " Spaceship" .   "</td>" .
                                "<td>" .  " Crew" .        "</td>" .
                                "<td>" .  " Duration" .    "</td>" .
                                "<td>" .  " Fuel Bill" .    "</td>" .
                            "</tr>";

                            foreach ($_SESSION["missions_player"] as $mission) {

                                // We search the user's spaceship in the "spaceships_player" session variable to get its name
                                foreach ($_SESSION["spaceships_player"] as $UserSpaceship) {
                                    if ($UserSpaceship["user_spaceship_id"] == $mission["user_spaceship_id"]) {
                                        $selectedUserShip = $UserSpaceship;
                                        break;
                                    }
                                }

                                // We search the user's crew members in the "crews_player" session variable to get its name
                                $selectedUserCrew = null;
                                foreach ($_SESSION["crews_player"] as $UserCrew) {
                                    if ($UserCrew["user_crew_id"] == $mission["user_crew_id"]) {
                                        $selectedUserCrew = $UserCrew;
                                        break;
                                    }
                                }

                                // We verify if there is a crew member for the mission and if there is one we display its name
                                if(isset($selectedUserCrew)){
                                    $CrewName = $selectedUserCrew["name"];
                                }
                                // If there isn't any crew member for the crew member we display none instead of the name
                                else {
                                    $CrewName = "none" ;
                                }

                                // We display a line in the html table with all the info of the mission
                                // such as the mission id, its reward, the spaceship's name, the name of the crew member or none, and the time of the mission
                                    echo "<tr>";
                                        ?>
                                        <!-- Planet column displays image of planet -->
                                            <td>
                                                <img src="<?php echo $mission['photo']; ?>" alt="<?php echo $mission['photo']; ?>" width="100" height="100" >
                                            </td>

                                        <!-- reward column displays the reward of the mission -->
                                            <?php
                                            echo
                                            "<td>" .
                                                    $mission["new_reward"] . "$" .
                                            "</td>" ;
                                            ?>

                                        <!-- spaceship column displays the image of the spaceship used in the mission -->
                                            <td>
                                                <img src="<?php echo $selectedUserShip['photo']; ?>" alt="<?php echo $selectedUserShip['photo']; ?>" width="100" height="100" >
                                            </td>

                                        <!-- Crew column displays the image of the crew of the crew used in the mission -->
                                            <?php if($selectedUserCrew!=null){?>
                                            <td>
                                                <img src="<?php echo $selectedUserCrew['photo']; ?>" alt="<?php echo $selectedUserCrew['photo']; ?>" width="100" height="100" >
                                            </td>
                                            <?php } else {
                                                echo "<td>".''."</td>";
                                            }
                                        // Timer column displays the time remaining for the mission
                                            $timer = $mission['time_of_end'] - time();
                                            if ($timer < 0){
                                                $timer = "finished";
                                                echo
                                                    "<td>" .
                                                    $timer .
                                                    "</td>" ;

                                            } else {
                                                echo
                                                    "<td>" .
                                                    $timer . "sec" .
                                                    "</td>" ;
                                            }

                                            if ($timer < 0) {
                                                $timerText = "finished";
                                            } else {
                                                $timerText = $timer . "s";
                                                $animationDuration = $timer . 's'; // Durée de l'animation basée sur le timer
                                            }
                                        // fuel spent
                                            echo
                                                "<td>" .
                                                $mission["fuel_spent"] . "$" .
                                                "</td>" ;
                                            echo
                                    "</tr>";
                                        
                                        // Ligne pour la barre de progression (animation)
                                    echo "<tr>";
                                    echo "<td colspan='6'>"; // Assurez-vous que '5' est le nombre total de colonnes dans votre tableau
                                    if ($timer == 'finished') {
                                        echo "Mission finished.";
                                    } else {
                                        $animationDuration = max($timer, 1) . 's'; // Durée de l'animation en secondes
                                        echo "<div class='ProgressBarContainer'>";
                                        echo "<div class='ProgressBar' style='animation: fillAnimation {$animationDuration} linear;'></div>";
                                        echo "</div>";
                                    }
                                    echo "</td>";
                                    echo "</tr>";
                            }
                        echo "</table>";

                    ?>
                </ul>
                <form action="Process_collect.php" method="post">
                    <div>
                        <button type="submit" class="action-button" name="collect"> Collect </button>
                    </div>
                </form>
            </div>
        </div>

        <!-- button used to go to the Upgradeship.php page -->
        <form action="Create_mission.php" method="post">
            <div>
                <button type="submit" class="action-button2" name="Create_mission">Create Mission</button>
            </div>
        </form>

    </body>

</html>
