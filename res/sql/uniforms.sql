-- phpMyAdmin SQL Dump
-- version 4.1.14
-- http://www.phpmyadmin.net
--
-- Client :  127.0.0.1
-- Généré le :  Sam 06 Décembre 2014 à 17:50
-- Version du serveur :  5.6.17
-- Version de PHP :  5.5.12

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8 */;

--
-- Base de données :  `uniforms`
--

-- --------------------------------------------------------

--
-- Structure de la table `answervalue`
--

DROP TABLE IF EXISTS `answervalue`;
CREATE TABLE IF NOT EXISTS `answervalue` (
  `answervalue_id` int(11) NOT NULL AUTO_INCREMENT,
  `value` varchar(255) DEFAULT NULL,
  `elementanswer_id` int(11) NOT NULL,
  PRIMARY KEY (`answervalue_id`),
  KEY `fk_answervalue_elementanswer1_idx` (`elementanswer_id`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 AUTO_INCREMENT=152 ;

--
-- Contenu de la table `answervalue`
--

INSERT INTO `answervalue` (`answervalue_id`, `value`, `elementanswer_id`) VALUES
(1, '10', 1),
(2, '12', 6),
(3, '1', 3),
(4, '2', 3),
(5, '2', 7),
(6, '4', 7),
(7, '3', 7),
(100, '15', 8),
(101, '0', 9),
(102, '56', 10),
(103, '29', 11),
(104, '15', 12),
(105, '0', 13),
(106, '56', 14),
(107, '29', 15),
(108, '15', 16),
(109, '0', 17),
(110, '56', 18),
(111, '29', 19),
(112, '15', 20),
(113, '0', 21),
(114, '56', 22),
(115, '29', 23),
(116, '15', 24),
(117, '0', 25),
(118, '56', 26),
(119, '29', 27),
(120, '15', 28),
(121, '0', 29),
(122, '56', 30),
(123, '29', 31),
(124, '15', 32),
(125, '0', 33),
(126, '56', 34),
(127, '29', 35),
(144, '15', 52),
(145, '0', 53),
(146, '56', 54),
(147, '29', 55),
(148, '15', 56),
(149, '0', 57),
(150, '56', 58),
(151, '29', 59);

-- --------------------------------------------------------

--
-- Structure de la table `elementanswer`
--

DROP TABLE IF EXISTS `elementanswer`;
CREATE TABLE IF NOT EXISTS `elementanswer` (
  `elementanswer_id` int(11) NOT NULL AUTO_INCREMENT,
  `formelement_id` int(11) NOT NULL,
  `formdest_id` int(11) NOT NULL,
  PRIMARY KEY (`elementanswer_id`),
  KEY `fk_formanswers_formlist1_idx` (`formelement_id`),
  KEY `fk_formanswers_formdest1_idx` (`formdest_id`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 AUTO_INCREMENT=60 ;

--
-- Contenu de la table `elementanswer`
--

INSERT INTO `elementanswer` (`elementanswer_id`, `formelement_id`, `formdest_id`) VALUES
(1, 1, 1),
(3, 2, 1),
(6, 1, 2),
(7, 2, 2),
(8, 1, 65),
(9, 2, 65),
(10, 2, 65),
(11, 2, 65),
(12, 1, 66),
(13, 2, 66),
(14, 2, 66),
(15, 2, 66),
(16, 1, 66),
(17, 2, 66),
(18, 2, 66),
(19, 2, 66),
(20, 1, 67),
(21, 2, 67),
(22, 2, 67),
(23, 2, 67),
(24, 1, 67),
(25, 2, 67),
(26, 2, 67),
(27, 2, 67),
(28, 1, 69),
(29, 2, 69),
(30, 2, 69),
(31, 2, 69),
(32, 1, 69),
(33, 2, 69),
(34, 2, 69),
(35, 2, 69),
(52, 1, 72),
(53, 2, 72),
(54, 2, 72),
(55, 2, 72),
(56, 1, 72),
(57, 2, 72),
(58, 2, 72),
(59, 2, 72);

-- --------------------------------------------------------

--
-- Structure de la table `elementoption`
--

DROP TABLE IF EXISTS `elementoption`;
CREATE TABLE IF NOT EXISTS `elementoption` (
  `elementoption_id` int(11) NOT NULL AUTO_INCREMENT,
  `optionvalue` varchar(255) NOT NULL DEFAULT '0',
  `optionordre` int(11) NOT NULL DEFAULT '0',
  `optiondefault` tinyint(4) NOT NULL DEFAULT '0',
  PRIMARY KEY (`elementoption_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 AUTO_INCREMENT=1 ;

-- --------------------------------------------------------

--
-- Structure de la table `form`
--

DROP TABLE IF EXISTS `form`;
CREATE TABLE IF NOT EXISTS `form` (
  `form_id` int(11) NOT NULL AUTO_INCREMENT,
  `form_name` varchar(255) DEFAULT NULL,
  `form_status` tinyint(1) DEFAULT '0',
  `form_anonymous` tinyint(1) DEFAULT '0',
  `form_printable` tinyint(1) DEFAULT '1',
  `form_maxanswers` int(11) DEFAULT '1',
  `user_id` int(11) NOT NULL,
  PRIMARY KEY (`form_id`),
  KEY `fk_form_user_idx` (`user_id`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 AUTO_INCREMENT=9 ;

--
-- Contenu de la table `form`
--

INSERT INTO `form` (`form_id`, `form_name`, `form_status`, `form_anonymous`, `form_printable`, `form_maxanswers`, `user_id`) VALUES
(1, 'teste', 1, 0, 0, 1, 1),
(2, 'teste2', 1, 0, 0, 1, 1),
(3, 'teste3', 1, 0, 1, 1, 2),
(4, 'teste4', 1, 1, 1, 25, 4),
(5, NULL, 1, 0, 1, 1, 1),
(6, NULL, 1, 0, 1, 3, 1),
(7, NULL, 0, 0, 1, 2, 1),
(8, NULL, 0, 0, 0, 1, 1);

-- --------------------------------------------------------

--
-- Structure de la table `formdest`
--

DROP TABLE IF EXISTS `formdest`;
CREATE TABLE IF NOT EXISTS `formdest` (
  `formdest_id` int(11) NOT NULL AUTO_INCREMENT,
  `formdest_status` tinyint(1) DEFAULT '0',
  `user_id` int(11) NOT NULL,
  `form_id` int(11) NOT NULL,
  PRIMARY KEY (`formdest_id`),
  KEY `fk_formdest_user1_idx` (`user_id`),
  KEY `fk_formdest_form1_idx` (`form_id`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 AUTO_INCREMENT=90 ;

--
-- Contenu de la table `formdest`
--

INSERT INTO `formdest` (`formdest_id`, `formdest_status`, `user_id`, `form_id`) VALUES
(1, 0, 1, 4),
(2, 0, 1, 3),
(36, 0, 2, 1),
(37, 0, 3, 1),
(39, 0, 4, 5),
(40, 0, 3, 5),
(44, 0, 3, 6),
(45, 0, 4, 6),
(46, 0, 2, 7),
(47, 0, 3, 7),
(48, 0, 1, 4),
(49, 0, 1, 4),
(50, 0, 1, 4),
(51, 1, 1, 4),
(52, 1, 1, 4),
(53, 1, 1, 4),
(54, 1, 1, 4),
(55, 1, 1, 4),
(56, 1, 1, 4),
(57, 1, 1, 4),
(58, 1, 1, 4),
(59, 1, 1, 4),
(60, 1, 1, 4),
(61, 1, 1, 4),
(62, 1, 1, 4),
(63, 0, 1, 4),
(64, 0, 1, 4),
(65, 0, 1, 4),
(66, 1, 1, 4),
(67, 1, 1, 4),
(68, 0, 1, 4),
(69, 1, 1, 4),
(72, 1, 1, 4),
(88, 0, 2, 8),
(89, 0, 3, 8);

-- --------------------------------------------------------

--
-- Structure de la table `formelement`
--

DROP TABLE IF EXISTS `formelement`;
CREATE TABLE IF NOT EXISTS `formelement` (
  `formelement_id` int(11) NOT NULL AUTO_INCREMENT,
  `type_element` int(11) DEFAULT NULL,
  `form_id` int(11) NOT NULL,
  `x` int(11) NOT NULL,
  `y` int(11) NOT NULL,
  `default` varchar(255) DEFAULT NULL,
  `required` tinyint(1) DEFAULT '0',
  `width` int(11) DEFAULT NULL,
  `height` int(11) DEFAULT NULL,
  `placeholder` varchar(255) DEFAULT NULL,
  `direction` tinyint(1) DEFAULT '0',
  `isbiglist` tinyint(1) DEFAULT '0',
  PRIMARY KEY (`formelement_id`),
  KEY `fk_formlist_form1_idx` (`form_id`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 AUTO_INCREMENT=3 ;

--
-- Contenu de la table `formelement`
--

INSERT INTO `formelement` (`formelement_id`, `type_element`, `form_id`, `x`, `y`, `default`, `required`, `width`, `height`, `placeholder`, `direction`, `isbiglist`) VALUES
(1, NULL, 1, 0, 0, NULL, 0, NULL, NULL, NULL, NULL, 0),
(2, NULL, 1, 0, 0, NULL, 0, NULL, NULL, NULL, NULL, 0);

-- --------------------------------------------------------

--
-- Structure de la table `user`
--

DROP TABLE IF EXISTS `user`;
CREATE TABLE IF NOT EXISTS `user` (
  `user_id` int(11) NOT NULL AUTO_INCREMENT,
  `user_name` varchar(255) DEFAULT NULL,
  PRIMARY KEY (`user_id`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 AUTO_INCREMENT=5 ;

--
-- Contenu de la table `user`
--

INSERT INTO `user` (`user_id`, `user_name`) VALUES
(0, 'Anonymous'),
(1, 'Luis'),
(2, 'Romain'),
(3, 'Genevieve'),
(4, 'Ayoub');

--
-- Contraintes pour les tables exportées
--

--
-- Contraintes pour la table `answervalue`
--
ALTER TABLE `answervalue`
  ADD CONSTRAINT `fk_answervalue_elementanswer` FOREIGN KEY (`elementanswer_id`) REFERENCES `elementanswer` (`elementanswer_id`) ON DELETE CASCADE;

--
-- Contraintes pour la table `elementanswer`
--
ALTER TABLE `elementanswer`
  ADD CONSTRAINT `fk_elementanswer_formdest` FOREIGN KEY (`formdest_id`) REFERENCES `formdest` (`formdest_id`) ON DELETE CASCADE,
  ADD CONSTRAINT `fk_elementanswer_formelement` FOREIGN KEY (`formelement_id`) REFERENCES `formelement` (`formelement_id`) ON DELETE CASCADE;

--
-- Contraintes pour la table `form`
--
ALTER TABLE `form`
  ADD CONSTRAINT `fk_form_user` FOREIGN KEY (`user_id`) REFERENCES `user` (`user_id`) ON DELETE CASCADE ON UPDATE NO ACTION;

--
-- Contraintes pour la table `formdest`
--
ALTER TABLE `formdest`
  ADD CONSTRAINT `fk_formdest_form1` FOREIGN KEY (`form_id`) REFERENCES `form` (`form_id`) ON DELETE CASCADE ON UPDATE NO ACTION,
  ADD CONSTRAINT `fk_formdest_user1` FOREIGN KEY (`user_id`) REFERENCES `user` (`user_id`) ON DELETE CASCADE ON UPDATE NO ACTION;

--
-- Contraintes pour la table `formelement`
--
ALTER TABLE `formelement`
  ADD CONSTRAINT `fk_formlist_form1` FOREIGN KEY (`form_id`) REFERENCES `form` (`form_id`) ON DELETE CASCADE ON UPDATE NO ACTION;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
