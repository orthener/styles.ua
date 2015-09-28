
ALTER TABLE `photos` ADD `awning_line_id` INT UNSIGNED NULL AFTER `window_line_id`;
ALTER TABLE `photos` CHANGE `awning_line_id` `line_id` INT( 10 ) UNSIGNED NULL DEFAULT NULL ;


-- --------------------------------------------------------

--
-- Struktura tabeli dla  `awning_accessories`
--

CREATE TABLE IF NOT EXISTS `awning_accessories` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `price_model` varchar(20) DEFAULT NULL COMMENT 'if not null take price from related model',
  `name` varchar(100) NOT NULL,
  `price` decimal(6,2) DEFAULT NULL COMMENT 'unit price',
  `created` datetime DEFAULT NULL,
  `modified` datetime DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 AUTO_INCREMENT=1 ;

-- --------------------------------------------------------

--
-- Struktura tabeli dla  `awning_accessories_configurations`
--

CREATE TABLE IF NOT EXISTS `awning_accessories_configurations` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `accessory_id` int(10) unsigned NOT NULL,
  `configuration_id` int(10) unsigned NOT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `awning_configuration_id` (`configuration_id`,`accessory_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 AUTO_INCREMENT=1 ;

-- --------------------------------------------------------

--
-- Struktura tabeli dla  `awning_configurations`
--

CREATE TABLE IF NOT EXISTS `awning_configurations` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `step` tinyint(3) unsigned NOT NULL DEFAULT '1',
  `max_step` tinyint(4) NOT NULL DEFAULT '1',
  `line_id` int(10) unsigned DEFAULT NULL,
  `construction_colour_id` int(10) unsigned DEFAULT NULL,
  `fabric_id` int(10) unsigned DEFAULT NULL,
  `fabric_style_id` int(10) unsigned DEFAULT NULL,
  `valance_id` int(10) unsigned DEFAULT NULL,
  `drive` enum('crank','motor') COLLATE utf8_unicode_ci DEFAULT NULL,
  `crank_id` int(10) unsigned DEFAULT NULL,
  `motor_id` int(10) unsigned DEFAULT NULL,
  `mounting_id` int(10) unsigned DEFAULT NULL,
  `width` int(10) unsigned DEFAULT NULL,
  `outreach` int(10) unsigned DEFAULT NULL COMMENT 'cm',
  `use_site` enum('left','right') COLLATE utf8_unicode_ci DEFAULT NULL,
  `price` decimal(7,2) DEFAULT NULL,
  `created` datetime DEFAULT NULL,
  `modified` datetime DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci AUTO_INCREMENT=1 ;

-- --------------------------------------------------------

--
-- Struktura tabeli dla  `awning_configurations_motor_options`
--

CREATE TABLE IF NOT EXISTS `awning_configurations_motor_options` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `configuration_id` int(10) unsigned NOT NULL,
  `motor_option_id` int(10) unsigned NOT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `awning_configuration_id` (`configuration_id`,`motor_option_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 AUTO_INCREMENT=1 ;

-- --------------------------------------------------------

--
-- Struktura tabeli dla  `awning_construction_colours`
--

CREATE TABLE IF NOT EXISTS `awning_construction_colours` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `name` varchar(255) COLLATE utf8_unicode_ci NOT NULL DEFAULT '',
  `color` char(6) COLLATE utf8_unicode_ci NOT NULL DEFAULT 'FFFFFF',
  `color_img` varchar(150) COLLATE utf8_unicode_ci DEFAULT NULL,
  `created` datetime DEFAULT NULL,
  `modified` datetime DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci AUTO_INCREMENT=6 ;

-- --------------------------------------------------------

--
-- Struktura tabeli dla  `awning_construction_colours_lines`
--

CREATE TABLE IF NOT EXISTS `awning_construction_colours_lines` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `construction_colour_id` int(10) unsigned NOT NULL,
  `line_id` int(10) unsigned NOT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `awning_line_id` (`line_id`,`construction_colour_id`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 AUTO_INCREMENT=14 ;

-- --------------------------------------------------------

--
-- Struktura tabeli dla  `awning_cranks`
--

CREATE TABLE IF NOT EXISTS `awning_cranks` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `name` varchar(15) NOT NULL,
  `created` datetime DEFAULT NULL,
  `modified` datetime DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 AUTO_INCREMENT=1 ;

-- --------------------------------------------------------

--
-- Struktura tabeli dla  `awning_fabrics`
--

CREATE TABLE IF NOT EXISTS `awning_fabrics` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `name` varchar(255) NOT NULL,
  `description` text,
  `price_factor` tinyint(3) unsigned NOT NULL DEFAULT '0' COMMENT '% additional payment',
  `photo_id` int(10) unsigned DEFAULT NULL,
  `created` datetime DEFAULT NULL,
  `modified` datetime DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8 AUTO_INCREMENT=1 ;

-- --------------------------------------------------------

--
-- Struktura tabeli dla  `awning_fabrics_valances`
--

CREATE TABLE IF NOT EXISTS `awning_fabrics_valances` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `fabric_id` int(10) unsigned NOT NULL,
  `valance_id` int(10) unsigned NOT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `awning_fabric_id` (`fabric_id`,`valance_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 AUTO_INCREMENT=1 ;

-- --------------------------------------------------------

--
-- Struktura tabeli dla  `awning_fabric_styles`
--

CREATE TABLE IF NOT EXISTS `awning_fabric_styles` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `img` varchar(255) COLLATE utf8_unicode_ci DEFAULT NULL,
  `slug` varchar(100) COLLATE utf8_unicode_ci NOT NULL,
  `fabric_id` int(10) unsigned NOT NULL,
  `title` varchar(255) COLLATE utf8_unicode_ci DEFAULT NULL,
  `x` int(11) DEFAULT NULL,
  `y` int(11) DEFAULT NULL,
  `order` int(6) unsigned NOT NULL DEFAULT '1',
  `modified` datetime NOT NULL,
  `created` datetime NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci AUTO_INCREMENT=1 ;

-- --------------------------------------------------------

--
-- Struktura tabeli dla  `awning_hood_prices`
--

CREATE TABLE IF NOT EXISTS `awning_hood_prices` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `min_width` int(10) unsigned DEFAULT NULL,
  `max_width` int(10) unsigned DEFAULT NULL,
  `price` decimal(6,2) NOT NULL COMMENT 'unit price',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 AUTO_INCREMENT=1 ;

-- --------------------------------------------------------

--
-- Struktura tabeli dla  `awning_lines`
--

CREATE TABLE IF NOT EXISTS `awning_lines` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `name` varchar(255) NOT NULL,
  `description` text,
  `price_factor` decimal(6,4) unsigned NOT NULL DEFAULT '1.0000',
  `price_margin` tinyint(3) unsigned NOT NULL DEFAULT '0',
  `photo_id` int(10) unsigned DEFAULT NULL,
  `created` datetime DEFAULT NULL,
  `modified` datetime DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM  DEFAULT CHARSET=utf8 AUTO_INCREMENT=4 ;

-- --------------------------------------------------------

--
-- Struktura tabeli dla  `awning_motors`
--

CREATE TABLE IF NOT EXISTS `awning_motors` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `name` varchar(100) NOT NULL,
  `price` decimal(6,2) NOT NULL COMMENT 'unit price',
  `created` datetime NOT NULL,
  `modified` datetime NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 AUTO_INCREMENT=1 ;

-- --------------------------------------------------------

--
-- Struktura tabeli dla  `awning_motor_options`
--

CREATE TABLE IF NOT EXISTS `awning_motor_options` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `motor_id` int(10) unsigned NOT NULL,
  `name` varchar(100) NOT NULL,
  `price` decimal(6,2) NOT NULL COMMENT 'unit price',
  `created` datetime NOT NULL,
  `modified` datetime NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 AUTO_INCREMENT=1 ;

-- --------------------------------------------------------

--
-- Struktura tabeli dla  `awning_mountings`
--

CREATE TABLE IF NOT EXISTS `awning_mountings` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `name` varchar(100) NOT NULL,
  `created` datetime NOT NULL,
  `modified` datetime NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 AUTO_INCREMENT=4 ;

-- --------------------------------------------------------

--
-- Struktura tabeli dla  `awning_mounting_console_prices`
--

CREATE TABLE IF NOT EXISTS `awning_mounting_console_prices` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `line_id` int(10) unsigned NOT NULL,
  `mounting_id` int(10) unsigned NOT NULL,
  `price` decimal(6,2) NOT NULL DEFAULT '0.00' COMMENT 'unit price',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 AUTO_INCREMENT=5 ;

-- --------------------------------------------------------

--
-- Struktura tabeli dla  `awning_mounting_console_quantities`
--

CREATE TABLE IF NOT EXISTS `awning_mounting_console_quantities` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `line_id` int(10) unsigned NOT NULL,
  `min_width` int(10) unsigned DEFAULT NULL,
  `max_width` int(10) unsigned DEFAULT NULL,
  `quantity` tinyint(4) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 AUTO_INCREMENT=4 ;

-- --------------------------------------------------------

--
-- Struktura tabeli dla  `awning_sizes`
--

CREATE TABLE IF NOT EXISTS `awning_sizes` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `line_id` int(10) unsigned NOT NULL,
  `outreach` smallint(5) unsigned NOT NULL COMMENT 'cm',
  `width_from` smallint(5) unsigned DEFAULT NULL COMMENT 'cm',
  `width_to` smallint(5) unsigned NOT NULL COMMENT 'cm',
  `price` decimal(6,2) unsigned DEFAULT NULL,
  `created` datetime DEFAULT NULL,
  `modified` datetime DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci AUTO_INCREMENT=1 ;

-- --------------------------------------------------------

--
-- Struktura tabeli dla  `awning_valances`
--

CREATE TABLE IF NOT EXISTS `awning_valances` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `img` varchar(255) COLLATE utf8_unicode_ci DEFAULT NULL,
  `title` varchar(255) COLLATE utf8_unicode_ci DEFAULT NULL,
  `price` decimal(6,2) NOT NULL DEFAULT '0.00' COMMENT 'real price is price * width (m)',
  `modified` datetime NOT NULL,
  `created` datetime NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci AUTO_INCREMENT=1 ;

