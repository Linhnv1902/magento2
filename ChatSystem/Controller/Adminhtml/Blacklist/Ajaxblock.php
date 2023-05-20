<?php

namespace Linhnv\ChatSystem\Controller\Adminhtml\Blacklist;

use Linhnv\ChatSystem\Helper\Data;

class Ajaxblock extends \Linhnv\ChatSystem\Controller\Adminhtml\Blacklist
{

    /**
     * Save action
     *
     * @return \Magento\Framework\Controller\ResultInterface
     */
    public function execute()
    {
        $responseData = [];
        $responseData['error'] = __('Don\'t have data to save.');
        $responseData['status'] = false;
        $responseData['data'] = [];
        // check if data sent
        $data = $this->getRequest()->getPostValue();
        if ($data) {
            $model = $this->blacklistFactory->create();
            $email = $this->getRequest()->getParam('email');
            $ip = $this->getRequest()->getParam('ip');
            $customer_id = $this->getRequest()->getParam('customer_id');

            if ($email) {
                $model->loadByEmail($email);
            }
            if ($ip && !$model->getId()) {
                $model->loadByIp($ip);
            }
            if ($customer_id && !$model->getId()) {
                $model->loadByCustomerId($customer_id);
            }
            if (!$model->getId()) {
                // init model and set data
                // try to save it
                try {
                    $model->setData($data);
                    $model->save();

                    $responseData['status'] = true;
                    $responseData['success'] = __('You saved the blacklist.');
                    $responseData['error'] = "";
                    $responseData['created_time'] = $model->getData('created_time');
                    $responseData['data'] = $model->getData();


                } catch (\Exception $e) {
                    $responseData['error'] = __('Have problem when save the blacklist.');
                    //$responseData['error'] .= (string)$e;
                }
            } else {
                $responseData['error'] = __('The ip or email was added to blocklist.');
            }
        }
        if (isset($responseData['created_time'])) {
            $formatDate = $this->_formatDate->FormatDateFormBuilder($responseData['created_time']);
            $responseData['created_time']=$formatDate;
        }
        $this->getResponse()->representJson(
            $this->_objectManager->get('Magento\Framework\Json\Helper\Data')->jsonEncode($responseData)
        );
    }
}
