-- phpMyAdmin SQL Dump
-- HOST
-- Generation Time: {date()}
 SET SQL_MODE = ''; 
--
--
-- --STRUCTURE SQL
--
--
--
-- ------TABLE STRUCTURE FOR `dd_blinds`
CREATE TABLE `dd_blinds` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `name` varchar(50) NOT NULL,
  `val` varchar(50) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM AUTO_INCREMENT=6 DEFAULT CHARSET=latin1;
  
  
-- 
-- 
-- 
-- ------TABLE DATA FOR IMPORT `bciccom_db2`.`dd_blinds`
-- 
-- 
-- 
INSERT INTO `bciccom_db2`.`dd_blinds`  VALUES ('1' , 'No Blinds' , 'no_blinds' ) ;
 
INSERT INTO `bciccom_db2`.`dd_blinds`  VALUES ('2' , 'Vertical' , 'vertical' ) ;
 
INSERT INTO `bciccom_db2`.`dd_blinds`  VALUES ('3' , 'Venetians' , 'venetians' ) ;
 
INSERT INTO `bciccom_db2`.`dd_blinds`  VALUES ('4' , 'Rollers' , 'rollers' ) ;
 
INSERT INTO `bciccom_db2`.`dd_blinds`  VALUES ('5' , 'Shutters' , 'shutters' ) ;
 
--
--
--
-- ------TABLE STRUCTURE FOR `dd_property_type`
CREATE TABLE `dd_property_type` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `val` varchar(50) NOT NULL,
  `name` varchar(50) NOT NULL,
  `amount` varchar(10) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM AUTO_INCREMENT=5 DEFAULT CHARSET=latin1;
  
  
-- 
-- 
-- 
-- ------TABLE DATA FOR IMPORT `bciccom_db2`.`dd_property_type`
-- 
-- 
-- 
INSERT INTO `bciccom_db2`.`dd_property_type`  VALUES ('1' , 'unit' , 'Unit' , '0' ) ;
 
INSERT INTO `bciccom_db2`.`dd_property_type`  VALUES ('2' , 'house' , 'House' , '0' ) ;
 
INSERT INTO `bciccom_db2`.`dd_property_type`  VALUES ('3' , 'two_stroy' , 'Two Story' , '40' ) ;
 
INSERT INTO `bciccom_db2`.`dd_property_type`  VALUES ('4' , 'multi_story' , 'Multi Story' , '80' ) ;
 
--
--
--
-- ------TABLE STRUCTURE FOR `job_images`
CREATE TABLE `job_images` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `job_id` int(11) NOT NULL,
  `image` varchar(255) NOT NULL,
  `createdOn` datetime NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=4 DEFAULT CHARSET=latin1;
  
  
--
--
--
-- ------TABLE STRUCTURE FOR `quote_details`
CREATE TABLE `quote_details` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `quote_id` int(11) NOT NULL,
  `job_type_id` int(11) NOT NULL,
  `job_type` varchar(50) NOT NULL,
  `bed` varchar(10) NOT NULL,
  `study` varchar(10) NOT NULL,
  `bath` varchar(10) NOT NULL,
  `toilet` varchar(10) NOT NULL,
  `living` varchar(10) NOT NULL,
  `furnished` varchar(10) NOT NULL,
  `property_type` varchar(10) NOT NULL,
  `blinds_type` varchar(25) NOT NULL,
  `carpet_stairs` varchar(10) NOT NULL,
  `pest_inside` int(1) NOT NULL,
  `pest_outside` int(1) NOT NULL,
  `pest_flee` int(1) NOT NULL,
  `hours` varchar(10) NOT NULL,
  `rate` varchar(10) NOT NULL,
  `amount` varchar(10) NOT NULL,
  `description` tinytext NOT NULL,
  `status` int(11) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM AUTO_INCREMENT=3234 DEFAULT CHARSET=latin1;
  
  
--
--
--
-- ------TABLE STRUCTURE FOR `quote_new`
CREATE TABLE `quote_new` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `site_id` int(11) NOT NULL,
  `booking_id` int(11) NOT NULL,
  `job_ref` varchar(25) COLLATE utf8_unicode_ci NOT NULL,
  `date` date NOT NULL,
  `name` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `email` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `phone` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `suburb` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `address` tinytext COLLATE utf8_unicode_ci NOT NULL,
  `booking_date` date NOT NULL,
  `amount` varchar(50) COLLATE utf8_unicode_ci NOT NULL,
  `status` int(1) NOT NULL,
  `login_id` int(11) NOT NULL,
  `comments` text COLLATE utf8_unicode_ci NOT NULL,
  `deleted` int(1) NOT NULL,
  `emailed_client` datetime NOT NULL,
  `called` int(1) NOT NULL,
  `called_date` datetime NOT NULL,
  `ssecret` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `sms_quote_date` date NOT NULL,
  `step` int(1) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM AUTO_INCREMENT=1910 DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;
  
  
