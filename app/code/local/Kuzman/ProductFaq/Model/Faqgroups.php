<?php
/**
 * @author	    Vladan Kuzmanovic (vladankuzmanovic@gmail.com)
 */
class Kuzman_ProductFaq_Model_Faqgroups extends Mage_Core_Model_Abstract
{
	protected function _construct()
    {
		$this->_init("kproductfaq/faqgroups");
	}
	
	public function getOptionArray()
	{
		$options = array();
		$questionGroups=Mage::getModel('kproductfaq/faqgroups')->getCollection();
		foreach($questionGroups as $group) {
			$groupId=$group->getGroupId();
			$groupName=$group->getGroupName();
			$options[$groupId] = Mage::helper('kproductfaq')->__($groupName);
		}
		return $options;
	}
}