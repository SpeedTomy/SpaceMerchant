<?php
    session_start();

    // Verifies if the user is connected
        if (!isset($_SESSION["user_id"])) {
            header("Location: Connexion.php");
            exit();
        }

    // Recuperation of the ID of the Spaceship to buy from the form
        if (isset($_POST["shipSelect"])) {
            $selectedShipId = $_POST["shipSelect"];

        // Search of the selected spaceship in the session variable called "spaceships"
            $selectedShip = null;
            foreach ($_SESSION["spaceships"] as $spaceship) {
                if ($spaceship["spaceship_id"] == $selectedShipId) {
                    $selectedShip = $spaceship;
                    break;
                }
            }

        // Verifies if the selected ship exists in the session variable
            if ($selectedShip) {
                $price = $selectedShip["price"];
                $userId = $_SESSION["user_id"];
                $userMoney = $_SESSION["money"];

            // Verifies if the player has enough money to buy the spaceship
                if ($userMoney >= $price) {

                // We subtract the ship's price from the money of the player
                    $newUserMoney = $userMoney - $price;

                // Update of the player's money in the session variable
                    $_SESSION["money"] = $newUserMoney;

                // Update of the player's money in the database
                    $bdd = new PDO("mysql:host=localhost;dbname=spacemerchant;charset=utf8", "root", "");
                    $updateMoneyQuery = $bdd->prepare("UPDATE user SET money = ? WHERE user_id = ?");
                    $updateMoneyQuery->execute([$newUserMoney, $userId]);

                // We add the newly bought spaceship into the table "user_spaceship"
                    $insertShipQuery = $bdd->prepare("INSERT INTO user_spaceship (user_id, spaceship_id) VALUES (?, ?)");
                    $insertShipQuery->execute([$userId, $selectedShipId]);

                // We update the "spaceships_player" session variable containing the spaceships owned by the player
                    $querySpaceships = $bdd->prepare("SELECT * FROM user_spaceship X, spaceship S, spaceship_info I WHERE X.spaceship_id = S.spaceship_id AND S.spaceship_info_id = I.spaceship_info_id AND X.user_id = ?");
                    $querySpaceships->execute([$userId]);
                    $_SESSION["spaceships_player"] = $querySpaceships->fetchAll(PDO::FETCH_ASSOC);

                // Redirect to the Storeship.php page with a success message (Transaction completed)
                    $_SESSION["sucess_message"] = "Transaction completed !";
                    header("Location: Storeship.php");
                    exit();

                    } else {
                        // In the case where the user doesn't have enough money
                        // He is redirected to the Storeship.php page with an error message (Not enough money to buy this spaceship)
                        $_SESSION["error_message"] = "Not enough money to buy the spaceship!";
                        header("Location: Storeship.php");
                        exit();
                    }

                } else {
                    // In the case where the crew member does not exist in the session variable
                    // Redirect to the Storeship.php page with an error message (Spaceship not found)
                    $_SESSION["error_message"] = "Spaceship not found";
                    header("Location: Storeship.php");
                    exit();
                }

            } else {
                // In the case where no data has been posted from the form, redirect to the Storeship.php page
                $_SESSION["error_message"] = "There're no longer any spaceship to buy!";
                header("Location: Storeship.php");
                exit();
        }
?>
