<?php
    session_start();

    // Verifies if the user is connected
        if (!isset($_SESSION["user_id"])) {
            header("Location: Connexion.php");
            exit();
        }

    // Connexion to the database
        $bdd = new PDO(
            "mysql:host=localhost;dbname=spacemerchant;charset=utf8",
            "root",
            ""
        );

    // Recuperation of the ID of the Spaceship to upgrade from the form
        if (isset($_POST["playerShipSelect"])) {
            $selectedShipId = $_POST["playerShipSelect"];

            // Search of the selectedship in the session variable called "spaceships"
                $selectedShip = null;
                foreach ($_SESSION["spaceships"] as $spaceship) {
                    if ($spaceship["spaceship_id"] == $selectedShipId) {
                        $selectedShip = $spaceship;
                        break;
                    }
                }
                $level = $selectedShip["level"];

            // Verifies if the level of the spaceship is already level 5
                if ($level>= 5) {

                // Redirects the user with to the "Upgradeship.php" page with an error message
                    $_SESSION["error_message"] = "Spaceship is already at maximum level!";
                    header("Location: Upgradeship.php");
                    exit();
                }

            // Recuperation of the upgrade price based on the next level of the ship
                $nextShip = null;
                foreach ($_SESSION["spaceships"] as $spaceship) {
                    if ($spaceship["spaceship_id"] == $selectedShipId +1)
                    {
                        $nextShip = $spaceship;
                        break;
                    }
                }
                $upgradePrice = $nextShip["price"];

                // Verifies if the user has enough money for the upgrade
                    if ($_SESSION["money"] >= $upgradePrice) {

                    // We subtract the upgrade price from the money of the player
                        $newMoney = $_SESSION["money"] - $upgradePrice;

                    // Update of the player's money in the session variable
                        $_SESSION["money"] = $newMoney;

                    // Update of the player's money in the database Mettre à jour l'argent de l'utilisateur dans la base de données
                        $updateMoneyQuery = $bdd->prepare("UPDATE user SET money = ? WHERE user_id = ?");
                        $updateMoneyQuery->execute([$newMoney, $_SESSION["user_id"]]);

                    // Update the database with the new level of the spaceship
                        $updateQuery = $bdd->prepare("UPDATE user_spaceship SET spaceship_id = ? WHERE user_id = ? and spaceship_id=?");
                        $updateQuery->execute([$selectedShipId +1, $_SESSION["user_id"],$selectedShipId]);

                    // Recuperation of the player's spaceships
                        $querySpaceships = $bdd->prepare("Select * FROM user_spaceship X, spaceship S, spaceship_info I where X.spaceship_id=S.spaceship_id 
                        and S.spaceship_info_id=I.spaceship_info_id and X.user_id=?;");
                        $querySpaceships->execute([$_SESSION["user_id"]]);
                        $_SESSION["spaceships_player"] = $querySpaceships->fetchAll(PDO::FETCH_ASSOC);


                    // Redirects the user to Upgradeship.php with a success message (Upgrade successful! Your spaceship is now at level ...)
                        $_SESSION["sucess_message"] = "Upgrade successful! Your spaceship is now at level " . $nextShip["level"];
                        header("Location: Upgradeship.php");
                        exit();

                    } else {
                        // In the case where the user doesn't have enough money
                        // Redirects the user to Upgradeship.php with an error message (Not enough money to upgrade the spaceship!)
                        $_SESSION["error_message"] = "Not enough money to upgrade the spaceship!";
                        header("Location: Upgradeship.php");
                        exit();
                    }

        }else {
            // In the case where no data has been posted from the form, redirect to the Upgradeship.php page
            $_SESSION["error_message"] = "You don't own any ship!";
            header("Location: Upgradeship.php");
            exit();
        }
?>
