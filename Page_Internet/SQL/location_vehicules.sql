-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Hôte : 127.0.0.1:3306
-- Généré le : ven. 25 avr. 2025 à 11:02
-- Version du serveur : 8.3.0
-- Version de PHP : 8.2.18

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Base de données : `location_vehicules`
--
CREATE DATABASE IF NOT EXISTS `location_vehicules` DEFAULT CHARACTER SET utf8mb4 COLLATE utf8mb4_0900_ai_ci;
USE `location_vehicules`;

-- --------------------------------------------------------

--
-- Structure de la table `motorisation`
--

DROP TABLE IF EXISTS `motorisation`;
CREATE TABLE IF NOT EXISTS `motorisation` (
  `id` int NOT NULL AUTO_INCREMENT,
  `nom` varchar(50) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM AUTO_INCREMENT=6 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

--
-- Déchargement des données de la table `motorisation`
--

INSERT INTO `motorisation` (`id`, `nom`) VALUES
(1, 'Diesel'),
(2, 'Electrique'),
(3, 'Essence'),
(4, 'Hybride');

-- --------------------------------------------------------

--
-- Structure de la table `reservations`
--

DROP TABLE IF EXISTS `reservations`;
CREATE TABLE IF NOT EXISTS `reservations` (
  `id` int NOT NULL AUTO_INCREMENT,
  `id_vehicule` int NOT NULL,
  `id_utilisateur` int NOT NULL,
  `date_debut` date NOT NULL,
  `date_fin` date NOT NULL,
  PRIMARY KEY (`id`),
  KEY `fk_utilisateur` (`id_utilisateur`),
  KEY `fk_vehicule` (`id_vehicule`)
) ENGINE=MyISAM AUTO_INCREMENT=2 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

-- --------------------------------------------------------

--
-- Structure de la table `utilisateurs`
--

DROP TABLE IF EXISTS `utilisateurs`;
CREATE TABLE IF NOT EXISTS `utilisateurs` (
  `id` int NOT NULL AUTO_INCREMENT,
  `nom` varchar(100) DEFAULT NULL,
  `email` varchar(100) DEFAULT NULL,
  `password` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_0900_ai_ci DEFAULT NULL,
  `role` varchar(20) DEFAULT 'utilisateur',
  PRIMARY KEY (`id`)
) ENGINE=MyISAM AUTO_INCREMENT=4 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

--
-- Déchargement des données de la table `utilisateurs`
--

INSERT INTO `utilisateurs` (`id`, `nom`, `email`, `password`, `role`) VALUES
(1, 'Admin', 'Admin@site.com', 'Admin123', 'admin'),
(2, 'test', 'test@test.com', 'Test123', 'utilisateur'),
(3, 'test2', 'test2@test.com', 'Test123', 'utilisateur');

-- --------------------------------------------------------

--
-- Structure de la table `vehicules`
--

DROP TABLE IF EXISTS `vehicules`;
CREATE TABLE IF NOT EXISTS `vehicules` (
  `id` int NOT NULL AUTO_INCREMENT,
  `nom` varchar(100) DEFAULT NULL,
  `marque` varchar(100) DEFAULT NULL,
  `modele` varchar(100) DEFAULT NULL,
  `id_motorisation` int DEFAULT NULL,
  `prix_journalier` decimal(10,2) DEFAULT NULL,
  `image` varchar(255) DEFAULT NULL,
  `boite_auto` tinyint(1) DEFAULT '0',
  `nb_places` int DEFAULT '4',
  PRIMARY KEY (`id`),
  KEY `id_motorisation` (`id_motorisation`)
) ENGINE=MyISAM AUTO_INCREMENT=29 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

--
-- Déchargement des données de la table `vehicules`
--

INSERT INTO `vehicules` (`id`, `nom`, `marque`, `modele`, `id_motorisation`, `prix_journalier`, `image`, `boite_auto`, `nb_places`) VALUES
(2, 'Renault Clio', 'Renault', 'Clio V', 1, 50.00, '../public/images/67ed336fd404f_renault-clio-facelift-wm-argus_3.jpg', 0, 5),
(3, 'Tesla Model 3', 'Tesla', 'Model 3', 2, 120.00, NULL, 1, 5),
(4, 'Volkswagen Golf', 'Volkswagen', 'Golf 8', 1, 60.00, '../public/images/67ed33cc29ece_Volkswagen_Golf_8.jpg', 0, 5),
(5, 'BMW X1', 'BMW', 'X1', 2, 95.00, NULL, 1, 5),
(11, 'C3', 'Citroën', 'C3 Feel', 1, 37.90, NULL, 0, 5),
(9, 'Clio 5', 'Renault', 'Clio 5', 1, 39.99, NULL, 0, 5),
(10, '308', 'Peugeot', '308 GT', 2, 45.50, NULL, 1, 5),
(12, 'Twingo', 'Renault', 'Twingo Electric', 3, 34.00, NULL, 1, 4),
(13, 'Megane', 'Renault', 'Mégane IV', 2, 49.99, NULL, 1, 5),
(14, 'DS3', 'DS', 'DS3 Crossback', 2, 52.00, NULL, 1, 5),
(15, '208', 'Peugeot', '208 Style', 1, 41.20, NULL, 0, 5),
(16, 'Tesla Model 3', 'Tesla', 'Model 3', 3, 89.00, NULL, 1, 5),
(17, 'Zoe', 'Renault', 'Zoe E-Tech', 3, 42.00, NULL, 1, 5),
(18, 'Golf', 'Volkswagen', 'Golf 8', 2, 55.50, NULL, 1, 5),
(19, 'Polo', 'Volkswagen', 'Polo R-Line', 2, 39.90, NULL, 0, 5),
(21, 'Corsa', 'Opel', 'Corsa E', 1, 35.50, NULL, 0, 5),
(22, 'i20', 'Hyundai', 'i20 2023', 1, 36.00, NULL, 0, 5),
(23, 'Yaris', 'Toyota', 'Yaris Hybride', 3, 43.00, NULL, 1, 5),
(25, 'Mini', 'Mini', 'Cooper SE', 3, 70.00, NULL, 1, 4),
(26, 'Sandero', 'Dacia', 'Sandero Stepway', 1, 32.00, NULL, 0, 5),
(27, 'T-Roc', 'Volkswagen', 'T-Roc', 2, 58.00, NULL, 1, 5),
(28, 'Captur', 'Renault', 'Captur Intens', 2, 50.00, NULL, 1, 5);
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
