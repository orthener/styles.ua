

--
-- Struktura tabeli dla  `payments`
--

CREATE TABLE IF NOT EXISTS `payments` (
  `id` int(10) unsigned NOT NULL auto_increment,
  `user_plugin` varchar(255) default NULL,
  `user_model` varchar(255) NOT NULL,
  `user_row_id` char(36) NOT NULL,
  `related_plugin` varchar(255) default NULL,
  `related_model` varchar(255) NOT NULL,
  `related_row_id` char(36) character set utf8 collate utf8_bin NOT NULL,
  `client_ip` varchar(255) default  NULL,
  `payment_gate` varchar(255) NOT NULL default 'platnosci.pl',
  `title` varchar(255) NOT NULL default '',
  `amount` decimal(10,2) NOT NULL,
  `created` datetime default NULL,
  `modified` datetime default NULL,
  `payment_date` datetime default NULL,
  `status` tinyint(4) default NULL,
  `email_confirm` smallint(6) NOT NULL default '0',
  `platnosci_status` varchar(255) default NULL,
  `platnosci_pay_type` varchar(10) default NULL,
  `platnosci_amount` int(11) default NULL,
  `platnosci_desc` varchar(50) default NULL,
  `platnosci_desc2` varchar(255) default NULL,
  `platnosci_firstname` varchar(100) default NULL,
  `platnosci_lastname` varchar(100) default NULL,
  PRIMARY KEY  (`id`)
) ENGINE=MyISAM  DEFAULT CHARSET=utf8;

CREATE TABLE IF NOT EXISTS `invoices` (
  `id` int(10) unsigned NOT NULL auto_increment,
  `price_type` tinyint(1) default NULL COMMENT '0 - cena liczona od netto (PRICE_NET), 1 - cena liczona od brutto (PRICE_GROSS)',
  `number_prefix` varchar(50) collate utf8_unicode_ci NOT NULL,
  `number_int` mediumint(8) unsigned NOT NULL,
  `number_period` varchar(10) collate utf8_unicode_ci NOT NULL,
  `number_sufix` varchar(50) collate utf8_unicode_ci NOT NULL,
  `number` varchar(100) collate utf8_unicode_ci NOT NULL,
  `invoice_date` date NULL,
  `pdf` varchar(255) collate utf8_unicode_ci default NULL,
  `related_plugin` varchar(255) collate utf8_unicode_ci default NULL,
  `related_model` varchar(255) collate utf8_unicode_ci default NULL,
  `related_row_id` char(36) collate utf8_unicode_ci default NULL,
  `seller` text collate utf8_unicode_ci,
  `buyer_is_company` tinyint(1) default NULL,
  `buyer` text collate utf8_unicode_ci,
  `items` text collate utf8_unicode_ci,
  `payments` text collate utf8_unicode_ci NOT NULL,
  `taxes` text collate utf8_unicode_ci,
  `total_net` decimal(10,2) default NULL,
  `total_tax` decimal(10,2) default NULL,
  `total_gross` decimal(10,2) default NULL,
  `total_paid` decimal(10,2) NOT NULL,
  `sent` tinyint(1) NOT NULL default '0',
  `printed` tinyint(1) NOT NULL default '0',
  `emailed` tinyint(1) NOT NULL default '0',
  `done` tinyint(1) NOT NULL default '0',
  `created` datetime default NULL,
  `modified` datetime default NULL,
  PRIMARY KEY  (`id`),
  UNIQUE KEY `number` (`number`)
) ENGINE=MyISAM  DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

