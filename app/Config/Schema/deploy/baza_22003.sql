DROP TABLE IF EXISTS `products_sizes`;

CREATE TABLE IF NOT EXISTS `products_sizes` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `product_id` int(10) NOT NULL,
  `name` varchar(20) DEFAULT NULL,
  `quantity` tinyint(6) NOT NULL,
  `created` datetime NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8