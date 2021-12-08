-- phpMyAdmin SQL Dump
-- version 5.0.2
-- https://www.phpmyadmin.net/
--
-- Hôte : 127.0.0.1:3306
-- Généré le : mar. 07 déc. 2021 à 02:42
-- Version du serveur :  5.7.31
-- Version de PHP : 7.4.9

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Base de données : `ledukilian_p5_blog`
--

-- --------------------------------------------------------

--
-- Structure de la table `admin`
--

DROP TABLE IF EXISTS `admin`;
CREATE TABLE IF NOT EXISTS `admin` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `id_user` int(11) NOT NULL,
  `catch_phrase` varchar(200) NOT NULL,
  `avatar_url` varchar(300) NOT NULL,
  `avatar_alt_url` varchar(300) NOT NULL,
  `url_cv` varchar(300) NOT NULL,
  `created_at` datetime NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `updated_at` datetime NOT NULL DEFAULT CURRENT_TIMESTAMP,
  PRIMARY KEY (`id`),
  KEY `id_user` (`id_user`)
) ENGINE=InnoDB AUTO_INCREMENT=2 DEFAULT CHARSET=utf8;

--
-- Déchargement des données de la table `admin`
--

INSERT INTO `admin` (`id`, `id_user`, `catch_phrase`, `avatar_url`, `avatar_alt_url`, `url_cv`, `created_at`, `updated_at`) VALUES
(1, 1, 'Le développeur qu\'il vous faut', '/img/avatar_moi.png', 'Photo de profil modifié', '/pdf/CV.pdf', '2021-07-19 09:32:12', '2021-12-07 03:41:54');

-- --------------------------------------------------------

--
-- Structure de la table `comment`
--

DROP TABLE IF EXISTS `comment`;
CREATE TABLE IF NOT EXISTS `comment` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `user_id` int(11) NOT NULL,
  `post_id` int(11) NOT NULL,
  `comment` varchar(500) NOT NULL,
  `status` tinyint(1) NOT NULL,
  `created_at` datetime NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `updated_at` datetime NOT NULL DEFAULT CURRENT_TIMESTAMP,
  PRIMARY KEY (`id`),
  KEY `id_user` (`user_id`),
  KEY `id_post` (`post_id`)
) ENGINE=InnoDB AUTO_INCREMENT=4 DEFAULT CHARSET=utf8;

--
-- Déchargement des données de la table `comment`
--

INSERT INTO `comment` (`id`, `user_id`, `post_id`, `comment`, `status`, `created_at`, `updated_at`) VALUES
(1, 1, 1, 'Ceci est un test', 1, '2021-12-07 03:20:25', '2021-12-07 03:20:53'),
(2, 1, 1, 'Ceci est encore un test', 1, '2021-12-07 03:21:14', '2021-12-07 03:21:19'),
(3, 1, 1, 'Ceci est encore encore un test\r\n', 1, '2021-12-07 03:22:16', '2021-12-07 03:22:25');

-- --------------------------------------------------------

--
-- Structure de la table `post`
--

DROP TABLE IF EXISTS `post`;
CREATE TABLE IF NOT EXISTS `post` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `admin_id` int(11) NOT NULL,
  `title` varchar(150) NOT NULL,
  `cover_img` varchar(150) NOT NULL,
  `cover_alt_img` varchar(150) NOT NULL,
  `lead` varchar(150) NOT NULL,
  `content` text NOT NULL,
  `slug` varchar(150) NOT NULL,
  `created_at` datetime NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `updated_at` datetime NOT NULL DEFAULT CURRENT_TIMESTAMP,
  PRIMARY KEY (`id`),
  KEY `id_admin` (`admin_id`)
) ENGINE=InnoDB AUTO_INCREMENT=10 DEFAULT CHARSET=utf8;

--
-- Déchargement des données de la table `post`
--

