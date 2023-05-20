<?php
namespace Linhnv\ChatSystem\Controller\Adminhtml\Chat;

use Magento\Framework\Controller\ResultFactory;
use Magento\Backend\App\Action\Context;
use Magento\Ui\Component\MassAction\Filter;
use Linhnv\ChatSystem\Model\ResourceModel\Chat\CollectionFactory;

class MassDelete extends \Magento\Backend\App\Action
{
    /**
     * @var Filter
     */
    protected $filter;

    /**
     * @var CollectionFactory
     */
    protected $collectionFactory;

    protected $chatMessageFactory;

    /**
     * @param Context $context
     * @param Filter $filter
     * @param CollectionFactory $collectionFactory
     * @param \Linhnv\ChatSystem\Model\ChatMessageFactory $chatMessageFactory
     */
    public function __construct(
        Context $context,
        Filter $filter,
        CollectionFactory $collectionFactory,
        \Linhnv\ChatSystem\Model\ChatMessageFactory $chatMessageFactory
        )
    {
        $this->filter = $filter;
        $this->collectionFactory = $collectionFactory;
        $this->chatMessageFactory = $chatMessageFactory;
        parent::__construct($context);
    }

    /**
     * Execute action
     *
     * @return \Magento\Backend\Model\View\Result\Redirect
     * @throws \Magento\Framework\Exception\LocalizedException|\Exception
     */
    public function execute()
    {
        $collection = $this->filter->getCollection($this->collectionFactory->create());
        $collectionSize = $collection->getSize();
        $chat_ids = [];
        foreach ($collection as $chat) {
            $chat_ids[] = $chat->getId();
            $chat->delete();
        }

        $messageCollection = $this->chatMessageFactory->create()->getCollection();
        $messageCollection->addFieldToFilter("chat_id", ["in" => $chat_ids]);
        foreach ($messageCollection as $chatMessage) {
            $chatMessage->delete();
        }

        $this->messageManager->addSuccess(__('A total of %1 record(s) have been deleted.', $collectionSize));

        /** @var \Magento\Backend\Model\View\Result\Redirect $resultRedirect */
        $resultRedirect = $this->resultFactory->create(ResultFactory::TYPE_REDIRECT);
        return $resultRedirect->setPath('*/*/');
    }

    /**
     * {@inheritdoc}
     */
    protected function _isAllowed()
    {
        return $this->_authorization->isAllowed('Linhnv_ChatSystem::chat_delete');
    }
}
