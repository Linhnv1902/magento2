<?php
namespace Linhnv\ChatSystem\Controller\Adminhtml\Chat;

class AddBlacklist extends \Magento\Backend\App\Action
{
    protected $chatFactory;
    protected $blacklistFactory;
    /**
     * @param \Magento\Backend\App\Action\Context $context
     * @param \Linhnv\ChatSystem\Model\ChatFactory $chatFactory
     * @param \Linhnv\ChatSystem\Model\BlacklistFactory $blacklistFactory
     */
    public function __construct(
        \Magento\Backend\App\Action\Context $context,
        \Linhnv\ChatSystem\Model\ChatFactory $chatFactory,
        \Linhnv\ChatSystem\Model\BlacklistFactory $blacklistFactory
    )
    {
        $this->chatFactory = $chatFactory;
        $this->blacklistFactory = $blacklistFactory;
        parent::__construct($context);
    }
    /**
     * Delete action
     *
     * @return \Magento\Framework\Controller\ResultInterface
     */
    public function execute()
    {
        /** @var \Magento\Backend\Model\View\Result\Redirect $resultRedirect */
        $resultRedirect = $this->resultRedirectFactory->create();
        // check if we know what should be deleted
        $id = $this->getRequest()->getParam('chat_id');
        if ($id) {
            try {
                // init model and delete
                $model = $this->chatFactory->create();
                $model->load($id);
                $blacklist = $this->blacklistFactory->create();
                $blacklist->addChatToBlacklist($model->getData());
                // display success message
                $this->messageManager->addSuccessMessage(__('You add user to blacklist.'));
                // go to grid
                return $resultRedirect->setPath('*/*/');
            } catch (\Exception $e) {
                // display error message
                $this->messageManager->addErrorMessage($e->getMessage());
                // go back to edit form
                return $resultRedirect->setPath('*/*/edit', ['chat_id' => $id]);
            }
        }
        // display error message
        $this->messageManager->addErrorMessage(__('We can\'t find a Chat to add to black list.'));
        // go to grid
        return $resultRedirect->setPath('*/*/');
    }
}

