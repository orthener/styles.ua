
ALTER TABLE `awning_accessories` DROP `name`;

ALTER TABLE `awning_construction_colours` DROP `name`;

ALTER TABLE `awning_cranks` DROP `name`;

ALTER TABLE `awning_fabrics`
  DROP `name`,
  DROP `description`;

ALTER TABLE `awning_lines`
  DROP `name`,
  DROP `description`;

ALTER TABLE `awning_motors` DROP `name`;

ALTER TABLE `awning_motor_options` DROP `name`;

ALTER TABLE `awning_mountings` DROP `name`;

ALTER TABLE `awning_accessories` ADD `img` VARCHAR( 255 ) NULL AFTER `price` ;