INSERT INTO `post` (`id`, `admin_id`, `title`, `cover_img`, `cover_alt_img`, `lead`, `content`, `slug`, `created_at`, `updated_at`) VALUES
(1, 1, 'Jolie prairie', 'article_00001', 'Image article 7', 'Lead', 'Lorem ipsum dolor sit amet, consectetur adipiscing elit. Aenean non nibh interdum massa faucibus posuere eget et turpis. Donec scelerisque risus sodales, rutrum quam sit amet, imperdiet odio. Integer id hendrerit massa, in finibus lectus. Duis mauris lacus, vehicula sit amet efficitur ac, mattis tristique sapien. Sed feugiat nunc vel sapien aliquam, at lacinia odio vehicula. Curabitur sollicitudin a velit vel luctus. In efficitur bibendum facilisis. Nullam ultrices porta venenatis.', 'slug-1', '2021-06-28 09:31:57', '2021-06-28 09:31:57'),
(2, 1, 'Arbre vert', 'article_00002', 'Image article 2', 'Lead', 'Lorem ipsum dolor sit amet, consectetur adipiscing elit. Aenean non nibh interdum massa faucibus posuere eget et turpis. Donec scelerisque risus sodales, rutrum quam sit amet, imperdiet odio. Integer id hendrerit massa, in finibus lectus. Duis mauris lacus, vehicula sit amet efficitur ac, mattis tristique sapien. Sed feugiat nunc vel sapien aliquam, at lacinia odio vehicula. Curabitur sollicitudin a velit vel luctus. In efficitur bibendum facilisis. Nullam ultrices porta venenatis.', 'slug-2', '2021-06-28 09:31:57', '2021-06-28 09:31:57'),
(4, 1, 'Montagne neige', 'article_00004', 'Image article 4', 'Lead', 'Lorem ipsum dolor sit amet, consectetur adipiscing elit. Aenean non nibh interdum massa faucibus posuere eget et turpis. Donec scelerisque risus sodales, rutrum quam sit amet, imperdiet odio. Integer id hendrerit massa, in finibus lectus. Duis mauris lacus, vehicula sit amet efficitur ac, mattis tristique sapien. Sed feugiat nunc vel sapien aliquam, at lacinia odio vehicula. Curabitur sollicitudin a velit vel luctus. In efficitur bibendum facilisis. Nullam ultrices porta venenatis.', 'slug-3', '2021-06-28 09:31:57', '2021-06-28 09:31:57'),
(6, 1, 'Désert arche', 'article_00006', 'Image article 6', 'Lead', 'Lorem ipsum dolor sit amet, consectetur adipiscing elit. Aenean non nibh interdum massa faucibus posuere eget et turpis. Donec scelerisque risus sodales, rutrum quam sit amet, imperdiet odio. Integer id hendrerit massa, in finibus lectus. Duis mauris lacus, vehicula sit amet efficitur ac, mattis tristique sapien. Sed feugiat nunc vel sapien aliquam, at lacinia odio vehicula. Curabitur sollicitudin a velit vel luctus. In efficitur bibendum facilisis. Nullam ultrices porta venenatis.', 'slug-4', '2021-06-28 09:31:57', '2021-06-28 09:31:57'),
(8, 1, 'Lac et eau', 'article_00003', 'Image article 8', 'Lead', 'Lorem ipsum dolor sit amet, consectetur adipiscing elit. Aenean non nibh interdum massa faucibus posuere eget et turpis. Donec scelerisque risus sodales, rutrum quam sit amet, imperdiet odio. Integer id hendrerit massa, in finibus lectus. Duis mauris lacus, vehicula sit amet efficitur ac, mattis tristique sapien. Sed feugiat nunc vel sapien aliquam, at lacinia odio vehicula. Curabitur sollicitudin a velit vel luctus. In efficitur bibendum facilisis. Nullam ultrices porta venenatis.', 'slug-5', '2021-06-28 09:31:57', '2021-06-28 09:31:57'),
(9, 1, 'Cabane dans les bois', 'article_00005', 'Image article 9', 'Lead', 'Lorem ipsum dolor sit amet, consectetur adipiscing elit. Aenean non nibh interdum massa faucibus posuere eget et turpis. Donec scelerisque risus sodales, rutrum quam sit amet, imperdiet odio. Integer id hendrerit massa, in finibus lectus. Duis mauris lacus, vehicula sit amet efficitur ac, mattis tristique sapien. Sed feugiat nunc vel sapien aliquam, at lacinia odio vehicula. Curabitur sollicitudin a velit vel luctus. In efficitur bibendum facilisis. Nullam ultrices porta venenatis.', 'slug-6', '2021-06-28 09:31:57', '2021-06-28 09:31:57');

