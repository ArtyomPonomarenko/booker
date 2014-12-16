-- phpMyAdmin SQL Dump
-- version 3.5.5
-- http://www.phpmyadmin.net
--
-- Хост: sql5.freemysqlhosting.net
-- Время создания: Дек 11 2014 г., 12:03
-- Версия сервера: 5.5.40-0ubuntu0.14.04.1
-- Версия PHP: 5.3.28

SET SQL_MODE="NO_AUTO_VALUE_ON_ZERO";
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8 */;

--
-- База данных: `sql561018`
--

-- --------------------------------------------------------

--
-- Структура таблицы `EMPLOYEES`
--

CREATE TABLE IF NOT EXISTS `EMPLOYEES` (
  `Id` int(11) NOT NULL AUTO_INCREMENT,
  `Email` varchar(255) NOT NULL,
  `Name` varchar(255) NOT NULL,
  PRIMARY KEY (`Id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 AUTO_INCREMENT=1 ;

-- --------------------------------------------------------

--
-- Структура таблицы `EVENTDATA`
--

CREATE TABLE IF NOT EXISTS `EVENTDATA` (
  `Id` int(11) NOT NULL AUTO_INCREMENT,
  `Description` text NOT NULL,
  `EmployeeId` int(11) NOT NULL,
  `RoomId` int(11) NOT NULL,
  `RegDate` datetime NOT NULL,
  PRIMARY KEY (`Id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 AUTO_INCREMENT=1 ;

-- --------------------------------------------------------

--
-- Структура таблицы `EVENTS`
--

CREATE TABLE IF NOT EXISTS `EVENTS` (
  `Id` int(11) NOT NULL AUTO_INCREMENT,
  `Start` datetime NOT NULL,
  `End` datetime NOT NULL,
  `DataId` int(11) NOT NULL,
  PRIMARY KEY (`Id`),
  KEY `Start` (`Start`,`End`,`DataId`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 AUTO_INCREMENT=1 ;

-- --------------------------------------------------------

--
-- Структура таблицы `ROOMS`
--

CREATE TABLE IF NOT EXISTS `ROOMS` (
  `Id` int(11) NOT NULL AUTO_INCREMENT,
  `Name` varchar(255) NOT NULL,
  PRIMARY KEY (`Id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 AUTO_INCREMENT=1 ;

-- --------------------------------------------------------

--
-- Структура таблицы `USERS`
--

CREATE TABLE IF NOT EXISTS `USERS` (
  `Email` varchar(255) NOT NULL,
  `Password` varchar(255) NOT NULL,
  `LastLogin` datetime NOT NULL,
  `Name` varchar(255) NOT NULL,
  `Clearance` int(11) NOT NULL,
  UNIQUE KEY `Email` (`Email`),
  KEY `Password` (`Password`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
