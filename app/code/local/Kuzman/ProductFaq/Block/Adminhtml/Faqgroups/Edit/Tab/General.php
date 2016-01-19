<?php
/**
 * @author	    Vladan Kuzmanovic (vladankuzmanovic@gmail.com)
 */
class Kuzman_ProductFaq_Block_Adminhtml_Faqgroups_Edit_Tab_General extends Mage_Adminhtml_Block_Widget_Form
{
    protected function _prepareForm()
    {
        $model = Mage::registry("faqgroups_data");
        $form = new Varien_Data_Form();
        $this->setForm($form);
        $fieldset = $form->addFieldset('faqgroups_form', array('legend'=>Mage::helper('kproductfaq')->__('Group Information')));
        
        $fieldset->addField('group_name', 'label', array(
            'label'     => Mage::helper('kproductfaq')->__('Group Name'),
            'readonly' => true,
            'name'      => 'group_name',
        ));
        
        $fieldset->addField('group_description', 'textarea', array(
            'label'     => Mage::helper('kproductfaq')->__('Group Description'),
            'name'      => 'group_description',
        ));

        $fieldset->addField('sort_order', 'text', array(
            'label'     => Mage::helper('kproductfaq')->__('Sort Order'),
            'class'     => 'validate-digits',
            'required'  => false,
            'name'      => 'sort_order',
            'maxlength'	=> 3,
        ));
        
        if (Mage::getSingleton("adminhtml/session")->getFaqgroupsData()) {
        	$form->setValues(Mage::getSingleton("adminhtml/session")->getFaqgroupsData());
        	Mage::getSingleton("adminhtml/session")->setFaqgroupsData(null);

        } elseif($model) {
        	$form->setValues($model->getData());
        }

        return parent::_prepareForm();
    }
}
