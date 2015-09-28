-- DROP TABLE IF EXISTS `addresses`, `affiliate_programs`, `countries`, `customers`, `invoice_identities`, `notes`, `orders`;
-- DROP TABLE IF EXISTS `order_items`, `order_statuses`, `regions`, `shipment_methods`;

-- phpMyAdmin SQL Dump
-- version 3.2.3
-- http://www.phpmyadmin.net
--
-- Host: localhost
-- Czas wygenerowania: 10 Lip 2011, 07:18
-- Wersja serwera: 5.0.51
-- Wersja PHP: 5.3.0

SET SQL_MODE="NO_AUTO_VALUE_ON_ZERO";

--
-- Struktura tabeli dla  `addresses`
--

CREATE TABLE IF NOT EXISTS `addresses` (
  `id` int(10) unsigned NOT NULL auto_increment,
  `customer_id` int(10) unsigned default NULL,
  `name` varchar(100) collate utf8_unicode_ci NOT NULL,
  `address` varchar(255) collate utf8_unicode_ci NOT NULL,
  `city` varchar(255) collate utf8_unicode_ci NOT NULL,
  `post_code` varchar(20) collate utf8_unicode_ci NOT NULL,
  `region_id` tinyint(3) unsigned default NULL,
  `country_id` char(2) collate utf8_unicode_ci NOT NULL COMMENT 'iso',
  `phone` varchar(30) collate utf8_unicode_ci NOT NULL,
  `created` datetime default NULL,
  `modified` datetime default NULL,
  PRIMARY KEY  (`id`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci AUTO_INCREMENT=2 ;

-- --------------------------------------------------------

--
-- Struktura tabeli dla  `affiliate_programs`
--

CREATE TABLE IF NOT EXISTS `affiliate_programs` (
  `id` int(10) unsigned NOT NULL auto_increment,
  `name` varchar(255) collate utf8_unicode_ci NOT NULL,
  `minimum` decimal(10,2) NOT NULL,
  `discount` int(3) NOT NULL,
  PRIMARY KEY  (`id`),
  UNIQUE KEY `id` (`id`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci AUTO_INCREMENT=6 ;

-- --------------------------------------------------------

--
-- Struktura tabeli dla  `countries`
--

CREATE TABLE IF NOT EXISTS `countries` (
  `id` char(2) collate utf8_unicode_ci NOT NULL COMMENT 'iso',
  `name` varchar(80) collate utf8_unicode_ci NOT NULL,
  `printable_name_en` varchar(80) collate utf8_unicode_ci NOT NULL,
  `printable_name` varchar(80) collate utf8_unicode_ci NOT NULL,
  `iso3` char(3) collate utf8_unicode_ci default NULL,
  `numcode` smallint(6) default NULL,
  PRIMARY KEY  (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

--
-- Zrzut danych tabeli `countries`
--

INSERT INTO `countries` (`id`, `name`, `printable_name_en`, `printable_name`, `iso3`, `numcode`) VALUES
('AD', 'ANDORRA', 'Andorra', 'Andora', 'AND', 20),
('AE', 'UNITED ARAB EMIRATES', 'United Arab \r\nEmirates', 'Zjedn.Emiraty Arabskie', 'ARE', 784),
('AF', 'AFGHANISTAN', 'Afghanistan', 'Afganistan', 'AFG', 4),
('AG', 'ANTIGUA AND BARBUDA', 'Antigua and Barbuda', 'Antigua i Barbuda', 'ATG', 28),
('AI', 'ANGUILLA', 'Anguilla', 'Anguilla', 'AIA', 660),
('AL', 'ALBANIA', 'Albania', 'Albania', 'ALB', 8),
('AM', 'ARMENIA', 'Armenia', 'Armenia', 'ARM', 51),
('AN', 'NETHERLANDS ANTILLES', 'Netherlands \r\nAntilles', 'Antyle Holenderskie', 'ANT', 530),
('AO', 'ANGOLA', 'Angola', 'Angola', 'AGO', 24),
('AQ', 'ANTARCTICA', 'Antarctica', 'Antarktyda', NULL, NULL),
('AR', 'ARGENTINA', 'Argentina', 'Argentyna', 'ARG', 32),
('AS', 'AMERICAN SAMOA', 'American Samoa', 'Samoa Amerykańskie', 'ASM', 16),
('AT', 'AUSTRIA', 'Austria', 'Austria', 'AUT', 40),
('AU', 'AUSTRALIA', 'Australia', 'Australia', 'AUS', 36),
('AW', 'ARUBA', 'Aruba', 'Aruba', 'ABW', 533),
('AZ', 'AZERBAIJAN', 'Azerbaijan', 'Azerbejdżan', 'AZE', 31),
('BA', 'BOSNIA AND HERZEGOVINA', 'Bosnia and Herzegovina', 'Bośnia i Hercegowina', 'BIH', 70),
('BB', 'BARBADOS', 'Barbados', 'Barbados', 'BRB', 52),
('BD', 'BANGLADESH', 'Bangladesh', 'Bangladesz', 'BGD', 50),
('BE', 'BELGIUM', 'Belgium', 'Belgia', 'BEL', 56),
('BF', 'BURKINA FASO', 'Burkina Faso', 'Burkina Faso', 'BFA', 854),
('BG', 'BULGARIA', 'Bulgaria', 'Bułgaria', 'BGR', 100),
('BH', 'BAHRAIN', 'Bahrain', 'Bahrajn', 'BHR', 48),
('BI', 'BURUNDI', 'Burundi', 'Burundi', 'BDI', 108),
('BJ', 'BENIN', 'Benin', 'Benin', 'BEN', 204),
('BM', 'BERMUDA', 'Bermuda', 'Bermudy', 'BMU', 60),
('BN', 'BRUNEI DARUSSALAM', 'Brunei Darussalam', 'Brunei Darussalam', 'BRN', 96),
('BO', 'BOLIVIA', 'Bolivia', 'Boliwia', 'BOL', 68),
('BR', 'BRAZIL', 'Brazil', 'Brazylia', 'BRA', 76),
('BS', 'BAHAMAS', 'Bahamas', 'Bahamy', 'BHS', 44),
('BT', 'BHUTAN', 'Bhutan', 'Bhutan', 'BTN', 64),
('BV', 'BOUVET ISLAND', 'Bouvet Island', 'Wyspa Bouveta', NULL, NULL),
('BW', 'BOTSWANA', 'Botswana', 'Botswana', 'BWA', 72),
('BY', 'BELARUS', 'Belarus', 'Białoruś', 'BLR', 112),
('BZ', 'BELIZE', 'Belize', 'Belize', 'BLZ', 84),
('CA', 'CANADA', 'Canada', 'Kanada', 'CAN', 124),
('CC', 'COCOS (KEELING) ISLANDS', 'Cocos (Keeling) Islands', 'Wyspy Kokosowe (Keelinga)', NULL, NULL),
('CD', 'CONGO, THE DEMOCRATIC REPUBLIC OF THE', 'Congo, the Democratic Republic of the', 'Dem. Rep. Kongo', 'COD', 180),
('CF', 'CENTRAL AFRICAN REPUBLIC', 'Central African Republic', 'Rep.Środk.Afrykańska', 'CAF', 140),
('CG', 'CONGO', 'Congo', 'Kongo', 'COG', 178),
('CH', 'SWITZERLAND', 'Switzerland', 'Szwajcaria', 'CHE', 756),
('CI', 'COTE D''IVOIRE', 'Cote D''Ivoire', 'Wyb.Kości Słoniowej', 'CIV', 384),
('CK', 'COOK ISLANDS', 'Cook Islands', 'Wyspy Cooka', 'COK', 184),
('CL', 'CHILE', 'Chile', 'Chile', 'CHL', 152),
('CM', 'CAMEROON', 'Cameroon', 'Kamerun', 'CMR', 120),
('CN', 'CHINA', 'China', 'Chiny', 'CHN', 156),
('CO', 'COLOMBIA', 'Colombia', 'Kolumbia', 'COL', 170),
('CR', 'COSTA RICA', 'Costa Rica', 'Kostaryka', 'CRI', 188),
('CS', 'SERBIA AND MONTENEGRO', 'Serbia and Montenegro', 'Serbia i Czarnogóra', NULL, NULL),
('CU', 'CUBA', 'Cuba', 'Kuba', 'CUB', 192),
('CV', 'CAPE VERDE', 'Cape Verde', 'Zielony Przylądek', 'CPV', 132),
('CX', 'CHRISTMAS ISLAND', 'Christmas Island', 'Wyspa Bożego Narodzenia', NULL, NULL),
('CY', 'CYPRUS', 'Cyprus', 'Cypr', 'CYP', 196),
('CZ', 'CZECH REPUBLIC', 'Czech Republic', 'Republika Czeska', 'CZE', 203),
('DE', 'GERMANY', 'Germany', 'Niemcy', 'DEU', 276),
('DJ', 'DJIBOUTI', 'Djibouti', 'Dżibuti', 'DJI', 262),
('DK', 'DENMARK', 'Denmark', 'Dania', 'DNK', 208),
('DM', 'DOMINICA', 'Dominica', 'Dominika', 'DMA', 212),
('DO', 'DOMINICAN REPUBLIC', 'Dominican Republic', 'Dominikana', 'DOM', 214),
('DZ', 'ALGERIA', 'Algeria', 'Algieria', 'DZA', 12),
('EC', 'ECUADOR', 'Ecuador', 'Ekwador', 'ECU', 218),
('EE', 'ESTONIA', 'Estonia', 'Estonia', 'EST', 233),
('EG', 'EGYPT', 'Egypt', 'Egipt', 'EGY', 818),
('EH', 'WESTERN SAHARA', 'Western Sahara', 'Sahara zachodnia', 'ESH', 732),
('ER', 'ERITREA', 'Eritrea', 'Erytrea', 'ERI', 232),
('ES', 'SPAIN', 'Spain', 'Hiszpania', 'ESP', 724),
('ET', 'ETHIOPIA', 'Ethiopia', 'Etiopia', 'ETH', 231),
('FI', 'FINLAND', 'Finland', 'Finlandia', 'FIN', 246),
('FJ', 'FIJI', 'Fiji', 'Fidżi Republika', 'FJI', 242),
('FK', 'FALKLAND ISLANDS (MALVINAS)', 'Falkland Islands (Malvinas)', 'Falklandy', 'FLK', 238),
('FM', 'MICRONESIA, FEDERATED STATES \r\nOF', 'Micronesia, Federated States of', 'Mikronezja', 'FSM', 583),
('FO', 'FAROE ISLANDS', 'Faroe Islands', 'Wyspy Owcze', 'FRO', 234),
('FR', 'FRANCE', 'France', 'Francja', 'FRA', 250),
('GA', 'GABON', 'Gabon', 'Gabon', 'GAB', 266),
('GB', 'UNITED KINGDOM', 'United \r\nKingdom', 'Wielka Brytania', 'GBR', 826),
('GD', 'GRENADA', 'Grenada', 'Grenada', 'GRD', 308),
('GE', 'GEORGIA', 'Georgia', 'Gruzja', 'GEO', 268),
('GF', 'FRENCH GUIANA', 'French Guiana', 'Guiana francuska', 'GUF', 254),
('GH', 'GHANA', 'Ghana', 'Ghana', 'GHA', 288),
('GI', 'GIBRALTAR', 'Gibraltar', 'Gibraltar', 'GIB', 292),
('GL', 'GREENLAND', 'Greenland', 'Grenlandia', 'GRL', 304),
('GM', 'GAMBIA', 'Gambia', 'Gambia', 'GMB', 270),
('GN', 'GUINEA', 'Guinea', 'Gwinea', 'GIN', 324),
('GP', 'GUADELOUPE', 'Guadeloupe', 'Gwadelupe', 'GLP', 312),
('GQ', 'EQUATORIAL GUINEA', 'Equatorial Guinea', 'Gwinea Równikowa', 'GNQ', 226),
('GR', 'GREECE', 'Greece', 'Grecja', 'GRC', 300),
('GS', 'SOUTH GEORGIA AND THE SOUTH SANDWICH \r\nISLANDS', 'South Georgia and the South Sandwich Islands', 'Południowa Georgia i Południowe Wyspy Sandwich', NULL, NULL),
('GT', 'GUATEMALA', 'Guatemala', 'Gwatemala', 'GTM', 320),
('GU', 'GUAM', 'Guam', 'Guam', 'GUM', 316),
('GW', 'GUINEA-BISSAU', 'Guinea-Bissau', 'Gwinea-Bissau', 'GNB', 624),
('GY', 'GUYANA', 'Guyana', 'Gujana', 'GUY', 328),
('HK', 'HONG KONG', 'Hong Kong', 'Hongkong', 'HKG', 344),
('HM', 'HEARD ISLAND AND MCDONALD ISLANDS', 'Heard Island and Mcdonald Islands', 'Wyspy Heard i Mc Donald', NULL, NULL),
('HN', 'HONDURAS', 'Honduras', 'Honduras', 'HND', 340),
('HR', 'CROATIA', 'Croatia', 'Chorwacja', 'HRV', 191),
('HT', 'HAITI', 'Haiti', 'Haiti', 'HTI', 332),
('HU', 'HUNGARY', 'Hungary', 'Węgry', 'HUN', 348),
('ID', 'INDONESIA', 'Indonesia', 'Indonezja', 'IDN', 360),
('IE', 'IRELAND', 'Ireland', 'Irlandia', 'IRL', 372),
('IL', 'ISRAEL', 'Israel', 'Izrael', 'ISR', 376),
('IN', 'INDIA', 'India', 'India', 'IND', 356),
('IO', 'BRITISH INDIAN OCEAN TERRITORY', 'British Indian Ocean Territory', 'Brytyjskie Terytorium Oceanu Indyjskiego', NULL, NULL),
('IQ', 'IRAQ', 'Iraq', 'Irak', 'IRQ', 368),
('IR', 'IRAN, ISLAMIC REPUBLIC OF', 'Iran, Islamic Republic of', 'Iran', 'IRN', 364),
('IS', 'ICELAND', 'Iceland', 'Islandia', 'ISL', 352),
('IT', 'ITALY', 'Italy', 'Włochy', 'ITA', 380),
('JM', 'JAMAICA', 'Jamaica', 'Jamajka', 'JAM', 388),
('JO', 'JORDAN', 'Jordan', 'Jordania', 'JOR', 400),
('JP', 'JAPAN', 'Japan', 'Japonia', 'JPN', 392),
('KE', 'KENYA', 'Kenya', 'Kenia', 'KEN', 404),
('KG', 'KYRGYZSTAN', 'Kyrgyzstan', 'Kirgistan', 'KGZ', 417),
('KH', 'CAMBODIA', 'Cambodia', 'Kambodża', 'KHM', 116),
('KI', 'KIRIBATI', 'Kiribati', 'Kiribati', 'KIR', 296),
('KM', 'COMOROS', 'Comoros', 'Komory', 'COM', 174),
('KN', 'SAINT KITTS AND NEVIS', 'Saint Kitts \r\nand Nevis', 'St.Kitts i Nevis', 'KNA', 659),
('KP', 'KOREA, DEMOCRATIC PEOPLE''S REPUBLIC \r\nOF', 'Korea, Democratic People''s Republic of', 'Koreańska Republika Ludowo-Demokratyczna', 'PRK', 408),
('KR', 'KOREA, REPUBLIC OF', 'Korea, Republic \r\nof', 'Republika Korei', 'KOR', 410),
('KW', 'KUWAIT', 'Kuwait', 'Kuwejt', 'KWT', 414),
('KY', 'CAYMAN ISLANDS', 'Cayman Islands', 'Kajmany', 'CYM', 136),
('KZ', 'KAZAKHSTAN', 'Kazakhstan', 'Kazachstan', 'KAZ', 398),
('LA', 'LAO PEOPLE''S DEMOCRATIC \r\nREPUBLIC', 'Lao People''s Democratic Republic', 'Laos', 'LAO', 418),
('LB', 'LEBANON', 'Lebanon', 'Liban', 'LBN', 422),
('LC', 'SAINT LUCIA', 'Saint \r\nLucia', 'St.Lucia', 'LCA', 662),
('LI', 'LIECHTENSTEIN', 'Liechtenstein', 'Liechtenstein', 'LIE', 438),
('LK', 'SRI LANKA', 'Sri Lanka', 'Sri Lanka', 'LKA', 144),
('LR', 'LIBERIA', 'Liberia', 'Liberia', 'LBR', 430),
('LS', 'LESOTHO', 'Lesotho', 'Lesotho', 'LSO', 426),
('LT', 'LITHUANIA', 'Lithuania', 'Litwa', 'LTU', 440),
('LU', 'LUXEMBOURG', 'Luxembourg', 'Luksemburg', 'LUX', 442),
('LV', 'LATVIA', 'Latvia', 'Łotwa', 'LVA', 428),
('LY', 'LIBYAN ARAB JAMAHIRIYA', 'Libyan Arab \r\nJamahiriya', 'Libia', 'LBY', 434),
('MA', 'MOROCCO', 'Morocco', 'Maroko', 'MAR', 504),
('MC', 'MONACO', 'Monaco', 'Monako', 'MCO', 492),
('MD', 'MOLDOVA, REPUBLIC OF', 'Moldova, \r\nRepublic of', 'Mołdowa', 'MDA', 498),
('MG', 'MADAGASCAR', 'Madagascar', 'Madagaskar', 'MDG', 450),
('MH', 'MARSHALL ISLANDS', 'Marshall Islands', 'Wyspy Marshala', 'MHL', 584),
('MK', 'MACEDONIA, THE FORMER YUGOSLAV \r\nREPUBLIC OF', 'Macedonia, the Former Yugoslav Republic of', 'Macedonia', 'MKD', 807),
('ML', 'MALI', 'Mali', 'Mali', 'MLI', 466),
('MM', 'MYANMAR', 'Myanmar', 'Myanmar (Burma)', 'MMR', 104),
('MN', 'MONGOLIA', 'Mongolia', 'Mongolia', 'MNG', 496),
('MO', 'MACAO', 'Macao', 'Makau', 'MAC', 446),
('MP', 'NORTHERN MARIANA ISLANDS', 'Northern \r\nMariana Islands', 'Mariany Północne', 'MNP', 580),
('MQ', 'MARTINIQUE', 'Martinique', 'Martynika', 'MTQ', 474),
('MR', 'MAURITANIA', 'Mauritania', 'Mauretania', 'MRT', 478),
('MS', 'MONTSERRAT', 'Montserrat', 'Montserrat', 'MSR', 500),
('MT', 'MALTA', 'Malta', 'Malta', 'MLT', 470),
('MU', 'MAURITIUS', 'Mauritius', 'Mauritius', 'MUS', 480),
('MV', 'MALDIVES', 'Maldives', 'Malediwy', 'MDV', 462),
('MW', 'MALAWI', 'Malawi', 'Malawi', 'MWI', 454),
('MX', 'MEXICO', 'Mexico', 'Meksyk', 'MEX', 484),
('MY', 'MALAYSIA', 'Malaysia', 'Malezja', 'MYS', 458),
('MZ', 'MOZAMBIQUE', 'Mozambique', 'Mozambik', 'MOZ', 508),
('NA', 'NAMIBIA', 'Namibia', 'Namibia', 'NAM', 516),
('NC', 'NEW CALEDONIA', 'New \r\nCaledonia', 'Nowa Kaledonia', 'NCL', 540),
('NE', 'NIGER', 'Niger', 'Niger', 'NER', 562),
('NF', 'NORFOLK ISLAND', 'Norfolk \r\nIsland', 'Norfolk', 'NFK', 574),
('NG', 'NIGERIA', 'Nigeria', 'Nigeria', 'NGA', 566),
('NI', 'NICARAGUA', 'Nicaragua', 'Nikaragua', 'NIC', 558),
('NL', 'NETHERLANDS', 'Netherlands', 'Niderlandy', 'NLD', 528),
('NO', 'NORWAY', 'Norway', 'Norwegia', 'NOR', 578),
('NP', 'NEPAL', 'Nepal', 'Nepal', 'NPL', 524),
('NR', 'NAURU', 'Nauru', 'Nauru', 'NRU', 520),
('NU', 'NIUE', 'Niue', 'Niue', 'NIU', 570),
('NZ', 'NEW ZEALAND', 'New \r\nZealand', 'Nowa Zelandia', 'NZL', 554),
('OM', 'OMAN', 'Oman', 'Oman', 'OMN', 512),
('PA', 'PANAMA', 'Panama', 'Panama', 'PAN', 591),
('PE', 'PERU', 'Peru', 'Peru', 'PER', 604),
('PF', 'FRENCH POLYNESIA', 'French Polynesia', 'Polinezja Franc.', 'PYF', 258),
('PG', 'PAPUA NEW GUINEA', 'Papua New \r\nGuinea', 'Papua Nowa Gwinea', 'PNG', 598),
('PH', 'PHILIPPINES', 'Philippines', 'Filipiny', 'PHL', 608),
('PK', 'PAKISTAN', 'Pakistan', 'Pakistan', 'PAK', 586),
('PL', 'POLAND', 'Polska', 'Polska', 'POL', 616),
('PM', 'SAINT PIERRE AND MIQUELON', 'Saint \r\nPierre and Miquelon', 'St. Pierre i Miquelon', 'SPM', 666),
('PN', 'PITCAIRN', 'Pitcairn', 'Pitcairn', 'PCN', 612),
('PR', 'PUERTO RICO', 'Puerto Rico', 'Puerto Rico', 'PRI', 630),
('PS', 'PALESTINIAN TERRITORY, \r\nOCCUPIED', 'Palestinian Territory, Occupied', 'Okupowane Terytorium Palestyny', NULL, NULL),
('PT', 'PORTUGAL', 'Portugal', 'Portugalia', 'PRT', 620),
('PW', 'PALAU', 'Palau', 'Palau', 'PLW', 585),
('PY', 'PARAGUAY', 'Paraguay', 'Paragwaj', 'PRY', 600),
('QA', 'QATAR', 'Qatar', 'Katar', 'QAT', 634),
('RE', 'REUNION', 'Reunion', 'Reunion', 'REU', 638),
('RO', 'ROMANIA', 'Romania', 'Rumunia', 'ROM', 642),
('RU', 'RUSSIAN FEDERATION', 'Russian \r\nFederation', 'Rosja', 'RUS', 643),
('RW', 'RWANDA', 'Rwanda', 'Ruanda', 'RWA', 646),
('SA', 'SAUDI ARABIA', 'Saudi \r\nArabia', 'Arabia Saudyjska', 'SAU', 682),
('SB', 'SOLOMON ISLANDS', 'Solomon \r\nIslands', 'Wyspy Salomona', 'SLB', 90),
('SC', 'SEYCHELLES', 'Seychelles', 'Seszele', 'SYC', 690),
('SD', 'SUDAN', 'Sudan', 'Sudan', 'SDN', 736),
('SE', 'SWEDEN', 'Sweden', 'Szwecja', 'SWE', 752),
('SG', 'SINGAPORE', 'Singapore', 'Singapur', 'SGP', 702),
('SH', 'SAINT HELENA', 'Saint \r\nHelena', 'Święta Helena', 'SHN', 654),
('SI', 'SLOVENIA', 'Slovenia', 'Słowenia', 'SVN', 705),
('SJ', 'SVALBARD AND JAN MAYEN', 'Svalbard and Jan Mayen', 'Svalbard and Jan Mayen', 'SJM', 744),
('SK', 'SLOVAKIA', 'Slovakia', 'Słowacja', 'SVK', 703),
('SL', 'SIERRA LEONE', 'Sierra \r\nLeone', 'Sierra Leone', 'SLE', 694),
('SM', 'SAN MARINO', 'San Marino', 'San Marino', 'SMR', 674),
('SN', 'SENEGAL', 'Senegal', 'Senegal', 'SEN', 686),
('SO', 'SOMALIA', 'Somalia', 'Somalia', 'SOM', 706),
('SR', 'SURINAME', 'Suriname', 'Surinam', 'SUR', 740),
('ST', 'SAO TOME AND PRINCIPE', 'Sao Tome and \r\nPrincipe', 'Wyspy Św.Tomasza i Książęca', 'STP', 678),
('SV', 'EL SALVADOR', 'El Salvador', 'Salwador', 'SLV', 222),
('SY', 'SYRIAN ARAB REPUBLIC', 'Syrian Arab \r\nRepublic', 'Syria', 'SYR', 760),
('SZ', 'SWAZILAND', 'Swaziland', 'Skazi', 'SWZ', 748),
('TC', 'TURKS AND CAICOS ISLANDS', 'Turks and \r\nCaicos Islands', 'Turks i Caicos', 'TCA', 796),
('TD', 'CHAD', 'Chad', 'Czad', 'TCD', 148),
('TF', 'FRENCH SOUTHERN TERRITORIES', 'French Southern Territories', 'Franc.Teryt.Płd.', NULL, NULL),
('TG', 'TOGO', 'Togo', 'Togo', 'TGO', 768),
('TH', 'THAILAND', 'Thailand', 'Tajlandia', 'THA', 764),
('TJ', 'TAJIKISTAN', 'Tajikistan', 'Tadżykistan', 'TJK', 762),
('TK', 'TOKELAU', 'Tokelau', 'Tokelau', 'TKL', 772),
('TL', 'TIMOR-LESTE', 'Timor-Leste', 'Wschodni Tirom', NULL, NULL),
('TM', 'TURKMENISTAN', 'Turkmenistan', 'Turkmenistan', 'TKM', 795),
('TN', 'TUNISIA', 'Tunisia', 'Tunezja', 'TUN', 788),
('TO', 'TONGA', 'Tonga', 'Tonga', 'TON', 776),
('TR', 'TURKEY', 'Turkey', 'Turcja', 'TUR', 792),
('TT', 'TRINIDAD AND TOBAGO', 'Trinidad and \r\nTobago', 'Trynidad i Tobago', 'TTO', 780),
('TV', 'TUVALU', 'Tuvalu', 'Tuvalu', 'TUV', 798),
('TW', 'TAIWAN, PROVINCE OF CHINA', 'Taiwan, \r\nProvince of China', 'Tajwan', 'TWN', 158),
('TZ', 'TANZANIA, UNITED REPUBLIC \r\nOF', 'Tanzania, United Republic of', 'Tanzania', 'TZA', 834),
('UA', 'UKRAINE', 'Ukraine', 'Ukraina', 'UKR', 804),
('UG', 'UGANDA', 'Uganda', 'Uganda', 'UGA', 800),
('UM', 'UNITED STATES MINOR OUTLYING \r\nISLANDS', 'United States Minor Outlying Islands', 'Minor (Powiernicze Wyspy Pacyfiku Stanów Zjednoczonych)', NULL, NULL),
('US', 'UNITED STATES', 'United \r\nStates', 'Stany Zjedn. Ameryki', 'USA', 840),
('UY', 'URUGUAY', 'Uruguay', 'Urugwaj', 'URY', 858),
('UZ', 'UZBEKISTAN', 'Uzbekistan', 'Uzbekistan', 'UZB', 860),
('VA', 'HOLY SEE (VATICAN CITY STATE)', 'Holy See (Vatican City State)', 'Watykan', 'VAT', 336),
('VC', 'SAINT VINCENT AND THE \r\nGRENADINES', 'Saint Vincent and the Grenadines', 'St.Vincent i Grenadyny', 'VCT', 670),
('VE', 'VENEZUELA', 'Venezuela', 'Wenezuela', 'VEN', 862),
('VG', 'VIRGIN ISLANDS, BRITISH', 'Virgin \r\nIslands, British', 'Wyspy Dziewicze-W.B', 'VGB', 92),
('VI', 'VIRGIN ISLANDS, U.S.', 'Virgin Islands,\r\n U.s.', 'Wyspy Dziewicze-USA', 'VIR', 850),
('VN', 'VIET NAM', 'Viet Nam', 'Wietnam', 'VNM', 704),
('VU', 'VANUATU', 'Vanuatu', 'Vanuatu', 'VUT', 548),
('WF', 'WALLIS AND FUTUNA', 'Wallis and \r\nFutuna', 'WalIis i Futuna', 'WLF', 876),
('WS', 'SAMOA', 'Samoa', 'Samoa', 'WSM', 882),
('YE', 'YEMEN', 'Yemen', 'Jemen', 'YEM', 887),
('YT', 'MAYOTTE', 'Mayotte', 'Majotta', NULL, NULL),
('ZA', 'SOUTH AFRICA', 'South \r\nAfrica', 'Rep.Połud.Afryki', 'ZAF', 710),
('ZM', 'ZAMBIA', 'Zambia', 'Zambia', 'ZMB', 894),
('ZW', 'ZIMBABWE', 'Zimbabwe', 'Zimbabwe', 'ZWE', 716);

-- --------------------------------------------------------

--
-- Struktura tabeli dla  `customers`
--

CREATE TABLE IF NOT EXISTS `customers` (
  `id` int(10) unsigned NOT NULL auto_increment,
  `user_id` char(36) collate utf8_unicode_ci default NULL,
  `contact_person` varchar(100) collate utf8_unicode_ci NOT NULL,
  `email` varchar(255) collate utf8_unicode_ci NOT NULL,
  `phone` varchar(40) collate utf8_unicode_ci NOT NULL,
  `address_id` int(10) unsigned default NULL,
  `invoice_identity_id` int(10) unsigned default NULL,
  `discount` int(3) unsigned NOT NULL default '0' COMMENT 'Rabat, wartosci procentowe od 0-100',
  `created` datetime default NULL,
  `modified` datetime default NULL,
  PRIMARY KEY  (`id`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci AUTO_INCREMENT=2 ;

-- --------------------------------------------------------

--
-- Struktura tabeli dla  `invoice_identities`
--

CREATE TABLE IF NOT EXISTS `invoice_identities` (
  `id` int(10) unsigned NOT NULL auto_increment,
  `customer_id` int(10) unsigned default NULL,
  `iscompany` tinyint(1) NOT NULL default '0',
  `name` varchar(255) collate utf8_unicode_ci NOT NULL,
  `nip` varchar(20) collate utf8_unicode_ci default NULL,
  `address` varchar(255) collate utf8_unicode_ci NOT NULL,
  `city` varchar(255) collate utf8_unicode_ci NOT NULL,
  `post_code` varchar(20) collate utf8_unicode_ci NOT NULL,
  `region_id` tinyint(3) unsigned default NULL,
  `country_id` char(2) collate utf8_unicode_ci NOT NULL COMMENT 'iso',
  `created` datetime default NULL,
  `modified` datetime default NULL,
  PRIMARY KEY  (`id`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci AUTO_INCREMENT=2 ;

-- --------------------------------------------------------

--
-- Struktura tabeli dla  `notes`
--

CREATE TABLE IF NOT EXISTS `notes` (
  `id` int(10) unsigned NOT NULL auto_increment,
  `title` varchar(255) character set utf8 collate utf8_unicode_ci NOT NULL,
  `user_id` varchar(255) character set utf8 collate utf8_unicode_ci default NULL,
  `row_id` varchar(255) character set utf8 collate utf8_unicode_ci default NULL,
  `model` varchar(255) character set utf8 collate utf8_unicode_ci default NULL,
  `content` text character set utf8 collate utf8_unicode_ci NOT NULL,
  `modified` datetime NOT NULL,
  `created` datetime NOT NULL,
  PRIMARY KEY  (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 AUTO_INCREMENT=1 ;

-- --------------------------------------------------------

--
-- Struktura tabeli dla  `orders`
--

CREATE TABLE IF NOT EXISTS `orders` (
  `id` int(10) unsigned NOT NULL auto_increment,
  `hash` char(36) collate utf8_unicode_ci NOT NULL default '',
  `order_status_id` tinyint(3) unsigned NOT NULL default '0',
  `customer_id` int(10) unsigned default NULL,
  `address` text collate utf8_unicode_ci,
  `invoice_identity` text collate utf8_unicode_ci,
  `payment_type` tinyint(4) NOT NULL default '0' COMMENT '0 - Płatnosc przy odbiorze, 1 - platnosc elektroniczna / Przelew',
  `shipment_method_id` int(10) unsigned default NULL,
  `shipment_price` decimal(8,2) default NULL,
  `shipment_tax_rate` decimal(2,2) default NULL,
  `shipment_tax_value` decimal(8,2) default NULL,
  `shipment_discount` int(3) unsigned NOT NULL default '0',
  `total` decimal(8,2) NOT NULL default '0.00' COMMENT 'total gross (cena brutto)',
  `total_tax_value` decimal(8,2) NOT NULL default '0.00',
  `created` datetime default NULL,
  `modified` datetime default NULL,
  PRIMARY KEY  (`id`),
  KEY `status` (`order_status_id`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci AUTO_INCREMENT=2 ;

-- --------------------------------------------------------

--
-- Struktura tabeli dla  `order_items`
--

CREATE TABLE IF NOT EXISTS `order_items` (
  `id` int(10) unsigned NOT NULL auto_increment,
  `order_id` int(10) unsigned NOT NULL,
  `product_id` int(10) unsigned default NULL,
  `product` text collate utf8_unicode_ci NOT NULL COMMENT 'json encoded product record',
  `name` varchar(255) collate utf8_unicode_ci default NULL,
  `price` decimal(8,2) NOT NULL,
  `tax_rate` decimal(2,2) unsigned NOT NULL,
  `tax_value` decimal(8,2) unsigned NOT NULL,
  `quantity` smallint(5) unsigned NOT NULL,
  `discount` int(3) unsigned NOT NULL default '0' COMMENT 'Rabat, wartosci procentowe od 0-100',
  `created` datetime default NULL,
  `modified` datetime default NULL,
  PRIMARY KEY  (`id`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci AUTO_INCREMENT=3 ;

-- --------------------------------------------------------

--
-- Struktura tabeli dla  `order_statuses`
--

CREATE TABLE IF NOT EXISTS `order_statuses` (
  `id` int(10) unsigned NOT NULL auto_increment,
  `name` varchar(100) collate utf8_unicode_ci NOT NULL,
  `created` datetime default NULL,
  `modified` datetime default NULL,
  `deleted` datetime default NULL,
  PRIMARY KEY  (`id`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci AUTO_INCREMENT=6 ;

--
-- Zrzut danych tabeli `order_statuses`
--

INSERT INTO `order_statuses` (`id`, `name`, `created`, `modified`, `deleted`) VALUES
(0, 'W Koszyku', '2011-06-15 14:31:42', '2011-06-15 14:31:42', NULL),
(1, 'Czeka na zapłatę', '2011-06-15 08:53:47', '2011-06-15 08:53:47', NULL),
(2, 'Przyjęto do realizacji', '2011-06-15 08:53:47', '2011-06-15 08:53:47', NULL),
(3, 'W trakcie realizacji', '2011-06-15 08:53:47', '2011-06-15 08:53:47', NULL),
(4, 'Wysłano', '2011-06-15 08:53:47', '2011-06-15 08:53:47', NULL),
(5, 'Anulowano', '2011-06-15 08:53:47', '2011-06-15 08:53:47', NULL);

-- --------------------------------------------------------

--
-- Struktura tabeli dla  `regions`
--

CREATE TABLE IF NOT EXISTS `regions` (
  `id` tinyint(3) unsigned NOT NULL auto_increment,
  `name` varchar(255) collate utf8_unicode_ci NOT NULL,
  `order` smallint(6) NOT NULL,
  PRIMARY KEY  (`id`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci AUTO_INCREMENT=17 ;

--
-- Zrzut danych tabeli `regions`
--

INSERT INTO `regions` (`id`, `name`, `order`) VALUES
(1, 'dolnośląskie', 2),
(2, 'kujawsko-pomorskie', 4),
(3, 'lubelskie', 6),
(4, 'lubuskie', 8),
(5, 'łódzkie', 10),
(6, 'małopolskie', 12),
(7, 'mazowieckie', 14),
(8, 'opolskie', 16),
(9, 'podkarpackie', 18),
(10, 'podlaskie', 20),
(11, 'pomorskie', 22),
(12, 'śląskie', 24),
(13, 'świętokrzyskie', 26),
(14, 'warmińsko-mazurskie', 28),
(15, 'wielkopolskie', 30),
(16, 'zachodniopomorskie', 32);

-- --------------------------------------------------------

--
-- Struktura tabeli dla  `shipment_methods`
--

CREATE TABLE IF NOT EXISTS `shipment_methods` (
  `id` int(10) unsigned NOT NULL auto_increment,
  `name` varchar(100) collate utf8_unicode_ci NOT NULL,
  `shipment_price` decimal(8,2) NOT NULL,
  `cash_on_delivery_price` decimal(8,2) NOT NULL,
  `tax_rate` decimal(2,2) NOT NULL,
  `created` datetime default NULL,
  `modified` datetime default NULL,
  `deleted` datetime default NULL,
  PRIMARY KEY  (`id`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci AUTO_INCREMENT=4 ;

--
-- Zrzut danych tabeli `shipment_methods`
--

INSERT INTO `shipment_methods` (`id`, `name`, `shipment_price`, `cash_on_delivery_price`, `tax_rate`, `created`, `modified`, `deleted`) VALUES
(1, 'Odbiór osobisty', 0.00, 0.00, 0.23, '2011-06-08 13:34:38', '2011-06-08 13:34:38', NULL),
(2, 'Kurier', 20.00, 4.00, 0.23, '2011-06-08 13:34:38', '2011-06-08 13:34:38', NULL),
(3, 'Poczta polska', 15.00, 5.00, 0.23, '2011-06-08 13:34:38', '2011-06-08 13:34:38', NULL);
