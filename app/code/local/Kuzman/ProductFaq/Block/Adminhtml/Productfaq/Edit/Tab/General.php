<?php
/**
 * @author	    Vladan Kuzmanovic (vladankuzmanovic@gmail.com)
 */
class Kuzman_ProductFaq_Block_Adminhtml_Productfaq_Edit_Tab_General extends Mage_Adminhtml_Block_Widget_Form
{
    protected function _prepareForm()
    {
        $model = Mage::registry("productfaq_data");
        $form = new Varien_Data_Form();
        $this->setForm($form);
        $fieldset = $form->addFieldset('productfaq_form', array('legend'=>Mage::helper('kproductfaq')->__('Question information')));
        
        $fieldset->addField('nickname', 'text', array(
            'label'     => Mage::helper('kproductfaq')->__('Nickname'),
            'name'      => 'nickname',
        ));
        
        $fieldset->addField('question', 'textarea', array(
            'label'     => Mage::helper('kproductfaq')->__('Question'),
            'class'     => 'required-entry',
            'required'  => true,
            'name'      => 'question',
        ));
        $fieldset->addField('answer', 'textarea', array(
            'label'     => Mage::helper('kproductfaq')->__('Answer'),
            'class'     => 'required-entry',
            'required'  => true,
            'name'      => 'answer',
        ));
        
        $fieldset->addField('status', 'select', array(
            'label'     => Mage::helper('kproductfaq')->__('Status'),
            'name'      => 'status',
            'values'    => array(
                array(
                    'value'     => 1,
                    'label'     => Mage::helper('kproductfaq')->__('Approved'),
                ),
                array(
                    'value'     => 0,
                    'label'     => Mage::helper('kproductfaq')->__('Pending'),
                ),
            ),
        ));

        $fieldset->addField('sort_order', 'text', array(
            'label'     => Mage::helper('kproductfaq')->__('Sort Order'),
            'class'     => 'validate-digits',
            'required'  => false,
            'name'      => 'sort_order',
            'maxlength'	=> 3,
        ));

        /**
         * Check is single store mode
         */
        if (!Mage::app()->isSingleStoreMode()) {
            $field =$fieldset->addField('stores', 'multiselect', array(
                'name'      => 'stores[]',
                'label'     => Mage::helper('kproductfaq')->__('Store View'),
                'title'     => Mage::helper('kproductfaq')->__('Store View'),
                'required'  => true,
                'values'    => Mage::getSingleton('adminhtml/system_store')->getStoreValuesForForm(false, true),
            ));
            $renderer = $this->getLayout()->createBlock('adminhtml/store_switcher_form_renderer_fieldset_element');
            $field->setRenderer($renderer);
        }
        else {
            $fieldset->addField('stores', 'hidden', array(
                'name'      => 'stores[]',
                'value'     => Mage::app()->getStore(true)->getId()
            ));
            $model->setStoreId(Mage::app()->getStore(true)->getId());
        }

        $faqGroupsCollection = Mage::getModel('kproductfaq/faqgroups')->getCollection();

        foreach($faqGroupsCollection as $group){
        	$values[] = array('value' => $group->getGroupId(), 'label' => $group->getGroupName());
        }
        	
        $fieldset->addField('group_id', 'select', array(
            'label'     => Mage::helper('kproductfaq')->__('Question Group'),
            'class'     => 'required-entry',
            'required'  => true,
            'name'      => 'group_id',
            'values'		=> $values,
        ));
        
        $fieldset->addField('originallyposted', 'label', array(
            'label'     => Mage::helper('kproductfaq')->__('This question was originally posted on product'),
            'readonly' => true,
            'name'      => 'originallyposted',
        ));

        if (Mage::getSingleton("adminhtml/session")->getProductfaqData()) {
            $data=Mage::getSingleton("adminhtml/session")->getProductfaqData();
            $form->setValues($data);
            Mage::getSingleton("adminhtml/session")->setProductfaqData(null);
        } elseif($model) {
        	$form->setValues($model->getData());
        }
          
        return parent::_prepareForm();
    }
}