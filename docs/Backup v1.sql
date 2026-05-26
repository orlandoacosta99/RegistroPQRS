-- --------------------------------------------------------
-- Host:                         127.0.0.1
-- Versión del servidor:         8.0.30 - MySQL Community Server - GPL
-- SO del servidor:              Win64
-- HeidiSQL Versión:             12.1.0.6537
-- --------------------------------------------------------

/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET NAMES utf8 */;
/*!50503 SET NAMES utf8mb4 */;
/*!40103 SET @OLD_TIME_ZONE=@@TIME_ZONE */;
/*!40103 SET TIME_ZONE='+00:00' */;
/*!40014 SET @OLD_FOREIGN_KEY_CHECKS=@@FOREIGN_KEY_CHECKS, FOREIGN_KEY_CHECKS=0 */;
/*!40101 SET @OLD_SQL_MODE=@@SQL_MODE, SQL_MODE='NO_AUTO_VALUE_ON_ZERO' */;
/*!40111 SET @OLD_SQL_NOTES=@@SQL_NOTES, SQL_NOTES=0 */;


-- Volcando estructura de base de datos para registro_pqrs
DROP DATABASE IF EXISTS `registro_pqrs`;
CREATE DATABASE IF NOT EXISTS `registro_pqrs` /*!40100 DEFAULT CHARACTER SET utf8mb3 COLLATE utf8mb3_spanish_ci */ /*!80016 DEFAULT ENCRYPTION='N' */;
USE `registro_pqrs`;

-- Volcando estructura para tabla registro_pqrs.tm_usuario
DROP TABLE IF EXISTS `tm_usuario`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `tm_usuario` (
  `usu_id` int NOT NULL AUTO_INCREMENT,
  `usu_nomape` varchar(90) CHARACTER SET utf8mb3 COLLATE utf8mb3_spanish_ci NOT NULL,
  `usu_correo` varchar(50) CHARACTER SET utf8mb3 COLLATE utf8mb3_spanish_ci NOT NULL,
  `usu_pass` varchar(200) CHARACTER SET utf8mb3 COLLATE utf8mb3_spanish_ci DEFAULT NULL,
  `fech_crea` datetime NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `usu_img` varchar(500) CHARACTER SET utf8mb3 COLLATE utf8mb3_spanish_ci DEFAULT NULL,
  `rol_id` int DEFAULT NULL,
  `fech_modi` datetime DEFAULT NULL,
  `fech_elim` datetime DEFAULT NULL,
  `fech_acti` datetime DEFAULT NULL,
  `est` int NOT NULL DEFAULT '2',
  PRIMARY KEY (`usu_id`)
) ENGINE=InnoDB AUTO_INCREMENT=121 DEFAULT CHARSET=utf8mb3 COLLATE=utf8mb3_spanish_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `tm_usuario`
--

LOCK TABLES `tm_usuario` WRITE;
/*!40000 ALTER TABLE `tm_usuario` DISABLE KEYS */;
INSERT INTO `tm_usuario` VALUES (1,'User1','acostavargasorlando@gmail.com','5jPRnIhMm9aJByVOExo95jjYEOq+2sfv1AZDtHvSi0w=','2023-11-24 22:46:03','../../assets/picture/avatars/avatar_1_1779238882.png',1,'2026-05-19 20:02:09',NULL,NULL,1),(2,'AdminU','acostavargasorlando1@gmail.com','5jPRnIhMm9aJByVOExo95jjYEOq+2sfv1AZDtHvSi0w=','2026-05-19 16:42:51','../../assets/picture/avatars/avatar_2_1779241290.jpg',3,'2026-05-19 20:41:42',NULL,NULL,1),(3,'orlando acosta vargas','acostavargasorlando99@gmail.com','5jPRnIhMm9aJByVOExo95jjYEOq+2sfv1AZDtHvSi0w=','2026-05-19 21:21:21','https://lh3.googleusercontent.com/a/ACg8ocJg7TM2jqoDsLr7L_qHmyJSowm8B84JryR3l6qSPNIdkdh_EwaP=s96-c',1,NULL,NULL,NULL,1);
/*!40000 ALTER TABLE `tm_usuario` ENABLE KEYS */;
UNLOCK TABLES;
/*!40103 SET TIME_ZONE=IFNULL(@OLD_TIME_ZONE, 'system') */;
/*!40101 SET SQL_MODE=IFNULL(@OLD_SQL_MODE, '') */;
/*!40014 SET FOREIGN_KEY_CHECKS=IFNULL(@OLD_FOREIGN_KEY_CHECKS, 1) */;
/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40111 SET SQL_NOTES=IFNULL(@OLD_SQL_NOTES, 1) */;


