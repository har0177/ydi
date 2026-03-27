-- Run this SQL to create the alumni table
CREATE TABLE IF NOT EXISTS `alumni` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `title` varchar(255) NOT NULL,
  `desg` varchar(255) DEFAULT NULL,
  `image` varchar(255) DEFAULT NULL,
  `alumni_order` int(11) DEFAULT 1,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;
