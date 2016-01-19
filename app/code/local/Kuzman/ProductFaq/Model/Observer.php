<?php
/**
 * @author	    Vladan Kuzmanovic (vladankuzmanovic@gmail.com)
 */
class Kuzman_ProductFaq_Model_Observer
{
	public function productFaqLayout(Varien_Event_Observer $observer)
    {
		if ($layout = Mage::getSingleton('core/layout')) {	
			if(!Mage::helper('kproductfaq')->isEnabled()){
				$productInfo = $layout->getBlock('product.info');
				if($productInfo){
					$layout->getBlock('product.info')->unsetChild('product.faq.tab');
				}
			}
		}
	}
}