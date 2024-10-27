<?php
session_start();

// Verification if the user is connected
if (!isset($_SESSION["user_id"])) {
    header("Location: Connexion.php");
    exit();
}

// Verification that a ship has been selected
if (isset($_POST["shipSelect"])) {
    // Recuperation of the ID of the spaceship to buy from the form
    $selectedShipId = $_POST["shipSelect"];

    // Search of the selected ship in the session variable called "spaceships"
    $selectedShip = null;
    foreach ($_SESSION["spaceships"] as $spaceship) {
        if ($spaceship["spaceship_id"] == $selectedShipId) {
            $selectedShip = $spaceship;
            break;
        }
    }

    // Verification if the selected spaceship exists in the session variable
    if ($selectedShip) {

        $_SESSION["dispShip"] = $selectedShip;
            header("Location: Storeship.php");
            exit();
    } else {
        // Redirection to the Storeship.php page with an error message (Spaceship not found)
        $_SESSION["error_message"] = "Spaceship not found.";
        header("Location: Storeship.php");
        exit();
    }
}



// Verification that a crew member has been selected
elseif (isset($_POST["crewSelect"])) {
    // Recuperation of the ID of the crew member to buy from the form
    $selectedCrewId = $_POST["crewSelect"];

    // Search of the selected crew in the session variable called "crews"
    $selectedCrew = null;
    foreach ($_SESSION["crews"] as $crew) {
        if ($crew["crew_id"] == $selectedCrewId) {
            $selectedCrew = $crew;
            break;
        }
    }
    // Verification if the selected crew exists in the session variable
    if ($selectedCrew) {

        $_SESSION["dispCrew"] = $selectedCrew;
        header("Location: Crew.php");
        exit();
    }
    else {
        // Redirection to the Crew.php page with an error message (crew not found)
        $_SESSION["error_message"] = "Crew not found";
        header("Location: Crew.php");
        exit();
    }
}



// Verification that a player's spaceship has been selected
elseif (isset($_POST["playerShipSelect"])) {
    // Recuperate the ID of the spaceship to upgrade from the form
    $selectedShipId = $_POST["playerShipSelect"];

    $selectedShip = null; // variable for the selected ship
    $ShipUpg = null; // variable for the next level of the selected ship

    // Search of the selected spaceship in the session variable called "spaceships"
    foreach ($_SESSION["spaceships"] as $spaceship) {
        if ($spaceship["spaceship_id"] == $selectedShipId) {
            $selectedShip = $spaceship; // the info of the selected ship is put into the "selectedShip" for later use
            break;
        }
    }
    // Verification that the level of the selected ship is under 5 (being the max level)
    if ($selectedShip["level"]<5){
        // Search of the next level of the selected spaceship in the session variable called "spaceships"
        foreach ($_SESSION["spaceships"] as $spaceship) {
            if ($spaceship["spaceship_id"] == $selectedShipId+1) {
                $ShipUpg = $spaceship;  // the info of the next level of the selected ship is put into the "ShipUpg" for later use
                break;
            }
        }

        // Verification that both the selected and the next level of the selected ship have been found
        if ($selectedShip && $ShipUpg) {
            // we put the info of the selected ship and the info of the next level in session variables to use them in a table in upgradeship.php
            $_SESSION["dispShip"] = $selectedShip;
            $_SESSION["dispShipUpg"] = $ShipUpg;
            header("Location: Upgradeship.php"); // we head back to the upgradeship.php page
            exit();
        }
    }
    // In the case of the level of the ship being 5
    if ($selectedShip["level"]==5) {
        if ($selectedShip) {
            // we put the info of only the selected ship as there is no next level above level 5
            $_SESSION["dispShip"] = $selectedShip;
            $_SESSION["dispShipUpg"] = null;
            header("Location: Upgradeship.php");
            exit();
        }
    }
    else {
        // Redirection to the Upgradeship.php page with an error message (spaceship not found)
        $_SESSION["error_message"] = "spaceship not found.";
        header("Location: Upgradeship.php");
        exit();
    }
}



else {
    // The user is redirected to the Home page if no data has been posted
    header("Location: Home.php");
    exit();
}

?>
