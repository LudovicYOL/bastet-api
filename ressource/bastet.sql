-- phpMyAdmin SQL Dump
-- version 4.5.1
-- http://www.phpmyadmin.net
--
-- Client :  127.0.0.1
-- Généré le :  Mer 17 Janvier 2018 à 22:40
-- Version du serveur :  10.1.9-MariaDB
-- Version de PHP :  5.6.15

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Base de données :  `bastet`
--

-- --------------------------------------------------------

--
-- Structure de la table `l_personne_emploi`
--

CREATE TABLE `l_personne_emploi` (
  `FK_PERSONNE` int(11) NOT NULL,
  `FK_EMPLOI` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Contenu de la table `l_personne_emploi`
--

INSERT INTO `l_personne_emploi` (`FK_PERSONNE`, `FK_EMPLOI`) VALUES
(1, 2),
(1, 3),
(2, 1);

-- --------------------------------------------------------

--
-- Structure de la table `o_emploi`
--

CREATE TABLE `o_emploi` (
  `ID_EMPLOI` bigint(20) UNSIGNED NOT NULL,
  `POSTE` varchar(155) DEFAULT NULL,
  `TYPE_POSTE` varchar(100) DEFAULT NULL,
  `LOCALISATION` varchar(155) DEFAULT NULL,
  `DEBUT_CONTRAT` date NOT NULL,
  `FIN_CONTRAT` date DEFAULT NULL,
  `EN_RECHERCHE` tinyint(1) NOT NULL,
  `FK_ENTREPRISE` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Contenu de la table `o_emploi`
--

INSERT INTO `o_emploi` (`ID_EMPLOI`, `POSTE`, `TYPE_POSTE`, `LOCALISATION`, `DEBUT_CONTRAT`, `FIN_CONTRAT`, `EN_RECHERCHE`, `FK_ENTREPRISE`) VALUES
(1, 'Ingenieur JAVA/JEE', 'Technique', 'Blagnac', '2017-06-08', NULL, 1, 2),
(2, 'Ingenieur logiciel', 'Technique', 'Colomiers', '2016-08-08', '2017-08-31', 0, 1),
(3, 'Ingenieur logiciel', 'Technique', 'Basso Cambo', '2017-11-01', NULL, 0, 1);

-- --------------------------------------------------------

--
-- Structure de la table `o_entreprise`
--

CREATE TABLE `o_entreprise` (
  `ID_ENTREPRISE` bigint(20) UNSIGNED NOT NULL,
  `NOM` varchar(155) DEFAULT NULL,
  `LOCALISATION` varchar(155) DEFAULT NULL,
  `REGION` varchar(255) NOT NULL,
  `DEPARTEMENT` int(11) DEFAULT NULL,
  `SECTEUR` varchar(155) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Contenu de la table `o_entreprise`
--

INSERT INTO `o_entreprise` (`ID_ENTREPRISE`, `NOM`, `LOCALISATION`, `REGION`, `DEPARTEMENT`, `SECTEUR`) VALUES
(1, 'EOLE CONSULTING', 'BLAGNAC (31)', 'HAUTE-GARONNE', 31, 'SANTE'),
(2, 'ADAMING', 'BLAGNAC (31)', 'HAUTE-GARONNE', 31, 'VARIABLE');

-- --------------------------------------------------------

--
-- Structure de la table `o_personne`
--

CREATE TABLE `o_personne` (
  `ID_PERSONNE` bigint(20) UNSIGNED NOT NULL,
  `LOGIN` varchar(255) NOT NULL,
  `PASSWORD` varchar(255) NOT NULL,
  `NOM` varchar(155) NOT NULL,
  `PRENOM` varchar(155) NOT NULL,
  `ADRESSE` varchar(255) DEFAULT NULL,
  `DATE_NAISS` date DEFAULT NULL,
  `EMAIL` varchar(155) NOT NULL,
  `TELEPHONE` varchar(10) DEFAULT NULL,
  `PROMOTION` varchar(4) NOT NULL,
  `STATUT` varchar(8) DEFAULT 'Etudiant'
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Contenu de la table `o_personne`
--

INSERT INTO `o_personne` (`ID_PERSONNE`, `LOGIN`, `PASSWORD`, `NOM`, `PRENOM`, `ADRESSE`, `DATE_NAISS`, `EMAIL`, `TELEPHONE`, `PROMOTION`, `STATUT`) VALUES
(1, 'lyol', 'lyol', 'YOL', 'Ludovic', NULL, '1993-10-01', 'ludovic.yol@gmail.com', NULL, '2016', 'Diplome'),
(2, 'arec', 'arec', 'RECEVEUR', 'Alexandre', '31 avenue de la viste 31180 Rouffiac Tolosan', '1993-11-08', 'alexandre.receveur@yahoo.fr', '0638898577', '2016', 'Diplome');

-- --------------------------------------------------------

--
-- Structure de la table `o_salaire`
--

CREATE TABLE `o_salaire` (
  `ID_SALAIRE` bigint(20) UNSIGNED NOT NULL,
  `SALAIRE_ANNUEL` int(11) NOT NULL,
  `DATE_OBTENTION` date NOT NULL,
  `FK_EMPLOI` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Contenu de la table `o_salaire`
--

INSERT INTO `o_salaire` (`ID_SALAIRE`, `SALAIRE_ANNUEL`, `DATE_OBTENTION`, `FK_EMPLOI`) VALUES
(1, 24000, '2017-06-08', 1),
(2, 30000, '2016-08-08', 2),
(3, 33000, '2017-09-01', 3);

--
-- Index pour les tables exportées
--

--
-- Index pour la table `l_personne_emploi`
--
ALTER TABLE `l_personne_emploi`
  ADD PRIMARY KEY (`FK_PERSONNE`,`FK_EMPLOI`);

--
-- Index pour la table `o_emploi`
--
ALTER TABLE `o_emploi`
  ADD PRIMARY KEY (`ID_EMPLOI`),
  ADD UNIQUE KEY `ID_EMPLOI` (`ID_EMPLOI`);

--
-- Index pour la table `o_entreprise`
--
ALTER TABLE `o_entreprise`
  ADD PRIMARY KEY (`ID_ENTREPRISE`);

--
-- Index pour la table `o_personne`
--
ALTER TABLE `o_personne`
  ADD PRIMARY KEY (`ID_PERSONNE`);

--
-- Index pour la table `o_salaire`
--
ALTER TABLE `o_salaire`
  ADD PRIMARY KEY (`ID_SALAIRE`);

--
-- AUTO_INCREMENT pour les tables exportées
--

--
-- AUTO_INCREMENT pour la table `o_emploi`
--
ALTER TABLE `o_emploi`
  MODIFY `ID_EMPLOI` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;
--
-- AUTO_INCREMENT pour la table `o_entreprise`
--
ALTER TABLE `o_entreprise`
  MODIFY `ID_ENTREPRISE` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;
--
-- AUTO_INCREMENT pour la table `o_personne`
--
ALTER TABLE `o_personne`
  MODIFY `ID_PERSONNE` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=18;
--
-- AUTO_INCREMENT pour la table `o_salaire`
--
ALTER TABLE `o_salaire`
  MODIFY `ID_SALAIRE` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;
/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
