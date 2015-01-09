
# This is a fix for InnoDB in MySQL >= 4.1.x
# It "suspends judgement" for fkey relationships until are tables are set.
SET FOREIGN_KEY_CHECKS = 0;

-- ---------------------------------------------------------------------
-- sensor
-- ---------------------------------------------------------------------

DROP TABLE IF EXISTS `sensor`;

CREATE TABLE `sensor`
(
    `id` INTEGER NOT NULL AUTO_INCREMENT,
    `name` VARCHAR(128) NOT NULL,
    `description` VARCHAR(255),
    `delay` INTEGER NOT NULL,
    `status` VARCHAR(255) NOT NULL,
    `station_id` INTEGER NOT NULL,
    `stype_id` INTEGER NOT NULL,
    PRIMARY KEY (`id`),
    INDEX `sensor_fi_512178` (`station_id`),
    INDEX `sensor_fi_96faac` (`stype_id`),
    CONSTRAINT `sensor_fk_512178`
        FOREIGN KEY (`station_id`)
        REFERENCES `station` (`id`),
    CONSTRAINT `sensor_fk_96faac`
        FOREIGN KEY (`stype_id`)
        REFERENCES `sensortype` (`id`)
) ENGINE=InnoDB;

-- ---------------------------------------------------------------------
-- station
-- ---------------------------------------------------------------------

DROP TABLE IF EXISTS `station`;

CREATE TABLE `station`
(
    `id` INTEGER NOT NULL AUTO_INCREMENT,
    `name` VARCHAR(128) NOT NULL,
    `description` VARCHAR(128),
    `url_sensor` VARCHAR(255),
    `url_netmodule` VARCHAR(255),
    `url_tissan` VARCHAR(255),
    PRIMARY KEY (`id`)
) ENGINE=InnoDB;

-- ---------------------------------------------------------------------
-- measurement
-- ---------------------------------------------------------------------

DROP TABLE IF EXISTS `measurement`;

CREATE TABLE `measurement`
(
    `id` INTEGER NOT NULL AUTO_INCREMENT,
    `name` VARCHAR(128) NOT NULL,
    `value_float` FLOAT,
    `value_string` VARCHAR(128),
    `timestamp` DATE NOT NULL,
    `unit` VARCHAR(255),
    `sensor_id` INTEGER NOT NULL,
    PRIMARY KEY (`id`),
    INDEX `measurement_fi_6c28b5` (`sensor_id`),
    CONSTRAINT `measurement_fk_6c28b5`
        FOREIGN KEY (`sensor_id`)
        REFERENCES `sensor` (`id`)
) ENGINE=InnoDB;

-- ---------------------------------------------------------------------
-- sensortype
-- ---------------------------------------------------------------------

DROP TABLE IF EXISTS `sensortype`;

CREATE TABLE `sensortype`
(
    `id` INTEGER NOT NULL AUTO_INCREMENT,
    `name` VARCHAR(128) NOT NULL,
    `description` VARCHAR(128),
    `unit` VARCHAR(128),
    PRIMARY KEY (`id`)
) ENGINE=InnoDB;

-- ---------------------------------------------------------------------
-- alert
-- ---------------------------------------------------------------------

DROP TABLE IF EXISTS `alert`;

CREATE TABLE `alert`
(
    `id` INTEGER NOT NULL AUTO_INCREMENT,
    `name` VARCHAR(128) NOT NULL,
    `description` VARCHAR(128),
    `timestamp` DATE NOT NULL,
    `sensor_id` INTEGER NOT NULL,
    PRIMARY KEY (`id`),
    INDEX `alert_fi_6c28b5` (`sensor_id`),
    CONSTRAINT `alert_fk_6c28b5`
        FOREIGN KEY (`sensor_id`)
        REFERENCES `sensor` (`id`)
) ENGINE=InnoDB;

# This restores the fkey checks, after having unset them earlier
SET FOREIGN_KEY_CHECKS = 1;
