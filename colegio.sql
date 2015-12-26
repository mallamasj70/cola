-- phpMyAdmin SQL Dump
-- version 4.0.4.1
-- http://www.phpmyadmin.net
--
-- Servidor: 127.0.0.1
-- Tiempo de generación: 02-10-2013 a las 13:42:03
-- Versión del servidor: 5.5.32
-- Versión de PHP: 5.4.19

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET time_zone = "+00:00";

/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8 */;

USE colegio;

--
-- Base de datos: `colegio`
--
CREATE DATABASE IF NOT EXISTS `colegio` DEFAULT CHARACTER SET latin1 COLLATE latin1_spanish_ci;
USE `colegio`;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `alumno`
--

CREATE TABLE IF NOT EXISTS `alumno` (
  `codigo` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `nombre` varchar(250) COLLATE latin1_spanish_ci NOT NULL,
  `codGrupo` int(10) NOT NULL,
  `orden` int(11) DEFAULT NULL COMMENT 'almacena el timestamp que viene de php',
  `puesto` char(17) COLLATE latin1_spanish_ci DEFAULT NULL,
  PRIMARY KEY (`codigo`),
  KEY `orden` (`codGrupo`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 COLLATE=latin1_spanish_ci AUTO_INCREMENT=115 ;

--
-- Volcado de datos para la tabla `alumno`
--

INSERT INTO `alumno` (`codigo`, `nombre`, `codGrupo`, `orden`, `puesto`) VALUES
(101, 'Francisco Javier', 1, NULL, NULL),
(102, 'Jose Manuel', 1, NULL, NULL),
(103, 'Gabriel', 1, NULL, NULL),
(104, 'Rubén', 1, NULL, NULL),
(105, 'Alejandro', 1, NULL, NULL),
(106, 'Mario', 1, NULL, NULL),
(107, 'Manolo', 1, NULL, NULL),
(108, 'Angel', 1, NULL, NULL),
(109, 'Antonio', 1, NULL, NULL),
(110, 'Jairo', 1, NULL, NULL),
(111, 'Juan Jesus', 1, NULL, NULL),
(112, 'Salvador', 1, NULL, NULL),
(114, 'Cristian', 1, NULL, NULL);

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `configuracion`
--

CREATE TABLE IF NOT EXISTS `configuracion` (
  `Grupo` int(10) DEFAULT NULL COMMENT 'Es donde se almacena el grupo que se usa actualmente.',
  `password` varchar(100) COLLATE latin1_spanish_ci NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1 COLLATE=latin1_spanish_ci COMMENT='Para configuraciones varias.';

--
-- Volcado de datos para la tabla `configuracion`
--

INSERT INTO `configuracion` (`Grupo`, `password`) VALUES
(1, 'pandora');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `grupo`
--

CREATE TABLE IF NOT EXISTS `grupo` (
  `codigo` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `nombre` varchar(200) COLLATE latin1_spanish_ci NOT NULL,
  PRIMARY KEY (`codigo`),
  UNIQUE KEY `nombre` (`nombre`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 COLLATE=latin1_spanish_ci AUTO_INCREMENT=2 ;

--
-- Volcado de datos para la tabla `grupo`
--

INSERT INTO `grupo` (`codigo`, `nombre`) VALUES
(1, '2SMR');

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
