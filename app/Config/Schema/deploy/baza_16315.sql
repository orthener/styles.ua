-- #8222 ko24 :: doprogramować flage określającą, czy można przekroczyć zapisaną tabele wag i wprowadzić 4 pozycje do cennika dostawy
-- #8223 ko24 :: doprogramować flagę określającą czy dla danego kuriera jest dostepna przesyłka za pobraniem; uzależnienie widoczności tej opcji dostawy w koszyku od tej flagi
ALTER TABLE `commerce_shipment_methods` ADD `is_weight_over` TINYINT NOT NULL DEFAULT '0' COMMENT 'Flaga określa czy można przekroczyć zapisaną tabelę wag' AFTER `track_link`
ALTER TABLE `commerce_shipment_methods` ADD `is_cash_on_delivery` TINYINT NOT NULL DEFAULT '0' COMMENT 'Flaga określa czy jest dostępna przesyłka za pobraniem' AFTER `is_weight_over` 


