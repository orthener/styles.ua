--
-- Struktura tabeli dla tabeli `commerce_order_extras`
--

CREATE TABLE IF NOT EXISTS `commerce_order_extras` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `name` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `price` decimal(8,2) NOT NULL,
  `tax_rate` decimal(2,2) NOT NULL,
  `created` datetime NOT NULL,
  `modified` datetime NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci AUTO_INCREMENT=1 ;

--
-- Zrzut danych tabeli `commerce_order_extras`
--

INSERT INTO `commerce_order_extras` (`id`, `name`, `price`, `tax_rate`, `created`, `modified`) VALUES
(1, 'brak', 0.00, 0.23, '2013-01-30 09:26:50', '2013-01-30 09:26:50'),
(2, 'wstawienie okien w gotowy otwór', 1.00, 0.08, '2013-01-30 09:30:56', '2013-01-30 09:30:56'),
(3, 'wstawienie okien w gotowy otwór (ciepły montaż)', 2.00, 0.08, '2013-01-30 09:31:17', '2013-01-30 09:31:17'),
(4, 'wymiana okien szwedzkich bez obróbek', 3.00, 0.08, '2013-01-30 09:31:35', '2013-01-30 09:31:35'),
(5, 'wymiana okien skrzynkowych bez obróbek', 4.00, 0.08, '2013-01-30 09:31:49', '2013-01-30 09:31:49'),
(6, 'wymiana okien szwedzkich z obróbką (bez malowania) ', 5.00, 0.08, '2013-01-30 09:32:04', '2013-01-30 09:32:04'),
(7, 'wymiana okien skrzynkowych z obróbką (bez malowania)', 6.00, 0.08, '2013-01-30 09:32:24', '2013-01-30 09:32:24');

ALTER TABLE  `commerce_orders` DROP  `mounted` ,
DROP  `mounted_m2` ,
DROP  `demounted` ,
DROP  `demounted_m2` ,
DROP  `treatment` ,
DROP  `treatment_m2` ;

ALTER TABLE  `commerce_orders` ADD  `order_extra_id` INT NOT NULL DEFAULT  '0' AFTER  `vat` ,
ADD  `order_extra_m2` FLOAT NOT NULL DEFAULT  '0' AFTER  `order_extra_id`;

ALTER TABLE  `commerce_shipment_method_configs` DROP FOREIGN KEY  `fk_commerce_shipment_method_configs_commerce_shipment_methods1` ;

ALTER TABLE  `commerce_orders` DROP FOREIGN KEY  `fk_commerce_orders_commerce_shipment_methods1` ,
ADD FOREIGN KEY (  `shipment_method_id` ) REFERENCES  `feb_jk`.`commerce_shipment_methods` (
`id`
) ON DELETE SET NULL ON UPDATE NO ACTION ;

-- Shipment methods truncate


INSERT INTO `commerce_shipment_methods` (`id`, `name`, `img`, `shipment_price`, `cash_on_delivery_price`, `tax_rate`, `track_link`, `created`, `modified`, `deleted`, `order`) VALUES
(17, 'Odbiór osobisty', NULL, 0.00, 0.00, 0.23, '', '2013-01-30 10:10:37', '2013-01-30 10:10:37', '2013-01-30 10:08:00', 0),
(18, 'Dostawa', NULL, 100.00, 0.00, 0.23, '', '2013-01-30 10:10:54', '2013-01-30 10:10:54', '2013-01-30 10:10:00', 0);
