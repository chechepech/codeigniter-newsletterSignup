CREATE DATABASE `signupdb`;
USE DATABASE `signupdb`;
CREATE TABLE `signups` (
`signup_id` TINYINT NOT NULL AUTO_INCREMENT,
`signup_email` VARCHAR(30) NOT NULL,
`signup_opt1` TINYINT(1) NOT NULL,
`signup_opt2` TINYINT(1) NOT NULL,
`signup_active` TINYINT(1) NOT NULL,
`signup_created_at` TIMESTAMP NOT NULL DEFAULT CURRENT_TIMESTAMP,
PRIMARY KEY (`signup_id`)
) ENGINE=INNODB AUTO_INCREMENT=1 DEFAULT CHARSET=utf8;