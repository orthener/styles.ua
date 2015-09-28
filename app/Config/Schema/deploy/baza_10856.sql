
-- SELECT `locale`, `model`, `foreign_key`, `field`, `content` FROM `i18n` WHERE `model` LIKE 'Accessories'

--
-- Zrzut danych tabeli `awning_motors`
--

INSERT INTO `awning_motors` (`id`, `name`, `price`, `created`, `modified`) VALUES
(1, 'Mechanische endschalter', 68.00, '2012-05-31 17:17:52', '2012-05-31 17:17:58'),
(2, 'Mechanische endschalter und Nothandkurbel', 89.00, '2012-05-31 17:18:20', '2012-06-01 09:14:41'),
(3, 'Mechanische endschalter und Funk', 87.00, '2012-05-31 17:18:44', '2012-06-01 09:14:46'),
(4, 'Elektronische endschalter', 150.00, '2012-05-31 17:19:20', '2012-06-01 09:14:51'),
(5, 'Elektronische endschalter und Funk', 175.00, '2012-05-31 17:19:39', '2012-06-01 09:14:56'),
(6, 'Elektronische endschalter, Funk und Nothandkurbel', 300.00, '2012-05-31 17:19:56', '2012-06-01 09:15:00');




--
-- Zrzut danych tabeli `i18n`
--

INSERT INTO `i18n` (`locale`, `model`, `foreign_key`, `field`, `content`) VALUES
('pol', 'Motor', '1', 'name', 'Mechanische endschalter'),
('deu', 'Motor', '1', 'name', 'Mechanische endschalter'),
('deu', 'Motor', '2', 'name', 'Mechanische endschalter und Nothandkurbel'),
('deu', 'Motor', '3', 'name', 'Mechanische endschalter und Funk'),
('deu', 'Motor', '4', 'name', 'Elektronische endschalter'),
('deu', 'Motor', '5', 'name', 'Elektronische endschalter und Funk'),
('deu', 'Motor', '6', 'name', 'Elektronische endschalter, Funk und Nothandkurbel'),
('pol', 'Motor', '2', 'name', 'Mechanische endschalter und Nothandkurbel'),
('pol', 'Motor', '3', 'name', 'Mechanische endschalter und Funk'),
('pol', 'Motor', '4', 'name', 'Elektronische endschalter'),
('pol', 'Motor', '5', 'name', 'Elektronische endschalter und Funk'),
('pol', 'Motor', '6', 'name', 'Elektronische endschalter, Funk und Nothandkurbel');



--
-- Zrzut danych tabeli `awning_motor_options`
--

INSERT INTO `awning_motor_options` (`id`, `motor_id`, `name`, `price`, `created`, `modified`) VALUES
(1, 2, 'Drehschalter', 13.00, '2012-05-31 17:34:03', '2012-06-01 09:17:17'),
(2, 1, 'Drehschalter', 13.00, '2012-05-31 17:34:21', '2012-06-01 05:43:26'),
(3, 4, 'Drehschalter', 13.00, '2012-06-01 09:17:38', '2012-06-01 09:17:48'),
(4, 5, '1 kanal Handsender', 33.00, '2012-06-01 09:18:29', '2012-06-01 09:25:24'),
(5, 4, 'Windwächter', 38.00, '2012-06-01 09:19:00', '2012-06-01 09:25:29'),
(6, 5, 'Wind Radiowächter', 81.00, '2012-06-01 09:19:45', '2012-06-01 09:25:17'),
(7, 5, 'Wind/Sone Radiowächter', 99.00, '2012-06-01 09:21:33', '2012-06-01 09:25:12'),
(8, 6, '1 kanal Handsender', 29.00, '2012-06-01 09:23:04', '2012-06-01 09:25:06'),
(9, 6, '4 kanal Handsende', 56.00, '2012-06-01 09:23:20', '2012-06-01 09:25:00'),
(10, 6, 'Wind Radiowächter', 87.00, '2012-06-01 09:23:49', '2012-06-01 09:24:55'),
(11, 6, 'Wind/Sone Radiowächter', 108.00, '2012-06-01 09:24:41', '2012-06-01 09:24:49');


--
-- Zrzut danych tabeli `i18n`
--

