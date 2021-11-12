-- MariaDB dump 10.19  Distrib 10.6.4-MariaDB, for Linux (x86_64)
--
-- Host: localhost    Database: teambuilder
-- ------------------------------------------------------
-- Server version	10.6.4-MariaDB

/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;
/*!40103 SET @OLD_TIME_ZONE=@@TIME_ZONE */;
/*!40103 SET TIME_ZONE='+00:00' */;
/*!40014 SET @OLD_UNIQUE_CHECKS=@@UNIQUE_CHECKS, UNIQUE_CHECKS=0 */;
/*!40014 SET @OLD_FOREIGN_KEY_CHECKS=@@FOREIGN_KEY_CHECKS, FOREIGN_KEY_CHECKS=0 */;
/*!40101 SET @OLD_SQL_MODE=@@SQL_MODE, SQL_MODE='NO_AUTO_VALUE_ON_ZERO' */;
/*!40111 SET @OLD_SQL_NOTES=@@SQL_NOTES, SQL_NOTES=0 */;

--
-- Table structure for table `members`
--

DROP TABLE IF EXISTS `members`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `members` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `name` varchar(45) NOT NULL,
  `password` varchar(500) NOT NULL,
  `role_id` int(11) NOT NULL,
  `status_id` int(11) NOT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `name_UNIQUE` (`name`),
  KEY `fk_members_roles_idx` (`role_id`),
  KEY `fk_members_status1_idx` (`status_id`),
  CONSTRAINT `fk_members_roles` FOREIGN KEY (`role_id`) REFERENCES `roles` (`id`) ON DELETE NO ACTION ON UPDATE NO ACTION
) ENGINE=InnoDB AUTO_INCREMENT=52 DEFAULT CHARSET=utf8mb4;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `members`
--

