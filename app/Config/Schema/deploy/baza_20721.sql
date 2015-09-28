ALTER TABLE `news` ADD `is_published` TINYINT( 1 ) UNSIGNED NOT NULL DEFAULT '0' COMMENT 'Czy wpis ma być publikowany (1 -tak, 0 -nie)' AFTER `main` 
-- ustawiamy stare newsy na aktualne
UPDATE `news` SET `is_published` = 1 WHERE 1 