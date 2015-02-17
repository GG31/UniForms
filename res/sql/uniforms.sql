-- phpMyAdmin SQL Dump
-- version 4.1.14
-- http://www.phpmyadmin.net
--
-- Host: 127.0.0.1
-- Generation Time: 17-Fev-2015 às 22:53
-- Versão do servidor: 5.6.17
-- PHP Version: 5.5.12

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8 */;

--
-- Database: `uniforms`
--

-- --------------------------------------------------------

--
-- Estrutura da tabela `answervalue`
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
-- Extraindo dados da tabela `answervalue`
--

INSERT INTO `answervalue` (`answervalue_id`, `value`, `elementanswer_id`) VALUES
(2, '12', 6),
(5, '2', 7),
(6, '4', 7),
(7, '3', 7);

-- --------------------------------------------------------

--
-- Estrutura da tabela `elementanswer`
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
-- Extraindo dados da tabela `elementanswer`
--

INSERT INTO `elementanswer` (`elementanswer_id`, `formelement_id`, `formdest_id`) VALUES
(6, 1, 36),
(7, 2, 36);

-- --------------------------------------------------------

--
-- Estrutura da tabela `elementoption`
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
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 AUTO_INCREMENT=57 ;

--
-- Extraindo dados da tabela `elementoption`
--

INSERT INTO `elementoption` (`elementoption_id`, `optionvalue`, `optionorder`, `optiondefault`, `formelement_id`) VALUES
(1, 'op1', 3, 0, 4),
(2, 'op2', 2, 1, 4),
(54, 'secondoption', 2, 1, 56),
(55, 'thirdoption', 3, 0, 56),
(56, 'firstoption', 1, 1, 56);

-- --------------------------------------------------------

--
-- Estrutura da tabela `form`
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
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 AUTO_INCREMENT=30 ;

--
-- Extraindo dados da tabela `form`
--

INSERT INTO `form` (`form_id`, `form_name`, `form_status`, `form_anonymous`, `form_printable`, `form_maxanswers`, `user_id`) VALUES
(1, 'teste', 1, 0, 0, 1, 1),
(3, 'teste3', 1, 0, 1, 1, 2),
(4, 'teste4', 0, 1, 1, 25, 4),
(5, NULL, 1, 0, 1, 1, 1),
(6, NULL, 1, 0, 1, 3, 1),
(7, NULL, 0, 0, 1, 2, 1),
(8, NULL, 0, 0, 0, 1, 1),
(9, NULL, 0, 0, 1, 1, 1),
(10, NULL, 0, 0, 1, 1, 1),
(11, '', 1, 0, 1, 1, 1),
(12, '', 1, 0, 1, 1, 1),
(13, '', 0, 0, 1, 1, 1),
(14, '', 0, 0, 1, 1, 1),
(15, '', 1, 0, 1, 1, 1),
(16, '', 1, 0, 1, 1, 1),
(17, '', 1, 0, 1, 1, 1),
(18, '', 1, 0, 1, 1, 1),
(19, '', 0, 0, 1, 1, 1),
(20, '', 0, 0, 1, 1, 1),
(21, '', 0, 0, 1, 1, 8),
(22, '', 1, 0, 1, 1, 8),
(23, '', 0, 0, 1, 5, 4),
(24, '', 1, 0, 0, 1, 8),
(25, '', 0, 0, 1, 1, 1),
(26, '', 0, 0, 1, 1, 1),
(27, '', 0, 0, 1, 1, 1),
(28, '', 0, 0, 1, 1, 1),
(29, '', 0, 0, 1, 1, 1);

-- --------------------------------------------------------

--
-- Estrutura da tabela `formdest`
--

