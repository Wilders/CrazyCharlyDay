-- phpMyAdmin SQL Dump
-- version 5.0.0-rc1
-- https://www.phpmyadmin.net/
--
-- Hôte : localhost
-- Généré le :  jeu. 13 fév. 2020 à 11:45
-- Version du serveur :  5.7.29-0ubuntu0.18.04.1
-- Version de PHP :  7.2.24-0ubuntu0.18.04.2

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET AUTOCOMMIT = 0;
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Base de données :  `frogs`
--

-- --------------------------------------------------------

--
-- Structure de la table `need`
--

CREATE TABLE `need` (
  `id` int(11) NOT NULL,
  `niche_id` int(11) NOT NULL,
  `role_id` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

-- --------------------------------------------------------

--
-- Structure de la table `niche`
--

CREATE TABLE `niche` (
  `id` int(11) NOT NULL,
  `begin` int(11) NOT NULL,
  `end` int(11) NOT NULL,
  `day` int(11) NOT NULL,
  `week` varchar(1) COLLATE utf8_unicode_ci NOT NULL,
  `cycle_id` int(11) NOT NULL,
  `statut` int(2) NOT NULL DEFAULT '1'
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

-- --------------------------------------------------------

--
-- Structure de la table `registration`
--

CREATE TABLE `registration` (
  `id` int(11) NOT NULL,
  `user_id` int(11) NOT NULL,
  `need_id` int(11) NOT NULL,
  `recurring` tinyint(1) NOT NULL DEFAULT '0'
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

-- --------------------------------------------------------

--
-- Structure de la table `role`
--

CREATE TABLE `role` (
  `id` int(11) NOT NULL,
  `label` varchar(128) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Déchargement des données de la table `role`
--

INSERT INTO `role` (`id`, `label`) VALUES
(1, 'Caissier titulaire'),
(2, 'Caissier assistant'),
(3, 'Gestionnaire de vrac titulaire'),
(4, 'Gestionnaire de vrac assistant'),
(5, 'Chargé d\'accueil titulaire'),
(6, 'Chargé d\'accueil assistant');

-- --------------------------------------------------------

--
-- Structure de la table `user`
--

CREATE TABLE `user` (
  `id` int(11) NOT NULL,
  `username` varchar(30) NOT NULL,
  `description` varchar(255) NOT NULL,
  `email` varchar(320) NOT NULL,
  `password` varchar(60) NOT NULL,
  `address` varchar(70) NOT NULL,
  `name` varchar(40) NOT NULL,
  `forename` varchar(40) NOT NULL,
  `admin` int(4) NOT NULL DEFAULT '0',
  `phone` varchar(25) NOT NULL,
  `picture` varchar(255) NOT NULL,
  `absences` int(4) NOT NULL DEFAULT '0',
  `obligations` int(4) NOT NULL DEFAULT '3',
  `first` int(2) NOT NULL DEFAULT '1'
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Déchargement des données de la table `user`
--

INSERT INTO `user` (`id`, `username`, `description`, `email`, `password`, `address`, `name`, `forename`, `admin`, `phone`, `picture`, `absences`, `obligations`, `first`) VALUES
(1, 'Cassandre', '', '', '', '', '', '', 0, '', '', 0, 0, 0),
(2, 'Achille', '', '', '', '', '', '', 0, '', '', 0, 0, 0),
(3, 'Calypso', '', '', '', '', '', '', 0, '', '', 0, 0, 0),
(4, 'Bacchus', '', '', '', '', '', '', 0, '', '', 0, 0, 0),
(5, 'Diane', '', '', '', '', '', '', 0, '', '', 0, 0, 0),
(6, 'Clark', '', '', '', '', '', '', 0, '', '', 0, 0, 0),
(7, 'Helene', '', '', '', '', '', '', 0, '', '', 0, 0, 0),
(8, 'Jason', '', '', '', '', '', '', 0, '', '', 0, 0, 0),
(9, 'Bruce', '', '', '', '', '', '', 0, '', '', 0, 0, 0),
(10, 'Pénélope', '', '', '', '', '', '', 0, '', '', 0, 0, 0),
(11, 'Ariane', '', '', '', '', '', '', 0, '', '', 0, 0, 0),
(12, 'Lois', '', '', '', '', '', '', 0, '', '', 0, 0, 0);

--
-- Index pour les tables déchargées
--

--
-- Index pour la table `need`
--
ALTER TABLE `need`
  ADD PRIMARY KEY (`id`);

--
-- Index pour la table `niche`
--
ALTER TABLE `niche`
  ADD PRIMARY KEY (`id`);

--
-- Index pour la table `registration`
--
ALTER TABLE `registration`
  ADD PRIMARY KEY (`id`);

--
-- Index pour la table `role`
--
ALTER TABLE `role`
  ADD PRIMARY KEY (`id`);

--
-- Index pour la table `user`
--
ALTER TABLE `user`
  ADD PRIMARY KEY (`id`);

--
-- AUTO_INCREMENT pour les tables déchargées
--

--
-- AUTO_INCREMENT pour la table `need`
--
ALTER TABLE `need`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT pour la table `niche`
--
ALTER TABLE `niche`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;

