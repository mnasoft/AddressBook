DROP DATABASE address;

CREATE DATABASE address;
SET NAMES 'utf8';

USE address;

CREATE TABLE Countries
(
  id            BIGINT UNSIGNED AUTO_INCREMENT,
  country       varchar(50) NOT NULL COMMENT 'Название страны',
  country_full  varchar(100) NOT NULL COMMENT 'Полное название страны',
  PRIMARY KEY (id)
) ENGINE InnoDB CHARACTER SET utf8 COLLATE utf8_general_ci;

CREATE TABLE Regions
(
  id         BIGINT UNSIGNED AUTO_INCREMENT,
  country_id BIGINT UNSIGNED NOT NULL COMMENT 'Индекс страны', 
  region     VARCHAR(100) COMMENT 'Область',
  PRIMARY KEY (id),
  FOREIGN KEY (country_id) REFERENCES Countries (id) ON DELETE RESTRICT ON UPDATE CASCADE
) ENGINE InnoDB CHARACTER SET utf8 COLLATE utf8_general_ci;

CREATE TABLE Districts
(
  id         BIGINT UNSIGNED AUTO_INCREMENT,
  region_id  BIGINT UNSIGNED NOT NULL COMMENT 'Индекс области',
  district   VARCHAR(100) COMMENT 'Индекс района',
  PRIMARY KEY (id),
  FOREIGN KEY (region_id) REFERENCES Regions (id) ON DELETE RESTRICT ON UPDATE CASCADE
) ENGINE InnoDB CHARACTER SET utf8 COLLATE utf8_general_ci;

CREATE TABLE Localities
(
  id           BIGINT UNSIGNED AUTO_INCREMENT,
  district_id  BIGINT UNSIGNED NOT NULL COMMENT 'Индекс района',
  locality     VARCHAR(100) COMMENT 'Населенный пункт',
  PRIMARY KEY (id),
  FOREIGN KEY (district_id) REFERENCES Districts (id) ON DELETE RESTRICT ON UPDATE CASCADE
) ENGINE InnoDB CHARACTER SET utf8 COLLATE utf8_general_ci;

CREATE TABLE Streets
(
  id           BIGINT UNSIGNED AUTO_INCREMENT,
  locality_id  BIGINT UNSIGNED NOT NULL COMMENT 'Индекс населенного пункта',
  street       VARCHAR(100) COMMENT 'Улица',
  PRIMARY KEY (id),
  FOREIGN KEY (locality_id) REFERENCES Localities (id) ON DELETE RESTRICT ON UPDATE CASCADE
) ENGINE InnoDB CHARACTER SET utf8 COLLATE utf8_general_ci;

CREATE TABLE Houses
(
  id           BIGINT UNSIGNED AUTO_INCREMENT,
  street_id    BIGINT UNSIGNED NOT NULL COMMENT 'Индекс населенного пункта',
  house        VARCHAR(15), 
  PRIMARY KEY (id),
  FOREIGN KEY (street_id) REFERENCES Streets (id) ON DELETE RESTRICT ON UPDATE CASCADE
) ENGINE InnoDB CHARACTER SET utf8 COLLATE utf8_general_ci;

CREATE TABLE Rooms
(
  id           BIGINT UNSIGNED AUTO_INCREMENT,
  house_id     BIGINT UNSIGNED NOT NULL COMMENT 'Индекс населенного пункта',
  room         VARCHAR(15),
  PRIMARY KEY (id),
  FOREIGN KEY (house_id) REFERENCES Houses (id) ON DELETE RESTRICT ON UPDATE CASCADE
) ENGINE InnoDB CHARACTER SET utf8 COLLATE utf8_general_ci;

CREATE TABLE Humans
(
  id           BIGINT UNSIGNED AUTO_INCREMENT,
  f            VARCHAR(50),
  i            VARCHAR(50),
  o            VARCHAR(50),
  sex          ENUM('male','female'),
  birth        DATE,
  PRIMARY KEY (id)
) ENGINE InnoDB CHARACTER SET utf8 COLLATE utf8_general_ci  COMMENT 'Люди';

