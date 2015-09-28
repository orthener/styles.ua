

-- SELECT `locale`, `model`, `foreign_key`, `field`, `content` FROM `i18n` WHERE `model` LIKE 'Accessories'

INSERT INTO `i18n` (`locale`, `model`, `foreign_key`, `field`, `content`)
    SELECT 'pol', 'GlassPatternedType', id, 'name', `name` FROM `glass_patterned_types`;

INSERT INTO `i18n` (`locale`, `model`, `foreign_key`, `field`, `content`)
    SELECT 'pol', 'GlassPatternedType', id, 'description', `description` FROM `glass_patterned_types`;

INSERT INTO `i18n` (`locale`, `model`, `foreign_key`, `field`, `content`)
    SELECT 'pol', 'GlassTypesCategory', id, 'name', `name` FROM `glass_types_categories`;

INSERT INTO `i18n` (`locale`, `model`, `foreign_key`, `field`, `content`)
    SELECT 'pol', 'GlassTypesCategory', id, 'description', `description` FROM `glass_types_categories`;

INSERT INTO `i18n` (`locale`, `model`, `foreign_key`, `field`, `content`)
    SELECT 'pol', 'GlassType', id, 'name', `name` FROM `glass_types`;

INSERT INTO `i18n` (`locale`, `model`, `foreign_key`, `field`, `content`)
    SELECT 'pol', 'GlassType', id, 'description', `description` FROM `glass_types`;


INSERT INTO `i18n` (`locale`, `model`, `foreign_key`, `field`, `content`)
    SELECT 'pol', 'SashType', id, 'name', `name` FROM `sash_types`;

INSERT INTO `i18n` (`locale`, `model`, `foreign_key`, `field`, `content`)
    SELECT 'pol', 'WindowColorGroup', id, 'name', `name` FROM `window_color_groups`;

INSERT INTO `i18n` (`locale`, `model`, `foreign_key`, `field`, `content`)
    SELECT 'pol', 'WindowColor', id, 'name', `name` FROM `window_colors`;

INSERT INTO `i18n` (`locale`, `model`, `foreign_key`, `field`, `content`)
    SELECT 'pol', 'WindowSealColor', id, 'name', `name` FROM `window_seal_colors`;


INSERT INTO `i18n` (`locale`, `model`, `foreign_key`, `field`, `content`)
    SELECT 'pol', 'WindowFitting', id, 'name', `name` FROM `window_fittings`;

INSERT INTO `i18n` (`locale`, `model`, `foreign_key`, `field`, `content`)
    SELECT 'pol', 'WindowFitting', id, 'description', `description` FROM `window_fittings`;


INSERT INTO `i18n` (`locale`, `model`, `foreign_key`, `field`, `content`)
    SELECT 'pol', 'WindowHandler', id, 'name', `name` FROM `window_handlers`;

INSERT INTO `i18n` (`locale`, `model`, `foreign_key`, `field`, `content`)
    SELECT 'pol', 'WindowHandler', id, 'type', `type` FROM `window_handlers`;

INSERT INTO `i18n` (`locale`, `model`, `foreign_key`, `field`, `content`)
    SELECT 'pol', 'WindowHandler', id, 'color', `color` FROM `window_handlers`;
