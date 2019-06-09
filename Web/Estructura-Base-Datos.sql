SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET AUTOCOMMIT = 0;
START TRANSACTION;
SET time_zone = "+00:00";

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
COMMIT;

--
-- AUTO_INCREMENT de la tabla `usuarios`
--
ALTER TABLE `usuarios`
  MODIFY `id` int(4) NOT NULL AUTO_INCREMENT;
COMMIT;