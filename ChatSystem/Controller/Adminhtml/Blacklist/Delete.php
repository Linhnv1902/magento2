<?php

namespace Linhnv\ChatSystem\Controller\Adminhtml\Blacklist;

class Delete extends \Linhnv\ChatSystem\Controller\Adminhtml\Blacklist
{
    public function execute()
    {
        /** @var \Magento\Backend\Model\View\Result\Redirect $resultRedirect */
        $resultRedirect = $this->resultRedirectFactory->create();
        // check if we know what should be deleted
        $id = $this->getRequest()->getParam('blacklist_id');
        if ($id) {
            try {
                // init model and delete
                $model = $this->blacklistFactory->create();
                $model->load($id);
                $model->delete();
                // display success blacklist
                $this->messageManager->addSuccess(__('You deleted the blacklist.'));
                // go to grid
                return $resultRedirect->setPath('*/*/');
            } catch (\Exception $e) {
                // display error blacklist
                $this->messageManager->addError($e->getMessage());
                // go back to edit form
                return $resultRedirect->setPath('*/*/', ['blacklist_id' => $id]);
            }
        }
        // display error blacklist
        $this->messageManager->addError(__('We can\'t find a blacklist to delete.'));
        // go to grid
        return $resultRedirect->setPath('*/*/');
    }
     /**
      * {@inheritdoc}
      */
    protected function _isAllowed()
    {
        return $this->_authorization->isAllowed('Linhnv_ChatSystem::blacklist_delete');
    }
}
