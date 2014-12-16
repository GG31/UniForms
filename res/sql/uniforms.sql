-- phpMyAdmin SQL Dump
-- version 4.1.14
-- http://www.phpmyadmin.net
--
-- Client :  127.0.0.1
-- Généré le :  Mar 16 Décembre 2014 à 10:55
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
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 AUTO_INCREMENT=8 ;

--
-- Contenu de la table `answervalue`
--

INSERT INTO `answervalue` (`answervalue_id`, `value`, `elementanswer_id`) VALUES
(2, '12', 6),
(5, '2', 7),
(6, '4', 7),
(7, '3', 7);

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
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 AUTO_INCREMENT=8 ;

--
-- Contenu de la table `elementanswer`
--

INSERT INTO `elementanswer` (`elementanswer_id`, `formelement_id`, `formdest_id`) VALUES
(6, 1, 2),
(7, 2, 2);

-- --------------------------------------------------------

--
-- Structure de la table `elementoption`
--

DROP TABLE IF EXISTS `elementoption`;
CREATE TABLE IF NOT EXISTS `elementoption` (
  `elementoption_id` int(11) NOT NULL AUTO_INCREMENT,
  `optionvalue` varchar(255) NOT NULL DEFAULT '0',
  `optionorder` int(11) NOT NULL DEFAULT '0',
  `optiondefault` tinyint(4) NOT NULL DEFAULT '0',
  `formelement_id` int(11) DEFAULT NULL,
  PRIMARY KEY (`elementoption_id`),
  KEY `FK_elementoption_formelement` (`formelement_id`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 AUTO_INCREMENT=51 ;

--
-- Contenu de la table `elementoption`
--

INSERT INTO `elementoption` (`elementoption_id`, `optionvalue`, `optionorder`, `optiondefault`, `formelement_id`) VALUES
(1, 'op1', 3, 0, 4),
(2, 'op2', 2, 1, 4),
(48, 'secondoption', 2, 1, 45),
(49, 'thirdoption', 3, 0, 45),
(50, 'firstoption', 1, 1, 45);

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
(4, 'teste4', 0, 1, 1, 25, 4),
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
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 AUTO_INCREMENT=714 ;

--
-- Contenu de la table `formdest`
--

INSERT INTO `formdest` (`formdest_id`, `formdest_status`, `user_id`, `form_id`) VALUES
(2, 0, 1, 3),
(36, 0, 2, 1),
(37, 0, 3, 1),
(39, 0, 4, 5),
(40, 0, 3, 5),
(44, 0, 3, 6),
(45, 0, 4, 6),
(46, 0, 2, 7),
(47, 0, 3, 7),
(88, 0, 2, 8),
(89, 0, 3, 8),
(690, 0, 1, 4),
(691, 0, 1, 4),
(692, 0, 1, 4),
(693, 0, 1, 4),
(694, 0, 1, 4),
(695, 0, 1, 4),
(696, 0, 1, 4),
(697, 0, 1, 4),
(698, 0, 1, 4),
(699, 0, 1, 4),
(700, 0, 1, 4),
(701, 0, 1, 4),
(702, 0, 1, 4),
(703, 0, 1, 4),
(704, 0, 1, 4),
(705, 0, 1, 4),
(706, 0, 1, 4),
(707, 0, 1, 4),
(708, 0, 1, 4),
(709, 0, 1, 4),
(710, 0, 1, 4),
(711, 0, 1, 4),
(712, 0, 1, 4),
(713, 0, 1, 4);

-- --------------------------------------------------------

--
-- Structure de la table `formelement`
--

DROP TABLE IF EXISTS `formelement`;
CREATE TABLE IF NOT EXISTS `formelement` (
  `formelement_id` int(11) NOT NULL AUTO_INCREMENT,
  `type_element` int(11) DEFAULT NULL,
  `form_id` int(11) NOT NULL,
  `pos_x` int(11) NOT NULL,
  `pos_y` int(11) NOT NULL,
  `default_value` varchar(255) DEFAULT NULL,
  `required` tinyint(1) DEFAULT '0',
  `width` int(11) DEFAULT NULL,
  `height` int(11) DEFAULT NULL,
  `placeholder` varchar(255) DEFAULT NULL,
  `direction` tinyint(1) DEFAULT '0',
  `isbiglist` tinyint(1) DEFAULT '0',
  `max_value` int(11) DEFAULT NULL,
  `min_value` int(11) DEFAULT NULL,
  PRIMARY KEY (`formelement_id`),
  KEY `fk_formlist_form1_idx` (`form_id`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 AUTO_INCREMENT=46 ;

--
-- Contenu de la table `formelement`
--

INSERT INTO `formelement` (`formelement_id`, `type_element`, `form_id`, `pos_x`, `pos_y`, `default_value`, `required`, `width`, `height`, `placeholder`, `direction`, `isbiglist`, `max_value`, `min_value`) VALUES
(1, NULL, 1, 0, 0, NULL, 0, NULL, NULL, NULL, NULL, 0, NULL, NULL),
(2, NULL, 1, 0, 0, NULL, 0, NULL, NULL, NULL, NULL, 0, NULL, NULL),
(3, 1, 3, 15, 14, 'edfaulti', 1, 300, 15, 'place', 1, 0, NULL, NULL),
(4, 2, 3, 34, 455, NULL, 0, NULL, NULL, NULL, 0, 1, NULL, NULL),
(44, 1, 4, 25, 12, 'default', 1, 123, 23, 'placeholder', 0, 0, 100, 1),
(45, 2, 4, 234, 15, '', 0, 0, 0, '', 1, 1, 0, 0);

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
-- Contraintes pour la table `elementoption`
--
ALTER TABLE `elementoption`
  ADD CONSTRAINT `FK_elementoption_formelement` FOREIGN KEY (`formelement_id`) REFERENCES `formelement` (`formelement_id`) ON DELETE CASCADE;

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
