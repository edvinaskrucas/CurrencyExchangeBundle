DROP TABLE IF EXISTS `cache`;

CREATE TABLE `cache` (
  `id` int(11) unsigned NOT NULL AUTO_INCREMENT,
  `ck` varchar(255) NOT NULL DEFAULT '',
  `rate` double(8,4) NOT NULL,
  `provider` varchar(255) NOT NULL DEFAULT '',
  `date` int(11) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;