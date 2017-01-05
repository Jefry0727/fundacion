-- MySQL dump 10.13  Distrib 5.6.24, for osx10.8 (x86_64)
--
-- Host: 127.0.0.1    Database: sam_fundacion
-- ------------------------------------------------------
-- Server version	5.5.5-10.1.10-MariaDB

/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8 */;
/*!40103 SET @OLD_TIME_ZONE=@@TIME_ZONE */;
/*!40103 SET TIME_ZONE='+00:00' */;
/*!40014 SET @OLD_UNIQUE_CHECKS=@@UNIQUE_CHECKS, UNIQUE_CHECKS=0 */;
/*!40014 SET @OLD_FOREIGN_KEY_CHECKS=@@FOREIGN_KEY_CHECKS, FOREIGN_KEY_CHECKS=0 */;
/*!40101 SET @OLD_SQL_MODE=@@SQL_MODE, SQL_MODE='NO_AUTO_VALUE_ON_ZERO' */;
/*!40111 SET @OLD_SQL_NOTES=@@SQL_NOTES, SQL_NOTES=0 */;

--
-- Table structure for table `appointment_dates`
--

DROP TABLE IF EXISTS `appointment_dates`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `appointment_dates` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `appointments_id` int(11) NOT NULL,
  `created` datetime NOT NULL,
  `modified` datetime NOT NULL,
  `users_id` int(11) NOT NULL,
  `date_time_ini` datetime NOT NULL,
  `date_time_end` datetime NOT NULL,
  `appointment_states_id` int(11) NOT NULL,
  PRIMARY KEY (`id`),
  KEY `fk_appointment_dates_appointments1_idx` (`appointments_id`),
  KEY `fk_appointment_dates_users1_idx` (`users_id`),
  KEY `fk_appointment_dates_appointment_states1_idx` (`appointment_states_id`),
  CONSTRAINT `fk_appointment_dates_appointment_states1` FOREIGN KEY (`appointment_states_id`) REFERENCES `appointment_states` (`id`) ON DELETE CASCADE ON UPDATE CASCADE,
  CONSTRAINT `fk_appointment_dates_appointments1` FOREIGN KEY (`appointments_id`) REFERENCES `appointments` (`id`) ON DELETE CASCADE ON UPDATE CASCADE,
  CONSTRAINT `fk_appointment_dates_users1` FOREIGN KEY (`users_id`) REFERENCES `users` (`id`) ON DELETE NO ACTION ON UPDATE NO ACTION
) ENGINE=InnoDB DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `appointment_dates`
--

