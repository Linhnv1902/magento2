<?php

namespace Linhnv\ChatSystem\Controller\Adminhtml\Blacklist;

use Magento\Backend\App\Action\Context;
use Magento\Framework\View\Result\PageFactory;

class Index extends \Linhnv\ChatSystem\Controller\Adminhtml\Blacklist
{
    /**
     * Index action
     *
     * @return \Magento\Backend\Model\View\Result\Page
     */
    public function execute()
    {
        $resultPage = $this->resultPageFactory->create();
        $resultPage->setActiveMenu('Linhnv_ChatSystem::chatsystem_chat');
        $resultPage->getConfig()->getTitle()->prepend(__('Blacklist'));
        return $resultPage;
    }
}
