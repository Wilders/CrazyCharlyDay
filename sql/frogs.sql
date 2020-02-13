-- phpMyAdmin SQL Dump
-- version 5.0.0-rc1
-- https://www.phpmyadmin.net/
--
-- Hôte : localhost
-- Généré le :  jeu. 13 fév. 2020 à 21:48
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

--
-- Déchargement des données de la table `need`
--

INSERT INTO `need` (`id`, `niche_id`, `role_id`) VALUES
(1, 1, 1),
(2, 1, 2),
(3, 1, 3),
(4, 1, 6),
(5, 1, 6),
(6, 1, 6),
(7, 3, 3);

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
  `statut` tinyint(1) NOT NULL DEFAULT '1'
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

--
-- Déchargement des données de la table `niche`
--

INSERT INTO `niche` (`id`, `begin`, `end`, `day`, `week`, `cycle_id`, `statut`) VALUES
(2, 10, 12, 4, 'B', 5, 1),
(3, 0, 10, 7, 'A', 1, 1),
(4, 0, 1, 1, 'A', 0, 1),
(5, 0, 2, 2, 'A', 0, 1),
(6, 0, 3, 1, 'B', 0, 1),
(7, 1, 4, 1, 'A', 1, 0),
(8, 10, 12, 2, 'B', 0, 0),
(9, 12, 14, 1, 'A', 0, 0);

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

--
-- Déchargement des données de la table `registration`
--

INSERT INTO `registration` (`id`, `user_id`, `need_id`, `recurring`) VALUES
(1, 18, 1, 0),
(2, 18, 2, 0),
(3, 13, 4, 0),
(4, 13, 3, 0);

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
  `description` varchar(255) DEFAULT NULL,
  `email` varchar(320) NOT NULL,
  `password` varchar(60) NOT NULL,
  `address` varchar(70) NOT NULL,
  `name` varchar(40) NOT NULL,
  `forename` varchar(40) NOT NULL,
  `admin` tinyint(1) NOT NULL DEFAULT '0',
  `phone` varchar(10) NOT NULL,
  `picture` varchar(255) NOT NULL,
  `absences` int(4) NOT NULL DEFAULT '0',
  `obligations` int(4) NOT NULL DEFAULT '3',
  `first` int(2) NOT NULL DEFAULT '1'
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Déchargement des données de la table `user`
--

INSERT INTO `user` (`id`, `username`, `description`, `email`, `password`, `address`, `name`, `forename`, `admin`, `phone`, `picture`, `absences`, `obligations`, `first`) VALUES
(13, 'Flachag', '', 'flavien.chagras@protonmail.com', '$2y$10$F7HuE3RkJrFc5OdL6wEWOOe5DI4yWBnX/Ea2GsLkvV9oICxMw.CXO', '2 Rue de Ludres, Vandœuvre-lès-Nancy, Grand-Est, France', 'Chagras', 'Flavien', 0, '0667392881', 'w.png', 0, 3, 1),
(14, 'CrazyFuret', '', 'nat.che@hotmail.fr', '$2y$10$OcfPuKpzgSZpYdy2AMPO.urI2v8wfXfdyal9OAeet/3wMYbJjrPWS', '12 Rue Léon Tonnelier, Nancy, Grand-Est, France', 'Chevalier', 'Nathan', 0, '0750200436', 'default.jpg', 0, 3, 1),
(15, 'Jeannot', '', 'mathieu.jean88@wanadoo.fr', '$2y$10$3cvKWClXC9W8ENfEAPdcyufizhZ1wBO/q3XsRk5iuRnK3vKafWD82', '21 Rue Abbé Gridel, Nancy, Grand-Est, France', 'Mathieu', 'Jean', 0, '0786242254', 'default.jpg', 0, 3, 1),
(17, 'Wilders', 'test', 'jules.sayer@protonmail.com', '$2y$10$DqdgYgwmm0f/46abMhC31evG/BVJgjPw0tk9YVtVitggD6YZk7tTa', '23 Rue Louis Burtin, Dombasle-sur-Meurthe, Grand-Est, France', 'Sayer', 'Jules', 0, '0665343105', 'default.jpg', 0, 3, 1),
(18, 'admin', 'Compte admin', 'admin@admin.fr', '$2y$10$EZPYpJ6B/Ndg4SpWCHOig.tbFkNy5/jekwpcmZFHGiccOUSbRrriW', '2 Rue de Ludres, Vandœuvre-lès-Nancy, Grand-Est, France', 'Admin', 'admin', 1, '0', '8042044.png', 0, 0, 1),
(19, 'user', '', 'user@us.er', '$2y$10$Z0nTimre2rBF.BC0e/Eusu0uuhP2.oyqazA1If2Dtqw9ByHIKWoJ2', 'Bouche d&#39;Usure, Bouchamps-lès-Craon, Pays-de-la-Loire, France', 'User', 'Xuxu', 0, '0665343105', 'default.jpg', 0, 3, 1);

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
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=8;

--
-- AUTO_INCREMENT pour la table `niche`
--
ALTER TABLE `niche`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=10;

--
-- AUTO_INCREMENT pour la table `registration`
--
ALTER TABLE `registration`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;

--
-- AUTO_INCREMENT pour la table `user`
--
ALTER TABLE `user`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=20;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;

