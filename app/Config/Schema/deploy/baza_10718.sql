
CREATE TABLE IF NOT EXISTS `sashes_layouts` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `code` varchar(10) NOT NULL,
  `name` varchar(60) NOT NULL,
  `description` text NOT NULL,
  `created` datetime DEFAULT NULL,
  `modified` datetime DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 AUTO_INCREMENT=1 ;

ALTER TABLE `window_configurations` ADD `sashes_layout_id` INT UNSIGNED NULL AFTER `window_fitting_id`;


CREATE TABLE `sashes_layouts_sash_types` (
`id` INT UNSIGNED NOT NULL AUTO_INCREMENT PRIMARY KEY ,
`sashes_layout_id` INT UNSIGNED NOT NULL ,
`sash_type_id` INT UNSIGNED NOT NULL
) ENGINE = InnoDB;


ALTER TABLE `sashes_layouts`
  DROP `name`,
  DROP `description`;

ALTER TABLE `sashes_layouts` ADD `order` TINYINT NOT NULL AFTER `id`;

ALTER TABLE `window_configuration_records` ADD `sliding_sash_width` INT UNSIGNED NULL AFTER `width` ;


--
-- Zrzut danych tabeli `sashes_layouts`
--

INSERT INTO `sashes_layouts` (`id`, `order`, `code`, `created`, `modified`) VALUES
(1, 1, 'horizontal', '2012-05-09 13:28:29', '2012-05-09 13:32:47'),
(2, 3, 'vertical', '2012-05-09 13:33:09', '2012-05-09 13:34:06'),
(3, 5, 'psk', '2012-05-09 13:33:53', '2012-05-09 13:43:11');


INSERT INTO `sashes_layouts_sash_types` (`id`, `sashes_layout_id`, `sash_type_id`) VALUES
(16, 1, 1),
(17, 1, 2),
(18, 1, 3),
(19, 1, 4),
(20, 1, 5),
(26, 2, 1),
(27, 2, 2),
(28, 2, 3),
(29, 2, 4),
(30, 2, 5),
(31, 3, 6);


INSERT INTO `i18n` (`locale`, `model`, `foreign_key`, `field`, `content`) VALUES
('pol', 'SashesLayout', '1', 'name', 'Poziome'),
('deu', 'SashesLayout', '1', 'name', 'Horizontal'),
('pol', 'SashesLayout', '1', 'description', ''),
('deu', 'SashesLayout', '1', 'description', ''),
('deu', 'SashesLayout', '2', 'name', 'Vertical'),
('deu', 'SashesLayout', '2', 'description', ''),
('deu', 'SashesLayout', '3', 'name', 'PSK-Tür'),
('deu', 'SashesLayout', '3', 'description', ''),
('pol', 'SashesLayout', '2', 'name', 'Pionowe'),
('pol', 'SashesLayout', '2', 'description', ''),
('pol', 'SashesLayout', '3', 'name', 'Drzwi PSK'),
('pol', 'SashesLayout', '3', 'description', '');
