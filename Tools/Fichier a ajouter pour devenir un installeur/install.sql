-- phpMyAdmin SQL Dump
-- version 3.3.9.2
-- http://www.phpmyadmin.net
--
-- Serveur: 127.0.0.1
-- Généré le : Sam 14 Janvier 2012 à 14:21
-- Version du serveur: 5.5.10
-- Version de PHP: 5.3.6

SET SQL_MODE="NO_AUTO_VALUE_ON_ZERO";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8 */;

--
-- Base de données: `happycms`
--

-- --------------------------------------------------------

--
-- Structure de la table `categories`
--

CREATE TABLE IF NOT EXISTS `#prefix#categories` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `extension` varchar(50) NOT NULL,
  `lft` int(11) NOT NULL,
  `rght` int(11) NOT NULL,
  `parent_id` int(11) DEFAULT NULL,
  `item_id` int(11) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM  DEFAULT CHARSET=latin1 AUTO_INCREMENT=104 ;

--
-- Contenu de la table `categories`
--


-- --------------------------------------------------------

--
-- Structure de la table `categories_contents`
--

CREATE TABLE IF NOT EXISTS `#prefix#categories_contents` (
  `category_id` int(11) NOT NULL,
  `content_id` int(11) NOT NULL
) ENGINE=MyISAM DEFAULT CHARSET=latin1;

--
-- Contenu de la table `categories_contents`
--


-- --------------------------------------------------------

--
-- Structure de la table `contents`
--

CREATE TABLE IF NOT EXISTS `#prefix#contents` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `extension` varchar(255) NOT NULL,
  `item_id` int(11) NOT NULL,
  `language_id` int(11) NOT NULL,
  `created` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `published` tinyint(1) NOT NULL DEFAULT '1',
  `params` mediumtext CHARACTER SET utf8 NOT NULL,
  `custom_field_1` varchar(255) CHARACTER SET utf8 NOT NULL,
  `custom_field_2` varchar(255) CHARACTER SET utf8 NOT NULL,
  PRIMARY KEY (`id`),
  FULLTEXT KEY `params` (`params`)
) ENGINE=MyISAM  DEFAULT CHARSET=latin1 AUTO_INCREMENT=618 ;

--
-- Contenu de la table `contents`
--