DROP TABLE IF EXISTS `tm_tipo`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `tm_tipo` (
  `tip_id` int NOT NULL AUTO_INCREMENT,
  `tip_nom` varchar(50) CHARACTER SET utf8mb3 COLLATE utf8mb3_spanish_ci DEFAULT NULL,
  `fech_crea` datetime DEFAULT CURRENT_TIMESTAMP,
  `fech_modi` datetime DEFAULT NULL,
  `fech_elim` datetime DEFAULT NULL,
  `est` int DEFAULT '1',
  PRIMARY KEY (`tip_id`) USING BTREE
) ENGINE=InnoDB AUTO_INCREMENT=15 DEFAULT CHARSET=utf8mb3 COLLATE=utf8mb3_spanish_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `tm_tipo`
--

LOCK TABLES `tm_tipo` WRITE;
/*!40000 ALTER TABLE `tm_tipo` DISABLE KEYS */;
INSERT INTO `tm_tipo` VALUES (1,'Natural','2023-12-01 19:20:14',NULL,NULL,1),(2,'Juridico','2023-12-01 19:20:14',NULL,NULL,1),(3,'Otro','2023-12-01 19:20:14',NULL,NULL,1);
/*!40000 ALTER TABLE `tm_tipo` ENABLE KEYS */;
UNLOCK TABLES;


--
-- Table structure for table `tm_tramite`
--

DROP TABLE IF EXISTS `tm_tramite`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `tm_tramite` (
  `tra_id` int NOT NULL AUTO_INCREMENT,
  `tra_nom` varchar(150) CHARACTER SET utf8mb3 COLLATE utf8mb3_spanish_ci NOT NULL,
  `tra_descrip` varchar(300) CHARACTER SET utf8mb3 COLLATE utf8mb3_spanish_ci NOT NULL,
  `fech_crea` datetime DEFAULT CURRENT_TIMESTAMP,
  `fech_modi` datetime DEFAULT NULL,
  `fech_elim` datetime DEFAULT NULL,
  `est` int DEFAULT '1',
  PRIMARY KEY (`tra_id`)
) ENGINE=InnoDB AUTO_INCREMENT=23 DEFAULT CHARSET=utf8mb3 COLLATE=utf8mb3_spanish_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `tm_tramite`
--

LOCK TABLES `tm_tramite` WRITE;
/*!40000 ALTER TABLE `tm_tramite` DISABLE KEYS */;
INSERT INTO `tm_tramite` VALUES (1,'Recepción de Correspondencia Externa','Registro y distribución de la correspondencia enviada por clientes, proveedores u otras entidades externas.','2023-12-01 22:48:17',NULL,NULL,1),(2,'Registro de Quejas o Reclamos de Clientes','Proceso para gestionar y dar respuesta a las quejas o reclamos de los clientes.','2023-12-01 22:48:17',NULL,NULL,1),(3,'Solicitud de Información Pública','Gestión de solicitudes de información pública por parte de entidades gubernamentales u otros solicitantes externos.','2023-12-01 22:48:17',NULL,NULL,1),(4,'Registro de Contratos y Acuerdos','Archivo y seguimiento de los contratos y acuerdos firmados con clientes, proveedores u otras partes externas.','2023-12-01 22:48:17',NULL,NULL,1),(5,'Solicitud de Autorización para Eventos','Trámite para obtener permisos y autorizaciones necesarias para la realización de eventos.','2023-12-01 22:48:17',NULL,NULL,1),(6,'Solicitud de Registro de Proveedores','Proceso para incorporar nuevos proveedores al sistema de la empresa.','2023-12-01 22:48:17',NULL,NULL,1),(7,'Solicitud de Certificaciones o Documentos Oficiales','Obtención de certificaciones y documentos oficiales emitidos por la empresa.','2023-12-01 22:48:17',NULL,NULL,1),(8,'Registro de Visitantes','Proceso para registrar la entrada y salida de visitantes a las instalaciones de la empresa.','2023-12-01 22:48:17',NULL,NULL,1),(9,'Solicitud de Facturas o Documentación Financiera','Petición de facturas, recibos u otra documentación financiera por parte de clientes u otras entidades.','2023-12-01 22:48:17',NULL,NULL,1),(10,'Solicitud de Autorización para Viajes de Negocios','Trámite para obtener autorización y coordinar detalles relacionados con los viajes de negocios de los empleados.','2023-12-01 22:48:17',NULL,NULL,1),(11,'Solicitud de Material de Oficina','Pedido de suministros y material necesario para el funcionamiento de las distintas áreas.','2023-12-01 22:48:17',NULL,NULL,1),(12,'Solicitud de Permiso o Licencia','Gestión de permisos y licencias para ausencias programadas de los empleados.','2023-12-01 22:48:17',NULL,NULL,1),(13,'Reclamo de Gastos','Presentación y revisión de gastos realizados por empleados en nombre de la empresa.','2023-12-01 22:48:17',NULL,NULL,1),(14,'Solicitud de Equipamiento o Tecnología','Pedido de nuevas herramientas, equipos o tecnologías para mejorar las operaciones internas.','2023-12-01 22:48:17',NULL,NULL,1),(15,'Solicitud de Mantenimiento','Reporte y seguimiento de solicitudes de mantenimiento para equipos o instalaciones.','2023-12-01 22:48:17',NULL,NULL,1),(16,'Solicitud de Capacitación','Registro para participar en programas de formación y capacitación.','2023-12-01 22:48:17',NULL,NULL,1),(17,'Solicitud de Cambio de Turno o Horario','Gestión de cambios en los horarios laborales de los empleados.','2023-12-01 22:48:17',NULL,NULL,1),(18,'Solicitud de Vacaciones','Proceso para solicitar y coordinar períodos de vacaciones.','2023-12-01 22:48:17',NULL,NULL,1),(19,'Reclamo de Incidentes Laborales','Informe y seguimiento de incidentes laborales, como accidentes o problemas de seguridad.','2023-12-01 22:48:17',NULL,NULL,1),(20,'Solicitud de Compra de Insumos','Registro de solicitudes para adquirir insumos necesarios para las operaciones.','2023-12-01 22:48:17',NULL,NULL,1),(21,'Otro','Otro','2023-12-01 22:48:17',NULL,NULL,1),(22,'test2','test2','2023-12-01 22:58:54','2023-12-01 22:59:06','2023-12-01 22:59:14',0);
/*!40000 ALTER TABLE `tm_tramite` ENABLE KEYS */;
UNLOCK TABLES;
/*!40103 SET TIME_ZONE=@OLD_TIME_ZONE */;


