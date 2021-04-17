--
--
--
-- ------TABLE STRUCTURE FOR `3cx_calls`
CREATE TABLE `3cx_calls` (
  `id` bigint(255) NOT NULL AUTO_INCREMENT,
  `import_name` text NOT NULL COMMENT 'csv file name',
  `phone_id` bigint(255) NOT NULL,
  `call_date` varchar(255) DEFAULT NULL,
  `call_time` varchar(255) DEFAULT NULL,
  `from_type` varchar(255) DEFAULT NULL COMMENT '(admin/client/staff)',
  `from_number` varchar(255) DEFAULT NULL,
  `to_type` varchar(255) DEFAULT NULL COMMENT '(admin/client/staff)',
  `to_number` varchar(255) DEFAULT NULL,
  `ivr_option` varchar(255) DEFAULT NULL COMMENT '( sales, existings, others )',
  `duration` varchar(255) DEFAULT NULL,
  `terminated_by` varchar(255) DEFAULT NULL COMMENT '(admin/client/staff), who disconnected the call',
  `staff_id` bigint(255) DEFAULT NULL,
  `admin_id` bigint(255) DEFAULT NULL,
  `quote_id` varchar(255) DEFAULT NULL,
  `job_id` varchar(255) DEFAULT NULL,
  `approved_status` tinyint(2) NOT NULL DEFAULT '0' COMMENT '0 => unapproved , 1 => approved by someone',
  `approved_by` int(10) NOT NULL COMMENT 'approved by someone login id',
  `comments` text,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=3444 DEFAULT CHARSET=latin1 COMMENT='initial call detail';
  
  
