<?php
    session_start();

    // Verification if the user is connected
        if (!isset($_SESSION["user_id"])) {
            header("Location: Connexion.php");
            exit();
        }

    // Recuperation of the ID of the selected mission, the selected ship and also of the crew member in the case a crew member has been chosen
        if ( isset($_POST["MissionSelect"]) && isset($_POST["ShipSelect"]) ) {
            $selectedMissionId = $_POST["MissionSelect"];
            $selectedShipId = $_POST["ShipSelect"];
            $selectedCrewId = $_POST["CrewSelect"];


            // Search of the selected mission in the session variable called "missions"
            $selectedMission = null;
            foreach ($_SESSION["missions"] as $mission) {
                if ($mission["mission_id"] == $selectedMissionId) {
                    $selectedMission = $mission;
                    break;
                }
            }

            // Search of the selected ship in the session variable called "spaceships"
                $selectedUserShip = null;
                foreach ($_SESSION["spaceships_player"] as $UserSpaceship) {
                    if ($UserSpaceship["spaceship_id"] == $selectedShipId) {
                        $selectedUserShip = $UserSpaceship;
                        break;
                    }
                }

            // in the case that a member has also been selected for the mission
                $selectedUserCrew = null;
                if ($selectedCrewId != 'null') {
                    // Search of the selected crew in the session variable called "crews"
                    foreach ($_SESSION["crews_player"] as $UserCrew) {
                        if ($UserCrew["crew_id"] == $selectedCrewId) {
                            $selectedUserCrew = $UserCrew;
                            break;
                        }
                    }
                }else {
                    $selectedCrewId=null;
                }

            // We put the ship's range, cargo capacity, speed and fuel effeciency in new variables
                $ShipRange = $selectedUserShip["range"];
                $ShipCargo = $selectedUserShip["cargo_capacity"];
                $ShipSpeed = $selectedUserShip["speed"];
                $ShipFuelEfficiency = $selectedUserShip["fuel_efficiency"];
                $reward = $selectedMission["reward"];

            // We test the buff_type of the crew
                if ($selectedCrewId != null) {
                    if ($selectedUserCrew["buff_type"] == "cargo_capacity") {
                       $ShipCargo = $ShipCargo * $selectedUserCrew["buff_coef"];
                    }

                    if ($selectedUserCrew["buff_type"] == "speed") {
                        $ShipSpeed = $ShipSpeed * $selectedUserCrew["buff_coef"];
                    }

                    if ($selectedUserCrew["buff_type"] == "fuel_effeciency") {
                        $ShipFuelEfficiency = $ShipFuelEfficiency * $selectedUserCrew["buff_coef"];
                    }

                    if ($selectedUserCrew["buff_type"] == "reward"){
                        $reward = $reward * $selectedUserCrew["buff_coef"];
                    }

                }

            // Verifies that the mission and the ship have been chosen
            if ($selectedMission && $selectedUserShip) {
                // Verifies if the range is the spaceship is enough to do the mission
                if ($selectedMission["distance"] < $ShipRange) {
                    // Verifies if the cargo_capacity is the spaceship is enough to do the mission
                    if ($selectedMission["cargo"] < $ShipCargo) {

                        $UserId=$_SESSION["user_id"];

                    // We put user_spaceship_id of the selected spaceship into a variable to use it later for the insertion into the database
                        $selectedUserShipId = $selectedUserShip["user_spaceship_id"];

                    // We put user_crew_id of the selected spaceship into a variable to use it later for the insertion into the database
                        $selectedUserCrewId = null;
                        if ($selectedCrewId != null) {
                            $selectedUserCrewId = $selectedUserCrew["user_crew_id"];
                        }

                    // We calculate the amount of fuel spent by the spaceship during the mission
                        $FuelSpent = $mission["distance"] * $ShipFuelEfficiency;

                    // We calculate the time of the mission depending on the distance of the mission and the speed of the spaceship used for the mission
                        $timer = ($selectedMission["distance"]) / ($ShipSpeed);
                        // we multiply it by 3600 to have the time in seconds
                        $timer = $timer*3600;

                    // We calculate the time of end of the mission
                        $t = time();
                        $time_of_end = $t + $timer;

                    // Connexion to the database
                        $bdd = new PDO("mysql:host=localhost;dbname=spacemerchant;charset=utf8", "root", "");

                    // SQL query to add the user, the selected mission, the selected spaceship, and the potential crew member, the time of end, aswell as the fuel spent for the mission into the "user_mission" table
                        $insertCrewQuery = $bdd->prepare("INSERT INTO user_mission (user_id, mission_id, user_spaceship_id, user_crew_id, new_reward, time_of_end, fuel_spent) VALUES (?, ?, ?, ?, ?, ?, ?)");
                        $insertCrewQuery->execute([$UserId, $selectedMissionId, $selectedUserShipId, $selectedUserCrewId, $reward, $time_of_end, $FuelSpent]);

                    // Update of the session variable "missions_player"
                        $queryMissions = $bdd->prepare("SELECT * FROM mission m, user_mission um, planet p WHERE m.mission_id = um.mission_id AND m.planet_id = p.planet_id AND um.user_id = ?");
                        $queryMissions->execute([$UserId]);
                        $_SESSION["missions_player"] = $queryMissions->fetchAll(PDO::FETCH_ASSOC);

                        // The user is redirected to the Missions.php page with a success message (The mission has been added to your missions)
                        $_SESSION["sucess_message"] = "The mission has been added to your missions ";
                        header("Location: Missions.php");
                        exit();

                    } else {
                        // In the case where the user's spaceship has a smaller range than the distance to the planet
                        // He is redirected to the Missions.php page with an error message (The range of your spaceship is too small to do this mission)
                        $_SESSION["error_message"] = "The CARGO of your spaceship is too small to do this mission ";
                        header("Location: Missions.php");
                        exit();
                    }
                } else {
                    // In the case where the user's spaceship has a smaller range than the distance to the planet
                    // He is redirected to the Missions.php page with an error message (The range of your spaceship is too small to do this mission)
                    $_SESSION["error_message"] = "The RANGE of your spaceship is too small to do this mission";
                    header("Location: Missions.php");
                    exit();
                }
            }
        } else {
            // in the case where there isn't any value for MissionSelect or ShipSelect
                // This problem will always come from there not being any spaceship,
                // when the player doesn't have any spaceships, or when they are all used,
                // and as there are more missions than spaceships the problem will never come from the missions selection
            // In the case where no data has been posted from the form, redirect to the Missions.php page
            $_SESSION["error_message"] = "No spaceship has been chosen for the mission";
            header("Location: Missions.php");
            exit();
        }
?>