--
--
--
-- ------TABLE STRUCTURE FOR `quote_notes`
CREATE TABLE `quote_notes` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `quote_id` int(11) NOT NULL,
  `date` datetime NOT NULL,
  `heading` tinytext COLLATE utf8_unicode_ci NOT NULL,
  `comment` text COLLATE utf8_unicode_ci NOT NULL,
  `login_id` int(11) NOT NULL,
  `staff_name` varchar(64) COLLATE utf8_unicode_ci NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM AUTO_INCREMENT=64 DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;
  
  
--
--
--
-- ------TABLE STRUCTURE FOR `rates_carpet`
CREATE TABLE `rates_carpet` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `site_id` int(11) NOT NULL,
  `bed` int(11) NOT NULL,
  `living` int(11) NOT NULL,
  `stairs` int(11) NOT NULL,
  `price` varchar(10) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM AUTO_INCREMENT=10 DEFAULT CHARSET=latin1;
  
  
-- 
-- 
-- 
-- ------TABLE DATA FOR IMPORT `bciccom_db2`.`rates_carpet`
-- 
-- 
-- 
INSERT INTO `bciccom_db2`.`rates_carpet`  VALUES ('1' , '0' , '1' , '1' , '0' , '70' ) ;
 
INSERT INTO `bciccom_db2`.`rates_carpet`  VALUES ('2' , '0' , '1' , '1' , '15' , '70' ) ;
 
INSERT INTO `bciccom_db2`.`rates_carpet`  VALUES ('3' , '0' , '2' , '1' , '0' , '80' ) ;
 
INSERT INTO `bciccom_db2`.`rates_carpet`  VALUES ('4' , '0' , '2' , '1' , '15' , '85' ) ;
 
INSERT INTO `bciccom_db2`.`rates_carpet`  VALUES ('5' , '0' , '2' , '2' , '0' , '80' ) ;
 
INSERT INTO `bciccom_db2`.`rates_carpet`  VALUES ('6' , '0' , '2' , '2' , '15' , '90' ) ;
 
INSERT INTO `bciccom_db2`.`rates_carpet`  VALUES ('7' , '0' , '3' , '1' , '0' , '90' ) ;
 
INSERT INTO `bciccom_db2`.`rates_carpet`  VALUES ('8' , '0' , '3' , '2' , '15' , '100' ) ;
 
INSERT INTO `bciccom_db2`.`rates_carpet`  VALUES ('9' , '0' , '3' , '0' , '15' , '95' ) ;
 
--
--
--
-- ------TABLE STRUCTURE FOR `rates_cleaning`
CREATE TABLE `rates_cleaning` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `site_id` int(11) NOT NULL,
  `bed` int(11) NOT NULL,
  `bath` int(11) NOT NULL,
  `toilet` float NOT NULL,
  `hours` varchar(10) NOT NULL,
  `unfurnished` varchar(10) NOT NULL,
  `furnished` varchar(10) NOT NULL,
  `f_extra_hours` int(1) NOT NULL,
  `blinds` varchar(10) NOT NULL,
  `living_inc` int(11) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM AUTO_INCREMENT=18 DEFAULT CHARSET=latin1;
  
  
-- 
-- 
-- 
-- ------TABLE DATA FOR IMPORT `bciccom_db2`.`rates_cleaning`
-- 
-- 
-- 
INSERT INTO `bciccom_db2`.`rates_cleaning`  VALUES ('1' , '0' , '1' , '1' , '0' , '6' , '250' , '290' , '1' , '40' , '1' ) ;
 
INSERT INTO `bciccom_db2`.`rates_cleaning`  VALUES ('2' , '0' , '2' , '1' , '0' , '7' , '280' , '320' , '1' , '40' , '1' ) ;
 
INSERT INTO `bciccom_db2`.`rates_cleaning`  VALUES ('3' , '0' , '2' , '2' , '0' , '8' , '320' , '400' , '1' , '40' , '1' ) ;
 
INSERT INTO `bciccom_db2`.`rates_cleaning`  VALUES ('4' , '0' , '3' , '1' , '0' , '10' , '400' , '480' , '1' , '40' , '1' ) ;
 
INSERT INTO `bciccom_db2`.`rates_cleaning`  VALUES ('5' , '0' , '3' , '2' , '0' , '10' , '400' , '480' , '1' , '40' , '1' ) ;
 
