<?php
/**
 * @author	    Vladan Kuzmanovic (vladankuzmanovic@gmail.com)
 */
class Kuzman_ProductFaq_Model_Resource_Productfaq extends Mage_Core_Model_Resource_Db_Abstract
{
	protected function _construct()
    {
		$this->_init("kproductfaq/productfaq", "question_id");
	}
	
	public function getJoinedCollection($groupId, $productId)
    {
		$resource = Mage::getSingleton('core/resource');
		$readConnection = $resource->getConnection('core_read');
		$query='SELECT * FROM kuzman_product_faq AS q
				INNER JOIN kuzman_product_faq_product_grid AS pg ON
				q.question_id = pg.question_id
				WHERE q.group_id ='.$groupId.' AND product_id ='.$productId.'
				ORDER BY sort_order';
		$joinedCollection = $readConnection->fetchAll($query);
		return $joinedCollection;
	}
}