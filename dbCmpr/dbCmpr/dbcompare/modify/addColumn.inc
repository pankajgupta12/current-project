-- 
-- 
-- ADD  COLUMN  FOR  THIS` job_details` BEFORE COLUMN DATATYPE (NEW FIELD)
-- 
-- 
    ALTER TABLE `bciccom_db`.`job_details`
  ADD  COLUMN `job_sms` text NULL ;

-- 
-- 
-- ADD  COLUMN  FOR  THIS` job_details` BEFORE COLUMN DATATYPE (NEW FIELD)
-- 
-- 
    ALTER TABLE `bciccom_db`.`job_details`
  ADD  COLUMN `address_sms` text NULL ;

-- 
-- 
-- ADD  COLUMN  FOR  THIS` job_details` BEFORE COLUMN DATATYPE (NEW FIELD)
-- 
-- 
    ALTER TABLE `bciccom_db`.`job_details`
  ADD  COLUMN `job_sms_date` datetime NOT NULL ;

-- 
-- 
-- ADD  COLUMN  FOR  THIS` job_details` BEFORE COLUMN DATATYPE (NEW FIELD)
-- 
-- 
    ALTER TABLE `bciccom_db`.`job_details`
  ADD  COLUMN `address_sms_date` datetime NOT NULL ;

-- 
-- 
-- ADD  COLUMN  FOR  THIS` quote_new` BEFORE COLUMN DATATYPE (NEW FIELD)
-- 
-- 
    ALTER TABLE `bciccom_db`.`quote_new`
  ADD  COLUMN `second_called_date` datetime NOT NULL ;

-- 
-- 
-- ADD  COLUMN  FOR  THIS` quote_new` BEFORE COLUMN DATATYPE (NEW FIELD)
-- 
-- 
    ALTER TABLE `bciccom_db`.`quote_new`
  ADD  COLUMN `seven_called_date` datetime NOT NULL ;

