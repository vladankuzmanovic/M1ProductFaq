<?php
/**
 * @author	    Vladan Kuzmanovic (vladankuzmanovic@gmail.com)
 */
class Kuzman_Productfaq_Block_Adminhtml_Productfaq_Renderer_Group extends Mage_Adminhtml_Block_Widget_Grid_Column_Renderer_Abstract
{
    public function render(Varien_Object $row)
	{
		$questionGroup = Mage::getModel('kproductfaq/faqgroups')->load($row->getData('group_id'));
        return $questionGroup->getGroupName();
    }
}