--
-- Table structure for table `tm_rol`
--

DROP TABLE IF EXISTS `tm_rol`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `tm_rol` (
  `rol_id` int NOT NULL AUTO_INCREMENT,
  `rol_nom` varchar(50) CHARACTER SET utf8mb3 COLLATE utf8mb3_spanish_ci DEFAULT NULL,
  `fech_crea` datetime DEFAULT CURRENT_TIMESTAMP,
  `fech_modi` datetime DEFAULT NULL,
  `fech_elim` datetime DEFAULT NULL,
  `est` int DEFAULT '1',
  PRIMARY KEY (`rol_id`)
) ENGINE=InnoDB AUTO_INCREMENT=4 DEFAULT CHARSET=utf8mb3 COLLATE=utf8mb3_spanish_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `tm_rol`
--

LOCK TABLES `tm_rol` WRITE;
/*!40000 ALTER TABLE `tm_rol` DISABLE KEYS */;
INSERT INTO `tm_rol` VALUES (1,'Persona','2023-12-05 12:44:00',NULL,NULL,1),(2,'Colaborador','2023-12-05 12:44:10',NULL,NULL,1),(3,'Administrador','2023-12-05 12:44:17',NULL,NULL,1);
/*!40000 ALTER TABLE `tm_rol` ENABLE KEYS */;
UNLOCK TABLES;
/*!40103 SET TIME_ZONE=@OLD_TIME_ZONE */;


--
-- Table structure for table `tm_menu`
--

DROP TABLE IF EXISTS `tm_menu`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `tm_menu` (
  `men_id` int NOT NULL AUTO_INCREMENT,
  `men_nom` varchar(200) CHARACTER SET utf8mb3 COLLATE utf8mb3_spanish_ci DEFAULT NULL,
  `men_nom_vista` varchar(200) CHARACTER SET utf8mb3 COLLATE utf8mb3_spanish_ci DEFAULT NULL,
  `men_icon` varchar(200) CHARACTER SET utf8mb3 COLLATE utf8mb3_spanish_ci DEFAULT NULL,
  `men_ruta` varchar(200) CHARACTER SET utf8mb3 COLLATE utf8mb3_spanish_ci DEFAULT NULL,
  `fech_crea` datetime DEFAULT CURRENT_TIMESTAMP,
  `fech_modi` datetime DEFAULT NULL,
  `fech_elim` datetime DEFAULT NULL,
  `est` int DEFAULT '1',
  PRIMARY KEY (`men_id`)
) ENGINE=InnoDB AUTO_INCREMENT=12 DEFAULT CHARSET=utf8mb3 COLLATE=utf8mb3_spanish_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `tm_menu`
--

