-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Servidor: 127.0.0.1
-- Tiempo de generación: 10-12-2023 a las 02:26:28
-- Versión del servidor: 10.4.28-MariaDB-log
-- Versión de PHP: 8.2.4

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Base de datos: `mydb`
--

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `admin`
--

CREATE TABLE `admin` (
  `Id` int(11) NOT NULL,
  `Nombre` varchar(100) NOT NULL,
  `Apellido` varchar(100) NOT NULL,
  `Cargo` varchar(45) NOT NULL,
  `Usuario` varchar(45) NOT NULL,
  `Password` varchar(45) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_general_ci;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `alumnos`
--

CREATE TABLE `alumnos` (
  `Matricula` int(11) NOT NULL,
  `Nombre` varchar(100) NOT NULL,
  `Apellido` varchar(100) NOT NULL,
  `Sexo` char(1) NOT NULL,
  `Telefono` int(11) NOT NULL,
  `Correo` varchar(100) NOT NULL,
  `Semestre` int(11) NOT NULL,
  `Grupo` varchar(45) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_general_ci;

--
-- Volcado de datos para la tabla `alumnos`
--

INSERT INTO `alumnos` (`Matricula`, `Nombre`, `Apellido`, `Sexo`, `Telefono`, `Correo`, `Semestre`, `Grupo`) VALUES
(1003, 'Student3', 'Lastname3', 'M', 555111222, 'student3@example.com', 3, 'C'),
(1006, 'Adrian', 'Ramirez', 'M', 555333444, 'adrian.ramirez@example.com', 3, 'A'),
(1008, 'Alex', 'Molina', 'M', 555777888, 'alex.molina@example.com', 2, 'A'),
(1009, 'Sophia', 'Cruz', 'F', 555999000, 'sophia.cruz@example.com', 3, 'B'),
(1011, 'Olivia', 'Torres', 'F', 555111222, 'olivia.torres@example.com', 2, 'C'),
(1012, 'Sebastian', 'Gomez', 'M', 555222333, 'sebastian.gomez@example.com', 3, 'A'),
(1014, 'Daniel', 'Perez', 'M', 555444555, 'daniel.perez@example.com', 2, 'B'),
(100002, 'Karla Ivon', 'Matrtinez', 'M', 2147483647, 'ssded@gmail.com', 7, 'C'),
(123344, 'ww', 'www', 'H', 23343, 'de@gmailihxode', 1, 'w'),
(142277, 'Karla Ivon', 'Matrtinez', 'H', 2147483647, 'ssded@gmail.com', 3, 'A'),
(369654, 'Diego', 'Matrtinez', 'H', 2147483647, 'ssded@gmail.com', 5, 'C'),
(478596, 'Saul', 'Matrtinez', 'H', 2147483647, 'ssded@gmail.com', 7, 'B');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `cursar`
--

CREATE TABLE `cursar` (
  `Id_Cursar` int(11) NOT NULL,
  `Matricula_Alumno` int(11) NOT NULL,
  `Clave_Materia` varchar(45) NOT NULL,
  `Calificacion` decimal(3,1) DEFAULT NULL,
  `Ciclo_Escolar` varchar(45) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_general_ci;

--
-- Volcado de datos para la tabla `cursar`
--

INSERT INTO `cursar` (`Id_Cursar`, `Matricula_Alumno`, `Clave_Materia`, `Calificacion`, `Ciclo_Escolar`) VALUES
(1, 100002, 'Mate1', NULL, ''),
(8, 1003, 'DS1401', 9.4, '2023-01'),
(9, 1003, 'EE201', 8.7, '2023-01'),
(10, 1003, 'EE801', 9.2, '2023-01'),
(16, 1006, 'SE1301', 9.3, '2023-01'),
(17, 1006, 'DS1401', 9.0, '2023-01'),
(20, 1008, 'EE801', 8.8, '2023-01'),
(21, 1008, 'Mate1', 8.9, '2023-01'),
(22, 1009, 'IE901', 9.1, '2023-01'),
(23, 1009, 'DS1401', 8.7, '2023-01'),
(26, 1011, 'SE1301', 9.0, '2023-01'),
(27, 1011, 'DS1401', 8.8, '2023-01'),
(28, 1012, 'EE801', 8.7, '2023-01'),
(29, 1012, 'Mate1', 9.4, '2023-01'),
(32, 1014, 'SE1301', 9.1, '2023-01'),
(33, 1014, 'DS1401', 9.5, '2023-01'),
(34, 100002, 'CE501', 8.6, '2023-01'),
(35, 100002, 'CHE1101', 9.5, '2023-01'),
(36, 142277, 'DS1401', 9.0, '2023-01'),
(37, 142277, 'EE201', 8.5, '2023-01'),
(38, 369654, 'MSE1001', 8.9, '2023-01'),
(39, 369654, 'PE1201', 9.4, '2023-01'),
(40, 478596, 'SE1301', 9.3, '2023-01'),
(41, 478596, 'DS1401', 9.2, '2023-01');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `formacion`
--

CREATE TABLE `formacion` (
  `Clave` int(11) NOT NULL,
  `Nombre` varchar(100) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_general_ci;

--
-- Volcado de datos para la tabla `formacion`
--

INSERT INTO `formacion` (`Clave`, `Nombre`) VALUES
(1, 'Computer Science'),
(2, 'Electrical Engineering'),
(3, 'Mechanical Engineering'),
(4, 'Chemical Engineering'),
(5, 'Civil Engineering'),
(6, 'Aerospace Engineering'),
(7, 'Biomedical Engineering'),
(8, 'Environmental Engineering'),
(9, 'Industrial Engineering'),
(10, 'Materials Science and Engineering'),
(11, 'Chemical Engineering'),
(12, 'Petroleum Engineering'),
(13, 'Software Engineering'),
(14, 'Data Science'),
(111, 'DOCTORADO EN CQB'),
(222, 'LICENCIATURA EN QFB'),
(333, 'MAESTRÍA EN CQB');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `laboratorios`
--

CREATE TABLE `laboratorios` (
  `IdLaboratorios` int(11) NOT NULL,
  `NomLaboratorio` varchar(45) NOT NULL,
  `JefeNumEmp` bigint(20) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_general_ci;

--
-- Volcado de datos para la tabla `laboratorios`
--

INSERT INTO `laboratorios` (`IdLaboratorios`, `NomLaboratorio`, `JefeNumEmp`) VALUES
(1, 'Lab 1', 1),
(2, 'Lab 2', 2),
(3, 'Lab 3', 3),
(4, 'Lab 4', 4),
(5, 'Lab 5', 5),
(6, 'Lab 6', 6),
(7, 'Lab 7', 7),
(8, 'Lab 8', 8),
(9, 'Lab 9', 9),
(10, 'Lab 10', 10),
(11, 'Lab 11', 11),
(12, 'Lab 12', 12),
(13, 'Lab 13', 13),
(14, 'Lab 14', 14),
(41, 'Computacion', 981);

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `materias`
--

CREATE TABLE `materias` (
  `Clave` varchar(45) NOT NULL,
  `Nombre` varchar(100) NOT NULL,
  `Semestre` int(11) NOT NULL,
  `IdLaboratorio` int(11) NOT NULL,
  `ClaveFormacion` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_general_ci;

--
-- Volcado de datos para la tabla `materias`
--

INSERT INTO `materias` (`Clave`, `Nombre`, `Semestre`, `IdLaboratorio`, `ClaveFormacion`) VALUES
('AE601', 'Spacecraft Design', 3, 1, 3),
('BE701', 'Biomechanics', 1, 2, 1),
('CE401', 'Organic Chemistry', 1, 4, 1),
('CE501', 'Structural Engineering', 2, 5, 2),
('CHE1101', 'Process Dynamics and Control', 2, 1, 2),
('CS101', 'Introduction to Programming', 1, 1, 1),
('DS1401', 'Machine Learning', 2, 4, 2),
('EE201', 'Circuit Analysis', 2, 2, 2),
('EE801', 'Environmental Sustainability', 2, 3, 2),
('IE901', 'Operations Research', 3, 4, 3),
('Mate1', 'mate', 7, 41, 222),
('ME301', 'Thermodynamics', 3, 3, 3),
('MSE1001', 'Advanced Materials', 1, 5, 1),
('PE1201', 'Petroleum Reservoir Engineering', 3, 2, 3),
('SE1301', 'Software Architecture', 1, 3, 1);

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `profesores`
--

CREATE TABLE `profesores` (
  `Num_Emp` bigint(20) NOT NULL,
  `Nombre` varchar(100) NOT NULL,
  `Apellidos` varchar(100) NOT NULL,
  `Correo` varchar(100) NOT NULL,
  `Telefono` bigint(11) NOT NULL,
  `Password` varchar(100) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_general_ci;

--
-- Volcado de datos para la tabla `profesores`
--

INSERT INTO `profesores` (`Num_Emp`, `Nombre`, `Apellidos`, `Correo`, `Telefono`, `Password`) VALUES
(1, 'John', 'Doe', 'john.doe@example.com', 123456789, 'password1'),
(2, 'Jane', 'Smith', 'jane.smith@example.com', 987654321, 'password2'),
(3, 'Maria', 'Gonzalez', 'maria.gonzalez@example.com', 555123456, 'password3'),
(4, 'Carlos', 'Martinez', 'carlos.martinez@example.com', 555987654, 'password4'),
(5, 'Laura', 'Lopez', 'laura.lopez@example.com', 555555555, 'password5'),
(6, 'Alejandro', 'Hernandez', 'alejandro.hernandez@example.com', 555666666, 'password6'),
(7, 'Sofia', 'Perez', 'sofia.perez@example.com', 555777777, 'password7'),
(8, 'Gabriel', 'Torres', 'gabriel.torres@example.com', 555888888, 'password8'),
(9, 'Isabella', 'Garcia', 'isabella.garcia@example.com', 555999999, 'password9'),
(10, 'Daniel', 'Diaz', 'daniel.diaz@example.com', 555000000, 'password10'),
(11, 'Valentina', 'Moreno', 'valentina.moreno@example.com', 555123789, 'password11'),
(12, 'Mateo', 'Gutierrez', 'mateo.gutierrez@example.com', 555456789, 'password12'),
(13, 'Emma', 'Castro', 'emma.castro@example.com', 555789123, 'password13'),
(14, 'David', 'Ortega', 'david.ortega@example.com', 555987654, 'password14'),
(981, 'Isaias', 'mtz', 'sñlmcjsi@gmail.com', 9512168044, '12345');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `prof_lab`
--

CREATE TABLE `prof_lab` (
  `Id` int(11) NOT NULL,
  `Num_Emp` bigint(20) NOT NULL,
  `IdLaboratorio` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_general_ci;

--
-- Volcado de datos para la tabla `prof_lab`
--

INSERT INTO `prof_lab` (`Id`, `Num_Emp`, `IdLaboratorio`) VALUES
(1, 1, 1),
(2, 2, 2),
(3, 3, 3),
(4, 4, 4),
(5, 5, 5),
(6, 6, 6),
(7, 7, 7),
(8, 8, 8),
(9, 9, 9),
(10, 10, 10),
(11, 11, 11),
(12, 12, 12),
(13, 13, 13),
(14, 14, 14),
(15, 1, 1),
(16, 2, 2),
(17, 3, 3),
(18, 4, 4),
(19, 5, 5),
(20, 6, 6),
(21, 7, 7),
(22, 8, 8),
(23, 9, 9),
(24, 10, 10),
(25, 11, 11),
(26, 12, 12),
(27, 13, 13),
(28, 14, 14);

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `secretarias`
--

CREATE TABLE `secretarias` (
  `NumEmp` bigint(20) NOT NULL,
  `Nombre` varchar(100) NOT NULL,
  `Apellido` varchar(100) NOT NULL,
  `Password` varchar(45) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_general_ci;

--
-- Volcado de datos para la tabla `secretarias`
--

INSERT INTO `secretarias` (`NumEmp`, `Nombre`, `Apellido`, `Password`) VALUES
(4444, 'Alejandra', 'Luis Martinez', '12345');

--
-- Índices para tablas volcadas
--

--
-- Indices de la tabla `admin`
--
ALTER TABLE `admin`
  ADD PRIMARY KEY (`Id`);

--
-- Indices de la tabla `alumnos`
--
ALTER TABLE `alumnos`
  ADD PRIMARY KEY (`Matricula`);

--
-- Indices de la tabla `cursar`
--
ALTER TABLE `cursar`
  ADD PRIMARY KEY (`Id_Cursar`),
  ADD KEY `Matricula_Alumno` (`Matricula_Alumno`),
  ADD KEY `Clave_Materia` (`Clave_Materia`);

--
-- Indices de la tabla `formacion`
--
ALTER TABLE `formacion`
  ADD PRIMARY KEY (`Clave`);

--
-- Indices de la tabla `laboratorios`
--
ALTER TABLE `laboratorios`
  ADD PRIMARY KEY (`IdLaboratorios`);

--
-- Indices de la tabla `materias`
--
ALTER TABLE `materias`
  ADD PRIMARY KEY (`Clave`),
  ADD KEY `IdLaboratorio` (`IdLaboratorio`),
  ADD KEY `ClaveFormacion` (`ClaveFormacion`);

--
-- Indices de la tabla `profesores`
--
ALTER TABLE `profesores`
  ADD PRIMARY KEY (`Num_Emp`);

--
-- Indices de la tabla `prof_lab`
--
ALTER TABLE `prof_lab`
  ADD PRIMARY KEY (`Id`),
  ADD KEY `Num_Emp` (`Num_Emp`),
  ADD KEY `IdLaboratorio` (`IdLaboratorio`);

--
-- Indices de la tabla `secretarias`
--
ALTER TABLE `secretarias`
  ADD PRIMARY KEY (`NumEmp`);

--
-- AUTO_INCREMENT de las tablas volcadas
--

--
-- AUTO_INCREMENT de la tabla `cursar`
--
ALTER TABLE `cursar`
  MODIFY `Id_Cursar` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=42;

--
-- AUTO_INCREMENT de la tabla `prof_lab`
--
ALTER TABLE `prof_lab`
  MODIFY `Id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=29;

--
-- Restricciones para tablas volcadas
--

--
-- Filtros para la tabla `cursar`
--
ALTER TABLE `cursar`
  ADD CONSTRAINT `cursar_ibfk_1` FOREIGN KEY (`Matricula_Alumno`) REFERENCES `alumnos` (`Matricula`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `cursar_ibfk_2` FOREIGN KEY (`Clave_Materia`) REFERENCES `materias` (`Clave`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Filtros para la tabla `materias`
--
ALTER TABLE `materias`
  ADD CONSTRAINT `materias_ibfk_1` FOREIGN KEY (`IdLaboratorio`) REFERENCES `laboratorios` (`IdLaboratorios`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `materias_ibfk_2` FOREIGN KEY (`ClaveFormacion`) REFERENCES `formacion` (`Clave`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Filtros para la tabla `prof_lab`
--
ALTER TABLE `prof_lab`
  ADD CONSTRAINT `prof_lab_ibfk_1` FOREIGN KEY (`Num_Emp`) REFERENCES `profesores` (`Num_Emp`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `prof_lab_ibfk_2` FOREIGN KEY (`IdLaboratorio`) REFERENCES `laboratorios` (`IdLaboratorios`) ON DELETE CASCADE ON UPDATE CASCADE;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
