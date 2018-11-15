-- phpMyAdmin SQL Dump
-- version 4.8.3
-- https://www.phpmyadmin.net/
--
-- Servidor: 127.0.0.1
-- Tiempo de generación: 15-11-2018 a las 14:48:33
-- Versión del servidor: 10.1.36-MariaDB
-- Versión de PHP: 7.2.11

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET AUTOCOMMIT = 0;
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Base de datos: `chatbot_db`
--

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `data_type`
--

CREATE TABLE `data_type` (
  `dat_type_id` int(11) NOT NULL,
  `dat_type_value` varchar(45) NOT NULL COMMENT 'valor del tipo de dato, digase "csv", "json", "png".',
  `dat_bool_input` tinyint(4) NOT NULL COMMENT 'Este campo es 1 si es input y 0 si es output. fue la mejor forma que se me ocurrio de tener multiples campos de entrada y salida, ignorando la posible existencia de una tabla de entrada y otra de salida.',
  `dat_task_id` int(11) NOT NULL COMMENT 'id de la tarea a la que pertenece el tipo de dato'
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `file`
--

CREATE TABLE `file` (
  `fil_id` int(11) NOT NULL,
  `fil_filename` varchar(45) NOT NULL COMMENT 'nombre del archivo guardado',
  `fil_url` varchar(45) NOT NULL COMMENT 'dirección relativa a la carpetar raiz del proyecto en le servidor',
  `fil_associated_project_id` int(11) NOT NULL COMMENT 'id del proyecto asociado',
  `fil_created_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `process`
--

CREATE TABLE `process` (
  `prc_id` int(11) NOT NULL,
  `prc_name` varchar(45) NOT NULL COMMENT 'nombre del proceso',
  `prc_owner` int(11) NOT NULL COMMENT 'id del usuario creador del proceso',
  `prc_input` int(11) NOT NULL COMMENT 'id del archivo de entrada para el proceso',
  `prc_created_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `process_node`
--

CREATE TABLE `process_node` (
  `pcn_id` int(11) NOT NULL,
  `pcn_parent` int(11) DEFAULT NULL COMMENT 'nodo padre en el proceso. Puede estar vacio si el nodo es el inicial.\\n',
  `pcn_task_id` int(11) NOT NULL COMMENT 'id de la tarea a realizar',
  `pcn_process_id` int(11) NOT NULL COMMENT 'id del proceso al que pertenece'
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `project`
--

CREATE TABLE `project` (
  `prj_id` int(11) NOT NULL,
  `prj_name` varchar(45) NOT NULL COMMENT 'nombre del proyecto',
  `prj_creator` int(11) NOT NULL COMMENT 'id del usuario creador del proyecto',
  `prj_description` varchar(200) DEFAULT NULL,
  `prj_created_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP COMMENT 'fecha en que el proyecto fue creado'
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `project_member`
--

CREATE TABLE `project_member` (
  `prm_id` int(11) NOT NULL,
  `prm_project_id` int(11) NOT NULL COMMENT 'id del proyecto. Foranea',
  `prm_user_id` int(11) NOT NULL COMMENT 'id del usuario. Foranea'
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COMMENT='	';

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `project_task`
--

CREATE TABLE `project_task` (
  `pri_task_id` int(11) NOT NULL,
  `pri_project_id` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `site_user`
--

CREATE TABLE `site_user` (
  `usr_id` int(11) NOT NULL,
  `usr_name` varchar(45) NOT NULL COMMENT 'nombre del usuario',
  `usr_username` varchar(45) NOT NULL COMMENT 'Supongo que el nombre de usuario tambien es unico, cierto?',
  `usr_pass` varchar(45) NOT NULL COMMENT 'Campo password. Asumo que la clave es procesada antes con sal',
  `usr_mail` varchar(45) NOT NULL COMMENT 'Correo. Unico.',
  `usr_created_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP COMMENT 'Fecha de ingreso del usuario. es una fecha.'
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `task_instance`
--

CREATE TABLE `task_instance` (
  `ins_id` int(11) NOT NULL,
  `ins_name` varchar(45) NOT NULL,
  `ins_created_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `ins_type_id` int(11) NOT NULL COMMENT 'id del tipo de tarea de la instancia',
  `ins_owner` int(11) NOT NULL COMMENT 'id del creador de la tarea'
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `task_instance_parameter`
--

CREATE TABLE `task_instance_parameter` (
  `inp_instance_id` int(11) NOT NULL,
  `inp_parameter_type_id` int(11) NOT NULL,
  `inp_parameter_value` varchar(45) NOT NULL COMMENT 'valor que tomara el parametro para cierta instancia'
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `task_type`
--

CREATE TABLE `task_type` (
  `tst_id` int(11) NOT NULL,
  `tst_name` varchar(45) NOT NULL,
  `tst_description` varchar(45) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `task_type_parameter`
--

CREATE TABLE `task_type_parameter` (
  `itp_id` int(11) NOT NULL,
  `itp_name` varchar(45) NOT NULL,
  `itp_var_type` varchar(45) NOT NULL COMMENT 'tipo de variable, "char", "int", "array"',
  `itp_required` tinyint(4) NOT NULL,
  `itp_type_id` int(11) NOT NULL COMMENT 'id del tipo de tarea'
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Índices para tablas volcadas
--

--
-- Indices de la tabla `data_type`
--
ALTER TABLE `data_type`
  ADD PRIMARY KEY (`dat_type_id`),
  ADD KEY `data_task_id` (`dat_task_id`);

--
-- Indices de la tabla `file`
--
ALTER TABLE `file`
  ADD PRIMARY KEY (`fil_id`),
  ADD KEY `file_associated_project_id` (`fil_associated_project_id`);

--
-- Indices de la tabla `process`
--
ALTER TABLE `process`
  ADD PRIMARY KEY (`prc_id`),
  ADD KEY `process_owner` (`prc_owner`),
  ADD KEY `process_input_id` (`prc_input`);

--
-- Indices de la tabla `process_node`
--
ALTER TABLE `process_node`
  ADD PRIMARY KEY (`pcn_id`),
  ADD KEY `node_parent` (`pcn_parent`),
  ADD KEY `node_process_id` (`pcn_process_id`),
  ADD KEY `node_task_instance_id` (`pcn_task_id`);

--
-- Indices de la tabla `project`
--
ALTER TABLE `project`
  ADD PRIMARY KEY (`prj_id`),
  ADD KEY `prj_creator` (`prj_creator`);

--
-- Indices de la tabla `project_member`
--
ALTER TABLE `project_member`
  ADD PRIMARY KEY (`prm_id`),
  ADD KEY `pru_project_id` (`prm_project_id`),
  ADD KEY `pru_user_id` (`prm_user_id`);

--
-- Indices de la tabla `project_task`
--
ALTER TABLE `project_task`
  ADD PRIMARY KEY (`pri_task_id`,`pri_project_id`),
  ADD KEY `pri_project_id` (`pri_project_id`);

--
-- Indices de la tabla `site_user`
--
ALTER TABLE `site_user`
  ADD PRIMARY KEY (`usr_id`);

--
-- Indices de la tabla `task_instance`
--
ALTER TABLE `task_instance`
  ADD PRIMARY KEY (`ins_id`),
  ADD KEY `ins_creator_id` (`ins_owner`),
  ADD KEY `ins_type_id` (`ins_type_id`);

--
-- Indices de la tabla `task_instance_parameter`
--
ALTER TABLE `task_instance_parameter`
  ADD PRIMARY KEY (`inp_instance_id`,`inp_parameter_type_id`),
  ADD KEY `inp_parameter_type_id` (`inp_parameter_type_id`);

--
-- Indices de la tabla `task_type`
--
ALTER TABLE `task_type`
  ADD PRIMARY KEY (`tst_id`);

--
-- Indices de la tabla `task_type_parameter`
--
ALTER TABLE `task_type_parameter`
  ADD PRIMARY KEY (`itp_id`),
  ADD KEY `itp_type_id` (`itp_type_id`);

--
-- AUTO_INCREMENT de las tablas volcadas
--

--
-- AUTO_INCREMENT de la tabla `project`
--
ALTER TABLE `project`
  MODIFY `prj_id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT de la tabla `site_user`
--
ALTER TABLE `site_user`
  MODIFY `usr_id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT de la tabla `task_instance`
--
ALTER TABLE `task_instance`
  MODIFY `ins_id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT de la tabla `task_type`
--
ALTER TABLE `task_type`
  MODIFY `tst_id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT de la tabla `task_type_parameter`
--
ALTER TABLE `task_type_parameter`
  MODIFY `itp_id` int(11) NOT NULL AUTO_INCREMENT;

--
-- Restricciones para tablas volcadas
--

--
-- Filtros para la tabla `data_type`
--
ALTER TABLE `data_type`
  ADD CONSTRAINT `data_task_id` FOREIGN KEY (`dat_task_id`) REFERENCES `task_type` (`tst_id`) ON DELETE NO ACTION ON UPDATE NO ACTION;

--
-- Filtros para la tabla `file`
--
ALTER TABLE `file`
  ADD CONSTRAINT `file_associated_project_id` FOREIGN KEY (`fil_associated_project_id`) REFERENCES `project` (`prj_id`) ON DELETE NO ACTION ON UPDATE NO ACTION;

--
-- Filtros para la tabla `process`
--
ALTER TABLE `process`
  ADD CONSTRAINT `process_input_id` FOREIGN KEY (`prc_input`) REFERENCES `file` (`fil_id`) ON DELETE NO ACTION ON UPDATE NO ACTION,
  ADD CONSTRAINT `process_owner` FOREIGN KEY (`prc_owner`) REFERENCES `site_user` (`usr_id`) ON DELETE NO ACTION ON UPDATE NO ACTION;

--
-- Filtros para la tabla `process_node`
--
ALTER TABLE `process_node`
  ADD CONSTRAINT `node_parent` FOREIGN KEY (`pcn_parent`) REFERENCES `process_node` (`pcn_id`) ON DELETE NO ACTION ON UPDATE NO ACTION,
  ADD CONSTRAINT `node_process_id` FOREIGN KEY (`pcn_process_id`) REFERENCES `process` (`prc_id`) ON DELETE NO ACTION ON UPDATE NO ACTION,
  ADD CONSTRAINT `node_task_instance_id` FOREIGN KEY (`pcn_task_id`) REFERENCES `task_instance` (`ins_id`) ON DELETE NO ACTION ON UPDATE NO ACTION;

--
-- Filtros para la tabla `project`
--
ALTER TABLE `project`
  ADD CONSTRAINT `prj_creator` FOREIGN KEY (`prj_creator`) REFERENCES `site_user` (`usr_id`) ON DELETE NO ACTION ON UPDATE NO ACTION;

--
-- Filtros para la tabla `project_member`
--
ALTER TABLE `project_member`
  ADD CONSTRAINT `pru_project_id` FOREIGN KEY (`prm_project_id`) REFERENCES `project` (`prj_id`) ON DELETE NO ACTION ON UPDATE NO ACTION,
  ADD CONSTRAINT `pru_user_id` FOREIGN KEY (`prm_user_id`) REFERENCES `site_user` (`usr_id`) ON DELETE NO ACTION ON UPDATE NO ACTION;

--
-- Filtros para la tabla `project_task`
--
ALTER TABLE `project_task`
  ADD CONSTRAINT `pri_instance_id` FOREIGN KEY (`pri_task_id`) REFERENCES `task_instance` (`ins_id`) ON DELETE NO ACTION ON UPDATE NO ACTION,
  ADD CONSTRAINT `pri_project_id` FOREIGN KEY (`pri_project_id`) REFERENCES `project` (`prj_id`) ON DELETE NO ACTION ON UPDATE NO ACTION;

--
-- Filtros para la tabla `task_instance`
--
ALTER TABLE `task_instance`
  ADD CONSTRAINT `ins_creator_id` FOREIGN KEY (`ins_owner`) REFERENCES `site_user` (`usr_id`) ON DELETE NO ACTION ON UPDATE NO ACTION,
  ADD CONSTRAINT `ins_type_id` FOREIGN KEY (`ins_type_id`) REFERENCES `task_type` (`tst_id`) ON DELETE NO ACTION ON UPDATE NO ACTION;

--
-- Filtros para la tabla `task_instance_parameter`
--
ALTER TABLE `task_instance_parameter`
  ADD CONSTRAINT `inp_instance_id` FOREIGN KEY (`inp_instance_id`) REFERENCES `task_instance` (`ins_id`) ON DELETE NO ACTION ON UPDATE NO ACTION,
  ADD CONSTRAINT `inp_parameter_type_id` FOREIGN KEY (`inp_parameter_type_id`) REFERENCES `task_type_parameter` (`itp_id`) ON DELETE NO ACTION ON UPDATE NO ACTION;

--
-- Filtros para la tabla `task_type_parameter`
--
ALTER TABLE `task_type_parameter`
  ADD CONSTRAINT `itp_type_id` FOREIGN KEY (`itp_type_id`) REFERENCES `task_type` (`tst_id`) ON DELETE NO ACTION ON UPDATE NO ACTION;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