INSERT INTO `bciccom_db2`.`rates_cleaning`  VALUES ('6' , '0' , '3' , '3' , '0' , '11' , '440' , '500' , '1' , '40' , '2' ) ;
 
INSERT INTO `bciccom_db2`.`rates_cleaning`  VALUES ('7' , '0' , '4' , '2' , '0' , '12' , '480' , '540' , '1' , '80' , '2' ) ;
 
INSERT INTO `bciccom_db2`.`rates_cleaning`  VALUES ('9' , '0' , '4' , '3' , '0' , '13' , '520' , '560' , '1' , '80' , '2' ) ;
 
INSERT INTO `bciccom_db2`.`rates_cleaning`  VALUES ('10' , '0' , '5' , '1' , '0' , '16' , '640' , '720' , '1' , '80' , '2' ) ;
 
INSERT INTO `bciccom_db2`.`rates_cleaning`  VALUES ('11' , '0' , '5' , '2' , '0' , '16' , '640' , '720' , '1' , '80' , '2' ) ;
 
INSERT INTO `bciccom_db2`.`rates_cleaning`  VALUES ('12' , '0' , '5' , '3' , '0' , '17' , '680' , '720' , '1' , '80' , '2' ) ;
 
INSERT INTO `bciccom_db2`.`rates_cleaning`  VALUES ('13' , '0' , '5' , '4' , '0' , '18' , '720' , '760' , '1' , '80' , '2' ) ;
 
INSERT INTO `bciccom_db2`.`rates_cleaning`  VALUES ('14' , '0' , '6' , '2' , '0' , '19' , '760' , '800' , '1' , '80' , '2' ) ;
 
INSERT INTO `bciccom_db2`.`rates_cleaning`  VALUES ('15' , '0' , '6' , '3' , '0' , '20' , '800' , '880' , '2' , '80' , '3' ) ;
 
INSERT INTO `bciccom_db2`.`rates_cleaning`  VALUES ('16' , '0' , '6' , '4' , '0' , '20' , '800' , '880' , '2' , '80' , '3' ) ;
 
INSERT INTO `bciccom_db2`.`rates_cleaning`  VALUES ('17' , '0' , '7' , '3' , '0' , '22' , '880' , '1000' , '3' , '80' , '3' ) ;
 
--
--
--
-- ------TABLE STRUCTURE FOR `rates_pest`
CREATE TABLE `rates_pest` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `site_id` int(11) NOT NULL,
  `inside` varchar(10) NOT NULL,
  `outside` varchar(10) NOT NULL,
  `flea` varchar(10) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM AUTO_INCREMENT=3 DEFAULT CHARSET=latin1;
  
  
-- 
-- 
-- 
-- ------TABLE DATA FOR IMPORT `bciccom_db2`.`rates_pest`
-- 
-- 
-- 
INSERT INTO `bciccom_db2`.`rates_pest`  VALUES ('1' , '0' , '80' , '95' , '110' ) ;
 
INSERT INTO `bciccom_db2`.`rates_pest`  VALUES ('2' , '4' , '110' , '125' , '135' ) ;
 
--
--
--
-- ------TABLE STRUCTURE FOR `staff_files`
CREATE TABLE `staff_files` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `staff_id` int(11) NOT NULL,
  `image` varchar(255) NOT NULL,
  `createdOn` datetime NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=5 DEFAULT CHARSET=latin1;
  
  
--
--
--
-- ------TABLE STRUCTURE FOR `staff_roster`
CREATE TABLE `staff_roster` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `staff_id` int(11) NOT NULL,
  `date` date NOT NULL,
  `status` int(11) NOT NULL DEFAULT '0',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=244 DEFAULT CHARSET=latin1;
  
  
--
--
--
-- ------TABLE STRUCTURE FOR `temp_quote`
CREATE TABLE `temp_quote` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `session_id` varchar(64) COLLATE utf8_unicode_ci NOT NULL,
  `quote_id` int(11) NOT NULL,
  `job_ref` varchar(25) COLLATE utf8_unicode_ci NOT NULL,
  `site_id` int(11) NOT NULL,
  `date` date NOT NULL,
  `name` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `email` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `phone` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `suburb` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `address` tinytext COLLATE utf8_unicode_ci NOT NULL,
  `booking_date` date NOT NULL,
  `amount` varchar(50) COLLATE utf8_unicode_ci NOT NULL,
  `status` int(1) NOT NULL,
  `login_id` int(11) NOT NULL,
  `comments` text COLLATE utf8_unicode_ci NOT NULL,
  `deleted` int(1) NOT NULL,
  `emailed_client` datetime NOT NULL,
  `called` int(1) NOT NULL,
  `called_date` datetime NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM AUTO_INCREMENT=84 DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;
  
  
