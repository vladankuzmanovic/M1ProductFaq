<?php
/**
 * @author	    Vladan Kuzmanovic (vladankuzmanovic@gmail.com)
 */
class Kuzman_ProductFaq_Model_System_Config_Source_Display{
	
	public function toOptionArray()
	{
		return Mage::helper('kproductfaq')->getWhereToShowOptions();
	}
}