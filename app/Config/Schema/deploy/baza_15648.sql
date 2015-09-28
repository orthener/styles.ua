
ALTER TABLE `window_accessories_window_configurations` ADD `quantity` INT NOT NULL DEFAULT '1';

ALTER TABLE `window_accessories` ADD `jm` VARCHAR( 20 ) NOT NULL DEFAULT 'szt';

ALTER TABLE `window_accessories` ADD `price_color_1` DECIMAL( 8, 2 ) UNSIGNED NOT NULL AFTER `price` ,
ADD `price_color_2` DECIMAL( 8, 2 ) UNSIGNED NOT NULL AFTER `price_color_1` ;

ALTER TABLE `window_accessories` CHANGE `price_color_1` `price_color_1` DECIMAL( 8, 2 ) UNSIGNED NULL DEFAULT NULL ,
CHANGE `price_color_2` `price_color_2` DECIMAL( 8, 2 ) UNSIGNED NULL DEFAULT NULL ;

ALTER TABLE `window_accessories_window_configurations` CHANGE `quantity` `quantity` DECIMAL( 9, 3 ) NOT NULL DEFAULT '1';


