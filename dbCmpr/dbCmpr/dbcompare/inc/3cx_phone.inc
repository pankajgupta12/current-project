--
--
--
-- ------TABLE STRUCTURE FOR `3cx_phone`
CREATE TABLE `3cx_phone` (
  `id` bigint(255) NOT NULL AUTO_INCREMENT,
  `phone_number` varchar(255) NOT NULL,
  `import_name` text NOT NULL COMMENT 'csv file name',
  `date_time` varchar(255) NOT NULL COMMENT 'for checking and prevent duplicacy',
  `date` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=3445 DEFAULT CHARSET=latin1 COMMENT='3cx call first step';
  
  
