-- phpMyAdmin SQL Dump
-- version 4.8.3
-- https://www.phpmyadmin.net/
--
-- Servidor: 127.0.0.1
-- Tiempo de generación: 15-07-2019 a las 18:02:10
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
  `imagen` blob NOT NULL,
  `descripcion` text NOT NULL,
  `oculto` int(1) NOT NULL DEFAULT '0'
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
  `sub_precio_base` int(4) NOT NULL DEFAULT '0',
  `sub_finaliza` datetime NOT NULL,
  `hotsale` int(11) NOT NULL DEFAULT '0',
  `hotsale_precio` int(11) NOT NULL DEFAULT '0',
  `reservado` int(1) NOT NULL DEFAULT '0',
  `reservado_por` varchar(50) NOT NULL,
  `reservado_precio` int(4) NOT NULL DEFAULT '0'
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `subastas`
--

CREATE TABLE `subastas` (
  `id` int(4) NOT NULL,
  `residencia` int(4) NOT NULL DEFAULT '0',
  `semana` int(4) NOT NULL DEFAULT '0',
  `email` varchar(64) NOT NULL DEFAULT '',
  `oferta` varchar(64) NOT NULL DEFAULT ''
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `usuarios`
--

CREATE TABLE `usuarios` (
  `id` int(4) NOT NULL,
  `nombre` varchar(32) NOT NULL DEFAULT '',
  `apellido` varchar(32) NOT NULL DEFAULT '',
  `nacimiento` datetime NOT NULL DEFAULT '0000-00-00 00:00:00',
  `email` varchar(50) NOT NULL DEFAULT '',
  `clave` varchar(32) NOT NULL DEFAULT '',
  `cc_numero` varchar(16) NOT NULL,
  `cc_marca` varchar(32) NOT NULL,
  `cc_segur` varchar(3) NOT NULL,
  `cc_titular` varchar(50) NOT NULL DEFAULT '',
  `cc_vencimiento` datetime NOT NULL DEFAULT '0000-00-00 00:00:00',
  `rango` int(4) NOT NULL DEFAULT '0',
  `tokens` int(4) NOT NULL DEFAULT '2',
  `tokens_upd` datetime NOT NULL DEFAULT CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Volcado de datos para la tabla `usuarios`
--

INSERT INTO `usuarios` (`id`, `nombre`, `apellido`, `nacimiento`, `email`, `clave`, `cc_numero`, `cc_marca`, `cc_segur`, `cc_titular`, `cc_vencimiento`, `rango`, `tokens`, `tokens_upd`) VALUES
(157, 'Juan Andres', 'Geido', '1997-08-29 00:00:00', 'juangeido@hotmail.com', 'e10adc3949ba59abbe56e057f20f883e', '1234567891111111', 'Cabal', '111', 'Juan A Geido', '2020-12-28 00:00:00', 2, 0, '2020-06-16 00:00:00'),
(158, 'Mark', 'Ski', '1997-08-30 00:00:00', 'immarkski@pm.me', 'e10adc3949ba59abbe56e057f20f883e', '1234567891234567', 'Cabal', '123', 'Markski', '2020-08-28 00:00:00', 0, 2, '2020-07-14 00:00:00');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `variables`
--

CREATE TABLE `variables` (
  `id` int(4) NOT NULL,
  `nombre` varchar(32) NOT NULL DEFAULT '',
  `valor` int(4) NOT NULL DEFAULT '500'
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Volcado de datos para la tabla `variables`
--

INSERT INTO `variables` (`id`, `nombre`, `valor`) VALUES
(1, 'normal', 400),
(2, 'premium', 750);

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
-- Indices de la tabla `subastas`
--
ALTER TABLE `subastas`
  ADD PRIMARY KEY (`id`);

--
-- Indices de la tabla `usuarios`
--
ALTER TABLE `usuarios`
  ADD PRIMARY KEY (`id`);

--
-- Indices de la tabla `variables`
--
ALTER TABLE `variables`
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

--
-- AUTO_INCREMENT de la tabla `subastas`
--
ALTER TABLE `subastas`
  MODIFY `id` int(4) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT de la tabla `usuarios`
--
ALTER TABLE `usuarios`
  MODIFY `id` int(4) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=159;

--
-- AUTO_INCREMENT de la tabla `variables`
--
ALTER TABLE `variables`
  MODIFY `id` int(4) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
