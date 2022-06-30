DROP TABLE `juridica_laboral`;

CREATE TABLE `juridica_laboral` (
  `id` int(11) NOT NULL,
  `n_demandante` varchar(50) NOT NULL,
  `rut` text NOT NULL,
  `rol` varchar(20) NOT NULL,
  `fecha_not` date NOT NULL,
  `fecha_res` date DEFAULT NULL,
  `fecha_prep` date DEFAULT NULL,
  `fecha_juicio` date DEFAULT NULL,
  `tipo` varchar(2) DEFAULT NULL,
  `tribunal` int(11) DEFAULT NULL,
  `id_asignado` int(11) DEFAULT NULL,
  `archivo` varchar(60) DEFAULT NULL,
  `etapa` int(11) DEFAULT NULL,
  `resolucion` tinyint(1) DEFAULT NULL,
  `nombre_asignado` varchar(100) DEFAULT NULL,
  `apellido_asignado` varchar(100) DEFAULT NULL,
  `observacion` text DEFAULT NULL,
  `obs_asignado` text DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Volcado de datos para la tabla `juridica_laboral`
--

INSERT INTO `juridica_laboral` (`id`, `n_demandante`, `rut`, `rol`, `fecha_not`, `fecha_res`, `fecha_prep`, `fecha_juicio`, `tipo`, `tribunal`, `id_asignado`, `archivo`, `etapa`, `resolucion`, `nombre_asignado`, `apellido_asignado`, `observacion`, `obs_asignado`) VALUES
(2, 'Nombre Cambiado 2', '18.849.828-0', 'M-7484-8494', '2022-01-29', '2022-10-29', NULL, NULL, 'M', 1, 94, NULL, 0, 0, 'usuario', '3', NULL, NULL),
(52, 'Ignacio Perez', '1827398-9', 'M-9272-9383', '2022-02-08', '2022-02-24', NULL, NULL, 'M', 3, 96, 'demanda.pdf', 2, NULL, 'Abogado', '1', NULL, NULL),
(53, 'Ignacio Perez', '1827398-9', 'M-9272-9383', '2022-02-08', '2022-02-24', NULL, NULL, 'M', 3, 96, 'demanda.pdf', 2, NULL, 'Abogado', '1', NULL, NULL),
(69, 'SEÑOR PRUEBA', '1231234-0', 'O-1832-73783', '2022-02-23', NULL, NULL, '0000-00-00', 'O', 0, 96, 'demanda.pdf', 0, 2, 'Abogado', '1', NULL, NULL),
(70, 'SEÑOR PRUEBA', '1231234-0', 'O-1832-73783', '2022-02-23', NULL, NULL, '2022-03-16', 'O', 3, 96, 'demanda.pdf', 0, 2, 'Abogado', '1', NULL, NULL),
(71, 'SEÑOR PRUEBA', '1-1', 'O-1832-73783', '2022-02-22', NULL, '2022-03-02', '2022-03-10', 'O', 2, 96, 'demanda.pdf', 0, 0, 'Abogado', '1', NULL, NULL),
(72, 'SEÑOR PRUEBA', '1-1', 'M-73289-8737492', '2022-02-22', '2022-03-11', NULL, NULL, 'M', 5, 96, 'demanda.pdf', 0, 1, 'Abogado', '1', NULL, NULL),
(73, 'SEÑOR PRUEBA', '1-1', 'M-73289-8737492', '2022-02-23', '2022-03-11', NULL, NULL, 'M', 3, 94, 'demanda.pdf', 0, 1, 'usuario', '3', NULL, NULL),
(75, 'SEÑOR PRUEBA', '1231234-0', 'O-1832-73783', '2022-03-04', NULL, '2022-03-02', '2022-03-10', 'O', 3, 96, 'demanda.pdf', 0, 2, 'Abogado', '1', NULL, NULL),
(76, 'SEÑOR PRUEBA', '1-1', 'M-927392-9383', '2022-02-23', '2022-03-11', NULL, NULL, 'M', 1, 93, 'demanda.pdf', 0, 1, 'Usuario', '2', NULL, NULL),
(77, 'Juanito Jones', '1231234-0', 'O-1832-73783', '2022-02-23', NULL, '2022-03-10', '2022-04-08', 'O', 1, 96, 'demanda.pdf', 0, 2, 'Abogado', '1', NULL, NULL),
(78, 'Pepito ', '1-1', 'M-927392-9383', '2022-02-23', NULL, '2022-03-11', NULL, 'M', 1, 96, 'demanda.pdf', 0, 0, 'Abogado', '1', NULL, NULL),
(79, 'Juanito Jones', '1-1', 'O-1832-73783', '2022-02-28', NULL, '2022-03-03', NULL, 'O', 1, 93, 'demanda.pdf', 0, 2, 'Usuario', '2', NULL, 'Se pasa a usuario 2'),
(80, 'SEÑOR PRUEBA', '1231234-0', 'O-1832-73783', '2022-02-25', NULL, NULL, '2022-03-12', 'O', 1, 96, 'demanda.pdf', 5, NULL, 'Abogado', '1', 'Se requieren varios testigos para esto hehe', NULL);

ALTER TABLE `juridica_laboral`
  ADD PRIMARY KEY (`id`);

ALTER TABLE `juridica_laboral`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=81;
COMMIT;
