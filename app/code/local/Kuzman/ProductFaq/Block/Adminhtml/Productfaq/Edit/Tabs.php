<?php
/**
 * @author	    Vladan Kuzmanovic (vladankuzmanovic@gmail.com)
 */
class Kuzman_ProductFaq_Block_Adminhtml_Productfaq_Edit_Tabs extends Mage_Adminhtml_Block_Widget_Tabs
{
	public function __construct()
	{
		parent::__construct();
		$this->setId('productfaq_tabs');
		$this->setDestElementId('edit_form');
		$this->setTitle(Mage::helper('kproductfaq')->__('Product FAQ'));
	}

	protected function _beforeToHtml()
	{
		$this->addTab('productfaq', array(
            'label'     => Mage::helper('kproductfaq')->__('General Information'),
            'title'     => Mage::helper('kproductfaq')->__('General Information'),
            'content'   => $this->getLayout()->createBlock('kproductfaq/adminhtml_productfaq_edit_tab_general')->toHtml(),
		));

		$this->addTab('products', array(
            'label'     => Mage::helper('kproductfaq')->__('Products Grid'),
            'title'     => Mage::helper('kproductfaq')->__('Products Grid'),
            'url'       => $this->getUrl('*/*/product', array('_current' => true)),
            'class'     => 'ajax',
		));

		return parent::_beforeToHtml();
	}
}