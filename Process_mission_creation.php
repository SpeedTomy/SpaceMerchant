<?php

session_start();

// Verifies if the user is connected
    if (!isset($_SESSION["user_id"])) {
        header("Location: Connexion.php");
        exit();
    }

// Verifies if the values for the planet and the cargo exist
    if ( isset($_POST["planet"]) && isset($_POST["cargo"]) ) {

    // We put the info posted into variables
        $planetId = $_POST["planet"];
        $cargo = $_POST["cargo"];

    // Connexion to the database
        $bdd = new PDO("mysql:host=localhost;dbname=spacemerchant;charset=utf8", "root", "");

    // Recuperation of the all planets in game
        $queryplanet = $bdd->query("SELECT * FROM planet");
        $Planets = $queryplanet->fetchAll(PDO::FETCH_ASSOC);

    // We try and find the line of the planet chosen to get its info, such as its distance
        $planetselected = 1;
        foreach ($Planets as $planet) {
            if ($planet["planet_id"] == $planetId){
                $planetselected = $planet;
            }
        }

    // we calculate the reward depending on the distance of the selected planet and the chosen cargo
        $reward = $planetselected["distance"] * $cargo;

    // Recuperation of the all planets in game
        $insertNewMission = $bdd->prepare("INSERT INTO mission (cargo, planet_id, reward) VALUES (?, ?, ?)");
        $insertNewMission->execute([$cargo, $planetId, $reward]);

    // The user is redirected to the Missions.php page with a success message (The mission has been added to your missions)
        $_SESSION["sucess_message"] = "Mission has been successfully created.";
        header("Location: Create_mission.php");
        exit();
    } else {
        // In the case where no data has been posted from the form, redirect to the Create_missions.php page
        $_SESSION["error_message"] = "Mission could not be created!";
        header("Location: Create_mission.php");
        exit();
    }
?>