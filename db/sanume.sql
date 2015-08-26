/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `info` (
  `sitename` varchar(20) NOT NULL,
  `sitetag` varchar(100) NOT NULL,
  `disclaimer` varchar(1000) NOT NULL,
  `webmaster` varchar(100) NOT NULL,
  PRIMARY KEY (`sitename`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;
INSERT INTO `info` VALUES ('Tireayä Sänume','Na\'vi Grammar Done Simply','This site is not affiliated with the official Avatar website, James Cameron, or the Twentieth Century-Fox Film Corporation. All trademarks and servicemarks are the properties of their respective owners.','tirea@learnnavi.org');
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `lessons` (
  `id` int(10) NOT NULL,
  `title` varchar(100) NOT NULL,
  `body` varchar(10000) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;
/*!40101 SET character_set_client = @saved_cs_client */;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `navitems` (
  `id` int(10) NOT NULL,
  `en_name` varchar(40) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;
/*!40101 SET character_set_client = @saved_cs_client */;
INSERT INTO `navitems` VALUES (0,'Home'),(1,'Sounds'),(2,'Grammar'),(3,'Links'),(4,'Downloads');
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `pages` (
  `id` int(10) NOT NULL,
  `title` varchar(100) NOT NULL,
  `body` varchar(10000) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;
/*!40101 SET character_set_client = @saved_cs_client */;
INSERT INTO `pages` VALUES (0,'Oel Ngati Kameie','<p>Welcome to my new Lessons Website!</p><p>Currently under construction...</p>');
