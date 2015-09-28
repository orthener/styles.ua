ALTER TABLE `comments` CHANGE `page_id` `page_id` INT( 11 ) NULL;
ALTER TABLE `comments` ADD `news_id` INT NULL AFTER `page_id`;
ALTER TABLE `comments` ADD `user_id` CHAR( 36 ) NOT NULL AFTER `news_id`;
