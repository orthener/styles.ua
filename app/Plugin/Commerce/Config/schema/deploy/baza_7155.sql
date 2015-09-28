DROP TABLE `order_item_files`;

CREATE TABLE IF NOT EXISTS `order_item_files` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `order_item_id` int(10) unsigned NOT NULL,
  `name` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `accepted` tinyint(2) NOT NULL DEFAULT '0',
  `desc` text COLLATE utf8_unicode_ci,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;