DROP TABLE IF EXISTS `formdest`;
CREATE TABLE IF NOT EXISTS `formdest` (
  `formdest_id` int(11) NOT NULL AUTO_INCREMENT,
  `formdest_status` tinyint(1) DEFAULT '0',
  `user_id` int(11) NOT NULL,
  `formgroup_id` int(11) NOT NULL,
  PRIMARY KEY (`formdest_id`),
  KEY `fk_formdest_user1_idx` (`user_id`),
  KEY `fk_formdest_form1_idx` (`formgroup_id`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 AUTO_INCREMENT=944 ;

--
-- Extraindo dados da tabela `formdest`
--

INSERT INTO `formdest` (`formdest_id`, `formdest_status`, `user_id`, `formgroup_id`) VALUES
(2, 1, 1, 3),
(36, 1, 2, 1),
(37, 1, 3, 1),
(39, 1, 4, 5),
(40, 1, 3, 5),
(44, 0, 3, 6),
(45, 0, 4, 6),
(46, 0, 2, 7),
(47, 0, 3, 7),
(88, 0, 2, 8),
(89, 0, 3, 8),
(858, 0, 1, 4),
(859, 0, 1, 4),
(860, 0, 1, 4),
(861, 0, 1, 4),
(862, 0, 1, 4),
(863, 0, 1, 4),
(864, 0, 1, 4),
(865, 0, 1, 4),
(866, 0, 1, 4),
(867, 0, 1, 4),
(868, 0, 1, 4),
(869, 0, 1, 4),
(870, 0, 1, 4),
(871, 0, 1, 4),
(872, 0, 1, 4),
(873, 0, 1, 4),
(874, 0, 1, 4),
(875, 0, 1, 4),
(876, 0, 1, 4),
(877, 0, 1, 4),
(878, 0, 1, 4),
(879, 0, 1, 4),
(880, 0, 1, 4),
(881, 0, 1, 4),
(882, 0, 1, 10),
(883, 0, 2, 10),
(884, 0, 3, 14),
(885, 0, 4, 14),
(892, 0, 2, 18),
(893, 0, 4, 18),
(894, 0, 2, 19),
(895, 0, 4, 19),
(896, 0, 2, 20),
(897, 0, 4, 20),
(898, 0, 1, 21),
(899, 0, 2, 21),
(900, 0, 3, 21),
(901, 0, 4, 21),
(902, 0, 1, 22),
(903, 0, 2, 22),
(904, 0, 3, 22),
(905, 0, 4, 22),
(915, 0, 2, 26),
(916, 0, 3, 26),
(917, 0, 4, 26),
(918, 0, 1, 27),
(919, 0, 3, 27),
(920, 0, 4, 27),
(921, 0, 1, 28),
(922, 0, 4, 28),
(936, 0, 2, 39),
(937, 0, 4, 39),
(940, 0, 8, 42),
(941, 0, 2, 43),
(942, 0, 4, 43),
(943, 0, 8, 44);

-- --------------------------------------------------------

--
-- Estrutura da tabela `formelement`
--

DROP TABLE IF EXISTS `formelement`;
CREATE TABLE IF NOT EXISTS `formelement` (
  `formelement_id` int(11) NOT NULL AUTO_INCREMENT,
  `type_element` int(11) DEFAULT NULL,
  `formgroup_id` int(11) NOT NULL,
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
  `label` varchar(255) DEFAULT NULL,
  `img` mediumtext,
  PRIMARY KEY (`formelement_id`),
  KEY `fk_formlist_form1_idx` (`formgroup_id`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 AUTO_INCREMENT=64 ;

--
-- Extraindo dados da tabela `formelement`
--

INSERT INTO `formelement` (`formelement_id`, `type_element`, `formgroup_id`, `pos_x`, `pos_y`, `default_value`, `required`, `width`, `height`, `placeholder`, `direction`, `isbiglist`, `max_value`, `min_value`, `label`, `img`) VALUES
(1, NULL, 1, 0, 0, NULL, 0, NULL, NULL, NULL, NULL, 0, NULL, NULL, NULL, NULL),
(2, NULL, 1, 0, 0, NULL, 0, NULL, NULL, NULL, NULL, 0, NULL, NULL, NULL, NULL),
(3, 1, 3, 15, 14, 'edfaulti', 1, 300, 15, 'place', 1, 0, NULL, NULL, NULL, NULL),
(4, 2, 3, 34, 455, NULL, 0, NULL, NULL, NULL, 0, 1, NULL, NULL, NULL, NULL),
(55, 1, 4, 25, 12, 'default', 1, 123, 23, 'placeholder', 0, 0, 100, 1, 'label', NULL),
(56, 2, 4, 234, 15, '', 0, 0, 0, '', 1, 1, 0, 0, '', NULL),
(57, 9, 43, 46, 30, '', 0, 35, 20, '', 0, 0, 0, 0, '', NULL),
(58, 12, 45, 215, 107, '', 0, 277, 182, '', 0, 0, 0, 0, '', NULL),
(60, 12, 48, 140, 281, '', 0, 267, 172, '', 0, 0, 0, 0, '', 'data:image/jpeg;base64,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'),
(62, 12, 50, 171, 119, '', 0, 308, 149, '', 0, 0, 0, 0, '', 'data:image/jpeg;base64,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'),
(63, 2, 51, 367, 366, '', 0, 174, 26, '', 0, 0, 10, 4, '', '');

-- --------------------------------------------------------

--
-- Estrutura da tabela `formgroup`
--

DROP TABLE IF EXISTS `formgroup`;
CREATE TABLE IF NOT EXISTS `formgroup` (
  `formgroup_id` int(11) NOT NULL AUTO_INCREMENT,
  `form_id` int(11) NOT NULL DEFAULT '0',
  PRIMARY KEY (`formgroup_id`),
  KEY `fk_form_formgroup` (`form_id`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=52 ;

--
-- Extraindo dados da tabela `formgroup`
--

INSERT INTO `formgroup` (`formgroup_id`, `form_id`) VALUES
(1, 1),
(3, 3),
(4, 4),
(5, 5),
(6, 6),
(7, 7),
(8, 8),
(9, 9),
(10, 10),
(11, 11),
(12, 12),
(13, 13),
(14, 15),
(18, 16),
(19, 16),
(20, 16),
(21, 17),
(22, 18),
(26, 19),
(27, 19),
(28, 19),
(39, 20),
(43, 21),
(41, 22),
(42, 23),
(44, 24),
(45, 25),
(46, 26),
(48, 27),
(50, 28),
(51, 29);

-- --------------------------------------------------------

--
-- Estrutura da tabela `user`
--

DROP TABLE IF EXISTS `user`;
CREATE TABLE IF NOT EXISTS `user` (
  `user_id` int(11) NOT NULL AUTO_INCREMENT,
  `user_name` varchar(255) DEFAULT NULL,
  PRIMARY KEY (`user_id`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 AUTO_INCREMENT=9 ;

--
-- Extraindo dados da tabela `user`
--

INSERT INTO `user` (`user_id`, `user_name`) VALUES
(0, 'Anonymous'),
(1, 'Luis'),
(2, 'Romain'),
(3, 'Genevieve'),
(4, 'Ayoub'),
(8, 'ba306717');

--
-- Constraints for dumped tables
--

--
-- Limitadores para a tabela `answervalue`
--
ALTER TABLE `answervalue`
  ADD CONSTRAINT `fk_answervalue_elementanswer` FOREIGN KEY (`elementanswer_id`) REFERENCES `elementanswer` (`elementanswer_id`) ON DELETE CASCADE;

--
-- Limitadores para a tabela `elementanswer`
--
ALTER TABLE `elementanswer`
  ADD CONSTRAINT `fk_elementanswer_formdest` FOREIGN KEY (`formdest_id`) REFERENCES `formdest` (`formdest_id`) ON DELETE CASCADE,
  ADD CONSTRAINT `fk_elementanswer_formelement` FOREIGN KEY (`formelement_id`) REFERENCES `formelement` (`formelement_id`) ON DELETE CASCADE;

--
-- Limitadores para a tabela `elementoption`
--
ALTER TABLE `elementoption`
  ADD CONSTRAINT `FK_elementoption_formelement` FOREIGN KEY (`formelement_id`) REFERENCES `formelement` (`formelement_id`) ON DELETE CASCADE;

--
-- Limitadores para a tabela `form`
--
ALTER TABLE `form`
  ADD CONSTRAINT `fk_form_user` FOREIGN KEY (`user_id`) REFERENCES `user` (`user_id`) ON DELETE CASCADE ON UPDATE NO ACTION;

--
-- Limitadores para a tabela `formdest`
--
ALTER TABLE `formdest`
  ADD CONSTRAINT `fk_formdest_form1` FOREIGN KEY (`formgroup_id`) REFERENCES `formgroup` (`formgroup_id`) ON DELETE CASCADE ON UPDATE NO ACTION,
  ADD CONSTRAINT `fk_formdest_user1` FOREIGN KEY (`user_id`) REFERENCES `user` (`user_id`) ON DELETE CASCADE ON UPDATE NO ACTION;

--
-- Limitadores para a tabela `formelement`
--
ALTER TABLE `formelement`
  ADD CONSTRAINT `fk_formgroup_formelement` FOREIGN KEY (`formgroup_id`) REFERENCES `formgroup` (`formgroup_id`) ON DELETE CASCADE;

--
-- Limitadores para a tabela `formgroup`
--
ALTER TABLE `formgroup`
  ADD CONSTRAINT `fk_form_formgroup` FOREIGN KEY (`form_id`) REFERENCES `form` (`form_id`) ON DELETE CASCADE ON UPDATE NO ACTION;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
