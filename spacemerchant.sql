-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Hôte : 127.0.0.1
-- Généré le : dim. 12 nov. 2023 à 15:49
-- Version du serveur : 10.4.28-MariaDB
-- Version de PHP : 8.2.4

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Base de données : `spacemerchant`
--

-- --------------------------------------------------------

--
-- Structure de la table `crew`
--

CREATE TABLE `crew` (
  `crew_id` int(11) NOT NULL,
  `name` varchar(255) DEFAULT NULL,
  `photo` varchar(255) DEFAULT NULL,
  `description` text DEFAULT NULL,
  `price` int(11) DEFAULT NULL,
  `buff_coef` decimal(3,2) NOT NULL,
  `buff_type` varchar(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Déchargement des données de la table `crew`
--

INSERT INTO `crew` (`crew_id`, `name`, `photo`, `description`, `price`, `buff_coef`, `buff_type`) VALUES
(1, 'Flash', 'picture/flash.png', 'He has been fast his whole life and has been nicknamed flash. Gives a 20% speed buff\r\n', 1000, 1.20, 'speed'),
(2, 'The Negociator', 'picture/the negociator.png', 'He has always been very good at negociating with other merchants in order to get a bigger reward. Gives a 20% reward buff', 1000, 1.20, 'reward'),
(3, 'Tetris Man', 'picture/tetris man.png', 'He has played tetris his entire childhood and knows exactly how to stock cargo to save space. Gives a 20% cargo capacity buff.', 1000, 1.20, 'cargo_capacity'),
(4, 'Granny', 'picture/granny.png', 'Your grandmother, she has some cookies for you, but especially she helps you reduce your fuel consumption. Reduces your consumption to only 80% of fuel consumption.', 1000, 0.80, 'fuel_effeciency');

-- --------------------------------------------------------

--
-- Structure de la table `mission`
--

CREATE TABLE `mission` (
  `mission_id` int(11) NOT NULL,
  `name` varchar(255) NOT NULL,
  `cargo` int(11) DEFAULT NULL,
  `planet_id` int(11) DEFAULT NULL,
  `reward` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Déchargement des données de la table `mission`
--

INSERT INTO `mission` (`mission_id`, `name`, `cargo`, `planet_id`, `reward`) VALUES
(10, 'first mission: exploration of bluewy', 10, 1, 100),
(11, 'base implementation on bluewy', 18, 1, 150),
(20, 'browny: planet exploration', 14, 2, 230),
(21, 'material extraction on browny', 16, 2, 250),
(30, 'crusty: planet exploration', 20, 3, 400),
(31, 'mega base on crusty', 90, 3, 1200),
(32, 'research facilty on crusty', 25, 3, 500),
(40, 'marble: planet exploration', 20, 4, 600),
(41, 'city implementation on marble', 60, 4, 1000),
(50, 'mars: planet exploration', 20, 5, 800),
(51, 'base implementation on mars', 25, 5, 800),
(60, 'navy: planet exploration', 20, 6, 1200),
(61, 'underwater research facilty on navy', 25, 6, 1500),
(70, 'Orangy: planet exploration', 100, 7, 1400),
(71, 'small city on orangy', 120, 7, 1700),
(72, 'megacity implementation on orangy', 220, 7, 2000),
(80, 'purple: planet exploration', 100, 8, 1600),
(81, 'medium base on purple', 170, 8, 2000),
(82, 'advanced research on purple', 260, 8, 2200),
(90, 'wavy: planet exploration', 100, 9, 1800),
(91, 'research facility on wavy', 100, 9, 2200),
(100, 'whity: planet exploration', 500, 10, 5000),
(10002, '', 10, 1, 30);

-- --------------------------------------------------------

--
-- Structure de la table `planet`
--

CREATE TABLE `planet` (
  `planet_id` int(11) NOT NULL,
  `planet_name` varchar(255) DEFAULT NULL,
  `distance` int(11) NOT NULL,
  `photo` varchar(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Déchargement des données de la table `planet`
--

INSERT INTO `planet` (`planet_id`, `planet_name`, `distance`, `photo`) VALUES
(1, 'Bluewy', 3, 'picture/bluewy.jpg'),
(2, 'Browny', 7, 'picture/browny.jpg'),
(3, 'Crusty', 10, 'picture/crusty.jpg'),
(4, 'Marble', 12, 'picture/marble.jpg'),
(5, 'Mars', 15, 'picture/mars.jpg'),
(6, 'Navy', 20, 'picture/navy.jpg'),
(7, 'Orangy', 22, 'picture/orangy.jpg'),
(8, 'Purple', 28, 'picture/purple.jpg'),
(9, 'Wavy', 30, 'picture/wavy.jpg'),
(10, 'Whity', 50, 'picture/whity.jpg');

-- --------------------------------------------------------

--
-- Structure de la table `spaceship`
--

CREATE TABLE `spaceship` (
  `spaceship_id` int(11) NOT NULL,
  `cargo_capacity` int(11) DEFAULT NULL,
  `fuel_efficiency` decimal(3,1) DEFAULT NULL,
  `price` int(11) DEFAULT NULL,
  `speed` int(11) NOT NULL,
  `range` int(11) NOT NULL,
  `level` int(11) NOT NULL,
  `spaceship_info_id` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Déchargement des données de la table `spaceship`
--

INSERT INTO `spaceship` (`spaceship_id`, `cargo_capacity`, `fuel_efficiency`, `price`, `speed`, `range`, `level`, `spaceship_info_id`) VALUES
(0, 12, 5.0, 0, 100, 6, 1, 0),
(1, 14, 4.5, 100, 110, 7, 2, 0),
(2, 16, 4.0, 120, 120, 8, 3, 0),
(3, 18, 3.5, 140, 130, 9, 4, 0),
(4, 20, 3.0, 160, 140, 10, 5, 0),
(5, 20, 9.0, 1500, 250, 12, 1, 1),
(6, 22, 8.0, 300, 275, 14, 2, 1),
(7, 25, 7.0, 350, 300, 16, 3, 1),
(8, 28, 6.0, 400, 325, 18, 4, 1),
(9, 30, 5.0, 450, 350, 20, 5, 1),
(10, 60, 9.0, 1500, 120, 12, 1, 2),
(11, 70, 8.0, 300, 130, 14, 2, 2),
(12, 80, 7.0, 350, 140, 16, 3, 2),
(13, 90, 6.0, 400, 150, 18, 4, 2),
(14, 100, 5.0, 450, 160, 20, 5, 2),
(15, 40, 8.0, 1500, 160, 12, 1, 3),
(16, 45, 7.0, 300, 180, 14, 2, 3),
(17, 50, 6.0, 350, 200, 16, 3, 3),
(18, 55, 5.0, 400, 220, 18, 4, 3),
(19, 60, 4.0, 450, 240, 20, 5, 3),
(20, 100, 16.0, 5000, 500, 22, 1, 4),
(21, 110, 14.0, 700, 550, 24, 2, 4),
(22, 120, 12.0, 800, 600, 26, 3, 4),
(23, 130, 10.0, 900, 650, 28, 4, 4),
(24, 140, 8.0, 1000, 700, 30, 5, 4),
(25, 220, 16.0, 5000, 200, 22, 1, 5),
(26, 240, 14.0, 700, 225, 24, 2, 5),
(27, 260, 12.0, 800, 250, 26, 3, 5),
(28, 280, 10.0, 900, 275, 28, 4, 5),
(29, 300, 8.0, 1000, 300, 30, 5, 5),
(30, 140, 14.0, 5000, 350, 22, 1, 6),
(31, 155, 12.0, 700, 375, 24, 2, 6),
(32, 170, 10.0, 800, 400, 26, 3, 6),
(33, 190, 8.0, 900, 425, 28, 4, 6),
(34, 210, 6.0, 1000, 450, 30, 5, 6),
(35, 300, 22.0, 15000, 700, 30, 1, 7),
(36, 350, 19.0, 2000, 800, 35, 2, 7),
(37, 400, 16.0, 2500, 900, 40, 3, 7),
(38, 450, 13.0, 3000, 1000, 45, 4, 7),
(39, 500, 10.0, 3500, 1100, 50, 5, 7);

-- --------------------------------------------------------

--
-- Structure de la table `spaceship_info`
--

CREATE TABLE `spaceship_info` (
  `spaceship_info_id` int(11) NOT NULL,
  `name` varchar(255) NOT NULL,
  `description` text NOT NULL,
  `photo` varchar(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Déchargement des données de la table `spaceship_info`
--

INSERT INTO `spaceship_info` (`spaceship_info_id`, `name`, `description`, `photo`) VALUES
(0, 'Basic', 'Starter spaceship. This is a rust bucket but it\'ll be able to do the first few missions for you to able to buy your first real spaceship.', 'picture/basic.png'),
(1, 'StellarRacer MK-I', 'Medium spaceship made for speed. Three afterburners take you to new speeds with a streamlined body that slips easily through space.', 'picture/fasty.png'),
(2, 'Freighter MK-I', 'Medium ship made to transport cargo. Its big size gives it the space to carry large amount of cargo.', 'picture/biggy.png'),
(3, 'Swift MK-I', 'Medium ship with average speed and cargo and slighty better fuel effeciency. It was designed to travel quite fast with a cargo bay that gives it the possibility of transporting a good amount of cargo.', 'picture/medium average.png'),
(4, 'StellarRacer MK-II', 'Big ship made for speed. One of the fastest in the galaxy thanks to its 5 big thrust engines, it takes you to speeds only a small part of the galaxy have ever been.', 'picture/supersonic.png'),
(5, 'Freighter MK-II', 'Big ship, one of the largest in the galaxy, only you will able to do certain missions thanks to the spaceship\'s enormous cargo bay capable of transporting almost any amount of cargo.', 'picture/huge.png'),
(6, 'Swift MK-II', 'Big ship with average speed and cargo and slighty better fuel effeciency. This spaceship rivals with the best spaceships in the galaxy with a very good speed and a very good cargo capacity making it an spaceship capable of doing most missions you will be offered.', 'picture/big average.png'),
(7, 'Ultimate', 'Best ship in the galaxy with insane speed and cargo capacity capable of doing any mission. The size of the ship is absolutly gigantic with thrust engines bigger than anything existing in the galaxy making this spaceship faster than anyone could have ever imagined, while transporting more cargo than any other ship could ever do. This spaceship is an absolute beast.', 'picture/ultimate.png');

-- --------------------------------------------------------

--
-- Structure de la table `user`
--

CREATE TABLE `user` (
  `user_id` int(11) NOT NULL,
  `f_name` varchar(255) DEFAULT NULL,
  `l_name` varchar(255) DEFAULT NULL,
  `email` varchar(255) DEFAULT NULL,
  `pseudo` varchar(255) DEFAULT NULL,
  `password` varchar(255) DEFAULT NULL,
  `money` int(11) NOT NULL DEFAULT 0
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Structure de la table `user_crew`
--

CREATE TABLE `user_crew` (
  `user_crew_id` int(11) NOT NULL,
  `user_id` int(11) DEFAULT NULL,
  `crew_id` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Structure de la table `user_mission`
--

CREATE TABLE `user_mission` (
  `user_mission_id` int(11) NOT NULL,
  `user_id` int(11) DEFAULT NULL,
  `user_spaceship_id` int(11) DEFAULT NULL,
  `user_crew_id` int(11) DEFAULT NULL,
  `mission_id` int(11) DEFAULT NULL,
  `time_of_start` timestamp NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp(),
  `time_of_end` int(30) DEFAULT NULL,
  `new_reward` int(11) NOT NULL,
  `fuel_spent` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Structure de la table `user_spaceship`
--

CREATE TABLE `user_spaceship` (
  `user_spaceship_id` int(11) NOT NULL,
  `user_id` int(11) DEFAULT NULL,
  `spaceship_id` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Index pour les tables déchargées
--

--
-- Index pour la table `crew`
--
ALTER TABLE `crew`
  ADD PRIMARY KEY (`crew_id`);

--
-- Index pour la table `mission`
--
ALTER TABLE `mission`
  ADD PRIMARY KEY (`mission_id`),
  ADD KEY `planet_id` (`planet_id`);

--
-- Index pour la table `planet`
--
ALTER TABLE `planet`
  ADD PRIMARY KEY (`planet_id`);

--
-- Index pour la table `spaceship`
--
ALTER TABLE `spaceship`
  ADD PRIMARY KEY (`spaceship_id`),
  ADD KEY `cle etrangere` (`spaceship_info_id`);

--
-- Index pour la table `spaceship_info`
--
ALTER TABLE `spaceship_info`
  ADD PRIMARY KEY (`spaceship_info_id`);

--
-- Index pour la table `user`
--
ALTER TABLE `user`
  ADD PRIMARY KEY (`user_id`);

--
-- Index pour la table `user_crew`
--
ALTER TABLE `user_crew`
  ADD PRIMARY KEY (`user_crew_id`),
  ADD KEY `user_id` (`user_id`),
  ADD KEY `user_crew_ibfk_2` (`crew_id`);

--
-- Index pour la table `user_mission`
--
ALTER TABLE `user_mission`
  ADD PRIMARY KEY (`user_mission_id`),
  ADD KEY `user_id` (`user_id`),
  ADD KEY `user_spaceship_id` (`user_spaceship_id`),
  ADD KEY `user_crew_id` (`user_crew_id`),
  ADD KEY `mission_id` (`mission_id`);

--
-- Index pour la table `user_spaceship`
--
ALTER TABLE `user_spaceship`
  ADD PRIMARY KEY (`user_spaceship_id`),
  ADD KEY `user_id` (`user_id`),
  ADD KEY `spaceship_id` (`spaceship_id`);

--
-- AUTO_INCREMENT pour les tables déchargées
--

--
-- AUTO_INCREMENT pour la table `crew`
--
ALTER TABLE `crew`
  MODIFY `crew_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;

--
-- AUTO_INCREMENT pour la table `mission`
--
ALTER TABLE `mission`
  MODIFY `mission_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=10003;

--
-- AUTO_INCREMENT pour la table `planet`
--
ALTER TABLE `planet`
  MODIFY `planet_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=13;

--
-- AUTO_INCREMENT pour la table `spaceship`
--
ALTER TABLE `spaceship`
  MODIFY `spaceship_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=40;

--
-- AUTO_INCREMENT pour la table `spaceship_info`
--
ALTER TABLE `spaceship_info`
  MODIFY `spaceship_info_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=8;

--
-- AUTO_INCREMENT pour la table `user`
--
ALTER TABLE `user`
  MODIFY `user_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- AUTO_INCREMENT pour la table `user_crew`
--
ALTER TABLE `user_crew`
  MODIFY `user_crew_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=10;

--
-- AUTO_INCREMENT pour la table `user_mission`
--
ALTER TABLE `user_mission`
  MODIFY `user_mission_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=58;

--
-- AUTO_INCREMENT pour la table `user_spaceship`
--
ALTER TABLE `user_spaceship`
  MODIFY `user_spaceship_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=28;

--
-- Contraintes pour les tables déchargées
--

--
-- Contraintes pour la table `mission`
--
ALTER TABLE `mission`
  ADD CONSTRAINT `mission_ibfk_1` FOREIGN KEY (`planet_id`) REFERENCES `planet` (`planet_id`);

--
-- Contraintes pour la table `spaceship`
--
ALTER TABLE `spaceship`
  ADD CONSTRAINT `cle etrangere` FOREIGN KEY (`spaceship_info_id`) REFERENCES `spaceship_info` (`spaceship_info_id`);

--
-- Contraintes pour la table `user_crew`
--
ALTER TABLE `user_crew`
  ADD CONSTRAINT `user_crew_ibfk_1` FOREIGN KEY (`user_id`) REFERENCES `user` (`user_id`),
  ADD CONSTRAINT `user_crew_ibfk_2` FOREIGN KEY (`crew_id`) REFERENCES `crew` (`crew_id`);

--
-- Contraintes pour la table `user_mission`
--
ALTER TABLE `user_mission`
  ADD CONSTRAINT `user_mission_ibfk_1` FOREIGN KEY (`user_id`) REFERENCES `user` (`user_id`),
  ADD CONSTRAINT `user_mission_ibfk_2` FOREIGN KEY (`user_spaceship_id`) REFERENCES `user_spaceship` (`user_spaceship_id`),
  ADD CONSTRAINT `user_mission_ibfk_3` FOREIGN KEY (`user_crew_id`) REFERENCES `user_crew` (`user_crew_id`),
  ADD CONSTRAINT `user_mission_ibfk_4` FOREIGN KEY (`mission_id`) REFERENCES `mission` (`mission_id`);

--
-- Contraintes pour la table `user_spaceship`
--
ALTER TABLE `user_spaceship`
  ADD CONSTRAINT `user_spaceship_ibfk_1` FOREIGN KEY (`user_id`) REFERENCES `user` (`user_id`),
  ADD CONSTRAINT `user_spaceship_ibfk_2` FOREIGN KEY (`spaceship_id`) REFERENCES `spaceship` (`spaceship_id`);
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
