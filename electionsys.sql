/*
SQLyog Ultimate v9.02 
MySQL - 5.5.24-log : Database - electionsys
*********************************************************************
*/

/*!40101 SET NAMES utf8 */;

/*!40101 SET SQL_MODE=''*/;

/*!40014 SET @OLD_UNIQUE_CHECKS=@@UNIQUE_CHECKS, UNIQUE_CHECKS=0 */;
/*!40014 SET @OLD_FOREIGN_KEY_CHECKS=@@FOREIGN_KEY_CHECKS, FOREIGN_KEY_CHECKS=0 */;
/*!40101 SET @OLD_SQL_MODE=@@SQL_MODE, SQL_MODE='NO_AUTO_VALUE_ON_ZERO' */;
/*!40111 SET @OLD_SQL_NOTES=@@SQL_NOTES, SQL_NOTES=0 */;
CREATE DATABASE /*!32312 IF NOT EXISTS*/`electionsys` /*!40100 DEFAULT CHARACTER SET utf8 COLLATE utf8_spanish_ci */;

USE `electionsys`;

/*Table structure for table `cursos` */

DROP TABLE IF EXISTS `cursos`;

CREATE TABLE `cursos` (
  `idcurso` varchar(10) COLLATE utf8_spanish_ci NOT NULL,
  `desc_curso` varchar(50) COLLATE utf8_spanish_ci NOT NULL,
  `estado` char(1) COLLATE utf8_spanish_ci NOT NULL COMMENT 'A= ACTIVO, I= INACTIVO',
  PRIMARY KEY (`idcurso`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_spanish_ci;

/*Data for the table `cursos` */

insert  into `cursos`(`idcurso`,`desc_curso`,`estado`) values ('10B','CURSO 10 B','A'),('11A','CURSO 11 A','A');

/*Table structure for table `curules` */

DROP TABLE IF EXISTS `curules`;

CREATE TABLE `curules` (
  `idcurul` varchar(10) COLLATE utf8_spanish_ci NOT NULL,
  `desc_curul` varchar(100) COLLATE utf8_spanish_ci NOT NULL,
  `tipo_curul` char(1) COLLATE utf8_spanish_ci NOT NULL COMMENT 'G= GLOBAL, P=PRIVADO',
  `estado` char(1) COLLATE utf8_spanish_ci NOT NULL COMMENT 'A= ACTIVO, I= INACTIVO',
  PRIMARY KEY (`idcurul`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_spanish_ci;

/*Data for the table `curules` */

insert  into `curules`(`idcurul`,`desc_curul`,`tipo_curul`,`estado`) values ('01','CONCEJO ESTUDIANTIL','P','A'),('02','PERSONERIA ESTUDIANTIL','G','A');

/*Table structure for table `elecciones` */

DROP TABLE IF EXISTS `elecciones`;

CREATE TABLE `elecciones` (
  `ideleccion` varchar(10) CHARACTER SET utf8 COLLATE utf8_spanish_ci NOT NULL,
  `desc_eleccion` varchar(100) CHARACTER SET utf8 COLLATE utf8_spanish_ci DEFAULT NULL,
  `fecha_inicio` date NOT NULL,
  `fecha_fin` date NOT NULL,
  `estado` char(1) CHARACTER SET utf8 COLLATE utf8_spanish_ci NOT NULL COMMENT 'A= ABIERTA, C= CERRADA, X= ELIMINADA',
  PRIMARY KEY (`ideleccion`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

/*Data for the table `elecciones` */

insert  into `elecciones`(`ideleccion`,`desc_eleccion`,`fecha_inicio`,`fecha_fin`,`estado`) values ('201601','ELECCION PERSONERO Y CONCEJO ESTUDIANTIL 2016','2016-02-01','2016-02-06','A'),('201602','ELECCION DE REPRESENTANTE','2016-02-29','2016-03-03','A');

/*Table structure for table `estudiantes` */

DROP TABLE IF EXISTS `estudiantes`;

CREATE TABLE `estudiantes` (
  `idestudiante` varchar(20) COLLATE utf8_spanish_ci NOT NULL,
  `nombre_completo` varchar(100) COLLATE utf8_spanish_ci NOT NULL,
  `sexo` char(1) COLLATE utf8_spanish_ci NOT NULL COMMENT 'M= MASCULINO, F= FEMENINO',
  `telefono` varchar(15) COLLATE utf8_spanish_ci DEFAULT NULL,
  `idcurso` varchar(10) COLLATE utf8_spanish_ci NOT NULL,
  `estado` char(1) COLLATE utf8_spanish_ci NOT NULL COMMENT 'A= ACTIVO, I= INACTIVO',
  PRIMARY KEY (`idestudiante`),
  KEY `FK_estudiantes_cursos` (`idcurso`),
  CONSTRAINT `FK_estudiantes_cursos` FOREIGN KEY (`idcurso`) REFERENCES `cursos` (`idcurso`) ON DELETE NO ACTION ON UPDATE NO ACTION
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_spanish_ci;

/*Data for the table `estudiantes` */

insert  into `estudiantes`(`idestudiante`,`nombre_completo`,`sexo`,`telefono`,`idcurso`,`estado`) values ('123132132','KENNETH JIMENEZ OROZCO','M','','11A','A'),('44158745','KATHERINE OROZCO DE ALBA','F','21231321321','10B','A'),('72434252','WALTER JIMENEZ GERALDINO','M','3145160423','11A','A');

/*Table structure for table `usuarios` */

DROP TABLE IF EXISTS `usuarios`;

CREATE TABLE `usuarios` (
  `idusuario` int(20) NOT NULL,
  `nombre_completo` varchar(250) CHARACTER SET utf8 COLLATE utf8_spanish_ci NOT NULL,
  `email` varchar(250) CHARACTER SET utf8 COLLATE utf8_spanish_ci DEFAULT NULL,
  `login` varchar(15) CHARACTER SET utf8 COLLATE utf8_spanish_ci NOT NULL,
  `pass` varchar(40) CHARACTER SET utf8 COLLATE utf8_spanish_ci NOT NULL,
  `perfil` int(11) NOT NULL COMMENT '1= Administrador',
  `estado` char(1) CHARACTER SET utf8 COLLATE utf8_spanish_ci NOT NULL COMMENT 'A=Activo, I=Inactivo',
  PRIMARY KEY (`idusuario`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

/*Data for the table `usuarios` */

insert  into `usuarios`(`idusuario`,`nombre_completo`,`email`,`login`,`pass`,`perfil`,`estado`) values (72434252,'Walter Jimenez','thewalox@hotmail.com','wjimenez','3f21d33a835bee97c27e555e0690a692',1,'A');

/*!40101 SET SQL_MODE=@OLD_SQL_MODE */;
/*!40014 SET FOREIGN_KEY_CHECKS=@OLD_FOREIGN_KEY_CHECKS */;
/*!40014 SET UNIQUE_CHECKS=@OLD_UNIQUE_CHECKS */;
/*!40111 SET SQL_NOTES=@OLD_SQL_NOTES */;
