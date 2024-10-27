<?php
    session_start();

    // Verification if the user is connected
        if (!isset($_SESSION["user_id"])) {
            header("Location: Connexion.php");
            exit();
        }

    // Recuperation of the ID of the crew to buy from the form
        if (isset($_POST["crewSelect"])) {
            $selectedCrewId = $_POST["crewSelect"];

        // Search of the selected crew in the session variable called "crews"
            $selectedCrew = null;
            foreach ($_SESSION["crews"] as $crew) {
                if ($crew["crew_id"] == $selectedCrewId) {
                    $selectedCrew = $crew;
                    break;
                }
            }

        // Verify if the selected crew exists in the session variable.
            if ($selectedCrew) {
                $price = $selectedCrew["price"];
                $userId = $_SESSION["user_id"];
                $userMoney = $_SESSION["money"];

            // Verify if the player has enough money to buy the crew member
                if ($userMoney >= $price) {

                // We subtract the price of the crew from the money of the player
                    $newUserMoney = $userMoney - $price;

                // Update of the player's money in the session variable
                        $_SESSION["money"] = $newUserMoney;

                // Update of the player's money in the database
                    $bdd = new PDO("mysql:host=localhost;dbname=spacemerchant;charset=utf8", "root", "");
                    $updateMoneyQuery = $bdd->prepare("UPDATE user SET money = ? WHERE user_id = ?");
                    $updateMoneyQuery->execute([$newUserMoney, $userId]);

                // We add the newly bought crew member into the table "user_crew"
                    $insertCrewQuery = $bdd->prepare("INSERT INTO user_crew (user_id, crew_id) VALUES (?, ?)");
                    $insertCrewQuery->execute([$userId, $selectedCrewId]);

                // We update the "crews_player" session variable containing the crew owned by the player
                    $queryCrews = $bdd->prepare("SELECT * FROM user_crew X, crew C WHERE X.crew_id = C.crew_id AND X.user_id = ?");
                    $queryCrews->execute([$userId]);
                    $_SESSION["crews_player"] = $queryCrews->fetchAll(PDO::FETCH_ASSOC);

                // Redirection to the page Crew.php with a success message
                    $_SESSION["sucess_message"] = "Succesfully bought the Crew member !";
                    header("Location: Crew.php");
                    exit();

                } else {
                    // In the case where the user doesn't have enough money
                    // He is redirected to the Crew.php page with an error message (Not enough money to buy this crew member)
                    $_SESSION["error_message"] = "Not enough money to buy this crew member.";
                    header("Location: Crew.php");
                    exit();
                }

            } else {
                // In the case where the crew member does not exist in the session variable
                // Redirect to the Crew.php page with an error message (Crew member not found)
                $_SESSION["error_message"] = "Crew member not found.";
                header("Location: Crew.php");
                exit();
            }

        } else {
            // In the case where no data has been posted from the form, redirect to the Crew.php page
            header("Location: Crew.php");
            exit();
        }
?>
