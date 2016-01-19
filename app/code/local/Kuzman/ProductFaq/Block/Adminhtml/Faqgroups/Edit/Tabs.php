<?php
/**
 * @author	    Vladan Kuzmanovic (vladankuzmanovic@gmail.com)
 */
class Kuzman_ProductFaq_Block_Adminhtml_Faqgroups_Edit_Tabs extends Mage_Adminhtml_Block_Widget_Tabs
{
	public function __construct()
	{
		parent::__construct();
		$this->setId('faqgroups_tabs');
		$this->setDestElementId('edit_form');
		$this->setTitle(Mage::helper('kproductfaq')->__('Product Questions Group'));
	}

	protected function _beforeToHtml()
	{
		$this->addTab('faqgroups', array(
				'label'     => Mage::helper('kproductfaq')->__('General Information'),
				'title'     => Mage::helper('kproductfaq')->__('General Information'),
				'content'   => $this->getLayout()->createBlock('kproductfaq/adminhtml_faqgroups_edit_tab_general')->toHtml(),
		));

        $this->addTab('labels', array(
            'label'     => Mage::helper('catalog')->__('Manage Label / Options'),
            'title'     => Mage::helper('catalog')->__('Manage Label / Options'),
            'content'   => $this->getLayout()->createBlock('kproductfaq/adminhtml_faqgroups_edit_tab_options')->toHtml(),
        ));
		
		return parent::_beforeToHtml();
	}
}