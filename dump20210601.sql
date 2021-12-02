-- phpMyAdmin SQL Dump
-- version 4.8.5
-- https://www.phpmyadmin.net/
--
-- Hôte : 127.0.0.1:3306
-- Généré le :  mar. 01 juin 2021 à 12:04
-- Version du serveur :  5.7.26
-- Version de PHP :  7.2.18

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET AUTOCOMMIT = 0;
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Base de données :  `blogolivier`
--

-- --------------------------------------------------------

--
-- Structure de la table `article`
--

DROP TABLE IF EXISTS `article`;
CREATE TABLE IF NOT EXISTS `article` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `title` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `content` text COLLATE utf8mb4_unicode_ci NOT NULL,
  `created_at` datetime NOT NULL,
  `id_category` int(11) NOT NULL,
  PRIMARY KEY (`id`),
  KEY `category_id` (`id_category`)
) ENGINE=InnoDB AUTO_INCREMENT=6 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Déchargement des données de la table `article`
--

INSERT INTO `article` (`id`, `title`, `content`, `created_at`, `id_category`) VALUES
(1, 'Boieng 747 : le jumbo jet', 'Le Boeing 747 est un avion de ligne à réaction américain à fuselage large construit depuis 1969 par Boeing, souvent désigné par son surnom, Jumbo Jet ou Reine des Ciels. Sa « bosse » caractéristique à l\'avant du fuselage fait du 747 un appareil particulièrement reconnaissable.Le pont supérieur est conçu pour servir de salon de première classe ou accueillir des sièges supplémentaires et permet également à l\'avion d\'être facilement converti en cargo en retirant les sièges et en installant une porte cargo sur le nez. En effet, Boeing s\'attend à l\'arrivée d\'avions de ligne supersoniques, dont le développement est annoncé au début des années 1960, ce qui rendrait le 747 et d\'autres avions obsolètes tandis que la demande d\'appareils cargo subsoniques devrait être soutenue. Le 747 est appelé à devenir obsolète après 400 appareils vendus mais il dépasse les attentes des critiques et, en 1993, le 1000e appareil est construit. En mai 2020, 1 555 appareils avaient été livrés depuis 1970 et 16 restent en commande. ', '2021-02-15 09:13:13', 1),
(3, 'Boieng 777 : le dreamliner', 'Le Boeing 777 ou B777, parfois surnommé triple sept dans le milieu aérien, est un avion de ligne gros porteur, long courrier et biréacteur construit par la société Boeing depuis 1994. En 2013, il devient le gros porteur le plus vendu dans l\'histoire de l\'aviation. En septembre 2019, le carnet de commandes de Boeing compte 2 049 commandes pour le 777 dont 1 616 ont été livrées, faisant de cet avion un succès commercial pour son constructeur. ', '2021-01-18 09:16:09', 2),
(5, 'Airbus A380 : le géant des airs', 'L\'Airbus A380 est un avion de ligne civil très gros-porteur long-courrier quadriréacteur à double pont, produit par Airbus. Les éléments sont fabriqués et assemblés dans différents pays de l\'Union européenne ; les principaux lieux sont en France, en Allemagne, en Espagne et au Royaume-Uni. a conception de l\'A380 avait pour objectif constant de transporter plus de passagers que le 747 tout en consommant moins. Ces objectifs sont atteints aujourd\'hui et la supériorité de capacité n\'est pas menacée. Même si le futur Boeing 747-8 devrait consommer 13 % de moins par passager que l\'A380 actuel et avoir globalement un coût d\'exploitation inférieur de 19 %, sa capacité restera très en deçà de celle de l\'A380 avec 105 passagers de moins en configuration 3 classes. ', '2020-12-14 09:17:04', 1);

-- --------------------------------------------------------

--
-- Structure de la table `category`
--

DROP TABLE IF EXISTS `category`;
CREATE TABLE IF NOT EXISTS `category` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `label` varchar(256) CHARACTER SET utf8 NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=3 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Déchargement des données de la table `category`
--

INSERT INTO `category` (`id`, `label`) VALUES
(1, 'aviation'),
(2, 'aero');

-- --------------------------------------------------------

--
-- Structure de la table `comment`
--

DROP TABLE IF EXISTS `comment`;
CREATE TABLE IF NOT EXISTS `comment` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `content` text COLLATE utf8mb4_unicode_ci NOT NULL,
  `created_at` datetime NOT NULL,
  `article_id` int(11) NOT NULL,
  PRIMARY KEY (`id`),
  KEY `article_id` (`article_id`)
) ENGINE=InnoDB AUTO_INCREMENT=43 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Déchargement des données de la table `comment`
--

INSERT INTO `comment` (`id`, `content`, `created_at`, `article_id`) VALUES
(26, 'gfgf', '2021-05-31 16:02:23', 1),
(27, 'tgh', '2021-06-01 08:15:58', 1),
(28, 'gh', '2021-06-01 08:16:12', 3),
(29, 'hh', '2021-06-01 08:30:10', 3),
(42, 'ssddz', '2021-06-01 11:44:02', 1);

--
-- Contraintes pour les tables déchargées
--

--
-- Contraintes pour la table `article`
--
ALTER TABLE `article`
  ADD CONSTRAINT `article_ibfk_1` FOREIGN KEY (`id_category`) REFERENCES `category` (`id`);

--
-- Contraintes pour la table `comment`
--
ALTER TABLE `comment`
  ADD CONSTRAINT `comment_ibfk_1` FOREIGN KEY (`article_id`) REFERENCES `article` (`id`);
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
