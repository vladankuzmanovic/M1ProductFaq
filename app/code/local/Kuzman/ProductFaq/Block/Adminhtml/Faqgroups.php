<?php
/**
 * @author	    Vladan Kuzmanovic (vladankuzmanovic@gmail.com)
 */
class Kuzman_ProductFaq_Block_Adminhtml_Faqgroups extends Mage_Adminhtml_Block_Widget_Grid_Container
{
	public function __construct()
	{
		$this->_controller = 'adminhtml_faqgroups';
		$this->_blockGroup = 'kproductfaq';
		$this->_headerText = Mage::helper('kproductfaq')->__('Manage Question Groups');
		$this->_addButtonLabel = Mage::helper('kproductfaq')->__('Add Group');
		parent::__construct();
	}
}