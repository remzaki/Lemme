--
-- MySQL 5.5.20
-- Mon, 16 Mar 2015 10:58:28 +0000
--

CREATE DATABASE `ps_db` DEFAULT CHARSET latin1;

USE `ps_db`;

CREATE TABLE `ps_data` (
   `ID` int(255) not null auto_increment,
   `AID` varchar(8) not null,
   `Server` varchar(100),
   `Instance` varchar(100),
   `Username` varchar(100),
   `Password` varchar(100),
   `Table` varchar(100),
   `Top` int(100),
   `StoreFilter` varchar(100),
   `TermFilter` varchar(100),
   `TransFilter` varchar(100),
   `TransType` varchar(100),
   `IPAddress` varchar(100),
   `Date` varchar(100),
   PRIMARY KEY (`ID`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;