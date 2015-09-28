--
CREATE TABLE IF NOT EXISTS `news_categories` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `name` varchar(255) NOT NULL COMMENT 'Nazwa kategorii newsĂłw',
  `created` datetime DEFAULT NULL,
  `modified` datetime DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 AUTO_INCREMENT=1 ;
--

ALTER TABLE `news` ADD `news_category_id` INT NOT NULL AFTER `date` 
ALTER TABLE `news` ADD `ad_code` TEXT CHARACTER SET utf8 COLLATE utf8_general_ci NULL DEFAULT NULL COMMENT 'Kod reklamy zewnętrznego reklamodawcy' AFTER `news_category_id` 