LOCK TABLES `members` WRITE;
/*!40000 ALTER TABLE `members` DISABLE KEYS */;
INSERT INTO `members` VALUES (1,'Anthony','Anthony\'s_Pa$$w0rd',1,1),(2,'Armand','Armand\'s_Pa$$w0rd',1,1),(3,'Cyril','Cyril\'s_Pa$$w0rd',1,1),(4,'Filipe','Filipe\'s_Pa$$w0rd',1,1),(5,'Helene','Helene\'s_Pa$$w0rd',1,1),(6,'Mario','Mario\'s_Pa$$w0rd',1,1),(7,'Mathieu','Mathieu\'s_Pa$$w0rd',1,1),(8,'Mauro','Mauro\'s_Pa$$w0rd',1,1),(9,'Melodie','Melodie\'s_Pa$$w0rd',1,1),(10,'Noah','Noah\'s_Pa$$w0rd',1,1),(11,'Robiel','Robiel\'s_Pa$$w0rd',1,1),(12,'Sou','Sou\'s_Pa$$w0rd',1,1),(13,'Theo','Theo\'s_Pa$$w0rd',1,1),(14,'Yannick','Yannick\'s_Pa$$w0rd',1,1),(15,'Xavier','Xavier\'s_Pa$$w0rd',2,1),(16,'Pascal','Pascal\'s_Pa$$w0rd',2,1),(17,'Nicolas','Nicolas\'s_Pa$$w0rd',2,1),(18,'Lèi','Lèi\'s_Pa$$w0rd',1,1),(19,'Marie-josée','Marie-josée\'s_Pa$$w0rd',1,1),(20,'Håkan','Håkan\'s_Pa$$w0rd',1,1),(21,'Cécile','Cécile\'s_Pa$$w0rd',1,1),(22,'Dà','Dà\'s_Pa$$w0rd',1,1),(23,'Néhémie','Néhémie\'s_Pa$$w0rd',1,1),(24,'Sòng','Sòng\'s_Pa$$w0rd',1,1),(25,'Audréanne','Audréanne\'s_Pa$$w0rd',1,1),(26,'Lucrèce','Lucrèce\'s_Pa$$w0rd',2,1),(27,'Göran','Göran\'s_Pa$$w0rd',1,1),(28,'Hélèna','Hélèna\'s_Pa$$w0rd',1,1),(29,'Åslög','Åslög\'s_Pa$$w0rd',1,1),(30,'Inès','Inès\'s_Pa$$w0rd',1,1),(31,'Agnès','Agnès\'s_Pa$$w0rd',1,1),(32,'Táng','Táng\'s_Pa$$w0rd',1,1),(33,'Yáo','Yáo\'s_Pa$$w0rd',1,1),(34,'Marlène','Marlène\'s_Pa$$w0rd',1,1),(35,'Eléa','Eléa\'s_Pa$$w0rd',1,1),(36,'Thérèse','Thérèse\'s_Pa$$w0rd',1,1),(37,'Pélagie','Pélagie\'s_Pa$$w0rd',1,1),(38,'Clélia','Clélia\'s_Pa$$w0rd',2,1),(39,'Anaé','Anaé\'s_Pa$$w0rd',1,1),(40,'Marie-noël','Marie-noël\'s_Pa$$w0rd',1,1),(41,'Andréanne','Andréanne\'s_Pa$$w0rd',1,1),(42,'Gérald','Gérald\'s_Pa$$w0rd',1,1),(43,'Bérénice','Bérénice\'s_Pa$$w0rd',1,1),(44,'Anaël','Anaël\'s_Pa$$w0rd',1,1),(45,'Mélissandre','Mélissandre\'s_Pa$$w0rd',1,1),(46,'Marie-hélène','Marie-hélène\'s_Pa$$w0rd',1,1),(47,'Desirée','Desirée\'s_Pa$$w0rd',1,1),(48,'Zhì','Zhì\'s_Pa$$w0rd',1,1),(49,'Lén','Lén\'s_Pa$$w0rd',1,1),(50,'Cinéma','Cinéma\'s_Pa$$w0rd',1,1),(51,'Marylène','Marylène\'s_Pa$$w0rd',1,1);
/*!40000 ALTER TABLE `members` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `migration_version`
--

DROP TABLE IF EXISTS `migration_version`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `migration_version` (
  `version` int(11) DEFAULT NULL,
  `status` varchar(20) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb3;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `migration_version`
--

LOCK TABLES `migration_version` WRITE;
/*!40000 ALTER TABLE `migration_version` DISABLE KEYS */;
INSERT INTO `migration_version` VALUES (1,'complete');
/*!40000 ALTER TABLE `migration_version` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `roles`
--

DROP TABLE IF EXISTS `roles`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `roles` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `slug` varchar(10) NOT NULL,
  `name` varchar(45) NOT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `name_UNIQUE` (`name`),
  UNIQUE KEY `slug_UNIQUE` (`slug`)
) ENGINE=InnoDB AUTO_INCREMENT=3 DEFAULT CHARSET=utf8mb4;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `roles`
--

LOCK TABLES `roles` WRITE;
/*!40000 ALTER TABLE `roles` DISABLE KEYS */;
INSERT INTO `roles` VALUES (1,'MEM','Member'),(2,'MOD','Moderator');
/*!40000 ALTER TABLE `roles` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `states`
--

DROP TABLE IF EXISTS `states`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `states` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `slug` varchar(10) NOT NULL,
  `name` varchar(45) NOT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `name_UNIQUE` (`name`),
  UNIQUE KEY `slug_UNIQUE` (`slug`)
) ENGINE=InnoDB AUTO_INCREMENT=6 DEFAULT CHARSET=utf8mb4;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `states`
--

LOCK TABLES `states` WRITE;
/*!40000 ALTER TABLE `states` DISABLE KEYS */;
INSERT INTO `states` VALUES (1,'WAIT_CHANG','Attente de chagement'),(2,'WAIT_VAL','Attente de validation'),(3,'VALIDATED','Validé'),(4,'COMMITTED','Engagée'),(5,'RECRUTING','Recrutement');
/*!40000 ALTER TABLE `states` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `status`
--

DROP TABLE IF EXISTS `status`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `status` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `slug` varchar(10) COLLATE utf8mb4_unicode_ci NOT NULL,
  `value` varchar(45) COLLATE utf8mb4_unicode_ci NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=4 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `status`
--

LOCK TABLES `status` WRITE;
/*!40000 ALTER TABLE `status` DISABLE KEYS */;
INSERT INTO `status` VALUES (1,'ACT','Active'),(2,'INA','Inactive'),(3,'BAN','Banned');
/*!40000 ALTER TABLE `status` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `team_member`
--

DROP TABLE IF EXISTS `team_member`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `team_member` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `member_id` int(11) NOT NULL,
  `team_id` int(11) NOT NULL,
  `membership_type` int(11) NOT NULL COMMENT '0 = inactive\n1 = active\n2 = invitation\n3 = request',
  `is_captain` tinyint(4) NOT NULL DEFAULT 0,
  PRIMARY KEY (`id`),
  UNIQUE KEY `unique_membership` (`member_id`,`team_id`),
  KEY `fk_team_member_members1_idx` (`member_id`),
  KEY `fk_team_member_teams1_idx` (`team_id`),
  CONSTRAINT `fk_team_member_members1` FOREIGN KEY (`member_id`) REFERENCES `members` (`id`) ON DELETE NO ACTION ON UPDATE NO ACTION,
  CONSTRAINT `fk_team_member_teams1` FOREIGN KEY (`team_id`) REFERENCES `teams` (`id`) ON DELETE NO ACTION ON UPDATE NO ACTION
) ENGINE=InnoDB AUTO_INCREMENT=63 DEFAULT CHARSET=utf8mb4;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `team_member`
--

LOCK TABLES `team_member` WRITE;
/*!40000 ALTER TABLE `team_member` DISABLE KEYS */;
INSERT INTO `team_member` VALUES (1,27,1,1,1),(2,2,1,2,0),(3,22,1,1,0),(4,4,1,1,0),(5,1,2,1,1),(6,20,2,3,0),(7,37,2,1,0),(8,31,3,1,1),(9,2,3,2,0),(10,3,3,2,0),(11,32,3,1,0),(12,5,3,1,0),(13,6,3,2,0),(14,4,4,1,1),(15,33,4,1,0),(16,20,4,3,0),(17,7,4,3,0),(18,5,5,1,1),(19,6,5,1,0),(20,7,5,2,0),(21,28,6,1,1),(22,36,6,1,0),(23,34,6,2,0),(24,10,6,1,0),(25,21,7,1,1),(26,38,7,3,0),(27,10,7,1,0),(28,8,8,1,1),(29,25,8,3,0),(30,10,8,1,0),(31,11,8,2,0),(32,12,8,1,0),(33,13,8,1,0),(34,39,9,1,1),(35,12,9,1,0),(36,13,9,0,0),(37,21,9,1,0),(38,40,10,1,1),(39,14,11,1,1),(40,14,12,1,1),(41,35,13,1,1),(42,18,14,1,1),(43,19,15,1,1),(44,25,10,0,0),(45,13,10,1,0),(46,15,11,1,0),(47,16,11,2,0),(48,29,11,3,0),(49,15,12,1,0),(50,16,12,0,0),(51,26,12,1,0),(52,18,12,2,0),(53,16,13,1,0),(54,17,13,3,0),(55,23,13,1,0),(56,19,13,2,0),(57,20,13,1,0),(58,27,14,0,0),(59,30,14,1,0),(60,20,15,2,0),(61,21,15,1,0),(62,24,15,3,0);
/*!40000 ALTER TABLE `team_member` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `teams`
--

DROP TABLE IF EXISTS `teams`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `teams` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `name` varchar(45) NOT NULL,
  `state_id` int(11) NOT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `name_UNIQUE` (`name`),
  KEY `fk_teams_states1_idx` (`state_id`),
  CONSTRAINT `fk_teams_states1` FOREIGN KEY (`state_id`) REFERENCES `states` (`id`) ON DELETE NO ACTION ON UPDATE NO ACTION
) ENGINE=InnoDB AUTO_INCREMENT=16 DEFAULT CHARSET=utf8mb4;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `teams`
--

LOCK TABLES `teams` WRITE;
/*!40000 ALTER TABLE `teams` DISABLE KEYS */;
INSERT INTO `teams` VALUES (1,'Suicide Squad',1),(2,'Les Fâchés',1),(3,'Les Semi-Croustillants',1),(4,'Les Pécors',1),(5,'Les Bouffons de Défi',1),(6,'Les Mugiwaras',1),(7,'La DreamTeam',1),(8,'Les StormTrooper',1),(9,'Les PoufSoufle',1),(10,'Les X-Files',1),(11,'Les Demi-Dieux',1),(12,'Les Squeezos',1),(13,'Les Chevaliers du Zodiaque',1),(14,'No Name',1),(15,'Black Lagoon',1);
/*!40000 ALTER TABLE `teams` ENABLE KEYS */;
UNLOCK TABLES;
/*!40103 SET TIME_ZONE=@OLD_TIME_ZONE */;

/*!40101 SET SQL_MODE=@OLD_SQL_MODE */;
/*!40014 SET FOREIGN_KEY_CHECKS=@OLD_FOREIGN_KEY_CHECKS */;
/*!40014 SET UNIQUE_CHECKS=@OLD_UNIQUE_CHECKS */;
/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
/*!40111 SET SQL_NOTES=@OLD_SQL_NOTES */;

-- Dump completed on 2021-11-12 12:06:33
