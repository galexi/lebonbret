-- MySQL dump 10.13  Distrib 5.7.21, for Linux (x86_64)
--
-- Host: localhost    Database: skills_detector
-- ------------------------------------------------------
-- Server version	5.7.21-0ubuntu0.16.04.1

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
-- Table structure for table `competence`
--

DROP TABLE IF EXISTS `competence`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `competence` (
  `id_c` int(5) NOT NULL AUTO_INCREMENT,
  `titre` varchar(64) DEFAULT NULL,
  `categorie` varchar(32) DEFAULT NULL,
  PRIMARY KEY (`id_c`)
) ENGINE=InnoDB AUTO_INCREMENT=10 DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `competence`
--

LOCK TABLES `competence` WRITE;
/*!40000 ALTER TABLE `competence` DISABLE KEYS */;
INSERT INTO `competence` VALUES (1,'Nettoyer son ordinateur','informatique'),(2,'Changer une carte mère','informatique'),(3,'Conception de massifs','jardin'),(4,'Taille de haie','jardin'),(5,'Elagage tout arbre','jardin'),(6,'Cuisiner du boeuf Bourguignon','cuisine'),(7,'Conseils Divers','cuisine'),(8,'Changer évier','bricolage'),(9,'Changer des plaquettes de freins','mécanique auto');
/*!40000 ALTER TABLE `competence` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `lieu`
--

DROP TABLE IF EXISTS `lieu`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `lieu` (
  `id_l` int(5) NOT NULL AUTO_INCREMENT,
  `nom` varchar(32) DEFAULT NULL,
  `dist` int(5) DEFAULT NULL,
  PRIMARY KEY (`id_l`)
) ENGINE=InnoDB AUTO_INCREMENT=11 DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `lieu`
--

LOCK TABLES `lieu` WRITE;
/*!40000 ALTER TABLE `lieu` DISABLE KEYS */;
INSERT INTO `lieu` VALUES (1,'Toulouse',0),(2,'Ramonville St-Agne',10),(3,'Blagnac',8),(4,'St-Orens de Gameville',13),(5,'Castanet-Tolosan',14),(6,'Léguevin',19),(7,'Pechbonnieu',13),(8,'Albi',76),(9,'Castres',77),(10,'Cahors',114);
/*!40000 ALTER TABLE `lieu` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `message`
--

DROP TABLE IF EXISTS `message`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `message` (
  `id_m` int(10) NOT NULL AUTO_INCREMENT,
  `horodatage` datetime DEFAULT NULL,
  `contenu` varchar(300) DEFAULT NULL,
  `id_u` int(5) DEFAULT NULL,
  `id_conv` varchar(13) DEFAULT NULL,
  PRIMARY KEY (`id_m`),
  KEY `id_u` (`id_u`),
  CONSTRAINT `message_ibfk_1` FOREIGN KEY (`id_u`) REFERENCES `utilisateur` (`id_u`)
) ENGINE=InnoDB AUTO_INCREMENT=134 DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `message`
--

LOCK TABLES `message` WRITE;
/*!40000 ALTER TABLE `message` DISABLE KEYS */;
INSERT INTO `message` VALUES (1,'2018-03-27 11:09:13','Bonjour, etes-vous disponible le 4 ?',3,'1'),(2,'2018-03-27 11:30:24','Oui tout a fais',1,'1'),(27,'2018-03-27 16:36:23','Hey',1,'1'),(28,'2018-03-27 16:37:04','hello',2,'1'),(29,'2018-03-27 16:37:18','bite',2,'1'),(30,'2018-03-27 18:41:25','Hello',1,'1'),(31,'2018-03-27 18:41:41','jel',2,'1'),(32,'2018-03-27 18:41:50','hey',2,'1'),(33,'2018-03-27 18:41:52','yo',1,'1'),(34,'2018-03-27 18:45:55','hey',1,'1'),(35,'2018-03-27 19:03:42','lol',2,'1'),(36,'2018-03-27 19:04:10','haha',2,'1'),(37,'2018-03-27 19:04:25','bjr',1,'1'),(38,'2018-03-27 19:04:41','Ca va ?',1,'1'),(39,'2018-03-27 19:04:44','Oui',2,'1'),(40,'2018-03-27 19:13:55','ds',1,'1'),(41,'2018-03-27 19:14:00','ds',3,'1'),(42,'2018-03-27 19:14:12','hey',1,'1'),(43,'2018-03-27 19:17:24','Salut',1,'1'),(44,'2018-03-27 19:17:28','Hey',3,'1'),(45,'2018-03-27 19:17:32','Ca va ?',1,'1'),(46,'2018-03-27 19:17:37','Oui',3,'1'),(47,'2018-03-27 19:18:24','e',1,'1'),(48,'2018-03-27 19:18:27',' ?',3,'1'),(49,'2018-03-27 19:20:42','Oh',1,'1'),(50,'2018-03-27 19:24:28','hey',1,'1'),(51,'2018-03-27 19:24:37','Ca va ??',3,'1'),(52,'2018-03-27 19:24:38','s',3,'1'),(53,'2018-03-27 19:24:38','d',3,'1'),(54,'2018-03-27 19:24:39','d',3,'1'),(55,'2018-03-27 19:24:39','s',3,'1'),(56,'2018-03-27 19:24:39','d',3,'1'),(57,'2018-03-27 19:24:40','d',3,'1'),(58,'2018-03-27 19:24:40','d',3,'1'),(59,'2018-03-27 19:24:40','d',3,'1'),(60,'2018-03-27 19:24:41','dd',3,'1'),(61,'2018-03-27 19:24:41','d',3,'1'),(62,'2018-03-27 19:24:42','d',3,'1'),(63,'2018-03-27 19:24:42','fd',3,'1'),(64,'2018-03-27 19:24:43','fd',3,'1'),(65,'2018-03-27 19:24:43','fd',3,'1'),(66,'2018-03-27 19:24:44','fd',3,'1'),(67,'2018-03-27 19:24:45','fd',3,'1'),(68,'2018-03-27 19:24:47','hey',3,'1'),(69,'2018-03-27 19:25:05','plo',3,'1'),(70,'2018-03-27 19:25:13','gyuiop',1,'1'),(71,'2018-03-27 19:26:16','coucou',3,'1'),(72,'2018-03-27 19:26:35','bonjour',1,'1'),(74,'2018-03-27 19:27:02','vdvfs',1,'1'),(75,'2018-03-27 19:27:05','dsqd',3,'1'),(76,'2018-03-27 19:43:14','hey',3,'1'),(77,'2018-03-27 20:20:05','',1,'1'),(78,'2018-03-27 20:30:44','hey',3,'1'),(79,'2018-03-27 20:30:50','salut',1,'1'),(80,'2018-03-27 20:36:30','yop',3,'1'),(81,'2018-03-27 20:40:34','Hey',3,'1'),(82,'2018-03-27 20:40:40','ha',1,'1'),(83,'2018-03-27 20:46:32','hÃ©hÃ©',1,'1'),(84,'2018-03-27 20:46:59','w&w&w&w\"wÃ§_Ã¨-(\'\"\'(\'-(Ã¨-_Ã¨Ã§_Ã Ã§)Ã ',3,'1'),(85,'2018-03-27 20:47:10','plop',3,'1'),(86,'2018-03-27 21:03:02','hey',1,'2'),(87,'2018-03-27 21:03:08','ca va ?',2,'2'),(88,'2018-03-27 21:03:13','Oui oui',1,'2'),(113,'2018-03-27 23:46:39','Coucou',2,'c81e728d9d4c'),(114,'2018-03-27 23:46:55','Heeey',3,'c81e728d9d4c'),(115,'2018-03-27 23:48:53','hey',2,'c81e728d9d4c'),(116,'2018-03-27 23:54:39','je te baise cochonne',3,'c81e728d9d4c'),(117,'2018-03-27 23:54:49','non',2,'c81e728d9d4c'),(118,'2018-03-28 00:09:13','dsq',2,'c81e728d9d4c'),(119,'2018-03-28 00:12:38','efds',3,'c81e728d9d4c'),(120,'2018-03-28 00:12:41','fds',2,'c81e728d9d4c'),(121,'2018-03-28 00:13:45','fluf',2,'c81e728d9d4c'),(122,'2018-03-28 00:14:03','cchibre',2,'c81e728d9d4c'),(123,'2018-03-28 00:14:14','kbkbjbkj',3,'c81e728d9d4c'),(124,'2018-03-28 00:17:11','hahaha',2,'2'),(125,'2018-03-28 00:17:14','????',1,'2'),(126,'2018-03-28 10:03:01','oui*',2,'2'),(127,'2018-03-28 10:03:09','la gauuuuuule',1,'2'),(128,'2018-03-28 10:03:37','hey',2,'c81e728d9d4c'),(133,'2018-03-28 10:56:40','hehe',1,'2');
/*!40000 ALTER TABLE `message` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `participer`
--

DROP TABLE IF EXISTS `participer`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `participer` (
  `id_u` int(5) NOT NULL,
  `id_conv` varchar(13) NOT NULL,
  PRIMARY KEY (`id_u`,`id_conv`),
  CONSTRAINT `fk_1234` FOREIGN KEY (`id_u`) REFERENCES `utilisateur` (`id_u`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `participer`
--

LOCK TABLES `participer` WRITE;
/*!40000 ALTER TABLE `participer` DISABLE KEYS */;
INSERT INTO `participer` VALUES (1,'1'),(1,'2'),(2,'2'),(2,'c81e728d9d4c'),(3,'1'),(3,'c81e728d9d4c');
/*!40000 ALTER TABLE `participer` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `posseder`
--

DROP TABLE IF EXISTS `posseder`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `posseder` (
  `id_u` int(5) NOT NULL DEFAULT '0',
  `id_c` int(5) NOT NULL DEFAULT '0',
  `desc` varchar(300) DEFAULT NULL,
  `dispo_jour` varchar(20) DEFAULT NULL,
  `dispo_heure` time NOT NULL,
  PRIMARY KEY (`id_u`,`id_c`),
  KEY `id_c` (`id_c`),
  CONSTRAINT `posseder_ibfk_1` FOREIGN KEY (`id_c`) REFERENCES `competence` (`id_c`),
  CONSTRAINT `posseder_ibfk_2` FOREIGN KEY (`id_u`) REFERENCES `utilisateur` (`id_u`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `posseder`
--

LOCK TABLES `posseder` WRITE;
/*!40000 ALTER TABLE `posseder` DISABLE KEYS */;
INSERT INTO `posseder` VALUES (1,1,'Dépoussiérage logiciel de votre compagnon de route.','Vendredi','18:00:00'),(1,2,'Ce n\'est pas une tâche aisée !','Samedi','14:30:00'),(2,3,'Je peux choisir les plantes pour vous ou bien réaranger un massif existant.','Dimanche','15:30:00'),(3,9,'Aide pour tout modèle de voiture.','Mardi','18:15:00');
/*!40000 ALTER TABLE `posseder` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `prendre`
--

DROP TABLE IF EXISTS `prendre`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `prendre` (
  `id_u` int(5) NOT NULL DEFAULT '0',
  `id_r` int(5) NOT NULL DEFAULT '0',
  PRIMARY KEY (`id_u`,`id_r`),
  KEY `id_r` (`id_r`),
  CONSTRAINT `prendre_ibfk_1` FOREIGN KEY (`id_r`) REFERENCES `rdv` (`id_r`),
  CONSTRAINT `prendre_ibfk_2` FOREIGN KEY (`id_u`) REFERENCES `utilisateur` (`id_u`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `prendre`
--

LOCK TABLES `prendre` WRITE;
/*!40000 ALTER TABLE `prendre` DISABLE KEYS */;
INSERT INTO `prendre` VALUES (1,1),(3,1),(1,2),(2,2);
/*!40000 ALTER TABLE `prendre` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `rdv`
--

DROP TABLE IF EXISTS `rdv`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `rdv` (
  `id_r` int(5) NOT NULL AUTO_INCREMENT,
  `horaire` datetime DEFAULT NULL,
  `titre` varchar(32) DEFAULT NULL,
  `etat` tinyint(4) DEFAULT NULL,
  PRIMARY KEY (`id_r`)
) ENGINE=InnoDB AUTO_INCREMENT=3 DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `rdv`
--

LOCK TABLES `rdv` WRITE;
/*!40000 ALTER TABLE `rdv` DISABLE KEYS */;
INSERT INTO `rdv` VALUES (1,'2018-04-04 18:00:00','Changement de la CM de Géraldine',0),(2,'2018-04-08 15:30:00','Massif de rosier chez Patrice ',1);
/*!40000 ALTER TABLE `rdv` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `utilisateur`
--

DROP TABLE IF EXISTS `utilisateur`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `utilisateur` (
  `id_u` int(5) NOT NULL AUTO_INCREMENT,
  `nom` varchar(32) DEFAULT NULL,
  `prenom` varchar(32) DEFAULT NULL,
  `mail` varchar(64) NOT NULL,
  `d_naiss` date DEFAULT NULL,
  `mdp` varchar(32) DEFAULT NULL,
  `photo` varchar(64) DEFAULT NULL,
  `bio` varchar(300) DEFAULT NULL,
  `id_l` int(5) DEFAULT NULL,
  PRIMARY KEY (`id_u`),
  KEY `id_l` (`id_l`),
  CONSTRAINT `utilisateur_ibfk_1` FOREIGN KEY (`id_l`) REFERENCES `lieu` (`id_l`)
) ENGINE=InnoDB AUTO_INCREMENT=4 DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `utilisateur`
--

LOCK TABLES `utilisateur` WRITE;
/*!40000 ALTER TABLE `utilisateur` DISABLE KEYS */;
INSERT INTO `utilisateur` VALUES (1,'Patrice','Martin','pmartin@mail.fr','1958-12-15','toto','/images/comptes/pmartin-1.png','Ancien ingénieur en informatique, je propose mes services pour les petites tâches d\'entretiens que nécessite votre PC.',5),(2,'Emilie','Lion','elion@mail.fr','1988-08-21','toto','/images/comptes/elion-2.png','Bonjour, passionée de nature, je suis disponible pour tout conseil botanique !',9),(3,'Geraldine','Noll','gnoll@mail.fr','1979-05-04','toto','/images/comptes/gnoll-3.png','Conseils en mécanique auto.',3);
/*!40000 ALTER TABLE `utilisateur` ENABLE KEYS */;
UNLOCK TABLES;
/*!40103 SET TIME_ZONE=@OLD_TIME_ZONE */;

/*!40101 SET SQL_MODE=@OLD_SQL_MODE */;
/*!40014 SET FOREIGN_KEY_CHECKS=@OLD_FOREIGN_KEY_CHECKS */;
/*!40014 SET UNIQUE_CHECKS=@OLD_UNIQUE_CHECKS */;
/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
/*!40111 SET SQL_NOTES=@OLD_SQL_NOTES */;

-- Dump completed on 2018-03-28 10:59:24
