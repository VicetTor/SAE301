-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Hôte : 127.0.0.1
-- Généré le : mer. 08 jan. 2025 à 22:16
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
-- Base de données : `sae301grp2_bd`
--

-- --------------------------------------------------------

--
-- Structure de la table `grp2_ability`
--

CREATE TABLE `grp2_ability` (
  `ABI_ID` int(11) NOT NULL,
  `SKILL_ID` int(11) NOT NULL,
  `ABI_LABEL` varchar(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Déchargement des données de la table `grp2_ability`
--

INSERT INTO `grp2_ability` (`ABI_ID`, `SKILL_ID`, `ABI_LABEL`) VALUES
(1, 1, 'TEST');

-- --------------------------------------------------------

--
-- Structure de la table `grp2_attendee`
--

CREATE TABLE `grp2_attendee` (
  `ATTE_ID` int(11) NOT NULL,
  `SESS_ID` int(11) NOT NULL,
  `USER_ID` bigint(6) NOT NULL,
  `USER_ID_ATTENDEE` bigint(6) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Déchargement des données de la table `grp2_attendee`
--

INSERT INTO `grp2_attendee` (`ATTE_ID`, `SESS_ID`, `USER_ID`, `USER_ID_ATTENDEE`) VALUES
(1, 1, 1, 1);

-- --------------------------------------------------------

--
-- Structure de la table `grp2_club`
--

CREATE TABLE `grp2_club` (
  `CLUB_ID` bigint(6) NOT NULL,
  `CLUB_NAME` varchar(255) NOT NULL,
  `CLUB_POSTALCODE` char(5) NOT NULL,
  `CLUB_CITY` varchar(255) NOT NULL,
  `CLUB_ADDRESS` varchar(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Déchargement des données de la table `grp2_club`
--

INSERT INTO `grp2_club` (`CLUB_ID`, `CLUB_NAME`, `CLUB_POSTALCODE`, `CLUB_CITY`, `CLUB_ADDRESS`) VALUES
(1, 'Football Club de Paris', '75001', 'Paris', '123 Rue de Paris'),
(2, 'Basketball Club Lyon', '69001', 'Lyon', '456 Rue de Lyon'),
(3, 'Tennis Club Marseille', '13001', 'Marseille', '789 Boulevard de Marseille'),
(4, 'Hockey Club Lille', '59000', 'Lille', '321 Avenue de Lille'),
(5, 'Rugby Club Toulouse', '31000', 'Toulouse', '654 Route de Toulouse'),
(6, 'Volleyball Club Nice', '6000', 'Nice', '987 Promenade des Anglais'),
(7, 'Golf Club Bordeaux', '33000', 'Bordeaux', '258 Rue de Bordeaux'),
(8, 'Handball Club Nantes', '44000', 'Nantes', '369 Avenue des Champs'),
(9, 'Cycling Club Strasbourg', '67000', 'Strasbourg', '741 Route des Vosges'),
(10, 'Baseball Club Montpellier', '34000', 'Montpellier', '852 Avenue de la Méditerranée');

-- --------------------------------------------------------

--
-- Structure de la table `grp2_evaluation`
--

CREATE TABLE `grp2_evaluation` (
  `EVAL_ID` int(11) NOT NULL,
  `STATUSTYPE_ID` bigint(1) NOT NULL,
  `USER_ID` bigint(6) NOT NULL,
  `SESS_ID` int(11) NOT NULL,
  `ABI_ID` int(11) NOT NULL,
  `EVAL_OBSERVATION` varchar(255) DEFAULT NULL,
  `CLUB_ID` bigint(6) NOT NULL,
  `LEVEL_ID` int(11) NOT NULL,
  `SKILL_ID` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Déchargement des données de la table `grp2_evaluation`
--

INSERT INTO `grp2_evaluation` (`EVAL_ID`, `STATUSTYPE_ID`, `USER_ID`, `SESS_ID`, `ABI_ID`, `EVAL_OBSERVATION`, `CLUB_ID`, `LEVEL_ID`, `SKILL_ID`) VALUES
(1, 1, 1, 1, 1, 'Observation 1', 1, 1, 1),
(2, 1, 1, 1, 1, 'Observation 2', 3, 1, 1),
(3, 1, 1, 1, 1, 'Observation 3', 0, 0, 1),
(4, 1, 1, 1, 1, 'Observation 4', 0, 0, 1),
(5, 1, 1, 1, 1, 'Observation 5', 0, 0, 1),
(6, 1, 1, 1, 1, 'Observation 6', 0, 0, 1),
(7, 1, 1, 1, 1, 'Observation 7', 0, 0, 1),
(8, 1, 1, 1, 1, 'Observation 8', 0, 0, 1),
(9, 1, 1, 1, 1, 'Observation 9', 0, 0, 1);

-- --------------------------------------------------------

--
-- Structure de la table `grp2_level`
--

CREATE TABLE `grp2_level` (
  `LEVEL_ID` int(11) NOT NULL,
  `LEVEL_LABEL` varchar(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Déchargement des données de la table `grp2_level`
--

INSERT INTO `grp2_level` (`LEVEL_ID`, `LEVEL_LABEL`) VALUES
(1, 'Beginner'),
(2, 'Intermediate'),
(3, 'Advanced'),
(4, 'Expert'),
(5, 'Master'),
(6, 'Novice'),
(7, 'Skilled'),
(8, 'Proficient'),
(9, 'Exceptional'),
(10, 'Outstanding');

-- --------------------------------------------------------

--
-- Structure de la table `grp2_session`
--

CREATE TABLE `grp2_session` (
  `SESS_ID` int(11) NOT NULL,
  `TRAIN_ID` int(11) NOT NULL,
  `SESSTYPE_ID` int(11) NOT NULL,
  `SESS_DATE` date NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Déchargement des données de la table `grp2_session`
--

INSERT INTO `grp2_session` (`SESS_ID`, `TRAIN_ID`, `SESSTYPE_ID`, `SESS_DATE`) VALUES
(1, 1, 9, '2025-01-01');

-- --------------------------------------------------------

--
-- Structure de la table `grp2_sessiontype`
--

CREATE TABLE `grp2_sessiontype` (
  `SESSTYPE_ID` int(11) NOT NULL,
  `SESSTYPE_LABEL` varchar(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Déchargement des données de la table `grp2_sessiontype`
--

INSERT INTO `grp2_sessiontype` (`SESSTYPE_ID`, `SESSTYPE_LABEL`) VALUES
(1, 'Workshop'),
(2, 'Lecture'),
(3, 'Seminar'),
(4, 'Training'),
(5, 'Networking'),
(6, 'Conference'),
(7, 'Panel Discussion'),
(8, 'Webinar'),
(9, 'Bootcamp'),
(10, 'Retreat');

-- --------------------------------------------------------

--
-- Structure de la table `grp2_skill`
--

CREATE TABLE `grp2_skill` (
  `SKILL_ID` int(11) NOT NULL,
  `LEVEL_ID` int(11) NOT NULL,
  `SKILL_LABEL` varchar(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Déchargement des données de la table `grp2_skill`
--

INSERT INTO `grp2_skill` (`SKILL_ID`, `LEVEL_ID`, `SKILL_LABEL`) VALUES
(1, 3, 'TEST');

-- --------------------------------------------------------

--
-- Structure de la table `grp2_statustype`
--

CREATE TABLE `grp2_statustype` (
  `STATUSTYPE_ID` bigint(1) NOT NULL,
  `STATUSTYPE_LABEL` char(32) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Déchargement des données de la table `grp2_statustype`
--

INSERT INTO `grp2_statustype` (`STATUSTYPE_ID`, `STATUSTYPE_LABEL`) VALUES
(1, 'test');

-- --------------------------------------------------------

--
-- Structure de la table `grp2_training`
--

CREATE TABLE `grp2_training` (
  `TRAIN_ID` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Déchargement des données de la table `grp2_training`
--

INSERT INTO `grp2_training` (`TRAIN_ID`) VALUES
(1),
(2),
(3),
(4),
(5),
(6),
(7),
(8),
(9),
(10);

-- --------------------------------------------------------

--
-- Structure de la table `grp2_typeuser`
--

CREATE TABLE `grp2_typeuser` (
  `TYPE_ID` int(11) NOT NULL,
  `TYPE_LABEL` varchar(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Déchargement des données de la table `grp2_typeuser`
--

INSERT INTO `grp2_typeuser` (`TYPE_ID`, `TYPE_LABEL`) VALUES
(1, 'Admin'),
(2, 'User'),
(3, 'Guest'),
(4, 'Moderator'),
(5, 'Instructor'),
(6, 'Member'),
(7, 'Observer'),
(8, 'Coordinator'),
(9, 'Leader'),
(10, 'Trainer');

-- --------------------------------------------------------

--
-- Structure de la table `grp2_user`
--

CREATE TABLE `grp2_user` (
  `USER_ID` bigint(6) NOT NULL,
  `LEVEL_ID` int(11) NOT NULL,
  `TYPE_ID` int(11) NOT NULL,
  `TRAIN_ID` int(11) DEFAULT NULL,
  `LEVEL_ID_RESUME` int(11) DEFAULT NULL,
  `USER_MAIL` varchar(255) NOT NULL,
  `USER_PASSWORD` varchar(255) NOT NULL,
  `USER_FIRSTNAME` varchar(255) NOT NULL,
  `USER_LASTNAME` varchar(255) NOT NULL,
  `USER_PHONENUMBER` char(13) DEFAULT NULL,
  `USER_BIRTHDATE` date NOT NULL,
  `USER_ADDRESS` varchar(255) NOT NULL,
  `USER_POSTALCODE` char(5) NOT NULL,
  `USER_LICENSENUMBER` char(32) NOT NULL,
  `USER_MEDICCERTIFICATEDATE` date NOT NULL,
  `USER_ISFIRSTLOGIN` int(11) NOT NULL,
  `USER_ISACTIVE` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Déchargement des données de la table `grp2_user`
--

INSERT INTO `grp2_user` (`USER_ID`, `LEVEL_ID`, `TYPE_ID`, `TRAIN_ID`, `LEVEL_ID_RESUME`, `USER_MAIL`, `USER_PASSWORD`, `USER_FIRSTNAME`, `USER_LASTNAME`, `USER_PHONENUMBER`, `USER_BIRTHDATE`, `USER_ADDRESS`, `USER_POSTALCODE`, `USER_LICENSENUMBER`, `USER_MEDICCERTIFICATEDATE`, `USER_ISFIRSTLOGIN`, `USER_ISACTIVE`) VALUES
(1, 1, 1, 1, 2, 'john.doe@example.com', 'password123', 'John', 'Test', '0123456789', '2000-01-01', '123 Main St', '75001', 'ABC123', '2025-01-01', 1, 0),
(2, 2, 2, 2, 3, 'jane.smith@example.com', 'password456', 'Jane', 'Smith', '0987654321', '1995-02-02', '456 Oak Rd', '75002', 'XYZ456', '2025-02-01', 1, 0),
(3, 3, 1, 3, 1, 'houllegatte.tom@gmail.com', 'password789', 'Tom', 'HOULLEGATTE', '0761711046', '1990-03-03', '43 Sente de la Cressonnière', '14420', 'LMN789', '2002-07-19', 1, 1),
(4, 4, 4, 4, 5, 'bob.jones@example.com', 'password101', 'Bob', 'Jones', '2233445566', '1985-04-04', '321 Maple Ave', '75004', 'OPQ101', '2025-04-01', 1, 1),
(5, 5, 5, 5, 6, 'charlie.white@example.com', 'password102', 'Charlie', 'White', '3344556677', '1980-05-05', '654 Cedar Blvd', '75005', 'RST102', '2025-05-01', 1, 1),
(6, 6, 6, 6, 7, 'david.miller@example.com', 'password103', 'David', 'Miller', '4455667788', '1975-06-06', '987 Birch St', '75006', 'UVW103', '2025-06-01', 1, 1),
(7, 7, 7, 7, 8, 'emily.davis@example.com', 'password104', 'Emily', 'Davis', '5566778899', '1970-07-07', '159 Elm Rd', '75007', 'XYZ104', '2025-07-01', 1, 1),
(8, 8, 8, 8, 9, 'frank.moore@example.com', 'password105', 'Frank', 'Moore', '6677889900', '1965-08-08', '753 Willow St', '75008', 'ABC105', '2025-08-01', 1, 1),
(9, 9, 9, 9, 10, 'grace.taylor@example.com', 'password106', 'Grace', 'Taylor', '7788990011', '1960-09-09', '864 Ash Ave', '75009', 'DEF106', '2025-09-01', 1, 1),
(10, 10, 10, 10, 1, 'henry.wilson@example.com', 'password107', 'Henry', 'Wilson', '8899001122', '1955-10-10', '975 Oak St', '75010', 'GHI107', '2025-10-01', 1, 1);

-- --------------------------------------------------------

--
-- Structure de la table `grp2_validation`
--

CREATE TABLE `grp2_validation` (
  `VALID_ID` bigint(4) NOT NULL,
  `SKILL_ID` int(11) NOT NULL,
  `ABI_ID` int(11) NOT NULL,
  `LEVEL_ID` int(11) NOT NULL,
  `EVAL_ID` int(11) NOT NULL,
  `VALID_DATE` date DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Déchargement des données de la table `grp2_validation`
--

INSERT INTO `grp2_validation` (`VALID_ID`, `SKILL_ID`, `ABI_ID`, `LEVEL_ID`, `EVAL_ID`, `VALID_DATE`) VALUES
(1, 1, 1, 1, 1, '2025-01-01');

-- --------------------------------------------------------

--
-- Structure de la table `grp2_year`
--

CREATE TABLE `grp2_year` (
  `ANNU_YEAR` date NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Déchargement des données de la table `grp2_year`
--

INSERT INTO `grp2_year` (`ANNU_YEAR`) VALUES
('2025-01-01'),
('2026-01-01'),
('2027-01-01'),
('2028-01-01'),
('2029-01-01'),
('2030-01-01'),
('2031-01-01'),
('2032-01-01'),
('2033-01-01'),
('2034-01-01');

-- --------------------------------------------------------

--
-- Structure de la table `password_resets`
--

CREATE TABLE `password_resets` (
  `email` varchar(255) NOT NULL,
  `token` varchar(255) NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Structure de la table `personal_access_tokens`
--

CREATE TABLE `personal_access_tokens` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `tokenable_type` varchar(255) NOT NULL,
  `tokenable_id` bigint(20) UNSIGNED NOT NULL,
  `name` varchar(255) NOT NULL,
  `token` varchar(64) NOT NULL,
  `abilities` text DEFAULT NULL,
  `last_used_at` timestamp NULL DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Structure de la table `report`
--

CREATE TABLE `report` (
  `CLUB_ID` bigint(6) NOT NULL,
  `USER_ID` bigint(6) NOT NULL,
  `ANNU_YEAR` date NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Déchargement des données de la table `report`
--

INSERT INTO `report` (`CLUB_ID`, `USER_ID`, `ANNU_YEAR`) VALUES
(1, 1, '2025-01-01');

-- --------------------------------------------------------

--
-- Structure de la table `to_date`
--

CREATE TABLE `to_date` (
  `CLUB_ID` bigint(6) NOT NULL,
  `ANNU_YEAR` date NOT NULL,
  `CLUB_INSCRIPTIONNB` bigint(4) DEFAULT NULL,
  `CLUB_NBDEGREEOBTAINED` char(32) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Déchargement des données de la table `to_date`
--

INSERT INTO `to_date` (`CLUB_ID`, `ANNU_YEAR`, `CLUB_INSCRIPTIONNB`, `CLUB_NBDEGREEOBTAINED`) VALUES
(1, '2025-01-01', 25, '12');

-- --------------------------------------------------------

--
-- Structure de la table `users`
--

CREATE TABLE `users` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `name` varchar(255) NOT NULL,
  `email` varchar(255) NOT NULL,
  `email_verified_at` timestamp NULL DEFAULT NULL,
  `password` varchar(255) NOT NULL,
  `remember_token` varchar(100) DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Index pour les tables déchargées
--

--
-- Index pour la table `grp2_ability`
--
ALTER TABLE `grp2_ability`
  ADD PRIMARY KEY (`ABI_ID`),
  ADD KEY `I_FK_GRP2_ABILITY_GRP2_SKILL` (`SKILL_ID`);

--
-- Index pour la table `grp2_attendee`
--
ALTER TABLE `grp2_attendee`
  ADD PRIMARY KEY (`ATTE_ID`),
  ADD KEY `I_FK_GRP2_ATTENDEE_GRP2_SESSION` (`SESS_ID`),
  ADD KEY `I_FK_GRP2_ATTENDEE_GRP2_USER` (`USER_ID`),
  ADD KEY `I_FK_GRP2_ATTENDEE_GRP2_USER1` (`USER_ID_ATTENDEE`);

--
-- Index pour la table `grp2_club`
--
ALTER TABLE `grp2_club`
  ADD PRIMARY KEY (`CLUB_ID`);

--
-- Index pour la table `grp2_evaluation`
--
ALTER TABLE `grp2_evaluation`
  ADD PRIMARY KEY (`EVAL_ID`),
  ADD KEY `I_FK_GRP2_EVALUATION_GRP2_STATUSTYPE` (`STATUSTYPE_ID`),
  ADD KEY `I_FK_GRP2_EVALUATION_GRP2_USER` (`USER_ID`),
  ADD KEY `I_FK_GRP2_EVALUATION_GRP2_SESSION` (`SESS_ID`),
  ADD KEY `I_FK_GRP2_EVALUATION_GRP2_ABILITY` (`ABI_ID`),
  ADD KEY `fk_skill_id` (`SKILL_ID`);

--
-- Index pour la table `grp2_level`
--
ALTER TABLE `grp2_level`
  ADD PRIMARY KEY (`LEVEL_ID`);

--
-- Index pour la table `grp2_session`
--
ALTER TABLE `grp2_session`
  ADD PRIMARY KEY (`SESS_ID`),
  ADD KEY `I_FK_GRP2_SESSION_GRP2_TRAINING` (`TRAIN_ID`),
  ADD KEY `I_FK_GRP2_SESSION_GRP2_SESSIONTYPE` (`SESSTYPE_ID`);

--
-- Index pour la table `grp2_sessiontype`
--
ALTER TABLE `grp2_sessiontype`
  ADD PRIMARY KEY (`SESSTYPE_ID`);

--
-- Index pour la table `grp2_skill`
--
ALTER TABLE `grp2_skill`
  ADD PRIMARY KEY (`SKILL_ID`),
  ADD KEY `I_FK_GRP2_SKILL_GRP2_LEVEL` (`LEVEL_ID`);

--
-- Index pour la table `grp2_statustype`
--
ALTER TABLE `grp2_statustype`
  ADD PRIMARY KEY (`STATUSTYPE_ID`);

--
-- Index pour la table `grp2_training`
--
ALTER TABLE `grp2_training`
  ADD PRIMARY KEY (`TRAIN_ID`);

--
-- Index pour la table `grp2_typeuser`
--
ALTER TABLE `grp2_typeuser`
  ADD PRIMARY KEY (`TYPE_ID`);

--
-- Index pour la table `grp2_user`
--
ALTER TABLE `grp2_user`
  ADD PRIMARY KEY (`USER_ID`),
  ADD KEY `I_FK_GRP2_USER_GRP2_LEVEL` (`LEVEL_ID`),
  ADD KEY `I_FK_GRP2_USER_GRP2_TYPEUSER` (`TYPE_ID`),
  ADD KEY `I_FK_GRP2_USER_GRP2_TRAINING` (`TRAIN_ID`),
  ADD KEY `I_FK_GRP2_USER_GRP2_LEVEL1` (`LEVEL_ID_RESUME`);

--
-- Index pour la table `grp2_validation`
--
ALTER TABLE `grp2_validation`
  ADD PRIMARY KEY (`VALID_ID`),
  ADD KEY `I_FK_GRP2_VALIDATION_GRP2_SKILL` (`SKILL_ID`),
  ADD KEY `I_FK_GRP2_VALIDATION_GRP2_ABILITY` (`ABI_ID`),
  ADD KEY `I_FK_GRP2_VALIDATION_GRP2_LEVEL` (`LEVEL_ID`),
  ADD KEY `I_FK_GRP2_VALIDATION_GRP2_EVALUATION` (`EVAL_ID`);

--
-- Index pour la table `grp2_year`
--
ALTER TABLE `grp2_year`
  ADD PRIMARY KEY (`ANNU_YEAR`);

--
-- Index pour la table `password_resets`
--
ALTER TABLE `password_resets`
  ADD KEY `password_resets_email_index` (`email`);

--
-- Index pour la table `personal_access_tokens`
--
ALTER TABLE `personal_access_tokens`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `personal_access_tokens_token_unique` (`token`),
  ADD KEY `personal_access_tokens_tokenable_type_tokenable_id_index` (`tokenable_type`,`tokenable_id`);

--
-- Index pour la table `report`
--
ALTER TABLE `report`
  ADD PRIMARY KEY (`CLUB_ID`,`USER_ID`,`ANNU_YEAR`),
  ADD KEY `I_FK_REPORT_GRP2_CLUB` (`CLUB_ID`),
  ADD KEY `I_FK_REPORT_GRP2_USER` (`USER_ID`),
  ADD KEY `I_FK_REPORT_GRP2_YEAR` (`ANNU_YEAR`);

--
-- Index pour la table `to_date`
--
ALTER TABLE `to_date`
  ADD PRIMARY KEY (`CLUB_ID`,`ANNU_YEAR`),
  ADD KEY `I_FK_TO_DATE_GRP2_CLUB` (`CLUB_ID`),
  ADD KEY `I_FK_TO_DATE_GRP2_YEAR` (`ANNU_YEAR`);

--
-- Index pour la table `users`
--
ALTER TABLE `users`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `users_email_unique` (`email`);

--
-- AUTO_INCREMENT pour les tables déchargées
--

--
-- AUTO_INCREMENT pour la table `personal_access_tokens`
--
ALTER TABLE `personal_access_tokens`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT pour la table `users`
--
ALTER TABLE `users`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- Contraintes pour les tables déchargées
--

--
-- Contraintes pour la table `grp2_ability`
--
ALTER TABLE `grp2_ability`
  ADD CONSTRAINT `FK_GRP2_ABILITY_GRP2_SKILL` FOREIGN KEY (`SKILL_ID`) REFERENCES `grp2_skill` (`SKILL_ID`);

--
-- Contraintes pour la table `grp2_attendee`
--
ALTER TABLE `grp2_attendee`
  ADD CONSTRAINT `FK_GRP2_ATTENDEE_GRP2_SESSION` FOREIGN KEY (`SESS_ID`) REFERENCES `grp2_session` (`SESS_ID`),
  ADD CONSTRAINT `FK_GRP2_ATTENDEE_GRP2_USER` FOREIGN KEY (`USER_ID`) REFERENCES `grp2_user` (`USER_ID`),
  ADD CONSTRAINT `FK_GRP2_ATTENDEE_GRP2_USER1` FOREIGN KEY (`USER_ID_ATTENDEE`) REFERENCES `grp2_user` (`USER_ID`);

--
-- Contraintes pour la table `grp2_evaluation`
--
ALTER TABLE `grp2_evaluation`
  ADD CONSTRAINT `FK_GRP2_EVALUATION_GRP2_ABILITY` FOREIGN KEY (`ABI_ID`) REFERENCES `grp2_ability` (`ABI_ID`),
  ADD CONSTRAINT `FK_GRP2_EVALUATION_GRP2_SESSION` FOREIGN KEY (`SESS_ID`) REFERENCES `grp2_session` (`SESS_ID`),
  ADD CONSTRAINT `FK_GRP2_EVALUATION_GRP2_STATUSTYPE` FOREIGN KEY (`STATUSTYPE_ID`) REFERENCES `grp2_statustype` (`STATUSTYPE_ID`),
  ADD CONSTRAINT `FK_GRP2_EVALUATION_GRP2_USER` FOREIGN KEY (`USER_ID`) REFERENCES `grp2_user` (`USER_ID`),
  ADD CONSTRAINT `fk_skill_id` FOREIGN KEY (`SKILL_ID`) REFERENCES `grp2_skill` (`SKILL_ID`);

--
-- Contraintes pour la table `grp2_session`
--
ALTER TABLE `grp2_session`
  ADD CONSTRAINT `FK_GRP2_SESSION_GRP2_SESSIONTYPE` FOREIGN KEY (`SESSTYPE_ID`) REFERENCES `grp2_sessiontype` (`SESSTYPE_ID`),
  ADD CONSTRAINT `FK_GRP2_SESSION_GRP2_TRAINING` FOREIGN KEY (`TRAIN_ID`) REFERENCES `grp2_training` (`TRAIN_ID`);

--
-- Contraintes pour la table `grp2_skill`
--
ALTER TABLE `grp2_skill`
  ADD CONSTRAINT `FK_GRP2_SKILL_GRP2_LEVEL` FOREIGN KEY (`LEVEL_ID`) REFERENCES `grp2_level` (`LEVEL_ID`);

--
-- Contraintes pour la table `grp2_user`
--
ALTER TABLE `grp2_user`
  ADD CONSTRAINT `FK_GRP2_USER_GRP2_LEVEL` FOREIGN KEY (`LEVEL_ID`) REFERENCES `grp2_level` (`LEVEL_ID`),
  ADD CONSTRAINT `FK_GRP2_USER_GRP2_LEVEL1` FOREIGN KEY (`LEVEL_ID_RESUME`) REFERENCES `grp2_level` (`LEVEL_ID`),
  ADD CONSTRAINT `FK_GRP2_USER_GRP2_TRAINING` FOREIGN KEY (`TRAIN_ID`) REFERENCES `grp2_training` (`TRAIN_ID`),
  ADD CONSTRAINT `FK_GRP2_USER_GRP2_TYPEUSER` FOREIGN KEY (`TYPE_ID`) REFERENCES `grp2_typeuser` (`TYPE_ID`);

--
-- Contraintes pour la table `grp2_validation`
--
ALTER TABLE `grp2_validation`
  ADD CONSTRAINT `FK_GRP2_VALIDATION_GRP2_ABILITY` FOREIGN KEY (`ABI_ID`) REFERENCES `grp2_ability` (`ABI_ID`),
  ADD CONSTRAINT `FK_GRP2_VALIDATION_GRP2_EVALUATION` FOREIGN KEY (`EVAL_ID`) REFERENCES `grp2_evaluation` (`EVAL_ID`),
  ADD CONSTRAINT `FK_GRP2_VALIDATION_GRP2_LEVEL` FOREIGN KEY (`LEVEL_ID`) REFERENCES `grp2_level` (`LEVEL_ID`),
  ADD CONSTRAINT `FK_GRP2_VALIDATION_GRP2_SKILL` FOREIGN KEY (`SKILL_ID`) REFERENCES `grp2_skill` (`SKILL_ID`);

--
-- Contraintes pour la table `report`
--
ALTER TABLE `report`
  ADD CONSTRAINT `FK_REPORT_GRP2_CLUB` FOREIGN KEY (`CLUB_ID`) REFERENCES `grp2_club` (`CLUB_ID`),
  ADD CONSTRAINT `FK_REPORT_GRP2_USER` FOREIGN KEY (`USER_ID`) REFERENCES `grp2_user` (`USER_ID`),
  ADD CONSTRAINT `FK_REPORT_GRP2_YEAR` FOREIGN KEY (`ANNU_YEAR`) REFERENCES `grp2_year` (`ANNU_YEAR`);

--
-- Contraintes pour la table `to_date`
--
ALTER TABLE `to_date`
  ADD CONSTRAINT `FK_TO_DATE_GRP2_CLUB` FOREIGN KEY (`CLUB_ID`) REFERENCES `grp2_club` (`CLUB_ID`),
  ADD CONSTRAINT `FK_TO_DATE_GRP2_YEAR` FOREIGN KEY (`ANNU_YEAR`) REFERENCES `grp2_year` (`ANNU_YEAR`);
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
