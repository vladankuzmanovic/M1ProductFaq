<?php
/**
 * @author	    Vladan Kuzmanovic (vladankuzmanovic@gmail.com)
 */
class Kuzman_ProductFaq_Block_ProductfaqTab extends Mage_Core_Block_Template
{
    protected $_product = null;

    function getProduct()
    {
        if (!$this->_product) {
            $this->_product = Mage::registry('product');
        }
        return $this->_product;
    }

    public function getGroupCollection()
    {
        $groupsCollection= Mage::getModel('kproductfaq/faqgroups')->getCollection()
            ->setOrder('sort_order', 'ASC');
        return $groupsCollection;
    }

    public function getQuestionProductCollection($groupId, $productId)
    {
        $storeId = $this->getStoreId();
        $collectionPerStore = array();
        $faqjCollection=Mage::getResourceModel('kproductfaq/productfaq')->getJoinedCollection($groupId, $productId);
        foreach ($faqjCollection as $faqj) {
            $stores = explode(',', $faqj['stores']);
            if ((in_array($storeId, $stores) || in_array(0, $stores)) && $faqj['status']==1) {
                $collectionPerStore[]=$faqj;
            }
        }
        return $collectionPerStore;
    }

    public function getStoreId()
    {
        return Mage::app()->getStore()->getStoreId();
    }

    protected function getGroupName($storeId ,$groupId)
    {
        $model = Mage::getModel('kproductfaq/grouplabels')->getCollectionByAttributes($storeId, $groupId)->getFirstItem();
        if ($model->getId()){
            $groupName = $model->getStoreLabel();
        } else{
            $groupName = $this->getGroupName(0 , $groupId);
        }
        return $groupName;
    }

}