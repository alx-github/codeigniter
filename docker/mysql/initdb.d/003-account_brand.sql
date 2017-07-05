-- ----------------------------
-- Table structure for account_brand
-- ----------------------------
DROP TABLE IF EXISTS `account_brand`;
CREATE TABLE `account_brand` (
  `account_id` int(11) NOT NULL,
  `brand_id` int(11) NOT NULL,
  PRIMARY KEY (`account_id`,`brand_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci COMMENT='';
SET FOREIGN_KEY_CHECKS=1;
