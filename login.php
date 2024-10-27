<?php
    session_start();

    if (empty($_POST['email']) || empty($_POST['password'])) {
        header("Location: Connexion.php");
        exit();
    }
    // we put the database called "spacemerchant" in a variable called $bdd
    $bdd = new PDO("mysql:host=localhost;dbname=spacemerchant;charset=utf8", "root", "");

    $email = $_POST['email'];
    $password = $_POST['password'];

    $req = $bdd->prepare("SELECT * FROM user WHERE email = ?");
    $req->execute([$email]);
    $user = $req->fetch(PDO::FETCH_ASSOC);

    if ($user && password_verify($password, $user['password'])) {
        // The user is authentified succesfully
        $_SESSION["email"] = $email; // Stock the email of the user in a session variable
        $_SESSION["user_id"] = $user["user_id"]; // Stock the user's id in a session variable
        $_SESSION["Nickname"] = $user["pseudo"]; // Stock the pseudo in a session variable
        $_SESSION["money"] = $user["money"]; // Stock the user's money in a session variable

    // Recuperation of different data from the database and put in session variables in order to use them in the other php pages
        // Recuperation of the crew owned by the user
            $queryCrew = $bdd->prepare("SELECT * FROM crew c JOIN user_crew uc ON c.crew_id = uc.crew_id WHERE uc.user_id = ?");
            $queryCrew->execute([$user["user_id"]]);
            $_SESSION["crews_player"] = $queryCrew->fetchAll(PDO::FETCH_ASSOC);

        // Recuperation of the spaceships owned by the user
            $querySpaceships = $bdd->prepare("Select * FROM user_spaceship X, spaceship S, spaceship_info I 
            where X.spaceship_id=S.spaceship_id and S.spaceship_info_id=I.spaceship_info_id and X.user_id=?;");
            $querySpaceships->execute([$user["user_id"]]);
            $_SESSION["spaceships_player"] = $querySpaceships->fetchAll(PDO::FETCH_ASSOC);

        // Recuperation of the missions being done by the player
            $queryMissions = $bdd->prepare("SELECT * FROM mission m, user_mission um, planet p WHERE m.mission_id = um.mission_id AND m.planet_id = p.planet_id AND um.user_id = ?");
            $queryMissions->execute([$user["user_id"]]);
            $_SESSION["missions_player"] = $queryMissions->fetchAll(PDO::FETCH_ASSOC);

        // Recuperation of the all crew in game
            $queryCrews = $bdd->query("SELECT * FROM crew");
            $_SESSION["crews"] = $queryCrews->fetchAll(PDO::FETCH_ASSOC);

        // Recuperation of all the spaceships in the game
            // some attributes are renamed for this session variable
            $querySpaceships = $bdd->query("SELECT spaceship.spaceship_id, spaceship.cargo_capacity, spaceship.fuel_efficiency, spaceship.price, spaceship.speed, spaceship.range, spaceship.level, spaceship_info.name AS ship_name, spaceship_info.description AS ship_description, spaceship_info.photo AS ship_photo
            FROM spaceship INNER JOIN spaceship_info ON spaceship.spaceship_info_id = spaceship_info.spaceship_info_id");
            $_SESSION["spaceships"] = $querySpaceships->fetchAll(PDO::FETCH_ASSOC);

        // Recuperation of all the missions in the game
            $queryMissions = $bdd->query("SELECT * FROM mission M, planet P WHERE M.planet_id=P.planet_id");
            $_SESSION["missions"] = $queryMissions->fetchAll(PDO::FETCH_ASSOC);

        // Variables used for the display of spaceships and crews in "Storeship.php", "Upgradeship.php" and "crew.php" filled in by "display.php"
            $_SESSION["dispShip"]=null;
            $_SESSION["dispCrew"]=null;

        // redirects to the Home page
            header("Location: Home.php");


        // Verifies if the session variable "inactive" is defined, else it is defined to 3600 seconds (1 hour)
            if (!isset($_SESSION['inactive'])) {
                $_SESSION['inactive'] = 3600; // 1 hour in seconds
            }

        // Verifies if the user has been inactive for more than an hour
            if (isset($_SESSION['timeout']) && time() - $_SESSION['timeout'] > $_SESSION['inactive']) {
                // If the user has been inactive for more than an hour, he is disconnected
                session_unset();
                session_destroy();
                header("Location: Connexion.php"); // He is therefore redirected to the Connexion page
                exit();
            }
        // We update the timestamp of the last activity
            $_SESSION['timeout'] = time();

    } else {
        // case when authentication has failed
        $_SESSION['error_message'] = "Nom d'utilisateur ou mot de passe incorrect.";
        header("Location: Connexion.php"); // redirection to the connexion page with an error message
        exit();
    }

?>
