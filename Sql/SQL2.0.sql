-- phpMyAdmin SQL Dump
-- version 4.7.7
-- https://www.phpmyadmin.net/
--
-- Hôte : localhost:3306
-- Généré le :  mar. 20 mars 2018 à 17:31
-- Version du serveur :  5.6.38
-- Version de PHP :  7.1.12

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET time_zone = "+00:00";

--
-- Base de données :  `facturation`
--

-- --------------------------------------------------------

--
-- Structure de la table `details`
--

CREATE TABLE `details` (
  `Id_foyer` int(11) NOT NULL,
  `Id_date` date NOT NULL,
  `Id_type_install` int(11) NOT NULL,
  `Id_type` int(11) NOT NULL,
  `Detail` varchar(80) DEFAULT NULL
) ENGINE=MyISAM DEFAULT CHARSET=latin1;

--
-- Déchargement des données de la table `details`
--

INSERT INTO `details` (`Id_foyer`, `Id_date`, `Id_type_install`, `Id_type`, `Detail`) VALUES
(1, '1111-11-11', 1, 6, 'hotel'),
(1, '1111-11-11', 1, 5, 'peages'),
(1, '1111-11-11', 1, 4, 'repas'),
(1, '1111-11-11', 1, 2, 'poste'),
(1, '1111-11-11', 1, 1, 'Kms aller'),
(1, '1111-11-11', 1, 3, 'poste'),
(1, '1111-11-11', 1, 7, 'autre');

--
-- Index pour les tables déchargées
--

--
-- Index pour la table `details`
--
ALTER TABLE `details`
  ADD PRIMARY KEY (`Id_foyer`,`Id_date`,`Id_type_install`,`Id_type`),
  ADD KEY `Id_type` (`Id_type`);
