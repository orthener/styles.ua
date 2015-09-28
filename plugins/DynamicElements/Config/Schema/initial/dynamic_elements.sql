
--
-- Struktura tabeli dla  `dynamic_elements`
--

CREATE TABLE IF NOT EXISTS `dynamic_elements` (
  `id` char(36) character set utf8 collate utf8_bin NOT NULL,
  `name` varchar(30) collate utf8_unicode_ci NOT NULL,
  `slug` varchar(30) collate utf8_unicode_ci NOT NULL,
  `content` text collate utf8_unicode_ci NOT NULL,
  `style` varchar(255) collate utf8_unicode_ci NOT NULL,
  `created` datetime default NULL,
  `modified` datetime default NULL,
  PRIMARY KEY  (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

