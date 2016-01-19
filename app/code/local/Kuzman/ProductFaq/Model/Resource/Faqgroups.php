<?php
/**
 * @author	    Vladan Kuzmanovic (vladankuzmanovic@gmail.com)
 */
class Kuzman_ProductFaq_Model_Resource_Faqgroups extends Mage_Core_Model_Resource_Db_Abstract
{
	protected function _construct()
    {
		$this->_init("kproductfaq/faqgroups", "group_id");
	}
}