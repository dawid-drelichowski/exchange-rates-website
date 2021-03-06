DROP DATABASE IF EXISTS `ExchangeRatesWebsite`;
CREATE DATABASE IF NOT EXISTS `ExchangeRatesWebsite` DEFAULT CHARACTER SET utf8;

USE `ExchangeRatesWebsite`;

DROP TABLE IF EXISTS `ExchangeRate`;
CREATE TABLE `ExchangeRate` (
    `id` TINYINT(3) UNSIGNED NOT NULL AUTO_INCREMENT,
    `typeId` TINYINT(3) UNSIGNED NOT NULL DEFAULT '1',
    `country` VARCHAR(50) DEFAULT NULL,
    `currency` VARCHAR(10) DEFAULT NULL,
    `purchase` FLOAT UNSIGNED DEFAULT NULL,
    `sale` FLOAT UNSIGNED DEFAULT NULL,
    `purchaseTendency` TINYINT(1) NOT NULL DEFAULT '0',
    `saleTendency` TINYINT(1) NOT NULL DEFAULT '0',
    `timestamp` TIMESTAMP NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
    PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

DROP FUNCTION IF EXISTS `tendency`;

DELIMITER $$ 
CREATE FUNCTION `tendency` (`first` FLOAT UNSIGNED, `second` FLOAT UNSIGNED)
    RETURNS TINYINT
BEGIN
    DECLARE `result` TINYINT DEFAULT '0';
    
    IF `first` > `second` THEN
        SET `result` = -1;
    ELSEIF `first` < `second` THEN
        SET `result` = 1;
    END IF;
    
    RETURN `result`;
END $$
DELIMITER ;

DROP PROCEDURE IF EXISTS `updateExchangeRate`;

DELIMITER $$ 
CREATE PROCEDURE `updateExchangeRate` (
    IN `id` TINYINT(3) UNSIGNED,
    IN `typeId` TINYINT(3) UNSIGNED,
    IN `country` VARCHAR(50),
    IN `currency` VARCHAR(10),
    IN `purchase` FLOAT UNSIGNED,
    IN `sale` FLOAT UNSIGNED
) BEGIN
    DECLARE `purchaseTendency`, `saleTendency` TINYINT(1) DEFAULT '0';
    
    SELECT tendency(`ER`.`purchase`, `purchase`), tendency(`ER`.`sale`, `sale`)
        INTO `purchaseTendency`, `saleTendency`
        FROM `ExchangeRate` AS `ER`
        WHERE `ER`.`id` = `id`;
    
    UPDATE `ExchangeRate` AS `ER`
        SET
            `ER`.`typeId` = `typeId`,
            `ER`.`country` = `country`,
            `ER`.`currency` = `currency`,
            `ER`.`purchase` = `purchase`,
            `ER`.`sale` = `sale`,
            `ER`.`purchaseTendency` = `purchaseTendency`,
            `ER`.`saleTendency` = `saleTendency`
        WHERE `ER`.`id` = `id`;    
        
END $$ 
DELIMITER ;

INSERT INTO `ExchangeRate` (`id`, `typeId`, `country`, `currency`, `purchase`, `sale`)
    VALUES
        (1, 1, 'United States' ,'USD', 0, 0),
        (2, 1, 'European Union', 'EUR', 0, 0),
        (3, 1, 'Great Britain', 'GBP', 0, 0),
        (4, 1, 'Switzerland', 'CHF', 0, 0),
        (5, 1, 'Australia', 'AUD', 0, 0),
        (6, 1, 'Canada', 'CAD', 0, 0),
        (7, 1, 'Sweden', 'SEK', 0, 0),
        (8, 1, 'Hungary', 'HUF', 0, 0),
        (9, 1, 'Denmark', 'DKK', 0, 0),
        (10, 1, 'Norway', 'NOK', 0, 0),
        (11, 1, 'Czech Republic', 'CZK', 0, 0),
        (12, 1, 'Slovakia', 'SKK', 0, 0),
        (13, 1, 'European Union coin', 'EURc', 0, 0),
        (14, 2, 'United States', 'USD', 0, 0),
        (15, 2, 'European Union', 'EUR', 0, 0),
        (16, 2, 'Great Britain', 'GBP', 0, 0),
        (17, 2, 'Switzerland', 'CHF', 0, 0),
        (18, 2, 'Australia', 'AUD', 0, 0),
        (19, 2, 'Canada', 'CAD', 0, 0),
        (20, 2, 'Sweden', 'SEK', 0, 0),
        (21, 2, 'Hungary', 'HUF', 0, 0),
        (22, 2, 'Denmark', 'DKK', 0, 0),
        (23, 2, 'Norway', 'NOK', 0, 0),
        (24, 2, 'Czech Republic', 'CZK', 0, 0),
        (25, 2, 'Slovakia', 'SKK', 0, 0),
        (26, 2, 'European Union coin', 'EURc', 0, 0);