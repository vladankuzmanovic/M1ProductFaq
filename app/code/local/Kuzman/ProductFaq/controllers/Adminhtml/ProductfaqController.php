<?php
/**
 * @author	    Vladan Kuzmanovic (vladankuzmanovic@gmail.com)
 */
class Kuzman_ProductFaq_Adminhtml_ProductfaqController extends Mage_Adminhtml_Controller_action
{
	public function productAction()
    {
		$this->loadLayout();
		$this->getLayout()->getBlock('product.grid')
		    ->setProducts($this->getRequest()->getPost('products', null));
		$this->renderLayout();
	}
	
	public function productgridAction()
    {
		$this->loadLayout();
		$this->getLayout()->getBlock('product.grid')
		    ->setProducts($this->getRequest()->getPost('products', null));
		$this->renderLayout();
	}
	
	protected function _initAction()
	{
		$this->loadLayout()->_setActiveMenu("catalog/catalog");
		return $this;
	}
	
	public function indexAction()
	{
		$this->_title($this->__("Product Questions"));
		$this->_initAction();
		$this->renderLayout();
	}
	
	public function editAction()
	{
		$this->_title($this->__("Product Questions"));
		$this->_title($this->__("Edit Question"));
		$id = $this->getRequest()->getParam("id");
		$model = Mage::getModel("kproductfaq/productfaq")->load($id);
		if ($model->getQuestionId()) {
			Mage::register("productfaq_data", $model);
			$this->loadLayout();
			$this->_setActiveMenu("catalog/catalog");
			$this->getLayout()->getBlock("head")->setCanLoadExtJs(true);
			$this->_addContent($this->getLayout()->createBlock("kproductfaq/adminhtml_productfaq_edit"))->_addLeft($this->getLayout()->createBlock("kproductfaq/adminhtml_productfaq_edit_tabs"));
			$this->renderLayout();
		} else {
			Mage::getSingleton("adminhtml/session")->addError(Mage::helper("kproductfaq")->__("Question does not exist."));
			$this->_redirect("*/*/");
		}
	}
	
	public function newAction()
	{
		$this->_title($this->__("Product Question"));
		$this->_title($this->__("Add New Question"));
	
		$id   = $this->getRequest()->getParam("id");
		$model  = Mage::getModel("kproductfaq/productfaq")->load($id);
	
		$data = Mage::getSingleton("adminhtml/session")->getProductfaqData(true);
		
		if (!empty($data)) {
			$model->setData($data);
		}

		Mage::register("productfaq_data", $model);
	
		$this->loadLayout();
		$this->_setActiveMenu("catalog/catalog");
	
		$this->getLayout()->getBlock("head")->setCanLoadExtJs(true);

		$this->_addContent($this->getLayout()->createBlock("kproductfaq/adminhtml_productfaq_edit"))->_addLeft($this->getLayout()->createBlock("kproductfaq/adminhtml_productfaq_edit_tabs"));
	
		$this->renderLayout();
	}
	
	public function saveAction()
	{
		$post_data=$this->getRequest()->getPost();
		if ($post_data) {
            if(is_array($post_data['stores'])) {
                $post_data['stores']=implode(',',$post_data['stores']);
            }
            $model = Mage::getModel("kproductfaq/productfaq")
                ->setData($post_data)
                ->setId($this->getRequest()->getParam("id"));
            try {
                $model->save();
                $question_id = $model->getQuestionId();
                if(isset($post_data['links'])){
                    $products = Mage::helper('adminhtml/js')->decodeGridSerializedInput($post_data['links']['products']); //Save the array to your database
                    $collection = Mage::getModel('kproductfaq/productgrid')->getCollection();
                    $collection->addFieldToFilter('question_id',$question_id);
                    foreach($collection as $obj) {
                        $obj->delete();
                    }
                    foreach($products as $key => $value) {
                        $model2 = Mage::getModel('kproductfaq/productgrid');
                        $model2->setQuestionId($question_id);
                        $model2->setProductId($key);
                        $model2->setPosition($value['position']);
                        $model2->save();
                    }
                }
                Mage::getSingleton("adminhtml/session")->addSuccess(Mage::helper("adminhtml")->__("Question was successfully saved"));
                Mage::getSingleton("adminhtml/session")->setProductfaqData(false);

                if ($this->getRequest()->getParam("back")) {
                    $this->_redirect("*/*/edit", array("id" => $model->getQuestionId()));
                    return;
                }
                $this->_redirect("*/*/");
                return;
            } catch (Exception $e) {
                Mage::getSingleton("adminhtml/session")->addError($e->getMessage());
                Mage::getSingleton("adminhtml/session")->setProductfaqData($this->getRequest()->getPost());
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
				$model = Mage::getModel("kproductfaq/productfaq");
				$model->setId($this->getRequest()->getParam("id"))->delete();
				$productQuestionModel=Mage::getModel('kproductfaq/productgrid');
				$pQCollection=$productQuestionModel->getCollection();
				 $questionId=$this->getRequest()->getParam("id"); 
				foreach($pQCollection as $pQ) {
					if($pQ->getQuestionId() == $questionId ){
						$productQuestionModel->load($pQ->getId())->delete();
					}
				}
				Mage::getSingleton("adminhtml/session")->addSuccess(Mage::helper("adminhtml")->__("Question was successfully deleted"));
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
			$ids = $this->getRequest()->getPost('productfaq_ids', array());
			foreach ($ids as $id) {
				$model = Mage::getModel("kproductfaq/productfaq");
				$model->setId($id)->delete();
				$productQuestionModel=Mage::getModel('kproductfaq/productgrid');
				$pQCollection=$productQuestionModel->getCollection();
				foreach($pQCollection as $pQ) {
					if($pQ->getQuestionId() == $id ) {
						$productQuestionModel->load($pQ->getId())->delete();
					}
				}
			}
			Mage::getSingleton("adminhtml/session")->addSuccess(Mage::helper("adminhtml")->__("Question(s) was successfully removed"));
		} catch (Exception $e) {
			Mage::getSingleton("adminhtml/session")->addError($e->getMessage());
		}
		$this->_redirect('*/*/');
	}
	
	public function updateMassAction()
	{
		try {
			$ids = $this->getRequest()->getPost('productfaq_ids', array());
			$question_status = (int) $this->getRequest()->getPost('question_status');
			$model = Mage::getModel("kproductfaq/productfaq");
			foreach ($ids as $id) {
				$model->load($id);
				$model->setStatus($question_status);
				$model->save();
			}
			Mage::getSingleton("adminhtml/session")->addSuccess(Mage::helper("adminhtml")->__("Status was successfully changed"));
		} catch (Exception $e) {
			Mage::getSingleton("adminhtml/session")->addError($e->getMessage());
		}
		$this->_redirect('*/*/');
	}
}