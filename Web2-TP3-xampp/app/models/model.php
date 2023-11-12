<?php

    abstract class Model {
        protected $db;

        function __construct() {
            $this->db = new PDO('mysql:host='. MYSQL_HOST .';dbname='. MYSQL_DB .';charset=utf8', MYSQL_USER, MYSQL_PASS);
            $this->deploy();
        }

        function deploy() {
            $query = $this->db->query('SHOW TABLES');
            $tables = $query->fetchAll(); 
            if(count($tables)==0) {
                $sql =<<<END
                -- phpMyAdmin SQL Dump
                -- version 5.2.1
                -- https://www.phpmyadmin.net/
                --
                -- Servidor: 127.0.0.1
                -- Tiempo de generación: 18-10-2023 a las 00:20:30
                -- Versión del servidor: 10.4.28-MariaDB
                -- Versión de PHP: 8.2.4
                
                SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
                START TRANSACTION;
                SET time_zone = "+00:00";
                
                
                /*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
                /*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
                /*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
                /*!40101 SET NAMES utf8mb4 */;
                
                --
                -- Base de datos: `db_cancionero`
                --
                
                -- --------------------------------------------------------
                
                --
                -- Estructura de tabla para la tabla `albumes`
                --
                
                CREATE TABLE `albumes` (
                `id` int(11) NOT NULL,
                `nombre` varchar(50) CHARACTER SET utf8 COLLATE utf8_unicode_ci NOT NULL,
                `autor` varchar(50) CHARACTER SET utf8 COLLATE utf8_unicode_ci NOT NULL,
                `fecha` year(4) NOT NULL
                ) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;
                
                --
                -- Volcado de datos para la tabla `albumes`
                --
                
                INSERT INTO `albumes` (`id`, `nombre`, `autor`, `fecha`) VALUES
                (1, '27', 'Ciro y los Persas', '2012'),
                (3, 'Espejos', 'Ciro y los persas', '2010');
                
                -- --------------------------------------------------------
                
                --
                -- Estructura de tabla para la tabla `canciones`
                --
                
                CREATE TABLE `canciones` (
                `id` int(11) NOT NULL,
                `Nombre` varchar(45) NOT NULL,
                `Duracion` time NOT NULL,
                `Album_fk` int(11) NOT NULL
                ) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;
                
                --
                -- Volcado de datos para la tabla `canciones`
                --
                
                INSERT INTO `canciones` (`id`, `Nombre`, `Duracion`, `Album_fk`) VALUES
                (1, 'Me gusta', '00:04:49', 3),
                (9, 'Nico', '00:05:55', 3);
                
                -- --------------------------------------------------------
                
                --
                -- Estructura de tabla para la tabla `usuarios`
                --
                
                CREATE TABLE `usuarios` (
                `id` int(11) NOT NULL,
                `username` varchar(150) NOT NULL,
                `password` varchar(255) NOT NULL
                ) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;
                
                --
                -- Volcado de datos para la tabla `usuarios`
                --
                
                INSERT INTO `usuarios` (`id`, `username`, `password`) VALUES
                (1, 'webadmin', '$2a$13\$zJhGyBTGGUur2lNahIChJueNK/ER0VPSWbmVr0nqreSu5WkWifxQG');
                
                --
                -- Índices para tablas volcadas
                --
                
                --
                -- Indices de la tabla `albumes`
                --
                ALTER TABLE `albumes`
                ADD PRIMARY KEY (`id`);
                
                --
                -- Indices de la tabla `canciones`
                --
                ALTER TABLE `canciones`
                ADD PRIMARY KEY (`id`),
                ADD KEY `Album_fk` (`Album_fk`);
                
                --
                -- Indices de la tabla `usuarios`
                --
                ALTER TABLE `usuarios`
                ADD PRIMARY KEY (`id`);
                
                --
                -- AUTO_INCREMENT de las tablas volcadas
                --
                
                --
                -- AUTO_INCREMENT de la tabla `albumes`
                --
                ALTER TABLE `albumes`
                MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;
                
                --
                -- AUTO_INCREMENT de la tabla `canciones`
                --
                ALTER TABLE `canciones`
                MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=10;
                
                --
                -- AUTO_INCREMENT de la tabla `usuarios`
                --
                ALTER TABLE `usuarios`
                MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;
                
                --
                -- Restricciones para tablas volcadas
                --
                
                --
                -- Filtros para la tabla `canciones`
                --
                ALTER TABLE `canciones`
                ADD CONSTRAINT `Album_fk` FOREIGN KEY (`Album_fk`) REFERENCES `albumes` (`id`);
                COMMIT;
                
                /*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
                /*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
                /*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;                
                END;
                $this->db->query($sql);
            }
            
        }
    }