LOCK TABLES `tm_menu` WRITE;
/*!40000 ALTER TABLE `tm_menu` DISABLE KEYS */;
INSERT INTO `tm_menu` VALUES (1,'home','Inicio','home','../home/','2023-12-05 12:15:29',NULL,NULL,1),(2,'nuevotramite','Nuevo Tramite','grid','../NuevoTramite/','2023-12-05 12:15:47',NULL,NULL,1),(3,'consultartramite','Consultar Tramite','users','../ConsultarTramite/','2023-12-05 12:16:19',NULL,NULL,1),(4,'iniciocolaborador','Inicio Colaborador','home','../homecolaborador/','2023-12-05 12:16:46',NULL,NULL,1),(5,'gestionartramite','Gestionar Tramite','grid','../gestionartramite/','2023-12-05 12:17:08',NULL,NULL,1),(6,'buscartramite','Buscar Tramite','users','../buscartramite/','2023-12-05 12:17:32',NULL,NULL,1),(7,'mntcolaborador','Mnt.Colaborador','users','../mntusuario/','2023-12-05 12:18:06',NULL,NULL,1),(8,'mntarea','Mnt.Area','users','../mntarea/','2023-12-05 12:18:27',NULL,NULL,1),(9,'mnttramite','Mnt.Tramite','users','../mnttramite/','2023-12-05 12:18:51',NULL,NULL,1),(10,'mnttipo','Mnt.Tipo','users','../mnttipo/','2023-12-05 12:19:16',NULL,NULL,1),(11,'mntrol','Mnt.Rol','users','../mntrol/','2023-12-05 12:19:34',NULL,NULL,1);
/*!40000 ALTER TABLE `tm_menu` ENABLE KEYS */;
UNLOCK TABLES;
/*!40103 SET TIME_ZONE=@OLD_TIME_ZONE */;


--
-- Table structure for table `td_menu_detalle`
--

DROP TABLE IF EXISTS `td_menu_detalle`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `td_menu_detalle` (
  `mend_id` int NOT NULL AUTO_INCREMENT,
  `rol_id` int DEFAULT NULL,
  `men_id` int DEFAULT NULL,
  `mend_permi` varchar(2) CHARACTER SET utf8mb3 COLLATE utf8mb3_spanish_ci DEFAULT 'No',
  `fech_crea` datetime DEFAULT CURRENT_TIMESTAMP,
  `fech_modi` datetime DEFAULT NULL,
  `fech_elim` datetime DEFAULT NULL,
  `est` int DEFAULT '1',
  PRIMARY KEY (`mend_id`)
) ENGINE=InnoDB AUTO_INCREMENT=42 DEFAULT CHARSET=utf8mb3 COLLATE=utf8mb3_spanish_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `td_menu_detalle`
--

LOCK TABLES `td_menu_detalle` WRITE;
/*!40000 ALTER TABLE `td_menu_detalle` DISABLE KEYS */;
INSERT INTO `td_menu_detalle` VALUES (1,3,1,'No','2023-12-05 12:53:29','2023-12-05 21:28:57',NULL,1),(2,3,2,'Si','2023-12-05 12:53:29','2023-12-10 11:24:02',NULL,1),(3,3,3,'Si','2023-12-05 12:53:29','2023-12-10 11:23:59',NULL,1),(4,3,4,'Si','2023-12-05 12:53:29','2023-12-05 21:28:23',NULL,1),(5,3,5,'Si','2023-12-05 12:53:29','2023-12-10 11:23:59',NULL,1),(6,3,6,'Si','2023-12-05 12:53:29','2023-12-10 11:24:01',NULL,1),(7,3,7,'Si','2023-12-05 12:53:29','2023-12-05 15:45:48',NULL,1),(8,3,8,'Si','2023-12-05 12:53:29','2023-12-05 15:45:49',NULL,1),(9,3,9,'Si','2023-12-05 12:53:29','2023-12-05 15:32:40',NULL,1),(10,3,10,'Si','2023-12-05 12:53:29','2023-12-05 15:32:39',NULL,1),(11,3,11,'Si','2023-12-05 12:53:29','2023-12-05 15:32:38',NULL,1),(16,2,1,'No','2023-12-05 15:32:23','2023-12-05 21:28:39',NULL,1),(17,2,2,'No','2023-12-05 15:32:23','2023-12-05 21:28:37',NULL,1),(18,2,3,'No','2023-12-05 15:32:23','2023-12-05 21:28:44',NULL,1),(19,2,4,'Si','2023-12-05 15:32:23','2023-12-05 15:32:29',NULL,1),(20,2,5,'Si','2023-12-05 15:32:23','2023-12-05 15:32:30',NULL,1),(21,2,6,'Si','2023-12-05 15:32:23','2023-12-05 15:32:30',NULL,1),(22,2,7,'No','2023-12-05 15:32:23','2023-12-05 15:32:48',NULL,1),(23,2,8,'No','2023-12-05 15:32:23','2023-12-05 15:32:47',NULL,1),(24,2,9,'No','2023-12-05 15:32:23','2023-12-05 15:32:49',NULL,1),(25,2,10,'No','2023-12-05 15:32:23','2023-12-05 15:32:49',NULL,1),(26,2,11,'No','2023-12-05 15:32:23','2023-12-05 15:32:48',NULL,1),(31,1,1,'Si','2023-12-05 15:46:28','2023-12-05 15:46:38',NULL,1),(32,1,2,'Si','2023-12-05 15:46:28','2023-12-05 15:46:41',NULL,1),(33,1,3,'Si','2023-12-05 15:46:28','2023-12-05 15:46:36',NULL,1),(34,1,4,'No','2023-12-05 15:46:28',NULL,NULL,1),(35,1,5,'No','2023-12-05 15:46:28',NULL,NULL,1),(36,1,6,'No','2023-12-05 15:46:28',NULL,NULL,1),(37,1,7,'No','2023-12-05 15:46:28',NULL,NULL,1),(38,1,8,'No','2023-12-05 15:46:28',NULL,NULL,1),(39,1,9,'No','2023-12-05 15:46:28',NULL,NULL,1),(40,1,10,'No','2023-12-05 15:46:28',NULL,NULL,1),(41,1,11,'No','2023-12-05 15:46:28',NULL,NULL,1);
/*!40000 ALTER TABLE `td_menu_detalle` ENABLE KEYS */;
UNLOCK TABLES;
/*!40103 SET TIME_ZONE=@OLD_TIME_ZONE */;


