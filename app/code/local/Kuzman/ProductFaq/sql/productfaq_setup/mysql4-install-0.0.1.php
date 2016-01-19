<?php
/**
 * @author	    Vladan Kuzmanovic (vladankuzmanovic@gmail.com)
 */
$installer = $this;
$installer->startSetup();
$installer->run("
	DROP TABLE IF EXISTS {$this->getTable('kproductfaq/productfaq')};
	CREATE TABLE `{$this->getTable('kproductfaq/productfaq')}` (
		  `question_id` int(11) NOT NULL AUTO_INCREMENT,
		  `nickname` varchar(255),
		  `question` text DEFAULT NULL,
		  `answer` text DEFAULT NULL,
		  `originallyposted` varchar(255) DEFAULT NULL,
		  `group_id` int(11) DEFAULT NULL,
		  `status` smallint(6) DEFAULT '0',
		  `stores` varchar(255) DEFAULT NULL,
		  `sort_order` smallint(5) DEFAULT NULL,
 	 PRIMARY KEY (`question_id`)
	) ENGINE=InnoDB AUTO_INCREMENT=1 DEFAULT CHARSET=utf8;
	
	DROP TABLE IF EXISTS {$this->getTable('kproductfaq/productgrid')};
	CREATE TABLE `{$installer->getTable('kproductfaq/productgrid')}` (
		  `id` int(11) NOT NULL AUTO_INCREMENT,
		  `question_id` int(11) NOT NULL,
		  `product_id` int(11) NOT NULL,
		  `position` int(11) NOT NULL default 0,
 	 PRIMARY KEY (`id`)
	) ENGINE=InnoDB AUTO_INCREMENT=1 DEFAULT CHARSET=utf8;

	DROP TABLE IF EXISTS {$this->getTable('kproductfaq/faqgroups')};
	CREATE TABLE `{$installer->getTable('kproductfaq/faqgroups')}` (
			  `group_id` int(11) NOT NULL AUTO_INCREMENT,
			  `group_name` varchar(255),
			  `group_description` text DEFAULT NULL,
			  `sort_order` smallint(5) DEFAULT NULL,
			  PRIMARY KEY (`group_id`)
	) ENGINE=InnoDB AUTO_INCREMENT=1 DEFAULT CHARSET=utf8;

	DROP TABLE IF EXISTS {$this->getTable('kproductfaq/grouplabels')};
	CREATE TABLE `{$installer->getTable('kproductfaq/grouplabels')}` (
			  `id` int(11) NOT NULL AUTO_INCREMENT,
			  `group_id` int(11) NOT NULL,
			  `store_id` int(11) NOT NULL,
			  `store_label` varchar(255) DEFAULT NULL,
			  PRIMARY KEY (`id`)
	) ENGINE=InnoDB AUTO_INCREMENT=1 DEFAULT CHARSET=utf8;

    INSERT INTO `{$this->getTable('kproductfaq/faqgroups')}` (group_id,group_name,group_description,sort_order) VALUES (1,'Default Group','This is Default Group',0);
    INSERT INTO `{$this->getTable('kproductfaq/grouplabels')}` (group_id,store_id,store_label) VALUES (1,0,'Default Group');
");
$installer->endSetup();
	 