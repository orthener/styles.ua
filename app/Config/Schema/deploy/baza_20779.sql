
ALTER TABLE `products` ADD `hit_counter` BIGINT UNSIGNED NOT NULL DEFAULT '0' COMMENT 'Licznik wejść' AFTER `popular`;