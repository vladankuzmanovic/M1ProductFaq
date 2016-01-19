<?php
/**
 * @author	    Vladan Kuzmanovic (vladankuzmanovic@gmail.com)
 */
class Kuzman_ProductFaq_Model_Grouplabels extends Mage_Core_Model_Abstract
{
    protected function _construct()
    {
        $this->_init("kproductfaq/grouplabels");
    }

    public function getCollectionByAttributes($storeId, $groupId)
    {
        $collection = $this->getCollection()
            ->addFieldToFilter('store_id', $storeId)
            ->addFieldToFilter('group_id', $groupId);

        return $collection;
    }
}