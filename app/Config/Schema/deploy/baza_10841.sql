
ALTER TABLE `photos` ADD `fabric_id` INT UNSIGNED NULL AFTER `line_id`;

ALTER TABLE `awning_fabrics` ADD `fabric_style_id` INT UNSIGNED NULL AFTER `photo_id`;

