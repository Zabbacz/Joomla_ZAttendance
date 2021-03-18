CREATE TABLE IF NOT EXISTS `#__attendance` (
  `id` INT(11) UNSIGNED AUTO_INCREMENT PRIMARY KEY,
  `gymnastic_id` int(11) NOT NULL,
  `date` timestamp NOT NULL DEFAULT '0000-00-00 00:00:00',
  `note` varchar(255) DEFAULT NULL
  ) ENGINE=InnoDB DEFAULT CHARSET=utf8;
  CREATE TABLE IF NOT EXISTS `#__gymnastics` (
  `gymnastic_id` INT(11) UNSIGNED AUTO_INCREMENT PRIMARY KEY,
  `gymnastic_name` varchar(64) DEFAULT NULL,
  `beginning` timestamp NOT NULL DEFAULT '0000-00-00 00:00:00',
  `link_gis` varchar(255) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

