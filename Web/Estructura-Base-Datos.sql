-- phpMyAdmin SQL Dump
-- version 4.8.3
-- https://www.phpmyadmin.net/
--
-- Servidor: 127.0.0.1
-- Tiempo de generación: 12-05-2019 a las 18:59:25
-- Versión del servidor: 10.1.36-MariaDB
-- Versión de PHP: 7.2.10

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET AUTOCOMMIT = 0;
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Base de datos: `hsh`
--

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `residencias`
--

CREATE TABLE `residencias` (
  `id` int(4) NOT NULL,
  `nombre` varchar(128) NOT NULL DEFAULT '',
  `calle` varchar(64) NOT NULL,
  `localizacion` varchar(64) NOT NULL DEFAULT '',
  `numero` int(2) NOT NULL DEFAULT '0',
  `pisoydepto` varchar(32) NOT NULL DEFAULT 'NA',
  `precio` int(4) NOT NULL DEFAULT '0',
  `imagen` blob NOT NULL,
  `descripcion` text NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `semanas`
--

CREATE TABLE `semanas` (
  `id` int(4) NOT NULL,
  `residencia` int(4) NOT NULL,
  `fecha` datetime NOT NULL DEFAULT '0000-00-00 00:00:00',
  `subasta` tinyint(1) NOT NULL DEFAULT '0',
  `sub_precio_base` int(4) NOT NULL DEFAULT '0'
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Índices para tablas volcadas
--

--
-- Indices de la tabla `residencias`
--
ALTER TABLE `residencias`
  ADD PRIMARY KEY (`id`);

--
-- Indices de la tabla `semanas`
--
ALTER TABLE `semanas`
  ADD PRIMARY KEY (`id`);

--
-- AUTO_INCREMENT de las tablas volcadas
--

--
-- AUTO_INCREMENT de la tabla `residencias`
--
ALTER TABLE `residencias`
  MODIFY `id` int(4) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT de la tabla `semanas`
--
ALTER TABLE `semanas`
  MODIFY `id` int(4) NOT NULL AUTO_INCREMENT;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
