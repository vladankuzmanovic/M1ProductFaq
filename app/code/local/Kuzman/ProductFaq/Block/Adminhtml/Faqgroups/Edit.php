<?php
/**
 * @author	    Vladan Kuzmanovic (vladankuzmanovic@gmail.com)
 */
class Kuzman_ProductFaq_Block_Adminhtml_Faqgroups_Edit extends Mage_Adminhtml_Block_Widget_Form_Container{
	
	public function __construct()
	{
		parent::__construct();
	
		$this->_objectId = 'faqgroups_id';
		$this->_blockGroup = 'kproductfaq';
		$this->_controller = 'adminhtml_faqgroups';
		$this->_updateButton('save', 'label', Mage::helper('kproductfaq')->__('Save Question Group'));
		$this->_updateButton('delete', 'label', Mage::helper('kproductfaq')->__('Delete Question Group'));
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
		return Mage::helper('kproductfaq')->__('Group Information');
	}
}