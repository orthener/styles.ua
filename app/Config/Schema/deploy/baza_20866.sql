ALTER TABLE `news_categories` ADD `is_promoted` TINYINT(1) NOT NULL DEFAULT '0' COMMENT 'jeśli flaga jest na 1 to kategoria jest promowana, 0 w przeciwnym przypadku' AFTER `name`;