--
-- Table structure for table `tm_documento`
--

DROP TABLE IF EXISTS `tm_documento`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `tm_documento` (
  `doc_id` int NOT NULL AUTO_INCREMENT,
  `area_id` int DEFAULT NULL,
  `tra_id` int DEFAULT NULL,
  `doc_externo` varchar(50) CHARACTER SET utf8mb3 COLLATE utf8mb3_spanish_ci DEFAULT NULL,
  `tip_id` int DEFAULT NULL,
   `tip_doc` varchar(45) CHARACTER SET utf8mb3 COLLATE utf8mb3_spanish_ci DEFAULT NULL,
  `doc_dni` varchar(50) CHARACTER SET utf8mb3 COLLATE utf8mb3_spanish_ci DEFAULT NULL,
  `doc_nom` varchar(250) CHARACTER SET utf8mb3 COLLATE utf8mb3_spanish_ci DEFAULT NULL,
  `doc_descrip` varchar(500) CHARACTER SET utf8mb3 COLLATE utf8mb3_spanish_ci DEFAULT NULL,
  `usu_id` int DEFAULT NULL,
  `doc_estado` varchar(50) CHARACTER SET utf8mb3 COLLATE utf8mb3_spanish_ci DEFAULT 'Pendiente',
  `doc_respuesta` varchar(500) CHARACTER SET utf8mb3 COLLATE utf8mb3_spanish_ci DEFAULT NULL,
  `doc_usu_terminado` int DEFAULT NULL,
  `fech_crea` datetime DEFAULT CURRENT_TIMESTAMP,
  `fech_modi` datetime DEFAULT NULL,
  `fech_elim` datetime DEFAULT NULL,
  `fech_terminado` datetime DEFAULT NULL,
  `est` int DEFAULT '1',
  PRIMARY KEY (`doc_id`)
) ENGINE=InnoDB AUTO_INCREMENT=72 DEFAULT CHARSET=utf8mb3 COLLATE=utf8mb3_spanish_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `tm_documento`
--

LOCK TABLES `tm_documento` WRITE;
/*!40000 ALTER TABLE `tm_documento` DISABLE KEYS */;
/*!40000 ALTER TABLE `tm_documento` ENABLE KEYS */;
UNLOCK TABLES;
/*!40103 SET TIME_ZONE=@OLD_TIME_ZONE */;




--
-- Table structure for table `tm_area`
--

DROP TABLE IF EXISTS `tm_area`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `tm_area` (
  `area_id` int NOT NULL AUTO_INCREMENT,
  `area_nom` varchar(50) CHARACTER SET utf8mb3 COLLATE utf8mb3_spanish_ci NOT NULL,
  `area_correo` varchar(50) CHARACTER SET utf8mb3 COLLATE utf8mb3_spanish_ci NOT NULL DEFAULT '1',
  `fech_crea` datetime DEFAULT CURRENT_TIMESTAMP,
  `fech_modi` datetime DEFAULT NULL,
  `fech_elim` datetime DEFAULT NULL,
  `est` int NOT NULL DEFAULT '1',
  PRIMARY KEY (`area_id`)
) ENGINE=InnoDB AUTO_INCREMENT=17 DEFAULT CHARSET=utf8mb3 COLLATE=utf8mb3_spanish_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `tm_area`
--

