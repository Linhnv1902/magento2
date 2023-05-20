<?php
namespace Linhnv\ChatSystem\Model;

use Linhnv\ChatSystem\Api\Data\MessageInterface;
use Linhnv\ChatSystem\Api\Data\MessageInterfaceFactory;
use Magento\Framework\Api\DataObjectHelper;

/**
 * CMS block model
 *
 * @method \Magento\Cms\Model\ResourceModel\Block _getResource()
 * @method \Magento\Cms\Model\ResourceModel\Block getResource()
 */
class ChatMessage extends \Magento\Framework\Model\AbstractModel
{
    const STATUS_ENABLED = 1;
    const STATUS_DISABLED = 0;

    protected $messageDataFactory;

    protected $dataObjectHelper;

    protected $_eventPrefix = 'linhnv_chatsystem_message';

    /**
     * @param \Magento\Framework\Model\Context $context
     * @param \Magento\Framework\Registry $registry
     * @param MessageInterfaceFactory $messageDataFactory
     * @param DataObjectHelper $dataObjectHelper
     * @param \Linhnv\ChatSystem\Model\ResourceModel\ChatMessage $resource
     * @param \Linhnv\ChatSystem\Model\ResourceModel\ChatMessage\Collection $resourceCollection
     * @param array $data
     */
    public function __construct(
        \Magento\Framework\Model\Context $context,
        \Magento\Framework\Registry $registry,
        MessageInterfaceFactory $messageDataFactory,
        DataObjectHelper $dataObjectHelper,
        \Linhnv\ChatSystem\Model\ResourceModel\ChatMessage $resource,
        \Linhnv\ChatSystem\Model\ResourceModel\ChatMessage\Collection $resourceCollection,
        array $data = []
    ) {
        $this->messageDataFactory = $messageDataFactory;
        $this->dataObjectHelper = $dataObjectHelper;
        parent::__construct($context, $registry, $resource, $resourceCollection, $data);
    }

    public function getAvailableStatuses()
    {
        return [self::STATUS_ENABLED => __('Enabled'), self::STATUS_DISABLED => __('Disabled')];
    }

    /**
     * Retrieve message model with message data
     * @return MessageInterface
     */
    public function getDataModel()
    {
        $messageData = $this->getData();

        $messageDataObject = $this->messageDataFactory->create();
        $this->dataObjectHelper->populateWithArray(
            $messageDataObject,
            $messageData,
            MessageInterface::class
        );

        return $messageDataObject;
    }
}