--
--
--
-- ------TABLE STRUCTURE FOR `temp_quote_details`
CREATE TABLE `temp_quote_details` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `temp_quote_id` int(11) NOT NULL,
  `job_type_id` int(11) NOT NULL,
  `job_type` varchar(50) NOT NULL,
  `bed` varchar(10) NOT NULL,
  `study` varchar(10) NOT NULL,
  `bath` varchar(10) NOT NULL,
  `toilet` varchar(10) NOT NULL,
  `living` varchar(10) NOT NULL,
  `furnished` varchar(10) NOT NULL,
  `property_type` varchar(10) NOT NULL,
  `blinds_type` varchar(10) NOT NULL,
  `carpet_stairs` varchar(10) NOT NULL,
  `pest_inside` int(1) NOT NULL,
  `pest_outside` int(1) NOT NULL,
  `pest_flee` int(1) NOT NULL,
  `hours` varchar(10) NOT NULL,
  `rate` varchar(10) NOT NULL,
  `amount` varchar(10) NOT NULL,
  `description` tinytext NOT NULL,
  `status` int(11) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM AUTO_INCREMENT=144 DEFAULT CHARSET=latin1;
  
  
--
--
 -- ADD NEW COLUMN 
--
--
ALTER TABLE `bciccom_db2`.`admin_module_details`
  ADD  COLUMN `f_filed_desc` text NOT NULL ;
--
--
--
--
 -- ADD NEW COLUMN 
--
--
ALTER TABLE `bciccom_db2`.`job_details`
  ADD  COLUMN `quote_details_id` int(11) NOT NULL ;
--
--
--
--
 -- ADD NEW COLUMN 
--
--
ALTER TABLE `bciccom_db2`.`job_details`
  ADD  COLUMN `description` tinytext NOT NULL ;
--
--
--
--
 -- ADD NEW COLUMN 
--
--
ALTER TABLE `bciccom_db2`.`job_type`
  ADD  COLUMN `inv` int(1) NOT NULL ;
--
--
--
--
 -- ADD NEW COLUMN 
--
--
ALTER TABLE `bciccom_db2`.`jobs`
  ADD  COLUMN `eway_token` varchar(255) NOT NULL ;
--
--
--
--
 -- ADD NEW COLUMN 
--
--
ALTER TABLE `bciccom_db2`.`staff`
  ADD  COLUMN `site_id2` int(11) NOT NULL ;
--
--
--
--
 -- ADD NEW COLUMN 
--
--
ALTER TABLE `bciccom_db2`.`staff`
  ADD  COLUMN `insurance_expiry` date NOT NULL ;
--
--
--
--
 -- ADD NEW COLUMN 
--
--
ALTER TABLE `bciccom_db2`.`staff`
  ADD  COLUMN `staff_member_rating` int(11)  DEFAULT 0  NOT NULL ;
--
--
--
--
 -- ADD NEW COLUMN 
--
--
ALTER TABLE `bciccom_db2`.`staff`
  ADD  COLUMN `nick_name` varchar(255) NOT NULL ;
--
--
--
--
 -- ADD NEW COLUMN 
--
--
ALTER TABLE `bciccom_db2`.`staff`
  ADD  COLUMN `avaibility` varchar(255) NOT NULL ;
--
--
--
--
 -- MODIFY EXISTS COLUMN AND OLD DATATYPE WAS ( int(1) )
--
--
ALTER TABLE `bciccom_db2`.`admin`
  MODIFY  COLUMN `status` int(11) NOT NULL ;
--
--
--
--
 -- MODIFY EXISTS COLUMN AND OLD DATATYPE WAS ( int(1) )
--
--
ALTER TABLE `bciccom_db2`.`admin_modules`
  MODIFY  COLUMN `xlist` tinyint(5)  DEFAULT 10  NOT NULL ;
--
--
--
--
 -- MODIFY EXISTS COLUMN AND OLD DATATYPE WAS ( longtext )
--
--
ALTER TABLE `bciccom_db2`.`job_notes`
  MODIFY  COLUMN `comment` text NOT NULL ;
--
--
--
--
 -- MODIFY EXISTS COLUMN AND OLD DATATYPE WAS ( varchar(25) )
--
--
ALTER TABLE `bciccom_db2`.`job_payments`
  MODIFY  COLUMN `amount` float(5,2)  DEFAULT 0.00  NOT NULL ;
--
--

--
--
--
