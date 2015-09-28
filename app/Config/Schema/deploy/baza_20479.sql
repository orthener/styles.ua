-- Dodanie danych meta: keywords oraz description
ALTER TABLE `news_categories` ADD `metakey` VARCHAR( 255 ) CHARACTER SET utf8 COLLATE utf8_general_ci NULL DEFAULT NULL COMMENT 'słowa kluczowe znacznika meta' AFTER `name`;
ALTER TABLE `news_categories` ADD `metadesc` VARCHAR( 255 ) CHARACTER SET utf8 COLLATE utf8_general_ci NULL DEFAULT NULL COMMENT 'opis dla znacznika meta' AFTER `metakey`;
--
ALTER TABLE `brands` ADD `metakey` VARCHAR( 255 ) CHARACTER SET utf8 COLLATE utf8_general_ci NULL DEFAULT NULL COMMENT 'słowa kluczowe znacznika meta' AFTER `url`;
ALTER TABLE `brands` ADD `metadesc` VARCHAR( 255 ) CHARACTER SET utf8 COLLATE utf8_general_ci NULL DEFAULT NULL COMMENT 'opis dla znacznika meta' AFTER `metakey`;
-- 
ALTER TABLE `products` ADD `metakey` VARCHAR( 255 ) CHARACTER SET utf8 COLLATE utf8_general_ci NULL DEFAULT NULL COMMENT 'słowa kluczowe znacznika meta' AFTER `tax`;
ALTER TABLE `products` ADD `metadesc` VARCHAR( 255 ) CHARACTER SET utf8 COLLATE utf8_general_ci NULL DEFAULT NULL COMMENT 'opis dla znacznika meta' AFTER `metakey`;
--
ALTER TABLE `products_categories` ADD `metakey` VARCHAR( 255 ) CHARACTER SET utf8 COLLATE utf8_general_ci NULL DEFAULT NULL COMMENT 'słowa kluczowe znacznika meta' AFTER `rght`;
ALTER TABLE `products_categories` ADD `metadesc` VARCHAR( 255 ) CHARACTER SET utf8 COLLATE utf8_general_ci NULL DEFAULT NULL COMMENT 'opis dla znacznika meta' AFTER `metakey`;

 