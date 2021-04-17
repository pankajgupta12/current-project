--
--
--
-- ------TABLE STRUCTURE FOR `3cx_calls_details`
CREATE TABLE `3cx_calls_details` (
  `id` bigint(25) NOT NULL AUTO_INCREMENT,
  `import_name` text NOT NULL COMMENT 'csv file name',
  `phone_id` bigint(255) NOT NULL,
  `calls_id` bigint(255) NOT NULL,
  `date` varchar(255) DEFAULT NULL,
  `time` varchar(255) DEFAULT NULL,
  `caller_id` bigint(255) DEFAULT NULL,
  `destination` varchar(255) DEFAULT NULL,
  `status` varchar(255) DEFAULT NULL,
  `ringing` varchar(255) NOT NULL,
  `talking` varchar(255) NOT NULL,
  `totals` varchar(255) NOT NULL,
  `cost` float(5,2) DEFAULT NULL,
  `reasons` text,
  `updated_time` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=9314 DEFAULT CHARSET=latin1 COMMENT='complete call details';
  
  
