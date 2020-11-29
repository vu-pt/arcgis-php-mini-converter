drop user if exists 'spaghetti_user'@'localhost';
drop user if exists 'spaghetti_user'@'%';

CREATE USER 'spaghetti_user'@'localhost' IDENTIFIED BY 'spaghetti_user';
CREATE USER 'spaghetti_user'@'%' IDENTIFIED BY 'spaghetti_user';

drop database if exists spaghetti;
create database spaghetti;

GRANT ALL PRIVILEGES ON spaghetti.* TO 'spaghetti_user'@'localhost';
GRANT ALL PRIVILEGES ON spaghetti.* TO 'spaghetti_user'@'%';

use spaghetti;
CREATE TABLE `TSP_POINT` (
    `idp` INT (10) NOT NULL AUTO_INCREMENT,
    `name` VARCHAR (100),
    `location` VARCHAR (100),
	`x` DECIMAL(11, 8) NOT NULL COMMENT 'longitude',
	`y` DECIMAL(10, 8) NOT NULL COMMENT 'latitude',
    PRIMARY KEY (`idp`)
)
ENGINE=InnoDB
DEFAULT CHARSET=utf8;

CREATE TABLE `TSP_LINE` (
    `idl` INT (10) NOT NULL AUTO_INCREMENT,
    `name` VARCHAR (100),
    `description` VARCHAR (100),
    PRIMARY KEY (`idl`)
)
ENGINE=InnoDB
DEFAULT CHARSET=utf8;

CREATE TABLE `TSP_POLYGON` (
    `idpo` INT (10) NOT NULL AUTO_INCREMENT,
    `name` VARCHAR (100),
    `description` VARCHAR (100),
    PRIMARY KEY (`idpo`)
)
ENGINE=InnoDB
DEFAULT CHARSET=utf8;

CREATE TABLE `TSP_LINE_POINT` (
    `idlp` INT (10) NOT NULL AUTO_INCREMENT,
    `idl` INT (10) NOT NULL,
    `idp` INT (10) NOT NULL,
    `seq` INT not null,
    PRIMARY KEY (`idlp`)
)
ENGINE=InnoDB
DEFAULT CHARSET=utf8;

CREATE TABLE `TSP_POLYGON_POINT` (
    `idpp` INT (10) NOT NULL AUTO_INCREMENT,
    `idpo` INT (10) NOT NULL,
    `idp` INT (10) NOT NULL,
    `seq` INT not null,
    PRIMARY KEY (`idpp`)
)
ENGINE=InnoDB
DEFAULT CHARSET=utf8;