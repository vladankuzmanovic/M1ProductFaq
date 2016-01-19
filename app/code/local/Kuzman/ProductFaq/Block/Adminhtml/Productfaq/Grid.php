<?php
/**
 * @author	    Vladan Kuzmanovic (vladankuzmanovic@gmail.com)
 */
class Kuzman_ProductFaq_Block_Adminhtml_Productfaq_Grid extends Mage_Adminhtml_Block_Widget_Grid
{
    public function __construct()
	{
		parent::__construct();
		$this->setId("productfaqGrid");
		$this->setDefaultSort("id");
		$this->setDefaultDir("ASC");
		$this->setSaveParametersInSession(true);
	}
	
	protected function _prepareCollection()
	{
		$collection = Mage::getModel("kproductfaq/productfaq")->getCollection();
		$this->setCollection($collection);
		return parent::_prepareCollection();
	}
	
	protected function _prepareColumns()
	{
        $this->addColumn("question_id", array(
            "header" => Mage::helper("kproductfaq")->__("Question ID"),
            "type" => "number",
            "index" => "question_id",
		));

        $this->addColumn("nickname", array(
            "header" => Mage::helper("kproductfaq")->__("Nickname"),
            "type" => "text",
            "index" => "nickname",
		));
		
        $this->addColumn("question", array(
            "header" => Mage::helper("kproductfaq")->__("Question"),
            "type" => "text",
            "index" => "question",
		));

        $this->addColumn("answer", array(
            "header" => Mage::helper("kproductfaq")->__("Answer"),
            "type" => "text",
            "index" => "answer",
		));

        $this->addColumn('group_id', array(
            'header'    => Mage::helper('kproductfaq')->__('Question Group'),
            'width'     => '120px',
            'index'     => 'group_id',
            'renderer'  => 'kproductfaq/adminhtml_productfaq_renderer_group',
            'type'  => 'options',
            'options' => Mage::getSingleton('kproductfaq/faqgroups')->getOptionArray(),
		));

        $this->addColumn("sort_order", array(
            "header" => Mage::helper("kproductfaq")->__("Position"),
            "type" => "text",
            "index" => "sort_order",
        ));

        $this->addColumn("status", array(
            "header" => Mage::helper("kproductfaq")->__("Status"),
            "type" => "options",
            "options"=> array('0' => 'Pending', '1' => 'Approved'),
            "index" => "status",
		));

        $this->addColumn('action',
            array(
                'header'    =>  Mage::helper('kproductfaq')->__('Action'),
                'width'     => '40',
                'type'      => 'action',
                'getter'    => 'getId',
                'actions'   => array(
                    array(
                        'caption'   => Mage::helper('kproductfaq')->__('Edit'),
                        'url'       => array('base'=> '*/*/edit'),
                        'field'     => 'id'
                    )
                ),
                'filter'    => false,
                'sortable'  => false,
                'index'     => 'stores',
                'is_system' => true,
            ));

		return parent::_prepareColumns();
	}
	
	public function getRowUrl($row)
	{
		return $this->getUrl("*/*/edit", array("id" => $row->getId()));
	}
	
	protected function _prepareMassaction()
	{
		$this->setMassactionIdField('id');
		$this->getMassactionBlock()->setFormFieldName('productfaq_ids');
		$this->getMassactionBlock()->setUseSelectAll(true);
		$this->getMassactionBlock()->addItem('remove_questions', array(
				'label'=> Mage::helper('kproductfaq')->__('Remove Selected Questions'),
				'url'  => $this->getUrl('*/*/massRemove'),
				'confirm' => Mage::helper('kproductfaq')->__('Are you sure?')
		));
		$this->getMassactionBlock()->addItem('status', array(
				'label' => $this->__('Update Question Status'),
				'url' => $this->getUrl('*/*/updateMass'),
				'additional' => array(
                    'visibility' => array(
                        'name' => 'question_status',
                        'type' => 'select',
                        'class' => 'required-entry',
                        'label' => $this->__('Status'),
                        'values' => array(
                            array(
                                'label' => 'Pending',
                                'value' => 0
                            ),
                            array(
                                'label' => 'Approved',
                                'value' => 1
                            )
                        )
                    )
				)
		));

		return $this;
	}
}