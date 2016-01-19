<?php
/**
 * @author	    Vladan Kuzmanovic (vladankuzmanovic@gmail.com)
 */
class Kuzman_ProductFaq_Block_Adminhtml_Faqgroups_Grid extends Mage_Adminhtml_Block_Widget_Grid
{
	public function __construct()
	{
        parent::__construct();
		$this->setId("faqgroupsGrid");
		$this->setDefaultSort("id");
		$this->setDefaultDir("ASC");
		$this->setSaveParametersInSession(true);
	}

	protected function _prepareCollection()
	{
		$collection = Mage::getModel("kproductfaq/faqgroups")->getCollection();
		$this->setCollection($collection);
		return parent::_prepareCollection();
	}
	
	protected function _prepareColumns()
	{
		$this->addColumn("group_id", array(
            "header" => Mage::helper("kproductfaq")->__("Group ID"),
            "type" => "number",
            "index" => "group_id",
		));

		$this->addColumn("group_name", array(
            "header" => Mage::helper("kproductfaq")->__("Group Name"),
            "type" => "text",
            "index" => "group_name",
		));
		
		$this->addColumn("group_description", array(
            "header" => Mage::helper("kproductfaq")->__("Group Description"),
            "type" => "text",
            "index" => "group_description",
		));

        $this->addColumn("sort_order", array(
            "header" => Mage::helper("kproductfaq")->__("Position"),
            "type" => "text",
            "index" => "sort_order",
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
		$this->getMassactionBlock()->setFormFieldName('faqgroups_ids');
		$this->getMassactionBlock()->setUseSelectAll(true);
		$this->getMassactionBlock()->addItem('remove_groups', array (
				'label'=> Mage::helper('kproductfaq')->__('Remove Selected FAQ Groups'),
				'url'  => $this->getUrl('*/*/massRemove'),
				'confirm' => Mage::helper('kproductfaq')->__('Are you sure?')
		));

		return $this;
	}
}