INSERT INTO `#prefix#contents` (`id`, `extension`, `item_id`, `language_id`, `created`, `published`, `params`, `custom_field_1`, `custom_field_2`) VALUES
(418, 'extensions', 1, 1, '0000-00-00 00:00:00', 1, '{"default_menu_id":"56"}', '', ''),
(415, 'menus', 2, 1, '0000-00-00 00:00:00', 1, '{"title":"Menu racine","alias":"Menu-racine","published":"1","class":"","thumb":"imgAcc.jpg"}', '', ''),
(419, 'extensions', 3, 1, '0000-00-00 00:00:00', 1, '{}', '', ''),
(420, 'extensions', 2, 1, '0000-00-00 00:00:00', 1, '{}', '', ''),
(442, 'extensions', 4, 1, '0000-00-00 00:00:00', 1, '{}', '', ''),
(443, 'extensions', 5, 1, '0000-00-00 00:00:00', 1, '{}', '', ''),
(444, 'extensions', 6, 1, '0000-00-00 00:00:00', 1, '{}', '', ''),
(445, 'extensions', 7, 1, '0000-00-00 00:00:00', 1, '{"online":"1","offline-message":"test","title":"Happy Cms","description":"","meta-tag":"","default_menu_id":"33","contactEmail":"contact@linksite.fr"}', '', ''),
(505, 'menus', 35, 1, '2011-12-17 17:28:42', 1, '{"title":"Contact","alias":"Contact","published":"1","class":""}', '', ''),
(499, 'menus', 33, 1, '2011-12-17 17:25:13', 1, '{"title":"Page d''accueil","alias":"Page-d-accueil","published":"1","class":""}', '', ''),
(489, 'extensions', 10, 1, '0000-00-00 00:00:00', 1, '{}', '', ''),
(607, 'menus', 139, 1, '0000-00-00 00:00:00', 1, '{"title":"Page d''accueil","alias":"accueil","published":"1","class":""}', '', ''),
(608, 'pages', 46, 1, '2012-01-05 14:32:07', 1, '{"text":""}', '', ''),
(469, 'extensions', 8, 1, '0000-00-00 00:00:00', 1, '{}', '', ''),
(610, 'extensions', 12, 1, '2012-01-13 18:07:00', 1, '{}', '', ''),
(475, 'extensions', 9, 1, '0000-00-00 00:00:00', 1, '{}', '', ''),
(481, 'contact', 1, 1, '0000-00-00 00:00:00', 1, '{"text":"<p>Twitter, Inc.<br \\/> 795 Folsom Ave, Suite 600<br \\/> San Francisco, CA 94107<br \\/>P: (123) 456-7890.<\\/p>","googlemaps":"45.783806|3.1681820000000016|8","googlemapsOptions":""}', '', ''),
(527, 'menus', 47, 1, '2011-12-22 17:21:05', 1, '{"title":"Actus","alias":"Actus","published":"1","class":""}', '', ''),
(492, 'extensions', 11, 1, '0000-00-00 00:00:00', 1, '{}', '', ''),
(493, 'posts', 1, 1, '0000-00-00 00:00:00', 1, '{"title":"Titre de l\\u2019actualit\\u00e9 num\\u00e9ro 1","img":"4f1063ff46431_74239.jpg","text":"<div id=\\"actu1\\">\\r\\n<p>Lorem ipsum dolor sit amet, consectetur adipiscing elit. Quisque sed metus id metus varius cursus vel vitae sapien. Pellentesque porta vehicula nisi nec vehicula. Nulla fringilla dictum nequeinia consequat nec vitae massa.!:!<\\/p>\\r\\n<\\/div>"}', '', ''),
(494, 'posts', 2, 1, '0000-00-00 00:00:00', 1, '{"title":"Titre de l\\u2019actualit\\u00e9 num\\u00e9ro 2","img":"4f1063fb5716e_74235.jpg","text":"<div id=\\"actu1\\">\\r\\n<p>Lorem ipsum dolor sit amet, consectetur adipiscing elit. Quisque sed metus id metus varius cursus vel vitae sapien. Pellentesque porta vehicula nisi nec vehicula. Nulla fringilla dictum nequeinia consequat nec vitae massa.<\\/p>\\r\\n<\\/div>"}', '', ''),
(501, 'pages', 13, 1, '2011-12-17 17:25:30', 1, '{"text":"<p>Lorem ipsum dolor sit amet, consectetur adipiscing elit. Integer gravida convallis neque vestibulum volutpat. In egestas sodales erat, sed dapibus nisl rhoncus ut. Nam sit amet nisl ultrices arcu mattis aliquam mollis et felis. Pellentesque sit amet suscipit orci. Vivamus ultricies urna eget sapien placerat a convallis sem pellentesque. Nam ut urna lectus, ac venenatis odio. Mauris fringilla enim vitae lacus tincidunt faucibus tincidunt ante accumsan. Aliquam molestie augue quis lorem blandit pretium. Aenean vitae commodo eros. Cras bibendum posuere neque, ut interdum augue laoreet sed. Curabitur eros lorem, consectetur vel rutrum nec, ultrices sed tellus. Nunc fermentum sapien sit amet augue consequat molestie. Aliquam sed odio vel mi condimentum mollis in in dolor. Sed ornare pulvinar lorem quis sollicitudin. Aenean tortor mi, placerat eu fringilla sed, aliquet laoreet diam. <br \\/><br \\/> In eu leo turpis, id bibendum massa. Nam non imperdiet ante. Nulla molestie condimentum libero vel interdum. Vestibulum euismod luctus justo vel vehicula. Sed tincidunt vulputate odio, vitae placerat massa pellentesque at. Curabitur varius tincidunt lectus non consectetur. Etiam tempus ante in lorem ornare lobortis. Praesent egestas pellentesque leo vitae elementum. Curabitur non tellus est, luctus mollis leo. Nam accumsan aliquet magna, ut pulvinar sapien elementum a. Sed vitae facilisis odio. Nullam tincidunt, mauris sed congue porttitor, metus sem elementum nisl, nec porta libero urna id nulla. Mauris auctor faucibus purus adipiscing blandit. Aliquam at lorem eget est adipiscing viverra nec ac eros.<\\/p>"}', '', '');

-- --------------------------------------------------------

--
-- Structure de la table `extensions`
--

CREATE TABLE IF NOT EXISTS `#prefix#extensions` (
  `name` varchar(255) NOT NULL,
  `controller` varchar(255) NOT NULL,
  `item_id` int(11) NOT NULL,
  `current_id` int(11) NOT NULL DEFAULT '1',
  `category_id` int(11) NOT NULL,
  PRIMARY KEY (`controller`)
) ENGINE=MyISAM DEFAULT CHARSET=latin1;

