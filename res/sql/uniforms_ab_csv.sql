-- phpMyAdmin SQL Dump
-- version 3.5.1
-- http://www.phpmyadmin.net
--
-- Client: localhost
-- Généré le: Mar 16 Décembre 2014 à 20:58
-- Version du serveur: 5.5.24-log
-- Version de PHP: 5.4.3

SET SQL_MODE="NO_AUTO_VALUE_ON_ZERO";
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8 */;

--
-- Base de données: `uniforms`
--

-- --------------------------------------------------------

--
-- Structure de la table `answervalue`
--

CREATE TABLE IF NOT EXISTS `answervalue` (
  `answervalue_id` int(11) NOT NULL AUTO_INCREMENT,
  `value` varchar(255) DEFAULT NULL,
  `elementanswer_id` int(11) NOT NULL,
  PRIMARY KEY (`answervalue_id`),
  KEY `fk_answervalue_elementanswer1_idx` (`elementanswer_id`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 AUTO_INCREMENT=10 ;

--
-- Contenu de la table `answervalue`
--

INSERT INTO `answervalue` (`answervalue_id`, `value`, `elementanswer_id`) VALUES
(2, '12', 6),
(5, '2', 7),
(6, '4', 7),
(7, '3', 7),
(8, 'Oui je suis d''accord', 8),
(9, 'J''accepte pas votre offre', 9);

-- --------------------------------------------------------

--
-- Structure de la table `elementanswer`
--

CREATE TABLE IF NOT EXISTS `elementanswer` (
  `elementanswer_id` int(11) NOT NULL AUTO_INCREMENT,
  `formelement_id` int(11) NOT NULL,
  `formdest_id` int(11) NOT NULL,
  PRIMARY KEY (`elementanswer_id`),
  KEY `fk_formanswers_formlist1_idx` (`formelement_id`),
  KEY `fk_formanswers_formdest1_idx` (`formdest_id`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 AUTO_INCREMENT=10 ;

--
-- Contenu de la table `elementanswer`
--

INSERT INTO `elementanswer` (`elementanswer_id`, `formelement_id`, `formdest_id`) VALUES
(6, 1, 2),
(7, 2, 2),
(8, 4, 40),
(9, 4, 39);

-- --------------------------------------------------------

--
-- Structure de la table `elementoption`
--

CREATE TABLE IF NOT EXISTS `elementoption` (
  `elementoption_id` int(11) NOT NULL AUTO_INCREMENT,
  `optionvalue` varchar(255) NOT NULL DEFAULT '0',
  `optionorder` int(11) NOT NULL DEFAULT '0',
  `optiondefault` tinyint(4) NOT NULL DEFAULT '0',
  `formelement_id` int(11) DEFAULT NULL,
  PRIMARY KEY (`elementoption_id`),
  KEY `FK_elementoption_formelement` (`formelement_id`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 AUTO_INCREMENT=54 ;

--
-- Contenu de la table `elementoption`
--

INSERT INTO `elementoption` (`elementoption_id`, `optionvalue`, `optionorder`, `optiondefault`, `formelement_id`) VALUES
(1, 'op1', 3, 0, 4),
(2, 'op2', 2, 1, 4),
(51, 'secondoption', 2, 1, 47),
(52, 'thirdoption', 3, 0, 47),
(53, 'firstoption', 1, 1, 47);

-- --------------------------------------------------------

--
-- Structure de la table `form`
--

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
(3, 'teste3', 1, 0, 1, 1, 4),
(4, 'teste4', 0, 1, 1, 3, 4),
(5, NULL, 1, 0, 1, 1, 4),
(6, NULL, 1, 0, 1, 3, 1),
(7, NULL, 0, 0, 1, 2, 1),
(8, NULL, 0, 0, 0, 1, 1);

-- --------------------------------------------------------

--
-- Structure de la table `formdest`
--

CREATE TABLE IF NOT EXISTS `formdest` (
  `formdest_id` int(11) NOT NULL AUTO_INCREMENT,
  `formdest_status` tinyint(1) DEFAULT '0',
  `user_id` int(11) NOT NULL,
  `form_id` int(11) NOT NULL,
  PRIMARY KEY (`formdest_id`),
  KEY `fk_formdest_user1_idx` (`user_id`),
  KEY `fk_formdest_form1_idx` (`form_id`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 AUTO_INCREMENT=738 ;

--
-- Contenu de la table `formdest`
--

INSERT INTO `formdest` (`formdest_id`, `formdest_status`, `user_id`, `form_id`) VALUES
(2, 1, 1, 3),
(36, 0, 2, 1),
(37, 0, 3, 1),
(39, 1, 4, 5),
(40, 1, 3, 5),
(44, 0, 3, 6),
(45, 0, 4, 6),
(46, 0, 2, 7),
(47, 0, 3, 7),
(88, 0, 2, 8),
(89, 0, 3, 8),
(727, 0, 0, 4),
(728, 0, 1, 4),
(729, 0, 1, 4),
(730, 0, 1, 4),
(731, 0, 1, 4),
(732, 0, 1, 4),
(733, 0, 1, 4),
(734, 0, 1, 4),
(735, 0, 1, 4),
(736, 0, 1, 4),
(737, 0, 1, 4);

-- --------------------------------------------------------

--
-- Structure de la table `formelement`
--

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
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 AUTO_INCREMENT=48 ;

--
-- Contenu de la table `formelement`
--

INSERT INTO `formelement` (`formelement_id`, `type_element`, `form_id`, `pos_x`, `pos_y`, `default_value`, `required`, `width`, `height`, `placeholder`, `direction`, `isbiglist`, `max_value`, `min_value`) VALUES
(1, NULL, 1, 0, 0, NULL, 0, NULL, NULL, NULL, NULL, 0, NULL, NULL),
(2, NULL, 1, 0, 0, NULL, 0, NULL, NULL, NULL, NULL, 0, NULL, NULL),
(3, 1, 3, 15, 14, 'edfaulti', 1, 300, 15, 'place', 1, 0, NULL, NULL),
(4, 2, 5, 34, 455, NULL, 0, NULL, NULL, NULL, 0, 1, NULL, NULL),
(46, 1, 4, 25, 12, 'default', 1, 123, 23, 'placeholder', 0, 0, 100, 1),
(47, 2, 4, 234, 15, '', 0, 0, 0, '', 1, 1, 0, 0);

-- --------------------------------------------------------

--
-- Structure de la table `user`
--

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