-- --------------------------------------------------------

--
-- Structure de la table `social`
--

DROP TABLE IF EXISTS `social`;
CREATE TABLE IF NOT EXISTS `social` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `id_admin` int(11) NOT NULL,
  `name` varchar(100) NOT NULL,
  `icon` varchar(300) NOT NULL,
  `link` varchar(300) NOT NULL,
  `created_at` datetime NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `updated_at` datetime NOT NULL DEFAULT CURRENT_TIMESTAMP,
  PRIMARY KEY (`id`),
  KEY `id_admin` (`id_admin`)
) ENGINE=InnoDB AUTO_INCREMENT=3 DEFAULT CHARSET=utf8;

--
-- Déchargement des données de la table `social`
--

INSERT INTO `social` (`id`, `id_admin`, `name`, `icon`, `link`, `created_at`, `updated_at`) VALUES
(1, 1, 'Twitter', '<i class=\"fab fa-twitter\"></i>', 'https://twitter.com/kilian_ld', '2021-08-30 23:31:34', '2021-12-03 23:26:00'),
(2, 1, 'LinkedIn', '<i class=\"fab fa-linkedin-in\"></i>', 'https://www.linkedin.com/in/ledu-kilian/', '2021-08-30 23:31:34', '2021-12-03 23:36:10');

-- --------------------------------------------------------

--
-- Structure de la table `user`
--

DROP TABLE IF EXISTS `user`;
CREATE TABLE IF NOT EXISTS `user` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `username` varchar(80) NOT NULL,
  `lastname` varchar(80) NOT NULL,
  `firstname` varchar(80) NOT NULL,
  `email` varchar(255) NOT NULL,
  `password` varchar(255) NOT NULL,
  `role` varchar(50) NOT NULL,
  `created_at` datetime NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `updated_at` datetime NOT NULL DEFAULT CURRENT_TIMESTAMP,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=2 DEFAULT CHARSET=utf8;

--
-- Déchargement des données de la table `user`
--

INSERT INTO `user` (`id`, `username`, `lastname`, `firstname`, `email`, `password`, `role`, `created_at`, `updated_at`) VALUES
(1, 'admin', 'Admin', 'Admin', 'admin@admin.dev', '$2y$10$z4qlAwz0PB18ejF9b65r0OrkrAzngkx2f/.yxnaWvPHpwQ98g/fAC', 'ADMIN', '2021-07-04 21:42:37', '2021-12-07 03:41:54');

--
-- Contraintes pour les tables déchargées
--

--
-- Contraintes pour la table `admin`
--
ALTER TABLE `admin`
  ADD CONSTRAINT `admin_ibfk_1` FOREIGN KEY (`id_user`) REFERENCES `user` (`id`);

--
-- Contraintes pour la table `comment`
--
ALTER TABLE `comment`
  ADD CONSTRAINT `comment_ibfk_1` FOREIGN KEY (`user_id`) REFERENCES `user` (`id`),
  ADD CONSTRAINT `comment_ibfk_2` FOREIGN KEY (`post_id`) REFERENCES `post` (`id`) ON DELETE CASCADE;

--
-- Contraintes pour la table `post`
--
ALTER TABLE `post`
  ADD CONSTRAINT `post_ibfk_1` FOREIGN KEY (`admin_id`) REFERENCES `admin` (`id`);

--
-- Contraintes pour la table `social`
--
ALTER TABLE `social`
  ADD CONSTRAINT `social_ibfk_1` FOREIGN KEY (`id_admin`) REFERENCES `admin` (`id`);
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
