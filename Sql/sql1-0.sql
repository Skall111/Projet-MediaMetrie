-- phpMyAdmin SQL Dump
-- version 4.7.4
-- https://www.phpmyadmin.net/
--
-- HÃ´te : 127.0.0.1:3306
-- GÃ©nÃ©rÃ© le :  jeu. 15 mars 2018 Ã  13:43
-- Version du serveur :  5.7.19
-- Version de PHP :  7.1.9

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET AUTOCOMMIT = 0;
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Base de donnÃ©es :  `facturation`
--

-- --------------------------------------------------------

--
-- Structure de la table `compte`
--

DROP TABLE IF EXISTS `compte`;
CREATE TABLE IF NOT EXISTS `compte` (
  `id` int(11) NOT NULL,
  `pass` varchar(255) NOT NULL,
  `prenom_amba` varchar(255) NOT NULL
) ENGINE=MyISAM DEFAULT CHARSET=latin1;

--
-- DÃ©chargement des donnÃ©es de la table `compte`
--

INSERT INTO `compte` (`id`, `pass`, `prenom_amba`) VALUES
(2018, 'test', 'Patrick'),
(69, 'GrosZizi', 'Kongolo');

-- --------------------------------------------------------

--
-- Structure de la table `details`
--

DROP TABLE IF EXISTS `details`;
CREATE TABLE IF NOT EXISTS `details` (
  `Id_foyer` int(11) NOT NULL,
  `Id_date` date NOT NULL,
  `Id_type_install` int(11) NOT NULL,
  `Id_type` int(11) NOT NULL,
  `Detail` varchar(80) DEFAULT NULL,
  `Kms_aller` varchar(50) NOT NULL,
  `Repas` varchar(50) NOT NULL,
  `Peage` varchar(50) NOT NULL,
  `Hotel` varchar(50) NOT NULL,
  `Autre` varchar(50) NOT NULL,
  PRIMARY KEY (`Id_foyer`,`Id_date`,`Id_type_install`,`Id_type`),
  KEY `Id_type` (`Id_type`)
) ENGINE=MyISAM DEFAULT CHARSET=latin1;

--
-- DÃ©chargement des donnÃ©es de la table `details`
--

INSERT INTO `details` (`Id_foyer`, `Id_date`, `Id_type_install`, `Id_type`, `Detail`, `Kms_aller`, `Repas`, `Peage`, `Hotel`, `Autre`) VALUES
(1, '2018-01-10', 1, 1, '120', '', '', '', '', ''),
(1, '2018-01-10', 1, 8, '1.75', '', '', '', '', ''),
(1, '2018-01-10', 1, 2, '25.50', '', '', '', '', ''),
(22222222, '2222-11-22', 2, 0, '2222', '222222', '12312312', '3123123121', '321312312', '312312312312312313131'),
(4, '2018-01-11', 2, 4, '180', '', '', '', '', ''),
(4, '2018-01-11', 2, 2, '60', '', '', '', '', ''),
(12, '1111-01-01', 1, 0, '34', '', '', '', '', ''),
(456, '0645-05-04', 1, 1, '456', '456', '456', '456', '6456', '456'),
(2, '0012-12-12', 1, 1, '1212', '', '', '', '', '');

-- --------------------------------------------------------

--
-- Structure de la table `facture`
--

DROP TABLE IF EXISTS `facture`;
CREATE TABLE IF NOT EXISTS `facture` (
  `Id_foyer` int(11) NOT NULL,
  `Id_date` date NOT NULL,
  `Id_type_inter` int(11) NOT NULL,
  PRIMARY KEY (`Id_foyer`,`Id_date`,`Id_type_inter`)
) ENGINE=MyISAM DEFAULT CHARSET=latin1;

--
-- DÃ©chargement des donnÃ©es de la table `facture`
--

INSERT INTO `facture` (`Id_foyer`, `Id_date`, `Id_type_inter`) VALUES
(1, '2018-01-10', 1),
(1, '2018-01-10', 2),
(2, '2018-01-10', 1),
(3, '2018-01-10', 2),
(4, '2018-01-11', 2);

-- --------------------------------------------------------

--
-- Structure de la table `fichiers`
--

DROP TABLE IF EXISTS `fichiers`;
CREATE TABLE IF NOT EXISTS `fichiers` (
  `Id_foyer` int(11) NOT NULL,
  `Id_date` date NOT NULL,
  `Id_type_install` int(11) NOT NULL,
  `Id_type` int(11) NOT NULL,
  `Id_dossier` int(11) NOT NULL,
  `Fichier` varchar(80) DEFAULT NULL,
  `Url` varchar(120) DEFAULT NULL,
  PRIMARY KEY (`Id_foyer`,`Id_date`,`Id_type_install`,`Id_type`,`Id_dossier`)
) ENGINE=MyISAM DEFAULT CHARSET=latin1;

--
-- DÃ©chargement des donnÃ©es de la table `fichiers`
--

INSERT INTO `fichiers` (`Id_foyer`, `Id_date`, `Id_type_install`, `Id_type`, `Id_dossier`, `Fichier`, `Url`) VALUES
(1, '2018-01-10', 1, 7, 1, 'dÃ©tail.docx', 'src/autres'),
(1, '2018-01-10', 1, 7, 2, 'dÃ©tail2.docx', 'src/autres'),
(1, '2018-01-10', 1, 2, 1, 'repas.docx', 'src/repas'),
(1, '2018-01-10', 1, 1, 1, 'kms.docx', 'src/kms'),
(4, '2018-01-11', 2, 4, 1, 'hotel.docx', 'src/hotels'),
(4, '2018-01-11', 2, 2, 1, 'repassemaine1.docx', 'src/repas'),
(4, '2018-01-11', 2, 2, 2, 'repassemaine2.docx', 'src/repas');
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
