<?php
/**
 * @author	    Vladan Kuzmanovic (vladankuzmanovic@gmail.com)
 */
class Kuzman_ProductFaq_IndexController extends Mage_Core_Controller_Front_Action
{
	public function saveQuestionAction()
    {
		$params = $this->getRequest ()->getParams();
		if ($params ['isAjax'] == 1){
			$response = array ();
			$nickname= $params['nickname'];
			$question= $params['question'];
			$product_id=$params['product_id'];
			$product_name=$params['product_name'];
 			$response['nickname']=$nickname;
 			if(isset ($nickname) && isset ($question) && isset ($product_id) && isset ($product_name)) {
                try {
                    $productFaqModel = Mage::getModel('kproductfaq/productfaq');
                    $productFaqModel->setQuestion($question);
                    $productFaqModel->setNickname($nickname);
                    $productFaqModel->setOriginallyposted($product_name);

                    $productFaqModel->save();
                    $questionId = $productFaqModel->getQuestionId();
                    $productQuestionCollection = Mage::getModel('kproductfaq/productgrid');
                    $productQuestionCollection->setQuestionId($questionId);
                    $productQuestionCollection->setProductId($product_id);
                    $productQuestionCollection->save();
                    $response['status'] = 'SUCCESS';
                    $response['message'] = 'Question was successfully sent';
                } catch (Exception $e) {
                    $response ['status'] = 'ERROR';
                    $response ['message'] = $this->__('Cannot send question.');
                }
            }
			$this->getResponse()->setBody(Mage::helper('core')->jsonEncode($response));
		}
	}
}