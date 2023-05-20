<?php
namespace Linhnv\ChatSystem\Controller\Adminhtml\Chat;

class Delete extends \Magento\Backend\App\Action
{
    protected $chatFactory;
    protected $chatMessageFactory;
    /**
     * @param \Magento\Backend\App\Action\Context $context
     * @param \Linhnv\ChatSystem\Model\ChatFactory $chatFactory
     * @param \Linhnv\ChatSystem\Model\ChatMessageFactory $chatMessageFactory
     */
    public function __construct(
        \Magento\Backend\App\Action\Context $context,
        \Linhnv\ChatSystem\Model\ChatFactory $chatFactory,
        \Linhnv\ChatSystem\Model\ChatMessageFactory $chatMessageFactory
    )
    {
        $this->chatFactory = $chatFactory;
        $this->chatMessageFactory = $chatMessageFactory;
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
                $model->delete();

                $collection = $this->chatMessageFactory->create()->getCollection();
                $collection->addFieldToFilter("chat_id", $id);
                foreach ($collection as $chatMessage) {
                    $chatMessage->delete();
                }

                // display success message
                $this->messageManager->addSuccessMessage(__('You deleted the Chat.'));
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
        $this->messageManager->addErrorMessage(__('We can\'t find a Chat to delete.'));
        // go to grid
        return $resultRedirect->setPath('*/*/');
    }
}

