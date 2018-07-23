
# Dump of table login_data
# ------------------------------------------------------------

DROP TABLE IF EXISTS `login_data`;

CREATE TABLE `login_data` (
  `id` int(11) unsigned NOT NULL AUTO_INCREMENT,
  `site_id` int(11) NOT NULL,
  `user_id` int(11) NOT NULL,
  `user_name` varchar(40) NOT NULL DEFAULT '',
  `password` varchar(250) NOT NULL DEFAULT '',
  PRIMARY KEY (`id`),
  UNIQUE KEY `Site User` (`site_id`,`user_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

LOCK TABLES `login_data` WRITE;
/*!40000 ALTER TABLE `login_data` DISABLE KEYS */;

INSERT INTO `login_data` (`id`, `site_id`, `user_id`, `user_name`, `password`)
VALUES
	(1,1,1,'lemur@easy.com','replace with hashed value'),
	(2,1,2,'bbleafturtle@tnaquariaum.com','replace with hashed value');

/*!40000 ALTER TABLE `login_data` ENABLE KEYS */;
UNLOCK TABLES;


# Dump of table sites
# ------------------------------------------------------------

DROP TABLE IF EXISTS `sites`;

CREATE TABLE `sites` (
  `id` int(11) unsigned NOT NULL AUTO_INCREMENT,
  `name` varchar(255) NOT NULL DEFAULT '',
  `address_line_1` varchar(255) NOT NULL DEFAULT '',
  `address_line_2` varchar(255) DEFAULT NULL,
  `address_line_3` varchar(255) DEFAULT NULL,
  `city` varchar(40) NOT NULL DEFAULT '',
  `state` varchar(40) NOT NULL DEFAULT '',
  `country` varchar(40) NOT NULL DEFAULT '',
  `code_zip_or_postal` varchar(40) NOT NULL DEFAULT '',
  `phone_country_code` int(10) NOT NULL,
  `phone_area_code` int(10) NOT NULL,
  `phone` int(10) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

LOCK TABLES `sites` WRITE;
/*!40000 ALTER TABLE `sites` DISABLE KEYS */;

INSERT INTO `sites` (`id`, `name`, `address_line_1`, `address_line_2`, `address_line_3`, `city`, `state`, `country`, `code_zip_or_postal`, `phone_country_code`, `phone_area_code`, `phone`)
VALUES
	(1,'Long of Athens','Chevrolet Buick GMC of Athens TN','1900 Congress Parkway South',NULL,'Athens','Tennessee','USA','37030',1,423,7451962);

/*!40000 ALTER TABLE `sites` ENABLE KEYS */;
UNLOCK TABLES;


# Dump of table users
# ------------------------------------------------------------

DROP TABLE IF EXISTS `users`;

CREATE TABLE `users` (
  `id` int(11) unsigned NOT NULL AUTO_INCREMENT,
  `site_id` int(11) NOT NULL,
  `email` varchar(90) NOT NULL DEFAULT '',
  `name_first` varchar(40) DEFAULT '',
  `name_last` varchar(40) DEFAULT '',
  `address_line_1` varchar(250) DEFAULT '',
  `address_line_2` varchar(250) DEFAULT NULL,
  `address_line_3` varchar(250) DEFAULT NULL,
  `city` varchar(40) DEFAULT '',
  `state` varchar(40) DEFAULT NULL,
  `country` varchar(40) DEFAULT NULL,
  `code_zip_or_postal` varchar(40) DEFAULT NULL,
  `phone_home` int(10) DEFAULT NULL,
  `phone_cell` int(10) DEFAULT NULL,
  `area_code` int(10) DEFAULT NULL,
  `country_code` int(10) DEFAULT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `Site User` (`site_id`,`email`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

LOCK TABLES `users` WRITE;
/*!40000 ALTER TABLE `users` DISABLE KEYS */;

INSERT INTO `users` (`id`, `site_id`, `email`, `name_first`, `name_last`, `address_line_1`, `address_line_2`, `address_line_3`, `city`, `state`, `country`, `code_zip_or_postal`, `phone_home`, `phone_cell`, `area_code`, `country_code`)
VALUES
	(1,1,'lemur@tnaquariaum.com','Red','Lemur','c/o Tennessee Aquariaum Lemur Forest','1 Broad St',NULL,'Chattanooga','Tennessee','USA','37402',2620695,NULL,800,11),
	(2,1,'bbleafturtle@tnaquariaum.com','Black-Breasted Leaf','Turtle','c/o Tennessee Aquariaum Rivers of the World','1 Broad St',NULL,'Chattanooga','Tennessee','USA','37402',2620695,NULL,800,11);

/*!40000 ALTER TABLE `users` ENABLE KEYS */;
UNLOCK TABLES;

