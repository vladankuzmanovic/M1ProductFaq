<?php
/**
 * @author	    Vladan Kuzmanovic (vladankuzmanovic@gmail.com)
 */
class Kuzman_ProductFaq_Block_Adminhtml_Productfaq_Edit_Tab_Products extends Mage_Adminhtml_Block_Widget_Grid{
	
	public function __construct()
	{
		parent::__construct();
		$this->setId('productGrid');
		$this->setUseAjax(true); 
		$this->setDefaultSort('entity_id');
		$this->setDefaultFilter(array('in_products'=>1));
		$this->setSaveParametersInSession(false);
	}

	protected function _prepareCollection()
	{
		$collection = Mage::getResourceModel('catalog/product_collection');
		$collection->joinAttribute(
				'name',
				'catalog_product/name',
				'entity_id',
				null,
				'inner'
	    );

		$this->setCollection($collection);
		return parent::_prepareCollection();
	}

	protected function _addColumnFilterToCollection($column)
	{
		if ($column->getId() == 'in_products') {
			$ids = $this->_getSelectedProducts();
			if (empty($ids)) {
				$ids = 0;
			}
			if ($column->getFilter()->getValue()) {
				$this->getCollection()->addFieldToFilter('entity_id', array('in'=>$ids));
			}else {
				if($ids) {
					$this->getCollection()->addFieldToFilter('entity_id', array('nin'=>$ids));
				}
			}
		} else {
			parent::_addColumnFilterToCollection($column);
		}
		return $this;
	}

	protected function _prepareColumns()
	{
        $this->addColumn('in_products', array(
            'header_css_class'  => 'a-center',
            'type'              => 'checkbox',
            'name'              => 'product',
            'values'            => $this->_getSelectedProducts(),
            'align'             => 'center',
            'index'             => 'entity_id'
        ));

        $this->addColumn('entity_id', array(
            'header'    => Mage::helper('catalog')->__('ID'),
            'sortable'  => true,
            'width'     => 60,
            'index'     => 'entity_id'
        ));

        $this->addColumn('name', array(
            'header'    => Mage::helper('catalog')->__('Name'),
            'index'     => 'name'
        ));

        $this->addColumn('type', array(
            'header'    => Mage::helper('catalog')->__('Type'),
            'width'     => 100,
            'index'     => 'type_id',
            'type'      => 'options',
            'options'   => Mage::getSingleton('catalog/product_type')->getOptionArray(),
        ));

        $sets = Mage::getResourceModel('eav/entity_attribute_set_collection')
                ->setEntityTypeFilter(Mage::getModel('catalog/product')->getResource()->getTypeId())
                ->load()
                ->toOptionHash();

        $this->addColumn('set_name', array(
            'header'    => Mage::helper('catalog')->__('Attrib. Set Name'),
            'width'     => 130,
            'index'     => 'attribute_set_id',
            'type'      => 'options',
            'options'   => $sets,
        ));

        $this->addColumn('sku', array(
            'header'    => Mage::helper('catalog')->__('SKU'),
            'width'     => 80,
            'index'     => 'sku'
        ));

        $this->addColumn('position', array(
            'header'            => Mage::helper('catalog')->__('Position'),
            'name'              => 'position',
            'type'              => 'number',
            'validate_class'    => 'validate-number',
            'index'             => 'position',
            'width'             => 60,
            'editable'          => true,
            'edit_only'         => true
        ));

        return parent::_prepareColumns();
	}
	
	protected function _getSelectedProducts()   
	{
		$products = array_keys($this->getSelectedProducts());
		return $products;
	}

	public function getGridUrl()
	{
		return $this->_getData('grid_url') ? $this->_getData('grid_url') : $this->getUrl('*/*/productgrid', array('_current'=>true));
	}

	public function getSelectedProducts()
	{	
		$tm_id = $this->getRequest()->getParam('id');
		if(!isset($tm_id)) {
			$tm_id = 0;
		}
		$collection = Mage::getModel('kproductfaq/productgrid')->getCollection();
		$collection->addFieldToFilter('question_id',$tm_id);
		$prodIds = array();
		foreach($collection as $obj) {
			$prodIds[$obj->getProductId()] = array('position'=>$obj->getPosition());
		}
		return $prodIds;
	}
}