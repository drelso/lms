# ************************************************************
# Sequel Pro SQL dump
# Versión 4499
#
# http://www.sequelpro.com/
# https://github.com/sequelpro/sequelpro
#
# Host: 127.0.0.1 (MySQL 5.5.38)
# Base de datos: learning_mgmt_system
# Tiempo de Generación: 2016-01-03 05:24:30 +0000
# ************************************************************


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8 */;
/*!40014 SET @OLD_FOREIGN_KEY_CHECKS=@@FOREIGN_KEY_CHECKS, FOREIGN_KEY_CHECKS=0 */;
/*!40101 SET @OLD_SQL_MODE=@@SQL_MODE, SQL_MODE='NO_AUTO_VALUE_ON_ZERO' */;
/*!40111 SET @OLD_SQL_NOTES=@@SQL_NOTES, SQL_NOTES=0 */;


# Volcado de tabla calificaciones
# ------------------------------------------------------------

DROP TABLE IF EXISTS `calificaciones`;

CREATE TABLE `calificaciones` (
  `id_usuario` int(11) unsigned NOT NULL,
  `id_contenido` int(11) unsigned NOT NULL,
  `id_grupo` int(11) unsigned NOT NULL,
  `calificacion` double NOT NULL DEFAULT '0',
  PRIMARY KEY (`id_usuario`,`id_contenido`),
  KEY `calificaciones_contenido` (`id_contenido`),
  KEY `calificaciones_grupo` (`id_grupo`),
  CONSTRAINT `calificaciones_contenido` FOREIGN KEY (`id_contenido`) REFERENCES `contenidos` (`id`),
  CONSTRAINT `calificaciones_grupo` FOREIGN KEY (`id_grupo`) REFERENCES `grupos` (`id`),
  CONSTRAINT `calificaciones_usuario` FOREIGN KEY (`id_usuario`) REFERENCES `usuarios` (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;



# Volcado de tabla colores
# ------------------------------------------------------------

DROP TABLE IF EXISTS `colores`;

CREATE TABLE `colores` (
  `id` int(11) unsigned NOT NULL AUTO_INCREMENT,
  `rgb` varchar(12) NOT NULL DEFAULT '',
  `hex` varchar(6) NOT NULL DEFAULT '',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

LOCK TABLES `colores` WRITE;
/*!40000 ALTER TABLE `colores` DISABLE KEYS */;

INSERT INTO `colores` (`id`, `rgb`, `hex`)
VALUES
	(1,'','FFFFFF'),
	(2,'','0BABA5');

/*!40000 ALTER TABLE `colores` ENABLE KEYS */;
UNLOCK TABLES;


# Volcado de tabla contenidos
# ------------------------------------------------------------

DROP TABLE IF EXISTS `contenidos`;

CREATE TABLE `contenidos` (
  `id` int(11) unsigned NOT NULL AUTO_INCREMENT,
  `modulo` int(11) DEFAULT NULL,
  `informacion` varchar(10000) DEFAULT NULL,
  `tipo_de_aprendizaje` int(11) NOT NULL,
  `tipo_de_contenido` int(11) unsigned NOT NULL,
  `orden` int(11) unsigned NOT NULL,
  PRIMARY KEY (`id`),
  KEY `contenido_tipocontenido` (`tipo_de_contenido`),
  CONSTRAINT `contenido_tipocontenido` FOREIGN KEY (`tipo_de_contenido`) REFERENCES `tipo_contenido` (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;



# Volcado de tabla departamento
# ------------------------------------------------------------

DROP TABLE IF EXISTS `departamento`;

CREATE TABLE `departamento` (
  `id` varchar(11) NOT NULL DEFAULT '',
  `nombre` varchar(255) NOT NULL DEFAULT '',
  `director` varchar(255) DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

LOCK TABLES `departamento` WRITE;
/*!40000 ALTER TABLE `departamento` DISABLE KEYS */;

INSERT INTO `departamento` (`id`, `nombre`, `director`)
VALUES
	('COM','Computación','Miguel González'),
	('EDU','Educación','María Rodríguez'),
	('FIS','Física','Alejandro Martínez'),
	('MAT','Matemáticas','José González');

/*!40000 ALTER TABLE `departamento` ENABLE KEYS */;
UNLOCK TABLES;


# Volcado de tabla estructuras
# ------------------------------------------------------------

DROP TABLE IF EXISTS `estructuras`;

CREATE TABLE `estructuras` (
  `id` int(11) unsigned NOT NULL AUTO_INCREMENT,
  `estilos` varchar(10000) NOT NULL DEFAULT '',
  `id_html_1` int(11) unsigned NOT NULL,
  `id_html_2` int(11) unsigned NOT NULL,
  `id_html_3` int(11) unsigned NOT NULL,
  `id_html_4` int(11) unsigned NOT NULL,
  `id_html_5` int(11) unsigned NOT NULL,
  PRIMARY KEY (`id`),
  KEY `estructura_html_2` (`id_html_2`),
  KEY `estructura_html_1` (`id_html_1`),
  KEY `estructura_html_3` (`id_html_3`),
  KEY `estructura_html_4` (`id_html_4`),
  KEY `estructura_html_5` (`id_html_5`),
  CONSTRAINT `estructura_html_1` FOREIGN KEY (`id_html_1`) REFERENCES `html` (`id`),
  CONSTRAINT `estructura_html_2` FOREIGN KEY (`id_html_2`) REFERENCES `html` (`id`),
  CONSTRAINT `estructura_html_3` FOREIGN KEY (`id_html_3`) REFERENCES `html` (`id`),
  CONSTRAINT `estructura_html_4` FOREIGN KEY (`id_html_4`) REFERENCES `html` (`id`),
  CONSTRAINT `estructura_html_5` FOREIGN KEY (`id_html_5`) REFERENCES `html` (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;



# Volcado de tabla evaluaciones
# ------------------------------------------------------------

DROP TABLE IF EXISTS `evaluaciones`;

CREATE TABLE `evaluaciones` (
  `id_contenido` int(11) unsigned NOT NULL,
  `pregunta` varchar(5000) DEFAULT NULL,
  `respuesta_1` varchar(1000) DEFAULT NULL,
  `respuesta_2` varchar(1000) DEFAULT NULL,
  `respuesta_3` varchar(1000) DEFAULT NULL,
  `respuesta_4` varchar(1000) DEFAULT NULL,
  `respuesta_5` varchar(1000) DEFAULT NULL,
  `respuesta_6` varchar(1000) DEFAULT NULL,
  `respuesta_7` varchar(1000) DEFAULT NULL,
  `respuesta_8` varchar(1000) DEFAULT NULL,
  `correctas` varchar(100) NOT NULL DEFAULT '',
  PRIMARY KEY (`id_contenido`),
  CONSTRAINT `evaluacion_contenido` FOREIGN KEY (`id_contenido`) REFERENCES `contenidos` (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;



# Volcado de tabla grupos
# ------------------------------------------------------------

DROP TABLE IF EXISTS `grupos`;

CREATE TABLE `grupos` (
  `id` int(11) unsigned NOT NULL AUTO_INCREMENT,
  `id_materia` varchar(11) NOT NULL DEFAULT '',
  `id_profesor` int(11) unsigned DEFAULT NULL,
  `id_interfaz` int(11) unsigned DEFAULT NULL,
  `id_periodo` int(11) unsigned NOT NULL,
  `numero` int(11) unsigned NOT NULL DEFAULT '1',
  PRIMARY KEY (`id`),
  KEY `grupo_periodo` (`id_periodo`),
  KEY `grupo_interfaz` (`id_interfaz`),
  KEY `grupo_profesor` (`id_profesor`),
  KEY `grupo_materia` (`id_materia`),
  CONSTRAINT `grupo_interfaz` FOREIGN KEY (`id_interfaz`) REFERENCES `interfaz` (`id`),
  CONSTRAINT `grupo_materia` FOREIGN KEY (`id_materia`) REFERENCES `materia` (`id`),
  CONSTRAINT `grupo_periodo` FOREIGN KEY (`id_periodo`) REFERENCES `periodos` (`id`),
  CONSTRAINT `grupo_profesor` FOREIGN KEY (`id_profesor`) REFERENCES `usuarios` (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

LOCK TABLES `grupos` WRITE;
/*!40000 ALTER TABLE `grupos` DISABLE KEYS */;

INSERT INTO `grupos` (`id`, `id_materia`, `id_profesor`, `id_interfaz`, `id_periodo`, `numero`)
VALUES
	(1,'1',4,NULL,1,0),
	(2,'1',5,NULL,1,0),
	(3,'2',4,NULL,1,0),
	(4,'2',3,NULL,1,0),
	(5,'1',3,NULL,1,0),
	(7,'1',3,NULL,1,1),
	(8,'1',3,NULL,1,2);

/*!40000 ALTER TABLE `grupos` ENABLE KEYS */;
UNLOCK TABLES;


# Volcado de tabla html
# ------------------------------------------------------------

DROP TABLE IF EXISTS `html`;

CREATE TABLE `html` (
  `id` int(11) unsigned NOT NULL AUTO_INCREMENT,
  `id_tipo_contenido` int(11) unsigned NOT NULL,
  `html` varchar(10000) NOT NULL DEFAULT '',
  PRIMARY KEY (`id`),
  KEY `html_tipocontenido` (`id_tipo_contenido`),
  CONSTRAINT `html_tipocontenido` FOREIGN KEY (`id_tipo_contenido`) REFERENCES `tipo_contenido` (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;



# Volcado de tabla interfaz
# ------------------------------------------------------------

DROP TABLE IF EXISTS `interfaz`;

CREATE TABLE `interfaz` (
  `id` int(11) unsigned NOT NULL AUTO_INCREMENT,
  `id_paleta` int(11) unsigned NOT NULL,
  `id_estructura` int(11) unsigned NOT NULL,
  PRIMARY KEY (`id`),
  KEY `interfaz_paleta` (`id_paleta`),
  KEY `interfaz_estructura` (`id_estructura`),
  CONSTRAINT `interfaz_estructura` FOREIGN KEY (`id_estructura`) REFERENCES `estructuras` (`id`),
  CONSTRAINT `interfaz_paleta` FOREIGN KEY (`id_paleta`) REFERENCES `paleta_de_colores` (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;



# Volcado de tabla materia
# ------------------------------------------------------------

DROP TABLE IF EXISTS `materia`;

CREATE TABLE `materia` (
  `id` varchar(11) NOT NULL DEFAULT '',
  `nombre` varchar(255) NOT NULL DEFAULT '',
  `id_departamento` varchar(11) DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `materia_departamento` (`id_departamento`),
  CONSTRAINT `materia_departamento` FOREIGN KEY (`id_departamento`) REFERENCES `departamento` (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

LOCK TABLES `materia` WRITE;
/*!40000 ALTER TABLE `materia` DISABLE KEYS */;

INSERT INTO `materia` (`id`, `nombre`, `id_departamento`)
VALUES
	('1','Administración del desarrollo de software',NULL),
	('2','Técnicas de programación',NULL),
	('3','Metodología de la Investigación',NULL),
	('4','Inteligencia Artificial',NULL),
	('5','Sistemas Distribuidos',NULL),
	('F3001','Introducción a la física',NULL),
	('MT3201','Cálculo I',NULL),
	('TC2001','Bases de datos distribuidas',NULL);

/*!40000 ALTER TABLE `materia` ENABLE KEYS */;
UNLOCK TABLES;


# Volcado de tabla paleta_de_colores
# ------------------------------------------------------------

DROP TABLE IF EXISTS `paleta_de_colores`;

CREATE TABLE `paleta_de_colores` (
  `id` int(11) unsigned NOT NULL AUTO_INCREMENT,
  `id_color_1` int(11) unsigned NOT NULL,
  `id_color_2` int(11) unsigned NOT NULL,
  `id_color_3` int(11) unsigned NOT NULL,
  `id_color_4` int(11) unsigned NOT NULL,
  `id_color_5` int(11) unsigned NOT NULL,
  PRIMARY KEY (`id`),
  KEY `paletacolor_1` (`id_color_1`),
  KEY `paletacolor_2` (`id_color_2`),
  KEY `paletacolor_3` (`id_color_3`),
  KEY `paletacolor_4` (`id_color_4`),
  KEY `paletacolor_5` (`id_color_5`),
  CONSTRAINT `paletacolor_1` FOREIGN KEY (`id_color_1`) REFERENCES `colores` (`id`),
  CONSTRAINT `paletacolor_2` FOREIGN KEY (`id_color_2`) REFERENCES `colores` (`id`),
  CONSTRAINT `paletacolor_3` FOREIGN KEY (`id_color_3`) REFERENCES `colores` (`id`),
  CONSTRAINT `paletacolor_4` FOREIGN KEY (`id_color_4`) REFERENCES `colores` (`id`),
  CONSTRAINT `paletacolor_5` FOREIGN KEY (`id_color_5`) REFERENCES `colores` (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;



# Volcado de tabla periodos
# ------------------------------------------------------------

DROP TABLE IF EXISTS `periodos`;

CREATE TABLE `periodos` (
  `id` int(11) unsigned NOT NULL AUTO_INCREMENT,
  `nombre` varchar(255) DEFAULT NULL,
  `descripcion` varchar(255) DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

LOCK TABLES `periodos` WRITE;
/*!40000 ALTER TABLE `periodos` DISABLE KEYS */;

INSERT INTO `periodos` (`id`, `nombre`, `descripcion`)
VALUES
	(1,'20153','Agosto - Diciembre 2015'),
	(2,'ds','sdf'),
	(3,'20151','Enero – Mayo 2015'),
	(4,'20152','Junio – Septiembre 2015'),
	(5,'20161','Enero – Mayo 2016');

/*!40000 ALTER TABLE `periodos` ENABLE KEYS */;
UNLOCK TABLES;


# Volcado de tabla registros
# ------------------------------------------------------------

DROP TABLE IF EXISTS `registros`;

CREATE TABLE `registros` (
  `id_usuario` int(11) unsigned NOT NULL,
  `id_grupo` int(11) unsigned NOT NULL,
  `completado` double DEFAULT NULL,
  `calificacion` double DEFAULT NULL,
  PRIMARY KEY (`id_usuario`),
  KEY `registros_grupo` (`id_grupo`),
  CONSTRAINT `registros_grupo` FOREIGN KEY (`id_grupo`) REFERENCES `grupos` (`id`),
  CONSTRAINT `registros_usuario` FOREIGN KEY (`id_usuario`) REFERENCES `usuarios` (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;



# Volcado de tabla retroalimentacion_interfaz
# ------------------------------------------------------------

DROP TABLE IF EXISTS `retroalimentacion_interfaz`;

CREATE TABLE `retroalimentacion_interfaz` (
  `id_usuario` int(11) unsigned NOT NULL,
  `id_grupo` int(11) unsigned NOT NULL,
  `id_interfaz` int(11) unsigned NOT NULL,
  `valoracion` double NOT NULL,
  `comentarios` varchar(5000) DEFAULT NULL,
  KEY `retroalimentacion_usuario` (`id_usuario`),
  KEY `retroalimentacion_grupo` (`id_grupo`),
  KEY `retroalimentacion_interfaz` (`id_interfaz`),
  CONSTRAINT `retroalimentacion_grupo` FOREIGN KEY (`id_grupo`) REFERENCES `grupos` (`id`),
  CONSTRAINT `retroalimentacion_interfaz` FOREIGN KEY (`id_interfaz`) REFERENCES `interfaz` (`id`),
  CONSTRAINT `retroalimentacion_usuario` FOREIGN KEY (`id_usuario`) REFERENCES `usuarios` (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;



# Volcado de tabla tema
# ------------------------------------------------------------

DROP TABLE IF EXISTS `tema`;

CREATE TABLE `tema` (
  `id` int(11) unsigned NOT NULL,
  `id_materia` varchar(11) NOT NULL DEFAULT '',
  `nombre` varchar(255) NOT NULL,
  `orden` int(11) unsigned NOT NULL,
  PRIMARY KEY (`id`),
  KEY `tema_materia` (`id_materia`),
  CONSTRAINT `tema_materia` FOREIGN KEY (`id_materia`) REFERENCES `materia` (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;



# Volcado de tabla tema_contenido
# ------------------------------------------------------------

DROP TABLE IF EXISTS `tema_contenido`;

CREATE TABLE `tema_contenido` (
  `idtema` int(11) unsigned NOT NULL,
  `idcontenido` int(11) unsigned NOT NULL,
  KEY `temacontenido_tema` (`idtema`),
  KEY `temacontenido_contenido` (`idcontenido`),
  CONSTRAINT `temacontenido_contenido` FOREIGN KEY (`idcontenido`) REFERENCES `contenidos` (`id`),
  CONSTRAINT `temacontenido_tema` FOREIGN KEY (`idtema`) REFERENCES `tema` (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;



# Volcado de tabla tipo_contenido
# ------------------------------------------------------------

DROP TABLE IF EXISTS `tipo_contenido`;

CREATE TABLE `tipo_contenido` (
  `id` int(11) unsigned NOT NULL AUTO_INCREMENT,
  `nombre` varchar(255) NOT NULL DEFAULT '',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

LOCK TABLES `tipo_contenido` WRITE;
/*!40000 ALTER TABLE `tipo_contenido` DISABLE KEYS */;

INSERT INTO `tipo_contenido` (`id`, `nombre`)
VALUES
	(1,'Texto'),
	(2,'Imagen'),
	(3,'Video'),
	(4,'Audio'),
	(5,'Evaluación');

/*!40000 ALTER TABLE `tipo_contenido` ENABLE KEYS */;
UNLOCK TABLES;


# Volcado de tabla tipo_usuario
# ------------------------------------------------------------

DROP TABLE IF EXISTS `tipo_usuario`;

CREATE TABLE `tipo_usuario` (
  `id_usuario` int(11) unsigned NOT NULL,
  `id_tipo` int(11) unsigned NOT NULL,
  PRIMARY KEY (`id_usuario`,`id_tipo`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

LOCK TABLES `tipo_usuario` WRITE;
/*!40000 ALTER TABLE `tipo_usuario` DISABLE KEYS */;

INSERT INTO `tipo_usuario` (`id_usuario`, `id_tipo`)
VALUES
	(1,3),
	(3,1),
	(3,2),
	(3,3),
	(4,2),
	(5,2),
	(8,3),
	(9,3),
	(10,3),
	(11,3),
	(12,3),
	(13,3),
	(14,3),
	(15,3),
	(18,3),
	(19,2);

/*!40000 ALTER TABLE `tipo_usuario` ENABLE KEYS */;
UNLOCK TABLES;


# Volcado de tabla tipos_usuarios
# ------------------------------------------------------------

DROP TABLE IF EXISTS `tipos_usuarios`;

CREATE TABLE `tipos_usuarios` (
  `id` int(11) unsigned NOT NULL AUTO_INCREMENT,
  `nombre` varchar(255) DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

LOCK TABLES `tipos_usuarios` WRITE;
/*!40000 ALTER TABLE `tipos_usuarios` DISABLE KEYS */;

INSERT INTO `tipos_usuarios` (`id`, `nombre`)
VALUES
	(1,'Administrador'),
	(2,'Profesor'),
	(3,'Estudiante');

/*!40000 ALTER TABLE `tipos_usuarios` ENABLE KEYS */;
UNLOCK TABLES;


# Volcado de tabla usuario_departamento
# ------------------------------------------------------------

DROP TABLE IF EXISTS `usuario_departamento`;

CREATE TABLE `usuario_departamento` (
  `id_usuario` int(11) unsigned NOT NULL,
  `id_departamento` varchar(11) NOT NULL DEFAULT '0',
  PRIMARY KEY (`id_usuario`,`id_departamento`),
  KEY `departamento_usuario` (`id_departamento`),
  CONSTRAINT `departamento_usuario` FOREIGN KEY (`id_departamento`) REFERENCES `departamento` (`id`),
  CONSTRAINT `usuario_departamento` FOREIGN KEY (`id_usuario`) REFERENCES `usuarios` (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

LOCK TABLES `usuario_departamento` WRITE;
/*!40000 ALTER TABLE `usuario_departamento` DISABLE KEYS */;

INSERT INTO `usuario_departamento` (`id_usuario`, `id_departamento`)
VALUES
	(3,'COM'),
	(4,'COM'),
	(18,'COM'),
	(19,'COM'),
	(4,'EDU'),
	(5,'EDU'),
	(10,'EDU'),
	(18,'FIS'),
	(19,'FIS'),
	(18,'MAT');

/*!40000 ALTER TABLE `usuario_departamento` ENABLE KEYS */;
UNLOCK TABLES;


# Volcado de tabla usuario_grupo
# ------------------------------------------------------------

DROP TABLE IF EXISTS `usuario_grupo`;

CREATE TABLE `usuario_grupo` (
  `id_usuario` int(11) unsigned NOT NULL,
  `id_grupo` int(11) unsigned NOT NULL,
  PRIMARY KEY (`id_usuario`,`id_grupo`),
  KEY `usuariogrupo_grupo` (`id_grupo`),
  CONSTRAINT `usuariogrupo_grupo` FOREIGN KEY (`id_grupo`) REFERENCES `grupos` (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

LOCK TABLES `usuario_grupo` WRITE;
/*!40000 ALTER TABLE `usuario_grupo` DISABLE KEYS */;

INSERT INTO `usuario_grupo` (`id_usuario`, `id_grupo`)
VALUES
	(3,2),
	(3,3);

/*!40000 ALTER TABLE `usuario_grupo` ENABLE KEYS */;
UNLOCK TABLES;


# Volcado de tabla usuarios
# ------------------------------------------------------------

DROP TABLE IF EXISTS `usuarios`;

CREATE TABLE `usuarios` (
  `id` int(11) unsigned NOT NULL AUTO_INCREMENT,
  `nombre` varchar(255) DEFAULT '',
  `matricula` varchar(10) DEFAULT NULL,
  `correo` varchar(255) DEFAULT NULL,
  `curriculum` varchar(10000) DEFAULT NULL,
  `contrasena` varchar(255) DEFAULT NULL,
  `nivel_estudios` int(11) DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

LOCK TABLES `usuarios` WRITE;
/*!40000 ALTER TABLE `usuarios` DISABLE KEYS */;

INSERT INTO `usuarios` (`id`, `nombre`, `matricula`, `correo`, `curriculum`, `contrasena`, `nivel_estudios`)
VALUES
	(1,'Diego RamÃ­rez EchavarrÃ­a',NULL,'diegoraech1@gmail.com','Licenciado en ProducciÃ³n ElectrÃ³nica y DiseÃ±o de Audio. Candidato a Maestro en Ciencias de la ComputaciÃ³n.','$2y$10$9miyQ9GLjtP6Jtk0kGOQjuGOQ0Sk56axnwoZB9hSlzi.dec339M4O',1),
	(3,'Diego Ramírez Echavarría','A01336922','diegoraech@gmail.com','Licenciado en Producción Electrónica y Diseño de Audio. Candidato a Maestro en Ciencias de la Computación.','$2y$10$BrFTUqcx8HAzDNQfEOjw4O8U7Uq8W2.S47lNQ2wKycf6.mqo3uawu',2),
	(4,'Julieta Noguez','L01001010','jnoguez@itesm.mx','Profesora/Investigadora\\nGrupo de Investigación e Innovación en Educación\\nEscuela de Educación, Humanidades y Ciencias Sociales','$2y$10$uUpH2UwT6qtzVqg5H.1hq.wvDzBPF0M8KBOrkBcKxcyFqAdZ.lQ9G',8),
	(5,'Juan Pérez Martínrez','A112','prueb3a@itesm.mx','Edité a Juanito, le puse la contraseña \'00000000\' por mientras','$2y$10$BjCY0KxHBaO0WHkpubvPP.cFZqFUJQI2KkULjNrYqVtMB5c6k8a.u',5),
	(6,'José Rodríguez','A01112233','jrodriguez@correo.com','curriculum','12345678',3),
	(7,'Arturo Chávez','A01336924','achavez@correo.com','curriculum','$2y$10$obfCjEmc76VkR1EWSlhro.gUs8eLr4k3iTSEqF85xGjworuYP0Q4e',3),
	(8,'Matías Fuentes','A01336925','mfuentes@correo.com','curriculum','$2y$10$kjzYPRDK1Ib8q/90G6jwHOAuu25.91U/hEZaictkq5sD5G5IKoysq',3),
	(9,'Andrea Suárez','A01326455','asuarez@prueba.com','curriculum','$2y$10$Pho12yv6zDmYJV9FIbojXeQgfW4T8mq6w5.tyqrBPAFbsueedjMte',3),
	(10,'María Rodríguez','A01326454','arodriguez@prueba.com','curriculum','$2y$10$aLYkZ/k7rqpC0OtjpUopdOvJ2TE1xg/9xHl7jg0uVLm5wIFuBCzdC',4),
	(11,'Rodrigo Pérez','A01326450','rperez@correo.com','curriculum','$2y$10$RjbxaIaJyOV.P.uMrNKez.iBAOgmkBN9UXkprEyy3vbKJliwRABgS',4),
	(12,'Fernanda Rangel','A01326448','frangel@correo.com','curriculum','$2y$10$LG5j0cAk/KSSegSnaWi4Zu9Jg.GN1cwm6g7Hetz6bKNqiYxsT/xti',4),
	(13,'Jorge Jiménez','A01326457','jjimenez@correo.com','curriculum','$2y$10$3AqxUvJ.3QYxK5bgRB06tuAV5I693d4SvhpEK0roxXWY5Hxf/6ak6',4),
	(14,'Ana Aguilera','A01326455','aaguilera@correo.com','CV','$2y$10$jZ7xRKJHU9gb4exPD3HztOxXOZeTXx1dCjAY5llETpvIU8rJ.EJHm',4),
	(15,'Jaime Ortiz','A01326459','jortiz@correo.com','CV','$2y$10$WONe5ZWQI0mkr22issDpFeYX71CxTgpBAoQN3LBq6itXN6UBgc68S',4),
	(18,'Jorge Alcántara','A01326465','jalcantara@correo.com','CV','$2y$10$EzKRY67GRJP/98RQSXGovei8AFnk5BVAvaaVNi3cIKEgs3mXVCOZW',4),
	(19,'Jesús Hernández','A01326452','jhernandez@correo.com','CV','$2y$10$sTTh31kbdUWLadt4082Cg.8.u993jdS54esxVTD14aaBKZxHkOfDe',4);

/*!40000 ALTER TABLE `usuarios` ENABLE KEYS */;
UNLOCK TABLES;



/*!40111 SET SQL_NOTES=@OLD_SQL_NOTES */;
/*!40101 SET SQL_MODE=@OLD_SQL_MODE */;
/*!40014 SET FOREIGN_KEY_CHECKS=@OLD_FOREIGN_KEY_CHECKS */;
/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
