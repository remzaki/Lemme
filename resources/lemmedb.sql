--
-- MySQL 5.5.20
-- Thu, 05 May 2016 10:38:47 +0000
--

CREATE DATABASE `lemmedb` DEFAULT CHARSET latin1;

USE `lemmedb`;

CREATE TABLE `userpref` (
   `ID` int(255) not null auto_increment,
   `Server` varchar(15) not null,
   `Instance` varchar(255),
   `Username` varchar(255) not null,
   `Password` varchar(255) not null,
   `User` varchar(40) not null,
   `DateAdded` varchar(255),
   PRIMARY KEY (`ID`),
   UNIQUE KEY (`User`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;