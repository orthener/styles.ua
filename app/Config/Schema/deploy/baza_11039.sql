
ALTER TABLE `window_lines` DROP `name` , DROP `description` ;


ALTER TABLE `window_colors` DROP `name`;

ALTER TABLE `glass_patterned_types`
  DROP `name`,
  DROP `description`;

ALTER TABLE `glass_types`
  DROP `name`,
  DROP `description`;

ALTER TABLE `glass_types_categories`
  DROP `name`,
  DROP `description`;


ALTER TABLE `sash_types` DROP `name`;


ALTER TABLE `window_bar_types` DROP `name`;


ALTER TABLE `window_color_groups` DROP `name`;

ALTER TABLE `window_fittings`
  DROP `name`,
  DROP `description`;

ALTER TABLE `window_handlers`
  DROP `name`,
  DROP `type`,
  DROP `color`;

ALTER TABLE `window_seal_colors` DROP `name`;


