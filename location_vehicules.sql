-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Hôte : 127.0.0.1:3306
-- Généré le : mar. 18 fév. 2025 à 09:29
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

-- --------------------------------------------------------

--
-- Structure de la table `comptes`
--

DROP TABLE IF EXISTS `comptes`;
CREATE TABLE IF NOT EXISTS `comptes` (
  `Pseudo` varchar(50) NOT NULL,
  `MDP` varchar(100) NOT NULL
) ENGINE=MyISAM DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

--
-- Déchargement des données de la table `comptes`
--

INSERT INTO `comptes` (`Pseudo`, `MDP`) VALUES
('Admin', 'Admin');

-- --------------------------------------------------------

--
-- Structure de la table `motorisation`
--

DROP TABLE IF EXISTS `motorisation`;
CREATE TABLE IF NOT EXISTS `motorisation` (
  `id` int NOT NULL AUTO_INCREMENT,
  `Motorisation` text NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM AUTO_INCREMENT=2 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

--
-- Déchargement des données de la table `motorisation`
--

INSERT INTO `motorisation` (`id`, `Motorisation`) VALUES
(1, 'Diesel');

-- --------------------------------------------------------

--
-- Structure de la table `vehicules`
--

DROP TABLE IF EXISTS `vehicules`;
CREATE TABLE IF NOT EXISTS `vehicules` (
  `id` int NOT NULL AUTO_INCREMENT,
  `Type` varchar(10) NOT NULL,
  `Marques` text NOT NULL,
  `Modeles` text NOT NULL,
  `BVA` tinyint(1) NOT NULL,
  `Places` int NOT NULL,
  `Motorisation` int NOT NULL,
  `Radio` tinyint(1) NOT NULL,
  `Climatisation` tinyint(1) NOT NULL,
  `Bluetooth` tinyint(1) NOT NULL,
  `Regulateur_vitesse` tinyint(1) NOT NULL,
  `Pack_Electrique` tinyint(1) NOT NULL,
  `GPS` tinyint(1) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM AUTO_INCREMENT=2 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

--
-- Déchargement des données de la table `vehicules`
--

INSERT INTO `vehicules` (`id`, `Type`, `Marques`, `Modeles`, `BVA`, `Places`, `Motorisation`, `Radio`, `Climatisation`, `Bluetooth`, `Regulateur_vitesse`, `Pack_Electrique`, `GPS`) VALUES
(1, 'Utilitaire', 'BMW', 'Série 1', 1, 5, 2, 1, 1, 1, 1, 1, 1);
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
