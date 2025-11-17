-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Hôte : 127.0.0.1
-- Généré le : lun. 29 sep. 2025 à 09:24
-- Version du serveur : 10.4.32-MariaDB
-- Version de PHP : 8.2.12

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Base de données : `footclub`
--

-- --------------------------------------------------------

--
-- Structure de la table `club_adverse`
--

CREATE TABLE `club_adverse` (
  `id` int(11) NOT NULL,
  `adresse` varchar(255) NOT NULL,
  `ville` varchar(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Déchargement des données de la table `club_adverse`
--

INSERT INTO `club_adverse` (`id`, `adresse`, `ville`) VALUES
(1, 'Rue du commerçant ', 'Saint-Cyr '),
(2, 'Rue de la fontaine', 'Fontaineau');

-- --------------------------------------------------------

--
-- Structure de la table `equipe`
--

CREATE TABLE `equipe` (
  `id` int(11) NOT NULL,
  `nom` varchar(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Déchargement des données de la table `equipe`
--

INSERT INTO `equipe` (`id`, `nom`) VALUES
(1, 'FC Barcelone'),
(2, 'Real Madrid CF');

-- --------------------------------------------------------

--
-- Structure de la table `joueur`
--

CREATE TABLE `joueurs` (
  `id` int(11) NOT NULL,
  `prenom` varchar(255) NOT NULL,
  `nom` varchar(255) NOT NULL,
  `date_naissance` date NOT NULL,
  `photo` varchar(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Déchargement des données de la table `joueur`
--

INSERT INTO `joueur` (`id`, `prenom`, `nom`, `date_de_naissance`, `photo`) VALUES
(1, 'Redwane', 'Koua', '2004-11-09', 'test'),
(2, 'Valentin', 'Gogo', '2006-09-01', 'va');

-- --------------------------------------------------------

--
-- Structure de la table `joueur_ayant_equipe`
--

CREATE TABLE `joueur_ayant_equipe` (
  `joueur_id` int(11) NOT NULL,
  `equipe_id` int(11) NOT NULL,
  `role` varchar(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Déchargement des données de la table `joueur_ayant_equipe`
--

INSERT INTO `joueur_ayant_equipe` (`joueur_id`, `equipe_id`, `role`) VALUES
(1, 1, 'Défenseur Gauche'),
(2, 2, 'Buteur'),
(1, 1, 'Défenseur Gauche'),
(2, 2, 'Buteur');

-- --------------------------------------------------------

--
-- Structure de la table `match`
--

CREATE TABLE `match` (
  `id` int(11) NOT NULL,
  `score_equipe` int(11) NOT NULL,
  `score_equipe_adv` int(11) NOT NULL,
  `date` datetime NOT NULL,
  `equipe_id` int(11) NOT NULL,
  `ville` varchar(255) NOT NULL,
  `clup_adv_id` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Déchargement des données de la table `match`
--

INSERT INTO `match` (`id`, `score_equipe`, `score_equipe_adv`, `date`, `equipe_id`, `ville`, `clup_adv_id`) VALUES
(1, 4, 0, '2025-09-26 17:10:52', 1, 'Barcelone', 1),
(2, 0, 4, '2025-09-26 17:10:52', 2, 'Madrid', 2),
(3, 4, 0, '2025-09-26 17:10:52', 1, 'Barcelone', 1),
(4, 0, 4, '2025-09-26 17:10:52', 2, 'Madrid', 2);

-- --------------------------------------------------------

--
-- Structure de la table `membre_du_staff`
--

CREATE TABLE `membre_du_staff` (
  `id` int(11) NOT NULL,
  `prenom` varchar(255) NOT NULL,
  `nom` varchar(255) NOT NULL,
  `image` varchar(255) NOT NULL,
  `role` varchar(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Déchargement des données de la table `membre_du_staff`
--

INSERT INTO `membre_du_staff` (`id`, `prenom`, `nom`, `image`, `role`) VALUES
(1, 'zinedine', 'zidane', '...', 'Entraineur'),
(2, 'diego', 'simeone', '...', 'entraineur');

-- --------------------------------------------------------

--
-- Structure de la table `users`
--

CREATE TABLE `users` (
  `id` int(11) NOT NULL,
  `username` varchar(255) NOT NULL,
  `email` varchar(255) NOT NULL,
  `mdp` varchar(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Déchargement des données de la table `users`
--

INSERT INTO `users` (`id`, `username`, `email`, `mdp`) VALUES
(1, 'Redwane', 'redo@redo.fr', '123456'),
(4, 'Messi', 'messi@best.fr', '$2y$10$BBUPHlvrVM04j2zdu08f..ZYhaT7xhzADL4QL55i1ABl75dJ9woG6'),
(5, 'Messi', 'messi@best.fr', '$2y$10$naUGLG56aa610kyiPIE0h.b7R4FVLChh3BnUeuNjZJb9ewRWBrXJq'),
(6, 'vltn', 'vltn@goat.fr', '$2y$10$sPty/ZugA.AGnl1naKMV2..po9HXLeGoCPuTHLIFu74pQw7.2YU4O'),
(7, 'moi', 'moi@moi', '$2y$10$M/I2PFlzf2ToEzfbZJt1k.KbzE35nuthSwEU4NecsZWVsbjWJcBdC');

--
-- Index pour les tables déchargées
--

--
-- Index pour la table `club_adverse`
--
ALTER TABLE `club_adverse`
  ADD PRIMARY KEY (`id`);

--
-- Index pour la table `equipe`
--
ALTER TABLE `equipe`
  ADD PRIMARY KEY (`id`);

--
-- Index pour la table `joueur`
--
ALTER TABLE `joueur`
  ADD PRIMARY KEY (`id`);

--
-- Index pour la table `joueur_ayant_equipe`
--
ALTER TABLE `joueur_ayant_equipe`
  ADD KEY `fk_joueur_id` (`joueur_id`),
  ADD KEY `fk_equipe_id` (`equipe_id`);

--
-- Index pour la table `match`
--
ALTER TABLE `match`
  ADD PRIMARY KEY (`id`),
  ADD KEY `fk_match_equipe_id` (`equipe_id`),
  ADD KEY `fk_club_adv_id` (`clup_adv_id`);

--
-- Index pour la table `membre_du_staff`
--
ALTER TABLE `membre_du_staff`
  ADD PRIMARY KEY (`id`);

--
-- Index pour la table `users`
--
ALTER TABLE `users`
  ADD PRIMARY KEY (`id`);

--
-- AUTO_INCREMENT pour les tables déchargées
--

--
-- AUTO_INCREMENT pour la table `club_adverse`
--
ALTER TABLE `club_adverse`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT pour la table `equipe`
--
ALTER TABLE `equipe`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT pour la table `joueur`
--
ALTER TABLE `joueur`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;

--
-- AUTO_INCREMENT pour la table `match`
--
ALTER TABLE `match`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;

--
-- AUTO_INCREMENT pour la table `membre_du_staff`
--
ALTER TABLE `membre_du_staff`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT pour la table `users`
--
ALTER TABLE `users`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=9;

--
-- Contraintes pour les tables déchargées
--

--
-- Contraintes pour la table `joueur_ayant_equipe`
--
ALTER TABLE `joueur_ayant_equipe`
  ADD CONSTRAINT `fk_equipe_id` FOREIGN KEY (`equipe_id`) REFERENCES `equipe` (`id`),
  ADD CONSTRAINT `fk_joueur_id` FOREIGN KEY (`joueur_id`) REFERENCES `joueur` (`id`);

--
-- Contraintes pour la table `match`
--
ALTER TABLE `match`
  ADD CONSTRAINT `fk_club_adv_id` FOREIGN KEY (`clup_adv_id`) REFERENCES `club_adverse` (`id`),
  ADD CONSTRAINT `fk_match_equipe_id` FOREIGN KEY (`equipe_id`) REFERENCES `equipe` (`id`);
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
