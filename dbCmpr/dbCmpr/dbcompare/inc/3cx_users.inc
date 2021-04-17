--
--
--
-- ------TABLE STRUCTURE FOR `3cx_users`
CREATE TABLE `3cx_users` (
  `id` int(10) NOT NULL,
  `3cx_user_name` varchar(255) NOT NULL,
  `3cs_user_alt_name` varchar(255) NOT NULL,
  `3cx_extension_number` varchar(255) NOT NULL,
  `date` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1 COMMENT='3cx users to identify them';
  
  