LOCK TABLES `tm_area` WRITE;
/*!40000 ALTER TABLE `tm_area` DISABLE KEYS */;
INSERT INTO `tm_area` VALUES (15,'Tecnología de la Información (TI)','acostavargasorlando99@gmail.com','2026-05-19 20:48:16',NULL,NULL,1),(16,'Investigación y Desarrollo (I+D)','acostavargasorlando99@gmail.com','2026-05-19 20:48:38',NULL,NULL,1);
/*!40000 ALTER TABLE `tm_area` ENABLE KEYS */;
UNLOCK TABLES;
/*!40103 SET TIME_ZONE=@OLD_TIME_ZONE */;



--
-- Table structure for table `td_documento_detalle`
--

DROP TABLE IF EXISTS `td_documento_detalle`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `td_documento_detalle` (
  `det_id` int NOT NULL AUTO_INCREMENT,
  `doc_id` int DEFAULT NULL,
  `det_nom` varchar(250) CHARACTER SET utf8mb3 COLLATE utf8mb3_spanish_ci DEFAULT NULL,
  `usu_id` int DEFAULT NULL,
  `det_tipo` varchar(50) CHARACTER SET utf8mb3 COLLATE utf8mb3_spanish_ci DEFAULT NULL,
  `fech_crea` datetime DEFAULT CURRENT_TIMESTAMP,
  `fech_modi` datetime DEFAULT NULL,
  `fech_elim` datetime DEFAULT NULL,
  `est` int DEFAULT '1',
  PRIMARY KEY (`det_id`)
) ENGINE=InnoDB AUTO_INCREMENT=108 DEFAULT CHARSET=utf8mb3 COLLATE=utf8mb3_spanish_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `td_documento_detalle`
--

LOCK TABLES `td_documento_detalle` WRITE;
/*!40000 ALTER TABLE `td_documento_detalle` DISABLE KEYS */;
/*!40000 ALTER TABLE `td_documento_detalle` ENABLE KEYS */;
UNLOCK TABLES;
/*!40103 SET TIME_ZONE=@OLD_TIME_ZONE */;


--
-- Table structure for table `td_area_detalle`
--

DROP TABLE IF EXISTS `td_area_detalle`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `td_area_detalle` (
  `aread_id` int NOT NULL AUTO_INCREMENT,
  `usu_id` int DEFAULT NULL,
  `area_id` int DEFAULT NULL,
  `aread_permi` varchar(2) CHARACTER SET utf8mb3 COLLATE utf8mb3_spanish_ci DEFAULT 'No',
  `fech_crea` datetime DEFAULT CURRENT_TIMESTAMP,
  `fech_modi` datetime DEFAULT NULL,
  `fech_elim` datetime DEFAULT NULL,
  `est` int DEFAULT '1',
  PRIMARY KEY (`aread_id`)
) ENGINE=InnoDB AUTO_INCREMENT=46 DEFAULT CHARSET=utf8mb3 COLLATE=utf8mb3_spanish_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `td_area_detalle`
--

LOCK TABLES `td_area_detalle` WRITE;
/*!40000 ALTER TABLE `td_area_detalle` DISABLE KEYS */;
INSERT INTO `td_area_detalle` VALUES (43,2,15,'No','2026-05-19 20:52:22',NULL,NULL,1),(44,2,16,'No','2026-05-19 20:52:22',NULL,NULL,1);
/*!40000 ALTER TABLE `td_area_detalle` ENABLE KEYS */;
UNLOCK TABLES;
/*!40103 SET TIME_ZONE=@OLD_TIME_ZONE */;



--
-- Dumping routines for database 'registro_pqrs'
--
/*!50003 DROP PROCEDURE IF EXISTS `sp_i_area_01` */;
/*!50003 SET @saved_cs_client      = @@character_set_client */ ;
/*!50003 SET @saved_cs_results     = @@character_set_results */ ;
/*!50003 SET @saved_col_connection = @@collation_connection */ ;
/*!50003 SET character_set_client  = utf8mb4 */ ;
/*!50003 SET character_set_results = utf8mb4 */ ;
/*!50003 SET collation_connection  = utf8mb4_0900_ai_ci */ ;
/*!50003 SET @saved_sql_mode       = @@sql_mode */ ;
/*!50003 SET sql_mode              = 'ONLY_FULL_GROUP_BY,STRICT_TRANS_TABLES,NO_ZERO_IN_DATE,NO_ZERO_DATE,ERROR_FOR_DIVISION_BY_ZERO,NO_ENGINE_SUBSTITUTION' */ ;
DELIMITER ;;
CREATE DEFINER=`root`@`localhost` PROCEDURE `sp_i_area_01`(
	IN `xusu_id` INT
)
BEGIN
	DECLARE areaCount INT;

	SELECT COUNT(*) INTO areaCount FROM td_area_detalle WHERE usu_id = xusu_id;
	
	IF areaCount = 0 THEN
		INSERT INTO td_area_detalle(usu_id,area_id)
		SELECT xusu_id,area_id FROM tm_area WHERE est=1;
	ELSE
		INSERT INTO td_area_detalle(usu_id,area_id)
		SELECT xusu_id,area_id FROM tm_area WHERE est=1 AND area_id NOT IN (SELECT area_id FROM td_area_detalle WHERE usu_id = xusu_id);
	END IF;
	
	SELECT 
	td_area_detalle.aread_id,
	td_area_detalle.area_id,
	td_area_detalle.aread_permi,
	tm_area.area_nom,
	tm_area.area_correo 
	FROM td_area_detalle
	INNER JOIN tm_area ON tm_area.area_id = td_area_detalle.area_id
	WHERE 
	td_area_detalle.usu_id = xusu_id
	AND tm_area.est=1;
