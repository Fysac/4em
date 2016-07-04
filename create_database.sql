SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
CREATE DATABASE IF NOT EXISTS `4em` DEFAULT CHARACTER SET latin1 COLLATE latin1_swedish_ci;
USE `4em`;

CREATE TABLE IF NOT EXISTS `replies` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `thread` int(11) NOT NULL,
  `title` varchar(255) DEFAULT NULL,
  `body` mediumtext NOT NULL,
  `author` varchar(255) NOT NULL,
  `timestamp` varchar(255) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM  DEFAULT CHARSET=latin1 AUTO_INCREMENT=158 ;

CREATE TABLE IF NOT EXISTS `threads` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `title` varchar(255) NOT NULL,
  `body` mediumtext NOT NULL,
  `author` varchar(255) NOT NULL,
  `replies` int(11) NOT NULL,
  `views` int(11) NOT NULL,
  `timestamp` varchar(255) NOT NULL,
  `last_author` varchar(255) NOT NULL DEFAULT 'author',
  `last_timestamp` varchar(255) NOT NULL DEFAULT 'posted',
  PRIMARY KEY (`id`)
) ENGINE=MyISAM  DEFAULT CHARSET=latin1 AUTO_INCREMENT=84 ;

CREATE TABLE IF NOT EXISTS `users` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `username` varchar(30) NOT NULL,
  `hash` varchar(255) NOT NULL,
  `joined` varchar(255) NOT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `username` (`username`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=415 ;
