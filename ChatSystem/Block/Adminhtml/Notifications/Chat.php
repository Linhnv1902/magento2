<?php

namespace Linhnv\ChatSystem\Block\Adminhtml\Notifications;

use Linhnv\ChatSystem\Model\Config;

class Chat extends \Magento\Framework\View\Element\Template
{


    /**
     * @var \Linhnv\ChatSystem\Model\ChatMessage
     */
    protected $message;

    /**
     * @param \Magento\Backend\Block\Template\Context $context
     */
    public function __construct(
        \Magento\Backend\Block\Template\Context $context,
        \Linhnv\ChatSystem\Model\ChatMessage $message
    ) {
        $this->message = $message;
        parent::__construct($context);
    }

    public function countUnread() {

        $message = $this->message->getCollection()->addFieldToFilter('user_id',array('null' => true))->addFieldToFilter('is_read',1);
        return count($message);
    }

}