INSERT INTO `i18n` (`locale`, `model`, `foreign_key`, `field`, `content`) VALUES
('deu', 'MotorOption', '1', 'name', 'Drehschalter'),
('deu', 'MotorOption', '2', 'name', 'Drehschalter'),
('pol', 'MotorOption', '2', 'name', 'Drehschalter'),
('pol', 'MotorOption', '1', 'name', 'Drehschalter'),
('pol', 'MotorOption', '3', 'name', 'Drehschalter'),
('deu', 'MotorOption', '3', 'name', 'Drehschalter'),
('pol', 'MotorOption', '4', 'name', '1 kanal Handsender'),
('pol', 'MotorOption', '5', 'name', 'Windwächter'),
('pol', 'MotorOption', '6', 'name', 'Wind Radiowächter'),
('pol', 'MotorOption', '7', 'name', 'Wind/Sone Radiowächter'),
('pol', 'MotorOption', '8', 'name', '1 kanal Handsender'),
('pol', 'MotorOption', '9', 'name', '4 kanal Handsende'),
('pol', 'MotorOption', '10', 'name', 'Wind Radiowächter'),
('pol', 'MotorOption', '11', 'name', 'Wind/Sone Radiowächter'),
('deu', 'MotorOption', '11', 'name', 'Wind/Sone Radiowächter'),
('deu', 'MotorOption', '10', 'name', 'Wind Radiowächter'),
('deu', 'MotorOption', '9', 'name', '4 kanal Handsende'),
('deu', 'MotorOption', '8', 'name', '1 kanal Handsender'),
('deu', 'MotorOption', '7', 'name', 'Wind/Sone Radiowächter'),
('deu', 'MotorOption', '6', 'name', 'Wind Radiowächter'),
('deu', 'MotorOption', '4', 'name', '1 kanal Handsender'),
('deu', 'MotorOption', '5', 'name', 'Windwächter');


--
-- Zrzut danych tabeli `awning_accessories`
--

INSERT INTO `awning_accessories` (`id`, `price_model`, `name`, `price`, `created`, `modified`) VALUES
(1, NULL, 'Heizstrahler Heliosa 11 (12m2)', 154.00, '2012-06-01 14:08:07', '2012-06-01 14:08:07'),
(2, NULL, 'Heizstrahler Heliosa 55 (15m2)', 227.00, '2012-06-01 14:08:36', '2012-06-01 14:08:36'),
(3, NULL, 'Heizstrahler Heliosa 55 (20m2)', 265.00, '2012-06-01 14:08:54', '2012-06-01 14:08:54'),
(4, NULL, 'Machisenstutzen', 50.00, '2012-06-01 14:09:18', '2012-06-01 14:09:18'),
(5, 'HoodPrice', 'Schutzdach', NULL, '2012-06-01 14:10:09', '2012-06-01 14:10:09');

INSERT INTO `i18n` (`locale`, `model`, `foreign_key`, `field`, `content`) VALUES
('pol', 'Accessory', '1', 'name', 'Heizstrahler Heliosa 11 (12m2)'),
('pol', 'Accessory', '2', 'name', 'Heizstrahler Heliosa 55 (15m2)'),
('pol', 'Accessory', '3', 'name', 'Heizstrahler Heliosa 55 (20m2)'),
('pol', 'Accessory', '4', 'name', 'Machisenstutzen'),
('pol', 'Accessory', '5', 'name', 'Schutzdach');

INSERT INTO `i18n` (`locale`, `model`, `foreign_key`, `field`, `content`) VALUES
('deu', 'Accessory', '1', 'name', 'Heizstrahler Heliosa 11 (12m2)'),
('deu', 'Accessory', '2', 'name', 'Heizstrahler Heliosa 55 (15m2)'),
('deu', 'Accessory', '3', 'name', 'Heizstrahler Heliosa 55 (20m2)'),
('deu', 'Accessory', '4', 'name', 'Machisenstutzen'),
('deu', 'Accessory', '5', 'name', 'Schutzdach');


INSERT INTO `awning_hood_prices` (`id`, `min_width`, `max_width`, `price`) VALUES
(1, NULL, 230, 50.00),
(2, 231, 290, 59.00),
(3, 291, 350, 68.00),
(4, 351, 410, 80.00),
(5, 411, 470, 89.00),
(6, 471, 530, 101.00),
(7, 531, 650, 122.00),
(8, 651, 700, 130.00);