END ;;
DELIMITER ;
/*!50003 SET sql_mode              = @saved_sql_mode */ ;
/*!50003 SET character_set_client  = @saved_cs_client */ ;
/*!50003 SET character_set_results = @saved_cs_results */ ;
/*!50003 SET collation_connection  = @saved_col_connection */ ;
/*!50003 DROP PROCEDURE IF EXISTS `sp_i_rol_01` */;
/*!50003 SET @saved_cs_client      = @@character_set_client */ ;
/*!50003 SET @saved_cs_results     = @@character_set_results */ ;
/*!50003 SET @saved_col_connection = @@collation_connection */ ;
/*!50003 SET character_set_client  = utf8mb4 */ ;
/*!50003 SET character_set_results = utf8mb4 */ ;
/*!50003 SET collation_connection  = utf8mb4_0900_ai_ci */ ;
/*!50003 SET @saved_sql_mode       = @@sql_mode */ ;
/*!50003 SET sql_mode              = 'ONLY_FULL_GROUP_BY,STRICT_TRANS_TABLES,NO_ZERO_IN_DATE,NO_ZERO_DATE,ERROR_FOR_DIVISION_BY_ZERO,NO_ENGINE_SUBSTITUTION' */ ;
DELIMITER ;;
CREATE DEFINER=`root`@`localhost` PROCEDURE `sp_i_rol_01`(
	IN `xrol_id` INT
)
BEGIN
	DECLARE rolCount INT;

	SELECT COUNT(*) INTO rolCount FROM td_menu_detalle WHERE rol_id = xrol_id;
	
	IF rolCount = 0 THEN
		INSERT INTO td_menu_detalle(rol_id,men_id)
		SELECT xrol_id,men_id FROM tm_menu WHERE est=1;
	ELSE
		INSERT INTO td_menu_detalle(rol_id,men_id)
		SELECT xrol_id,men_id FROM tm_menu WHERE est=1 AND men_id NOT IN (SELECT men_id FROM td_menu_detalle WHERE rol_id = xrol_id);
	END IF;
	
	SELECT 
		td_menu_detalle.mend_id,
		td_menu_detalle.rol_id,
		td_menu_detalle.mend_permi,
		tm_menu.men_id,
		tm_menu.men_nom,
		tm_menu.men_nom_vista,
		tm_menu.men_icon,
		tm_menu.men_ruta
	FROM td_menu_detalle
	INNER JOIN tm_menu ON tm_menu.men_id = td_menu_detalle.men_id
	WHERE 
	td_menu_detalle.rol_id = xrol_id
	AND tm_menu.est=1;