LOCK TABLES `appointment_dates` WRITE;
/*!40000 ALTER TABLE `appointment_dates` DISABLE KEYS */;
/*!40000 ALTER TABLE `appointment_dates` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `appointment_states`
--

DROP TABLE IF EXISTS `appointment_states`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `appointment_states` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `state` varchar(45) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=5 DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `appointment_states`
--

LOCK TABLES `appointment_states` WRITE;
/*!40000 ALTER TABLE `appointment_states` DISABLE KEYS */;
INSERT INTO `appointment_states` VALUES (1,'Revervada'),(2,'Asginada'),(3,'Reasignada'),(4,'Cancelada');
/*!40000 ALTER TABLE `appointment_states` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `appointments`
--

DROP TABLE IF EXISTS `appointments`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `appointments` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `created` datetime NOT NULL,
  `modified` datetime NOT NULL,
  `medical_offices_id` int(11) NOT NULL,
  `studies_id` int(11) NOT NULL,
  `studies_value` double(10,2) DEFAULT NULL,
  `order_details_id` int(11) NOT NULL,
  PRIMARY KEY (`id`),
  KEY `fk_appointments_medical_offices1_idx` (`medical_offices_id`),
  KEY `fk_appointments_studies1_idx` (`studies_id`),
  KEY `fk_appointments_order_details1_idx` (`order_details_id`),
  CONSTRAINT `fk_appointments_medical_offices1` FOREIGN KEY (`medical_offices_id`) REFERENCES `medical_offices` (`id`) ON DELETE CASCADE ON UPDATE CASCADE,
  CONSTRAINT `fk_appointments_order_details1` FOREIGN KEY (`order_details_id`) REFERENCES `order_details` (`id`) ON DELETE CASCADE ON UPDATE CASCADE,
  CONSTRAINT `fk_appointments_studies1` FOREIGN KEY (`studies_id`) REFERENCES `studies` (`id`) ON DELETE NO ACTION ON UPDATE NO ACTION
) ENGINE=InnoDB DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `appointments`
--

LOCK TABLES `appointments` WRITE;
/*!40000 ALTER TABLE `appointments` DISABLE KEYS */;
/*!40000 ALTER TABLE `appointments` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `attention_consultations`
--

DROP TABLE IF EXISTS `attention_consultations`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `attention_consultations` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `date_time_ini` datetime NOT NULL,
  `date_time_end` datetime NOT NULL,
  `created` datetime NOT NULL,
  `modified` datetime NOT NULL,
  `orders_id` int(11) NOT NULL,
  `specialists_id` int(11) NOT NULL,
  PRIMARY KEY (`id`),
  KEY `fk_consultations_orders1_idx` (`orders_id`),
  KEY `fk_attention_consultations_specialists1_idx` (`specialists_id`),
  CONSTRAINT `fk_attention_consultations_specialists1` FOREIGN KEY (`specialists_id`) REFERENCES `specialists` (`id`) ON DELETE NO ACTION ON UPDATE NO ACTION,
  CONSTRAINT `fk_consultations_orders1` FOREIGN KEY (`orders_id`) REFERENCES `orders` (`id`) ON DELETE NO ACTION ON UPDATE NO ACTION
) ENGINE=InnoDB DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `attention_consultations`
--

LOCK TABLES `attention_consultations` WRITE;
/*!40000 ALTER TABLE `attention_consultations` DISABLE KEYS */;
/*!40000 ALTER TABLE `attention_consultations` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `buy_order_details`
--

DROP TABLE IF EXISTS `buy_order_details`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `buy_order_details` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `buy_orders_id` int(11) NOT NULL,
  `products_id` int(11) NOT NULL,
  `quantity` int(11) DEFAULT NULL,
  `subtotal` decimal(10,2) DEFAULT NULL,
  `individual_value` decimal(10,2) DEFAULT NULL,
  `iva` decimal(10,2) DEFAULT NULL,
  `total` decimal(10,2) DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `fk_buy_order_details_buy_orders1_idx` (`buy_orders_id`),
  KEY `fk_buy_order_details_products1_idx` (`products_id`),
  CONSTRAINT `fk_buy_order_details_buy_orders1` FOREIGN KEY (`buy_orders_id`) REFERENCES `buy_orders` (`id`) ON DELETE CASCADE ON UPDATE CASCADE,
  CONSTRAINT `fk_buy_order_details_products1` FOREIGN KEY (`products_id`) REFERENCES `products` (`id`) ON DELETE CASCADE ON UPDATE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `buy_order_details`
--

LOCK TABLES `buy_order_details` WRITE;
/*!40000 ALTER TABLE `buy_order_details` DISABLE KEYS */;
/*!40000 ALTER TABLE `buy_order_details` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `buy_orders`
--

DROP TABLE IF EXISTS `buy_orders`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `buy_orders` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `quotation_identifier` varchar(30) DEFAULT NULL,
  `discount` decimal(10,2) DEFAULT NULL,
  `total` decimal(10,2) DEFAULT NULL,
  `observations` varchar(255) DEFAULT NULL,
  `users_id` int(11) NOT NULL,
  `providers_id` int(11) NOT NULL,
  `date` date DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `fk_buy_orders_users1_idx` (`users_id`),
  KEY `fk_buy_orders_providers1_idx` (`providers_id`),
  CONSTRAINT `fk_buy_orders_providers1` FOREIGN KEY (`providers_id`) REFERENCES `providers` (`id`) ON DELETE CASCADE ON UPDATE CASCADE,
  CONSTRAINT `fk_buy_orders_users1` FOREIGN KEY (`users_id`) REFERENCES `users` (`id`) ON DELETE CASCADE ON UPDATE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `buy_orders`
--

LOCK TABLES `buy_orders` WRITE;
/*!40000 ALTER TABLE `buy_orders` DISABLE KEYS */;
/*!40000 ALTER TABLE `buy_orders` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `centers`
--

DROP TABLE IF EXISTS `centers`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `centers` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `name` varchar(45) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=4 DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `centers`
--

LOCK TABLES `centers` WRITE;
/*!40000 ALTER TABLE `centers` DISABLE KEYS */;
INSERT INTO `centers` VALUES (1,'Seleccione la  Sede'),(2,'Sede 1'),(3,'Sede 2');
/*!40000 ALTER TABLE `centers` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `clients`
--

DROP TABLE IF EXISTS `clients`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `clients` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `name` varchar(45) NOT NULL,
  `nit` varchar(30) NOT NULL,
  `social_reazon` varchar(250) DEFAULT NULL,
  `ars_code` varchar(20) DEFAULT NULL,
  `address` varchar(200) DEFAULT NULL,
  `responsible` varchar(150) DEFAULT NULL,
  `email` varchar(150) DEFAULT NULL,
  `phone` varchar(25) DEFAULT NULL,
  `phone2` varchar(25) DEFAULT NULL,
  `state` int(1) NOT NULL,
  `municipalities_id` int(11) NOT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `nit_UNIQUE` (`nit`),
  KEY `fk_clients_municipalities1_idx` (`municipalities_id`),
  CONSTRAINT `fk_clients_municipalities1` FOREIGN KEY (`municipalities_id`) REFERENCES `municipalities` (`id`) ON DELETE NO ACTION ON UPDATE NO ACTION
) ENGINE=InnoDB AUTO_INCREMENT=10 DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `clients`
--

LOCK TABLES `clients` WRITE;
/*!40000 ALTER TABLE `clients` DISABLE KEYS */;
INSERT INTO `clients` VALUES (1,'Cliente 1','1234090','Razón social','001','calle 10 N','Juan Camilo','deirojas.1@gmail.com','411111','1',0,789),(2,'Cliente 2','123','Pruebas','','calle','Reponsable','deiro1jas.1@gmail.com','311','311',1,1),(3,'Cliente 3','1234','medico','','calle','Reponsable','deiro1jas2.1@gmail.com','311','311',1,707),(4,'Cliente 4','890234','j','','calle','persona','2@gmail.com','322','212',0,409),(5,'Cliente 5','8g8','r','r','r','r','oijo@omc.com','r','ukj',1,835),(6,'Cliente 6','8g8lkn','r','r','r','r','oijklno@omc.com','r','ukj',0,849),(7,'Compañia 1','98980','r','r','r','r','r@gmail.com','r','r',1,796),(8,'Compañia 2','26748456','razon','2','2','2','deiro1jas.1@gmail.com','2','2',1,1),(9,'Compañia 3','654654','kjhj','ewq','ewq','ewq','jkhjh@asd.com','ewq','ewq',1,612);
/*!40000 ALTER TABLE `clients` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `control_formats`
--

DROP TABLE IF EXISTS `control_formats`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `control_formats` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `format_type_id` int(11) NOT NULL,
  `attention_studies_id` int(11) NOT NULL,
  PRIMARY KEY (`id`),
  KEY `fk_control_formats_format_type1_idx` (`format_type_id`),
  KEY `fk_control_formats_attention_studies1_idx` (`attention_studies_id`),
  CONSTRAINT `fk_control_formats_attention_studies1` FOREIGN KEY (`attention_studies_id`) REFERENCES `attention_studies` (`id`) ON DELETE NO ACTION ON UPDATE NO ACTION,
  CONSTRAINT `fk_control_formats_format_type1` FOREIGN KEY (`format_type_id`) REFERENCES `format_types` (`id`) ON DELETE CASCADE ON UPDATE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `control_formats`
--

LOCK TABLES `control_formats` WRITE;
/*!40000 ALTER TABLE `control_formats` DISABLE KEYS */;
/*!40000 ALTER TABLE `control_formats` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `departments`
--

DROP TABLE IF EXISTS `departments`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `departments` (
  `id` int(11) NOT NULL,
  `name` varchar(45) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `departments`
--

LOCK TABLES `departments` WRITE;
/*!40000 ALTER TABLE `departments` DISABLE KEYS */;
INSERT INTO `departments` VALUES (1,'Antioquia'),(2,'Atlántico'),(3,'Bogotá, D.C.'),(4,'Bolívar'),(5,'Boyacá'),(6,'Caldas'),(7,'Caquetá'),(8,'Cauca'),(9,'Cesar'),(10,'Córdoba'),(11,'Cundinamarca'),(12,'Chocó'),(13,'Huila'),(14,'La Guajira'),(15,'Magdalena'),(16,'Meta'),(17,'Nariño'),(18,'Norte De Santander'),(19,'Quindío'),(20,'Risaralda'),(21,'Santander'),(22,'Sucre'),(23,'Tolima'),(24,'Valle Del Cauca'),(25,'Arauca'),(26,'Casanare'),(27,'Putumayo'),(28,'Archipiélago De San Andrés'),(29,'Amazonas'),(30,'Guainía'),(31,'Guaviare'),(32,'Vaupés'),(33,'Vichada');
/*!40000 ALTER TABLE `departments` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `document_types`
--

DROP TABLE IF EXISTS `document_types`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `document_types` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `type` varchar(45) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=4 DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `document_types`
--

LOCK TABLES `document_types` WRITE;
/*!40000 ALTER TABLE `document_types` DISABLE KEYS */;
INSERT INTO `document_types` VALUES (1,'Seleccione una Opciòn '),(2,'Cedula Ciudadania '),(3,'Tarjeta Identidad');
/*!40000 ALTER TABLE `document_types` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `external_specialists`
--

DROP TABLE IF EXISTS `external_specialists`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `external_specialists` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `name` varchar(255) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=5 DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `external_specialists`
--

LOCK TABLES `external_specialists` WRITE;
/*!40000 ALTER TABLE `external_specialists` DISABLE KEYS */;
INSERT INTO `external_specialists` VALUES (1,'Medico'),(2,'medico'),(3,'pediatra'),(4,'perontologo');
/*!40000 ALTER TABLE `external_specialists` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `format_types`
--

DROP TABLE IF EXISTS `format_types`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `format_types` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `name` varchar(45) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `format_types`
--

LOCK TABLES `format_types` WRITE;
/*!40000 ALTER TABLE `format_types` DISABLE KEYS */;
/*!40000 ALTER TABLE `format_types` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `informed_consents`
--

DROP TABLE IF EXISTS `informed_consents`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `informed_consents` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `content` text COMMENT 'content',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `informed_consents`
--

LOCK TABLES `informed_consents` WRITE;
/*!40000 ALTER TABLE `informed_consents` DISABLE KEYS */;
/*!40000 ALTER TABLE `informed_consents` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `instructive_studies`
--

DROP TABLE IF EXISTS `instructive_studies`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `instructive_studies` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `instructives_id` int(11) NOT NULL,
  `studies_id` int(11) NOT NULL,
  PRIMARY KEY (`id`),
  KEY `fk_instructives_has_studies_studies1_idx` (`studies_id`),
  KEY `fk_instructives_has_studies_instructives1_idx` (`instructives_id`),
  CONSTRAINT `fk_instructives_has_studies_instructives1` FOREIGN KEY (`instructives_id`) REFERENCES `instructives` (`id`) ON DELETE CASCADE ON UPDATE CASCADE,
  CONSTRAINT `fk_instructives_has_studies_studies1` FOREIGN KEY (`studies_id`) REFERENCES `studies` (`id`) ON DELETE CASCADE ON UPDATE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `instructive_studies`
--

LOCK TABLES `instructive_studies` WRITE;
/*!40000 ALTER TABLE `instructive_studies` DISABLE KEYS */;
/*!40000 ALTER TABLE `instructive_studies` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `instructives`
--

DROP TABLE IF EXISTS `instructives`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `instructives` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `url` text COMMENT 'file path',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `instructives`
--

LOCK TABLES `instructives` WRITE;
/*!40000 ALTER TABLE `instructives` DISABLE KEYS */;
/*!40000 ALTER TABLE `instructives` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `inv_outputs`
--

DROP TABLE IF EXISTS `inv_outputs`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `inv_outputs` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `inv_outputs`
--

LOCK TABLES `inv_outputs` WRITE;
/*!40000 ALTER TABLE `inv_outputs` DISABLE KEYS */;
/*!40000 ALTER TABLE `inv_outputs` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `invima_code_products`
--

DROP TABLE IF EXISTS `invima_code_products`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `invima_code_products` (
  `id` int(11) unsigned zerofill NOT NULL,
  `invima_codes_id` int(11) NOT NULL,
  `products_id` int(11) NOT NULL,
  PRIMARY KEY (`id`),
  KEY `fk_invima_codes_has_products_products1_idx` (`products_id`),
  KEY `fk_invima_codes_has_products_invima_codes1_idx` (`invima_codes_id`),
  CONSTRAINT `fk_invima_codes_has_products_invima_codes1` FOREIGN KEY (`invima_codes_id`) REFERENCES `invima_codes` (`id`) ON DELETE CASCADE ON UPDATE CASCADE,
  CONSTRAINT `fk_invima_codes_has_products_products1` FOREIGN KEY (`products_id`) REFERENCES `products` (`id`) ON DELETE CASCADE ON UPDATE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `invima_code_products`
--

LOCK TABLES `invima_code_products` WRITE;
/*!40000 ALTER TABLE `invima_code_products` DISABLE KEYS */;
/*!40000 ALTER TABLE `invima_code_products` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `invima_codes`
--

DROP TABLE IF EXISTS `invima_codes`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `invima_codes` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `code` varchar(50) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `invima_codes`
--

LOCK TABLES `invima_codes` WRITE;
/*!40000 ALTER TABLE `invima_codes` DISABLE KEYS */;
/*!40000 ALTER TABLE `invima_codes` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `logging`
--

DROP TABLE IF EXISTS `logging`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `logging` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `users_id` int(11) NOT NULL,
  `register` text NOT NULL,
  `logging_sections_id` int(11) NOT NULL,
  `created` datetime NOT NULL,
  `logging_actions_id` int(11) NOT NULL,
  PRIMARY KEY (`id`),
  KEY `fk_logging_users1_idx` (`users_id`),
  KEY `fk_logging_logging_sections1_idx` (`logging_sections_id`),
  KEY `fk_logging_logging_actions1_idx` (`logging_actions_id`),
  CONSTRAINT `fk_logging_logging_actions1` FOREIGN KEY (`logging_actions_id`) REFERENCES `logging_actions` (`id`) ON DELETE CASCADE ON UPDATE CASCADE,
  CONSTRAINT `fk_logging_logging_sections1` FOREIGN KEY (`logging_sections_id`) REFERENCES `logging_sections` (`id`) ON DELETE CASCADE ON UPDATE CASCADE,
  CONSTRAINT `fk_logging_users1` FOREIGN KEY (`users_id`) REFERENCES `users` (`id`) ON DELETE CASCADE ON UPDATE CASCADE
) ENGINE=InnoDB AUTO_INCREMENT=4 DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `logging`
--

LOCK TABLES `logging` WRITE;
/*!40000 ALTER TABLE `logging` DISABLE KEYS */;
INSERT INTO `logging` VALUES (1,1,'{\"date_ini\":\"2016-06-08T00:00:00+0000\",\"date_end\":\"2016-06-28T00:00:00+0000\",\"medical_offices_id\":7,\"users_id\":1,\"created\":\"2016-06-15T14:38:21-0500\",\"modified\":\"2016-06-15T14:38:21-0500\",\"id\":21}',1,'2016-06-15 14:38:21',1),(2,1,'{\"date_ini\":\"2016-06-14T00:00:00+0000\",\"date_end\":\"2016-06-22T00:00:00+0000\",\"medical_offices_id\":7,\"users_id\":1,\"created\":\"2016-06-15T16:06:40-0500\",\"modified\":\"2016-06-15T16:06:40-0500\",\"id\":22}',1,'2016-06-15 16:06:40',1),(3,1,'{\"date_ini\":\"2016-06-14T00:00:00+0000\",\"date_end\":\"2016-06-22T00:00:00+0000\",\"medical_offices_id\":7,\"users_id\":1,\"created\":\"2016-06-15T16:06:42-0500\",\"modified\":\"2016-06-15T16:06:42-0500\",\"id\":23}',1,'2016-06-15 16:06:42',1);
/*!40000 ALTER TABLE `logging` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `logging_actions`
--

DROP TABLE IF EXISTS `logging_actions`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `logging_actions` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `action` varchar(20) DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=4 DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `logging_actions`
--

LOCK TABLES `logging_actions` WRITE;
/*!40000 ALTER TABLE `logging_actions` DISABLE KEYS */;
INSERT INTO `logging_actions` VALUES (1,'add'),(2,'edit'),(3,'delete');
/*!40000 ALTER TABLE `logging_actions` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `logging_sections`
--

DROP TABLE IF EXISTS `logging_sections`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `logging_sections` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `name` varchar(45) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=2 DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `logging_sections`
--

LOCK TABLES `logging_sections` WRITE;
/*!40000 ALTER TABLE `logging_sections` DISABLE KEYS */;
INSERT INTO `logging_sections` VALUES (1,'users');
/*!40000 ALTER TABLE `logging_sections` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `master_schedule`
--

DROP TABLE IF EXISTS `master_schedule`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `master_schedule` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `description` varchar(200) DEFAULT NULL COMMENT '	',
  `time_ini` time DEFAULT NULL,
  `time_end` time DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `master_schedule`
--

LOCK TABLES `master_schedule` WRITE;
/*!40000 ALTER TABLE `master_schedule` DISABLE KEYS */;
/*!40000 ALTER TABLE `master_schedule` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `medical_office_restrictions`
--

DROP TABLE IF EXISTS `medical_office_restrictions`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `medical_office_restrictions` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `description` varchar(80) DEFAULT NULL COMMENT '	',
  `date_ini` datetime DEFAULT NULL COMMENT '	',
  `date_end` datetime DEFAULT NULL,
  `medical_offices_id` int(11) NOT NULL,
  PRIMARY KEY (`id`),
  KEY `fk_schedule_intervals_restrictions_medical_offices1_idx` (`medical_offices_id`),
  CONSTRAINT `fk_schedule_intervals_restrictions_medical_offices1` FOREIGN KEY (`medical_offices_id`) REFERENCES `medical_offices` (`id`) ON DELETE NO ACTION ON UPDATE NO ACTION
) ENGINE=InnoDB DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `medical_office_restrictions`
--

LOCK TABLES `medical_office_restrictions` WRITE;
/*!40000 ALTER TABLE `medical_office_restrictions` DISABLE KEYS */;
/*!40000 ALTER TABLE `medical_office_restrictions` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `medical_offices`
--

DROP TABLE IF EXISTS `medical_offices`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `medical_offices` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `code` varchar(10) NOT NULL,
  `name` varchar(45) NOT NULL,
  `description` varchar(255) NOT NULL,
  `created` datetime NOT NULL,
  `modified` datetime NOT NULL,
  `state` int(1) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=15 DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `medical_offices`
--

LOCK TABLES `medical_offices` WRITE;
/*!40000 ALTER TABLE `medical_offices` DISABLE KEYS */;
INSERT INTO `medical_offices` VALUES (7,'1001','Consultorio 1','Consultorio 1','0000-00-00 00:00:00','0000-00-00 00:00:00',1),(9,'1002','Consultorio 2','Consultorio 2','0000-00-00 00:00:00','0000-00-00 00:00:00',1),(10,'1003','Consultorio 3','Consultorio 3','0000-00-00 00:00:00','0000-00-00 00:00:00',1),(13,'1004','Consultorio 4','Consultorio 4','0000-00-00 00:00:00','0000-00-00 00:00:00',1),(14,'1005','Consultorio 5','Consultorio 5','0000-00-00 00:00:00','0000-00-00 00:00:00',1);
/*!40000 ALTER TABLE `medical_offices` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `municipalities`
--

DROP TABLE IF EXISTS `municipalities`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `municipalities` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `municipality` varchar(100) NOT NULL,
  `department_id` int(11) NOT NULL,
  PRIMARY KEY (`id`),
  KEY `fk_municipalities_departments1_idx` (`department_id`),
  CONSTRAINT `fk_municipalities_departments1` FOREIGN KEY (`department_id`) REFERENCES `departments` (`id`) ON DELETE CASCADE ON UPDATE CASCADE
) ENGINE=InnoDB AUTO_INCREMENT=1123 DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `municipalities`
--

LOCK TABLES `municipalities` WRITE;
/*!40000 ALTER TABLE `municipalities` DISABLE KEYS */;
INSERT INTO `municipalities` VALUES (1,'Medellín',1),(2,'Abejorral',1),(3,'Abriaquí',1),(4,'Alejandría',1),(5,'Amagá',1),(6,'Amalfi',1),(7,'Andes',1),(8,'Angelópolis',1),(9,'Angostura',1),(10,'Anorí',1),(11,'Santa Fé De Antioquia',1),(12,'Anzá',1),(13,'Apartadó',1),(14,'Arboletes',1),(15,'Argelia',1),(16,'Armenia',1),(17,'Barbosa',1),(18,'Belmira',1),(19,'Bello',1),(20,'Betania',1),(21,'Betulia',1),(22,'Ciudad Bolívar',1),(23,'Briceño',1),(24,'Buriticá',1),(25,'Cáceres',1),(26,'Caicedo',1),(27,'Caldas',1),(28,'Campamento',1),(29,'Cañasgordas',1),(30,'Caracolí',1),(31,'Caramanta',1),(32,'Carepa',1),(33,'El Carmen De Viboral',1),(34,'Carolina',1),(35,'Caucasia',1),(36,'Chigorodó',1),(37,'Cisneros',1),(38,'Cocorná',1),(39,'Concepción',1),(40,'Concordia',1),(41,'Copacabana',1),(42,'Dabeiba',1),(43,'Donmatías',1),(44,'Ebéjico',1),(45,'El Bagre',1),(46,'Entrerríos',1),(47,'Envigado',1),(48,'Fredonia',1),(49,'Frontino',1),(50,'Giraldo',1),(51,'Girardota',1),(52,'Gómez Plata',1),(53,'Granada',1),(54,'Guadalupe',1),(55,'Guarne',1),(56,'Guatapé',1),(57,'Heliconia',1),(58,'Hispania',1),(59,'Itagüí',1),(60,'Ituango',1),(61,'Jardín',1),(62,'Jericó',1),(63,'La Ceja',1),(64,'La Estrella',1),(65,'La Pintada',1),(66,'La Unión',1),(67,'Liborina',1),(68,'Maceo',1),(69,'Marinilla',1),(70,'Montebello',1),(71,'Murindó',1),(72,'Mutatá',1),(73,'Nariño',1),(74,'Necoclí',1),(75,'Nechí',1),(76,'Olaya',1),(77,'Peñol',1),(78,'Peque',1),(79,'Pueblorrico',1),(80,'Puerto Berrío',1),(81,'Puerto Nare',1),(82,'Puerto Triunfo',1),(83,'Remedios',1),(84,'Retiro',1),(85,'Rionegro',1),(86,'Sabanalarga',1),(87,'Sabaneta',1),(88,'Salgar',1),(89,'San Andrés De Cuerquía',1),(90,'San Carlos',1),(91,'San Francisco',1),(92,'San Jerónimo',1),(93,'San José De La Montaña',1),(94,'San Juan De Urabá',1),(95,'San Luis',1),(96,'San Pedro De Los Milagros',1),(97,'San Pedro De Urabá',1),(98,'San Rafael',1),(99,'San Roque',1),(100,'San Vicente Ferrer',1),(101,'Santa Bárbara',1),(102,'Santa Rosa De Osos',1),(103,'Santo Domingo',1),(104,'El Santuario',1),(105,'Segovia',1),(106,'Sonsón',1),(107,'Sopetrán',1),(108,'Támesis',1),(109,'Tarazá',1),(110,'Tarso',1),(111,'Titiribí',1),(112,'Toledo',1),(113,'Turbo',1),(114,'Uramita',1),(115,'Urrao',1),(116,'Valdivia',1),(117,'Valparaíso',1),(118,'Vegachí',1),(119,'Venecia',1),(120,'Vigía Del Fuerte',1),(121,'Yalí',1),(122,'Yarumal',1),(123,'Yolombó',1),(124,'Yondó',1),(125,'Zaragoza',1),(126,'Barranquilla',2),(127,'Baranoa',2),(128,'Campo De La Cruz',2),(129,'Candelaria',2),(130,'Galapa',2),(131,'Juan De Acosta',2),(132,'Luruaco',2),(133,'Malambo',2),(134,'Manatí',2),(135,'Palmar De Varela',2),(136,'Piojó',2),(137,'Polonuevo',2),(138,'Ponedera',2),(139,'Puerto Colombia',2),(140,'Repelón',2),(141,'Sabanagrande',2),(142,'Sabanalarga',2),(143,'Santa Lucía',2),(144,'Santo Tomás',2),(145,'Soledad',2),(146,'Suan',2),(147,'Tubará',2),(148,'Usiacurí',2),(149,'Bogotá, D.C.',3),(150,'Cartagena De Indias',4),(151,'Achí',4),(152,'Altos Del Rosario',4),(153,'Arenal',4),(154,'Arjona',4),(155,'Arroyohondo',4),(156,'Barranco De Loba',4),(157,'Calamar',4),(158,'Cantagallo',4),(159,'Cicuco',4),(160,'Córdoba',4),(161,'Clemencia',4),(162,'El Carmen De Bolívar',4),(163,'El Guamo',4),(164,'El Peñón',4),(165,'Hatillo De Loba',4),(166,'Magangué',4),(167,'Mahates',4),(168,'Margarita',4),(169,'María La Baja',4),(170,'Montecristo',4),(171,'Mompós',4),(172,'Morales',4),(173,'Norosí',4),(174,'Pinillos',4),(175,'Regidor',4),(176,'Río Viejo',4),(177,'San Cristóbal',4),(178,'San Estanislao',4),(179,'San Fernando',4),(180,'San Jacinto',4),(181,'San Jacinto Del Cauca',4),(182,'San Juan Nepomuceno',4),(183,'San Martín De Loba',4),(184,'San Pablo',4),(185,'Santa Catalina',4),(186,'Santa Rosa',4),(187,'Santa Rosa Del Sur',4),(188,'Simití',4),(189,'Soplaviento',4),(190,'Talaigua Nuevo',4),(191,'Tiquisio',4),(192,'Turbaco',4),(193,'Turbaná',4),(194,'Villanueva',4),(195,'Zambrano',4),(196,'Tunja',5),(197,'Almeida',5),(198,'Aquitania',5),(199,'Arcabuco',5),(200,'Belén',5),(201,'Berbeo',5),(202,'Betéitiva',5),(203,'Boavita',5),(204,'Boyacá',5),(205,'Briceño',5),(206,'Buenavista',5),(207,'Busbanzá',5),(208,'Caldas',5),(209,'Campohermoso',5),(210,'Cerinza',5),(211,'Chinavita',5),(212,'Chiquinquirá',5),(213,'Chiscas',5),(214,'Chita',5),(215,'Chitaraque',5),(216,'Chivatá',5),(217,'Ciénega',5),(218,'Cómbita',5),(219,'Coper',5),(220,'Corrales',5),(221,'Covarachía',5),(222,'Cubará',5),(223,'Cucaita',5),(224,'Cuítiva',5),(225,'Chíquiza',5),(226,'Chivor',5),(227,'Duitama',5),(228,'El Cocuy',5),(229,'El Espino',5),(230,'Firavitoba',5),(231,'Floresta',5),(232,'Gachantivá',5),(233,'Gámeza',5),(234,'Garagoa',5),(235,'Guacamayas',5),(236,'Guateque',5),(237,'Guayatá',5),(238,'Güicán',5),(239,'Iza',5),(240,'Jenesano',5),(241,'Jericó',5),(242,'Labranzagrande',5),(243,'La Capilla',5),(244,'La Victoria',5),(245,'La Uvita',5),(246,'Villa De Leyva',5),(247,'Macanal',5),(248,'Maripí',5),(249,'Miraflores',5),(250,'Mongua',5),(251,'Monguí',5),(252,'Moniquirá',5),(253,'Motavita',5),(254,'Muzo',5),(255,'Nobsa',5),(256,'Nuevo Colón',5),(257,'Oicatá',5),(258,'Otanche',5),(259,'Pachavita',5),(260,'Páez',5),(261,'Paipa',5),(262,'Pajarito',5),(263,'Panqueba',5),(264,'Pauna',5),(265,'Paya',5),(266,'Paz De Río',5),(267,'Pesca',5),(268,'Pisba',5),(269,'Puerto Boyacá',5),(270,'Quípama',5),(271,'Ramiriquí',5),(272,'Ráquira',5),(273,'Rondón',5),(274,'Saboyá',5),(275,'Sáchica',5),(276,'Samacá',5),(277,'San Eduardo',5),(278,'San José De Pare',5),(279,'San Luis De Gaceno',5),(280,'San Mateo',5),(281,'San Miguel De Sema',5),(282,'San Pablo De Borbur',5),(283,'Santana',5),(284,'Santa María',5),(285,'Santa Rosa De Viterbo',5),(286,'Santa Sofía',5),(287,'Sativanorte',5),(288,'Sativasur',5),(289,'Siachoque',5),(290,'Soatá',5),(291,'Socotá',5),(292,'Socha',5),(293,'Sogamoso',5),(294,'Somondoco',5),(295,'Sora',5),(296,'Sotaquirá',5),(297,'Soracá',5),(298,'Susacón',5),(299,'Sutamarchán',5),(300,'Sutatenza',5),(301,'Tasco',5),(302,'Tenza',5),(303,'Tibaná',5),(304,'Tibasosa',5),(305,'Tinjacá',5),(306,'Tipacoque',5),(307,'Toca',5),(308,'Togüí',5),(309,'Tópaga',5),(310,'Tota',5),(311,'Tununguá',5),(312,'Turmequé',5),(313,'Tuta',5),(314,'Tutazá',5),(315,'Úmbita',5),(316,'Ventaquemada',5),(317,'Viracachá',5),(318,'Zetaquira',5),(319,'Manizales',6),(320,'Aguadas',6),(321,'Anserma',6),(322,'Aranzazu',6),(323,'Belalcázar',6),(324,'Chinchiná',6),(325,'Filadelfia',6),(326,'La Dorada',6),(327,'La Merced',6),(328,'Manzanares',6),(329,'Marmato',6),(330,'Marquetalia',6),(331,'Marulanda',6),(332,'Neira',6),(333,'Norcasia',6),(334,'Pácora',6),(335,'Palestina',6),(336,'Pensilvania',6),(337,'Riosucio',6),(338,'Risaralda',6),(339,'Salamina',6),(340,'Samaná',6),(341,'San José',6),(342,'Supía',6),(343,'Victoria',6),(344,'Villamaría',6),(345,'Viterbo',6),(346,'Florencia',7),(347,'Albania',7),(348,'Belén De Los Andaquíes',7),(349,'Cartagena Del Chairá',7),(350,'Curillo',7),(351,'El Doncello',7),(352,'El Paujíl',7),(353,'La Montañita',7),(354,'Milán',7),(355,'Morelia',7),(356,'Puerto Rico',7),(357,'San José Del Fragua',7),(358,'San Vicente Del Caguán',7),(359,'Solano',7),(360,'Solita',7),(361,'Valparaíso',7),(362,'Popayán',8),(363,'Almaguer',8),(364,'Argelia',8),(365,'Balboa',8),(366,'Bolívar',8),(367,'Buenos Aires',8),(368,'Cajibío',8),(369,'Caldono',8),(370,'Caloto',8),(371,'Corinto',8),(372,'El Tambo',8),(373,'Florencia',8),(374,'Guachené',8),(375,'Guapí',8),(376,'Inzá',8),(377,'Jambaló',8),(378,'La Sierra',8),(379,'La Vega',8),(380,'López De Micay',8),(381,'Mercaderes',8),(382,'Miranda',8),(383,'Morales',8),(384,'Padilla',8),(385,'Páez',8),(386,'Patía',8),(387,'Piamonte',8),(388,'Piendamó',8),(389,'Puerto Tejada',8),(390,'Puracé',8),(391,'Rosas',8),(392,'San Sebastián',8),(393,'Santander De Quilichao',8),(394,'Santa Rosa',8),(395,'Silvia',8),(396,'Sotara',8),(397,'Suárez',8),(398,'Sucre',8),(399,'Timbío',8),(400,'Timbiquí',8),(401,'Toribío',8),(402,'Totoró',8),(403,'Villa Rica',8),(404,'Valledupar',9),(405,'Aguachica',9),(406,'Agustín Codazzi',9),(407,'Astrea',9),(408,'Becerril',9),(409,'Bosconia',9),(410,'Chimichagua',9),(411,'Chiriguaná',9),(412,'Curumaní',9),(413,'El Copey',9),(414,'El Paso',9),(415,'Gamarra',9),(416,'González',9),(417,'La Gloria',9),(418,'La Jagua De Ibirico',9),(419,'Manaure Balcón Del Cesar',9),(420,'Pailitas',9),(421,'Pelaya',9),(422,'Pueblo Bello',9),(423,'Río De Oro',9),(424,'La Paz',9),(425,'San Alberto',9),(426,'San Diego',9),(427,'San Martín',9),(428,'Tamalameque',9),(429,'Montería',10),(430,'Ayapel',10),(431,'Buenavista',10),(432,'Canalete',10),(433,'Cereté',10),(434,'Chimá',10),(435,'Chinú',10),(436,'Ciénaga De Oro',10),(437,'Cotorra',10),(438,'La Apartada',10),(439,'Lorica',10),(440,'Los Córdobas',10),(441,'Momil',10),(442,'Montelíbano',10),(443,'Moñitos',10),(444,'Planeta Rica',10),(445,'Pueblo Nuevo',10),(446,'Puerto Escondido',10),(447,'Puerto Libertador',10),(448,'Purísima De La Concepción',10),(449,'Sahagún',10),(450,'San Andrés De Sotavento',10),(451,'San Antero',10),(452,'San Bernardo Del Viento',10),(453,'San Carlos',10),(454,'San José De Uré',10),(455,'San Pelayo',10),(456,'Tierralta',10),(457,'Tuchín',10),(458,'Valencia',10),(459,'Agua De Dios',11),(460,'Albán',11),(461,'Anapoima',11),(462,'Anolaima',11),(463,'Arbeláez',11),(464,'Beltrán',11),(465,'Bituima',11),(466,'Bojacá',11),(467,'Cabrera',11),(468,'Cachipay',11),(469,'Cajicá',11),(470,'Caparrapí',11),(471,'Cáqueza',11),(472,'Carmen De Carupa',11),(473,'Chaguaní',11),(474,'Chía',11),(475,'Chipaque',11),(476,'Choachí',11),(477,'Chocontá',11),(478,'Cogua',11),(479,'Cota',11),(480,'Cucunubá',11),(481,'El Colegio',11),(482,'El Peñón',11),(483,'El Rosal',11),(484,'Facatativá',11),(485,'Fómeque',11),(486,'Fosca',11),(487,'Funza',11),(488,'Fúquene',11),(489,'Fusagasugá',11),(490,'Gachalá',11),(491,'Gachancipá',11),(492,'Gachetá',11),(493,'Gama',11),(494,'Girardot',11),(495,'Granada',11),(496,'Guachetá',11),(497,'Guaduas',11),(498,'Guasca',11),(499,'Guataquí',11),(500,'Guatavita',11),(501,'Guayabal De Síquima',11),(502,'Guayabetal',11),(503,'Gutiérrez',11),(504,'Jerusalén',11),(505,'Junín',11),(506,'La Calera',11),(507,'La Mesa',11),(508,'La Palma',11),(509,'La Peña',11),(510,'La Vega',11),(511,'Lenguazaque',11),(512,'Machetá',11),(513,'Madrid',11),(514,'Manta',11),(515,'Medina',11),(516,'Mosquera',11),(517,'Nariño',11),(518,'Nemocón',11),(519,'Nilo',11),(520,'Nimaima',11),(521,'Nocaima',11),(522,'Venecia',11),(523,'Pacho',11),(524,'Paime',11),(525,'Pandi',11),(526,'Paratebueno',11),(527,'Pasca',11),(528,'Puerto Salgar',11),(529,'Pulí',11),(530,'Quebradanegra',11),(531,'Quetame',11),(532,'Quipile',11),(533,'Apulo',11),(534,'Ricaurte',11),(535,'San Antonio Del Tequendama',11),(536,'San Bernardo',11),(537,'San Cayetano',11),(538,'San Francisco',11),(539,'San Juan De Rioseco',11),(540,'Sasaima',11),(541,'Sesquilé',11),(542,'Sibaté',11),(543,'Silvania',11),(544,'Simijaca',11),(545,'Soacha',11),(546,'Sopó',11),(547,'Subachoque',11),(548,'Suesca',11),(549,'Supatá',11),(550,'Susa',11),(551,'Sutatausa',11),(552,'Tabio',11),(553,'Tausa',11),(554,'Tena',11),(555,'Tenjo',11),(556,'Tibacuy',11),(557,'Tibirita',11),(558,'Tocaima',11),(559,'Tocancipá',11),(560,'Topaipí',11),(561,'Ubalá',11),(562,'Ubaque',11),(563,'Villa De San Diego De Ubaté',11),(564,'Une',11),(565,'Útica',11),(566,'Vergara',11),(567,'Vianí',11),(568,'Villagómez',11),(569,'Villapinzón',11),(570,'Villeta',11),(571,'Viotá',11),(572,'Yacopí',11),(573,'Zipacón',11),(574,'Zipaquirá',11),(575,'Quibdó',12),(576,'Acandí',12),(577,'Alto Baudó',12),(578,'Atrato',12),(579,'Bagadó',12),(580,'Bahía Solano',12),(581,'Bajo Baudó',12),(582,'Bojayá',12),(583,'El Cantón Del San Pablo',12),(584,'Carmen Del Darién',12),(585,'Cértegui',12),(586,'Condoto',12),(587,'El Carmen De Atrato',12),(588,'El Litoral Del San Juan',12),(589,'Istmina',12),(590,'Juradó',12),(591,'Lloró',12),(592,'Medio Atrato',12),(593,'Medio Baudó',12),(594,'Medio San Juan',12),(595,'Nóvita',12),(596,'Nuquí',12),(597,'Río Iró',12),(598,'Río Quito',12),(599,'Riosucio',12),(600,'San José Del Palmar',12),(601,'Sipí',12),(602,'Tadó',12),(603,'Unguía',12),(604,'Unión Panamericana',12),(605,'Neiva',13),(606,'Acevedo',13),(607,'Agrado',13),(608,'Aipe',13),(609,'Algeciras',13),(610,'Altamira',13),(611,'Baraya',13),(612,'Campoalegre',13),(613,'Colombia',13),(614,'Elías',13),(615,'Garzón',13),(616,'Gigante',13),(617,'Guadalupe',13),(618,'Hobo',13),(619,'Íquira',13),(620,'Isnos',13),(621,'La Argentina',13),(622,'La Plata',13),(623,'Nátaga',13),(624,'Oporapa',13),(625,'Paicol',13),(626,'Palermo',13),(627,'Palestina',13),(628,'Pital',13),(629,'Pitalito',13),(630,'Rivera',13),(631,'Saladoblanco',13),(632,'San Agustín',13),(633,'Santa María',13),(634,'Suaza',13),(635,'Tarqui',13),(636,'Tesalia',13),(637,'Tello',13),(638,'Teruel',13),(639,'Timaná',13),(640,'Villavieja',13),(641,'Yaguará',13),(642,'Riohacha',14),(643,'Albania',14),(644,'Barrancas',14),(645,'Dibulla',14),(646,'Distracción',14),(647,'El Molino',14),(648,'Fonseca',14),(649,'Hatonuevo',14),(650,'La Jagua Del Pilar',14),(651,'Maicao',14),(652,'Manaure',14),(653,'San Juan Del Cesar',14),(654,'Uribia',14),(655,'Urumita',14),(656,'Villanueva',14),(657,'Santa Marta',15),(658,'Algarrobo',15),(659,'Aracataca',15),(660,'Ariguaní',15),(661,'Cerro De San Antonio',15),(662,'Chivolo',15),(663,'Ciénaga',15),(664,'Concordia',15),(665,'El Banco',15),(666,'El Piñón',15),(667,'El Retén',15),(668,'Fundación',15),(669,'Guamal',15),(670,'Nueva Granada',15),(671,'Pedraza',15),(672,'Pijiño Del Carmen',15),(673,'Pivijay',15),(674,'Plato',15),(675,'Puebloviejo',15),(676,'Remolino',15),(677,'Sabanas De San Ángel',15),(678,'Salamina',15),(679,'San Sebastián De Buenavista',15),(680,'San Zenón',15),(681,'Santa Ana',15),(682,'Santa Bárbara De Pinto',15),(683,'Sitionuevo',15),(684,'Tenerife',15),(685,'Zapayán',15),(686,'Zona Bananera',15),(687,'Villavicencio',16),(688,'Acacías',16),(689,'Barranca De Upía',16),(690,'Cabuyaro',16),(691,'Castilla La Nueva',16),(692,'San Luis De Cubarral',16),(693,'Cumaral',16),(694,'El Calvario',16),(695,'El Castillo',16),(696,'El Dorado',16),(697,'Fuente De Oro',16),(698,'Granada',16),(699,'Guamal',16),(700,'Mapiripán',16),(701,'Mesetas',16),(702,'La Macarena',16),(703,'Uribe',16),(704,'Lejanías',16),(705,'Puerto Concordia',16),(706,'Puerto Gaitán',16),(707,'Puerto López',16),(708,'Puerto Lleras',16),(709,'Puerto Rico',16),(710,'Restrepo',16),(711,'San Carlos De Guaroa',16),(712,'San Juan De Arama',16),(713,'San Juanito',16),(714,'San Martín',16),(715,'Vistahermosa',16),(716,'Pasto',17),(717,'Albán',17),(718,'Aldana',17),(719,'Ancuyá',17),(720,'Arboleda',17),(721,'Barbacoas',17),(722,'Belén',17),(723,'Buesaco',17),(724,'Colón',17),(725,'Consacá',17),(726,'Contadero',17),(727,'Córdoba',17),(728,'Cuaspúd',17),(729,'Cumbal',17),(730,'Cumbitara',17),(731,'Chachagüí',17),(732,'El Charco',17),(733,'El Peñol',17),(734,'El Rosario',17),(735,'El Tablón De Gómez',17),(736,'El Tambo',17),(737,'Funes',17),(738,'Guachucal',17),(739,'Guaitarilla',17),(740,'Gualmatán',17),(741,'Iles',17),(742,'Imués',17),(743,'Ipiales',17),(744,'La Cruz',17),(745,'La Florida',17),(746,'La Llanada',17),(747,'La Tola',17),(748,'La Unión',17),(749,'Leiva',17),(750,'Linares',17),(751,'Los Andes',17),(752,'Magüí',17),(753,'Mallama',17),(754,'Mosquera',17),(755,'Nariño',17),(756,'Olaya Herrera',17),(757,'Ospina',17),(758,'Francisco Pizarro',17),(759,'Policarpa',17),(760,'Potosí',17),(761,'Providencia',17),(762,'Puerres',17),(763,'Pupiales',17),(764,'Ricaurte',17),(765,'Roberto Payán',17),(766,'Samaniego',17),(767,'Sandoná',17),(768,'San Bernardo',17),(769,'San Lorenzo',17),(770,'San Pablo',17),(771,'San Pedro De Cartago',17),(772,'Santa Bárbara',17),(773,'Santacruz',17),(774,'Sapuyes',17),(775,'Taminango',17),(776,'Tangua',17),(777,'San Andrés De Tumaco',17),(778,'Túquerres',17),(779,'Yacuanquer',17),(780,'Cúcuta',18),(781,'Ábrego',18),(782,'Arboledas',18),(783,'Bochalema',18),(784,'Bucarasica',18),(785,'Cácota',18),(786,'Cáchira',18),(787,'Chinácota',18),(788,'Chitagá',18),(789,'Convención',18),(790,'Cucutilla',18),(791,'Durania',18),(792,'El Carmen',18),(793,'El Tarra',18),(794,'El Zulia',18),(795,'Gramalote',18),(796,'Hacarí',18),(797,'Herrán',18),(798,'Labateca',18),(799,'La Esperanza',18),(800,'La Playa',18),(801,'Los Patios',18),(802,'Lourdes',18),(803,'Mutiscua',18),(804,'Ocaña',18),(805,'Pamplona',18),(806,'Pamplonita',18),(807,'Puerto Santander',18),(808,'Ragonvalia',18),(809,'Salazar',18),(810,'San Calixto',18),(811,'San Cayetano',18),(812,'Santiago',18),(813,'Sardinata',18),(814,'Silos',18),(815,'Teorama',18),(816,'Tibú',18),(817,'Toledo',18),(818,'Villa Caro',18),(819,'Villa Del Rosario',18),(820,'Armenia',19),(821,'Buenavista',19),(822,'Calarcá',19),(823,'Circasia',19),(824,'Córdoba',19),(825,'Filandia',19),(826,'Génova',19),(827,'La Tebaida',19),(828,'Montenegro',19),(829,'Pijao',19),(830,'Quimbaya',19),(831,'Salento',19),(832,'Pereira',20),(833,'Apía',20),(834,'Balboa',20),(835,'Belén De Umbría',20),(836,'Dosquebradas',20),(837,'Guática',20),(838,'La Celia',20),(839,'La Virginia',20),(840,'Marsella',20),(841,'Mistrató',20),(842,'Pueblo Rico',20),(843,'Quinchía',20),(844,'Santa Rosa De Cabal',20),(845,'Santuario',20),(846,'Bucaramanga',21),(847,'Aguada',21),(848,'Albania',21),(849,'Aratoca',21),(850,'Barbosa',21),(851,'Barichara',21),(852,'Barrancabermeja',21),(853,'Betulia',21),(854,'Bolívar',21),(855,'Cabrera',21),(856,'California',21),(857,'Capitanejo',21),(858,'Carcasí',21),(859,'Cepitá',21),(860,'Cerrito',21),(861,'Charalá',21),(862,'Charta',21),(863,'Chima',21),(864,'Chipatá',21),(865,'Cimitarra',21),(866,'Concepción',21),(867,'Confines',21),(868,'Contratación',21),(869,'Coromoro',21),(870,'Curití',21),(871,'El Carmen De Chucurí',21),(872,'El Guacamayo',21),(873,'El Peñón',21),(874,'El Playón',21),(875,'Encino',21),(876,'Enciso',21),(877,'Florián',21),(878,'Floridablanca',21),(879,'Galán',21),(880,'Gámbita',21),(881,'Girón',21),(882,'Guaca',21),(883,'Guadalupe',21),(884,'Guapotá',21),(885,'Guavatá',21),(886,'Güepsa',21),(887,'Hato',21),(888,'Jesús María',21),(889,'Jordán',21),(890,'La Belleza',21),(891,'Landázuri',21),(892,'La Paz',21),(893,'Lebrija',21),(894,'Los Santos',21),(895,'Macaravita',21),(896,'Málaga',21),(897,'Matanza',21),(898,'Mogotes',21),(899,'Molagavita',21),(900,'Ocamonte',21),(901,'Oiba',21),(902,'Onzaga',21),(903,'Palmar',21),(904,'Palmas Del Socorro',21),(905,'Páramo',21),(906,'Piedecuesta',21),(907,'Pinchote',21),(908,'Puente Nacional',21),(909,'Puerto Parra',21),(910,'Puerto Wilches',21),(911,'Rionegro',21),(912,'Sabana De Torres',21),(913,'San Andrés',21),(914,'San Benito',21),(915,'San Gil',21),(916,'San Joaquín',21),(917,'San José De Miranda',21),(918,'San Miguel',21),(919,'San Vicente De Chucurí',21),(920,'Santa Bárbara',21),(921,'Santa Helena Del Opón',21),(922,'Simacota',21),(923,'Socorro',21),(924,'Suaita',21),(925,'Sucre',21),(926,'Suratá',21),(927,'Tona',21),(928,'Valle De San José',21),(929,'Vélez',21),(930,'Vetas',21),(931,'Villanueva',21),(932,'Zapatoca',21),(933,'Sincelejo',22),(934,'Buenavista',22),(935,'Caimito',22),(936,'Coloso',22),(937,'Corozal',22),(938,'Coveñas',22),(939,'Chalán',22),(940,'El Roble',22),(941,'Galeras',22),(942,'Guaranda',22),(943,'La Unión',22),(944,'Los Palmitos',22),(945,'Majagual',22),(946,'Morroa',22),(947,'Ovejas',22),(948,'Palmito',22),(949,'Sampués',22),(950,'San Benito Abad',22),(951,'San Juan De Betulia',22),(952,'San Marcos',22),(953,'San Onofre',22),(954,'San Pedro',22),(955,'San Luis De Sincé',22),(956,'Sucre',22),(957,'Santiago De Tolú',22),(958,'Tolú Viejo',22),(959,'Ibagué',23),(960,'Alpujarra',23),(961,'Alvarado',23),(962,'Ambalema',23),(963,'Anzoátegui',23),(964,'Armero Guayabal',23),(965,'Ataco',23),(966,'Cajamarca',23),(967,'Carmen De Apicalá',23),(968,'Casabianca',23),(969,'Chaparral',23),(970,'Coello',23),(971,'Coyaima',23),(972,'Cunday',23),(973,'Dolores',23),(974,'Espinal',23),(975,'Falan',23),(976,'Flandes',23),(977,'Fresno',23),(978,'Guamo',23),(979,'Herveo',23),(980,'Honda',23),(981,'Icononzo',23),(982,'Lérida',23),(983,'Líbano',23),(984,'San Sebastián De Mariquita',23),(985,'Melgar',23),(986,'Murillo',23),(987,'Natagaima',23),(988,'Ortega',23),(989,'Palocabildo',23),(990,'Piedras',23),(991,'Planadas',23),(992,'Prado',23),(993,'Purificación',23),(994,'Rioblanco',23),(995,'Roncesvalles',23),(996,'Rovira',23),(997,'Saldaña',23),(998,'San Antonio',23),(999,'San Luis',23),(1000,'Santa Isabel',23),(1001,'Suárez',23),(1002,'Valle De San Juan',23),(1003,'Venadillo',23),(1004,'Villahermosa',23),(1005,'Villarrica',23),(1006,'Cali',24),(1007,'Alcalá',24),(1008,'Andalucía',24),(1009,'Ansermanuevo',24),(1010,'Argelia',24),(1011,'Bolívar',24),(1012,'Buenaventura',24),(1013,'Guadalajara De Buga',24),(1014,'Bugalagrande',24),(1015,'Caicedonia',24),(1016,'Calima',24),(1017,'Candelaria',24),(1018,'Cartago',24),(1019,'Dagua',24),(1020,'El Águila',24),(1021,'El Cairo',24),(1022,'El Cerrito',24),(1023,'El Dovio',24),(1024,'Florida',24),(1025,'Ginebra',24),(1026,'Guacarí',24),(1027,'Jamundí',24),(1028,'La Cumbre',24),(1029,'La Unión',24),(1030,'La Victoria',24),(1031,'Obando',24),(1032,'Palmira',24),(1033,'Pradera',24),(1034,'Restrepo',24),(1035,'Riofrío',24),(1036,'Roldanillo',24),(1037,'San Pedro',24),(1038,'Sevilla',24),(1039,'Toro',24),(1040,'Trujillo',24),(1041,'Tuluá',24),(1042,'Ulloa',24),(1043,'Versalles',24),(1044,'Vijes',24),(1045,'Yotoco',24),(1046,'Yumbo',24),(1047,'Zarzal',24),(1048,'Arauca',25),(1049,'Arauquita',25),(1050,'Cravo Norte',25),(1051,'Fortul',25),(1052,'Puerto Rondón',25),(1053,'Saravena',25),(1054,'Tame',25),(1055,'Yopal',26),(1056,'Aguazul',26),(1057,'Chámeza',26),(1058,'Hato Corozal',26),(1059,'La Salina',26),(1060,'Maní',26),(1061,'Monterrey',26),(1062,'Nunchía',26),(1063,'Orocué',26),(1064,'Paz De Ariporo',26),(1065,'Pore',26),(1066,'Recetor',26),(1067,'Sabanalarga',26),(1068,'Sácama',26),(1069,'San Luis De Palenque',26),(1070,'Támara',26),(1071,'Tauramena',26),(1072,'Trinidad',26),(1073,'Villanueva',26),(1074,'Mocoa',27),(1075,'Colón',27),(1076,'Orito',27),(1077,'Puerto Asís',27),(1078,'Puerto Caicedo',27),(1079,'Puerto Guzmán',27),(1080,'Puerto Leguízamo',27),(1081,'Sibundoy',27),(1082,'San Francisco',27),(1083,'San Miguel',27),(1084,'Santiago',27),(1085,'Valle Del Guamuez',27),(1086,'Villagarzón',27),(1087,'San Andrés',28),(1088,'Providencia',28),(1089,'Leticia',29),(1090,'El Encanto',29),(1091,'La Chorrera',29),(1092,'La Pedrera',29),(1093,'La Victoria',29),(1094,'Mirití - Paraná',29),(1095,'Puerto Alegría',29),(1096,'Puerto Arica',29),(1097,'Puerto Nariño',29),(1098,'Puerto Santander',29),(1099,'Tarapacá',29),(1100,'Inírida',30),(1101,'Barranco Minas',30),(1102,'Mapiripana',30),(1103,'San Felipe',30),(1104,'Puerto Colombia',30),(1105,'La Guadalupe',30),(1106,'Cacahual',30),(1107,'Pana Pana',30),(1108,'Morichal',30),(1109,'San José Del Guaviare',31),(1110,'Calamar',31),(1111,'El Retorno',31),(1112,'Miraflores',31),(1113,'Mitú',32),(1114,'Carurú',32),(1115,'Pacoa',32),(1116,'Taraira',32),(1117,'Papunaua',32),(1118,'Yavaraté',32),(1119,'Puerto Carreño',33),(1120,'a Primavera',33),(1121,'anta Rosalía',33),(1122,'Cumaribo',33);
/*!40000 ALTER TABLE `municipalities` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `order_details`
--

DROP TABLE IF EXISTS `order_details`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `order_details` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `subtotal` decimal(10,2) DEFAULT NULL,
  `validator` varchar(45) DEFAULT NULL,
  `coopago` int(11) DEFAULT NULL,
  `total` decimal(10,2) DEFAULT NULL COMMENT '								',
  `created` datetime DEFAULT NULL COMMENT 'fecha de solicitud de cita',
  `modified` datetime DEFAULT NULL,
  `observations` varchar(255) DEFAULT NULL,
  `calculated_age` varchar(11) DEFAULT NULL,
  `courtesy` decimal(10,2) DEFAULT NULL,
  `discount` decimal(10,2) DEFAULT NULL,
  `particular_ payout` decimal(10,2) DEFAULT NULL COMMENT '	',
  `clients_id` int(11) NOT NULL,
  `rates_id` int(11) NOT NULL,
  `users_id` int(11) NOT NULL,
  `patients_id` int(11) NOT NULL,
  `external_specialists_id` int(11) NOT NULL,
  `service_type_id` int(11) NOT NULL,
  `order_types_id` int(11) NOT NULL,
  `centers_id` int(11) NOT NULL,
  PRIMARY KEY (`id`),
  KEY `fk_request_appointments_clients1_idx` (`clients_id`),
  KEY `fk_request_appointments_rates1_idx` (`rates_id`),
  KEY `fk_request_appointments_users1_idx` (`users_id`),
  KEY `fk_request_appointments_patients1_idx` (`patients_id`),
  KEY `fk_order_details_external_specialists1_idx` (`external_specialists_id`),
  KEY `fk_order_details_service_type1_idx` (`service_type_id`),
  KEY `fk_order_details_order_types1_idx` (`order_types_id`),
  KEY `fk_order_details_centers1_idx` (`centers_id`),
  CONSTRAINT `fk_order_details_centers1` FOREIGN KEY (`centers_id`) REFERENCES `centers` (`id`) ON DELETE CASCADE ON UPDATE CASCADE,
  CONSTRAINT `fk_order_details_external_specialists1` FOREIGN KEY (`external_specialists_id`) REFERENCES `external_specialists` (`id`) ON DELETE CASCADE ON UPDATE CASCADE,
  CONSTRAINT `fk_order_details_order_types1` FOREIGN KEY (`order_types_id`) REFERENCES `order_types` (`id`) ON DELETE CASCADE ON UPDATE CASCADE,
  CONSTRAINT `fk_order_details_service_type1` FOREIGN KEY (`service_type_id`) REFERENCES `service_types` (`id`) ON DELETE CASCADE ON UPDATE CASCADE,
  CONSTRAINT `fk_request_appointments_clients1` FOREIGN KEY (`clients_id`) REFERENCES `clients` (`id`) ON DELETE CASCADE ON UPDATE CASCADE,
  CONSTRAINT `fk_request_appointments_patients1` FOREIGN KEY (`patients_id`) REFERENCES `patients` (`id`) ON DELETE CASCADE ON UPDATE CASCADE,
  CONSTRAINT `fk_request_appointments_rates1` FOREIGN KEY (`rates_id`) REFERENCES `rates` (`id`) ON DELETE CASCADE ON UPDATE CASCADE,
  CONSTRAINT `fk_request_appointments_users1` FOREIGN KEY (`users_id`) REFERENCES `users` (`id`) ON DELETE CASCADE ON UPDATE CASCADE
) ENGINE=InnoDB AUTO_INCREMENT=27 DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `order_details`
--

LOCK TABLES `order_details` WRITE;
/*!40000 ALTER TABLE `order_details` DISABLE KEYS */;
INSERT INTO `order_details` VALUES (12,0.00,'',0,0.00,'2016-06-24 10:02:03','2016-06-24 10:02:03','','',0.00,0.00,NULL,1,1,1,1,1,1,1,0),(13,0.00,'',0,0.00,'2016-06-24 10:02:14','2016-06-24 10:02:14','','',0.00,0.00,NULL,1,1,1,1,1,1,1,0),(14,0.00,'',0,0.00,'2016-06-24 10:02:19','2016-06-24 10:02:19','','',0.00,0.00,NULL,1,1,1,1,1,1,1,0),(15,0.00,'',0,0.00,'2016-06-24 10:02:32','2016-06-24 10:02:32','','',0.00,0.00,NULL,1,1,1,1,1,1,1,0),(16,0.00,'',0,0.00,'2016-06-24 10:02:37','2016-06-24 10:02:37','','',0.00,0.00,NULL,1,1,1,1,1,1,1,0),(17,0.00,'',0,0.00,'2016-06-24 10:02:56','2016-06-24 10:02:56','','',0.00,0.00,NULL,1,1,1,1,1,1,1,0),(18,0.00,'',0,0.00,'2016-06-24 10:02:58','2016-06-24 10:02:58','','',0.00,0.00,NULL,1,1,1,1,1,1,1,0),(19,0.00,'',0,0.00,'2016-06-24 10:03:28','2016-06-24 10:03:28','','',0.00,0.00,NULL,1,1,1,1,1,1,1,0),(20,0.00,'',0,0.00,'2016-06-24 10:05:30','2016-06-24 10:05:30','','',0.00,0.00,NULL,1,1,1,1,1,1,1,0),(21,0.00,'',0,0.00,'2016-06-24 10:10:09','2016-06-24 10:10:09','','',0.00,0.00,NULL,1,1,1,1,1,1,1,0),(22,0.00,'',0,0.00,'2016-06-24 10:10:25','2016-06-24 10:10:25','','',0.00,0.00,NULL,1,1,1,1,1,1,1,0),(23,0.00,'',0,0.00,'2016-06-24 10:13:54','2016-06-24 10:13:54','','',0.00,0.00,NULL,1,1,1,1,1,1,1,0),(24,0.00,'',0,0.00,'2016-06-24 10:14:27','2016-06-24 10:14:27','','',0.00,0.00,NULL,1,1,1,1,1,1,1,0),(25,0.00,'',0,0.00,'2016-06-24 11:08:59','2016-06-24 11:08:59','','',0.00,0.00,NULL,1,1,1,1,1,1,1,0),(26,0.00,'',0,0.00,'2016-06-24 11:09:08','2016-06-24 11:09:08','','',0.00,0.00,NULL,1,1,1,1,1,1,1,0);
/*!40000 ALTER TABLE `order_details` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `order_states`
--

DROP TABLE IF EXISTS `order_states`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `order_states` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `state` varchar(45) NOT NULL COMMENT '1. created, 2.canceled',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=2 DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `order_states`
--

LOCK TABLES `order_states` WRITE;
/*!40000 ALTER TABLE `order_states` DISABLE KEYS */;
INSERT INTO `order_states` VALUES (1,'creación');
/*!40000 ALTER TABLE `order_states` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `order_types`
--

DROP TABLE IF EXISTS `order_types`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `order_types` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `type` varchar(45) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=7 DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `order_types`
--

LOCK TABLES `order_types` WRITE;
/*!40000 ALTER TABLE `order_types` DISABLE KEYS */;
INSERT INTO `order_types` VALUES (1,'Seleccione una Opciòn'),(2,'Urgencias'),(3,'Hospitalización'),(4,'Unidad Renal'),(5,'Toma de Muestras'),(6,'Consulta Externa');
/*!40000 ALTER TABLE `order_types` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `orders`
--

DROP TABLE IF EXISTS `orders`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `orders` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `order` varchar(20) NOT NULL,
  `created` datetime NOT NULL,
  `modified` datetime NOT NULL,
  `order_details_id` int(11) NOT NULL,
  `users_id` int(11) NOT NULL,
  `order_states_id` int(11) NOT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `order_UNIQUE` (`order`),
  KEY `fk_orders_order_details1_idx` (`order_details_id`),
  KEY `fk_orders_users1_idx` (`users_id`),
  KEY `fk_orders_order_states1_idx` (`order_states_id`),
  CONSTRAINT `fk_orders_order_details1` FOREIGN KEY (`order_details_id`) REFERENCES `order_details` (`id`) ON DELETE CASCADE ON UPDATE CASCADE,
  CONSTRAINT `fk_orders_order_states1` FOREIGN KEY (`order_states_id`) REFERENCES `order_states` (`id`) ON DELETE CASCADE ON UPDATE CASCADE,
  CONSTRAINT `fk_orders_users1` FOREIGN KEY (`users_id`) REFERENCES `users` (`id`) ON DELETE CASCADE ON UPDATE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `orders`
--

LOCK TABLES `orders` WRITE;
/*!40000 ALTER TABLE `orders` DISABLE KEYS */;
/*!40000 ALTER TABLE `orders` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `patients`
--

DROP TABLE IF EXISTS `patients`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `patients` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `people_id` int(11) NOT NULL,
  `users_id` int(11) NOT NULL,
  `created` datetime NOT NULL,
  `modified` datetime NOT NULL,
  `zone_id` int(11) NOT NULL,
  `regimes_id` int(11) NOT NULL,
  `permanent_diagnostic` text,
  PRIMARY KEY (`id`),
  KEY `fk_patients_people1_idx` (`people_id`),
  KEY `fk_patients_users1_idx` (`users_id`),
  KEY `fk_patients_zone1_idx` (`zone_id`),
  KEY `fk_patients_regimes1_idx` (`regimes_id`),
  CONSTRAINT `fk_patients_people1` FOREIGN KEY (`people_id`) REFERENCES `people` (`id`) ON DELETE NO ACTION ON UPDATE NO ACTION,
  CONSTRAINT `fk_patients_regimes1` FOREIGN KEY (`regimes_id`) REFERENCES `regimes` (`id`) ON DELETE CASCADE ON UPDATE CASCADE,
  CONSTRAINT `fk_patients_users1` FOREIGN KEY (`users_id`) REFERENCES `users` (`id`) ON DELETE NO ACTION ON UPDATE NO ACTION,
  CONSTRAINT `fk_patients_zone1` FOREIGN KEY (`zone_id`) REFERENCES `zones` (`id`) ON DELETE CASCADE ON UPDATE CASCADE
) ENGINE=InnoDB AUTO_INCREMENT=2 DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `patients`
--

LOCK TABLES `patients` WRITE;
/*!40000 ALTER TABLE `patients` DISABLE KEYS */;
INSERT INTO `patients` VALUES (1,1,1,'2015-10-10 10:10:10','2015-10-10 10:10:10',1,1,'algo');
/*!40000 ALTER TABLE `patients` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `paydments`
--

DROP TABLE IF EXISTS `paydments`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `paydments` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `users_id` int(11) NOT NULL,
  `paid` decimal(10,2) NOT NULL,
  `debt` decimal(10,2) NOT NULL,
  `date` datetime NOT NULL,
  PRIMARY KEY (`id`),
  KEY `fk_paydments_users1_idx` (`users_id`),
  CONSTRAINT `fk_paydments_users1` FOREIGN KEY (`users_id`) REFERENCES `users` (`id`) ON DELETE CASCADE ON UPDATE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `paydments`
--

LOCK TABLES `paydments` WRITE;
/*!40000 ALTER TABLE `paydments` DISABLE KEYS */;
/*!40000 ALTER TABLE `paydments` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `people`
--

DROP TABLE IF EXISTS `people`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `people` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `document_types_id` int(11) NOT NULL,
  `identification` varchar(45) NOT NULL,
  `first_name` varchar(45) NOT NULL,
  `middle_name` varchar(45) NOT NULL,
  `last_name` varchar(45) NOT NULL,
  `last_name_two` varchar(45) NOT NULL,
  `birthdate` datetime NOT NULL,
  `gender` int(11) DEFAULT NULL,
  `address` varchar(45) DEFAULT NULL,
  `phone` varchar(45) DEFAULT NULL,
  `email` varchar(45) DEFAULT NULL,
  `created` datetime NOT NULL,
  `modified` datetime NOT NULL,
  `municipalities_id` int(11) NOT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `identification_UNIQUE` (`identification`),
  KEY `fk_people_document_types1_idx` (`document_types_id`),
  KEY `fk_people_municipalities1_idx` (`municipalities_id`),
  CONSTRAINT `fk_people_document_types1` FOREIGN KEY (`document_types_id`) REFERENCES `document_types` (`id`) ON DELETE NO ACTION ON UPDATE NO ACTION,
  CONSTRAINT `fk_people_municipalities1` FOREIGN KEY (`municipalities_id`) REFERENCES `municipalities` (`id`) ON DELETE NO ACTION ON UPDATE NO ACTION
) ENGINE=InnoDB AUTO_INCREMENT=3 DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `people`
--

LOCK TABLES `people` WRITE;
/*!40000 ALTER TABLE `people` DISABLE KEYS */;
INSERT INTO `people` VALUES (1,1,'1345678','admin','admin','admin','admin','2016-05-26 13:30:22',1,'add','1234','asd@asd.com','2015-10-10 10:10:10','2015-10-10 10:10:10',76),(2,1,'1324532','Medico ','medico','Espcialista','Especialista','2016-05-26 13:30:22',1,'add','1234','asd@asd.com','2016-05-26 13:30:22','2016-05-26 13:30:22',107);
/*!40000 ALTER TABLE `people` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `permissions`
--

DROP TABLE IF EXISTS `permissions`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `permissions` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `name` varchar(150) NOT NULL,
  `permission_identifier` varchar(255) NOT NULL,
  `description` varchar(255) NOT NULL,
  `created` datetime NOT NULL,
  `modified` datetime NOT NULL,
  `parent_permission_id` int(11) NOT NULL COMMENT 'identificador del permiso padre, si el mismo es padre asignar 0 de lo contrario el numero.',
  `action` varchar(150) NOT NULL,
  `icon` varchar(25) NOT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `name_UNIQUE` (`name`)
) ENGINE=InnoDB AUTO_INCREMENT=13 DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `permissions`
--

LOCK TABLES `permissions` WRITE;
/*!40000 ALTER TABLE `permissions` DISABLE KEYS */;
INSERT INTO `permissions` VALUES (1,'Reportes','reportes','reportes','2016-10-10 10:10:10','2016-10-10 10:10:10',0,'',''),(2,'rips a','rips_a','rips a','2016-10-10 10:10:10','2016-10-10 10:10:10',1,'roles','fa-bomb'),(3,'rips b','rips_b','rips b ','2016-10-10 10:10:10','2016-10-10 10:10:10',1,'',''),(4,'Inventarios','inventarios','inventarios','2016-10-10 10:10:10','2016-10-10 10:10:10',0,'',''),(5,'reporte a','reporte_a','reporte_a','2016-10-10 10:10:10','2016-10-10 10:10:10',4,'',''),(6,'Agenda','agenda','agenda','2016-10-10 10:10:10','2016-10-10 10:10:10',0,'',''),(7,'asignacion citas','asignacion_citas','asignacion','2016-10-10 10:10:10','2016-10-10 10:10:10',6,'',''),(8,'Facturacion','facturacion','facturacion','2016-10-10 10:10:10','2016-10-10 10:10:10',0,'',''),(9,'confirmacion de citas','confirmacion_citas','confirmacion','2016-10-10 10:10:10','2016-10-10 10:10:10',6,'',''),(10,'Asignacion de Citas','asignacion','asignacion','2016-10-10 10:10:10','2016-10-10 10:10:10',6,'agendamientoCita','fa-stethoscope'),(11,'Configuración','Configuración','Configuración','0000-00-00 00:00:00','0000-00-00 00:00:00',0,'',''),(12,'Consultorios','consultorios','consultorios','0000-00-00 00:00:00','0000-00-00 00:00:00',11,'medicalOffices','fa-plus-square');
/*!40000 ALTER TABLE `permissions` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `permissions_roles`
--

DROP TABLE IF EXISTS `permissions_roles`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `permissions_roles` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `permissions_id` int(11) NOT NULL,
  `roles_id` int(11) NOT NULL,
  `created` datetime NOT NULL,
  `modified` datetime NOT NULL,
  PRIMARY KEY (`id`),
  KEY `fk_permissions_has_roles_roles1_idx` (`roles_id`),
  KEY `fk_permissions_has_roles_permissions1_idx` (`permissions_id`),
  CONSTRAINT `fk_permissions_has_roles_permissions1` FOREIGN KEY (`permissions_id`) REFERENCES `permissions` (`id`) ON DELETE NO ACTION ON UPDATE NO ACTION,
  CONSTRAINT `fk_permissions_has_roles_roles1` FOREIGN KEY (`roles_id`) REFERENCES `roles` (`id`) ON DELETE NO ACTION ON UPDATE NO ACTION
) ENGINE=InnoDB AUTO_INCREMENT=48 DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `permissions_roles`
--

LOCK TABLES `permissions_roles` WRITE;
/*!40000 ALTER TABLE `permissions_roles` DISABLE KEYS */;
INSERT INTO `permissions_roles` VALUES (37,7,1,'2016-05-27 15:17:59','2016-05-27 15:17:59'),(44,3,1,'2016-05-27 19:49:10','2016-05-27 19:49:10'),(46,5,1,'2016-05-27 22:23:11','2016-05-27 22:23:11'),(47,2,1,'2016-06-22 10:43:38','2016-06-22 10:43:38');
/*!40000 ALTER TABLE `permissions_roles` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `products`
--

DROP TABLE IF EXISTS `products`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `products` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `cup` int(11) NOT NULL,
  `name` varchar(45) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `products`
--

LOCK TABLES `products` WRITE;
/*!40000 ALTER TABLE `products` DISABLE KEYS */;
/*!40000 ALTER TABLE `products` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `products_studies`
--

DROP TABLE IF EXISTS `products_studies`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `products_studies` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `products_id` int(11) NOT NULL,
  `studies_id` int(11) NOT NULL,
  PRIMARY KEY (`id`),
  KEY `fk_products_has_studies_studies1_idx` (`studies_id`),
  KEY `fk_products_has_studies_products1_idx` (`products_id`),
  CONSTRAINT `fk_products_has_studies_products1` FOREIGN KEY (`products_id`) REFERENCES `products` (`id`) ON DELETE CASCADE ON UPDATE CASCADE,
  CONSTRAINT `fk_products_has_studies_studies1` FOREIGN KEY (`studies_id`) REFERENCES `studies` (`id`) ON DELETE CASCADE ON UPDATE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `products_studies`
--

LOCK TABLES `products_studies` WRITE;
/*!40000 ALTER TABLE `products_studies` DISABLE KEYS */;
/*!40000 ALTER TABLE `products_studies` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `providers`
--

DROP TABLE IF EXISTS `providers`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `providers` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `code` varchar(20) DEFAULT NULL,
  `nit` varchar(45) DEFAULT NULL,
  `name` varchar(55) DEFAULT NULL,
  `phone` varchar(45) DEFAULT NULL,
  `phone_two` varchar(45) DEFAULT NULL,
  `address` varchar(45) DEFAULT NULL,
  `email` varchar(45) DEFAULT NULL,
  `contact` varchar(45) DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `providers`
--

LOCK TABLES `providers` WRITE;
/*!40000 ALTER TABLE `providers` DISABLE KEYS */;
/*!40000 ALTER TABLE `providers` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `rate_studies`
--

DROP TABLE IF EXISTS `rate_studies`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `rate_studies` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `studies_id` int(11) NOT NULL,
  `rates_clients_id` int(11) NOT NULL,
  `value` decimal(10,2) NOT NULL,
  `date_ini` datetime DEFAULT NULL COMMENT 'initial date',
  `date_end` datetime DEFAULT NULL COMMENT 'end date',
  PRIMARY KEY (`id`),
  KEY `fk_rates_has_studies_studies1_idx` (`studies_id`),
  KEY `fk_rate_studies_rates_clients1_idx` (`rates_clients_id`),
  CONSTRAINT `fk_rate_studies_rates_clients1` FOREIGN KEY (`rates_clients_id`) REFERENCES `rates_clients` (`id`) ON DELETE CASCADE ON UPDATE CASCADE,
  CONSTRAINT `fk_rates_has_studies_studies1` FOREIGN KEY (`studies_id`) REFERENCES `studies` (`id`) ON DELETE CASCADE ON UPDATE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `rate_studies`
--

LOCK TABLES `rate_studies` WRITE;
/*!40000 ALTER TABLE `rate_studies` DISABLE KEYS */;
/*!40000 ALTER TABLE `rate_studies` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `rates`
--

DROP TABLE IF EXISTS `rates`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `rates` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `nombre` varchar(45) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=2 DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `rates`
--

LOCK TABLES `rates` WRITE;
/*!40000 ALTER TABLE `rates` DISABLE KEYS */;
INSERT INTO `rates` VALUES (1,'Particular');
/*!40000 ALTER TABLE `rates` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `rates_clients`
--

DROP TABLE IF EXISTS `rates_clients`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `rates_clients` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `rates_id` int(11) NOT NULL,
  `clients_id` int(11) NOT NULL,
  PRIMARY KEY (`id`),
  KEY `fk_rates_has_clients_clients1_idx` (`clients_id`),
  KEY `fk_rates_has_clients_rates1_idx` (`rates_id`),
  CONSTRAINT `fk_rates_has_clients_clients1` FOREIGN KEY (`clients_id`) REFERENCES `clients` (`id`) ON DELETE CASCADE ON UPDATE CASCADE,
  CONSTRAINT `fk_rates_has_clients_rates1` FOREIGN KEY (`rates_id`) REFERENCES `rates` (`id`) ON DELETE CASCADE ON UPDATE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `rates_clients`
--

LOCK TABLES `rates_clients` WRITE;
/*!40000 ALTER TABLE `rates_clients` DISABLE KEYS */;
/*!40000 ALTER TABLE `rates_clients` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `regimes`
--

DROP TABLE IF EXISTS `regimes`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `regimes` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `regime` varchar(25) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=4 DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `regimes`
--

LOCK TABLES `regimes` WRITE;
/*!40000 ALTER TABLE `regimes` DISABLE KEYS */;
INSERT INTO `regimes` VALUES (1,'Seleccione una opciòn'),(2,'Subsidiado'),(3,'Contributivo');
/*!40000 ALTER TABLE `regimes` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `resource_entity_directories`
--

DROP TABLE IF EXISTS `resource_entity_directories`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `resource_entity_directories` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `directory` varchar(45) NOT NULL,
  `entity_id` int(11) NOT NULL,
  `resource_parent_entities_id` int(11) NOT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `directory_UNIQUE` (`directory`),
  KEY `fk_resource_entity_directories_resource_parent_entities1_idx` (`resource_parent_entities_id`),
  CONSTRAINT `fk_resource_entity_directories_resource_parent_entities1` FOREIGN KEY (`resource_parent_entities_id`) REFERENCES `resource_parent_entities` (`id`) ON DELETE NO ACTION ON UPDATE NO ACTION
) ENGINE=InnoDB AUTO_INCREMENT=13 DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `resource_entity_directories`
--

LOCK TABLES `resource_entity_directories` WRITE;
/*!40000 ALTER TABLE `resource_entity_directories` DISABLE KEYS */;
INSERT INTO `resource_entity_directories` VALUES (5,'asddd',1,1),(6,'consent_signatures',1,2),(8,'1234',4,1),(12,'12345',2,1);
/*!40000 ALTER TABLE `resource_entity_directories` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `resource_extensions`
--

DROP TABLE IF EXISTS `resource_extensions`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `resource_extensions` (
  `id` int(11) NOT NULL AUTO_INCREMENT COMMENT '		',
  `extension` varchar(5) NOT NULL,
  `resource_file_types_id` int(11) NOT NULL,
  PRIMARY KEY (`id`),
  KEY `fk_resource_extensions_resource_file_types1_idx` (`resource_file_types_id`),
  CONSTRAINT `fk_resource_extensions_resource_file_types1` FOREIGN KEY (`resource_file_types_id`) REFERENCES `resource_file_types` (`id`) ON DELETE CASCADE ON UPDATE NO ACTION
) ENGINE=InnoDB AUTO_INCREMENT=14 DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `resource_extensions`
--

LOCK TABLES `resource_extensions` WRITE;
/*!40000 ALTER TABLE `resource_extensions` DISABLE KEYS */;
INSERT INTO `resource_extensions` VALUES (1,'jpg',3),(2,'pdf',4),(3,'png',3),(4,'doc',4),(5,'docx',4),(6,'xls',4),(7,'xlsx',4),(8,'ppt',4),(9,'pptx',4),(10,'bmp',3),(11,'gif',3),(12,'jpeg',3),(13,'svg',3);
/*!40000 ALTER TABLE `resource_extensions` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `resource_file_types`
--

DROP TABLE IF EXISTS `resource_file_types`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `resource_file_types` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `type` varchar(45) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=5 DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `resource_file_types`
--

LOCK TABLES `resource_file_types` WRITE;
/*!40000 ALTER TABLE `resource_file_types` DISABLE KEYS */;
INSERT INTO `resource_file_types` VALUES (1,'audio'),(2,'video'),(3,'image'),(4,'document');
/*!40000 ALTER TABLE `resource_file_types` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `resource_parent_entities`
--

DROP TABLE IF EXISTS `resource_parent_entities`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `resource_parent_entities` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `name` varchar(45) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=3 DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `resource_parent_entities`
--

LOCK TABLES `resource_parent_entities` WRITE;
/*!40000 ALTER TABLE `resource_parent_entities` DISABLE KEYS */;
INSERT INTO `resource_parent_entities` VALUES (1,'patients'),(2,'studies_consents');
/*!40000 ALTER TABLE `resource_parent_entities` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `resource_types`
--

DROP TABLE IF EXISTS `resource_types`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `resource_types` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `name` varchar(100) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=3 DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `resource_types`
--

LOCK TABLES `resource_types` WRITE;
/*!40000 ALTER TABLE `resource_types` DISABLE KEYS */;
INSERT INTO `resource_types` VALUES (1,'profile_pic'),(2,'consent_signature');
/*!40000 ALTER TABLE `resource_types` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `resources`
--

DROP TABLE IF EXISTS `resources`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `resources` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `users_id` int(11) NOT NULL,
  `stored_file_name` varchar(150) NOT NULL,
  `name` varchar(255) NOT NULL,
  `created` datetime DEFAULT NULL COMMENT '	',
  `modified` datetime DEFAULT NULL,
  `entity_id` int(11) NOT NULL COMMENT 'identificador de la entidad a la que pertenece',
  `resource_extensions_id` int(11) NOT NULL,
  `resource_types_id` int(11) NOT NULL,
  `resource_parent_entities_id` int(11) NOT NULL,
  `bytes` varchar(50) NOT NULL,
  `size_format` varchar(30) NOT NULL,
  PRIMARY KEY (`id`),
  KEY `fk_rosources_users1_idx` (`users_id`),
  KEY `fk_rosources_resource_extensions1_idx` (`resource_extensions_id`),
  KEY `fk_resources_resource_types1_idx` (`resource_types_id`),
  KEY `fk_resources_resource_parent_entities1_idx` (`resource_parent_entities_id`),
  CONSTRAINT `fk_resources_resource_parent_entities1` FOREIGN KEY (`resource_parent_entities_id`) REFERENCES `resource_parent_entities` (`id`) ON DELETE CASCADE ON UPDATE NO ACTION,
  CONSTRAINT `fk_resources_resource_types1` FOREIGN KEY (`resource_types_id`) REFERENCES `resource_types` (`id`) ON DELETE CASCADE ON UPDATE NO ACTION,
  CONSTRAINT `fk_rosources_resource_extensions1` FOREIGN KEY (`resource_extensions_id`) REFERENCES `resource_extensions` (`id`) ON DELETE CASCADE ON UPDATE NO ACTION,
  CONSTRAINT `fk_rosources_users1` FOREIGN KEY (`users_id`) REFERENCES `users` (`id`) ON DELETE CASCADE ON UPDATE NO ACTION
) ENGINE=InnoDB AUTO_INCREMENT=65 DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `resources`
--

LOCK TABLES `resources` WRITE;
/*!40000 ALTER TABLE `resources` DISABLE KEYS */;
INSERT INTO `resources` VALUES (31,1,'1466105344176181077957153.jpg','IMG_20160614_153829','2016-06-16 14:29:04','2016-06-16 14:29:04',1,1,1,1,'1141219','1.09 MB'),(32,1,'1466106418675452947616577.jpg','IMG_20160614_153829','2016-06-16 14:46:59','2016-06-16 14:46:59',1,1,1,1,'1141219','1.09 MB'),(33,1,'1466106894870439052581787.jpg','IMG_20160614_153829','2016-06-16 14:54:54','2016-06-16 14:54:54',1,1,1,1,'1141219','1.09 MB'),(34,1,'1466107403430649042129517.xlsx','scrum_final','2016-06-16 15:03:23','2016-06-16 15:03:23',1,7,1,1,'14472','14.13 KB'),(35,1,'1466441080399673938751221.svg','signature_c1','2016-06-20 11:44:40','2016-06-20 11:44:40',1,13,2,1,'1573','1.54 KB'),(36,1,'1466441083053956985473633.svg','signature_c1','2016-06-20 11:44:43','2016-06-20 11:44:43',1,13,2,1,'1573','1.54 KB'),(37,1,'1466441407370904922485352.svg','signature_c1','2016-06-20 11:50:07','2016-06-20 11:50:07',1,13,2,1,'1573','1.54 KB'),(38,1,'1466441409304877996444702.svg','signature_c1','2016-06-20 11:50:09','2016-06-20 11:50:09',1,13,2,1,'1573','1.54 KB'),(39,1,'1466441410113811016082764.svg','signature_c1','2016-06-20 11:50:10','2016-06-20 11:50:10',1,13,2,1,'1573','1.54 KB'),(40,1,'1466450027103899002075195.svg','signature_c1','2016-06-20 14:13:47','2016-06-20 14:13:47',1,13,2,2,'1573','1.54 KB'),(41,1,'1466450029436959028244019.svg','signature_c1','2016-06-20 14:13:49','2016-06-20 14:13:49',1,13,2,2,'1573','1.54 KB'),(42,1,'1466450064218863964080811.svg','signature_c1','2016-06-20 14:14:24','2016-06-20 14:14:24',1,13,2,2,'1573','1.54 KB'),(43,1,'1466450607912401914596558.svg','signature_c1','2016-06-20 14:23:28','2016-06-20 14:23:28',1,13,2,2,'1573','1.54 KB'),(44,1,'1466450609389465093612671.svg','signature_c1','2016-06-20 14:23:29','2016-06-20 14:23:29',1,13,2,2,'1573','1.54 KB'),(45,1,'1466450627409415006637573.svg','signature_c1','2016-06-20 14:23:47','2016-06-20 14:23:47',1,13,2,2,'1573','1.54 KB'),(46,1,'1466452484991117000579834.svg','signature_c1','2016-06-20 14:54:45','2016-06-20 14:54:45',1,13,2,2,'711','711 bytes'),(47,1,'1466452489916397094726562.svg','signature_c1','2016-06-20 14:54:49','2016-06-20 14:54:49',1,13,2,2,'1386','1.35 KB'),(48,1,'1466452503204314947128296.svg','signature_c1','2016-06-20 14:55:03','2016-06-20 14:55:03',1,13,2,2,'1754','1.71 KB'),(49,1,'146645256983034610748291.svg','signature_c1','2016-06-20 14:56:09','2016-06-20 14:56:09',1,13,2,2,'6882','6.72 KB'),(50,1,'1466452767300528049468994.svg','signature_c1','2016-06-20 14:59:27','2016-06-20 14:59:27',1,13,2,2,'1955','1.91 KB'),(51,1,'1466452769143558025360107.svg','signature_c1','2016-06-20 14:59:29','2016-06-20 14:59:29',1,13,2,2,'1955','1.91 KB'),(52,1,'1466452806980760097503662.svg','signature_c1','2016-06-20 15:00:07','2016-06-20 15:00:07',1,13,2,2,'23663','23.11 KB'),(53,1,'1466452819920839071273804.svg','signature_c1','2016-06-20 15:00:19','2016-06-20 15:00:19',1,13,2,2,'1012','1012 bytes'),(54,1,'1466456420802978992462158.svg','signature_c1','2016-06-20 16:00:21','2016-06-20 16:00:21',1,13,2,2,'1191','1.16 KB'),(55,1,'1466456700088116884231567.png','IMG_20062016_084748','2016-06-20 16:05:00','2016-06-20 16:05:00',1,3,1,1,'22023','21.51 KB'),(56,2,'1466457023359380006790161.png','IMG_20062016_085320','2016-06-20 16:10:23','2016-06-20 16:10:23',2,3,1,1,'18213','17.79 KB'),(57,2,'1466457027209507942199707.png','IMG_20062016_085320','2016-06-20 16:10:27','2016-06-20 16:10:27',2,3,1,1,'18213','17.79 KB'),(58,2,'1466457029028992891311646.png','IMG_20062016_085320','2016-06-20 16:10:29','2016-06-20 16:10:29',2,3,1,1,'18213','17.79 KB'),(59,2,'146645703222658109664917.png','IMG_20062016_085320','2016-06-20 16:10:32','2016-06-20 16:10:32',2,3,1,1,'18213','17.79 KB'),(60,2,'1466457032975142955780029.png','IMG_20062016_085320','2016-06-20 16:10:33','2016-06-20 16:10:33',2,3,1,1,'18213','17.79 KB'),(61,2,'1466457033451965093612671.png','IMG_20062016_085320','2016-06-20 16:10:33','2016-06-20 16:10:33',2,3,1,1,'18213','17.79 KB'),(62,2,'1466457407721894025802612.png','IMG_20062016_085320','2016-06-20 16:16:48','2016-06-20 16:16:48',2,3,1,1,'18213','17.79 KB'),(63,2,'1466457412176076889038086.png','IMG_20062016_085320','2016-06-20 16:16:52','2016-06-20 16:16:52',2,3,1,1,'18213','17.79 KB'),(64,1,'1466461546947094917297363.svg','signature_c1','2016-06-20 17:25:47','2016-06-20 17:25:47',1,13,2,2,'952','952 bytes');
/*!40000 ALTER TABLE `resources` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `result_profiles`
--

DROP TABLE IF EXISTS `result_profiles`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `result_profiles` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `specialists_id` int(11) NOT NULL,
  `studies_id` int(11) NOT NULL,
  `content` text,
  PRIMARY KEY (`id`),
  KEY `fk_result_profiles_specialists1_idx` (`specialists_id`),
  KEY `fk_result_profiles_studies1_idx` (`studies_id`),
  CONSTRAINT `fk_result_profiles_specialists1` FOREIGN KEY (`specialists_id`) REFERENCES `specialists` (`id`) ON DELETE NO ACTION ON UPDATE NO ACTION,
  CONSTRAINT `fk_result_profiles_studies1` FOREIGN KEY (`studies_id`) REFERENCES `studies` (`id`) ON DELETE NO ACTION ON UPDATE NO ACTION
) ENGINE=InnoDB DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `result_profiles`
--

LOCK TABLES `result_profiles` WRITE;
/*!40000 ALTER TABLE `result_profiles` DISABLE KEYS */;
/*!40000 ALTER TABLE `result_profiles` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `results`
--

DROP TABLE IF EXISTS `results`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `results` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `results`
--

LOCK TABLES `results` WRITE;
/*!40000 ALTER TABLE `results` DISABLE KEYS */;
/*!40000 ALTER TABLE `results` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `roles`
--

DROP TABLE IF EXISTS `roles`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `roles` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `name` varchar(100) NOT NULL,
  `description` varchar(255) NOT NULL,
  `created` datetime NOT NULL,
  `modified` datetime NOT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `name_UNIQUE` (`name`)
) ENGINE=InnoDB AUTO_INCREMENT=9 DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `roles`
--

LOCK TABLES `roles` WRITE;
/*!40000 ALTER TABLE `roles` DISABLE KEYS */;
INSERT INTO `roles` VALUES (1,'admin','Administrador','2015-10-10 10:10:10','2015-10-10 10:10:10'),(2,'facturacion','Profesional de facturación','2016-05-27 15:17:28','2016-05-27 15:17:28'),(3,'especialista','Profesional de la salud que presta servicios especializados o de consulta','2016-06-03 16:52:37','2016-06-03 16:52:37'),(4,'tecnologo','Profesional de la salud que toma un estudio','2016-06-17 08:43:24','2016-06-17 08:43:24'),(5,'contable','Profesional encargado de contabilidad','2016-06-17 08:44:31','2016-06-17 08:44:31'),(6,'inventario','Profesional encargado de inventario','2016-06-17 08:45:25','2016-06-17 08:45:25'),(7,'paciente','Pacientes','2016-06-17 08:45:58','2016-06-17 08:45:58'),(8,'recepcion','Profesional encargado de recepción','2016-06-17 08:46:17','2016-06-17 08:46:17');
/*!40000 ALTER TABLE `roles` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `schedule_especialist_restrictions`
--

DROP TABLE IF EXISTS `schedule_especialist_restrictions`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `schedule_especialist_restrictions` (
  `Id` int(11) NOT NULL AUTO_INCREMENT,
  `description` varchar(80) DEFAULT NULL COMMENT '	',
  `date_ini` datetime DEFAULT NULL COMMENT '	',
  `date_end` datetime DEFAULT NULL,
  `specialists_id` int(11) NOT NULL,
  PRIMARY KEY (`Id`),
  KEY `fk_schedule_especialist_restrictions_specialists1_idx` (`specialists_id`),
  CONSTRAINT `fk_schedule_especialist_restrictions_specialists1` FOREIGN KEY (`specialists_id`) REFERENCES `specialists` (`id`) ON DELETE NO ACTION ON UPDATE NO ACTION
) ENGINE=InnoDB AUTO_INCREMENT=9 DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `schedule_especialist_restrictions`
--

LOCK TABLES `schedule_especialist_restrictions` WRITE;
/*!40000 ALTER TABLE `schedule_especialist_restrictions` DISABLE KEYS */;
INSERT INTO `schedule_especialist_restrictions` VALUES (1,'hgf','2016-06-08 15:45:00','2016-06-08 15:45:00',1),(2,'asfdsg','2016-06-09 14:45:00','2016-06-09 11:00:00',1),(3,'dvfsgfb','2016-06-09 09:45:00','2016-06-09 10:45:00',1),(4,'safdsg','2016-06-17 08:30:00','2016-06-17 10:30:00',1),(5,'sfdffg','2016-06-15 10:15:00','2016-06-15 13:15:00',1),(6,'gxvc','2016-06-10 12:00:00','2016-06-10 12:00:00',1),(7,'asd','2016-06-16 12:15:00','2016-06-16 12:15:00',1),(8,'safdg','2016-06-03 13:30:00','2016-06-03 16:30:00',1);
/*!40000 ALTER TABLE `schedule_especialist_restrictions` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `schedule_intervals`
--

DROP TABLE IF EXISTS `schedule_intervals`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `schedule_intervals` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `date_ini` date NOT NULL,
  `date_end` date NOT NULL,
  `medical_offices_id` int(11) NOT NULL,
  `created` datetime NOT NULL,
  `modified` datetime NOT NULL,
  `users_id` int(11) NOT NULL,
  PRIMARY KEY (`id`),
  KEY `fk_schedule_medical_offices1_idx` (`medical_offices_id`),
  KEY `fk_schedule_intervals_users1_idx` (`users_id`),
  CONSTRAINT `fk_schedule_intervals_users1` FOREIGN KEY (`users_id`) REFERENCES `users` (`id`) ON DELETE CASCADE ON UPDATE CASCADE,
  CONSTRAINT `fk_schedule_medical_offices1` FOREIGN KEY (`medical_offices_id`) REFERENCES `medical_offices` (`id`) ON DELETE CASCADE ON UPDATE CASCADE
) ENGINE=InnoDB AUTO_INCREMENT=23 DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `schedule_intervals`
--

LOCK TABLES `schedule_intervals` WRITE;
/*!40000 ALTER TABLE `schedule_intervals` DISABLE KEYS */;
INSERT INTO `schedule_intervals` VALUES (8,'2015-10-10','2015-11-09',9,'2016-06-02 20:44:23','2016-06-02 20:44:23',1),(12,'2016-06-01','2016-06-30',9,'2016-06-03 12:26:57','2016-06-03 12:26:57',1),(14,'2016-07-02','2016-07-28',7,'2016-06-03 14:48:04','2016-06-03 14:48:04',1),(21,'2016-06-08','2016-06-28',7,'2016-06-15 14:38:21','2016-06-15 14:38:21',1),(22,'2016-06-14','2016-06-22',7,'2016-06-15 16:06:40','2016-06-15 16:06:40',1);
/*!40000 ALTER TABLE `schedule_intervals` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `schedule_specialists`
--

DROP TABLE IF EXISTS `schedule_specialists`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `schedule_specialists` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `specialists_id` int(11) NOT NULL,
  `created` datetime NOT NULL,
  `modified` datetime NOT NULL,
  `date_ini` datetime DEFAULT NULL COMMENT '	',
  `date_end` datetime DEFAULT NULL,
  `medical_offices_id` int(11) NOT NULL,
  PRIMARY KEY (`id`),
  KEY `fk_schedules_has_specialists_specialists1_idx` (`specialists_id`),
  KEY `fk_schedule_specialists_medical_offices1_idx` (`medical_offices_id`),
  CONSTRAINT `fk_schedule_specialists_medical_offices1` FOREIGN KEY (`medical_offices_id`) REFERENCES `medical_offices` (`id`) ON DELETE NO ACTION ON UPDATE NO ACTION,
  CONSTRAINT `fk_schedules_has_specialists_specialists1` FOREIGN KEY (`specialists_id`) REFERENCES `specialists` (`id`) ON DELETE CASCADE ON UPDATE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `schedule_specialists`
--

LOCK TABLES `schedule_specialists` WRITE;
/*!40000 ALTER TABLE `schedule_specialists` DISABLE KEYS */;
/*!40000 ALTER TABLE `schedule_specialists` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `service_types`
--

DROP TABLE IF EXISTS `service_types`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `service_types` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `type` varchar(45) DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=7 DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `service_types`
--

LOCK TABLES `service_types` WRITE;
/*!40000 ALTER TABLE `service_types` DISABLE KEYS */;
INSERT INTO `service_types` VALUES (1,'Seleccione una Opciòn'),(2,'Urgencia'),(3,'Prioritario'),(4,'Tan Pronto Como Sea Posible'),(5,'Re-Llamado'),(6,'Rutina');
/*!40000 ALTER TABLE `service_types` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `specialists`
--

DROP TABLE IF EXISTS `specialists`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `specialists` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `people_id` int(11) NOT NULL,
  `users_id` int(11) NOT NULL,
  `created` datetime NOT NULL,
  `modified` datetime NOT NULL,
  PRIMARY KEY (`id`),
  KEY `fk_specialists_people1_idx` (`people_id`),
  KEY `fk_specialists_users1_idx` (`users_id`),
  CONSTRAINT `fk_specialists_people1` FOREIGN KEY (`people_id`) REFERENCES `people` (`id`) ON DELETE NO ACTION ON UPDATE NO ACTION,
  CONSTRAINT `fk_specialists_users1` FOREIGN KEY (`users_id`) REFERENCES `users` (`id`) ON DELETE NO ACTION ON UPDATE NO ACTION
) ENGINE=InnoDB AUTO_INCREMENT=2 DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `specialists`
--

LOCK TABLES `specialists` WRITE;
/*!40000 ALTER TABLE `specialists` DISABLE KEYS */;
INSERT INTO `specialists` VALUES (1,2,2,'2016-05-26 13:30:22','2016-05-26 13:30:22');
/*!40000 ALTER TABLE `specialists` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `specialists_availables`
--

DROP TABLE IF EXISTS `specialists_availables`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `specialists_availables` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `day` int(11) NOT NULL,
  `time_ini` time NOT NULL,
  `time_end` time NOT NULL,
  `state` int(1) NOT NULL,
  `created` datetime NOT NULL,
  `modified` datetime NOT NULL,
  `specialists_id` int(11) NOT NULL,
  `service_type_id` int(11) NOT NULL,
  PRIMARY KEY (`id`),
  KEY `fk_specialists_availables_specialists1_idx` (`specialists_id`),
  KEY `fk_specialists_availables_service_type1_idx` (`service_type_id`),
  CONSTRAINT `fk_specialists_availables_service_type1` FOREIGN KEY (`service_type_id`) REFERENCES `service_types` (`id`) ON DELETE NO ACTION ON UPDATE NO ACTION,
  CONSTRAINT `fk_specialists_availables_specialists1` FOREIGN KEY (`specialists_id`) REFERENCES `specialists` (`id`) ON DELETE NO ACTION ON UPDATE NO ACTION
) ENGINE=InnoDB DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `specialists_availables`
--

LOCK TABLES `specialists_availables` WRITE;
/*!40000 ALTER TABLE `specialists_availables` DISABLE KEYS */;
/*!40000 ALTER TABLE `specialists_availables` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `specializations`
--

DROP TABLE IF EXISTS `specializations`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `specializations` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `specialization` varchar(255) NOT NULL,
  `created` datetime NOT NULL,
  `modified` datetime NOT NULL,
  `parent_specialization` int(11) NOT NULL,
  `code` varchar(10) DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=7 DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `specializations`
--

LOCK TABLES `specializations` WRITE;
/*!40000 ALTER TABLE `specializations` DISABLE KEYS */;
INSERT INTO `specializations` VALUES (1,'Cardiologia','2016-05-26 13:30:22','2016-05-26 13:30:22',0,NULL),(2,'Cardiologia Pediatrica','2016-05-26 13:30:22','2016-05-26 13:30:22',1,NULL),(3,'Ecografia','2016-05-26 13:30:22','2016-05-26 13:30:22',1,NULL),(4,'Medicina Nuclear','2016-05-26 13:30:22','2016-05-26 13:30:22',1,NULL),(5,'Rayos X','2016-05-26 13:30:22','2016-05-26 13:30:22',0,NULL),(6,'Mamografia','2016-05-26 13:30:22','2016-05-26 13:30:22',0,NULL);
/*!40000 ALTER TABLE `specializations` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `studies`
--

DROP TABLE IF EXISTS `studies`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `studies` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `cup` int(11) DEFAULT NULL,
  `name` varchar(45) NOT NULL,
  `specializations_id` int(11) NOT NULL,
  `average_time` time DEFAULT NULL,
  `type` varchar(45) DEFAULT NULL,
  `service_types_id` int(11) NOT NULL,
  PRIMARY KEY (`id`),
  KEY `fk_studies_specializations1_idx` (`specializations_id`),
  KEY `fk_studies_service_type1_idx` (`service_types_id`),
  CONSTRAINT `fk_studies_service_type1` FOREIGN KEY (`service_types_id`) REFERENCES `service_types` (`id`) ON DELETE NO ACTION ON UPDATE NO ACTION,
  CONSTRAINT `fk_studies_specializations1` FOREIGN KEY (`specializations_id`) REFERENCES `specializations` (`id`) ON DELETE CASCADE ON UPDATE CASCADE
) ENGINE=InnoDB AUTO_INCREMENT=5 DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `studies`
--

LOCK TABLES `studies` WRITE;
/*!40000 ALTER TABLE `studies` DISABLE KEYS */;
INSERT INTO `studies` VALUES (1,901,'Ecografia Convencional Ecografia Convencional',3,'00:00:10',NULL,0),(2,902,'Doppler',3,'00:00:02',NULL,0),(3,903,'Obstetrico',3,'00:00:50',NULL,0),(4,801,'Rayos X ',5,'00:00:20',NULL,0);
/*!40000 ALTER TABLE `studies` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `studies_informed_consents`
--

DROP TABLE IF EXISTS `studies_informed_consents`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `studies_informed_consents` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `studies_id` int(11) NOT NULL,
  `informed_consents_id` int(11) NOT NULL,
  PRIMARY KEY (`id`),
  KEY `fk_studies_has_informed_consents_informed_consents1_idx` (`informed_consents_id`),
  KEY `fk_studies_has_informed_consents_studies1_idx` (`studies_id`),
  CONSTRAINT `fk_studies_has_informed_consents_informed_consents1` FOREIGN KEY (`informed_consents_id`) REFERENCES `informed_consents` (`id`) ON DELETE CASCADE ON UPDATE CASCADE,
  CONSTRAINT `fk_studies_has_informed_consents_studies1` FOREIGN KEY (`studies_id`) REFERENCES `studies` (`id`) ON DELETE CASCADE ON UPDATE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `studies_informed_consents`
--

LOCK TABLES `studies_informed_consents` WRITE;
/*!40000 ALTER TABLE `studies_informed_consents` DISABLE KEYS */;
/*!40000 ALTER TABLE `studies_informed_consents` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `studies_medical_offices`
--

DROP TABLE IF EXISTS `studies_medical_offices`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `studies_medical_offices` (
  `studies_id` int(11) NOT NULL,
  `medical_offices_id` int(11) NOT NULL,
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `created` datetime NOT NULL,
  `modified` datetime NOT NULL,
  PRIMARY KEY (`id`),
  KEY `fk_studies_has_medical_offices_medical_offices1_idx` (`medical_offices_id`),
  KEY `fk_studies_has_medical_offices_studies1_idx` (`studies_id`),
  CONSTRAINT `fk_studies_has_medical_offices_medical_offices1` FOREIGN KEY (`medical_offices_id`) REFERENCES `medical_offices` (`id`) ON DELETE NO ACTION ON UPDATE NO ACTION,
  CONSTRAINT `fk_studies_has_medical_offices_studies1` FOREIGN KEY (`studies_id`) REFERENCES `studies` (`id`) ON DELETE NO ACTION ON UPDATE NO ACTION
) ENGINE=InnoDB AUTO_INCREMENT=8 DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `studies_medical_offices`
--

LOCK TABLES `studies_medical_offices` WRITE;
/*!40000 ALTER TABLE `studies_medical_offices` DISABLE KEYS */;
INSERT INTO `studies_medical_offices` VALUES (3,7,3,'2016-06-22 11:02:55','2016-06-22 11:02:55'),(1,9,4,'2016-06-22 11:07:10','2016-06-22 11:07:10'),(2,7,5,'2016-06-22 11:48:01','2016-06-22 11:48:01'),(4,14,6,'2016-06-24 10:02:49','2016-06-24 10:02:49'),(1,14,7,'2016-06-24 10:02:49','2016-06-24 10:02:49');
/*!40000 ALTER TABLE `studies_medical_offices` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `studies_result_format`
--

DROP TABLE IF EXISTS `studies_result_format`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `studies_result_format` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `content` text,
  `orders_id` int(11) NOT NULL,
  `users_id` int(11) NOT NULL,
  `specialists_id` int(11) NOT NULL,
  PRIMARY KEY (`id`),
  KEY `fk_table1_orders1_idx` (`orders_id`),
  KEY `fk_studies_result_format_users1_idx` (`users_id`),
  KEY `fk_studies_result_format_specialists1_idx` (`specialists_id`),
  CONSTRAINT `fk_studies_result_format_specialists1` FOREIGN KEY (`specialists_id`) REFERENCES `specialists` (`id`) ON DELETE NO ACTION ON UPDATE NO ACTION,
  CONSTRAINT `fk_studies_result_format_users1` FOREIGN KEY (`users_id`) REFERENCES `users` (`id`) ON DELETE NO ACTION ON UPDATE NO ACTION,
  CONSTRAINT `fk_table1_orders1` FOREIGN KEY (`orders_id`) REFERENCES `orders` (`id`) ON DELETE NO ACTION ON UPDATE NO ACTION
) ENGINE=InnoDB DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `studies_result_format`
--

LOCK TABLES `studies_result_format` WRITE;
/*!40000 ALTER TABLE `studies_result_format` DISABLE KEYS */;
/*!40000 ALTER TABLE `studies_result_format` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `studies_specialists`
--

DROP TABLE IF EXISTS `studies_specialists`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `studies_specialists` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `studies_id` int(11) NOT NULL,
  `specialists_id` int(11) NOT NULL,
  `created` datetime NOT NULL COMMENT '	',
  `modified` datetime NOT NULL,
  PRIMARY KEY (`id`),
  KEY `fk_studies_has_specialists_specialists1_idx` (`specialists_id`),
  KEY `fk_studies_has_specialists_studies1_idx` (`studies_id`),
  CONSTRAINT `fk_studies_has_specialists_specialists1` FOREIGN KEY (`specialists_id`) REFERENCES `specialists` (`id`) ON DELETE NO ACTION ON UPDATE NO ACTION,
  CONSTRAINT `fk_studies_has_specialists_studies1` FOREIGN KEY (`studies_id`) REFERENCES `studies` (`id`) ON DELETE NO ACTION ON UPDATE NO ACTION
) ENGINE=InnoDB AUTO_INCREMENT=107 DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `studies_specialists`
--

LOCK TABLES `studies_specialists` WRITE;
/*!40000 ALTER TABLE `studies_specialists` DISABLE KEYS */;
INSERT INTO `studies_specialists` VALUES (105,1,1,'0000-00-00 00:00:00','0000-00-00 00:00:00'),(106,2,1,'0000-00-00 00:00:00','0000-00-00 00:00:00');
/*!40000 ALTER TABLE `studies_specialists` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `user_centers`
--

DROP TABLE IF EXISTS `user_centers`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `user_centers` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `users_id` int(11) NOT NULL,
  `centers_id` int(11) NOT NULL,
  PRIMARY KEY (`id`),
  KEY `fk_ubications_has_users_users1_idx` (`users_id`),
  KEY `fk_user_centers_centers1_idx` (`centers_id`),
  CONSTRAINT `fk_ubications_has_users_users1` FOREIGN KEY (`users_id`) REFERENCES `users` (`id`) ON DELETE CASCADE ON UPDATE CASCADE,
  CONSTRAINT `fk_user_centers_centers1` FOREIGN KEY (`centers_id`) REFERENCES `centers` (`id`) ON DELETE NO ACTION ON UPDATE NO ACTION
) ENGINE=InnoDB DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `user_centers`
--

LOCK TABLES `user_centers` WRITE;
/*!40000 ALTER TABLE `user_centers` DISABLE KEYS */;
/*!40000 ALTER TABLE `user_centers` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `users`
--

DROP TABLE IF EXISTS `users`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `users` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `username` varchar(45) NOT NULL,
  `password` varchar(255) NOT NULL,
  `roles_id` int(11) NOT NULL,
  `created` datetime NOT NULL,
  `modified` datetime NOT NULL,
  `people_id` int(11) NOT NULL,
  `active` int(11) NOT NULL COMMENT '1. active , 0.inactive',
  PRIMARY KEY (`id`),
  UNIQUE KEY `username_UNIQUE` (`username`),
  KEY `fk_users_roles_idx` (`roles_id`),
  KEY `fk_users_people1_idx` (`people_id`),
  CONSTRAINT `fk_users_people1` FOREIGN KEY (`people_id`) REFERENCES `people` (`id`) ON DELETE NO ACTION ON UPDATE NO ACTION,
  CONSTRAINT `fk_users_roles` FOREIGN KEY (`roles_id`) REFERENCES `roles` (`id`) ON DELETE NO ACTION ON UPDATE NO ACTION
) ENGINE=InnoDB AUTO_INCREMENT=3 DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `users`
--

LOCK TABLES `users` WRITE;
/*!40000 ALTER TABLE `users` DISABLE KEYS */;
INSERT INTO `users` VALUES (1,'admin','$2y$10$F0.KYrLx5buLLhkVxJj8KOSUyMLJN8vkojqL7WSIFcvZXamocxgO6',1,'2016-05-26 13:30:22','2016-06-20 15:53:30',1,0),(2,'medico','$2y$10$F0.KYrLx5buLLhkVxJj8KOSUyMLJN8vkojqL7WSIFcvZXamocxgO6',1,'2016-05-26 13:30:22','2016-05-26 13:30:22',2,0);
/*!40000 ALTER TABLE `users` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `zones`
--

DROP TABLE IF EXISTS `zones`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `zones` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `zone` varchar(20) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=3 DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `zones`
--

LOCK TABLES `zones` WRITE;
/*!40000 ALTER TABLE `zones` DISABLE KEYS */;
INSERT INTO `zones` VALUES (1,'Rural'),(2,'Urbana');
/*!40000 ALTER TABLE `zones` ENABLE KEYS */;
UNLOCK TABLES;
/*!40103 SET TIME_ZONE=@OLD_TIME_ZONE */;

/*!40101 SET SQL_MODE=@OLD_SQL_MODE */;
/*!40014 SET FOREIGN_KEY_CHECKS=@OLD_FOREIGN_KEY_CHECKS */;
/*!40014 SET UNIQUE_CHECKS=@OLD_UNIQUE_CHECKS */;
/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
/*!40111 SET SQL_NOTES=@OLD_SQL_NOTES */;

-- Dump completed on 2016-06-27  8:55:39
