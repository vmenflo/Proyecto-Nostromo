-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Servidor: 127.0.0.1
-- Tiempo de generación: 03-06-2025 a las 19:19:00
-- Versión del servidor: 10.4.32-MariaDB
-- Versión de PHP: 8.2.12

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Base de datos: `bd_nostromo`
--

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `articulos`
--

CREATE TABLE `articulos` (
  `id_articulo` int(11) NOT NULL,
  `titulo` varchar(100) NOT NULL,
  `resumen` varchar(200) NOT NULL,
  `descripcion` text NOT NULL,
  `foto` varchar(100) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Volcado de datos para la tabla `articulos`
--

INSERT INTO `articulos` (`id_articulo`, `titulo`, `resumen`, `descripcion`, `foto`) VALUES
(1, '\"Bird\": Desvelando al misterioso hombre del tejado', 'Barry Keoghan (\"Saltburn\") protagoniza la nueva película de Andrea Arnold (\"Fish Tank\"), una de las obras europeas imprescindibles de la temporada, que llega a los cines el 21 de marzo', 'La película un nuevo retrato de esos personajes que viven en los márgenes de la sociedad tan propios de Arnold, está protagonizada por Bailey (la debutante Nykiya Adams), una joven de 12 años que vive en una casa ocupada junto a su imprudente y despreocupado padre Bug (Barry Keoghan) y su hermano Hunter (Jason Buda), adicto a los vídeos de Youtube. Bailey es una figura solitaria, hasta que conoce al misterioso Bird (Franz Rogowski), un hombre que parece ser el héroe que está buscando. \"Bird\" ha sido una de las grandes películas europeas de la temporada: nominada en las categorías de Mejor Dirección y Mejor Actor en los Premios del Cine Europeo, y en la de Mejor Película Británica en los Bafta, tuvo su estreno mundial en el Festival de Cannes y llegó a los cines españoles el pasado noviembre de la mano de Avalon.||\r\n\r\nEl peculiar proceso creativo de Arnold llevó a la directora a construir todo el guion a partir, no de un tema o una historia concreta, sino de una imagen: \"Todo empezó hace mucho tiempo, cuando me vino a la mente la imagen de un hombre muy alto y delgado con un pene muy largo sobre un tejado. desde entonces me estuve preguntando si era un alien, quién podía ser, si bueno, si malo, de qué se trataba\", contó la directora en Cannes: \"Bird es el resultado de esa imagen y de un largo viaje intentando averiguar qué significaba\". Arnold añade que nunca pensó en escribir un coming-of-age sobre una niña de 12 años: \"Ni siquiera soy consciente de que estoy trabajando en un género. Simplemente hurgo en esa imagen inicial y veo qué surge de ahí\", prosigue: \"Nunca sigo ninguna regla de estructura o la sabiduría recibida de la escritura de guiones. Fui a la escuela de cine, pero nunca lo dirías\".||\r\n\r\nLa película, rodada como \"Fish Tank\" (2009) en la región de Kent, donde nació Arnold, es sin duda la obra de la directora que más se acerca al realismo mágico de películas como \"Bestias del sur salvaje\", y en la que la fantasía juega un papel más importante: \"Esa especie de cualidad mágica empezó a surgir en el guión y no me detuve. Me permití esa imaginación. Hasta ahora, he trabajado con reglas bastante estrictas en mi trabajo cinematográfico, reglas que me impuse yo mismo. Y en esta película, pensé que tal vez podría romper las reglas. Quiero decir, son mis reglas. ¡Puedo romperlas! Pero simplemente sucedió de manera natural. Me di permiso y lo acepté\", explica la directora.||\r\n\r\nLa película cuenta con canciones de The Verve, Coldplay y Blur, con la presencia de dos de los actores europeos del momento (Barry Keoghan y un Franz Rogowski galardonado en los British Independent Film Awards por su papel en el film) y con una banda sonora original a cargo del músico electrónico londinense Burial. Pero el nombre que roba la función es el de la joven Nykiya Adams. \"Es curioso, cuando estás haciendo un casting, porque algunas personas simplemente despiertan algo en ti cuando las ves. Nikiya era una chica muy diferente al personaje que yo había escrito, pero esa primera sensación que tuve, y que no puedo explicar con palabras, es la que me llevó a elegirla\", concluye Arnold.\r\n', 'bird'),
(2, '“La sustancia\": Tú, pero mejor en todos los sentidos', 'La película, dirigida por Coralie Fargeat (\"Revenge\") y nominada a cinco Óscar, ha sido uno de los fenómenos de taquilla de la temporada en España', '\"La sustancia\", uno de los mayores fenómenos cinematográficos de los últimos años. Dirigida por la francesa Coralie Fargeat (\"Revenge\") y protagonizada por Demi Moore y Margaret Qualley (hija de Andie MacDowell), la película se basa en un guion original escrito por la propia Fargeat alrededor de Elisabeth Sparkle, una estrella de la televisión en horas bajas que ve su estatus en peligro cuando el director de su cadena decide retirarla de su programa de aerobic. Sparkle acepta entonces una misteriosa propuesta y decide someterse a un tratamiento que promete generar una nueva versión de ella misma, pero más joven, más bella y más perfecta. Como ocurre siempre con la magia en los cuentos de hadas, \"la sustancia\" tiene unas reglas claras que deben respetarse, pero Sue, el alter ego rejuvenecido de Elisabeth, no parece estar por la labor de ser obediente.||\r\n\r\n\"La sustancia\" tuvo su premiere mundial en el Festival de Cannes, donde se llevó el premio al Mejor Guion. Ganadora del Globo de Oro a la Mejor Actriz en Comedia y Musical, galardón que recibió Demi Moore hace unos días, ayer conocimos que la película ha recibido cinco nominaciones a los Óscar: Mejor Película, Mejor Dirección, Mejor Actriz (Demi Moore), Mejor Guion Original y Mejor Maquillaje y Peluquería.||\r\n\r\nCuenta Coralie Fargeat que su primera experiencia en el mundo del cine fue en el rodaje de \"Pasión por vivir\" (Alain Berliner, 2000), una película protagonizada, curiosamente, por Demi Moore. Como meritoria de dirección, Fargeat le servía el café a la actriz por las mañanas, hacía fotocopias y observaba con atención todo lo que ocurría a su alrededor. \"Pude ver cómo era la vida de la película detrás de la escena, la realidad sobre cómo se hace una película\", recuerda. En sus inicios, la directora, fascinada por obras como \"Robocop\", \"La mosca\" o \"Mad Max\", descubrió que este no era el tipo de cine que se hacía en Francia, y encontró serias dificultades para poner en marcha sus primeros proyectos. Con un presupuesto muy ajustado, pudo estrenar \"Revenge\" en 2017 y su éxito en el circuito de festivales de género le abrió de par en par las puertas de la industria del cine.||\r\n\r\nLa semilla de “La sustancia” surgió cuando Fargeat se acercaba a los 50 años. “Tuve una enorme ola de pensamientos como: Mi vida se va a terminar. Ya no voy a ser interesante. Nadie me va a mirar más. Mi vida se acabó. Tenía estos pensamientos enormes y violentos y eran tan poderosos que me dije que había llegado el momento de hacer algo con ellos\". El subgénero del \"body horror\", en el que el cuerpo humano es sometido a violentos cambios y transformaciones, y que tiene en David Cronenberg a uno de sus mayores exponentes, le ofrecía las herramientas adecuadas para hablar de este tipo de violencia que se ejerce sobre los cuerpos de las mujeres. \"No podía encontrar una mejor manera de mostrar la violencia que podemos infligirnos a nosotras mismas\", afirma la directora.||\r\n\r\nMoore no recordaba a aquella chiquilla que le servía cafés en el rodaje de \"Pasión por vivir\", pero aceptó protagonizar la segunda película de Fargeat a pesar de que la propia directora tenía muy pocas esperanzas de que la otrora estrella de Hollywood se interesara por un proyecto de estas características. \"Leí su autobiografía y descubrí que ella había pasado por algunos años difíciles en su vida personal. Ahora estaba en una fase en la que había decidido dar un paso atrás para recuperar el control de sí misma. Eso es lo que la hizo sentirse cómoda mostrando vulnerabilidad en la pantalla, porque creo que se sentía fuerte por dentro y estaba en una buena posición consigo misma\", explica Fargeat. Gracias a este papel, la protagonista de éxitos como \"Ghost\" (1990) o \"La teniente O\'Neil\" (1997) ha ganado su primer Globo de Oro y ha obtenido su primera nominación al Óscar.\r\n', 'sustancia');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `asientos`
--

CREATE TABLE `asientos` (
  `id_asiento` int(11) NOT NULL,
  `id_sala` int(11) NOT NULL,
  `fila` int(11) NOT NULL,
  `butaca` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Volcado de datos para la tabla `asientos`
--

INSERT INTO `asientos` (`id_asiento`, `id_sala`, `fila`, `butaca`) VALUES
(1, 1, 1, 1),
(2, 1, 1, 2),
(3, 1, 1, 3),
(4, 1, 1, 4),
(5, 1, 1, 5),
(6, 1, 1, 6),
(7, 1, 1, 7),
(8, 1, 1, 8),
(9, 1, 1, 9),
(10, 1, 1, 10),
(11, 1, 1, 11),
(12, 1, 1, 12),
(13, 1, 1, 13),
(14, 1, 1, 14),
(15, 1, 1, 15),
(16, 1, 1, 16),
(17, 1, 1, 17),
(18, 1, 1, 18),
(19, 1, 2, 1),
(20, 1, 2, 2),
(21, 1, 2, 3),
(22, 1, 2, 4),
(23, 1, 2, 5),
(24, 1, 2, 6),
(25, 1, 2, 7),
(26, 1, 2, 8),
(27, 1, 2, 9),
(28, 1, 2, 10),
(29, 1, 2, 11),
(30, 1, 2, 12),
(31, 1, 2, 13),
(32, 1, 2, 14),
(33, 1, 2, 15),
(34, 1, 2, 16),
(35, 1, 2, 17),
(36, 1, 2, 18),
(37, 1, 3, 1),
(38, 1, 3, 2),
(39, 1, 3, 3),
(40, 1, 3, 4),
(41, 1, 3, 5),
(42, 1, 3, 6),
(43, 1, 3, 7),
(44, 1, 3, 8),
(45, 1, 3, 9),
(46, 1, 3, 10),
(47, 1, 3, 11),
(48, 1, 3, 12),
(49, 1, 3, 13),
(50, 1, 3, 14),
(51, 1, 3, 15),
(52, 1, 3, 16),
(53, 1, 3, 17),
(54, 1, 3, 18),
(55, 1, 4, 1),
(56, 1, 4, 2),
(57, 1, 4, 3),
(58, 1, 4, 4),
(59, 1, 4, 5),
(60, 1, 4, 6),
(61, 1, 4, 7),
(62, 1, 4, 8),
(63, 1, 4, 9),
(64, 1, 4, 10),
(65, 1, 4, 11),
(66, 1, 4, 12),
(67, 1, 4, 13),
(68, 1, 4, 14),
(69, 1, 4, 15),
(70, 1, 4, 16),
(71, 1, 4, 17),
(72, 1, 4, 18),
(73, 1, 5, 1),
(74, 1, 5, 2),
(75, 1, 5, 3),
(76, 1, 5, 4),
(77, 1, 5, 5),
(78, 1, 5, 6),
(79, 1, 5, 7),
(80, 1, 5, 8),
(81, 1, 5, 9),
(82, 1, 5, 10),
(83, 1, 5, 11),
(84, 1, 5, 12),
(85, 1, 5, 13),
(86, 1, 5, 14),
(87, 1, 5, 15),
(88, 1, 5, 16),
(89, 1, 5, 17),
(90, 1, 5, 18),
(91, 1, 6, 1),
(92, 1, 6, 2),
(93, 1, 6, 3),
(94, 1, 6, 4),
(95, 1, 6, 5),
(96, 1, 6, 6),
(97, 1, 6, 7),
(98, 1, 6, 8),
(99, 1, 6, 9),
(100, 1, 6, 10),
(101, 1, 6, 11),
(102, 1, 6, 12),
(103, 1, 6, 13),
(104, 1, 6, 14),
(105, 1, 6, 15),
(106, 1, 6, 16),
(107, 1, 6, 17),
(108, 1, 6, 18),
(109, 1, 7, 1),
(110, 1, 7, 2),
(111, 1, 7, 3),
(112, 1, 7, 4),
(113, 1, 7, 5),
(114, 1, 7, 6),
(115, 1, 7, 7),
(116, 1, 7, 8),
(117, 1, 7, 9),
(118, 1, 7, 10),
(119, 1, 7, 11),
(120, 1, 7, 12),
(121, 1, 7, 13),
(122, 1, 7, 14),
(123, 1, 7, 15),
(124, 1, 7, 16),
(125, 1, 7, 17),
(126, 1, 7, 18),
(127, 1, 8, 1),
(128, 1, 8, 2),
(129, 1, 8, 3),
(130, 1, 8, 4),
(131, 1, 8, 5),
(132, 1, 8, 6),
(133, 1, 8, 7),
(134, 1, 8, 8),
(135, 1, 8, 9),
(136, 1, 8, 10),
(137, 1, 8, 11),
(138, 1, 8, 12),
(139, 1, 8, 13),
(140, 1, 8, 14),
(141, 1, 8, 15),
(142, 1, 8, 16),
(143, 1, 8, 17),
(144, 1, 8, 18),
(145, 1, 9, 1),
(146, 1, 9, 2),
(147, 1, 9, 3),
(148, 1, 9, 4),
(149, 1, 9, 5),
(150, 1, 9, 6),
(151, 1, 9, 7),
(152, 1, 9, 8),
(153, 1, 9, 9),
(154, 1, 9, 10),
(155, 1, 9, 11),
(156, 1, 9, 12),
(157, 1, 9, 13),
(158, 1, 9, 14),
(159, 1, 9, 15),
(160, 1, 9, 16),
(161, 1, 9, 17),
(162, 1, 9, 18),
(163, 1, 10, 1),
(164, 1, 10, 2),
(165, 1, 10, 3),
(166, 1, 10, 4),
(167, 1, 10, 5),
(168, 1, 10, 6),
(169, 1, 10, 7),
(170, 1, 10, 8),
(171, 1, 10, 9),
(172, 1, 10, 10),
(173, 1, 10, 11),
(174, 1, 10, 12),
(175, 1, 10, 13),
(176, 1, 10, 14),
(177, 1, 10, 15),
(178, 1, 10, 16),
(179, 1, 10, 17),
(180, 1, 10, 18);

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `cines`
--

CREATE TABLE `cines` (
  `id_cine` int(11) NOT NULL,
  `nombre` varchar(30) NOT NULL,
  `direccion` varchar(50) NOT NULL,
  `ciudad` varchar(30) NOT NULL,
  `cp` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Volcado de datos para la tabla `cines`
--

INSERT INTO `cines` (`id_cine`, `nombre`, `direccion`, `ciudad`, `cp`) VALUES
(1, 'Cine Albeniz', 'C/ Alcazabilla, 4', 'Málaga', 29015),
(2, 'Cinesur', 'C/ Jaén, 1', 'Málaga', 29004),
(7, 'prueba', 'ds', 'df', 29680);

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `peliculas`
--

CREATE TABLE `peliculas` (
  `id_pelicula` int(11) NOT NULL,
  `titulo` varchar(30) NOT NULL,
  `sinopsis` text NOT NULL,
  `duracion` int(11) NOT NULL,
  `director` varchar(30) NOT NULL,
  `reparto` varchar(150) NOT NULL,
  `disponibilidad` enum('cartelera','proximamente','no_disponible') NOT NULL,
  `fecha_estreno` date NOT NULL,
  `fecha_final` date NOT NULL,
  `cant_asistencia` int(11) NOT NULL,
  `foto` varchar(150) NOT NULL,
  `genero` varchar(50) NOT NULL,
  `url_trailer` varchar(200) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Volcado de datos para la tabla `peliculas`
--

INSERT INTO `peliculas` (`id_pelicula`, `titulo`, `sinopsis`, `duracion`, `director`, `reparto`, `disponibilidad`, `fecha_estreno`, `fecha_final`, `cant_asistencia`, `foto`, `genero`, `url_trailer`) VALUES
(1, 'Alien: el octavo pasajero', 'De regreso a la Tierra, la nave de carga Nostromo interrumpe su viaje y despierta a sus siete tripulantes. El ordenador central, MADRE, ha detectado la misteriosa transmisión de una forma de vida desconocida, procedente de un planeta cercano aparentemente deshabitado. La nave se dirige entonces al extraño planeta para investigar el origen de la comunicación.', 190, 'Ridley Scott', 'Sigourney Weaver, Tom Skerritt, Veronica Cartwright', 'cartelera', '2025-05-29', '2025-06-30', 3, 'alien', 'Horror', 'https://www.youtube.com/embed/Eu9ZFTXXEiw?si=-fBZ9j_3zaKsY8s-'),
(2, 'El bueno, el feo y el malo', 'Los protagonistas son tres cazadores de recompensas que buscan un tesoro que ninguno de ellos puede encontrar sin la ayuda de los otros dos. Así que los tres colaboran entre sí, al menos en apariencia.', 190, 'Sergio Leone', 'Clint Eastwood, Linda Hamilton, Michael Biehn', 'cartelera', '2025-05-29', '2025-06-30', 8, 'bueno-feo-malo', 'Western', ''),
(3, 'Fire of love', 'Katia y Maurice Krafft amaban dos cosas: el uno al otro y los volcanes. Durante dos décadas han recorrido el planeta, persiguiendo las erupciones y sus consecuencias, documentando sus descubrimiento', 190, 'Sara Dosa', 'Sara Dosa, Jocelyne Chaput, Shane Boris, Erin Casper', 'proximamente', '2025-06-27', '2025-08-15', 0, 'fire', 'Documental', ''),
(4, 'Mad max: Furia en la carretera', 'Tras la guerra termonuclear que ha convertido a la Tierra en un páramo, el antiguo policía Max Rockatansky, atormentado por los espíritus de aquellos a los que no pudo proteger, se ha convertido en un hombre con un solo instinto: sobrevivir. ', 130, 'George Miller', 'Tom Hardy\r\nCharlize Theron\r\nNicholas Hoult\r\nHugh Keays-Byrne\r\nImmortan Joe', 'proximamente', '2025-06-27', '2025-08-15', 0, 'mad-max', 'Acción', ''),
(5, 'Her', 'En Los Ángeles, Theodore es un escritor desanimado que escribe cartas emotivas para otras personas. Él desarrolla una relación amorosa especial con el sistema operativo de su ordenador y su teléfono, una intuitiva y sensible entidad llamada Samantha.', 190, 'Spike Jonze', '', 'proximamente', '2025-07-16', '2025-08-19', 0, 'her', 'Drama', ''),
(6, 'Seven', 'El veterano teniente Somerset está a punto de jubilarse y ser reemplazado por el impulsivo detective David Mills. Ambos tendrán que colaborar en la resolución de unos asesinatos cometidos por un psicópata que se basa en los siete pecados capitales.', 190, 'David Fincher', '', 'proximamente', '2025-07-16', '2025-08-19', 0, 'seven', 'Thriller/Policiaco', ''),
(7, 'Los asesinos de la luna', 'En la década de 1920, los miembros de la tribu de nativos americanos del condado de Osage, en Oklahoma, son asesinados cuando se encuentra petróleo en sus tierras, y el FBI decide investigar.', 180, 'Martin Scorsese', '', 'proximamente', '2025-07-16', '2025-08-19', 0, 'asesinos-luna', 'Drama', ''),
(8, 'Dune Parte 1', 'Arrakis, también denominado \"Dune\", se ha convertido en el planeta más importante del universo. A su alrededor comienza una gigantesca lucha por el poder que culmina en una guerra interestelar.', 190, 'Denis Villeneuve', '', 'proximamente', '2025-07-16', '2025-08-19', 0, 'dune', 'Ciencia Ficción', '');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `proyecciones`
--

CREATE TABLE `proyecciones` (
  `id_proyeccion` int(11) NOT NULL,
  `id_cine` int(11) NOT NULL,
  `id_pelicula` int(11) NOT NULL,
  `fecha` date NOT NULL,
  `hora` time NOT NULL,
  `id_sala` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Volcado de datos para la tabla `proyecciones`
--

INSERT INTO `proyecciones` (`id_proyeccion`, `id_cine`, `id_pelicula`, `fecha`, `hora`, `id_sala`) VALUES
(1, 1, 1, '2025-08-14', '20:00:00', 1),
(2, 2, 2, '2025-08-14', '20:00:00', 2),
(3, 1, 2, '2024-12-15', '18:30:00', 1);

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `reservas`
--

CREATE TABLE `reservas` (
  `id_reserva` int(11) NOT NULL,
  `id_usuario` int(11) NOT NULL,
  `id_proyeccion` int(11) NOT NULL,
  `fecha_reserva` date NOT NULL,
  `cantidad_entradas` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Volcado de datos para la tabla `reservas`
--

INSERT INTO `reservas` (`id_reserva`, `id_usuario`, `id_proyeccion`, `fecha_reserva`, `cantidad_entradas`) VALUES
(1, 1, 1, '2025-05-26', 3),
(3, 1, 1, '2025-05-27', 2),
(4, 1, 1, '2025-05-27', 2),
(5, 1, 1, '2025-05-27', 2),
(8, 1, 3, '2024-12-10', 2),
(100, 2, 1, '2025-05-29', 2),
(101, 3, 1, '2025-05-29', 2);

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `reservas_asientos`
--

CREATE TABLE `reservas_asientos` (
  `id_reserva` int(11) NOT NULL,
  `id_asiento` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Volcado de datos para la tabla `reservas_asientos`
--

INSERT INTO `reservas_asientos` (`id_reserva`, `id_asiento`) VALUES
(1, 42),
(1, 43),
(1, 61),
(3, 13),
(3, 14),
(4, 85),
(4, 86),
(5, 51),
(5, 52),
(8, 1),
(8, 2),
(100, 98),
(100, 99),
(101, 119),
(101, 120);

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `salas`
--

CREATE TABLE `salas` (
  `id_sala` int(11) NOT NULL,
  `id_cine` int(11) NOT NULL,
  `nombre` varchar(50) NOT NULL,
  `aforo` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Volcado de datos para la tabla `salas`
--

INSERT INTO `salas` (`id_sala`, `id_cine`, `nombre`, `aforo`) VALUES
(1, 1, '1', 50),
(2, 2, '1', 50),
(3, 7, '1', 50);

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `usuarios`
--

CREATE TABLE `usuarios` (
  `id_usuario` int(11) NOT NULL,
  `nombre` varchar(30) NOT NULL,
  `apellidos` varchar(30) NOT NULL,
  `correo` varchar(100) NOT NULL,
  `clave` varchar(100) NOT NULL,
  `puntos` int(11) NOT NULL,
  `tipo` enum('admin','normal') NOT NULL DEFAULT 'normal',
  `suscripcion` tinyint(1) NOT NULL,
  `telefono` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Volcado de datos para la tabla `usuarios`
--

INSERT INTO `usuarios` (`id_usuario`, `nombre`, `apellidos`, `correo`, `clave`, `puntos`, `tipo`, `suscripcion`, `telefono`) VALUES
(1, 'Alex', 'Hargau', 'alex@correo.com', '202cb962ac59075b964b07152d234b70', 2, 'normal', 0, 600908070),
(2, 'Maria', 'Molina Flor', 'mari@correo.com', '202cb962ac59075b964b07152d234b70', 5, 'normal', 0, 0),
(3, 'Simón', 'Vallejo Aragón', 'simon@correo.com', '202cb962ac59075b964b07152d234b70', 2, 'normal', 0, 0),
(31, 'Víctor', 'Mena', 'admin@correo.com', '202cb962ac59075b964b07152d234b70', 0, 'admin', 0, 0);

--
-- Índices para tablas volcadas
--

--
-- Indices de la tabla `articulos`
--
ALTER TABLE `articulos`
  ADD PRIMARY KEY (`id_articulo`);

--
-- Indices de la tabla `asientos`
--
ALTER TABLE `asientos`
  ADD PRIMARY KEY (`id_asiento`),
  ADD UNIQUE KEY `id_sala` (`id_sala`,`fila`,`butaca`);

--
-- Indices de la tabla `cines`
--
ALTER TABLE `cines`
  ADD PRIMARY KEY (`id_cine`);

--
-- Indices de la tabla `peliculas`
--
ALTER TABLE `peliculas`
  ADD PRIMARY KEY (`id_pelicula`);

--
-- Indices de la tabla `proyecciones`
--
ALTER TABLE `proyecciones`
  ADD PRIMARY KEY (`id_proyeccion`),
  ADD KEY `proyecciones_ibfk_1` (`id_cine`),
  ADD KEY `proyecciones_ibfk_2` (`id_pelicula`),
  ADD KEY `fk_proyecciones_sala` (`id_sala`);

--
-- Indices de la tabla `reservas`
--
ALTER TABLE `reservas`
  ADD PRIMARY KEY (`id_reserva`),
  ADD KEY `reservas_ibfk_1` (`id_usuario`),
  ADD KEY `reservas_ibfk_2` (`id_proyeccion`);

--
-- Indices de la tabla `reservas_asientos`
--
ALTER TABLE `reservas_asientos`
  ADD PRIMARY KEY (`id_reserva`,`id_asiento`),
  ADD KEY `id_asiento` (`id_asiento`);

--
-- Indices de la tabla `salas`
--
ALTER TABLE `salas`
  ADD PRIMARY KEY (`id_sala`),
  ADD KEY `id_cine` (`id_cine`);

--
-- Indices de la tabla `usuarios`
--
ALTER TABLE `usuarios`
  ADD PRIMARY KEY (`id_usuario`);

--
-- AUTO_INCREMENT de las tablas volcadas
--

--
-- AUTO_INCREMENT de la tabla `articulos`
--
ALTER TABLE `articulos`
  MODIFY `id_articulo` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT de la tabla `asientos`
--
ALTER TABLE `asientos`
  MODIFY `id_asiento` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=181;

--
-- AUTO_INCREMENT de la tabla `cines`
--
ALTER TABLE `cines`
  MODIFY `id_cine` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=8;

--
-- AUTO_INCREMENT de la tabla `peliculas`
--
ALTER TABLE `peliculas`
  MODIFY `id_pelicula` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=9;

--
-- AUTO_INCREMENT de la tabla `proyecciones`
--
ALTER TABLE `proyecciones`
  MODIFY `id_proyeccion` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- AUTO_INCREMENT de la tabla `reservas`
--
ALTER TABLE `reservas`
  MODIFY `id_reserva` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=102;

--
-- AUTO_INCREMENT de la tabla `salas`
--
ALTER TABLE `salas`
  MODIFY `id_sala` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;

--
-- AUTO_INCREMENT de la tabla `usuarios`
--
ALTER TABLE `usuarios`
  MODIFY `id_usuario` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=32;

--
-- Restricciones para tablas volcadas
--

--
-- Filtros para la tabla `asientos`
--
ALTER TABLE `asientos`
  ADD CONSTRAINT `asientos_ibfk_1` FOREIGN KEY (`id_sala`) REFERENCES `salas` (`id_sala`) ON DELETE CASCADE;

--
-- Filtros para la tabla `proyecciones`
--
ALTER TABLE `proyecciones`
  ADD CONSTRAINT `fk_proyecciones_sala` FOREIGN KEY (`id_sala`) REFERENCES `salas` (`id_sala`) ON DELETE CASCADE,
  ADD CONSTRAINT `proyecciones_ibfk_1` FOREIGN KEY (`id_cine`) REFERENCES `cines` (`id_cine`) ON DELETE CASCADE,
  ADD CONSTRAINT `proyecciones_ibfk_2` FOREIGN KEY (`id_pelicula`) REFERENCES `peliculas` (`id_pelicula`) ON DELETE CASCADE,
  ADD CONSTRAINT `proyecciones_ibfk_3` FOREIGN KEY (`id_sala`) REFERENCES `salas` (`id_sala`) ON DELETE CASCADE;

--
-- Filtros para la tabla `reservas`
--
ALTER TABLE `reservas`
  ADD CONSTRAINT `reservas_ibfk_1` FOREIGN KEY (`id_usuario`) REFERENCES `usuarios` (`id_usuario`) ON DELETE CASCADE,
  ADD CONSTRAINT `reservas_ibfk_2` FOREIGN KEY (`id_proyeccion`) REFERENCES `proyecciones` (`id_proyeccion`) ON DELETE CASCADE;

--
-- Filtros para la tabla `reservas_asientos`
--
ALTER TABLE `reservas_asientos`
  ADD CONSTRAINT `reservas_asientos_ibfk_1` FOREIGN KEY (`id_reserva`) REFERENCES `reservas` (`id_reserva`) ON DELETE CASCADE,
  ADD CONSTRAINT `reservas_asientos_ibfk_2` FOREIGN KEY (`id_asiento`) REFERENCES `asientos` (`id_asiento`) ON DELETE CASCADE;

--
-- Filtros para la tabla `salas`
--
ALTER TABLE `salas`
  ADD CONSTRAINT `salas_ibfk_1` FOREIGN KEY (`id_cine`) REFERENCES `cines` (`id_cine`);
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
