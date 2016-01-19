<?php
/**
 * @author	    Vladan Kuzmanovic (vladankuzmanovic@gmail.com)
 */
class Kuzman_ProductFaq_Helper_Data extends Mage_Core_Helper_Abstract
{
	const XML_PATH_ENABLED = 'kproductfaq/general/enabled';
	
	public function isEnabled()
    {
        $storeId = Mage::app()->getStore()->getStoreId();
		return (bool)Mage::getStoreConfig(self::XML_PATH_ENABLED, $storeId);
	}
}