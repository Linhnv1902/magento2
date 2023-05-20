<?php

namespace Linhnv\ChatSystem\Controller\Adminhtml\Blacklist;

class NewAction extends \Linhnv\ChatSystem\Controller\Adminhtml\Blacklist
{
    /**
     * Create new chat blacklist
     *
     * @return \Magento\Framework\Controller\ResultInterface
     */
    public function execute()
    {
        /** @var \Magento\Framework\Controller\Result\Forward $resultForward */
        $resultForward = $this->resultForwardFactory->create();
        return $resultForward->forward('edit');
    }
}
