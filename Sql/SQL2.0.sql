-- phpMyAdmin SQL Dump
-- version 4.7.7
-- https://www.phpmyadmin.net/
--
-- Hôte : localhost:3306
-- Généré le :  jeu. 22 mars 2018 à 14:51
-- Version du serveur :  5.6.38
-- Version de PHP :  7.2.1

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET time_zone = "+00:00";

--
-- Base de données :  `facturation`
--

-- --------------------------------------------------------

--
-- Structure de la table `compte`
--

CREATE TABLE `compte` (
  `id` int(11) NOT NULL,
  `pass` varchar(255) NOT NULL,
  `prenom_amba` varchar(255) NOT NULL
) ENGINE=MyISAM DEFAULT CHARSET=latin1;

--
-- Déchargement des données de la table `compte`
--

INSERT INTO `compte` (`id`, `pass`, `prenom_amba`) VALUES
(2018, 'test', 'Patrick'),
(69, 'GrosZizi', 'Kongolo');

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
(1, '1313-12-13', 1, 7, 'ERG'),
(1, '1313-12-13', 1, 6, '2345'),
(1, '1313-12-13', 1, 5, 'C342'),
(1, '1313-12-13', 1, 4, 'FGSdf'),
(1, '1313-12-13', 1, 2, '1'),
(1, '1313-12-13', 1, 1, '24'),
(1, '1313-12-13', 1, 3, '12');

-- --------------------------------------------------------

--
-- Structure de la table `facture`
--

CREATE TABLE `facture` (
  `Id_foyer` int(11) NOT NULL,
  `Id_date` date NOT NULL,
  `Id_type_inter` int(11) NOT NULL
) ENGINE=MyISAM DEFAULT CHARSET=latin1;

--
-- Déchargement des données de la table `facture`
--

INSERT INTO `facture` (`Id_foyer`, `Id_date`, `Id_type_inter`) VALUES
(1, '1313-12-13', 1);

-- --------------------------------------------------------

--
-- Structure de la table `fichiers`
--

CREATE TABLE `fichiers` (
  `Id_foyer` int(11) NOT NULL,
  `Id_date` date NOT NULL,
  `Id_type_install` int(11) NOT NULL,
  `Id_type` int(11) NOT NULL,
  `Id_dossier` int(11) NOT NULL,
  `Fichier` varchar(80) DEFAULT NULL,
  `Url` varchar(120) DEFAULT NULL
) ENGINE=MyISAM DEFAULT CHARSET=latin1;

--
-- Index pour les tables déchargées
--

--
-- Index pour la table `details`
--
ALTER TABLE `details`
  ADD PRIMARY KEY (`Id_foyer`,`Id_date`,`Id_type_install`,`Id_type`),
  ADD KEY `Id_type` (`Id_type`);

--
-- Index pour la table `facture`
--
ALTER TABLE `facture`
  ADD PRIMARY KEY (`Id_foyer`,`Id_date`,`Id_type_inter`);

--
-- Index pour la table `fichiers`
--
ALTER TABLE `fichiers`
  ADD PRIMARY KEY (`Id_foyer`,`Id_date`,`Id_type_install`,`Id_type`,`Id_dossier`);
