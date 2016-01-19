<?php
/**
 * @author	    Vladan Kuzmanovic (vladankuzmanovic@gmail.com)
 */
class Kuzman_ProductFaq_Block_Adminhtml_Productfaq_Edit extends Mage_Adminhtml_Block_Widget_Form_Container
{
    public function __construct()
	{
		parent::__construct();
        $this->_objectId = 'productfaq_id';
		$this->_blockGroup = 'kproductfaq';
		$this->_controller = 'adminhtml_productfaq';
		$this->_updateButton('save', 'label', Mage::helper('kproductfaq')->__('Save'));
		$this->_updateButton('delete', 'label', Mage::helper('kproductfaq')->__('Delete'));
		$this->_addButton('saveandcontinue', array(
				'label'     => Mage::helper('adminhtml')->__('Save And Continue Edit'),
				'onclick'   => 'saveAndContinueEdit()',
				'class'     => 'save',
		), -100);
		
		$this->_formScripts[] = "
		                function saveAndContinueEdit(){
								editForm.submit($('edit_form').action+'back/edit/');
							}
						";
	}
	
	public function getHeaderText()
	{
		return Mage::helper('kproductfaq')->__('Question Information');
	}
}