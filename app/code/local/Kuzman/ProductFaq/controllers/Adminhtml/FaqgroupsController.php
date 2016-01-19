<?php
/**
 * @author	    Vladan Kuzmanovic (vladankuzmanovic@gmail.com)
 */
class Kuzman_ProductFaq_Adminhtml_FaqgroupsController extends Mage_Adminhtml_Controller_action
{
	protected function _initAction()
	{
		$this->loadLayout()->_setActiveMenu("catalog/catalog");
		return $this;
	}
	
	public function indexAction()
	{
		$this->_title($this->__("Question Groups"));
		$this->_initAction();
		$this->renderLayout();
	}
	
	public function editAction()
	{
		$this->_title($this->__("Product Questions Groups"));
		$this->_title($this->__("Edit Question Group"));
		$id = $this->getRequest()->getParam("id");
		$model = Mage::getModel("kproductfaq/faqgroups")->load($id);
		if ($model->getGroupId()) {
            $model->setStoreLabels($this->_getStoreLabels($model->getGroupId()));
			Mage::register("faqgroups_data", $model);
			$this->loadLayout();
			$this->_setActiveMenu("catalog/catalog");
			$this->getLayout()->getBlock("head")->setCanLoadExtJs(true);
			$this->_addContent($this->getLayout()->createBlock("kproductfaq/adminhtml_faqgroups_edit"))->_addLeft($this->getLayout()->createBlock("kproductfaq/adminhtml_faqgroups_edit_tabs"));
			$this->renderLayout();
		} else {
			Mage::getSingleton("adminhtml/session")->addError(Mage::helper("kproductfaq")->__("Question Group does not exist."));
			$this->_redirect("*/*/");
		}
	}
	
	public function newAction()
	{
		$this->_title($this->__("Questions Groups"));
		$this->_title($this->__("Add New Question Group"));
	
		$groupId   = $this->getRequest()->getParam("id");
		$model  = Mage::getModel("kproductfaq/faqgroups")->load($groupId);
	
		$data = Mage::getSingleton("adminhtml/session")->getFaqgroupsData(true);
	
		if (!empty($data)) {
			$model->setData($data);
		}

		Mage::register("faqgroups_data", $model);
	
		$this->loadLayout();
		$this->_setActiveMenu("catalog/catalog");
	
		$this->getLayout()->getBlock("head")->setCanLoadExtJs(true);
	
		$this->_addContent($this->getLayout()->createBlock("kproductfaq/adminhtml_faqgroups_edit"))->_addLeft($this->getLayout()->createBlock("kproductfaq/adminhtml_faqgroups_edit_tabs"));
	
		$this->renderLayout();
	}
	
	public function saveAction()
	{
		$postData=$this->getRequest()->getPost();
        if ($postData) {
            try {
                $model = Mage::getModel("kproductfaq/faqgroups")
                    ->addData($postData)
                    ->setId($this->getRequest()->getParam("id"))
                    ->setGroupName($postData['frontend_label'][0])
                    ->save();

                foreach($postData['frontend_label'] as $key => $value){
                    $groupLabels = Mage::getModel("kproductfaq/grouplabels");
                    if($this->ifExist($this->getRequest()->getParam("id"),$key)) {
                        $groupLabels->load($this->ifExist($this->getRequest()->getParam("id"),$key));
                    }
                    if(!empty($value)) {
                        $groupLabels->setGroupId($model->getGroupId());
                        $groupLabels->setStoreId($key);
                        $groupLabels->setStoreLabel($value);
                        $groupLabels->save();
                    }}

                Mage::getSingleton("adminhtml/session")->addSuccess(Mage::helper("adminhtml")->__("Question Group was successfully saved"));
                Mage::getSingleton("adminhtml/session")->setFaqgroupsData(false);

                if ($this->getRequest()->getParam("back")) {
                    $this->_redirect("*/*/edit", array("id" => $model->getId()));
                    return;
                }
                $this->_redirect("*/*/");
                return;
            } catch (Exception $e) {
                Mage::getSingleton("adminhtml/session")->addError($e->getMessage());
                Mage::getSingleton("adminhtml/session")->setFaqgroupsData($this->getRequest()->getPost());
                $this->_redirect("*/*/edit", array("id" => $this->getRequest()->getParam("id")));
            return;
            }
        }
        $this->_redirect("*/*/");
	}
	
	public function deleteAction()
	{
		if( $this->getRequest()->getParam("id") > 0 ) {
            try {
                $model = Mage::getModel("kproductfaq/faqgroups");
                $model->setId($this->getRequest()->getParam("id"))->delete();
                $groupLabelsCollection = Mage::getModel("kproductfaq/grouplabels")->getCollection()->addFieldToFilter('group_id',$this->getRequest()->getParam("id"));
                foreach($groupLabelsCollection as $label){
                    $label->delete();
                }
                Mage::getSingleton("adminhtml/session")->addSuccess(Mage::helper("adminhtml")->__("Question Group was successfully deleted"));
                $this->_redirect("*/*/");
            } catch (Exception $e) {
                Mage::getSingleton("adminhtml/session")->addError($e->getMessage());
                $this->_redirect("*/*/edit", array("id" => $this->getRequest()->getParam("id")));
            }
        }
		$this->_redirect("*/*/");
	}

	public function massRemoveAction()
	{
		try {
            $ids = $this->getRequest()->getPost('faqgroups_ids', array());
            foreach ($ids as $id) {
                $model = Mage::getModel("kproductfaq/faqgroups");
                $model->setId($id)->delete();
                $groupLabelsCollection = Mage::getModel("kproductfaq/grouplabels")->getCollection()->addFieldToFilter('group_id',$id);
                foreach($groupLabelsCollection as $label){
                    $label->delete();
                }
            }
            Mage::getSingleton("adminhtml/session")->addSuccess(Mage::helper("adminhtml")->__("Question Group(s) was successfully removed"));
        } catch (Exception $e) {
            Mage::getSingleton("adminhtml/session")->addError($e->getMessage());
        }
		$this->_redirect('*/*/');
	}

    protected function _getStoreLabels($groupId)
    {
        $labelCollection=Mage::getModel("kproductfaq/grouplabels")->getCollection()->addFieldToFilter('group_id', $groupId);
        $storeLabelArray = array();
        foreach($labelCollection as $label){
            $storeLabelArray[$label->getStoreId()] = $label->getStoreLabel();
        }
        return $storeLabelArray;
    }

    protected function ifExist($groupId, $storeId)
    {
        $labelsCollection = Mage::getModel("kproductfaq/grouplabels")->getCollectionByAttributes($storeId, $groupId);
        return ($labelsCollection->getSize() !=0) ? $labelsCollection->getFirstItem()->getId() : false;
    }
}