END ;;
DELIMITER ;
/*!50003 SET sql_mode              = @saved_sql_mode */ ;
/*!50003 SET character_set_client  = @saved_cs_client */ ;
/*!50003 SET character_set_results = @saved_cs_results */ ;
/*!50003 SET collation_connection  = @saved_col_connection */ ;
/*!50003 DROP PROCEDURE IF EXISTS `sp_l_documento_01` */;
/*!50003 SET @saved_cs_client      = @@character_set_client */ ;
/*!50003 SET @saved_cs_results     = @@character_set_results */ ;
/*!50003 SET @saved_col_connection = @@collation_connection */ ;
/*!50003 SET character_set_client  = utf8mb4 */ ;
/*!50003 SET character_set_results = utf8mb4 */ ;
/*!50003 SET collation_connection  = utf8mb4_0900_ai_ci */ ;
/*!50003 SET @saved_sql_mode       = @@sql_mode */ ;
/*!50003 SET sql_mode              = 'ONLY_FULL_GROUP_BY,STRICT_TRANS_TABLES,NO_ZERO_IN_DATE,NO_ZERO_DATE,ERROR_FOR_DIVISION_BY_ZERO,NO_ENGINE_SUBSTITUTION' */ ;
DELIMITER $$
CREATE DEFINER=`root`@`localhost` PROCEDURE `sp_l_documento_01`(IN `xdoc_id` INT)
BEGIN
      SELECT
          tm_documento.doc_id,
          tm_documento.area_id,
          tm_area.area_nom,
          tm_area.area_correo,
          tm_documento.doc_externo,
          tm_documento.doc_dni,
          tm_documento.doc_nom,
          tm_documento.doc_descrip,
          tm_documento.tra_id,
          tm_tramite.tra_nom,
          tm_documento.tip_id,
          tm_tipo.tip_nom,
          tm_documento.tip_doc,
          tm_documento.usu_id,
          tm_usuario.usu_nomape,
          tm_usuario.usu_correo,
          tm_documento.doc_estado,
          tm_documento.doc_respuesta,
          COALESCE(contador.cant,0) AS cant,
          CONCAT(DATE_FORMAT(tm_documento.fech_crea,'%m'),'-',DATE_FORMAT(tm_documento.fech_crea,'%Y'),'-',tm_documento.doc_id) AS nrotramite
      FROM tm_documento
      INNER JOIN tm_area ON tm_documento.area_id = tm_area.area_id
      INNER JOIN tm_tramite ON tm_documento.tra_id = tm_tramite.tra_id
      INNER JOIN tm_tipo ON tm_documento.tip_id = tm_tipo.tip_id
      INNER JOIN tm_usuario ON tm_documento.usu_id = tm_usuario.usu_id
      LEFT JOIN (
          SELECT doc_id, COUNT(*) AS cant
          FROM td_documento_detalle
          WHERE doc_id = xdoc_id
          GROUP BY doc_id
      ) contador ON tm_documento.doc_id = contador.doc_id
      WHERE tm_documento.doc_id = xdoc_id;
  END$$
DELIMITER ;
/*!50003 SET sql_mode              = @saved_sql_mode */ ;
/*!50003 SET character_set_client  = @saved_cs_client */ ;
/*!50003 SET character_set_results = @saved_cs_results */ ;
/*!50003 SET collation_connection  = @saved_col_connection */ ;
/*!50003 DROP PROCEDURE IF EXISTS `sp_l_documento_02` */;
/*!50003 SET @saved_cs_client      = @@character_set_client */ ;
/*!50003 SET @saved_cs_results     = @@character_set_results */ ;
/*!50003 SET @saved_col_connection = @@collation_connection */ ;
/*!50003 SET character_set_client  = utf8mb4 */ ;
/*!50003 SET character_set_results = utf8mb4 */ ;
/*!50003 SET collation_connection  = utf8mb4_0900_ai_ci */ ;
/*!50003 SET @saved_sql_mode       = @@sql_mode */ ;
/*!50003 SET sql_mode              = 'ONLY_FULL_GROUP_BY,STRICT_TRANS_TABLES,NO_ZERO_IN_DATE,NO_ZERO_DATE,ERROR_FOR_DIVISION_BY_ZERO,NO_ENGINE_SUBSTITUTION' */ ;
DELIMITER $$
CREATE DEFINER=`root`@`localhost` PROCEDURE `sp_l_documento_02`(IN `xusu_id` INT)
BEGIN
      SELECT
          tm_documento.doc_id,
          tm_documento.area_id,
          tm_area.area_nom,
          tm_area.area_correo,
          tm_documento.doc_externo,
          tm_documento.doc_dni,
          tm_documento.doc_nom,
          tm_documento.doc_descrip,
          tm_documento.tra_id,
          tm_tramite.tra_nom,
          tm_documento.tip_id,
          tm_tipo.tip_nom,
          tm_documento.tip_doc,
          tm_documento.usu_id,
          tm_usuario.usu_nomape,
          tm_usuario.usu_correo,
          tm_documento.doc_estado,
          CONCAT(DATE_FORMAT(tm_documento.fech_crea,'%m'),'-',DATE_FORMAT(tm_documento.fech_crea,'%Y'),'-',tm_documento.doc_id) AS nrotramite
      FROM tm_documento
      INNER JOIN tm_area ON tm_documento.area_id = tm_area.area_id
      INNER JOIN tm_tramite ON tm_documento.tra_id = tm_tramite.tra_id
      INNER JOIN tm_tipo ON tm_documento.tip_id = tm_tipo.tip_id
      INNER JOIN tm_usuario ON tm_documento.usu_id = tm_usuario.usu_id
      WHERE tm_documento.usu_id = xusu_id;
  END$$
DELIMITER ;
/*!50003 SET sql_mode              = @saved_sql_mode */ ;
/*!50003 SET character_set_client  = @saved_cs_client */ ;
/*!50003 SET character_set_results = @saved_cs_results */ ;
