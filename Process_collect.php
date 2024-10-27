<?php

    session_start();

    // Verification if the user is connected
    if (!isset($_SESSION["user_id"])) {
        header("Location: Connexion.php");
        exit();
    }

    // variables to keep track of the Number of missions collected and the total money earned, used then in the message displayed on the missions page
    $NumberMissionCollected = 0;
    $TotalMoneyEarned = 0;

    foreach ($_SESSION['missions_player'] as $mission) {
        $remaining_time = $mission['time_of_end'] - time();
        if ($remaining_time < 0){

            // We calculate the new value of the User's Money
                $newUserMoney = $_SESSION['money'] + $mission['new_reward'] - $mission['fuel_spent'];
            // We create a variable for the player id
                $UserId = $_SESSION['user_id'];

            // Update of the player's money in the session variable
                $_SESSION["money"] = $newUserMoney;

            // We calculate the total money earned in order to show the player how much money his finished missions gives him
                $TotalMoneyEarned = $TotalMoneyEarned + $mission['new_reward'] - $mission['fuel_spent'];

            // Connexion to the database
                $bdd = new PDO("mysql:host=localhost;dbname=spacemerchant;charset=utf8", "root", "");

            // Update of the User's money in the database
                $updateMoneyQuery = $bdd->prepare("UPDATE user SET money = ? WHERE user_id = ?");
                $updateMoneyQuery->execute([$newUserMoney, $UserId]);

            // We want to delete the user's mission from the table user_mission as it is finished
                $updateMissionQuery = $bdd->prepare("DELETE FROM user_mission WHERE user_mission_id=?;");
                $updateMissionQuery->execute([$mission["user_mission_id"]]);

            // Update of the session variable "missions_player"
                $queryMissions = $bdd->prepare("SELECT * FROM mission m, user_mission um, planet p WHERE m.mission_id = um.mission_id AND m.planet_id = p.planet_id AND um.user_id = ?");
                $queryMissions->execute([$UserId]);
                $_SESSION["missions_player"] = $queryMissions->fetchAll(PDO::FETCH_ASSOC);

            // We add 1 to the number of missions finished in order to show the player how much money his finished missions gives him
                $NumberMissionCollected = $NumberMissionCollected + 1;
        }
    }

    if ($NumberMissionCollected > 0){
        // In the case where there is at least one mission finished
        $_SESSION['sucess_message2'] = "You have completed " . $NumberMissionCollected . " missions for a total of " . $TotalMoneyEarned . " $ earned !";
        header("Location: Missions.php");
        exit();

    } else {
        // In the case where there are no missions to be collected, because either there are no missions being done or none are finished
        $_SESSION['error_message2'] = "No mission is finished yet !";
        header("Location: Missions.php");
        exit();
    }

?>