--
-- Contenu de la table `extensions`
--

INSERT INTO `#prefix#extensions` (`name`, `controller`, `item_id`, `current_id`, `category_id`) VALUES
('Menu racine', 'menus', 1, 3, 0),
('Page simple', 'pages', 2, 5, 0),
('Formulaire de contact', 'contact', 3, 4, 0),
('Lien vers une autre page', 'links', 5, 1, 0),
('Page d''accueil', 'home', 12, 2, 0),
('gestion des extensions', 'extensions', 6, 1, 0),
('Configuration du site', 'configurations', 7, 1, 0),
('Sous Menus', 'submenus', 9, 1, 0),
('Actualités', 'posts', 11, 4, 0);

-- --------------------------------------------------------

--
-- Structure de la table `groups`
--

CREATE TABLE IF NOT EXISTS `#prefix#groups` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `name` varchar(60) NOT NULL,
  `rules` varchar(255) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=5 ;

--
-- Contenu de la table `groups`
--

INSERT INTO `#prefix#groups` (`id`, `name`, `rules`) VALUES
(1, 'LinkSite Administrateur', '*:*'),
(2, 'Administrateur', '*:*,!contents:users_*,!users:admin_save,!files:admin_*,files:admin_upload_form'),
(3, 'Simple utilisateur', '*:*,!*:admin_*,Offline|!*:*'),
(4, 'Utilisateur enregistré', '*:*:*,!*:admin_*,Offline|!*:*');

-- --------------------------------------------------------

--
-- Structure de la table `languages`
--

CREATE TABLE IF NOT EXISTS `#prefix#languages` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `name` varchar(50) CHARACTER SET utf8 NOT NULL,
  `code` varchar(6) CHARACTER SET utf8 NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=2 ;

--
-- Contenu de la table `languages`
--

INSERT INTO `#prefix#languages` (`id`, `name`, `code`) VALUES
(1, 'Français', 'fre');

-- --------------------------------------------------------

--
-- Structure de la table `media`
--

CREATE TABLE IF NOT EXISTS `#prefix#media` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `context_extension` varchar(60) NOT NULL,
  `context_id` int(8) NOT NULL,
  `name` varchar(255) NOT NULL,
  `ext` varchar(5) NOT NULL,
  `url` varchar(255) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1 AUTO_INCREMENT=1 ;

--
-- Contenu de la table `media`
--


-- --------------------------------------------------------

--
-- Structure de la table `menus`
--

CREATE TABLE IF NOT EXISTS `#prefix#menus` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `parent_id` int(11) DEFAULT NULL,
  `lft` int(11) NOT NULL,
  `rght` int(11) NOT NULL,
  `extension` varchar(255) NOT NULL,
  `view` varchar(255) NOT NULL,
  `params` text NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM  DEFAULT CHARSET=latin1 AUTO_INCREMENT=145 ;

--
-- Contenu de la table `menus`
--

INSERT INTO `#prefix#menus` (`id`, `parent_id`, `lft`, `rght`, `extension`, `view`, `params`) VALUES
(1, NULL, 1, 12, '', '', ''),
(2, 1, 2, 11, 'menus', 'top_menu', ''),
(35, 2, 7, 8, 'contact', 'index', ''),
(33, 2, 3, 4, 'pages', 'display', '13'),
(47, 2, 5, 6, 'posts', 'index', ''),
(139, 2, 9, 10, 'pages', 'display', '46');

-- --------------------------------------------------------

--
-- Structure de la table `users`
--

CREATE TABLE IF NOT EXISTS `#prefix#users` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `username` varchar(255) NOT NULL,
  `password` varchar(255) NOT NULL,
  `rules` varchar(255) NOT NULL,
  `group_id` int(11) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM  DEFAULT CHARSET=latin1 AUTO_INCREMENT=4 ;

--
-- Contenu de la table `users`
--

INSERT INTO `#prefix#users` (`id`, `username`, `password`, `rules`, `group_id`) VALUES
(2, 'admin', '2b36c3eae875942d63340663e373d6711babf5a9', '', 2),
(1, 'linksite', 'a5cda2d8751551b5b65766985b3716f74f4fb511', '', 1),
(3, 'default', '', '', 3);