CREATE TABLE Human_Room
(
  id           BIGINT UNSIGNED AUTO_INCREMENT,
  human_id     BIGINT UNSIGNED NOT NULL COMMENT 'Индекс особы',
  room_id      BIGINT UNSIGNED NOT NULL COMMENT 'Индекс населенного пункта',
  PRIMARY KEY (id),
  FOREIGN KEY (human_id) REFERENCES Humans (id) ON DELETE RESTRICT ON UPDATE CASCADE,
  FOREIGN KEY (room_id) REFERENCES Rooms (id) ON DELETE RESTRICT ON UPDATE CASCADE
) ENGINE InnoDB CHARACTER SET utf8 COLLATE utf8_general_ci  COMMENT 'Люди';

CREATE TABLE Phones
(
  id           BIGINT UNSIGNED AUTO_INCREMENT,
  phone        VARCHAR(50) NOT NULL COMMENT 'Телефон',
  note         VARCHAR(50) NULL COMMENT 'Примечание',
  PRIMARY KEY (id)  
) ENGINE InnoDB CHARACTER SET utf8 COLLATE utf8_general_ci COMMENT 'Телефоны';

CREATE TABLE Phone_Room
(
  id       BIGINT UNSIGNED AUTO_INCREMENT,
  phone_id     BIGINT UNSIGNED NOT NULL COMMENT 'Индекс особы',
  room_id      BIGINT UNSIGNED NOT NULL COMMENT 'Индекс населенного пункта',
  PRIMARY KEY (id),
  FOREIGN KEY (phone_id) REFERENCES Humans (id) ON DELETE RESTRICT ON UPDATE CASCADE,
  FOREIGN KEY (room_id) REFERENCES Rooms (id) ON DELETE RESTRICT ON UPDATE CASCADE
) ENGINE InnoDB CHARACTER SET utf8 COLLATE utf8_general_ci  COMMENT 'Телефоны';

CREATE TABLE Human_Phone
(
  id           BIGINT UNSIGNED AUTO_INCREMENT,
  human_id     BIGINT UNSIGNED NOT NULL COMMENT 'Индекс особы',
  phone_id     BIGINT UNSIGNED NOT NULL COMMENT 'Индекс телефона',
  PRIMARY KEY (id),
  FOREIGN KEY (human_id) REFERENCES Humans (id) ON DELETE RESTRICT ON UPDATE CASCADE,
  FOREIGN KEY (phone_id) REFERENCES Phones (id) ON DELETE RESTRICT ON UPDATE CASCADE
) ENGINE InnoDB CHARACTER SET utf8 COLLATE utf8_general_ci COMMENT 'Таблица владения телефонами';

CREATE TABLE Emailes
(
  id           BIGINT UNSIGNED AUTO_INCREMENT,
  mail         VARCHAR(50), 
  PRIMARY KEY (id)
) ENGINE InnoDB CHARACTER SET utf8 COLLATE utf8_general_ci COMMENT 'Электронная почта';

CREATE TABLE Human_Email
(
  id           BIGINT UNSIGNED AUTO_INCREMENT,
  human_id     BIGINT UNSIGNED NOT NULL COMMENT 'Индекс особы',
  email_id     BIGINT UNSIGNED NOT NULL COMMENT 'Индекс электронной почты',
  note         VARCHAR(50) NULL COMMENT 'Примечание',
  PRIMARY KEY (id),
  FOREIGN KEY (human_id) REFERENCES Humans (id) ON DELETE RESTRICT ON UPDATE CASCADE,
  FOREIGN KEY (email_id) REFERENCES Emailes (id) ON DELETE RESTRICT ON UPDATE CASCADE
) ENGINE InnoDB CHARACTER SET utf8 COLLATE utf8_general_ci COMMENT 'Электронная почта';
